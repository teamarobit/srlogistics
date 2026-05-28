<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FleetVehicleExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        protected ?string $v_driver = null,
        protected ?string $v_managed_by = null,
        protected ?string $v_vehicle_no = null,
        protected ?string $status = null,
        protected ?string $v_vehiclegroup_id = null,
        protected ?string $v_ownership = null,
    ) {}

    public function query()
    {
        $query = Vehicle::with([
            'group',
            'groupTracking',
            'driverAllocation.contact',
        ]);

        if ($this->v_vehiclegroup_id) {
            $query->where('vehiclegroup_id', $this->v_vehiclegroup_id);
        }
        if ($this->v_ownership) {
            $query->where('ownership_type', $this->v_ownership);
        }
        if ($this->v_driver) {
            $query->whereHas('driverAllocation.contact', fn($q) =>
                $q->where('contact_name', 'like', '%' . $this->v_driver . '%')
            );
        }
        if ($this->v_managed_by) {
            $query->whereHas('groupTracking', fn($q) =>
                $q->where('managed_by_employee', 'like', '%' . $this->v_managed_by . '%')
            );
        }
        if ($this->v_vehicle_no) {
            $query->where('vehicle_no', 'like', '%' . $this->v_vehicle_no . '%');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            '#',
            'Vehicle No',
            'Driver Name',
            'Driver Phone',
            'Vehicle Group',
            'Managed By',
        ];
    }

    public function map($vehicle): array
    {
        static $i = 0;
        $i++;
        return [
            $i,
            $vehicle->vehicle_no ?? '',
            $vehicle->driverAllocation->contact->contact_name ?? '—',
            $vehicle->driverAllocation->contact->phone ?? '—',
            $vehicle->group->name ?? '—',
            $vehicle->groupTracking->managed_by_employee ?? '—',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
