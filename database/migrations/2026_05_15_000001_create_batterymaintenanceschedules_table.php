<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batterymaintenanceschedules', function (Blueprint $table) {
            $table->bigInteger('id', true);

            $table->bigInteger('battery_id')->comment('FK → batteries.id');
            $table->bigInteger('organisation_id')->default(1);

            $table->string('maintenance_item', 255)->nullable();
            $table->enum('maintenance_type', ['Inspection', 'Charging', 'Replacement', 'Other'])->nullable();

            $table->bigInteger('vehicle_id')->nullable()->comment('FK → vehicles.id');

            $table->date('last_done_date')->nullable();
            $table->date('next_due_date')->nullable();

            $table->unsignedInteger('odometer_km')->nullable();
            $table->unsignedInteger('scheduled_km')->nullable();
            $table->unsignedInteger('actual_km')->nullable();

            $table->decimal('cost', 12, 2)->nullable();

            $table->enum('status', [
                'Scheduled',
                'Pending',
                'Done',
                'Overdue',
                'Completed',
                'Missed',
                'Upcoming',
            ])->default('Scheduled');

            $table->text('notes')->nullable();

            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batterymaintenanceschedules');
    }
};
