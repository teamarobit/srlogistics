<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use OpenSpout\Reader\XLSX\Reader;

use App\Models\Scheduleupload;
use App\Models\Uploadlog;

class ProcessImportJob implements ShouldQueue
{
    use Queueable;
    
    public $uploadId;

    public function __construct($uploadId) {
        $this->uploadId = $uploadId;
    }

    public function handle()
    {
        $upload = Scheduleupload::findOrFail($this->uploadId);

        $reader = new Reader();
        $reader->open(storage_path("app/{$upload->file_path}"));

        $total = $success = $failed = 0;
        $batch = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $index => $row) {

                if ($index === 1) continue; // skip header

                $total++;
                $data = $row->toArray();

                try {
                    $validated = $this->validateRow($data);

                    $batch[] = $validated;
                    $success++;

                } catch (\Throwable $e) {

                    Uploadlog::create([
                        'scheduleupload_id' => $upload->id,
                        'row_number' => $index,
                        'row_data' => json_encode($data),
                        'error_message' => $e->getMessage(),
                    ]);

                    $failed++;
                }

                // Bulk insert every 500 rows
                if (count($batch) === 500) {
                    // DB::table('vehicles')->insert($batch);
                    $batch = [];
                }

                // Update progress every 100 rows
                if ($total % 100 === 0) {
                    $upload->update([
                        'processed_rows' => $total,
                        'success_rows' => $success,
                        'failed_rows' => $failed,
                    ]);
                }
            }
        }

        // Insert remaining
        if (!empty($batch)) {
            // DB::table('vehicles')->insert($batch);
        }

        $reader->close();

        $upload->update([
            'status' => 'Completed',
            'processed_rows' => $total,
            'success_rows' => $success,
            'failed_rows' => $failed,
            'completed_at' => now(),
        ]);

    }
    
    private function validateRow(array $data)
    {
        $validator = Validator::make([
            'vehicle_no' => $data[0],
            'owner_name' => $data[1],
        ], [
            'vehicle_no' => 'required|unique:vehicles,vehicle_no',
            'owner_name' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            throw new \Exception(implode(', ', $validator->errors()->all()));
        }
    
        return $validator->validated();
    }
}
