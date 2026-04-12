<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Workshop Stock Balances — location-wise current stock.
 *
 * Replaces the single `current_stock` column on wsspareparts / tyres / batteries
 * with a proper per-location stock record.
 *
 * Each row = one item (spare_part | tyre | battery)
 *          × one location (warehouse | workshop)
 *          → current quantity + reorder level
 *
 * BA CIAA approved — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wsstockbalances', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('organisation_id')->nullable()
                  ->comment('FK → organisations.id');

            // ── Item reference ─────────────────────────────────────────────
            $table->enum('item_type', ['spare_part', 'tyre', 'battery'])
                  ->comment('Which master table this row references');
            $table->unsignedBigInteger('item_id')
                  ->comment('FK → wsspareparts.id / tyres.id / vehiclebatteries.id');

            // ── Location reference ─────────────────────────────────────────
            $table->enum('location_type', ['warehouse', 'workshop'])
                  ->comment('Warehouse (warehouses table) or Workshop (workshops table)');
            $table->unsignedBigInteger('location_id')
                  ->comment('FK → warehouses.id or workshops.id');

            // ── Stock figures ──────────────────────────────────────────────
            $table->decimal('quantity', 10, 3)->default(0)
                  ->comment('Current on-hand quantity at this location');
            $table->decimal('reserved_quantity', 10, 3)->default(0)
                  ->comment('Qty reserved for pending job cards / POs');
            $table->unsignedInteger('reorder_level')->default(0)
                  ->comment('Low-stock trigger for this location');

            // ── Status ─────────────────────────────────────────────────────
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            // ── Audit ──────────────────────────────────────────────────────
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            // ── Constraints ────────────────────────────────────────────────
            $table->unique(
                ['item_type', 'item_id', 'location_type', 'location_id'],
                'wssb_item_location_unique'
            );

            $table->index(['item_type', 'item_id'], 'wssb_item_idx');
            $table->index(['location_type', 'location_id'], 'wssb_location_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wsstockbalances');
    }
};
