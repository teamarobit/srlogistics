<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Workshop Spare Parts master table.
 * Table name: wsspareparts (WS module naming convention)
 * BA approved — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wsspareparts', function (Blueprint $table) {
            $table->id();
            $table->string('part_no', 50)->unique()->comment('Unique part number / SKU, e.g. SP-0001');
            $table->string('name', 255);
            $table->string('category', 100)->nullable();
            $table->string('compatible_makes', 500)->nullable()->comment('Comma-separated vehicle makes');
            $table->string('unit', 30)->default('Piece')->comment('Piece, Set, Litre, Kg, etc.');
            $table->decimal('standard_cost', 10, 2)->default(0);
            $table->unsignedInteger('reorder_level')->default(0)
                  ->comment('Default reorder level; overridden per-location in wsstockbalances');
            // NOTE: current_stock removed — stock is now tracked per location in wsstockbalances
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wsspareparts');
    }
};
