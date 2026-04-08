<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Loanaccount;
use App\Models\Loanaccountlog;
use App\Models\Loanaccountcrongivenemi;


class GenerateEmiEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emi:generate';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate EMI entries daily';
    
    

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        $day = now()->day;
    
        $loans = Loanaccount::where('status', '!=', 'Closed')
                            ->where('emi_date_every_month', $day)
                            ->whereDate('emi_start_date', '<=', $today)
                            ->whereDate('emi_end_date', '>=', $today)
                            ->get();
    
        foreach ($loans as $loan) {
    
            $exists = Loanaccountcrongivenemi::where('loanaccount_id', $loan->id)
                                            ->whereDate('emi_date', $today)
                                            ->exists();
    
            if ($exists) continue;
            
            $givenEmiLog = new Loanaccountcrongivenemi(); 
            $givenEmiLog->loanaccount_id = $loan->id;
            $givenEmiLog->vehicle_id = $loan->vehicle_id;
            $givenEmiLog->emi_date = $today;
            $givenEmiLog->emi_amount = $loan->emi_amount;
            $givenEmiLog->status = 'Paid';
            $givenEmiLog->save();
            
            
            // Paid months update
            $loan->paid_upto_months = ($loan->paid_upto_months ?? 0) + 1;
            // Status update
            if ($loan->paid_upto_months >= $loan->total_months) {
                $loan->status = 'Closed';
            } else {
                $loan->status = 'Partially Paid';
            }
    
            $loan->save();
            
        }
        
        $this->info("Auto EMI Paid & Updated Successfully.");
        
    }
    
    
}
