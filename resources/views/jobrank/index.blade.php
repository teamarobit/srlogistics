@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/HR/jobrank-index.css') }}">


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
                                <h5 class="d-inline-block mb-0">Job Rank</h5>
                                <a href="{{ route('jobrank.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Job Rank</a>
                                
                                <form action="{{ route('jobrank.index') }}" id="searchform" class="d-inline-block">
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width: 150px;">
                                        <input type="text" name="name" id="search_name" value="{{ old('name', $search_name) }}" class="form-control" placeholder="Search by Job Rank">
                                    </div>
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
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
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                        <select class="form-select select2"  name="designation" id="search_designation_id">
                                            <option value="">Filter by Designation</option>
                                            @forelse ($designations as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ request('designation') == $designation->id ? 'selected' : '' }}>
                                                {{ $designation->name }}
                                            </option>
                                            @empty
                                                <option value="" disabled>No designation available!</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    
                                    <a href="{{ route('jobrank.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-hover invoice-table mb-0">
                            <thead>
                                <tr>
                                    <th>Job Rank</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th class="text-end">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @forelse($datas as $data)
                                <tr>
                                    <td>{{ $data->name ?? '-' }}</td>
                                    <td>{{ $data->department?->name ?? 'N/A' }}</td>
                                    <td>{{ $data->designation?->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $data->status == 'Active' ? 'success' : 'danger' }}">
                                            {{ $data->status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{$data->createdby?->name}}
                                        <span class="text-secondary d-block">{{$data->createdby?->email}}</span>
                                    </td>
                                    
                                    <td class="text-end">
                                        <div class="dropdown dot-dd">
                                          <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-h"></i>
                                          </span>
                                          <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                            <li><a class="dropdown-item" href="{{ route('jobrank.edit',$data->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                            {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $data->id }}" data-actmodelid="50" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                          </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No Data found!
                                    </td>
                                </tr>
                                @endforelse
                                
                                
                            </tbody>
                        </table>
                    </div>
                    
                    @if ($datas->hasPages())
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-end">
                    
                            {{-- Previous --}}
                            <li class="page-item {{ $datas->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $datas->previousPageUrl() }}">Previous</a>
                            </li>
                    
                            {{-- Page Numbers --}}
                            @foreach ($datas->getUrlRange(1, $datas->lastPage()) as $page => $url)
                                <li class="page-item {{ $datas->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                    
                            {{-- Next --}}
                            <li class="page-item {{ $datas->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $datas->nextPageUrl() }}">Next</a>
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
var JOBRANKS        = "{{ route('jobrank.index') }}";
var DELETE_JOBRANK  = "{{route('jobrank.delete')}}";

var DESIGNATION_URL = "{{ route('designation.getDepartmentWiseDesignations', '__ID__') }}";
</script>

<script type="text/javascript" src="{{asset('customjs/jobrank/index.js')}}"></script>

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