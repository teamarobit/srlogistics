@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Warehouse/form.css?v=1.1') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">

            @include('includes.leftbar')

            <div class="main-wrap">

                <div class="container-fluid page-head">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="wh-breadcrumb">
                                <a href="{{ route('adminconsole.index') }}">Admin Console</a>
                                <span class="sep">›</span>
                                <a href="{{ route('warehouse.master.index') }}">Warehouse Master</a>
                                <span class="sep">›</span>
                                Edit — {{ $wh->name }}
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-0">Edit Warehouse</h5>
                                <span class="wh-code">{{ $wh->warehouse_code }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid mt-3" style="max-width: 860px;">
                    {{--
                        SD-1: No inline JS. Config passed via data-* attributes.
                        SD-3: Form submitted via $.ajax() in edit.js.
                    --}}
                    <form id="whEditForm"
                          action="{{ route('warehouse.master.update', $wh->id) }}"
                          method="POST"
                          novalidate
                          data-cities-url="{{ route('warehouse.cities.by-state', '__STATE_ID__') }}"
                          data-saved-state="{{ $wh->state_id }}"
                          data-saved-city="{{ $wh->city_name }}"
                          data-index-url="{{ route('warehouse.master.index') }}">
                        @csrf
                        @method('PUT')

                        {{-- ── Basic Info ─────────────────────────── --}}
                        <div class="wh-form-card">
                            <p class="wh-section-title">Basic Information</p>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Warehouse Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                           name="name" id="wh_name" value="{{ old('name', $wh->name) }}"
                                           maxlength="100" placeholder="e.g. Hyderabad Central Warehouse">
                                    @error('name')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Warehouse Type <span class="text-danger">*</span></label>
                                    <select class="form-select" name="warehouse_type" id="wh_type">
                                        <option value="">Select Type</option>
                                        <option value="Central"   {{ old('warehouse_type', $wh->warehouse_type) === 'Central'   ? 'selected' : '' }}>Central</option>
                                        <option value="Regional"  {{ old('warehouse_type', $wh->warehouse_type) === 'Regional'  ? 'selected' : '' }}>Regional</option>
                                        <option value="Site/Yard" {{ old('warehouse_type', $wh->warehouse_type) === 'Site/Yard' ? 'selected' : '' }}>Site / Yard</option>
                                    </select>
                                    @error('warehouse_type')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ── Location ───────────────────────────── --}}
                        <div class="wh-form-card">
                            <p class="wh-section-title">Location</p>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control"
                                              name="address" id="wh_address" rows="2" maxlength="500"
                                              placeholder="Full address">{{ old('address', $wh->address) }}</textarea>
                                    @error('address')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select class="form-select select2"
                                            name="state_id" id="wh_state_id" style="width:100%;">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}"
                                                {{ old('state_id', $wh->state_id) == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state_id')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select class="form-select"
                                            name="city_name" id="wh_city_name" style="width:100%;">
                                        {{-- Existing cities for this state pre-loaded --}}
                                        @foreach($cities as $c)
                                            <option value="{{ $c->name }}"
                                                {{ old('city_name', $wh->city_name) === $c->name ? 'selected' : '' }}>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                        {{-- If saved city_name not in table, add it as option --}}
                                        @if($wh->city_name && !$cities->firstWhere('name', $wh->city_name))
                                            <option value="{{ $wh->city_name }}" selected>{{ $wh->city_name }}</option>
                                        @endif
                                    </select>
                                    <div class="wh-city-hint">Type city name — existing cities will appear. New cities are saved automatically.</div>
                                    @error('city_name')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location Name</label>
                                    <input type="text" class="form-control" name="location_name" id="wh_location_name"
                                           value="{{ old('location_name', $wh->location_name) }}" maxlength="150"
                                           placeholder="Landmark / area / zone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" class="form-control numberonly" name="pincode" id="wh_pincode"
                                           value="{{ old('pincode', $wh->pincode) }}" maxlength="10"
                                           placeholder="e.g. 500001">
                                </div>
                            </div>
                        </div>

                        {{-- ── Contact & Operations ───────────────── --}}
                        <div class="wh-form-card">
                            <p class="wh-section-title">Contact & Operations</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Manager</label>
                                    <select class="form-select select2"
                                            name="manager_contact_id" id="wh_manager_contact_id" style="width:100%;">
                                        <option value="">Select Manager</option>
                                        @foreach($managers as $mgr)
                                            <option value="{{ $mgr->id }}"
                                                {{ old('manager_contact_id', $wh->manager_contact_id) == $mgr->id ? 'selected' : '' }}>
                                                {{ $mgr->contact_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('manager_contact_id')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    {{-- SD-13: intl-tel-input, default country IN (+91). Init in edit.js. --}}
                                    <input type="tel" class="form-control"
                                           name="contact_number" id="wh_contact_number"
                                           value="{{ old('contact_number', $wh->contact_number) }}"
                                           placeholder="9876543210"
                                           data-intl-phone="1">
                                    @error('contact_number')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Storage Type</label>
                                    <select class="form-select" name="storage_type" id="wh_storage_type">
                                        <option value="">Select Storage Type</option>
                                        <option value="Rack"      {{ old('storage_type', $wh->storage_type) === 'Rack'       ? 'selected' : '' }}>Rack</option>
                                        <option value="Floor"     {{ old('storage_type', $wh->storage_type) === 'Floor'      ? 'selected' : '' }}>Floor</option>
                                        <option value="Open Yard" {{ old('storage_type', $wh->storage_type) === 'Open Yard'  ? 'selected' : '' }}>Open Yard</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" id="wh_status">
                                        <option value="Active"   {{ old('status', $wh->status) === 'Active'   ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', $wh->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" id="wh_notes" rows="2"
                                              maxlength="500" placeholder="Any additional notes…">{{ old('notes', $wh->notes) }}</textarea>
                                </div>
                            </div>

                            <div class="wh-form-footer">
                                <button type="submit" class="btn btn-primary" id="btnSave">
                                    <span id="btnSaveText">Update Warehouse</span>
                                    <span id="btnSaveSpinner" class="spinner-border spinner-border-sm ms-1 d-none" role="status"></span>
                                </button>
                                <a href="{{ route('warehouse.master.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{{-- SD-1: All JS in external file. Blade config passed via data-* attributes on #whEditForm. --}}
{{-- SD-13: intl-tel-input must load before edit.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script src="{{ asset('js/Warehouse/edit.js?v=1.2') }}"></script>
@endsection
