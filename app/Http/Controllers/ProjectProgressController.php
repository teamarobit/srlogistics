<?php

namespace App\Http\Controllers;

use App\Http\Requests\PpUploadRequest;
use App\Models\PpModule;
use App\Models\PpModuleFile;
use App\Models\PpPhase;
use App\Models\PpSignoffEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * ProjectProgressController
 *
 * Dynamic, DB-backed client sign-off board at /project-progress.
 * Phases/modules come from pp_phases / pp_modules; per-module status,
 * client approval, freeze lock, notes and file uploads persist. Every state
 * change writes an audit row to pp_signoff_events (who / when).
 *
 * Design status weights used for the timeline / aggregate %.
 */
class ProjectProgressController extends Controller
{
    private const WEIGHTS = ['Not Started' => 0, 'In Design' => 34, 'Design Done' => 67, 'Approved' => 100];

    /** Where sign-off uploads are stored (local disk, outside public root). */
    private const UPLOAD_DIR = 'project-progress';

    public function index(): View
    {
        $phases = PpPhase::with(['modules' => function ($q) {
                $q->orderBy('sort_order')->with('files');
            }])
            ->orderBy('sort_order')
            ->get();

        // Aggregate project % — weighted across every module in every phase.
        $allModules = $phases->flatMap->modules;
        $moduleCount = $allModules->count();
        $overall = $moduleCount
            ? (int) round($allModules->sum(fn ($m) => self::WEIGHTS[$m->status] ?? 0) / $moduleCount)
            : 0;

        return view('projectprogress.index', compact('phases', 'overall'));
    }

    // ─── Client approval (toggle) ────────────────────────────────────────────

