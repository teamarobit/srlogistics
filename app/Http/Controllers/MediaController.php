<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Tyre;
use App\Models\Tyrelog;

class MediaController extends Controller
{
    /**
     * Serve a tyre-related attachment (image or invoice) via an auth-gated route.
     * Reads the file from public_path('medias/' . file_path) where file_path is
     * stored as 'tyre/<filename>' on the Media row.
     *
     * NOTE (BUG-002 partial fix, 2026-05-28):
     *   Files remain under public/medias/tyre/ and are still statically served
     *   by Nginx at the legacy URL /medias/tyre/<filename>. Going forward all
     *   blade views must link via route('tyre.media.serve', $media->id) so new
     *   links go through this gate. A deployment-side deny rule (Nginx location
     *   block) is required to close the legacy URL completely. Tracked in
     *   docs/HumanAttention/2026-05-28-media-public-exposure.md.
     *
     * Restricts mediable_type to Tyre / Tyrelog so the endpoint cannot be
     * abused to expose other modules' files.
     */
    public function serveTyre($id)
    {
        $media = Media::find($id);
        if (! $media) {
            abort(404);
        }

        if (! in_array($media->mediable_type, [Tyre::class, Tyrelog::class])) {
            abort(404);
        }

        $fullPath = public_path('medias' . DIRECTORY_SEPARATOR . $media->file_path);
        if (! is_file($fullPath)) {
            abort(404);
        }

        return response()->file($fullPath);
    }
}
