@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/employe-list.css') }}">

<style>
body { background-color: #fff; }
.table thead tr th { padding: 8px 10px; }
.table tbody td { padding: 8px 10px; }
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
                            <h5 class="d-inline-block mb-0">Employee</h5>
                            
                            @if (Route::has('contact.employee.create')) 
                            <a href="{{ route('contact.employee.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Employee</a>
                            @endif
                            
                            <form action="{{ route('contact.employee.index') }}" id="searchform" class="d-inline-block">
                                
                                <div class="search-wrap d-inline-block ms-2" style="width:150px;">
                                    <input type="text" name="name" id="search_name" value="{{ $search_name ?? '' }}" class="form-control" placeholder="Search by Name">
                                </div>
                                    
                                <div class="search-wrap d-inline-block ms-2" style="width: 150px;">
                                    <select name="branch" id="search_branch" class="form-select select2">
                                        <option value="">Filter by Branch</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ $branch->id == $search_branch ? 'selected' : '' }}>
                                            {{ $branch->location }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="search-wrap d-inline-block ms-2" style="width: 150px;">
                                    <select name="worktype" id="search_worktype" class="form-select select2">
                                        <option value="">Filter by Work Type</option>
                                        <option value="Office Work" {{ $search_worktype == 'Office Work' ? 'selected' : '' }}>Office Work</option>
                                        <option value="Service Center" {{ $search_worktype == 'Service Center' ? 'selected' : '' }}>Service Center</option>
                                    </select>
                                </div>
                                
                            </form>
                            
                            <a href="{{ route('contact.employee.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                            
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="uil uil-trash-alt me-1"></i> Delete
                            </button>
                           
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Designation</th>
                                
                                <th style="width:150px">Work Type </th>
                                <th>Associated Since</th>
                                <th>Last Activity</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if($contacts->count())
                                @foreach($contacts as $contact)
                                
                                @php
                                    
                                    $branch = $contact->work_type === 'Office Work'
                                            ? $contact->officeBranch
                                            : $contact->serviceCenterBranch;
                    
                                    $department = $contact->work_type === 'Office Work'
                                                ? $contact->officeDepartment
                                                : $contact->serviceCenterDepartment;
                        
                                    $designation = $contact->work_type === 'Office Work'
                                                ? $contact->officeDesignation
                                                : $contact->serviceCenterDesignation;
                                    
                                    
                                @endphp
            
                                <tr>
                                    <td>
                                        <input type="checkbox" class="rowCheckbox" value="{{ $contact->id }}">
                                    </td>
                                    <td>{{ $contact->contact_name ?? '-' }} </td>
                                    <td>
                                        {{ $branch->location ?? '-' }}
                                        @if($branch)
                                            <br>
                                            <small class="text-muted">{{ $branch->code }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $department->name ?? '-' }}</td>
                                    <td>{{ $designation->name ?? '-' }}</td>
                                    <td>
                                        <span class="tag">
                                            {{ $contact->work_type ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $contact->doj ? \Carbon\Carbon::parse($contact->doj)->format('d-M-Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ $contact->updated_at ? $contact->updated_at->diffForHumans() : '-' }}
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
                                        {{$contact->createdby?->name}}
                                        <span class="text-secondary d-block">{{$contact->createdby?->email}}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dot-dd">
                                          <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-h"></i>
                                          </span>
                                          <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                            <li><a class="dropdown-item" href="{{ route('contact.employee.edit', $contact->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                            {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $contact->id }}" data-actmodelid="5" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                          </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="11" class="text-center text-muted py-3">
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



