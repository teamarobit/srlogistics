@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Routes/index.css') }}">



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
                              <h5 class="d-inline-block mb-0">Routes</h5>
                              <a href="{{ route('route.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Route</a>
                              
                              <form action="{{ route('route.index') }}" id="searchform" class="d-inline-block">
                                  <div class="search-wrap d-inline-block" style="width: 125px;">
                                      <input type="text" name="route" id="search_route" value="{{ old('route', $search_route_name) }}" class="form-control" placeholder="Search by Route" />
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block" style="width: 140px;">
                                      <input type="text" name="source" id="search_source" value="{{ old('source', $search_source) }}" class="form-control" placeholder="Search by Source" />
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block" style="width: 140px;">
                                      <input type="text" name="destination" id="search_destination" value="{{ old('destination', $search_destination) }}" class="form-control" placeholder="Search by Destination" />
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 130px;">
                                      <select name="route_type" id="route_type" class="form-select">
                                          <option value="">Filter by Route Type</option>
                                          <option value="Line">Line</option>
                                          <option value="Local">Local</option>
                                      </select>
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 130px;">
                                      <select name="status" id="search_status" class="form-select">
                                          <option value="">Filter by Status</option>
                                          <option value="Active">Active</option>
                                          <option value="Inactive">Inactive</option>
                                      </select>
                                  </div>
                                  
                              </form>
                              
                              <a href="{{ route('route.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
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
                                        <th>SL No.</th>
                                        <th style="width: 150px">Route Name</th>
                                        <th>Source<br/>Destination</th>
                                        <th style="width: 200px">Fixed  KM<br/>Transit Time</th>
                                        <th style="width: 200px">Fixed Diesel BS-3 & BS-4<br/>Fixed Diesel BS-6</th>
                                        <th style="width: 200px">Fixed Driver Advance</th>
                                        <th>Route Type</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    
                                    @forelse($routes as $key => $route)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $route->name ?? '-' }}</td>
                                        <td>
                                            {{ $route->sourceCity->name ?? '-' }}
                                            <br>
                                            {{ $route->destinationCity->name ?? '-' }}
                                        </td>
                                    
                                        <td>
                                            {{ number_format($route->fixed_km, 2) }} KM
                                            <br>
                                            {{ $route->transit_time_days ?? '-' }} Days
                                            {{ $route->transit_time_hrs ?? '-' }} Hrs
                                        </td>
                                    
                                        <td>
                                            BS3 / BS4 : ₹{{ number_format($route->fixed_diesel_bs3_bs4, 2) }}
                                            <br>
                                            BS6 : ₹{{ number_format($route->fixed_diesel_bs6, 2) }}
                                        </td>
                                    
                                        <td>₹{{ number_format($route->fixed_driver_advance, 2) }}</td>
                                        <td>{{ $route->route_type ?? '' }}</td>
                                    
                                        <td>
                                            <span class="badge {{ $route->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $route->status }}
                                            </span>
                                        </td>
                                        <td>
                                            {{$route->createdby?->name}}
                                            <span class="text-secondary d-block">{{$route->createdby?->email}}</span>
                                        </td>
                                        
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                              <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                              </span>
                                              <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="{{ route('route.edit', $route->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                {{--<li><a class="dropdown-item text-danger delete-route" data-id="{{ $route->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                              </ul>
                                            </div>
                                        </td>
                                    
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No routes found</td>
                                    </tr>
                                    @endforelse


                                </tbody>
                            </table>
                        </div>
                        
                        @if ($routes->hasPages())
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination">
                        
                                {{-- Previous --}}
                                <li class="page-item {{ $routes->onFirstPage() ? 'disabled' : '' }}">
                                    @if ($routes->onFirstPage())
                                        <span class="page-link">Previous</span>
                                    @else
                                        <a class="page-link" href="{{ $routes->previousPageUrl() }}">Previous</a>
                                    @endif
                                </li>
                        
                                {{-- Page Numbers --}}
                                @foreach ($routes->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $routes->currentPage() == $page ? 'active' : '' }}"
                                        aria-current="{{ $routes->currentPage() == $page ? 'page' : '' }}">
                                        
                                        @if ($routes->currentPage() == $page)
                                            <span class="page-link">{{ $page }}</span>
                                        @else
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        @endif
                                    </li>
                                @endforeach
                        
                                {{-- Next --}}
                                <li class="page-item {{ $routes->hasMorePages() ? '' : 'disabled' }}">
                                    @if ($routes->hasMorePages())
                                        <a class="page-link" href="{{ $routes->nextPageUrl() }}">Next</a>
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
var DELETE_ROUTE  = "{{route('route.delete')}}";
</script>

<script type="text/javascript" src="{{asset('js/Routes/index.js')}}"></script>

@endsection



