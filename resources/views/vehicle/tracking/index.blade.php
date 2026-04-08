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
                <div class="container-fluid page-head">
                    <div class="row align-items-end">
                        <div class="col-12">
                            <h5 class="d-inline-block mb-0">Vehicle Group</h5>
                            <a href="{{ route('vehicletracking.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Vehicle Group Tracking</a>
                            
                        </div>
                    </div>
                </div>

                <!--<div class="no-datawrapper">
                   <div class="container">
                        <div class="no-data">
                            <p class="text-dark mb-0">No Data Found</p>
                        </div>
                   </div>
                </div>-->

                <div class="table-responsive mt-3">

                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            <th style="min-width: 200px;">Vehicle Group</th>
                            <th>Employee Name</th>
                            <th>No. of Vehicles</th>
                            <th>Vehicle Enlisted</th>
                            <th class="text-end">
                                Action
                            </th>
                        </thead>
                        <tbody>
                            
                            @forelse($datas as $key => $data)
                            <tr>
                                <td>{{ $data->vehicleGroup->name ?? '-' }}</td>
                                <td>{{ $data->managed_by_employee ?? '-' }}</td>
                                <td>{{ $data->no_of_vehicles ?? '-' }}</td>
                            
                                <td>
                                    @if($data->vehicles->count())
                                        @foreach($data->vehicles as $v)
                                            <span class="tag">
                                                {{ $v->vehicle->vehicle_no ?? '' }}
                                            </span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                            
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown">
                                            <i class="uil uil-ellipsis-h"></i>
                                        </span>
                            
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('vehicletracking.edit',$data->id) }}">
                                                    <i class="uil uil-pen me-2"></i>Edit
                                                </a>
                                            </li>
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





