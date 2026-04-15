@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')
            
            <div class="main-wrap">
                <div class="container-fluid page-head">
                    <div class="row align-items-center">
                        <div class="col-12 d-flex align-items-center p-0">
                            
                            <h6 class="d-inline-block m-1">Tyre Vendor</h6>
                            
                            @if (Route::has('contact.tyrevendor.create')) 
                            <a href="{{ route('contact.tyrevendor.create') }}" class="btn btn-theme mb-0" style="padding: 8px 21px !important;"><i class="uil uil-plus me-1"></i>Tyre Vendor</a>
                            @endif
                            
                            <form action="{{ route('contact.tyrevendor.index') }}" id="searchform" class="d-flex align-items-center m-1">
                                
                                <div class="search-wrap d-inline-block ms-1" style="width:140px;">
                                    <input type="text" name="name" id="search_name" value="{{ $search_name ?? '' }}" class="form-control" placeholder="Search by Contact">
                                </div>
                                
                                <div class="search-wrap d-inline-block ms-1" style="width:120px;">
                                    <select class="form-select select2" name="city" id="search_city"> 
                                        <option value="">Filter by City</option> 
                                        @forelse ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ $city->id == $search_city ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                        @empty
                                            <option value="" disabled>No city available!</option>
                                        @endforelse
                                    </select>
                                </div>
                                
                                <a href="{{ route('contact.tyrevendor.index') }}" style="text-transform: capitalize;" class="btn btn-primary reset-btn ms-1">Reset</a>
                            
                                <button type="button" class="btn btn-danger reset-btn ms-1" style="text-transform: capitalize;" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    Delete
                                </button>
                            
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Contact Name</th>
                                <th>Company Name</th>
                                <th>
                                    Contact Person<br/><span class="text-secondary">Contact Number</span>
                                </th>
                                <th>Status</th>
                                <th>Created by</th>
                                <th class="text-end">
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
                                    <td>{{ $contact->contact_name ?? '-' }}</td>
                                    <td>{{ $contact->company_name ?? '-' }}</td>
                                    
                                    <td>
                                        {{ $contact->relcontacts->first()?->name ?? '' }} <br>
                                        <span class="text-secondary d-block">
                                            +{{ $contact->relcontacts->first()?->ph_prefix ?? '91' }} {{ $contact->relcontacts->first()?->phone ?? '91' }}
                                        </span>
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
                                    <td class="text-end">
                                        <div class="dropdown dot-dd">
                                          <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-h"></i>
                                          </span>
                                          <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                            <li><a class="dropdown-item" href="{{ route('contact.tyrevendor.edit', $contact->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                            {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $contact->id }}" data-actmodelid="7" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                          </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
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
    
var DELETE_CONTACT  = "{{-- route('contact.delete') --}}";
</script>

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/index.js') }}"></script>

@endsection



