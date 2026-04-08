@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/department.css') }}">

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
                            
                            <h5 class="d-inline-block mb-0">Department</h5>
                            <a href="{{ route('department.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Department</a>
                            
                            <form action="{{ route('department.index') }}" id="searchform" class="d-inline-block">
                                <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                    <input type="text" name="name" id="search_department_name" value="{{ old('name', $search_department_name) }}" class="form-control" placeholder="Search by Department Name">
                                </div>
                                <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                    <select class="form-select select2"  name="branch" id="search_branch_id">
                                        <option value="">Filter by Location</option>
                                        @forelse ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->location }}
                                        </option>
                                        @empty
                                            <option value="" disabled>No branch available!</option>
                                        @endforelse
                                    </select>
                                    
                                </div>
                              
                            </form>
                            
                            <a href="{{ route('department.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            <tr>
                                <th>Department Name</th>
                                <th>Department Head Name</th>
                                <th>Number of Employees</th>
                                <th>Branch Office</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse($departments as $key => $department)
                            <tr>
                                
                                <td>{{ $department->name ?? '' }}</td>
                                <td>{{ $department->department_head_name ?? '' }}</td>
                                <td>{{ $department->no_of_employees ?? '' }}</td>
                                
                                <td>
                                    @if($department->branches->count())
                                        <span class="badge bg-secondary">{{ $department->branches->pluck('location')->implode(', ') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                
                                <td>
                                    <span class="badge bg-{{ $department->status == 'Active' ? 'success' : 'danger' }}">
                                        {{ $department->status }}
                                    </span>
                                </td>
                                <td>
                                    {{$department->createdby?->name}}
                                    <span class="text-secondary d-block">{{$department->createdby?->email}}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                      <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="uil uil-ellipsis-h"></i>
                                      </span>
                                      <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                        <li><a class="dropdown-item" href="{{ route('department.edit', $department->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                        {{--<li><a class="dropdown-item text-danger deleteDepartment" data-id="{{ $department->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No department found.
                                    </td>
                                </tr>
                            @endforelse
                           
                            
                        </tbody>
                    </table>
                </div>
                
                
                @if ($departments->hasPages())
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">
                
                        {{-- Previous --}}
                        <li class="page-item {{ $departments->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $departments->previousPageUrl() }}">Previous</a>
                        </li>
                
                        {{-- Page Numbers --}}
                        @foreach ($departments->getUrlRange(1, $departments->lastPage()) as $page => $url)
                            <li class="page-item {{ $departments->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                
                        {{-- Next --}}
                        <li class="page-item {{ $departments->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $departments->nextPageUrl() }}">Next</a>
                        </li>
                
                    </ul>
                </nav>
                @endif
                
                
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('js')

<script>
    var DEPARTMENTS        = "{{route('department.index')}}";
    
    var DELETE_DEPARTMENT  = "{{route('department.delete')}}";
    
   
</script>
<script type="text/javascript" src="{{ asset('public/customjs/department/index.js') }}?v={{ time() }}"></script>
@endsection