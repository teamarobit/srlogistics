<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * ─────────────────────────────────────────────────────────────
 * FEATURE TEST AGENT (FTA) — Warehouse Module
 * ─────────────────────────────────────────────────────────────
 * HTTP-level tests against real MySQL schema (sr_logistics_test).
 * Uses DatabaseTransactions — every test rolled back automatically.
 *
 * Routes tested:
 *   GET    /warehouse/master                  → index
 *   GET    /warehouse/master/create           → create
 *   POST   /warehouse/master                  → store
 *   GET    /warehouse/master/{id}/edit        → edit
 *   PUT    /warehouse/master/{id}             → update
 *   DELETE /warehouse/master/{id}             → destroy (JSON)
 *   GET    /get-cities-by-state/{stateId}     → getCitiesByState (JSON)
 * ─────────────────────────────────────────────────────────────
 */
class WarehouseFeatureTest extends TestCase
{
    use DatabaseTransactions;

    private User  $user;
    private State $state;

    protected function setUp(): void
    {
        parent::setUp();

        // Use a real seeded state — Maharashtra is always present from CountryStateCitySeeder
        $this->state = State::where('name', 'Maharashtra')->first()
                    ?? State::first();

        // Use a real seeded user — avoids creating users which requires organisation_id NOT NULL.
        // All seeded users have organisation_id = 1. No data is written; safe to reuse across tests.
        $this->user = User::where('is_active', 'Yes')->first();

        if (! $this->user) {
            $this->markTestSkipped('No active user found in DB. Run: php artisan db:seed --class=UserSeeder');
        }
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'            => 'QA Test Warehouse ' . uniqid(),
            'warehouse_type'  => 'Central',
            'address'         => '123 QA Test Road',
            'state_id'        => $this->state->id,
            'city_name'       => 'QATestCity',
            'location_name'   => 'QA Zone',
            'pincode'         => '400001',
            'contact_number'  => '9876543210',
            'storage_type'    => 'Rack',
            'status'          => 'Active',
            'notes'           => '',
        ], $overrides);
    }

    private function makeWarehouse(array $data = []): Warehouse
    {
        return Warehouse::create(array_merge([
            'warehouse_code' => 'WH-QA' . uniqid(),
            'name'           => 'QA WH ' . uniqid(),
            'warehouse_type' => 'Regional',
            'address'        => '99 QA Seeded St',
            'state_id'       => $this->state->id,
            'city_name'      => 'QASeedCity',
            'storage_type'   => 'Floor',
            'status'         => 'Active',
        ], $data));
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // AUTH GUARD
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function unauthenticated_user_is_redirected_from_index(): void
    {
        $this->get(route('warehouse.master.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthenticated_user_is_redirected_from_create(): void
    {
        $this->get(route('warehouse.master.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthenticated_post_to_store_is_redirected(): void
    {
        // Plain POST (not JSON) still redirects unauthenticated users to login
        $this->post(route('warehouse.master.store'), $this->validPayload())
             ->assertRedirect(route('login'));
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // INDEX
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function index_page_returns_200_for_authenticated_user(): void
    {
        $this->actingAs($this->user)
             ->get(route('warehouse.master.index'))
             ->assertStatus(200)
             ->assertViewIs('warehouse.index');
    }

    /** @test */
    public function index_view_has_warehouses_variable(): void
    {
        $this->actingAs($this->user)
             ->get(route('warehouse.master.index'))
             ->assertViewHas('warehouses');
    }

    /** @test */
    public function index_shows_created_warehouse_name(): void
    {
        $uniqueName = 'QA Index WH ' . uniqid();
        $this->makeWarehouse(['name' => $uniqueName]);

        $this->actingAs($this->user)
             ->get(route('warehouse.master.index'))
             ->assertSee($uniqueName);
    }

    /** @test */
    public function index_does_not_show_soft_deleted_warehouse(): void
    {
        $uniqueName = 'QA Deleted WH ' . uniqid();
        $wh = $this->makeWarehouse(['name' => $uniqueName]);
        $wh->delete();

        $this->actingAs($this->user)
             ->get(route('warehouse.master.index'))
             ->assertDontSee($uniqueName);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // CREATE
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function create_page_returns_200(): void
    {
        $this->actingAs($this->user)
             ->get(route('warehouse.master.create'))
             ->assertStatus(200)
             ->assertViewIs('warehouse.create');
    }

    /** @test */
    public function create_page_passes_states_and_managers_to_view(): void
    {
        $this->actingAs($this->user)
             ->get(route('warehouse.master.create'))
             ->assertViewHas('states')
             ->assertViewHas('managers');
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // STORE — happy path (SD-3: store/update return JSON, tested with postJson)
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function store_creates_warehouse_and_returns_json_success(): void
    {
        $payload = $this->validPayload();

        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $payload)
             ->assertStatus(200)
             ->assertJson(['success' => true]);

        $this->assertDatabaseHas('warehouses', [
            'name'           => $payload['name'],
            'warehouse_type' => 'Central',
            'state_id'       => $this->state->id,
            'city_name'      => 'QATestCity',
        ]);
    }

    /** @test */
    public function store_auto_assigns_wh_nnn_warehouse_code(): void
    {
        $payload = $this->validPayload();
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $payload);

        $wh = Warehouse::where('name', $payload['name'])->first();
        $this->assertNotNull($wh);
        $this->assertMatchesRegularExpression('/^WH-\d{3,}$/', $wh->warehouse_code);
    }

    /** @test */
    public function store_sets_created_by_to_logged_in_user(): void
    {
        $payload = $this->validPayload();
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $payload);

        $this->assertDatabaseHas('warehouses', [
            'name'       => $payload['name'],
            'created_by' => $this->user->id,
        ]);
    }

    /** @test */
    public function store_inserts_new_city_into_cities_table(): void
    {
        $newCity = 'QACity' . uniqid();
        $this->assertDatabaseMissing('cities', ['name' => $newCity]);

        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['city_name' => $newCity]));

        $this->assertDatabaseHas('cities', [
            'name'     => $newCity,
            'state_id' => $this->state->id,
        ]);
    }

    /** @test */
    public function store_does_not_duplicate_existing_city(): void
    {
        $cityName = 'QAExistingCity' . uniqid();
        City::create(['name' => $cityName, 'state_id' => $this->state->id]);

        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['city_name' => $cityName]));

        $count = City::where('name', $cityName)->where('state_id', $this->state->id)->count();
        $this->assertSame(1, $count);
    }

    /** @test */
    public function store_response_contains_redirect_url(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload())
             ->assertStatus(200)
             ->assertJsonPath('redirect', route('warehouse.master.index'));
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // STORE — validation failures (422 JSON, not session errors — SD-3)
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function store_fails_when_name_is_empty(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['name' => '']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function store_fails_when_warehouse_type_is_invalid(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['warehouse_type' => 'SuperStore']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('warehouse_type');
    }

    /** @test */
    public function store_fails_when_state_id_does_not_exist(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['state_id' => 999999]))
             ->assertStatus(422)
             ->assertJsonValidationErrors('state_id');
    }

    /** @test */
    public function store_fails_when_city_name_is_empty(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['city_name' => '']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('city_name');
    }

    /** @test */
    public function store_fails_when_address_is_empty(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['address' => '']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('address');
    }

    /** @test */
    public function store_fails_when_status_is_invalid(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['status' => 'Pending']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('status');
    }

    /** @test */
    public function store_fails_when_storage_type_is_invalid(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['storage_type' => 'Container']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('storage_type');
    }

    /** @test */
    public function store_fails_when_contact_number_contains_letters(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['contact_number' => 'ABC1234']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('contact_number');
    }

    /** @test */
    public function store_fails_when_contact_number_is_too_short(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['contact_number' => '123']))
             ->assertStatus(422)
             ->assertJsonValidationErrors('contact_number');
    }

    /** @test */
    public function store_fails_on_duplicate_warehouse_name(): void
    {
        $name = 'QA Dupe WH ' . uniqid();
        $this->makeWarehouse(['name' => $name]);

        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $this->validPayload(['name' => $name]))
             ->assertStatus(422)
             ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function store_succeeds_when_all_optional_fields_are_null(): void
    {
        $payload = $this->validPayload([
            'location_name'      => null,
            'pincode'            => null,
            'contact_number'     => null,
            'storage_type'       => null,
            'notes'              => null,
            'manager_contact_id' => null,
        ]);

        $this->actingAs($this->user)
             ->postJson(route('warehouse.master.store'), $payload)
             ->assertStatus(200)
             ->assertJson(['success' => true]);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // EDIT
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function edit_page_returns_200_for_valid_warehouse(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->get(route('warehouse.master.edit', $wh->id))
             ->assertStatus(200)
             ->assertViewIs('warehouse.edit');
    }

    /** @test */
    public function edit_page_passes_required_view_variables(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->get(route('warehouse.master.edit', $wh->id))
             ->assertViewHas('wh')
             ->assertViewHas('states')
             ->assertViewHas('managers')
             ->assertViewHas('cities');
    }

    /** @test */
    public function edit_page_returns_404_for_nonexistent_warehouse(): void
    {
        $this->actingAs($this->user)
             ->get(route('warehouse.master.edit', 9999999))
             ->assertStatus(404);
    }

    /** @test */
    public function edit_page_returns_404_for_soft_deleted_warehouse(): void
    {
        $wh = $this->makeWarehouse();
        $wh->delete();

        $this->actingAs($this->user)
             ->get(route('warehouse.master.edit', $wh->id))
             ->assertStatus(404);
    }

    /** @test */
    public function edit_view_wh_matches_requested_warehouse(): void
    {
        $wh = $this->makeWarehouse();

        $response = $this->actingAs($this->user)
                         ->get(route('warehouse.master.edit', $wh->id));

        $this->assertSame($wh->id, $response->viewData('wh')->id);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // UPDATE — happy path (SD-3: returns JSON)
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function update_saves_new_values_and_returns_json_success(): void
    {
        $wh      = $this->makeWarehouse();
        $newName = 'QA Updated WH ' . uniqid();

        $this->actingAs($this->user)
             ->putJson(route('warehouse.master.update', $wh->id), $this->validPayload(['name' => $newName]))
             ->assertStatus(200)
             ->assertJson(['success' => true]);

        $this->assertDatabaseHas('warehouses', ['id' => $wh->id, 'name' => $newName]);
    }

    /** @test */
    public function update_sets_updated_by_to_authenticated_user(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->putJson(route('warehouse.master.update', $wh->id), $this->validPayload());

        $this->assertDatabaseHas('warehouses', [
            'id'         => $wh->id,
            'updated_by' => $this->user->id,
        ]);
    }

    /** @test */
    public function update_allows_same_name_on_own_record(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->putJson(route('warehouse.master.update', $wh->id), $this->validPayload(['name' => $wh->name]))
             ->assertStatus(200)
             ->assertJson(['success' => true]);
    }

    /** @test */
    public function update_blocks_name_that_conflicts_with_another_warehouse(): void
    {
        $other = $this->makeWarehouse(['name' => 'QA Other WH ' . uniqid()]);
        $wh    = $this->makeWarehouse(['name' => 'QA My WH ' . uniqid()]);

        $this->actingAs($this->user)
             ->putJson(route('warehouse.master.update', $wh->id), $this->validPayload(['name' => $other->name]))
             ->assertStatus(422)
             ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function update_inserts_new_city_if_not_in_cities_table(): void
    {
        $wh      = $this->makeWarehouse();
        $newCity = 'QAUpdateCity' . uniqid();

        $this->assertDatabaseMissing('cities', ['name' => $newCity]);

        $this->actingAs($this->user)
             ->putJson(route('warehouse.master.update', $wh->id), $this->validPayload(['city_name' => $newCity]));

        $this->assertDatabaseHas('cities', ['name' => $newCity, 'state_id' => $this->state->id]);
    }

    /** @test */
    public function update_returns_422_for_nonexistent_warehouse(): void
    {
        // SD-8: AJAX methods use find() + 422, not findOrFail() + 404
        $this->actingAs($this->user)
             ->putJson(route('warehouse.master.update', 9999999), $this->validPayload())
             ->assertStatus(422)
             ->assertJson(['success' => false]);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // DESTROY
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function destroy_soft_deletes_and_returns_json_success(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->deleteJson(route('warehouse.master.destroy', $wh->id))
             ->assertStatus(200)
             ->assertJson(['success' => true]);
    }

    /** @test */
    public function destroy_makes_warehouse_invisible_in_default_query(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->deleteJson(route('warehouse.master.destroy', $wh->id));

        $this->assertNull(Warehouse::find($wh->id));
    }

    /** @test */
    public function destroy_warehouse_still_visible_with_trashed(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->deleteJson(route('warehouse.master.destroy', $wh->id));

        $this->assertNotNull(Warehouse::withTrashed()->find($wh->id));
    }

    /** @test */
    public function destroy_sets_deleted_by_to_authenticated_user(): void
    {
        $wh = $this->makeWarehouse();

        $this->actingAs($this->user)
             ->deleteJson(route('warehouse.master.destroy', $wh->id));

        $this->assertDatabaseHas('warehouses', [
            'id'         => $wh->id,
            'deleted_by' => $this->user->id,
        ]);
    }

    /** @test */
    public function destroy_returns_422_for_nonexistent_warehouse(): void
    {
        // SD-8: AJAX methods use find() + 422, not findOrFail() + 404
        $this->actingAs($this->user)
             ->deleteJson(route('warehouse.master.destroy', 9999999))
             ->assertStatus(422)
             ->assertJson(['success' => false]);
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // GET CITIES BY STATE
    // ═══════════════════════════════════════════════════════════════════════════

    /** @test */
    public function get_cities_by_state_returns_json_for_valid_state(): void
    {
        $response = $this->actingAs($this->user)
                         ->getJson(route('warehouse.cities.by-state', $this->state->id));

        $response->assertStatus(200);

        $data = $response->json();
        if (count($data) > 0) {
            // Only assert structure when cities exist — assertJsonStructure fails on empty array
            $response->assertJsonStructure([['id', 'name']]);
        } else {
            $this->markTestSkipped('No cities seeded for state ' . $this->state->name . ' — run CountryStateCitySeeder first.');
        }
    }

    /** @test */
    public function get_cities_by_state_returns_empty_array_for_state_with_no_cities(): void
    {
        // Use a state ID that definitely has no cities — we'll create a temp state
        // Actually safer: find a real state that has cities and verify structure
        // Use nonexistent state ID for empty test
        $response = $this->actingAs($this->user)
                         ->getJson(route('warehouse.cities.by-state', 999999));

        $response->assertStatus(200);
        $response->assertExactJson([]);
    }

    /** @test */
    public function get_cities_by_state_response_contains_id_and_name_fields(): void
    {
        // Maharashtra has many cities from seeder
        $response = $this->actingAs($this->user)
                         ->getJson(route('warehouse.cities.by-state', $this->state->id));

        $response->assertStatus(200);
        $data = $response->json();

        if (count($data) > 0) {
            $this->assertArrayHasKey('id', $data[0]);
            $this->assertArrayHasKey('name', $data[0]);
        } else {
            $this->markTestSkipped('No cities found for state ' . $this->state->name . ' in test DB.');
        }
    }

    /** @test */
    public function get_cities_by_state_results_are_alphabetically_ordered(): void
    {
        $response = $this->actingAs($this->user)
                         ->getJson(route('warehouse.cities.by-state', $this->state->id));

        $names = collect($response->json())->pluck('name')->values()->toArray();

        if (count($names) < 2) {
            $this->markTestSkipped('Need at least 2 cities to test ordering.');
        }

        // Assert each city name is <= the next one (case-insensitive).
        // This matches what MySQL ORDER BY name guarantees without replicating collation in PHP.
        for ($i = 0; $i < count($names) - 1; $i++) {
            $this->assertLessThanOrEqual(
                0,
                strcasecmp($names[$i], $names[$i + 1]),
                "City '{$names[$i]}' should come before '{$names[$i + 1]}' in alphabetical order."
            );
        }
    }
}
