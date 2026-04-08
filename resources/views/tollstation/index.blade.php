@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/add-toll-master.css') }}">

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
                              
                              <h5 class="d-inline-block mb-0">Toll Station</h5>
                              
                                <a href="{{ route('tollstation.create') }}" class="btn btn-theme mb-0 ms-2">
                                  <i class="uil uil-plus me-1"></i>
                                  Toll Station
                                </a>
                                
                                <form action="{{ route('tollstation.index') }}" id="searchform" class="d-inline-block d-flex">
                                      
                                  <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                      <input type="text" name="tollstation" id="search_tollstation" value="{{ old('tollstation', $search_tollstation_name) }}" class="form-control" placeholder="Search by Name" />
                                  </div>
                                  
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                    <select name="state_id" id="search_state_id" class="form-control select2 dependent-select" data-target="search_city_id">
                                        <option value="">-- Select State --</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ (int)$search_state === $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
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
                                  
                                </form>
                                
                                <a href="{{ route('tollstation.index') }}" class="btn btn-primary ms-1 d-flex"><i class="uil uil-sync me-1"></i>Reset</a>

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
                                        <th style="/*min-width: 120px;*/">Name</th>
                                        <th>Toll Company</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th>Charges</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    @forelse($tollstations as $key => $tollstation)
                                        <tr>
                                            <td>{{ $tollstation->station_name }}</td>
                                            <td>{{ $tollstation->toll_company }}</td>
                                            <td>{{ $tollstation->state->name ?? '-' }}</td>
                                            <td>{{ $tollstation->city->name ?? '-' }}</td>
                                            <td>{{ $tollstation->address }}</td>
                                            {{--<td>
                                                @php
                                                    $currency = optional($tollstation->currency)->sign ?? '';
                                                @endphp
                                            
                                                Large: {{ $currency }}{{ $tollstation->large_vehicle_charge }}<br>
                                                Medium: {{ $currency }}{{ $tollstation->medium_vehicle_charge }}<br>
                                                Small: {{ $currency }}{{ $tollstation->small_vehicle_charge }}
                                            </td>--}}
                                            <td>
                                                {{ optional($tollstation->currency)->sign ?? '' }}{{ $tollstation->large_vehicle_charge }} (L)<br>
                                                {{ optional($tollstation->currency)->sign ?? '' }}{{ $tollstation->medium_vehicle_charge }} (M)<br>
                                                {{ optional($tollstation->currency)->sign ?? '' }}{{ $tollstation->small_vehicle_charge }} (S)
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $tollstation->status == 'Active' ? 'success' : 'danger' }}">
                                                    {{ $tollstation->status }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                {{$tollstation->createdby?->name}}
                                                <span class="text-secondary d-block">{{$tollstation->createdby?->email}}</span>
                                            </td>
                                            
                                            <td class="text-end">
                                                <div class="dropdown dot-dd">
                                                  <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-h"></i>
                                                  </span>
                                                  <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                    <li><a class="dropdown-item" href="{{ route('tollstation.edit', $tollstation->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                    {{--<li><a class="dropdown-item text-danger deleteTollstation" data-id="{{ $tollstation->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                                  </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No toll stations found.
                                            </td>
                                        </tr>
                                    @endforelse

                                    
                                </tbody>
                            </table>
                        </div>
                        
                        @if ($tollstations->hasPages())
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-end">
                        
                                {{-- Previous --}}
                                <li class="page-item {{ $tollstations->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $tollstations->previousPageUrl() }}">Previous</a>
                                </li>
                        
                                {{-- Page Numbers --}}
                                @foreach ($tollstations->getUrlRange(1, $tollstations->lastPage()) as $page => $url)
                                    <li class="page-item {{ $tollstations->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                {{-- Next --}}
                                <li class="page-item {{ $tollstations->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $tollstations->nextPageUrl() }}">Next</a>
                                </li>
                        
                            </ul>
                        </nav>
                        @endif


                        <!--<nav aria-label="..." class="mt-4">-->
                        <!--    <ul class="pagination">-->
                        <!--        <li class="page-item disabled">-->
                        <!--            <span class="page-link">Previous</span>-->
                        <!--        </li>-->
                        <!--        <li class="page-item"><a class="page-link" href="#">1</a></li>-->
                        <!--        <li class="page-item active" aria-current="page">-->
                        <!--            <span class="page-link">2</span>-->
                        <!--        </li>-->
                        <!--        <li class="page-item"><a class="page-link" href="#">3</a></li>-->
                        <!--        <li class="page-item">-->
                        <!--            <a class="page-link" href="#">Next</a>-->
                        <!--        </li>-->
                        <!--    </ul>-->
                        <!--</nav>-->

                        
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
    
@endsection

@section('js')
<script>
var DELETE_TOLLSTATION  = "{{route('tollstation.delete')}}";
</script>

<script type="text/javascript" src="{{asset('public/customjs/tollstation/index.js')}}"></script>

@endsection



