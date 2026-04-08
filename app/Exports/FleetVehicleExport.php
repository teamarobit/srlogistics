<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FleetVehicleExport implements FromCollection, WithHeadings
{
    protected $driver;
    protected $manager;
    protected $vehicle_no;
    protected $status;
    protected $vehiclegroup_id;
    protected $ownership;

    public function __construct(
        $driver = null,
        $manager = null,
        $vehicle_no = null,
        $status = null,
        $vehiclegroup_id = null,
        $ownership = null
    ){
        $this->driver = $driver;
        $this->manager = $manager;
        $this->vehicle_no = $vehicle_no;
        $this->status = $status;
        $this->vehiclegroup_id = $vehiclegroup_id;
        $this->ownership = $ownership;
    }

    public function collection(): Collection
    {
        $query = Vehicle::with([
            'group',
            'groupTracking',
            'driverAllocation.contact',
            'customerAllocation.contact'
        ]);

        if($this->vehiclegroup_id){
            $query->where('vehiclegroup_id',$this->vehiclegroup_id);
        }

        if($this->ownership){
            $query->where('ownership_type',$this->ownership);
        }

        if($this->vehicle_no){
            $query->where('vehicle_no','like','%'.$this->vehicle_no.'%');
        }

        $vehicles = $query->get();
        
        
        return $vehicles->map(function ($vehicle){

            $driverName  = optional(optional($vehicle->driverAllocation)->contact)->contact_name ?? '-';
            $driverPhone = optional(optional($vehicle->driverAllocation)->contact)->phone ?? '-';
        
            return [
        
                'Vehicle Number' => $vehicle->vehicle_no ?? '-',
                'Driver Name' => $driverName,
                'Driver Phone' => $driverPhone,
                'Vehicle Group' => $vehicle->group->name ?? '-',
                'Vehicle Status' => '-',
                'Last Location' => '-',
                'Managed By' => optional($vehicle->groupTracking)->managed_by_employee ?? '-',
        
            ];
        
        });


    }

    public function headings(): array
    {
        return [
            'Vehicle Number',
            'Driver Name',
            'Driver Phone',
            'Vehicle Group',
            'Vehicle Status',
            'Last Location',
            'Managed By'
        ];
    }
}