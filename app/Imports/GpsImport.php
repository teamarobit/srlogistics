<?php

namespace App\Imports;

use App\Models\Vehiclegps;
use App\Models\Vehiclegpslog;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class GpsImport implements ToModel, WithHeadingRow
{
    protected $vehicleId;
    
    public function __construct($vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }
    
    public function model(array $row)
    {
        return new Vehiclegps([
            //
        ]);
    }
}
