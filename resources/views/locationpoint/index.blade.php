@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/LocationPoint/index.css') }}">



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
                              
                              <h5 class="d-inline-block mb-0">Location Point</h5>
                              
                                
                                <form action="{{ route('locationpoint.index') }}" id="searchform" class="d-inline-block d-flex">
                                      
                                  <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                      <input type="text" name="location" id="search_location" value="{{ $search_location }}" class="form-control" placeholder="Search by Location" />
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                    <select name="locationtype" id="search_location_type" class="form-control select2">
                                        <option value="">-- Filter by Location Type --</option>
                                        <option value="Loading" {{ $search_location_type=='Loading'?'selected':'' }}>Loading Point</option>
                                        <option value="Unloading" {{ $search_location_type=='Unloading'?'selected':'' }}>Unloading Point</option>
                                        <option value="Both" {{ $search_location_type=='Both'?'selected':'' }}>Loading & Unloading Point</option>
                                    </select>
                                  </div>
                                  
                                  <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                    <select name="contacttype" id="search_contact_type" class="form-control select2">
                                        <option value="">-- Filter by Contact Type --</option>
                                        <option value="Customer" {{ $search_contact_type=='Customer'?'selected':'' }}>Customer</option>
                                        <option value="Load Vendor" {{ $search_contact_type=='Load Vendor'?'selected':'' }}>Load Vendor (Broker)</option>
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
                                
                                <a href="{{ route('locationpoint.index') }}" class="btn btn-primary ms-1 d-flex"><i class="uil uil-sync me-1"></i>Reset</a>

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
                                        <th style="max-width: 120px;">Location</th>
                                        <th style="width: 120px;">Location Type</th>
                                        <th style="max-width: 100px;">Onsite Contact</th>
                                        <th style="max-width: 100px;">Onsite Phone</th>
                                        <th style="width: 130px;">Onsite WhatsApp</th>
                                        <th>Contact Type</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    @forelse($locations as $key => $row)
                                        
                                        <tr>
                                            <td>{{ $row['location'] }}</td>
                                            <td>
                                                @switch($row['location_type'])
                                                    @case('Both')
                                                        <span class="tag">Loading</span>
                                                        <span class="tag">Unloading</span>
                                                        @break
                                            
                                                    @default
                                                        <span class="tag">{{ $row['location_type'] }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $row['onsite_contact_person'] }}</td>
                                            <td>{{ $row['phone'] }}</td>
                                            <td>{{ $row['whatsapp'] }}</td>
                                            <td>{{ $row['contact_type'] }}</td>
                                            <td>{{ $row['city_name'] }}</td>
                                            <td>{{ $row['state_name'] }}</td>
                                            
                                            <td class="text-end">
                                                <div class="dropdown dot-dd">
                                                  <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-h"></i>
                                                  </span>
                                                  <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                    <li><a class="dropdown-item" href="javascript:void(0)"><i class="uil uil-whatsapp me-2"></i>Share</a></li>
                                                  </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                No Data found!
                                            </td>
                                        </tr>
                                    @endforelse

                                    
                                </tbody>
                            </table>
                        </div>
                        
                        @if ($locations->hasPages())
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-end">
                        
                                {{-- Previous --}}
                                <li class="page-item {{ $locations->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $locations->previousPageUrl() }}">Previous</a>
                                </li>
                        
                                {{-- Page Numbers --}}
                                @foreach ($locations->getUrlRange(1, $locations->lastPage()) as $page => $url)
                                    <li class="page-item {{ $locations->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                {{-- Next --}}
                                <li class="page-item {{ $locations->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $locations->nextPageUrl() }}">Next</a>
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

</script>

<script type="text/javascript" src="{{asset('js/LocationPoint/index.js')}}"></script>

@endsection
