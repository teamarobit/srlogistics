@extends('layouts.app')

@section('css')
    
    <link rel="stylesheet" href="{{ asset('css/Fleet/tyre-create.css') }}">
    
@endsection

@section('content')
    <div class="layout-wrapper">
        
        @include('includes.header')
        <!--bottom header-->
       
        <div class="vehicledtl-bd srlog-bdwrapper">
            
            <div class="topbar-bd">
                
                <div class="item1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h1>Add Tyre Details</h1>
                            </div>
                            <div class="col-12 col-md-6 text-end">
                                <button class="btn btn-primary submitBtn mt-2 mb-2">Save</button>
                                <a href="{{ route('fleetdashboard.getVehicleDetails', $vehicle->id) }}" class="btn btn-secondary mt-2 mb-2">Close</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <form class="vehicle-itemtab pt-4" id="addTyreForm" action="{{ route('fleetdashboard.saveTyreDetails', $vehicle->id) }}">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="card left-wrap">
                                <h5>Truck Tyre Layout</h5>
                                <select class="form-select mt-4" id="type" name="wheel_count">
                                    <option value="6" selected>6 + 1  Wheeler</option>
                                    <option value="10">10 + 1 Wheeler</option>
                                </select>
                                
                                <div id="container-img">
                                    <!-- SVG will be rendered here -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-8">
                            @forelse($tyrepositions as $tyreposition)
                                @if(!in_array($tyreposition->code, ['S1']))
                                    <div id="{{ $tyreposition->code }}" class="card mb-4 mandtory_tyre_positions">
                                        <input type="hidden" value="{{ $tyreposition->id }}">
                                        <h6>Tyre Details - {{ $tyreposition->code }} <span class="text-danger" style="font-size: 14px">*</span></h6>
                                        <div>
                                            <div class="row">
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Brand <span class="text-danger">*</span></label>
                                                    <input type="text" name="tyre_brand[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_tyre_brand_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Model<span class="text-danger">*</span></label>
                                                    <input type="text" name="tyre_model_name[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_tyre_model_name_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Type<span class="text-danger">*</span></label>
                                                    <select name="tyre_type[{{ $tyreposition->id }}]" class="form-control">
                                                        <!--<option name="">Choose</option>-->
                                                        <option name="Radial">Radial</option>
                                                        <option name="Nylon">Nylon</option>
                                                    </select>
                                                    <small class="error text-danger" id="add_tyre_type_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Price <span class="text-danger">*</span></label>
                                                    <input type="text" name="tyre_price[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_tyre_price_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Serial Number <span class="text-danger">*</span></label>
                                                    <input type="text" name="tyre_serial_number[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_tyre_serial_number_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Purchase Date <span class="text-danger">*</span></label>
                                                    <input type="date" name="tyre_purchase_date[{{ $tyreposition->id }}]" class="form-control general_date">
                                                    <small class="error text-danger" id="add_tyre_purchase_date_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Issue Date <span class="text-danger">*</span></label>
                                                    <input type="date" name="tyre_issue_date[{{ $tyreposition->id }}]" class="form-control general_date">
                                                    <small class="error text-danger" id="add_tyre_issue_date_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Warranty Period (Months) <span class="text-danger">*</span></label>
                                                    <input type="text" name="tyre_warranty_months[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_tyre_warranty_months_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Fixed Run KM</label>
                                                    <input type="text" name="fixed_run_km[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_fixed_run_km_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Fixed Life (Months)</label>
                                                    <input type="text" name="fixed_life_months[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_fixed_life_months_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Actual Run KM</label>
                                                    <input type="text" name="actual_run_km[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_actual_run_km_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Actual Run Month</label>
                                                    <input type="text" name="actual_run_month[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_actual_run_month_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Remaining Run KM</label>
                                                    <input type="text" name="remaining_run_km[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_remaining_run_km_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Tyre Remaining Life (Months)</label>
                                                    <input type="text" name="remaining_life_month[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_remaining_life_month_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Last Wheel Alignment KM</label>
                                                    <input type="text" name="last_alignment_km[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_last_alignment_km_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label>Last Wheel Rotation KM</label>
                                                    <input type="text" name="last_rotation_km[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_last_rotation_km_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-6 col-md-4">
                                                    <label>Wheel Alignment Interval KM</label>
                                                    <input type="text" name="alignment_interval_km[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_alignment_interval_km_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-6 col-md-2">
                                                    <label>Set Reminder?</label>
                                                    <input type="checkbox" name="set_reminder_for_alignment[{{ $tyreposition->id }}]">
                                                    <small class="error text-danger" id="add_set_reminder_for_alignment_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-6 col-md-4">
                                                    <label>Tyre Rotation Interval KM</label>
                                                    <input type="text" name="rotation_interval_km[{{ $tyreposition->id }}]" class="form-control">
                                                    <small class="error text-danger" id="add_rotation_interval_km_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                                <div class="form-group col-6 col-md-2">
                                                    <label>Set Reminder?</label>
                                                    <input type="checkbox" name="set_reminder_for_rotation[{{ $tyreposition->id }}]">
                                                    <small class="error text-danger" id="add_set_reminder_for_rotation_{{ $tyreposition->id }}_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                            
                            <div class="card">
                                <h6>Tyre Details - S1</h6>
                                <div>
                                    <div class="row">
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Brand</label>
                                            <input type="text" name="stepney_tyre_brand" class="form-control">
                                            <small class="error text-danger" id="add_stepney_tyre_brand_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Model</label>
                                            <input type="text" name="stepney_tyre_model_name" class="form-control">
                                            <small class="error text-danger" id="add_stepney_tyre_model_name_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Type</label>
                                            <select name="stepney_tyre_type" class="form-control">
                                                <option name="Radial">Radial</option>
                                                <option name="Nylon">Nylon</option>
                                            </select>
                                            <small class="error text-danger" id="add_stepney_tyre_type_error"></small>
                                        </div>
                                        
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Price</label>
                                            <input type="text" name="stepney_tyre_price" class="form-control">
                                            <small class="error text-danger" id="add_stepney_tyre_price_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Serial Number</label>
                                            <input type="text" name="stepney_tyre_serial_number" class="form-control">
                                            <small class="error text-danger" id="add_stepney_tyre_serial_number_error"></small>
                                        </div>
                                        
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Purchase Date</label>
                                            <input type="date" name="stepney_tyre_purchase_date" class="form-control general_date">
                                            <small class="error text-danger" id="add_stepney_tyre_purchase_date_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Issue Date</label>
                                            <input type="date" name="stepney_tyre_issue_date" class="form-control general_date">
                                            <small class="error text-danger" id="add_stepney_tyre_issue_date_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Warranty Period (Months)</label>
                                            <input type="text" name="stepney_tyre_warranty_months" class="form-control">
                                            <small class="error text-danger" id="add_stepney_tyre_warranty_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Fixed Run KM</label>
                                            <input type="text" name="stepney_fixed_run_km" class="form-control">
                                            <small class="error text-danger" id="add_stepney_fixed_run_km_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Fixed Life (Months)</label>
                                            <input type="text" name="stepney_fixed_life_months" class="form-control">
                                            <small class="error text-danger" id="add_stepney_fixed_life_months_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Actual Run KM</label>
                                            <input type="text" name="stepney_actual_run_km" class="form-control">
                                            <small class="error text-danger" id="add_stepney_actual_run_km_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Actual Run Month</label>
                                            <input type="text" name="stepney_actual_run_month" class="form-control">
                                            <small class="error text-danger" id="add_stepney_actual_run_month_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Remaining Run KM</label>
                                            <input type="text" name="remaining_run_km" class="form-control">
                                            <small class="error text-danger" id="add_remaining_run_km_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Tyre Remaining Life (Months)</label>
                                            <input type="text" name="stepney_remaining_life_month" class="form-control">
                                            <small class="error text-danger" id="add_stepney_remaining_life_month_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Last Wheel Alignment KM</label>
                                            <input type="text" name="stepney_last_alignment_km" class="form-control">
                                            <small class="error text-danger" id="add_stepney_last_alignment_km_error"></small>
                                        </div>
                                        <div class="form-group col-12 col-md-3">
                                            <label>Last Wheel Rotation KM</label>
                                            <input type="text" name="last_rotation_km" class="form-control">
                                            <small class="error text-danger" id="add_last_rotation_km_error"></small>
                                        </div>
                                        <div class="form-group col-6 col-md-4">
                                            <label>Wheel Alignment Interval KM</label>
                                            <input type="text" name="stepney_alignment_interval_km" class="form-control">
                                            <small class="error text-danger" id="add_stepney_alignment_interval_km_error"></small>
                                        </div>
                                        <div class="form-group col-6 col-md-2">
                                            <label>Set Reminder?</label>
                                            <input type="checkbox" name="stepney_set_reminder_for_alignment">
                                            <small class="error text-danger" id="add_stepney_set_reminder_for_alignment_error"></small>
                                        </div>
                                        <div class="form-group col-6 col-md-4">
                                            <label>Tyre Rotation Interval KM</label>
                                            <input type="text" name="stepney_rotation_interval_km" class="form-control">
                                            <small class="error text-danger" id="add_stepney_rotation_interval_km_error"></small>
                                        </div>
                                        <div class="form-group col-6 col-md-2">
                                            <label>Set Reminder?</label>
                                            <input type="checkbox" name="stepney_set_reminder_for_rotation">
                                            <small class="error text-danger" id="add_stepney_set_reminder_for_rotation_error"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--<div class="col-12 text-end mt-4">-->
                        <!--    <button type="button" id="addTyreBtn" class="btn btn-primary">Save</button>-->
                        <!--    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <!--</div>-->
                    </div>
                </div>
            </form>
        </div>
    </div>
    
@endsection

@section('js')
<script>
    const sixWheelTruckPath = "{{ asset('arobittyre_management/6-wheel-new.svg') }}";
    const tenWheelTruckPath = "{{ asset('arobittyre_management/10-wheel-new.svg') }}";
</script>

<script type="text/javascript" src="{{ asset('arobittyre_management/fleet-tyre.js') }}"></script>
<script type="text/javascript" src="{{ asset('customjs/fleet/tyre/create.js') }}"></script>


@endsection


