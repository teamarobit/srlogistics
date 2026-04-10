@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-toll-master.css') }}">

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
                          <div class="col-lg-12 d-flex align-items-center">
                              
                              <h5 class="d-inline-block mb-0">RTO Checkpoint</h5>
                              
                                <a href="{{ route('rto.create') }}" class="btn btn-theme mb-0 ms-2">
                                  <i class="uil uil-plus me-1"></i>
                                  RTO Checkpoint
                                </a>
                                
                                <form action="{{ route('rto.index') }}" id="searchform" class="d-inline-block d-flex">
                                      
                                  <div class="search-wrap d-inline-block ms-2" style="width: 125px;">
                                      <input type="text" name="rto" id="search_rto" value="{{ old('rto', $search_rto_name) }}" class="form-control" placeholder="Search by Name" />
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 120px;">
                                    <select name="state_id" id="search_state_id" class="form-control select2 dependent-select" data-target="search_city_id">
                                        <option value="">-- Select State --</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ (int)$search_state === $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 110px;">
                                    <select name="city_id" id="search_city_id" class="form-control select2">
                                        <option value="">-- Select City --</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" 
                                                {{ (int)$search_city === $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 125px;">
                                    <select name="" id="" class="form-select">
                                        <option value="">Filter by Status</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                    </select>
                                  </div>
                                  
                                </form>
                                
                                <a href="{{ route('rto.index') }}" class="btn btn-primary ms-1 d-flex"><i class="uil uil-sync me-1"></i>Reset</a>

                          </div>
                      </div>
                  </div>
                </div>

                <div class="addroutelist-bd">
                    <div class="container-fluid">
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-hover invoice-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Charge For Large Truck</th>
                                        <th>Charge For Medium Truck</th>
                                        <th>Charge For Small Truck</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    @forelse($rtos as $key => $rto)
                                        @php
                                            $currency = optional($rto->currency)->sign ?? '';
                                        @endphp
                                        <tr>
                                            <td>{{ $rto->name }}</td>
                                            <td>{{ $rto->state->name ?? '-' }}</td>
                                            <td>{{ $rto->city->name ?? '-' }}</td>
                                            <td>{{ $currency }}{{ $rto->charge_for_large_truck }}</td>
                                            <td>{{ $currency }}{{ $rto->charge_for_medium_truck }}</td>
                                            <td>{{ $currency }}{{ $rto->charge_for_small_truck }}</td>
                                            
                                            
                                            <td>
                                                <span class="badge bg-{{ $rto->status == 'Active' ? 'success' : 'danger' }}">
                                                    {{ $rto->status }}
                                                </span>
                                            </td>
                                            <td>
                                                {{$rto->createdby?->name}}
                                                <span class="text-secondary d-block">{{$rto->createdby?->email}}</span>
                                            </td>
                                            
                                            <td class="text-end">
                                                <div class="dropdown dot-dd">
                                                  <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-h"></i>
                                                  </span>
                                                  <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                    <li><a class="dropdown-item" href="{{ route('rto.edit', $rto->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                    {{--<li><a class="dropdown-item text-danger deleteRTO" data-id="{{ $rto->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                                  </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                No RTO Checkpoint found.
                                            </td>
                                        </tr>
                                    @endforelse

                                    
                                </tbody>
                            </table>
                        </div>
                        
                        @if ($rtos->hasPages())
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-end">
                        
                                {{-- Previous --}}
                                <li class="page-item {{ $rtos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $rtos->previousPageUrl() }}">Previous</a>
                                </li>
                        
                                {{-- Page Numbers --}}
                                @foreach ($rtos->getUrlRange(1, $rtos->lastPage()) as $page => $url)
                                    <li class="page-item {{ $rtos->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                {{-- Next --}}
                                <li class="page-item {{ $rtos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $rtos->nextPageUrl() }}">Next</a>
                                </li>
                        
                            </ul>
                        </nav>
                        @endif


                        
                        
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
    
@endsection

@section('js')
<script>
var DELETE_RTO  = "{{route('rto.delete')}}";
</script>

<script type="text/javascript" src="{{asset('customjs/rto/index.js')}}"></script>

@endsection



