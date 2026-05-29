@extends('layouts.app')

@section('css')


<link rel="stylesheet" href="{{ asset('css/fleet/vehicle-details-v2.css?v=4.6') }}">

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

                                <h5 class="d-inline-block mb-0">Hisab Category</h5>
                                <a href="{{ route('hisab.category.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Hisab Category</a>
                                <form class="d-inline-block">
                                    <!--<div class="search-wrap d-inline-block ms-2" style="width: 140px;">-->
                                    <!--    <input type="text" class="form-control" placeholder="Serach by Hisab Category" />-->
                                    <!--</div>-->
                                    <div class="search-wrap d-inline-block ms-2" style="width: 120px;">
                                        <select class="form-select select2">
                                            <option>Filter by Type</option>
                                            <option>Line</option>
                                            <option>Local</option>
                                        </select>
                                    </div>
                                    <div class="search-wrap d-inline-block ms-2" style="width: 170px;">
                                        <select class="form-select select2">
                                            <option>Filter by Emission Type</option>
                                            <option>BS3</option>
                                            <option>BS3&4</option>
                                            <option>BS6</option>
                                        </select>
                                    </div>
                                    <div class="search-wrap d-inline-block ms-2" style="width: 160px;">
                                        <select class="form-select select2">
                                            <option>Filter by Fuel Mileage</option>
                                            <option>10</option>
                                            <option>6</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroutelist-bd">
                    <div class="container-fluid">
                        <!-- /////////////////////////////////// -->

                        <div class="table-responsive mt-3">
                            <table class="table table-hover invoice-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Hisab Category</th>
                                        <th>Type</th>
                                        <th>Hisab Category Type</th>
                                        <th>Emission Type</th>
                                        <th>Fuel Millage</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cat One</td>
                                        <td>Line</td>
                                        <td>Monthly Fixed + Diesel Margin</td>
                                        <td>BS6</td>
                                        <td>10</td>
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                                <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="{{ route('hisab.category.create') }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>Cat Two</td>
                                        <td>Local</td>
                                        <td>Minimum Fixed+ Diesel Margin</td>
                                        <td>BS3</td>
                                        <td>6</td>
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                                <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="{{ route('hisab.category.create') }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>Cat Three</td>
                                        <td>Line</td>
                                        <td>Monthly Fixed + Diesel Margin</td>
                                        <td>BS6</td>
                                        <td>10</td>
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                                <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="{{ route('hisab.category.create') }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>Cat Four</td>
                                        <td>Local</td>
                                        <td>Minimum Fixed+ Diesel Margin</td>
                                        <td>BS3</td>
                                        <td>6</td>
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                                <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="{{ route('hisab.category.create') }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <nav aria-label="..." class="mt-4">
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
                        </nav>

                        <!-- /////////////////////////////////// -->
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

@endsection

@section('js')


{{-- <script type="text/javascript" src="{{ asset('customjs/fleet/vehicle-details.js?v=2.1') }}"></script> --}}


@endsection
