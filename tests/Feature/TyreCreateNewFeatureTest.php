<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use App\Models\Tyre;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

/**
 * ─────────────────────────────────────────────────────────────
 * FEATURE TEST — Tyre / Create-New module
 * ─────────────────────────────────────────────────────────────
 * Routes tested:
 *   GET  /tyres/create-new     → createNew
 *   POST /tyres/save-new       → storeNew
 *
 * Standards enforced:
 *   QA-1: seeded user + skip-if-missing
 *   QA-2: validPayload() helper — tests modify only the field under test
 *   QA-3: full descriptive snake_case method names
 *   QA-4: assert organisation_id is never null
 *   SD-9: explicit HTTP status codes on JSON responses
 *   SD-11: Title Case ENUM values
 *   SD-12: organisation_id set in store()
 * ─────────────────────────────────────────────────────────────
 */
class TyreCreateNewFeatureTest extends TestCase
{
    use DatabaseTransactions;

    private User      $user;
    private Contact   $vendor;
    private Warehouse $warehouse;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::where('is_active', 'Yes')->first();
        if (! $this->user) {
            $this->markTestSkipped('No active user found. Run: php artisan db:seed --class=UserSeeder');
        }

        // Tyre vendor (cotype_id = 6 per CotypesTableSeeder)
        $this->vendor = Contact::where('cotype_id', 6)->where('status', 'Active')->first()
                     ?? Contact::create([
                         'organisation_id' => 1,
                         'cotype_id'       => 6,
                         'company_name'    => 'QA Tyre Vendor ' . uniqid(),
                         'contact_name'    => 'QA Tester',
                         'contact_number'  => '+919876543210',
                         'status'          => 'Active',
                         'created_by'      => $this->user->id,
                     ]);

        $this->warehouse = Warehouse::where('status', 'Active')->first()
                        ?? Warehouse::create([
                            'warehouse_code' => 'WH-QA' . uniqid(),
                            'name'           => 'QA Warehouse',
                            'warehouse_type' => 'Central',
                            'storage_type'   => 'Rack',
                            'status'         => 'Active',
                        ]);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            // Source
            'tyre_source_mode'         => 'Existing',
            'source_origin_note'       => 'QA: purchased from test vendor',
            'invoice_reference'        => 'QA-INV-' . uniqid(),

            // Identity
            'tyre_serial_number'       => 'TYR-QA-' . strtoupper(uniqid()),
            'vendor'                   => $this->vendor->id,
            'tyre_brand'               => 'MRF',
            'tyre_model_name'          => 'Steel Muscle',
            'tyre_type'                => 'Radial',         // SD-11 Title Case
            'tyre_size'                => '295/90 R20',

            // Classification
            'condition'                => 'New',            // SD-11 Title Case
            'tyre_category'            => 'Drive',          // SD-11 Title Case

            // Stock Location — unified radio group: wh:<id> | ws:<id> | ''
            'stock_location'           => 'wh:' . $this->warehouse->id,

            // Purchase & Cost
            'tyre_price'               => 18500.00,
            'tyre_purchase_date'       => now()->subDays(1)->toDateString(),
            'tyre_warranty_months'     => 12,

            // Lifecycle & Usage
            'fixed_run_km'             => 80000,
            'fixed_life_months'        => 36,
            'actual_run_km'            => 0,
            'actual_run_month'         => 0,

            // Maintenance & Reminders
            'alignment_interval_km'    => 10000,
            'rotation_interval_km'     => 10000,
            'set_reminder_for_alignment' => 1,
            'set_reminder_for_rotation'  => 1,

            // Technical
            'ply_rating'               => 16,
            'tube_type'                => 'Tubeless',       // SD-11 Title Case

            // Initial Condition
            'initial_condition'        => 'New',            // SD-11 Title Case

            // Notes
            'notes'                    => 'QA feature test run',

