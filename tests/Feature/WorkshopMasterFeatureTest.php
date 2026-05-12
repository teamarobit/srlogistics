<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Workshop;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

/**
 * ─────────────────────────────────────────────────────────────
 * FEATURE TEST — Workshop Master Module (State/City FK Feature)
 * SCR-WS-M-001 | BA approved 2026-04-30
 * ─────────────────────────────────────────────────────────────
 * HTTP-level tests against real MySQL schema.
 * Uses DatabaseTransactions — every test rolled back automatically.
 *
 * Routes tested:
 *   GET    /workshop/master/workshops              → masterWorkshops
 *   POST   /workshop/master/workshops              → masterWorkshopStore
 *   PUT    /workshop/master/workshops/{id}         → masterWorkshopUpdate
 *   DELETE /workshop/master/workshops/{id}         → masterWorkshopDestroy
 *   GET    /workshop/master/workshops/cities       → masterWorkshopCities
 *
 * Standards: QA-1 to QA-6, SD-5, SD-8, SD-9, SD-12
 * ─────────────────────────────────────────────────────────────
 */
class WorkshopMasterFeatureTest extends TestCase
{
    use DatabaseTransactions;

    private User  $user;
    private State $state;

    // ─── QA-1: Standard setUp ────────────────────────────────────────────────

    protected function setUp(): void
    {
        parent::setUp();

        // Bypass CSRF for all POST/PUT/DELETE feature test requests
        $this->withoutMiddleware(ValidateCsrfToken::class);

        // India state — always seeded via CountryStateCitySeeder
        $this->state = State::where('name', 'Telangana')->first()
                    ?? State::where('country_id', 101)->first()
                    ?? State::first();

        // QA-1: use seeded user — never create (organisation_id NOT NULL constraint)
        $this->user = User::where('is_active', 'Yes')->first();

        if (! $this->user) {
            $this->markTestSkipped('No active user. Run: php artisan db:seed --class=UserSeeder');
        }

        if (! $this->state) {
            $this->markTestSkipped('No states seeded. Run: php artisan db:seed --class=CountryStateCitySeeder');
        }
    }

    // ─── QA-2: Standard validPayload ─────────────────────────────────────────

    /**
     * HTTP payload for store/update — city is a name string (resolved by controller).
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'QA Workshop ' . uniqid(),
            'ownership'        => 'Own',           // SD-11: Title Case ENUM
            'workshop_type'    => 'Workshop',      // SD-11: Title Case ENUM
            'state_id'         => $this->state->id,
            'city'             => 'QA City ' . uniqid(),
            'technician_count' => 3,
            'contact_phone'    => '+919876543210', // SD-13: E.164 format
        ], $overrides);
    }

    /**
     * Create a Workshop row directly (bypasses controller, uses city_id FK).
     * Used in update/destroy/relationship tests as a pre-condition fixture.
     */
    private function makeWorkshop(array $overrides = []): Workshop
    {
        $city = City::firstOrCreate([
            'state_id' => $this->state->id,
            'name'     => 'QA-Fixture-City',
        ]);

        return Workshop::create(array_merge([
            'workshop_code'   => Workshop::nextWorkshopCode('Own', 'QAFix'),
            'name'            => 'QA Workshop ' . uniqid(),
            'ownership'       => 'Own',
            'workshop_type'   => 'Workshop',
            'state_id'        => $this->state->id,
            'city_id'         => $city->id,
            'technician_count'=> 3,
            'contact_phone'   => '+919876543210',
            'organisation_id' => $this->user->organisation_id ?? 1,
            'created_by'      => $this->user->id,
            'status'          => 'Active',
        ], $overrides));
    }

    // ─── LIST ────────────────────────────────────────────────────────────────

    /** QA-3: Descriptive method name */
    public function test_index_loads_for_authenticated_user(): void
    {
        $this->actingAs($this->user)
             ->get(route('ws.master.workshops'))
             ->assertOk()
             ->assertViewIs('ws.master-workshops')
             ->assertViewHas('workshops')
             ->assertViewHas('states');
    }

    public function test_index_contains_india_states_only(): void
    {
        $response = $this->actingAs($this->user)
                         ->get(route('ws.master.workshops'));

        $states = $response->viewData('states');

        $this->assertNotEmpty($states, 'States collection must not be empty');
        // All returned states must belong to India (country_id=101)
        foreach ($states as $s) {
            $this->assertEquals(
                101,
                $s->country_id,
                "State {$s->name} must belong to country_id 101 (India)"
            );
        }
    }

