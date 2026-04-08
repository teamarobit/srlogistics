@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-customer.css') }}">
<link rel="stylesheet" href="{{ asset('css/add-srlbranch-master.css') }}">

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
.added-routes{
    display: none;
}

.input-group-text {
    border-color: #e9eaed;
    background: #e9eaed;
    color: #000;
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
                            <h5>Add Contract</h5>
                        </div>
                    </div>
                </div>
              </div>

                <div class="addroute-bd">
                    <div class="container-fluid">
                        <form action="{{route('contact.customer.contract.save')}}" method="POST" id="addContractForm" class="formadd_contract">
                            @csrf
                            <input type="hidden" name="contact_id" value="{{ $customerid }}">
                            
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Customer Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <select name="contact_id" class="form-control {{ !empty($contractid) ? 'not-clickable' : '' }}">
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ (isset($customerid) && $customerid == $customer->id) ? 'selected' : '' }}>{{ $customer->contact_name }}</option>
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
                                    <input type="text" name="contract_no" class="form-control">   
                                    <small class="error text-danger" id="add_contract_no_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Contract Type <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <select name="contract_type_id" id="contract_type_id" class="form-select">
                                        <option value="">Choose..</option>
                                        @foreach($contractTypes as $contractType)
                                            <option value="{{ $contractType->id }}">{{ $contractType->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="error text-danger" id="add_contract_type_id_error"></small>
                                </div>
                            </div>
                            
                            <div id="MonthlyDiv" style="display:none;">
                                <div class="form-group row">
                                    <div class="col-12 col-md-3">
                                        <label>Monthly Total Allowed Kilometer <span class="text-danger">*</span> </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" name="total_allowed_kilometer" class="form-control">
                                        <small class="error text-danger" id="add_total_allowed_kilometer_error"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-3">
                                        <label>Monthly Total Price<span class="text-danger">*</span> </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" name="monthly_total_price" class="form-control">
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
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="date" name="start_date" class="form-control start_date">
                                    <small class="error text-danger" id="add_start_date_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>End Date <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="date" name="end_date" class="form-control end_date">
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
                                      <input type="text" name="advance_payment" class="form-control text-end" placeholder="0.00" aria-describedby="rate">
                                      <small class="error text-danger" id="add_advance_payment_error"></small>
                                    </div>
                                </div>
    
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Payment Within Day <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="text" name="payment_within_day" class="form-control numericonly">
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
                                        <input type="checkbox" name="set_reminder" value="Yes" {{ old('set_reminder') == 'Yes' ? 'checked' : '' }} class="form-check-input clickto-adclass" id="setReminder">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden by default -->
                            <div class="days-beforeexpiry" style="{{ (!empty($contract) && $contract->set_reminder == 'Yes') ? '' : 'display:none;' }}">
                                <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                        <label>Days Before Expiry <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input name="reminder_days_before_expiry" value="{{ !empty($contract) ? $contract->reminder_days_before_expiry : '' }}" class="form-control" type="number">
                                        <small class="error text-danger" id="add_reminder_days_before_expiry_error"></small>
                                    </div>
                                </div>
                            </div>
                            
                          
                            <div class="row form-group">
                                <div class="col-12 col-md-3">
                                    <label>Routes <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <select name="route_id[]" class="form-select select2" multiple="multiple">
                                        <!--<option value="" disabled>Choose..</option>-->
                                        @foreach($routes as $route)
                                            <option value="{{ $route->id }}">{{ $route->name }}</option>
                                        @endforeach
                                    </select>   
                                    <small class="error text-danger" id="add_route_id_error"></small>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-12 col-md-3">
                                    <label>Remark</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <textarea name="remarks" class="form-control" rows="4"></textarea>
                                    <small class="error text-danger" id="add_remarks_error"></small>
                                </div>
                            </div>
                          
                            <div class="text-right">
                              <button id="addContractBtn" class="btn btn-dark mb-4">Save</button>
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
var EDIT_CONTRACT = "{{ route('contact.customer.edit', ':id') }}";


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
    
    $('.add-routes').click(function(){
        $('.added-routes').show();
    })
    
    $('.del-route').click(function(){
        $('.added-routes').hide();
    })
    
});
</script>

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/contract-form.js') }}"></script>

@endsection




