<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\Models\Scheduleupload;
use App\Models\Uploadlog;

use App\Models\Vehiclegps;
use App\Models\Vehiclegpslog;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GpsImport;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Closure;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use App\Traits\Useractivity;
    

class ImportController extends Controller
{
    use Useractivity;
    
    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|mimes:xls,xlsx,csv|max:2048',
            'import_type' => 'required|in:gps,fastag,battery,tyre'
        ], [
                'required' => 'This field is required.',
            ]
        );
        
        $errorcount = 0;
        $errors = [];
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try {
            
            $uploadFile = null;
            $filename = null;
            $originalName = null;
            $size = null;
            $mimeType = null;
            $fileType = null;
    
            DB::transaction(function () use ($request, &$uploadFile) {
                
                $filename = null;
                if ($request->hasFile('import_file')) {
                    
                    $file = $request->file('import_file');
                    
                    
                    
                    // File metadata
                    $originalName = $file->getClientOriginalName();
                    
                    $size = round($file->getSize() / 1024, 2); // KB
                    //$size = $file->getSize(); 
                    
                    $mimeType = $file->getMimeType();
                    $fileType = $file->getClientOriginalExtension();
                    
                    $extension    = $file->getClientOriginalExtension();
            
                    // Upload path
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'scheduleupload');
                
                    // Create folder if not exists
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                
                    $filename = 'scheduleupload_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                    // Move file
                    $file->move($uploadPath, $filename);
                }
                
                
                // Batch no
                $lastData = Scheduleupload::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastData){
                    $lastbatchno = $lastData->batch_no;
                    $incr_lastbatch = $lastbatchno+1;
                    if(strlen($incr_lastbatch)<5){
                        $batchno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastbatch)); $i++){
                            $batchno .= '0';
                        }
                        $batchno .= $incr_lastbatch;
                    } else {
                        $batchno = $incr_lastbatch;
                    }
                    
                } else {
                    $batchno = '000001';
                }
                
                
                $uploadFile = new Scheduleupload();
                $uploadFile->batch_no    = $batchno;
                $uploadFile->module_name = $request->import_type ?? null;
                $uploadFile->file_name  = $filename;
                $uploadFile->file_original_name = $originalName;
                $uploadFile->file_size = $size;
                $uploadFile->mime_type = $fileType;
                $uploadFile->status    = 'Pending';
                
                $uploadFile->created_by = Auth::user()->id;
                $uploadFile->save();
                
               
                // Log user activity
                //$this->storeUseractivity(21, 3, Auth::user()->id, $branch->id, 'Added new branch.');
            });
    
            $success = true;
            $respmessage = 'File uploaded successfully.';
            
            
    
        } catch (\Exception $e) {
            \Log::error('Import failed', ['error' => $e->getMessage()]);
    
            return response()->json([
                'success' => false,
                'message' => 'Import failed: '.$e->getMessage()
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => $respmessage,
            'data' => $uploadFile
        ]);

    }
    
    
    
    
    
    
    
    
    
}