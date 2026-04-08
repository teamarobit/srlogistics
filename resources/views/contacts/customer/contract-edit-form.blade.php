@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/add-customer.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/add-srlbranch-master.css') }}">

<style>
.loading-wrap{
    display: none;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}
.unloading-wrap{
    display: none;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}
.rate-wrap{
    display: none;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}
.toll-wrap{
    display: none;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}
.tax-wrap{
    display: none;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

.not-clickable {
    pointer-events: none;      
    background-color: #f2f2f2; 
    cursor: not-allowed;
}
</style>

@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')
    
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')
            
            <div class="main-wrap">

                <div class="topbar">
                <div class="container-fluid page-head">
                    <div class="row align-items-end">
                        <div class="col-12 col-md-6">
                            <h5>Edit Contract</h5>
                        </div>
                    </div>
                </div>
              </div>

                <div class="addroute-bd">
                    <div class="container-fluid">
                        <form action="{{route('contact.customer.contract.update', $contract->id)}}" method="POST" id="editContractForm" class="formadd_contract">
                            @csrf
                            
                            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
                            
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Customer Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <select name="customer" class="form-control not-clickable">
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ $contract->contact_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->contact_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="error text-danger" id="add_contact_id_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Contract Number <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="contractno" value="{{ old('contract_no', $contract->contract_no) }}" class="form-control" disabled>   
                                    <small class="error text-danger" id="add_contract_no_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Contract Type <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <select name="contract_type_id" id="contract_type_id" class="form-select" disabled>
                                        <option value="">Choose..</option>
                                        @foreach($contractTypes as $contractType)
                                            <option value="{{ $contractType->id }}"
                                                {{ old('contract_type_id', $contract->contract_type_id) == $contractType->id ? 'selected' : '' }}>
                                                {{ $contractType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="error text-danger" id="add_contract_type_id_error"></small>
                                </div>
                            </div>
                            
                            <div id="MonthlyDiv" style="{{ $contract->contract_type_id == 1 ? '' : 'display:none;' }}">
                                <div class="form-group row">
                                    <div class="col-12 col-md-3">
                                        <label>Monthly Total Allowed Kilometer <span class="text-danger">*</span> </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" name="total_allowed_kilometer" value="{{ $contract->monthly_total_allowed_kilometer }}" class="form-control">
                                        <small class="error text-danger" id="add_total_allowed_kilometer_error"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-3">
                                        <label>Monthly Total Price<span class="text-danger">*</span> </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" name="monthly_total_price" value="{{ old('monthly_total_price', $contract->monthly_total_price) }}" class="form-control">
                                        <small class="error text-danger" id="add_monthly_total_price_error"></small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Upload File</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input name="upload_file" class="form-control bg-light text-black" type="file" id="formFile">
                                </div>
                                @if(optional($contract->detail)->contract_file)
                                    <p class="mt-2">
                                        <a href="{{ asset('public/media/customer-contract/'.$contract->detail->contract_file) }}"
                                           target="_blank">
                                           View Existing File
                                        </a>
                                    </p>
                                @endif
                            </div>
                          
                          
                            
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Start Date </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="date" name="start_date" value="{{ old('start_date', $contract->start_date) }}" class="form-control start_date" disabled>
                                    <small class="error text-danger" id="add_start_date_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>End Date </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="date" name="end_date" value="{{ old('end_date', $contract->end_date) }}" class="form-control end_date" disabled>
                                    <small class="error text-danger" id="add_end_date_error"></small>
                                </div>
                            </div>
                            
                            <div class="row form-group">
    
                                <div class="col-12 col-md-3">
                                    <label>Advance Payment <span class="text-danger">*</span></label>
                                </div>
    
                                <div class="col-12 col-md-6">
                                    <div class="input-group"> 
                                      <span class="input-group-text" id="rate">₹</span> 
                                      <input type="text" name="advance_payment" value="{{ old('advance_payment', $contract->advance_payment) }}" class="form-control text-end" placeholder="0.00" aria-describedby="rate">
                                      <small class="error text-danger" id="add_advance_payment_error"></small>
                                    </div>
                                </div>
    
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Payment Within Day</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="payment_within_day" value="{{ old('payment_within_day', $contract->payment_within_day) }}" class="form-control numericonly">
                                    <small class="error text-danger" id="add_payment_within_day_error"></small>
                                </div>
                            </div>
                          
                            <div class="row form-group">
                                <div class="col-12 col-md-3">
                                    <div class="d-flex">

                                        <label>Set Reminder </label>

                                        <div class="sec-tooltip">
                                        <i class="uil uil-info-circle"></i>
                                        <p>Check this box to receive a reminder.</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-md-5">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="set_reminder" value="Yes" {{ optional($contract->detail)->set_reminder == 'Yes' ? 'checked' : '' }} class="form-check-input clickto-adclass" id="setReminder">
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden by default -->
                            <div class="days-beforeexpiry" style="{{ optional($contract->detail)->set_reminder == 'Yes' ? '' : 'display:none;' }}">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Days Before Expiry <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input name="reminder_days_before_expiry" value="{{ old('reminder_days_before_expiry', optional($contract->detail)->reminder_days_before_expiry) }}" class="form-control" type="number">
                                        <small class="error text-danger" id="add_reminder_days_before_expiry_error"></small>
                                    </div>
                                </div>
                            </div>
                            
                            
                            @php
                                $selectedRoutes = $contract->routes->pluck('id')->toArray();
                            @endphp
                            <div class="row form-group">
                                <div class="col-12 col-md-3">
                                    <label>Routes <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <select name="route_id[]" class="form-select select2" multiple="multiple">
                                        <!--<option value="">Choose..</option>-->
                                        @foreach($routes as $route)
                                            <option value="{{ $route->id }}" {{ in_array($route->id, $selectedRoutes) ? 'selected' : '' }}>{{ $route->name }}</option>
                                        @endforeach
                                    </select>   
                                    <small class="error text-danger" id="add_route_id_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Remark</label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <textarea name="remarks" class="form-control" rows="4">{{ old('remarks', $contract->remarks) }}</textarea>
                                    <small class="error text-danger" id="add_remarks_error"></small>
                                </div>
                            </div>
                          
                            <div class="text-right">
                              <button id="editContractBtn" class="btn btn-dark mb-4">Save</button>
                              
                              <a href="{{ route('contact.customer.edit', $contract->contact_id) }}" class="btn btn-danger mb-4"> Close </a>
                            </div>
                        </form>         
                    </div>
                </div>

            </div>

        </div>
    </div>
            
</div>

@endsection

@section('js')

<script>

var CONTRACTS = "{{ route('contact.customer.contract.list') }}";


$(function() {
  $('input[name="time_hr_from"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');
    alert("You are " + years + " years old!");
  });
});

$(document).ready(function(){
    
    
    
    $('.loading-chargable').click(function(){
        $('.loading-wrap').toggle();
    })
    $('.unloading-chargable').click(function(){
        $('.unloading-wrap').toggle();
    })
    $('.dbtn-chargable').click(function(){
        $('.rate-wrap').toggle();
    })
    $('.set-tax').click(function(){
        $('.tax-wrap').toggle();
    })
    $('.toll-chargable').click(function(){
        $('.toll-wrap').toggle();
    })
    
});
</script>

<script type="text/javascript" src="{{ asset('public/customjs/contact/' . $cotype->slug . '/contract-form.js') }}"></script>

@endsection
