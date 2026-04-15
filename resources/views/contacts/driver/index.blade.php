@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Contacts/Driver/index.css') }}">


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

                                <h5 class="d-inline-block mb-0">Driver</h5>

                                @if (Route::has('contact.driver.create')) 
                                <a href="{{ route('contact.driver.create') }}" style="padding: 8px 10px !important;" class="btn btn-theme mb-0"><i class="uil uil-plus me-1"></i> Driver</a>
                                @endif
                            
                                <form action="{{ route('contact.driver.index') }}" id="searchform" class="d-inline-block">

                                    <div class="search-wrap d-inline-block" style="width:130px;">
                                        <input type="text" name="name" id="search_name" value="{{ $search_name ?? '' }}"  class="form-control" placeholder="Search by Name">
                                    </div>
                                    
                                    <div class="search-wrap d-inline-block" style="width: 130px;">
                                        <select class="form-select" id="" name="">
                                            <option value="">Filter By Vehicle</option>
                                            <option value="Red">WB-12-VH09-9890</option>
                                            <option value="Yellow">WB-13-VH08-9090</option>
                                            <option value="Green">WB-15-VH10-8990</option> 
                                         </select>
                                    </div>
                                    
                                    <div class="search-wrap d-inline-block" style="width: 120px;">
                                        <select name="rag" id="search_rag" class="form-select">
                                            <option value="">Filter by RAG</option>
                                            <option value="Red" {{ $search_rag == 'Red' ? 'selected' : '' }}>Red</option>
                                            <option value="Yellow" {{ $search_rag == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                                            <option value="Green" {{ $search_rag == 'Green' ? 'selected' : '' }}>Green</option>
                                        </select>
                                    </div>
                                    
    
                                    <div class="search-wrap d-inline-block" style="width:140px;">
                                        <select name="category" id="search_category" class="form-select">
                                            <option value="">Filter by Category </option>
                                            <option value="Line" {{ $search_category == 'Line' ? 'selected' : '' }}>Line</option>
                                            <option value="Local" {{ $search_category == 'Local' ? 'selected' : '' }}>Local</option>
                                        </select>
                                    </div>
                                    
                                    <a href="{{ route('contact.driver.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                                    
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="uil uil-trash-alt me-1"></i> Delete
                                    </button>
                            
                            
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--<div class="no-datawrapper">-->
                    <!--   <div class="container">-->
                    <!--        <div class="no-data">-->
                    <!--            <p class="text-dark mb-0">No Data Found</p>-->
                    <!--        </div>-->
                    <!--   </div>-->
                    <!--</div>-->

                    <div class="table-responsive mt-3">

                        <table class="table table-hover invoice-table mb-0">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>Name</th>
                                    <th>Current Allocated Vehicle</th>
                                    <th>Associated Since</th>
                                    <th>Category</th>
                                    <th>RAG Status</th>
                                    <th>Status</th>
                                    <th>Created by</th>
                                    <th class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                @if($contacts->count())
                                    @foreach($contacts as $contact)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="rowCheckbox" value="{{ $contact->id }}">
                                        </td>
                                        <td>
                                            {{ $contact->contact_name ?? '' }}
                                            <span class="text-secondary d-block">+{{ $contact->ph_prefix ?? '' }} {{ $contact->phone ?? '' }}</span>
                                        </td>
    
                                        <td>{{ $contact->currentVehicleAllocation->vehicle->vehicle_no ?? '-' }}</td>
    
                                        @php
                                            $associatedSince = '';
                                        
                                            if (!empty($contact->doj)) {
                                                $doj = new DateTime($contact->doj);
                                                $today = new DateTime();
                                        
                                                if ($doj <= $today) {
                                                    $diff = $today->diff($doj);
                                                    $associatedSince = $diff->y . ' Years ' . $diff->m . ' Months ' . $diff->d . ' Days';
                                                }
                                            }
                                        @endphp
                                        <td>{{ $associatedSince }}</td>
                                        
                                        <td>{{ optional($contact->driverinfo)->category ?? '-' }}</td>
                                        
                                        <td> 
                                            @if($contact->rag_status == 'Red')
                                                <span class="badge bg-danger">Red</span>
                                            @elseif($contact->rag_status == 'Yellow')
                                                <span class="badge bg-warning">Yellow</span>
                                            @elseif($contact->rag_status == 'Green')
                                                <span class="badge bg-success">Green</span>
                                            @endif
                                        </td>
                                        
                                        
                                        @php
                                            $statusClasses = [
                                                'Active' => 'badge badge-success',
                                                'Inactive' => 'badge badge-danger',
                                                'Blacklisted' => 'badge bg-danger',
                                            ];
                                        @endphp
                                        <td>
                                            <span class="{{ $statusClasses[$contact->status] ?? 'badge badge-secondary' }}">
                                                {{ $contact->status ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            {{ $contact->createdby?->name ?? '' }}
                                            <span class="text-secondary d-block">{{ $contact->createdby?->email ?? '' }}</span>
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="dropdown dot-dd">
                                              <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                              </span>
                                              <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                  
                                                <li><a class="dropdown-item" href="{{ route('contact.driver.edit', $contact->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $contact->id }}" data-actmodelid="6" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                                
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">
                                        No Data Found
                                    </td>
                                </tr>
                                @endif
                                
                                
                                
                                

                            </tbody>
                        </table>
                    </div>
                    
                    @if($contacts->count())
                    <nav aria-label="..." class="mt-4">
                      {{ $contacts->appends(array_filter([
                                                'cotype' => $cotype ?? null,
                                            ]))->links('pagination::bootstrap-5') }}
                    </nav>
                    @endif
                    
                </div>
              
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                
                <div class="form-check form-check-inline radio-chip">
                    <input class="form-check-input" type="radio" name="deleteType" id="delete_selected" value="selected" checked>
                    <label class="form-check-label" for="delete_selected">
                        <i class="uil uil-check-circle me-1"></i>Delete Selected
                    </label>
                </div>
                
                <div class="form-check form-check-inline radio-chip">
                    <input class="form-check-input" type="radio" name="deleteType" id="delete_all" value="all">
                    <label class="form-check-label" for="delete_all">
                        <i class="uil uil-check-circle me-1"></i>Delete All
                    </label>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>

        </div>
    </div>
</div>
    
@endsection

@section('js')

<script>
var CO_TYPE = "{{ $cotype->slug }}";
var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";

var DELETE_SELECTED_CONTACT  = "{{ route('contact.delete.selected') }}";
var DELETE_ALL  = "{{ route('contact.delete.all') }}";
    
var DELETE_CONTACT  = "{{route('contact.delete')}}";
</script>

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/index.js') }}"></script>

@endsection



