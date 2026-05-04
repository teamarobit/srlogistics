<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds all fields required by the 8-tab tyre dashboard redesign.
 * Additive only — does not rename or remove existing columns.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tyres', function (Blueprint $table) {

            // ── Master Tyre Status ───────────────────────────────────────────
            if (! Schema::hasColumn('tyres', 'tyre_status')) {
                $table->enum('tyre_status', [
                    'Ready to Use',
                    'Warranty Claim',
                    'Re-threading',
                    'Scrap',
                    'Allocated',
                    'Direct Fitment',
                    'Yet to Decide',
                    'Extra on Vehicle',
                ])->nullable()->after('tyre_condition')
                  ->comment('Explicit status used for tab routing on dashboard');
            }

            // ── Warranty Claim Fields ────────────────────────────────────────
            if (! Schema::hasColumn('tyres', 'warranty_location')) {
                $table->enum('warranty_location', ['SR Garage', 'Sent for Warranty'])
                      ->nullable()->after('tyre_status');
            }
            if (! Schema::hasColumn('tyres', 'warranty_claim_number')) {
                $table->string('warranty_claim_number', 100)->nullable()->after('warranty_location');
            }
            if (! Schema::hasColumn('tyres', 'warranty_claim_reason')) {
                $table->text('warranty_claim_reason')->nullable()->after('warranty_claim_number');
            }
            if (! Schema::hasColumn('tyres', 'warranty_claim_amount')) {
                $table->decimal('warranty_claim_amount', 12, 2)->nullable()->after('warranty_claim_reason');
            }
            if (! Schema::hasColumn('tyres', 'warranty_claim_date')) {
                $table->date('warranty_claim_date')->nullable()->after('warranty_claim_amount');
            }
            if (! Schema::hasColumn('tyres', 'warranty_expected_closure_date')) {
                $table->date('warranty_expected_closure_date')->nullable()->after('warranty_claim_date');
            }
            if (! Schema::hasColumn('tyres', 'warranty_utr')) {
                $table->string('warranty_utr', 100)->nullable()->after('warranty_expected_closure_date')
                      ->comment('UTR for refund payment; when filled, claim is closed');
            }
            if (! Schema::hasColumn('tyres', 'warranty_refund_amount')) {
                $table->decimal('warranty_refund_amount', 12, 2)->nullable()->after('warranty_utr');
            }

            // ── Re-threading Fields ──────────────────────────────────────────
            if (! Schema::hasColumn('tyres', 'rethreading_location')) {
                $table->enum('rethreading_location', ['SR Garage', 'Sent for Re-threading'])
                      ->nullable()->after('warranty_refund_amount');
            }
            if (! Schema::hasColumn('tyres', 'rethreading_vendor_id')) {
                $table->bigInteger('rethreading_vendor_id')->nullable()->after('rethreading_location')
                      ->comment('FK → contacts.id (Tyre Vendor / Re-threading vendor)');
            }
            if (! Schema::hasColumn('tyres', 'rethreading_sent_date')) {
                $table->date('rethreading_sent_date')->nullable()->after('rethreading_vendor_id');
            }
            if (! Schema::hasColumn('tyres', 'rethreading_expected_date')) {
                $table->date('rethreading_expected_date')->nullable()->after('rethreading_sent_date');
            }
            if (! Schema::hasColumn('tyres', 'rethreading_cost')) {
                $table->decimal('rethreading_cost', 12, 2)->nullable()->after('rethreading_expected_date');
            }

            // ── Scrap Fields ─────────────────────────────────────────────────
            if (! Schema::hasColumn('tyres', 'scrap_location')) {
                $table->enum('scrap_location', ['SR Garage', 'Sent for Scrap'])
                      ->nullable()->after('rethreading_cost');
            }
            if (! Schema::hasColumn('tyres', 'scrap_reason')) {
                $table->text('scrap_reason')->nullable()->after('scrap_location');
            }
            if (! Schema::hasColumn('tyres', 'scrap_vendor_id')) {
                $table->bigInteger('scrap_vendor_id')->nullable()->after('scrap_reason')
                      ->comment('FK → contacts.id');
            }
            if (! Schema::hasColumn('tyres', 'scrap_income')) {
                $table->decimal('scrap_income', 12, 2)->nullable()->after('scrap_vendor_id');
            }
            if (! Schema::hasColumn('tyres', 'scrap_utr')) {
                $table->string('scrap_utr', 100)->nullable()->after('scrap_income')
                      ->comment('UTR for scrap income received');
            }
            if (! Schema::hasColumn('tyres', 'scrap_sent_date')) {
                $table->date('scrap_sent_date')->nullable()->after('scrap_utr');
            }
            if (! Schema::hasColumn('tyres', 'last_fitted_vehicle_id')) {
                $table->bigInteger('last_fitted_vehicle_id')->nullable()->after('scrap_sent_date')
                      ->comment('FK → vehicles.id — last vehicle this tyre was fitted on');
            }

            // ── Yet To Decide Fields ─────────────────────────────────────────
            if (! Schema::hasColumn('tyres', 'damage_reason')) {
                $table->text('damage_reason')->nullable()->after('last_fitted_vehicle_id')
                      ->comment('Reason tyre is pending decision (Yet to Decide tab)');
            }
        });
    }

    public function down(): void
    {
        $cols = [
            'tyre_status',
            'warranty_location', 'warranty_claim_number', 'warranty_claim_reason',
            'warranty_claim_amount', 'warranty_claim_date', 'warranty_expected_closure_date',
            'warranty_utr', 'warranty_refund_amount',
            'rethreading_location', 'rethreading_vendor_id', 'rethreading_sent_date',
            'rethreading_expected_date', 'rethreading_cost',
            'scrap_location', 'scrap_reason', 'scrap_vendor_id', 'scrap_income',
            'scrap_utr', 'scrap_sent_date', 'last_fitted_vehicle_id',
            'damage_reason',
        ];

        Schema::table('tyres', function (Blueprint $table) use ($cols) {
            foreach ($cols as $col) {
                if (Schema::hasColumn('tyres', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
