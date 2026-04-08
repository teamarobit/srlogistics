<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Scheduleupload;
use App\Models\Uploadlog;

use App\Models\Vehicle;
use App\Models\Vehiclegps;
use App\Models\Vehiclegpslog;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;



class ProcessScheduleUpload implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Empty (scheduler based)
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        \Log::info('JOB STARTED');
        
        // Pick ONE pending record
        $upload = Scheduleupload::where('status', 'Pending')->first();

        if (!$upload) {
            \Log::info('No pending upload found');
            return;
        }
        
        \Log::info('Processing upload', ['id' => $upload->id]);

        try {
            // Set Ongoing
            $upload->status = 'Ongoing';
            $upload->save();
            
             
            \Log::info('Upload picked', ['upload_id' => $upload->id, 'file' => $upload->file_name]);

            $filePath = public_path('media/scheduleupload/' . $upload->file_name);

            if (!file_exists($filePath)) {
                \Log::error('File not found', ['path' => $filePath]);
                throw new \Exception("File not found: " . $upload->file_name);
            }

            
            // Read Excel
            $rows = Excel::toArray([], $filePath);
        
            \Log::info('Excel loaded', ['total_sheets' => count($rows)]);
        
            if (empty($rows) || empty($rows[0])) {
                Log::error('Excel empty');
                throw new \Exception("Excel file is empty");
            }
        
            \Log::info('Total rows in sheet', ['count' => count($rows[0])]);

            DB::transaction(function () use ($rows, $upload) {

                foreach ($rows[0] as $key => $row) {
                    
                    \Log::info('Row processing', ['row_index' => $key, 'data' => $row]);

                    // Skip header
                    if ($key == 0) {
                        \Log::info('Skipping header row');
                        continue;
                    }

                    // Skip empty rows
                    //if (empty($row[0])) continue;
                    
                    if (empty($row[0])) {
                        \Log::warning('Empty vehicle_no, skipped', ['row' => $row]);
                        continue;
                    }
                    
                    
                    $vehicle_no = trim($row[0]);
                    
                    \Log::info('Searching vehicle', ['vehicle_no' => $vehicle_no]);
                    
                    $vehicleData = Vehicle::where('vehicle_no', $vehicle_no)->first();
                    if($vehicleData){
                        $vehicle_id = $vehicleData->id;
                        
                        \Log::info('Vehicle found', ['vehicle_id' => $vehicle_id]);
                        
                        $exists = Vehiclegps::where('vehicle_id', $vehicle_id)->where('gps_provider', $row[1] ?? null)->exists();
                        if (!$exists) {
                            
                            \Log::info('Inserting GPS data');
                            
                            $gpsData = new Vehiclegps();
                            $gpsData->vehicle_id = $vehicle_id;
                            $gpsData->parent_id = null;
                            $gpsData->gps_provider = $row[1] ?? null;
                            $gpsData->gps_cost = $row[2] ?? 0;
                            $gpsData->gps_plan_validity = $row[3] ?? null;
                            $gpsData->purchase_date = date('Y-m-d');
                            $gpsData->created_by = 6;
                            $gpsData->save();
                            
                            // LOG TABLE
                            // $gpsLog = new Vehiclegpslog();
                            // $gpsLog->vehiclegps_id = $gpsData->id;
                            // $gpsLog->vehicle_id = $vehicle_id;
                            // $gpsLog->parent_id = null;
                            // $gpsLog->gps_provider = $row[1] ?? null;
                            // $gpsLog->gps_cost = $row[2] ?? 0;
                            // $gpsLog->gps_plan_validity = $row[3] ?? null;
                            // $gpsLog->purchase_date = date('Y-m-d');
                            // $gpsLog->created_by = 6;
                            // $gpsLog->save();
                            
                            \Log::info('Inserted successfully');
                            
                            
                            // UPLOAD LOG TABLE
                            $uploadLog = new Uploadlog();
                            $uploadLog->scheduleupload_id = $upload->id;
                            $uploadLog->note = 'Row ' . ($key + 1) . ' processed';
                            $uploadLog->type = 'Success';
                            $uploadLog->save();
                            
                        }else{
                            \Log::warning('Duplicate skipped', ['vehicle_no' => $vehicle_no]);
                            
                            $uploadLog = new Uploadlog();
                            $uploadLog->scheduleupload_id = $upload->id;
                            $uploadLog->note = 'Duplicate entry skipped for vehicle_id: ' . $row[0];
                            $uploadLog->type = 'Error';
                            $uploadLog->save();
                        }
                        
                    }else{
                        \Log::error('Vehicle not found', ['vehicle_no' => $vehicle_no]);
                        
                        // VEHICLE NOT FOUND
                        $uploadLog = new Uploadlog();
                        $uploadLog->scheduleupload_id = $upload->id;
                        $uploadLog->note = 'Vehicle not found for vehicle_no: ' . $row[0];
                        $uploadLog->type = 'Error';
                        $uploadLog->save();
                    }
                    
                }
            });

            // Mark completed
            //$upload->update(['status' => 'Completed']);
            $upload->status = 'Completed';
            $upload->save();

            \Log::info('Schedule upload processed', [
                'upload_id' => $upload->id
            ]);

        } catch (\Exception $e) {

            Log::error('Schedule upload failed', [
                'upload_id' => $upload->id,
                'error' => $e->getMessage()
            ]);

            // Reset to Pending (retry later)
            //$upload->update(['status' => 'Pending']);
            
            $upload->status = 'Pending';
            $upload->save();
            
        }
    }
}