    public function test_index_redirects_unauthenticated_user(): void
    {
        $this->get(route('ws.master.workshops'))
             ->assertRedirect();
    }

    // ─── CITIES AJAX ─────────────────────────────────────────────────────────

    public function test_cities_endpoint_returns_cities_for_valid_state(): void
    {
        $this->actingAs($this->user)
             ->getJson(route('ws.master.workshops.cities', ['state_id' => $this->state->id]))
             ->assertOk()
             ->assertJsonIsArray();
    }

    public function test_cities_endpoint_returns_empty_array_when_no_state_id(): void
    {
        $this->actingAs($this->user)
             ->getJson(route('ws.master.workshops.cities'))
             ->assertOk()
             ->assertExactJson([]);
    }

    public function test_cities_endpoint_returns_name_and_id_fields(): void
    {
        // Get a state that has cities
        $stateWithCities = State::whereHas('cities')->where('country_id', 101)->first();

        if (! $stateWithCities) {
            $this->markTestSkipped('No states with cities in DB.');
        }

        $response = $this->actingAs($this->user)
                         ->getJson(route('ws.master.workshops.cities', ['state_id' => $stateWithCities->id]))
                         ->assertOk();

        $data = $response->json();
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id',   $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
    }

    // ─── STORE ───────────────────────────────────────────────────────────────

    public function test_store_creates_workshop_with_state_id_and_city_id(): void
    {
        $payload = $this->validPayload();

        $this->actingAs($this->user)
             ->postJson(route('ws.master.workshops.store'), $payload)
             ->assertOk()
             ->assertJson(['success' => true]);

        $workshop = Workshop::where('name', $payload['name'])->first();
        $this->assertNotNull($workshop, 'Workshop should be saved in DB');
        $this->assertEquals($this->state->id, $workshop->state_id);
        $this->assertNotNull($workshop->city_id, 'city_id must be resolved and stored');
    }

    /** QA-4: organisation_id must never be null (SD-12) */
    public function test_store_sets_organisation_id_from_authenticated_user(): void
    {
        $payload = $this->validPayload();

        $this->actingAs($this->user)
             ->postJson(route('ws.master.workshops.store'), $payload);

        $workshop = Workshop::where('name', $payload['name'])->first();
        $this->assertNotNull($workshop);
        $this->assertNotNull($workshop->organisation_id, 'organisation_id must never be null (SD-12)');
    }

    public function test_store_creates_new_city_if_not_in_cities_table(): void
    {
        $uniqueCity = 'QA_NewCity_' . uniqid();
        $payload    = $this->validPayload(['city' => $uniqueCity]);

        $this->assertNull(
            City::where('state_id', $this->state->id)->where('name', $uniqueCity)->first(),
            'City should not exist before test'
        );

        $this->actingAs($this->user)
             ->postJson(route('ws.master.workshops.store'), $payload)
             ->assertOk()
             ->assertJson(['success' => true]);

        $this->assertNotNull(
            City::where('state_id', $this->state->id)->where('name', $uniqueCity)->first(),
            'City must be auto-created via firstOrCreate'
        );
    }

    public function test_store_reuses_existing_city_id(): void
    {
        // Pre-create a city
        $city = City::firstOrCreate(['state_id' => $this->state->id, 'name' => 'ExistingCityQA']);

        $cityCountBefore = City::where('state_id', $this->state->id)->where('name', 'ExistingCityQA')->count();

        $this->actingAs($this->user)
             ->postJson(route('ws.master.workshops.store'), $this->validPayload(['city' => 'ExistingCityQA']))
             ->assertOk();

        // No duplicate city created
        $cityCountAfter = City::where('state_id', $this->state->id)->where('name', 'ExistingCityQA')->count();
        $this->assertEquals($cityCountBefore, $cityCountAfter, 'Existing city must not be duplicated');

        $workshop = Workshop::whereNotNull('city_id')->latest('id')->first();
        $this->assertEquals($city->id, $workshop->city_id, 'Workshop must use existing city_id');
    }

