<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tyremaintenanceschedules', function (Blueprint $table) {
            // Maintenance type — Alignment or Rotation (replaces free-text maintenance_item)
            $table->string('maintenance_type')->nullable()->after('maintenance_item');

            // Vehicle context — which vehicle this tyre was on when scheduled
            $table->bigInteger('vehicle_id')->nullable()->after('maintenance_type');
            $table->index('vehicle_id');

            // Scheduled KM trigger point
            $table->bigInteger('scheduled_km')->nullable()->after('vehicle_id');

            // Actual service KM (actual_date uses existing last_done_date)
            $table->bigInteger('actual_km')->nullable()->after('scheduled_km');

            // Cost of the maintenance
            $table->decimal('cost', 10, 2)->nullable()->after('actual_km');
        });

        // Extend status enum via raw SQL (SD-11: Title Case)
        DB::statement("ALTER TABLE tyremaintenanceschedules
            MODIFY COLUMN status ENUM('Scheduled','Pending','Done','Overdue','Completed','Missed','Upcoming')
            DEFAULT 'Scheduled'");
    }

    public function down(): void
    {
        // Revert status enum
        DB::statement("ALTER TABLE tyremaintenanceschedules
            MODIFY COLUMN status ENUM('Scheduled','Pending','Done','Overdue')
            DEFAULT 'Scheduled'");

        Schema::table('tyremaintenanceschedules', function (Blueprint $table) {
            $table->dropIndex(['vehicle_id']);
            $table->dropColumn(['maintenance_type', 'vehicle_id', 'scheduled_km', 'actual_km', 'cost']);
        });
    }
};
