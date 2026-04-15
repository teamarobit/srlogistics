<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Workshop Stock Ledger — immutable transaction log.
 *
 * Every stock movement (IN / OUT / TRANSFER / ADJUSTMENT / etc.) is written
 * here. The wsstockbalances table is always updated simultaneously.
 *
 * Transaction types:
 *   Opening    — initial stock load
 *   Purchase   — goods received from vendor (IN)
 *   Issue      — issued to a job card / workshop (OUT)
 *   Return     — parts returned from job card (IN)
 *   Transfer   — moved between warehouse ↔ workshop
 *   Adjustment — stock-take correction (+ or -)
 *   Scrap      — write-off (OUT)
 *
 * BA CIAA approved — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wsstockledger', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('organisation_id')->nullable()
                  ->comment('FK → organisations.id');

            // ── Transaction identity ───────────────────────────────────────
            $table->string('txn_no', 30)->unique()
                  ->comment('Auto-generated ledger number e.g. SL-2026-00001');
            $table->date('txn_date')->comment('Date of movement');

            $table->enum('txn_type', [
                'Opening',
                'Purchase',
                'Issue',
                'Return',
                'Transfer',
                'Adjustment',
                'Scrap',
            ])->comment('Nature of transaction');

            // ── Item reference ─────────────────────────────────────────────
            $table->enum('item_type', ['spare_part', 'tyre', 'battery']);
            $table->unsignedBigInteger('item_id');

            // ── Location movement ──────────────────────────────────────────
            // For IN/OUT/Opening/Adjustment: only to_ or from_ is used.
            // For Transfer: both from_ and to_ are populated.
            $table->enum('from_location_type', ['warehouse', 'workshop'])->nullable();
            $table->unsignedBigInteger('from_location_id')->nullable();

            $table->enum('to_location_type', ['warehouse', 'workshop'])->nullable();
            $table->unsignedBigInteger('to_location_id')->nullable();

            // ── Quantity & cost ────────────────────────────────────────────
            $table->decimal('qty', 10, 3)->comment('Always positive; direction implied by txn_type');
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();

            // ── Reference document ─────────────────────────────────────────
            $table->string('ref_type', 50)->nullable()
                  ->comment('purchase_order | job_card | transfer_note | manual');
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('ref_no', 50)->nullable()
                  ->comment('Human-readable reference number');

            $table->text('notes')->nullable();

            // ── Status ─────────────────────────────────────────────────────
            $table->enum('status', ['Posted', 'Cancelled'])->default('Posted');

            // ── Audit ──────────────────────────────────────────────────────
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            // ── Indexes ────────────────────────────────────────────────────
            $table->index(['item_type', 'item_id'], 'wssl_item_idx');
            $table->index(['txn_date'], 'wssl_date_idx');
            $table->index(['txn_type'], 'wssl_type_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wsstockledger');
    }
};
