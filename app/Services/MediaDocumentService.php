<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Attachmenttype;
use App\Models\Mediadocument;

use App\Traits\Useractivity;

use Auth;

class MediaDocumentService
{
    use Useractivity;
    
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    public function storeDocument($model, array $data)
    {
        /**
         * $model => Vehicle / Tyre / etc (Eloquent model)
         * $data => validated request data
         */

        return DB::transaction(function () use ($model, $data) {
            $attachmenttype = Attachmenttype::firstOrCreate([
                                                    'name' => $data['attachment_type']
                                                ]);
            
            $document = Mediadocument::create([
                'attachmenttype_id'  => $attachmenttype->id,
                'document_number'    => $data['document_number'] ?? NULL,
                'issue_date'         => $data['issue_date'] ? date('Y-m-d', strtotime($data['issue_date'])) : NULL,
                'expiry_date'        => $data['expiry_date'] ? date('Y-m-d', strtotime($data['expiry_date'])) :  NULL,
                'set_reminder'       => isset($data['set_reminder']) ? 'Yes' : 'No',
                'reminder_days'      => $data['reminder_days'] ?? NULL,
                'notes'              => $data['notes'] ?? NULL,
            ]);

            $modelName = strtolower(class_basename($model)); // vehicle / tyre
            $folder = public_path("medias/{$modelName}/documents");

            // $mediaData = [];
            $this->storeUseractivity(70, 3, Auth::id(), $document->id, 'Added document.');

            foreach ($data['files'] as $file) {

                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                $file_mimetype = $file->getMimeType();
                $file_size = $file->getSize();
                $original_name = $file->getClientOriginalName();

                $file->move($folder, $fileName);

                $mediaData = [
                    'file_name'         => $original_name,
                    'file_path'         => "{$modelName}/documents/" . $fileName,
                    'file_type'         => $file_mimetype,
                    'file_size'         => $file_size,
                    'type'              => 'Document',
                    'mediadocument_id'  => $document->id,
                    'created_by'        => Auth::id(),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
                $media = $model->medias()->create($mediaData);
                $this->storeUseractivity(71, 3, Auth::id(), $media->id, 'Added media.');
            }

            // $model->medias()->createMany($mediaData);
            

            return $document->load('medias');
        });
    }
    
    public function updateDocument($model, $mediaDocument, array $data)
    {
        /**
         * $model => Vehicle / Tyre / etc (Eloquent model)
         * $mediaDocument => Mediadocument model instance
         * $data => validated request data
         */

        return DB::transaction(function () use ($model, $data, $mediaDocument) {
            $attachmenttype = Attachmenttype::firstOrCreate([
                                                    'name' => $data['attachment_type']
                                                ]);
            
            $mediaDocument->update([
                'attachmenttype_id'  => $attachmenttype->id,
                'document_number'    => $data['document_number'] ?? NULL,
                'issue_date'         => $data['issue_date'] ? date('Y-m-d', strtotime($data['issue_date'])) : NULL,
                'expiry_date'        => $data['expiry_date'] ? date('Y-m-d', strtotime($data['expiry_date'])) :  NULL,
                'set_reminder'       => isset($data['set_reminder']) ? 'Yes' : 'No',
                'reminder_days'      => $data['reminder_days'] ?? NULL,
                'notes'              => $data['notes'] ?? NULL,
            ]);
            
            $this->storeUseractivity(70, 4, Auth::id(), $mediaDocument->id, 'Updated document.');

            if(isset($data['files']) && !empty($data['files'])){
                $modelName = strtolower(class_basename($model)); // vehicle / tyre
                $folder = public_path("medias/{$modelName}/documents");
    
                // $mediaData = [];
                foreach ($data['files'] as $file) {
    
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    
                    $file_mimetype = $file->getMimeType();
                    $file_size = $file->getSize();
                    $original_name = $file->getClientOriginalName();
    
                    $file->move($folder, $fileName);
    
                    // $mediaData[] = [
                    $mediaData = [
                        'file_name'         => $original_name,
                        'file_path'         => "{$modelName}/documents/" . $fileName,
                        'file_type'         => $file_mimetype,
                        'file_size'         => $file_size,
                        'type'              => 'Document',
                        'mediadocument_id'  => $mediaDocument->id,
                        'created_by'        => Auth::id(),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                    
                    $media = $model->medias()->create($mediaData);
                    $this->storeUseractivity(71, 4, Auth::id(), $media->id, 'Added media.');
                }
    
                // $model->medias()->createMany($mediaData);
            }

            return $mediaDocument->load('medias');
        });
    }
}
