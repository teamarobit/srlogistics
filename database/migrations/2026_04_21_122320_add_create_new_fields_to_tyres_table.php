<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds additive columns required by the redesigned tyres/create-new screen.
 * Does NOT remove or rename any existing columns used by tyres/create.
 * Widens the tyre_condition ENUM so it can also accept the new design's values.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tyres', function (Blueprint $table) {
            // Organisation scope (SD-12) — default 1 so existing rows stay valid
            if (! Schema::hasColumn('tyres', 'organisation_id')) {
                $table->bigInteger('organisation_id')->default(1)->after('id');
                $table->index('organisation_id', 'tyres_organisation_id_index');
            }

            // Identity & Classification additions
            if (! Schema::hasColumn('tyres', 'tyre_size')) {
                $table->string('tyre_size', 50)->nullable()->after('tyre_brand');
            }
            if (! Schema::hasColumn('tyres', 'tyre_category')) {
                $table->enum('tyre_category', ['Drive', 'Steer', 'Trailer'])->nullable()->after('tyre_size');
            }

            // Source information
            if (! Schema::hasColumn('tyres', 'tyre_source_mode')) {
                $table->enum('tyre_source_mode', ['Existing', 'New PO'])->default('Existing')->after('tyre_category');
            }
            if (! Schema::hasColumn('tyres', 'source_origin_note')) {
                $table->text('source_origin_note')->nullable()->after('tyre_source_mode');
            }
            if (! Schema::hasColumn('tyres', 'purchase_order_reference')) {
                $table->string('purchase_order_reference', 100)->nullable()->after('source_origin_note');
            }
            if (! Schema::hasColumn('tyres', 'invoice_reference')) {
                $table->string('invoice_reference', 100)->nullable()->after('purchase_order_reference');
            }
            if (! Schema::hasColumn('tyres', 'invoice_file_path')) {
                $table->string('invoice_file_path', 255)->nullable()->after('invoice_reference');
            }

            // Stock location
            if (! Schema::hasColumn('tyres', 'bin_rack')) {
                $table->string('bin_rack', 50)->nullable()->after('warehouse_id');
            }
            if (! Schema::hasColumn('tyres', 'workshop_id')) {
                $table->bigInteger('workshop_id')->nullable()->after('warehouse_id');
                $table->index('workshop_id', 'tyres_workshop_id_index');
            }
            if (! Schema::hasColumn('tyres', 'stock_status')) {
                $table->enum('stock_status', ['Warehouse', 'Mounted', 'In Transit'])->default('Warehouse')->after('bin_rack');
            }

            // Current lifecycle status (distinct from tyre_condition)
            if (! Schema::hasColumn('tyres', 'current_status')) {
                $table->enum('current_status', ['Warehouse', 'Allocated', 'Workshop', 'Discarded'])->default('Warehouse')->after('stock_status');
            }
            if (! Schema::hasColumn('tyres', 'allocated_vehicle_id')) {
                $table->bigInteger('allocated_vehicle_id')->nullable()->after('current_status');
                $table->index('allocated_vehicle_id', 'tyres_allocated_vehicle_id_index');
            }
            if (! Schema::hasColumn('tyres', 'installation_date')) {
                $table->date('installation_date')->nullable()->after('allocated_vehicle_id');
            }

            // Lifecycle — end-of-life auto-computed at store time
            if (! Schema::hasColumn('tyres', 'end_of_life_date')) {
                $table->date('end_of_life_date')->nullable()->after('tyre_warrenty_end_date');
            }

            // Technical specifications
            if (! Schema::hasColumn('tyres', 'ply_rating')) {
                $table->integer('ply_rating')->nullable()->after('end_of_life_date');
            }
            if (! Schema::hasColumn('tyres', 'load_index')) {
                $table->integer('load_index')->nullable()->after('ply_rating');
            }
            if (! Schema::hasColumn('tyres', 'speed_rating')) {
                $table->string('speed_rating', 2)->nullable()->after('load_index');
            }
            if (! Schema::hasColumn('tyres', 'tread_depth_mm')) {
                $table->decimal('tread_depth_mm', 5, 2)->nullable()->after('speed_rating');
            }
            if (! Schema::hasColumn('tyres', 'tube_type')) {
                $table->enum('tube_type', ['Tube', 'Tubeless'])->nullable()->after('tread_depth_mm');
            }

            // Initial condition (SD-11 Title Case; expanded 4-option set)
            if (! Schema::hasColumn('tyres', 'initial_condition')) {
                $table->enum('initial_condition', ['New', 'Retreaded', 'Used Good', 'Scrap'])->nullable()->after('tyre_condition');
            }

            // Free-text notes for the new screen
            if (! Schema::hasColumn('tyres', 'notes')) {
                $table->text('notes')->nullable()->after('discard_note');
            }
        });

        // Widen tyre_condition ENUM so new-design values ('Used', 'Retread') are accepted
        // WITHOUT breaking the existing create screen which uses 'New' / 'Re-thread'.
        // Raw SQL — doctrine/dbal is not a Laravel 12 dependency.
        try {
            DB::statement("ALTER TABLE tyres MODIFY tyre_condition ENUM('New','Re-thread','Retread','Used','Used Good','Discard','Scrap') NOT NULL");
        } catch (\Throwable $e) {
            // Non-MySQL engine or existing column may be nullable — skip silently; validation guards values.
        }

        // Mirror the ENUM widening on tyrelogs so controller logs accept new condition values.
        try {
            DB::statement("ALTER TABLE tyrelogs MODIFY tyre_condition ENUM('New','Re-thread','Retread','Used','Used Good','Discard','Scrap') NOT NULL");
        } catch (\Throwable $e) {
            // ignore
        }
    }

    public function down(): void
    {
        Schema::table('tyres', function (Blueprint $table) {
            $cols = [
                'organisation_id',
                'tyre_size',
                'tyre_category',
                'tyre_source_mode',
                'source_origin_note',
                'purchase_order_reference',
                'invoice_reference',
                'invoice_file_path',
                'bin_rack',
                'workshop_id',
                'stock_status',
                'current_status',
                'allocated_vehicle_id',
                'installation_date',
                'end_of_life_date',
                'ply_rating',
                'load_index',
                'speed_rating',
                'tread_depth_mm',
                'tube_type',
                'initial_condition',
                'notes',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('tyres', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        try {
            DB::statement("ALTER TABLE tyres MODIFY tyre_condition ENUM('New','Re-thread','Discard') NOT NULL");
        } catch (\Throwable $e) {
            // ignore
        }
        try {
            DB::statement("ALTER TABLE tyrelogs MODIFY tyre_condition ENUM('New','Re-thread','Discard') NOT NULL");
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