    public function test_store_fails_validation_when_name_missing(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('ws.master.workshops.store'), $this->validPayload(['name' => '']))
             ->assertStatus(422)
             ->assertJsonValidationErrors(['name']);
    }

    public function test_store_fails_validation_when_state_id_invalid(): void
    {
        $this->actingAs($this->user)
             ->postJson(route('ws.master.workshops.store'), $this->validPayload(['state_id' => 99999]))
             ->assertStatus(422)
             ->assertJsonValidationErrors(['state_id']);
    }

    public function test_store_works_without_state_and_city(): void
    {
        $payload = $this->validPayload(['state_id' => null, 'city' => null]);

        $this->actingAs($this->user)
             ->postJson(route('ws.master.workshops.store'), $payload)
             ->assertOk()
             ->assertJson(['success' => true]);

        $workshop = Workshop::where('name', $payload['name'])->first();
        $this->assertNotNull($workshop);
        $this->assertNull($workshop->state_id);
        $this->assertNull($workshop->city_id);
    }

    // ─── UPDATE ──────────────────────────────────────────────────────────────

    public function test_update_resolves_new_city_and_stores_city_id(): void
    {
        $workshop = $this->makeWorkshop(['workshop_code' => Workshop::nextWorkshopCode('Own', 'TestCity')]);
        $newCity  = 'QA_UpdateCity_' . uniqid();

        $this->actingAs($this->user)
             ->putJson(route('ws.master.workshops.update', $workshop->id), $this->validPayload(['city' => $newCity]))
             ->assertOk()
             ->assertJson(['success' => true]);

        $workshop->refresh();
        $this->assertNotNull($workshop->city_id);

        $createdCity = City::find($workshop->city_id);
        $this->assertNotNull($createdCity);
        $this->assertEquals($newCity, $createdCity->name);
    }

    public function test_update_returns_correct_state_and_city_via_relationship(): void
    {
        $workshop = $this->makeWorkshop(['workshop_code' => Workshop::nextWorkshopCode('Own', 'RelTest')]);

        $this->actingAs($this->user)
             ->putJson(route('ws.master.workshops.update', $workshop->id), $this->validPayload(['city' => 'Hyderabad']))
             ->assertOk();

        $workshop->refresh()->load(['state', 'city']);
        $this->assertEquals($this->state->id,   $workshop->state_id);
        $this->assertEquals('Hyderabad',         $workshop->city->name);
        $this->assertEquals($this->state->name,  $workshop->state->name);
    }

    /** SD-8: update returns 422 JSON for missing record — not HTML 404 */
    public function test_update_returns_422_json_when_workshop_not_found(): void
    {
        $this->actingAs($this->user)
             ->putJson(route('ws.master.workshops.update', 99999), $this->validPayload())
             ->assertStatus(422)
             ->assertJson(['success' => false]);
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────

    /** QA-5: destroy returns 422 JSON (SD-8 — not HTML 404) */
    public function test_destroy_returns_422_json_when_not_found(): void
    {
        $this->actingAs($this->user)
             ->deleteJson(route('ws.master.workshops.destroy', 99999))
             ->assertStatus(422)
             ->assertJson(['success' => false]);
    }

    public function test_destroy_soft_deletes_workshop(): void
    {
        $workshop = $this->makeWorkshop(['workshop_code' => Workshop::nextWorkshopCode('Own', 'DelTest')]);

        $this->actingAs($this->user)
             ->deleteJson(route('ws.master.workshops.destroy', $workshop->id))
             ->assertOk()
             ->assertJson(['success' => true]);

        $this->assertSoftDeleted('workshops', ['id' => $workshop->id]);
    }

    // ─── RELATIONSHIPS ───────────────────────────────────────────────────────

    public function test_workshop_state_relationship_returns_state_model(): void
    {
        $city = City::where('state_id', $this->state->id)->first()
            ?? City::create(['state_id' => $this->state->id, 'name' => 'RelTestCity' . uniqid()]);

        $workshop = Workshop::create([
            'workshop_code'   => Workshop::nextWorkshopCode('Own', 'Rel'),
            'name'            => 'Relationship Test WS',
            'ownership'       => 'Own',
            'workshop_type'   => 'Workshop',
            'state_id'        => $this->state->id,
            'city_id'         => $city->id,
            'organisation_id' => $this->user->organisation_id ?? 1,
            'created_by'      => $this->user->id,
            'status'          => 'Active',
        ]);

        $this->assertEquals($this->state->id,   $workshop->state->id);
        $this->assertEquals($this->state->name, $workshop->state->name);
        $this->assertEquals($city->id,          $workshop->city->id);
        $this->assertEquals($city->name,        $workshop->city->name);
    }
}
