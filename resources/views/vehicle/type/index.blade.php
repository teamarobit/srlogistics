@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{-- asset('public/css/vehicle-type-list.css') --}}">

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
                              <div class="col-12">
                                  <h5 class="d-inline-block mb-0">Vehicle Type</h5>
                                  <a href="{{ route('vehicletype.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Vehicle Type</a>
                                  
                                  <form action="{{ route('vehicletype.index') }}" id="searchform" class="d-inline-block">
                                      <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                          <input type="text" name="name" id="search_name" value="{{ old('name', $search_name) }}" class="form-control" placeholder="Search by Name" />
                                      </div>
                                      <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                          <select name="status" id="search_status" class="form-select select2">
                                              <option value="">Filter by Status</option>
                                              <option value="Active" {{ old('status', $search_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                              <option value="Inactive" {{ old('status', $search_status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                          </select>
                                      </div>
                                  </form>
                                  
                                  <a href="{{ route('vehicletype.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                                  
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
                                            <th style="min-width: 120px;">Name</th>
                                            <th style="min-width: 220px;">Description</th>
                                            <th>Vehicle Size</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($datas as $type)
                                        <tr>
                                            <td>{{ $type->name }}</td>
                                            <td>{{ $type->description ?? '-' }}</td>
                                
                                            <td>
                                                @foreach($type->sizes as $size)
                                                    <span class="tag d-inline-block mb-1">
                                                        {{ $size->name }}
                                                        &nbsp;
                                                        {{ $size->length }} × {{ $size->width }} × {{ $size->height }}
                                                    </span>
                                                @endforeach
                                            </td>
                                
                                            <td>
                                                <span class="badge bg-{{ $type->status == 'Active' ? 'success' : 'danger' }}">
                                                    {{ $type->status }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                {{$type->createdby?->name}}
                                                <span class="text-secondary d-block">{{$type->createdby?->email}}</span>
                                            </td>
                                
                                            <td class="text-end">
                                                <div class="dropdown dot-dd">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="uil uil-ellipsis-h"></i>
                                                    </span>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('vehicletype.edit', $type->id) }}">
                                                                <i class="uil uil-pen me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        {{--<li>
                                                            <a class="dropdown-item text-danger deleteBtn"
                                                               href="javascript:void(0)"
                                                               data-id="{{ $type->id }}">
                                                                <i class="uil uil-trash-alt me-2"></i>Delete
                                                            </a>
                                                        </li>--}}
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No records found</td>
                                        </tr>
                                        @endforelse

                                         
                                    </tbody>
                                </table>
                            </div>
                            
                            @if ($datas->hasPages())
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination">
                            
                                    {{-- Previous --}}
                                    <li class="page-item {{ $datas->onFirstPage() ? 'disabled' : '' }}">
                                        @if ($datas->onFirstPage())
                                            <span class="page-link">Previous</span>
                                        @else
                                            <a class="page-link" href="{{ $datas->previousPageUrl() }}">Previous</a>
                                        @endif
                                    </li>
                            
                                    {{-- Page Numbers --}}
                                    @foreach ($datas->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $datas->currentPage() == $page ? 'active' : '' }}"
                                            aria-current="{{ $datas->currentPage() == $page ? 'page' : '' }}">
                                            
                                            @if ($datas->currentPage() == $page)
                                                <span class="page-link">{{ $page }}</span>
                                            @else
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                            
                                    {{-- Next --}}
                                    <li class="page-item {{ $datas->hasMorePages() ? '' : 'disabled' }}">
                                        @if ($datas->hasMorePages())
                                            <a class="page-link" href="{{ $datas->nextPageUrl() }}">Next</a>
                                        @else
                                            <span class="page-link">Next</span>
                                        @endif
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
var DELETE_VEHICLE_TYPE  = "{{route('vehicletype.delete')}}";
</script>

<script type="text/javascript" src="{{asset('public/customjs/vehicle/type/index.js')}}"></script>

@endsection





