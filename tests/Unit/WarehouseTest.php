<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * ─────────────────────────────────────────────────────────────
 * UNIT TEST AGENT (UTA) — Warehouse Module
 * ─────────────────────────────────────────────────────────────
 * Tests isolated model logic: nextCode(), fillable integrity,
 * SoftDeletes, and the active scope.
 *
 * Uses DatabaseTransactions — every test wrapped in a rollback.
 * Runs against sr_logistics_test (real MySQL schema, no migrations).
 * ─────────────────────────────────────────────────────────────
 */
class WarehouseTest extends TestCase
{
    use DatabaseTransactions;

    /** Create a minimal valid Warehouse row directly in the DB. */
    private function makeWarehouse(array $data = []): Warehouse
    {
        return Warehouse::create(array_merge([
            'warehouse_code' => 'WH-T' . uniqid(),
            'name'           => 'Test WH ' . uniqid(),
            'warehouse_type' => 'Central',
            'address'        => '123 Test Road',
            'state_id'       => null,
            'city_name'      => 'TestCity',
            'storage_type'   => 'Rack',
            'status'         => 'Active',
        ], $data));
    }

    // ─── nextCode() ────────────────────────────────────────────────────────────

    /** @test */
    public function next_code_returns_wh_nnn_format(): void
    {
        $code = Warehouse::nextCode();
        $this->assertMatchesRegularExpression('/^WH-\d{3,}$/', $code);
    }

    /** @test */
    public function next_code_increments_after_one_warehouse_created(): void
    {
        $before = Warehouse::nextCode();
        $this->makeWarehouse(['warehouse_code' => $before]);

        $after = Warehouse::nextCode();

        // Extract numbers and confirm after > before
        $beforeNum = (int) ltrim(str_replace('WH-', '', $before), '0') ?: 0;
        $afterNum  = (int) ltrim(str_replace('WH-', '', $after), '0')  ?: 0;

        $this->assertGreaterThan($beforeNum, $afterNum);
    }

    /** @test */
    public function next_code_includes_soft_deleted_warehouses_in_count(): void
    {
        $before = Warehouse::nextCode();
        $wh = $this->makeWarehouse(['warehouse_code' => $before]);
        $wh->delete(); // soft-delete

        $after = Warehouse::nextCode();

        $beforeNum = (int) ltrim(str_replace('WH-', '', $before), '0') ?: 0;
        $afterNum  = (int) ltrim(str_replace('WH-', '', $after), '0')  ?: 0;

        $this->assertGreaterThan($beforeNum, $afterNum);
    }

    // ─── Fillable / Mass-assignment ────────────────────────────────────────────

    /** @test */
    public function warehouse_model_has_all_expected_fillable_fields(): void
    {
        $fillable = (new Warehouse())->getFillable();

        $required = [
            'organisation_id', 'warehouse_code', 'name', 'warehouse_type',
            'address', 'location_name', 'state_id', 'city_name', 'pincode',
            'manager_contact_id', 'contact_number', 'storage_type',
            'notes', 'status', 'created_by', 'updated_by', 'deleted_by',
        ];

        foreach ($required as $field) {
            $this->assertContains($field, $fillable, "'{$field}' must be in \$fillable.");
        }
    }

    // ─── SoftDeletes ───────────────────────────────────────────────────────────

    /** @test */
    public function soft_deleted_warehouse_is_excluded_from_default_query(): void
    {
        $wh = $this->makeWarehouse();
        $id = $wh->id;
        $wh->delete();

        $this->assertNull(Warehouse::find($id));
    }

    /** @test */
    public function soft_deleted_warehouse_is_visible_with_trashed(): void
    {
        $wh = $this->makeWarehouse();
        $id = $wh->id;
        $wh->delete();

        $this->assertNotNull(Warehouse::withTrashed()->find($id));
    }

    /** @test */
    public function deleted_at_is_set_after_soft_delete(): void
    {
        $wh = $this->makeWarehouse();
        $wh->delete();

        $this->assertNotNull(Warehouse::withTrashed()->find($wh->id)->deleted_at);
    }

    // ─── scopeActive() ─────────────────────────────────────────────────────────

    /** @test */
    public function active_scope_only_returns_active_status_records(): void
    {
        $active   = $this->makeWarehouse(['status' => 'Active',   'name' => 'Scope Active ' . uniqid()]);
        $inactive = $this->makeWarehouse(['status' => 'Inactive', 'name' => 'Scope Inactive ' . uniqid()]);

        // Query using the specific IDs we just created (to avoid noise from existing data)
        $ids = [$active->id, $inactive->id];

        $result = Warehouse::active()->whereIn('id', $ids)->get();

        $this->assertCount(1, $result);
        $this->assertSame('Active', $result->first()->status);
        $this->assertSame($active->id, $result->first()->id);
    }

    /** @test */
    public function inactive_warehouse_is_excluded_from_active_scope(): void
    {
        $inactive = $this->makeWarehouse(['status' => 'Inactive', 'name' => 'Inactive Only ' . uniqid()]);

        $result = Warehouse::active()->where('id', $inactive->id)->get();

        $this->assertCount(0, $result);
    }

    // ─── warehouse_type enum ───────────────────────────────────────────────────

    /** @test */
    public function warehouse_accepts_all_valid_type_values(): void
    {
        foreach (['Central', 'Regional', 'Site/Yard'] as $type) {
            $wh = $this->makeWarehouse([
                'warehouse_type' => $type,
                'name'           => 'Type WH ' . $type . uniqid(),
            ]);
            $this->assertSame($type, Warehouse::find($wh->id)->warehouse_type);
        }
    }

    // ─── storage_type enum ─────────────────────────────────────────────────────

    /** @test */
    public function warehouse_accepts_all_valid_storage_type_values(): void
    {
        foreach (['Rack', 'Floor', 'Open Yard'] as $storage) {
            $wh = $this->makeWarehouse([
                'storage_type' => $storage,
                'name'         => 'Storage WH ' . $storage . uniqid(),
            ]);
            $this->assertSame($storage, Warehouse::find($wh->id)->storage_type);
        }
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    /** @test */
    public function warehouse_state_relationship_returns_null_when_state_id_is_null(): void
    {
        $wh = $this->makeWarehouse(['state_id' => null]);
        $this->assertNull($wh->state);
    }

    /** @test */
    public function warehouse_manager_relationship_returns_null_when_manager_not_set(): void
    {
        $wh = $this->makeWarehouse(['manager_contact_id' => null]);
        $this->assertNull($wh->manager);
    }
}
