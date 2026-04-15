<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop first in case a previous failed migration left the table behind
        Schema::dropIfExists('tyremaintenanceschedules');

        Schema::create('tyremaintenanceschedules', function (Blueprint $table) {
            $table->bigInteger('id', true);                  // signed BIGINT AUTO_INCREMENT (matches project convention)
            $table->bigInteger('tyre_id')->comment('FK → tyres.id');   // signed to match tyres.id
            $table->string('maintenance_item');              // e.g. Hub Greasing, Rotation, Balancing
            $table->date('last_done_date')->nullable();
            $table->date('next_due_date')->nullable();
            $table->integer('odometer_km')->nullable();      // odometer at last service
            $table->enum('status', ['Scheduled', 'Pending', 'Done', 'Overdue'])->default('Scheduled');
            $table->text('notes')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // No FK constraint — tyres.id is signed BIGINT; MySQL 8 strict mode rejects
            // signed ↔ unsigned FK pairs. Integrity enforced via Eloquent relationship.
            $table->index('tyre_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tyremaintenanceschedules');
    }
};
