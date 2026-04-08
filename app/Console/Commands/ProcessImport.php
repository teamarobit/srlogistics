<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Scheduleupload;

class ProcessImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imports:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $upload = Scheduleupload::where('status', 'Pending')
            ->orderBy('id')
            ->first();

        if (!$upload) return;

        // Prevent race condition
        $updated = Scheduleupload::where('id', $upload->id)
            ->where('status', 'Pending')
            ->update([
                'status' => 'Processing',
                'started_at' => now()
            ]);

        if (!$updated) return;

        ProcessImportJob::dispatch($upload->id);
    }
}
