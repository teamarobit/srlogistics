@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Trip/create.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="trip-create-bd srlog-bdwrapper">

        <div class="top-text">
            <div class="container-fluid">
                <h1>Create Trip</h1>
            </div>
        </div>

        <div class="container-fluid mt-4">

            <div class="tc-card">

                {{-- Page header row --}}
                <div class="tc-card-header d-flex align-items-center justify-content-between mb-4">
                    <h5 class="tc-card-title mb-0"><i class="uil uil-plus-circle me-2"></i>New Trip</h5>
                    <a href="{{ route('trip.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="uil uil-arrow-left me-1"></i>Back to Trips
                    </a>
                </div>

                <form id="createTripForm"
                      action="{{ route('trip.store') }}"
                      method="POST"
                      data-index-url="{{ route('trip.index') }}"
                      data-sizes-url="{{ route('trip.vehicle.sizes', ['vehicletype_id' => '__ID__']) }}">
                    @csrf

                    {{-- Row 1: Trip ID | Trip Date --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip ID</label>
                            <input type="text" class="form-control bg-light" readonly placeholder="Will be auto generated" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip Date</label>
                            <input type="text" id="trip_date" name="trip_date" class="form-control" placeholder="DD/MM/YYYY" autocomplete="off">
                        </div>
                    </div>

                    {{-- Row 2: Trip Type | Trip Category --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip Type</label>
                            <select class="form-select" name="trip_type" id="trip_type">
                                <option value="">Choose..</option>
                                <option value="Own">Own Booking</option>
                                <option value="Rental">Rental</option>
                                <option value="External">External</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Trip Category</label>
                            <div class="d-flex align-items-center" style="min-height:38px;">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="trip_category" id="tc_line" value="Line">
                                    <label class="form-check-label" for="tc_line">Line</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trip_category" id="tc_local" value="Local">
                                    <label class="form-check-label" for="tc_local">Local</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Load Vendor | RAG Status --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Load Vendor</label>
                            <select class="form-select" name="load_vendor_id" id="load_vendor_id">
                                <option value="">Choose..</option>
                                @foreach($loadVendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->contact_name }}</option>
                                @endforeach
                            </select>
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

                    {{-- Row 4: Customer | Internal Trip ID --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Customer</label>
                            <select class="form-select" name="customer_id" id="customer_id">
                                <option value="">Choose..</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->contact_name }}</option>
                                @endforeach
                            </select>
                            <div class="text-end mt-1">
                                <a href="{{ route('contact.customer.create') }}" target="_blank" style="font-size: 13px;"><i class="uil uil-plus me-1"></i> Add Customer</a>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Internal Trip ID</label>
                            <input type="text" class="form-control" name="internal_trip_id" id="internal_trip_id" />
                        </div>
                    </div>

                    {{-- Row 5: Vehicle Type | Vehicle Size --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Vehicle Type</label>
                            <select class="form-select" name="vehicletype_id" id="vehicletype_id">
                                <option value="">Choose..</option>
                                @foreach($vehicleTypes as $vt)
                                    <option value="{{ $vt->id }}">{{ $vt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Vehicle Size</label>
                            <select class="form-select" name="vehicletypesize_id" id="vehicletypesize_id" disabled>
                                <option value="">Select vehicle type first</option>
                            </select>
                        </div>
                    </div>

                    {{-- Route Card --}}
                    <div class="card mb-3 border route-details-card">
                        <div class="card-header py-2 px-3" style="font-size:13px; font-weight:600; color:#344767;">
                            <i class="uil uil-map-marker me-1"></i> Route Details
                        </div>
                        <div class="card-body pb-1">

                            {{-- Route | Source --}}
                            <div class="row mb-3">
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

                            {{-- No Midpoint notice --}}
                            <div id="noMidpointNotice" class="mb-3 d-flex align-items-center justify-content-center gap-2" style="font-size:13px; color:#6c757d;">
                                <i class="uil uil-info-circle"></i>
                                <span>No Midpoint is found.</span>
                                <a href="#" id="linkAddMidpoint" style="font-size:13px;">Add Midpoint</a>
                            </div>

                            {{-- Midpoint entries (dynamic) --}}
                            <div id="midpointContainer"></div>

                            {{-- Add Midpoint button --}}
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnAddMidpoint">
                                    <i class="uil uil-plus me-1"></i>Mid Point
                                </button>
                            </div>

                            {{-- Destination | Distance --}}
                            <div class="row mb-3">
                                <div class="col-md-6 form-group">
                                    <label class="form-label">Destination</label>
                                    <input type="text" class="form-control" name="destination" id="destination" placeholder="Destination location" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label">Distance</label>
                                    <input type="text" class="form-control" name="distance" id="distance" placeholder="e.g. 150 KM" />
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Row 8: Priority | Tarpaulin --}}
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Priority</label>
                            <div class="d-flex align-items-center" style="min-height:38px;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" id="priority_normal" value="Normal">
                                    <label class="form-check-label" for="priority_normal">Normal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" id="priority_urgent" value="Urgent">
                                    <label class="form-check-label" for="priority_urgent">Urgent</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Tarpaulin</label>
                            <div class="d-flex align-items-center" style="min-height:38px;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tarpaulin" id="tirpal_yes" value="Yes">
                                    <label class="form-check-label" for="tirpal_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tarpaulin" id="tirpal_no" value="No">
                                    <label class="form-check-label" for="tirpal_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Comment — full width --}}
                    <div class="row mb-4">
                        <div class="col-12 form-group">
                            <label class="form-label">Comment</label>
                            <textarea class="form-control" name="comment" id="comment" rows="4" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('trip.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="btnSaveTrip" class="btn btn-primary">
                            <span id="btnSaveTripText">Save Trip</span>
                            <span id="btnSaveTripSpinner" class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/Trip/create.js?v=1.0') }}"></script>
@endsection
