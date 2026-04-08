@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/employe-list.css') }}">

<style>
body{
    background-color: #fff;
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
                    <div class="container-fluid page-head">
                        <div class="row align-items-end">
                            <div class="col-12">
                                <h5 class="d-inline-block mb-0">Contract Master</h5>
                                <!--<a href="#" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Contract Master</a>-->
                                
                                <form action="{{ route('contact.customer.contract.list') }}" method="GET" class="d-inline-block" id="searchform">
                                    <div class="search-wrap d-inline-block ms-2" style="width:180px;">
                                        <select name="customer" id="search_customer" class="form-control select2">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ $search_customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->contact_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width:180px;">
                                        <select name="contractno" id="search_contractno" class="form-select select2">
                                            <option value="">Filter by Contract No</option>
                                            @foreach($contractNumbers as $contractNo)
                                                <option value="{{ $contractNo }}" 
                                                    {{ request('contractno') == $contractNo ? 'selected' : '' }}>
                                                    {{ $contractNo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                        {{--<input type="text" id="search_contractno" name="contractno" value="{{$search_contractno}}" class="form-control" placeholder="Filter by Contract No." >--}}
                                    </div>
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                        <input type="text" class="form-control" name="start_daterange" id="start_daterange" value="{{ request('start_daterange') }}" placeholder="Search by Start Date"/>
                                    </div>
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width:180px;">
                                        <input type="text" class="form-control" name="end_daterange" id="end_daterange" value="{{ request('end_daterange') }}" placeholder="Search by End Date"/>
                                    </div>
                                    
                                </form>
                                
                                <a href="{{ route('contact.customer.contract.list') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover invoice-table mb-0">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Contract Type</th>
                                    <th>Contract Number</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Advance Payment</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contracts as $contract)
                                    <tr>
                                        <td>{{ $contract->contact->contact_name ?? '-' }}</td>
                                        <td>{{ $contract->contracttype->name ?? '-' }}</td>
                                        <td>{{ $contract->contract_no ?? '-' }}</td>
                                        <td>{{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ number_format($contract->advance_payment ?? 0, 2) }}</td>
                                        
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                              <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                              </span>
                                              <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="{{ route('contact.customer.contract.edit', $contract->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                {{--<li><a class="dropdown-item text-danger" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                              </ul>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No contracts found.</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                    
                    @if($contracts->isNotEmpty())
                    <nav class="mt-4">
                        {{ $contracts->appends([
                            'cotype' => request('cotype'),
                            'name' => request('name'),
                            'start_date' => request('start_date'),
                            'end_date' => request('end_date'),
                        ])->links('pagination::bootstrap-5') }}
                    </nav>
                    @endif
                    
                    
                </div>

        </div>
    </div>
            
</div>

@endsection

@section('js')

<script>
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
    
    var CONTRACTS = "{{ route('contact.customer.contract.list') }}";
    
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

<script type="text/javascript" src="{{ asset('customjs/contact/customer/contract-list.js') }}"></script>

@endsection




