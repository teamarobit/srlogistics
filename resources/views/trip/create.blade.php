@extends('layouts.app')

@section('css')
<link href="{{ asset('css/trip/create.css?v=2.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="trip-create-bd srlog-bdwrapper">

        {{-- Page Header --}}
        <div class="top-text">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div>
                    <h1>Create Trip</h1>
                    <div class="tc-breadcrumb">Freight &rsaquo; Trips &rsaquo; New Trip</div>
                </div>
                <a href="{{ route('trip.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="uil uil-arrow-left me-1"></i>Back to Trips
                </a>
            </div>
        </div>

        <div class="container-fluid mt-4 pb-4">

            <form id="createTripForm"
                  action="{{ route('trip.store') }}"
                  method="POST"
                  data-index-url="{{ route('trip.index') }}"
                  data-sizes-url="{{ route('trip.vehicle.sizes', ['vehicletype_id' => '__ID__']) }}">
                @csrf

                <div class="row g-4 align-items-start">

                    {{-- ===== LEFT COLUMN ===== --}}
                    <div class="col-lg-8">

                        {{-- Section: Trip Information --}}
                        <div class="tc-section-card mb-4">
                            <div class="tc-section-header">
                                <div class="tc-section-icon tc-icon-blue">
                                    <i class="uil uil-clipboard-notes"></i>
                                </div>
                                <div>
                                    <h6 class="tc-section-title">Trip Information</h6>
                                    <p class="tc-section-sub">Basic trip details and classification</p>
                                </div>
                            </div>
                            <div class="tc-section-body">
                                <div class="row g-3">

                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Trip ID</label>
                                        <input type="text" class="form-control bg-light" readonly placeholder="Will be auto generated" />
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Trip Date <span class="text-danger">*</span></label>
                                        <input type="text" id="trip_date" name="trip_date" class="form-control" placeholder="DD/MM/YYYY" autocomplete="off">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Trip Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="trip_type" id="trip_type">
                                            <option value="">Choose..</option>
                                            <option value="Own">Own Booking</option>
                                            <option value="Rental">Rental</option>
                                            <option value="External">External</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Internal Trip ID</label>
                                        <input type="text" class="form-control" name="internal_trip_id" id="internal_trip_id" />
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Trip Category</label>
                                        <div class="tc-radio-group">
                                            <label class="tc-radio-chip">
                                                <input type="radio" name="trip_category" id="tc_line" value="Line">
                                                <span><i class="uil uil-road me-1"></i>Line</span>
                                            </label>
                                            <label class="tc-radio-chip">
                                                <input type="radio" name="trip_category" id="tc_local" value="Local">
                                                <span><i class="uil uil-map-marker me-1"></i>Local</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="form-label">RAG Status</label>
                                        <div class="d-flex align-items-center gap-2" style="min-height:38px;">
                                            <span class="badge bg-danger rag-btn" data-value="Red">Red</span>
                                            <span class="badge bg-warning rag-btn" data-value="Yellow">Yellow</span>
                                            <span class="badge bg-success rag-btn" data-value="Green">Green</span>
                                        </div>
                                        <input type="hidden" id="ragStatusInput" name="rag_status">
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Section: Route Details --}}
                        <div class="tc-section-card mb-4">
                            <div class="tc-section-header">
                                <div class="tc-section-icon tc-icon-green">
                                    <i class="uil uil-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h6 class="tc-section-title">Route Details</h6>
                                    <p class="tc-section-sub">Origin, waypoints, and destination</p>
                                </div>
                            </div>
                            <div class="tc-section-body">

                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Route</label>
                                        <select class="form-select" name="route_id" id="route_id">
                                            <option value="">Choose..</option>
                                            @foreach($routes as $route)
                                                <option value="{{ $route->id }}">{{ $route->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Source</label>
                                        <input type="text" class="form-control" name="source" id="source" placeholder="Source location" />
                                    </div>
                                </div>

                                {{-- Midpoint area --}}
                                <div class="tc-midpoint-area mt-3">
                                    <div id="noMidpointNotice" class="tc-midpoint-notice">
                                        <i class="uil uil-info-circle"></i>
                                        <span>No midpoint added.</span>
                                        <a href="#" id="linkAddMidpoint">Add Midpoint</a>
                                    </div>
                                    <div id="midpointContainer"></div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="btnAddMidpoint">
                                        <i class="uil uil-plus me-1"></i>Mid Point
                                    </button>
                                </div>

                                <div class="row g-3 mt-2">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Destination</label>
                                        <input type="text" class="form-control" name="destination" id="destination" placeholder="Destination location" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label">Distance</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="distance" id="distance" placeholder="e.g. 150" />
                                            <span class="input-group-text tc-km-badge">KM</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Section: Notes --}}
                        <div class="tc-section-card">
                            <div class="tc-section-header">
                                <div class="tc-section-icon tc-icon-grey">
                                    <i class="uil uil-comment-alt-lines"></i>
                                </div>
                                <div>
                                    <h6 class="tc-section-title">Notes</h6>
                                    <p class="tc-section-sub">Optional comments or special instructions</p>
                                </div>
                            </div>
                            <div class="tc-section-body">
                                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Optional notes..."></textarea>
                            </div>
                        </div>

                    </div>

                    {{-- ===== RIGHT COLUMN ===== --}}
                    <div class="col-lg-4">

                        {{-- Assignment --}}
                        <div class="tc-side-card mb-3">
                            <div class="tc-side-card-header">
                                <i class="uil uil-users-alt me-2"></i>Assignment
                            </div>
                            <div class="tc-side-card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label">Load Vendor</label>
                                    <select class="form-select" name="load_vendor_id" id="load_vendor_id">
                                        <option value="">Choose..</option>
                                        @foreach($loadVendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->contact_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Customer</label>
                                    <select class="form-select" name="customer_id" id="customer_id">
                                        <option value="">Choose..</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->contact_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-end mt-1">
                                        <a href="{{ route('contact.customer.create') }}" target="_blank" class="tc-link-add">
                                            <i class="uil uil-plus me-1"></i>Add Customer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Vehicle --}}
                        <div class="tc-side-card mb-3">
                            <div class="tc-side-card-header">
                                <i class="uil uil-truck me-2"></i>Vehicle
                            </div>
                            <div class="tc-side-card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label">Vehicle Type</label>
                                    <select class="form-select" name="vehicletype_id" id="vehicletype_id">
                                        <option value="">Choose..</option>
                                        @foreach($vehicleTypes as $vt)
                                            <option value="{{ $vt->id }}">{{ $vt->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Vehicle Size</label>
                                    <select class="form-select" name="vehicletypesize_id" id="vehicletypesize_id" disabled>
                                        <option value="">Select vehicle type first</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Trip Options --}}
                        <div class="tc-side-card mb-3">
                            <div class="tc-side-card-header">
                                <i class="uil uil-sliders-v me-2"></i>Trip Options
                            </div>
                            <div class="tc-side-card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label">Priority</label>
                                    <div class="tc-radio-group">
                                        <label class="tc-radio-chip">
                                            <input type="radio" name="priority" id="priority_normal" value="Normal">
                                            <span>Normal</span>
                                        </label>
                                        <label class="tc-radio-chip tc-radio-chip-urgent">
                                            <input type="radio" name="priority" id="priority_urgent" value="Urgent">
                                            <span><i class="uil uil-exclamation-triangle me-1"></i>Urgent</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tarpaulin</label>
                                    <div class="tc-radio-group">
                                        <label class="tc-radio-chip">
                                            <input type="radio" name="tarpaulin" id="tirpal_yes" value="Yes">
                                            <span>Yes</span>
                                        </label>
                                        <label class="tc-radio-chip">
                                            <input type="radio" name="tarpaulin" id="tirpal_no" value="No">
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="tc-side-card">
                            <div class="tc-side-card-body">
                                <button type="submit" id="btnSaveTrip" class="btn btn-primary w-100 mb-2">
                                    <span id="btnSaveTripText">Save Trip</span>
                                    <span id="btnSaveTripSpinner" class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                                </button>
                                <a href="{{ route('trip.index') }}" class="btn btn-outline-secondary w-100">Cancel</a>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Trip/create.js?v=1.0') }}"></script>
@endsection
