<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batteries', function (Blueprint $table) {

            // ── Dashboard tab status ──────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'battery_status')) {
                $table->enum('battery_status', [
                    'Ready to Use',
                    'Warranty Claim',
                    'Repair',
                    'Scrap',
                    'Allocated',
                    'Direct Fitment',
                    'Yet to Decide',
                ])->nullable()->after('current_status');
            }

            // ── RAG status ────────────────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'rag_status')) {
                $table->enum('rag_status', ['Green', 'Yellow', 'Red'])
                      ->default('Green')->after('battery_status');
            }

            // ── Location / position ───────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'battery_location')) {
                $table->enum('battery_location', ['SR Garage', 'Vehicle'])
                      ->default('SR Garage')->after('rag_status');
            }

            if (! Schema::hasColumn('batteries', 'battery_position')) {
                $table->enum('battery_position', ['B1', 'B2'])
                      ->nullable()->after('battery_location');
            }

            // ── Tracking group ────────────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'tracking_group_id')) {
                $table->bigInteger('tracking_group_id')->nullable()->after('battery_position');
            }

            // ── In-garage date (Ready to Use) ─────────────────────────────
            if (! Schema::hasColumn('batteries', 'in_garage_since')) {
                $table->date('in_garage_since')->nullable()->after('tracking_group_id');
            }

            // ── Warranty Claim columns ────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'warranty_claim_location')) {
                $table->enum('warranty_claim_location', ['SR Garage', 'Sent for Warranty'])
                      ->nullable()->after('in_garage_since');
            }

            if (! Schema::hasColumn('batteries', 'warranty_claim_number')) {
                $table->string('warranty_claim_number', 100)->nullable()
                      ->after('warranty_claim_location');
            }

            if (! Schema::hasColumn('batteries', 'warranty_claim_reason')) {
                $table->text('warranty_claim_reason')->nullable()
                      ->after('warranty_claim_number');
            }

            if (! Schema::hasColumn('batteries', 'warranty_claim_date')) {
                $table->date('warranty_claim_date')->nullable()
                      ->after('warranty_claim_reason');
            }

            if (! Schema::hasColumn('batteries', 'warranty_expected_closure_date')) {
                $table->date('warranty_expected_closure_date')->nullable()
                      ->after('warranty_claim_date');
            }

            if (! Schema::hasColumn('batteries', 'warranty_new_battery_serial')) {
                $table->string('warranty_new_battery_serial', 100)->nullable()
                      ->after('warranty_expected_closure_date');
            }

            if (! Schema::hasColumn('batteries', 'warranty_new_battery_received_date')) {
                $table->date('warranty_new_battery_received_date')->nullable()
                      ->after('warranty_new_battery_serial');
            }

            if (! Schema::hasColumn('batteries', 'warranty_comment')) {
                $table->text('warranty_comment')->nullable()
                      ->after('warranty_new_battery_received_date');
            }

            // ── Repair columns ────────────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'repair_location')) {
                $table->enum('repair_location', ['SR Garage', 'Sent for Repair'])
                      ->nullable()->after('warranty_comment');
            }

            if (! Schema::hasColumn('batteries', 'repair_type')) {
                $table->string('repair_type', 100)->nullable()->after('repair_location');
            }

            if (! Schema::hasColumn('batteries', 'repair_vendor_id')) {
                $table->bigInteger('repair_vendor_id')->nullable()->after('repair_type');
            }

            if (! Schema::hasColumn('batteries', 'repair_sent_date')) {
                $table->date('repair_sent_date')->nullable()->after('repair_vendor_id');
            }

            if (! Schema::hasColumn('batteries', 'repair_expected_closure_date')) {
                $table->date('repair_expected_closure_date')->nullable()
                      ->after('repair_sent_date');
            }

            if (! Schema::hasColumn('batteries', 'repair_cost')) {
                $table->decimal('repair_cost', 12, 2)->nullable()->after('repair_expected_closure_date');
            }

            if (! Schema::hasColumn('batteries', 'repair_comment')) {
                $table->text('repair_comment')->nullable()->after('repair_cost');
            }

            // ── Scrap columns ─────────────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'scrap_location')) {
                $table->enum('scrap_location', ['SR Garage', 'Sent for Scrap'])
                      ->nullable()->after('repair_comment');
            }

            if (! Schema::hasColumn('batteries', 'scrap_reason')) {
                $table->text('scrap_reason')->nullable()->after('scrap_location');
            }

            if (! Schema::hasColumn('batteries', 'scrap_vendor_id')) {
                $table->bigInteger('scrap_vendor_id')->nullable()->after('scrap_reason');
            }

            if (! Schema::hasColumn('batteries', 'scrap_sent_date')) {
                $table->date('scrap_sent_date')->nullable()->after('scrap_vendor_id');
            }

            if (! Schema::hasColumn('batteries', 'scrap_income')) {
                $table->decimal('scrap_income', 12, 2)->nullable()->after('scrap_sent_date');
            }

            if (! Schema::hasColumn('batteries', 'scrap_income_utr')) {
                $table->string('scrap_income_utr', 100)->nullable()->after('scrap_income');
            }

            if (! Schema::hasColumn('batteries', 'scrap_run_months')) {
                $table->unsignedSmallInteger('scrap_run_months')->nullable()->after('scrap_income_utr');
            }

            if (! Schema::hasColumn('batteries', 'scrap_run_km')) {
                $table->unsignedInteger('scrap_run_km')->nullable()->after('scrap_run_months');
            }

            if (! Schema::hasColumn('batteries', 'scrap_last_fitted_vehicle_id')) {
                $table->bigInteger('scrap_last_fitted_vehicle_id')->nullable()->after('scrap_run_km');
            }

            if (! Schema::hasColumn('batteries', 'scrap_comment')) {
                $table->text('scrap_comment')->nullable()->after('scrap_last_fitted_vehicle_id');
            }

            // ── Yet to Decide columns ─────────────────────────────────────
            if (! Schema::hasColumn('batteries', 'damage_reason')) {
                $table->text('damage_reason')->nullable()->after('scrap_comment');
            }

            if (! Schema::hasColumn('batteries', 'ytd_last_vehicle_id')) {
                $table->bigInteger('ytd_last_vehicle_id')->nullable()->after('damage_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('batteries', function (Blueprint $table) {
            $table->dropColumn([
                'battery_status',
                'rag_status',
                'battery_location',
                'battery_position',
                'tracking_group_id',
                'in_garage_since',
                'warranty_claim_location',
                'warranty_claim_number',
                'warranty_claim_reason',
                'warranty_claim_date',
                'warranty_expected_closure_date',
                'warranty_new_battery_serial',
                'warranty_new_battery_received_date',
                'warranty_comment',
                'repair_location',
                'repair_type',
                'repair_vendor_id',
                'repair_sent_date',
                'repair_expected_closure_date',
                'repair_cost',
                'repair_comment',
                'scrap_location',
                'scrap_reason',
                'scrap_vendor_id',
                'scrap_sent_date',
                'scrap_income',
                'scrap_income_utr',
                'scrap_run_months',
                'scrap_run_km',
                'scrap_last_fitted_vehicle_id',
                'scrap_comment',
                'damage_reason',
                'ytd_last_vehicle_id',
            ]);
        });
    }
};
