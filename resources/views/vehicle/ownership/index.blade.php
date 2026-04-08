@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/ownership-list.css') }}">

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
                                  <h5 class="d-inline-block mb-0">Ownership Type</h5>
                                  <a href="{{ route('vehicleownership.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Ownership</a>
                                  
                                  <form action="{{ route('vehicleownership.index') }}" id="searchform" class="d-inline-block">
                                      <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                          <input type="text" name="name" id="search_name" value="{{ $search_name ?? '' }}" class="form-control" placeholder="Search by Name" />
                                      </div>
                                  </form>
                                  
                                  <a href="{{ route('vehicleownership.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                                  
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
                                            <th style="min-width: 200px;">Description</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($datas as $val)
                                        <tr>
                                            <td>{{ $val->name ?? '-' }}</td>
                                            <td>{{ $val->description ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $val->status == 'Active' ? 'success' : 'danger' }}">
                                                    {{ $val->status }}
                                                </span>
                                            </td>
                                            <td>
                                                {{$val->createdby?->name}}
                                                <span class="text-secondary d-block">{{$val->createdby?->email}}</span>
                                            </td>
                                
                                            <td class="text-end">
                                                <div class="dropdown dot-dd">
                                                    <span class="dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="uil uil-ellipsis-h"></i>
                                                    </span>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('vehicleownership.edit', $val->id) }}">
                                                                <i class="uil uil-pen me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        {{--<li>
                                                            <a class="dropdown-item text-danger deleteBtn"
                                                               href="javascript:void(0)"
                                                               data-url="{{ route('vehicleownership.delete', ['id' => $val->id]) }}">
                                                                <i class="uil uil-trash-alt me-2"></i>Delete
                                                            </a>
                                                        </li>--}}
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No records found</td>
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
var LISTING = "{{ route('vehicleownership.index') }}";
</script>

<script type="text/javascript" src="{{asset('public/customjs/vehicle/ownership/index.js')}}"></script>

@endsection





