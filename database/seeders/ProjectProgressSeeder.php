<?php

namespace Database\Seeders;

use App\Models\PpModule;
use App\Models\PpPhase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds the 11 Project Progress phases and their modules from the original
 * static definition. Idempotent: re-running updates existing rows (matched by
 * phase_no / module_key) without duplicating. Statuses use Title Case ENUM
 * values (RULE 10). module_key is a stable slug used as the persistence key.
 */
class ProjectProgressSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->phases() as $pIndex => $phaseDef) {
            $phase = PpPhase::withTrashed()->updateOrCreate(
                ['phase_no' => $phaseDef['no']],
                [
                    'title'      => $phaseDef['title'],
                    'color'      => $phaseDef['color'],
                    'sort_order' => $pIndex + 1,
                    'status'     => 'Active',
                    'deleted_at' => null,
                ]
            );

            foreach ($phaseDef['modules'] as $mIndex => $module) {
                PpModule::withTrashed()->updateOrCreate(
                    [
                        'pp_phase_id' => $phase->id,
                        'module_key'  => Str::slug($module['name']),
                    ],
                    [
                        'group_name' => $module['group'] ?? null,
                        'name'       => $module['name'],
                        'sort_order' => $mIndex + 1,
                        'status'     => $module['status'],
                        'deleted_at' => null,
                    ]
                );
            }
        }
    }

    /**
     * Original phase/module definition. Statuses are the current placeholder
     * design states, mapped to Title Case ENUM values.
     */
    private function phases(): array
    {
        return [
            [
                'no' => 1, 'title' => 'Initial Setup (One Time)', 'color' => '#1B3A6B',
                'modules' => [
                    ['group' => 'Setup Masters', 'name' => 'Hisab Category', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Department', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Designation', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Job Rank', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Vehicle Management - Vehicle Type', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Vehicle Management - Vehicle Group', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Vehicle Management - Vehicle Status', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Vehicle Management - Vehicle Group Tracking Master', 'status' => 'In Design'],
                    ['group' => 'Setup Masters', 'name' => 'Vehicle Management - Ownership Type', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Location - Route', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Location - Branch', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Location - Location Point', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Master - Warehouse', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Workshop', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Skillset', 'status' => 'In Design'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Spare Part', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Spare Part Categories', 'status' => 'In Design'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Services', 'status' => 'In Design'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Service Keypoints', 'status' => 'Not Started'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Maintenance Items', 'status' => 'Not Started'],
                    ['group' => 'Setup Masters', 'name' => 'Workshop Master - Fault / Complaint Codes', 'status' => 'Not Started'],
                    ['group' => 'Setup Masters', 'name' => 'Finance Master - Expense Type Master', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Finance Master - Asset Master', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Miscellaneous Master - Toll Station', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Miscellaneous Master - RTO / Border Checkpoints', 'status' => 'Design Done'],
                    ['group' => 'Setup Masters', 'name' => 'Provider Master - GPS Provider', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Provider Master - Fastag Provider', 'status' => 'Approved'],
                    ['group' => 'Setup Masters', 'name' => 'Provider Master - Digital Lock Provider', 'status' => 'Design Done'],
                    ['group' => 'Create Contacts', 'name' => 'Customer', 'status' => 'Approved'],
                    ['group' => 'Create Contacts', 'name' => 'Load Vendor (Broker)', 'status' => 'Design Done'],
                    ['group' => 'Create Contacts', 'name' => 'Employees', 'status' => 'Design Done'],
                    ['group' => 'Create Contacts', 'name' => 'Drivers', 'status' => 'Approved'],
                    ['group' => 'Create Contacts', 'name' => 'Vehicle Vendors', 'status' => 'Design Done'],
                    ['group' => 'Create Contacts', 'name' => 'Tyre Vendors', 'status' => 'Design Done'],
                    ['group' => 'Create Contacts', 'name' => 'Battery Vendors', 'status' => 'In Design'],
                    ['group' => 'Create Contacts', 'name' => 'Insurance Providers', 'status' => 'Design Done'],
                ],
            ],
            [
                'no' => 2, 'title' => 'Fleet Onboarding', 'color' => '#1F9D55',
                'modules' => [
                    ['name' => 'Purchase Vehicle', 'status' => 'Approved'],
                    ['name' => 'Create Vehicle', 'status' => 'Design Done'],
                    ['name' => 'Upload Documents', 'status' => 'Design Done'],
                    ['name' => 'Assign Tyres', 'status' => 'Design Done'],
                    ['name' => 'Assign Batteries', 'status' => 'In Design'],
                    ['name' => 'Activate GPS', 'status' => 'In Design'],
                    ['name' => 'Purchase Insurance', 'status' => 'Design Done'],
                    ['name' => 'Permit & Fitness Compliance', 'status' => 'In Design'],
                    ['name' => 'Vehicle Ready', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 3, 'title' => 'Customer Booking', 'color' => '#8E44AD',
                'modules' => [
                    ['name' => 'Customer Inquiry', 'status' => 'Design Done'],
                    ['name' => 'Contract Verification', 'status' => 'In Design'],
                    ['name' => 'Create Trip', 'status' => 'Design Done'],
                ],
            ],
            [
                'no' => 4, 'title' => 'Trip Planning', 'color' => '#2563EB',
                'modules' => [
                    ['name' => 'Assign Vehicle', 'status' => 'Design Done'],
                    ['name' => 'Assign Driver', 'status' => 'Design Done'],
                    ['name' => 'Assign Route', 'status' => 'In Design'],
                    ['name' => 'Generate LR', 'status' => 'In Design'],
                    ['name' => 'Generate E-Way Bill', 'status' => 'Not Started'],
                    ['name' => 'Trip Ready', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 5, 'title' => 'Trip Execution', 'color' => '#E67E22',
                'modules' => [
                    ['name' => 'Trip Initiation', 'status' => 'In Design'],
                    ['name' => 'Vehicle Starts', 'status' => 'In Design'],
                    ['name' => 'GPS Tracking', 'status' => 'Not Started'],
                    ['name' => 'Fuel Entry', 'status' => 'In Design'],
                    ['name' => 'Expense Entry', 'status' => 'In Design'],
                    ['name' => 'Vehicle Status Updates', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 6, 'title' => 'Trip Completion', 'color' => '#16A085',
                'modules' => [
                    ['name' => 'Delivery Done', 'status' => 'Not Started'],
                    ['name' => 'Upload POD', 'status' => 'Not Started'],
                    ['name' => 'Trip Completed', 'status' => 'Not Started'],
                    ['name' => 'Driver Settlement', 'status' => 'Not Started'],
                    ['name' => 'Vendor Settlement', 'status' => 'Not Started'],
                    ['name' => 'Billing Summary', 'status' => 'Not Started'],
                    ['name' => 'Customer Invoice', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 7, 'title' => 'Fleet Health Check', 'color' => '#E74C3C',
                'modules' => [
                    ['name' => 'Vehicle Returned', 'status' => 'Not Started'],
                    ['name' => 'Inspection', 'status' => 'Not Started'],
                    ['name' => 'Complaint Handling', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 8, 'title' => 'Workshop Process', 'color' => '#2980B9',
                'modules' => [
                    ['name' => 'Service Request', 'status' => 'Not Started'],
                    ['name' => 'Appointment', 'status' => 'Not Started'],
                    ['name' => 'Gate Entry', 'status' => 'Not Started'],
                    ['name' => 'Job Card', 'status' => 'Not Started'],
                    ['name' => 'Repair', 'status' => 'Not Started'],
                    ['name' => 'Parts Consumption', 'status' => 'Not Started'],
                    ['name' => 'Billing', 'status' => 'Not Started'],
                    ['name' => 'Vehicle Delivery', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 9, 'title' => 'Inventory Management', 'color' => '#D4A017',
                'modules' => [
                    ['name' => 'Purchase Done', 'status' => 'Not Started'],
                    ['name' => 'Goods Received', 'status' => 'Not Started'],
                    ['name' => 'Inventory Updated', 'status' => 'Not Started'],
                    ['name' => 'Issue Spare Parts', 'status' => 'Not Started'],
                    ['name' => 'Workshop Uses Parts', 'status' => 'Not Started'],
                    ['name' => 'Stock Reduced', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 10, 'title' => 'Preventive Maintenance', 'color' => '#27AE60',
                'modules' => [
                    ['name' => 'Vehicle Running', 'status' => 'Not Started'],
                    ['name' => 'PM Due', 'status' => 'Not Started'],
                    ['name' => 'Schedule PM', 'status' => 'Not Started'],
                    ['name' => 'Maintenance', 'status' => 'Not Started'],
                    ['name' => 'Log Completed PM', 'status' => 'Not Started'],
                    ['name' => 'Next Due Date', 'status' => 'Not Started'],
                ],
            ],
            [
                'no' => 11, 'title' => 'Compliance Management', 'color' => '#7D3C98',
                'modules' => [
                    ['name' => 'Insurance Expiry', 'status' => 'Not Started'],
                    ['name' => 'Permit Expiry', 'status' => 'Not Started'],
                    ['name' => 'Fitness Expiry', 'status' => 'Not Started'],
                    ['name' => 'PUC Expiry', 'status' => 'Not Started'],
                    ['name' => 'Document Expiry', 'status' => 'Not Started'],
                    ['name' => 'Alerts & Notifications', 'status' => 'Not Started'],
                ],
            ],
        ];
    }
}