    public function toggleApproval(Request $request, $id): JsonResponse
    {
        $module = PpModule::find($id);
        if (! $module) {
            return response()->json(['success' => false, 'message' => 'Module not found.'], 422);
        }
        if ($module->is_frozen) {
            return response()->json(['success' => false, 'message' => 'Module is frozen and cannot be changed.'], 422);
        }

        $approve = $request->boolean('approved');

        // Rule: approval is only valid once design is ready for review.
        if ($approve && ! in_array($module->status, ['Design Done', 'Approved'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Module must be "Design Done" before client approval.',
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($module, $approve) {
                $module->client_approved = $approve;
                $module->approved_at     = $approve ? now() : null;
                $module->approved_by     = $approve ? Auth::id() : null;
                // Approving sets status to Approved; removing approval steps it back.
                $module->status          = $approve ? 'Approved' : 'Design Done';
                $module->updated_by      = Auth::id();
                $module->save();

                $this->logEvent($approve ? 'Client Approved' : 'Approval Removed', $module);

                return $module;
            });

            return response()->json([
                'success'         => true,
                'message'         => $approve ? 'Client approval recorded.' : 'Client approval removed.',
                'client_approved' => $result->client_approved,
                'status'          => $result->status,
                'progress'        => $this->phaseProgress($result->pp_phase_id),
                'overall'         => $this->overallProgress(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Freeze module (one-way) ─────────────────────────────────────────────

    public function freezeModule(Request $request, $id): JsonResponse
    {
        $module = PpModule::find($id);
        if (! $module) {
            return response()->json(['success' => false, 'message' => 'Module not found.'], 422);
        }
        if ($module->is_frozen) {
            return response()->json(['success' => false, 'message' => 'Module is already frozen.'], 422);
        }
        // Rule: freeze only after client approval.
        if (! $module->client_approved) {
            return response()->json([
                'success' => false,
                'message' => 'Module must be client-approved before it can be frozen.',
            ], 422);
        }

        try {
            DB::transaction(function () use ($module) {
                $module->is_frozen  = true;
                $module->frozen_at  = now();
                $module->frozen_by  = Auth::id();
                $module->updated_by = Auth::id();
                $module->save();

                $this->logEvent('Module Frozen', $module);

                return $module;
            });

            return response()->json(['success' => true, 'message' => 'Module frozen.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Freeze phase (one-way, cascades to all modules) ─────────────────────

    public function freezePhase(Request $request, $id): JsonResponse
    {
        $phase = PpPhase::with('modules')->find($id);
        if (! $phase) {
            return response()->json(['success' => false, 'message' => 'Phase not found.'], 422);
        }
        if ($phase->is_frozen) {
            return response()->json(['success' => false, 'message' => 'Phase is already frozen.'], 422);
        }

        // Rule: every module must be client-approved before the phase can freeze.
        $pending = $phase->modules->where('client_approved', false)->count();
        if ($pending > 0) {
            return response()->json([
                'success' => false,
                'message' => "All modules must be client-approved first ({$pending} pending).",
            ], 422);
        }

        try {
            DB::transaction(function () use ($phase) {
                $now = now();
                $uid = Auth::id();

                foreach ($phase->modules as $module) {
                    if (! $module->is_frozen) {
                        $module->is_frozen  = true;
                        $module->frozen_at  = $now;
                        $module->frozen_by  = $uid;
                        $module->updated_by = $uid;
                        $module->save();
                        $this->logEvent('Module Frozen', $module);
                    }
                }

                $phase->is_frozen  = true;
                $phase->frozen_at  = $now;
                $phase->frozen_by  = $uid;
                $phase->updated_by = $uid;
                $phase->save();

                $this->logEvent('Phase Frozen', null, ['phase_no' => $phase->phase_no], $phase->id);

                return $phase;
            });

            return response()->json(['success' => true, 'message' => 'Phase frozen.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── File upload (multiple allowed) ──────────────────────────────────────

    public function uploadFile(PpUploadRequest $request, $id): JsonResponse
    {
        $module = PpModule::find($id);
        if (! $module) {
            return response()->json(['success' => false, 'message' => 'Module not found.'], 422);
        }
        if ($module->is_frozen) {
            return response()->json(['success' => false, 'message' => 'Module is frozen; uploads are locked.'], 422);
        }

        try {
            $upload   = $request->file('file');
            $original = $upload->getClientOriginalName();
            $stored   = Str::uuid() . '.' . $upload->getClientOriginalExtension();
            $dir      = self::UPLOAD_DIR . '/' . $module->id;

            $result = DB::transaction(function () use ($module, $upload, $original, $stored, $dir) {
                $path = $upload->storeAs($dir, $stored, 'local');

                $file = PpModuleFile::create([
                    'pp_module_id'  => $module->id,
                    'original_name' => $original,
                    'stored_path'   => $path,
                    'mime_type'     => $upload->getClientMimeType(),
                    'size_bytes'    => $upload->getSize(),
                    'uploaded_by'   => Auth::id(),
                ]);

                $this->logEvent('File Uploaded', $module, ['file_id' => $file->id, 'name' => $original]);

                return $file;
            });

            return response()->json([
                'success' => true,
                'message' => 'File uploaded.',
                'file'    => [
                    'id'   => $result->id,
                    'name' => $result->original_name,
                    'size' => $result->size_bytes,
                    'url'  => route('projectprogress.file.download', $result->id),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Remove a file ───────────────────────────────────────────────────────

    public function removeFile(Request $request, $fileId): JsonResponse
    {
        $file = PpModuleFile::with('module')->find($fileId);
        if (! $file) {
            return response()->json(['success' => false, 'message' => 'File not found.'], 422);
        }
        if ($file->module && $file->module->is_frozen) {
            return response()->json(['success' => false, 'message' => 'Module is frozen; files are locked.'], 422);
        }

        try {
            DB::transaction(function () use ($file) {
                if ($file->stored_path && Storage::disk('local')->exists($file->stored_path)) {
                    Storage::disk('local')->delete($file->stored_path);
                }

                $this->logEvent('File Removed', $file->module, ['file_id' => $file->id, 'name' => $file->original_name]);

                $file->delete();

                return $file;
            });

            return response()->json(['success' => true, 'message' => 'File removed.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Download a file (auth-checked via route group) ──────────────────────

    public function downloadFile($fileId): StreamedResponse
    {
        $file = PpModuleFile::findOrFail($fileId); // non-AJAX GET → findOrFail is correct (SD-8)

        abort_unless(Storage::disk('local')->exists($file->stored_path), 404);

        return Storage::disk('local')->download($file->stored_path, $file->original_name);
    }

    // ─── Internal helpers ────────────────────────────────────────────────────

    private function logEvent(string $type, ?PpModule $module, array $meta = [], $phaseId = null): void
    {
        PpSignoffEvent::create([
            'pp_phase_id'  => $phaseId ?? $module?->pp_phase_id,
            'pp_module_id' => $module?->id,
            'event_type'   => $type,
            'performed_by' => Auth::id(),
            'meta'         => $meta ?: null,
        ]);
    }

    private function phaseProgress($phaseId): int
    {
        $phase = PpPhase::with('modules')->find($phaseId);
        return $phase ? $phase->progress() : 0;
    }

    private function overallProgress(): int
    {
        $modules = PpModule::all();
        $count   = $modules->count();
        return $count
            ? (int) round($modules->sum(fn ($m) => self::WEIGHTS[$m->status] ?? 0) / $count)
            : 0;
    }
}
