@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/department.css') }}">

<style>
body{ background-color: #fff; }
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
                            
                            <h5 class="d-inline-block mb-0">Designation</h5>
                            <a href="{{ route('designation.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Designation</a>
                            
                            <form action="{{ route('designation.index') }}" id="searchform" class="d-inline-block">
                                <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                    <input type="text" name="name" id="search_designation_name" value="{{ old('name', $search_name) }}" class="form-control" placeholder="Search by Designation Name">
                                </div>
                                <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                    <select class="form-select select2"  name="department" id="search_department_id">
                                        <option value="">Filter by Department</option>
                                        @forelse ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ request('department') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                        @empty
                                            <option value="" disabled>No department available!</option>
                                        @endforelse
                                    </select>
                                </div>
                              
                            </form>
                            
                            <a href="{{ route('designation.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse($designations as $key => $designation)
                            <tr>
                                
                                <td>{{ $designation->name ?? '' }}</td>
                                <td>{{ optional($designation->department)->name ?? '' }}</td>
                                <td>
                                    <span class="badge bg-{{ $designation->status == 'Active' ? 'success' : 'danger' }}">
                                        {{ $designation->status }}
                                    </span>
                                </td>
                                <td>
                                    {{$designation->createdby?->name}}
                                    <span class="text-secondary d-block">{{$designation->createdby?->email}}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                      <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="uil uil-ellipsis-h"></i>
                                      </span>
                                      <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                        <li><a class="dropdown-item" href="{{ route('designation.edit', $designation->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                        {{--<li><a class="dropdown-item text-danger deleteDesignation" data-id="{{ $designation->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No designation found.
                                    </td>
                                </tr>
                            @endforelse
                           
                            
                        </tbody>
                    </table>
                </div>
                
                
                @if ($designations->hasPages())
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">
                
                        {{-- Previous --}}
                        <li class="page-item {{ $designations->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $designations->previousPageUrl() }}">Previous</a>
                        </li>
                
                        {{-- Page Numbers --}}
                        @foreach ($designations->getUrlRange(1, $designations->lastPage()) as $page => $url)
                            <li class="page-item {{ $designations->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                
                        {{-- Next --}}
                        <li class="page-item {{ $designations->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $designations->nextPageUrl() }}">Next</a>
                        </li>
                
                    </ul>
                </nav>
                @endif
                
                <!--<nav aria-label="..." class="mt-4">
                  <ul class="pagination">
                    <li class="page-item disabled">
                      <span class="page-link">Previous</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                      <span class="page-link">2</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#">Next</a>
                    </li>
                  </ul>
                </nav>-->
                
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('js')

<script>
    var DESIGNATIONS        = "{{route('designation.index')}}";
    
    var DELETE_DESIGNATION  = "{{route('designation.delete')}}";
    
   
</script>
<script type="text/javascript" src="{{ asset('customjs/designation/index.js') }}?v={{ time() }}"></script>

@if(session('error'))
<script>
window.onload = function () {
    if (typeof Toast !== 'undefined') {
        Toast.fire({
            icon: 'error',
            title: @json(session('error'))
        });
    } else {
        alert(@json(session('error'))); // fallback
    }
};
</script>
@endif


@endsection