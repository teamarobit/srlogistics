@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/ownership-list.css') }}">

<style>

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
                          <div class="col-12">

                              <h5 class="d-inline-block mb-0">Vehicle Management</h5>

                              <a href="{{ route('vehiclemanagement.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Vehicle</a>
                              
                              <form action="{{ route('vehiclemanagement.index') }}" id="searchform" class="d-inline-block">
                                  
                                <div class="search-wrap d-inline-block ms-2" style="width: 220px;">
                                  <select name="number" id="search_vehicle_number" class="form-select ">
                                      <option value="">Filter by Registration Number</option>
                                      <option>458RQ87</option>
                                      <option>9964P792W</option>
                                  </select>
                                </div>

                                <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                  <select name="type" id="search_vehicle_type" class="form-select ">
                                    <option value="">Filter by Vehicle Type</option>
                                    @foreach($vehicletype as $type)
                                    <option value="{{ $type->id }}" >
                                        {{ $type->name }} 
                                    </option>
                                    @endforeach 
                                  </select>
                                </div>
                              
                              </form>
                              
                              <a href="{{ route('vehiclemanagement.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                              
                          </div>
                      </div>
                    </div>
                </div>

                <div class="addroutelist-bd">
                    <div class="container-fluid">
                        <!-- /////////////////////////////////// -->

                        <div class="table-responsive mt-3">
                            <table class="table table-hover invoice-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 150px;">Vehicle Number<br/><span class="text-secondary">Vehicle Age</span></th>
                                        <th>Brand Name</th>
                                        <th>Emission Norm</th>
                                        <th style="min-width: 106px;">Size</th>
                                        <th>Tracking Group</th>
                                        <th style="min-width: 150px;">Current Driver<br/><span class="text-secondary">Number</span></th>
                                        <th>Vehicle Status</th>
                                        <th>Owner Name</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th class="text-end">Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse($datas as $key => $val)
                                    <tr>
                                        <td>{{ $val->vehicle_no ?? '' }} <span class="text-secondary d-block">5 Years</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{ $val->size->name ?? '-' }}<br/><span class="text-secondary">{{ $val->type->name ?? '-' }}</span></td>
                                        <td>{{ $val->group->name ?? '-' }}</td>
                                        <td>-<br/><span class="text-secondary">+91 9876543210</span></td>
                                        <td>On Trip</td>
                                        <td>Asit Dhar</td>
                                        <td>
                                            <span class="badge bg-{{ $val->status == 'Active' ? 'success' : 'danger' }}">
                                                {{ $val->status }}
                                            </span>
                                        </td>
                                        <td>
                                            {{$val->createdby?->name}}
                                            <span class="text-secondary d-block">{{$val->createdby?->email}}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                              <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                              </span>
                                              <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('vehiclemanagement.edit', $val->id) }}">
                                                        <i class="uil uil-pen me-2"></i>Edit
                                                    </a>
                                                </li>
                                                {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $val->id }}" data-actmodelid="14" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                                
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">No records found</td>
                                    </tr>
                                    @endforelse


                                </tbody>
                            </table>
                        </div>

                        @if ($datas->hasPages())
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination">
                        
                                {{-- Previous --}}
                                <li class="page-item {{ $datas->onFirstPage() ? 'disabled' : '' }}">
                                    @if ($datas->onFirstPage())
                                        <span class="page-link">Previous</span>
                                    @else
                                        <a class="page-link" href="{{ $datas->previousPageUrl() }}">Previous</a>
                                    @endif
                                </li>
                        
                                {{-- Page Numbers --}}
                                @foreach ($datas->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $datas->currentPage() == $page ? 'active' : '' }}"
                                        aria-current="{{ $datas->currentPage() == $page ? 'page' : '' }}">
                                        
                                        @if ($datas->currentPage() == $page)
                                            <span class="page-link">{{ $page }}</span>
                                        @else
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        @endif
                                    </li>
                                @endforeach
                        
                                {{-- Next --}}
                                <li class="page-item {{ $datas->hasMorePages() ? '' : 'disabled' }}">
                                    @if ($datas->hasMorePages())
                                        <a class="page-link" href="{{ $datas->nextPageUrl() }}">Next</a>
                                    @else
                                        <span class="page-link">Next</span>
                                    @endif
                                </li>
                        
                            </ul>
                        </nav>
                        @endif

                        <!-- /////////////////////////////////// -->
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
    
@endsection

@section('js')

<script>
var LISTING = "{{ route('vehiclemanagement.index') }}";
</script>

<script type="text/javascript" src="{{asset('public/customjs/vehicle/management/index.js')}}"></script>

@endsection