            // Images — at least one required
            'files'                    => [
                UploadedFile::fake()->image('tyre-1.jpg', 800, 600)->size(200),
            ],
        ], $overrides);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // AUTH GUARD
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function unauthenticated_user_is_redirected_from_create_new(): void
    {
        $this->get(route('tyre.createNew'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthenticated_user_cannot_submit_save_new(): void
    {
        $this->postJson(route('tyre.saveNew'), $this->validPayload())
             ->assertStatus(401);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // HAPPY PATH
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function create_new_page_loads_for_authenticated_user(): void
    {
        $this->actingAs($this->user)
             ->get(route('tyre.createNew'))
             ->assertStatus(200)
             ->assertSee('Add Tyre to Inventory');
    }

    /** @test */
    public function store_new_creates_tyre_and_returns_json_redirect(): void
    {
        $payload = $this->validPayload();

        $response = $this->actingAs($this->user)
                         ->postJson(route('tyre.saveNew'), $payload);

        // Surface the controller's error message if the assertion would fail.
        // Remove once happy-path is green.
        if ($response->status() !== 200) {
            fwrite(STDERR, "\n\n=== storeNew 500 dump ===\n" . $response->getContent() . "\n=========================\n\n");
        }

        $response->assertStatus(200)   // SD-9
                 ->assertJson([
                     'success' => true,
                 ])
                 ->assertJsonStructure(['success', 'message', 'redirect_url', 'tyre_id']);

        $this->assertDatabaseHas('tyres', [
            'tyre_serial_number' => $payload['tyre_serial_number'],
            'tyre_brand'         => 'MRF',
            'tyre_category'      => 'Drive',
            'current_status'     => 'Warehouse',   // BR-3 — forced at create
            'stock_status'       => 'Warehouse',
        ]);
    }

    /** @test */
    public function store_new_sets_organisation_id_from_authenticated_user(): void
    {
        $payload = $this->validPayload();
        $this->actingAs($this->user)->postJson(route('tyre.saveNew'), $payload);

        $tyre = Tyre::where('tyre_serial_number', $payload['tyre_serial_number'])->first();
        $this->assertNotNull($tyre, 'Tyre row not created');
        $this->assertNotNull($tyre->organisation_id, 'organisation_id must never be null (SD-12)');
    }

    /** @test */
    public function store_new_auto_calculates_warranty_expiry_and_end_of_life_dates(): void
    {
        $payload = $this->validPayload([
            'tyre_purchase_date'   => '2026-01-15',
            'tyre_warranty_months' => 24,
            'fixed_life_months'    => 48,
        ]);

        $this->actingAs($this->user)->postJson(route('tyre.saveNew'), $payload);

        $tyre = Tyre::where('tyre_serial_number', $payload['tyre_serial_number'])->first();
        $this->assertNotNull($tyre);
        $this->assertEquals('2028-01-15', date('Y-m-d', strtotime($tyre->tyre_warrenty_end_date)));
        $this->assertEquals('2030-01-15', date('Y-m-d', strtotime($tyre->end_of_life_date)));
    }

    /** @test */
    public function store_new_uppercases_and_trims_serial_number(): void
    {
        $payload = $this->validPayload([
            'tyre_serial_number' => '  qa-lower-' . uniqid() . '  ',
        ]);

        $this->actingAs($this->user)->postJson(route('tyre.saveNew'), $payload);

        $expected = strtoupper(trim($payload['tyre_serial_number']));
        $this->assertDatabaseHas('tyres', [
            'tyre_serial_number' => $expected,
        ]);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // VALIDATION
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function store_new_requires_serial_number(): void
    {
        $payload = $this->validPayload(['tyre_serial_number' => '']);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $payload)
             ->assertStatus(422)   // SD-9
             ->assertJsonValidationErrors(['tyre_serial_number']);
    }

    /** @test */
    public function store_new_requires_source_origin_note(): void
    {
        $payload = $this->validPayload(['source_origin_note' => '']);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $payload)
             ->assertStatus(422)
             ->assertJsonValidationErrors(['source_origin_note']);
    }

    /** @test */
    public function store_new_requires_po_reference_when_source_is_new_po(): void
    {
        $payload = $this->validPayload([
            'tyre_source_mode'         => 'New PO',
            'purchase_order_reference' => '',
        ]);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $payload)
             ->assertStatus(422)
             ->assertJsonValidationErrors(['purchase_order_reference']);
    }

    /** @test */
    public function store_new_rejects_invalid_tyre_category(): void
    {
        $payload = $this->validPayload(['tyre_category' => 'InvalidCategory']);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $payload)
             ->assertStatus(422)
             ->assertJsonValidationErrors(['tyre_category']);
    }

    /** @test */
    public function store_new_rejects_invalid_initial_condition(): void
    {
        $payload = $this->validPayload(['initial_condition' => 'OddValue']);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $payload)
             ->assertStatus(422)
             ->assertJsonValidationErrors(['initial_condition']);
    }

    /** @test */
    public function store_new_rejects_future_purchase_date(): void
    {
        $payload = $this->validPayload([
            'tyre_purchase_date' => now()->addDays(7)->toDateString(),
        ]);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $payload)
             ->assertStatus(422)
             ->assertJsonValidationErrors(['tyre_purchase_date']);
    }

    /** @test */
    public function store_new_rejects_duplicate_serial_number(): void
    {
        $first = $this->validPayload();
        $this->actingAs($this->user)->postJson(route('tyre.saveNew'), $first);

        $dup = $this->validPayload([
            'tyre_serial_number' => $first['tyre_serial_number'],
        ]);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $dup)
             ->assertStatus(422)
             ->assertJsonValidationErrors(['tyre_serial_number']);
    }

    /** @test */
    public function store_new_requires_at_least_one_image(): void
    {
        $payload = $this->validPayload(['files' => []]);

        $this->actingAs($this->user)
             ->postJson(route('tyre.saveNew'), $payload)
             ->assertStatus(422)
             ->assertJsonValidationErrors(['files']);
    }

    /** @test */
    public function store_new_forces_warehouse_status_at_creation(): void
    {
        $payload = $this->validPayload();
        $this->actingAs($this->user)->postJson(route('tyre.saveNew'), $payload);

        $tyre = Tyre::where('tyre_serial_number', $payload['tyre_serial_number'])->first();
        $this->assertEquals('Warehouse', $tyre->current_status);  // BR-3
        $this->assertEquals('Warehouse', $tyre->stock_status);
    }

    /** @test */
    public function store_new_persists_reminder_toggles_as_yes(): void
    {
        $payload = $this->validPayload();
        $this->actingAs($this->user)->postJson(route('tyre.saveNew'), $payload);

        $tyre = Tyre::where('tyre_serial_number', $payload['tyre_serial_number'])->first();
        $this->assertEquals('Yes', $tyre->set_reminder_for_alignment);
        $this->assertEquals('Yes', $tyre->set_reminder_for_rotation);
    }
}
