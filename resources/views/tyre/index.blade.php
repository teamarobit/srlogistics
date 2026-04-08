@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/ownershiptype-list.css') }}">

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

                              <h5 class="d-inline-block mb-0">Tyre Management</h5>

                              <a href="{{ route('tyre.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Tyre</a>
                              
                              <form action="{{ route('tyre.index') }}" id="searchform" class="d-inline-block">
                                  
                                <div class="search-wrap d-inline-block ms-2" style="width: 220px;">
                                  <input type="text" class="form-control search_input" name="search_">
                                </div>

                                <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                  <select name="type" id="search_vehicle_type" class="form-select ">
                                    <option value="">Filter by Vehicle Type</option>
                                  </select>
                                </div>
                              
                              </form>
                              
                              <a href="{{ route('tyre.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                              
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
                                        <th style="min-width: 150px;">Vendor</th>
                                        <th>Condition</th>
                                        <th>Brand Name</th>
                                        <th>Model</th>
                                        <th>Type</th>
                                        <th>Serial Number</th>
                                        <th>Price</th>
                                        <th>Created By</th>
                                        <th class="text-end">Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse($tyres as $key => $tyre)
                                        <tr>
                                            <td>{{ $tyre->tyrevendor->contact_name }}</td>
                                            <td>{{ $tyre->tyre_condition }}</td>
                                            <td>{{ $tyre->tyre_brand }}</td>
                                            <td>{{ $tyre->tyre_model }}</td>
                                            <td>{{ $tyre->tyre_type }}</td>
                                            <td>{{ $tyre->tyre_serial_number }}</td>
                                            <td>₹{{ number_format($tyre->tyre_price, 2) }}</td>
                                            <td>
                                                {{$tyre->createdby?->name}}
                                                <span class="text-secondary d-block">{{$tyre->createdby?->email}}</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown dot-dd">
                                                  <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-h"></i>
                                                  </span>
                                                  <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('tyre.edit', $tyre->id) }}">
                                                            <i class="uil uil-pen me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li><a class="dropdown-item text-danger mark_as_discard" data-url="{{ route('tyre.markasdiscard', $tyre->id) }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Mark As Discard</a></li>
                                                    
                                                  </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">No records found</td>
                                        </tr>
                                    @endforelse


                                </tbody>
                            </table>
                        </div>
                        {{--
                        @if ($datas->hasPages())
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination">
                                <li class="page-item {{ $datas->onFirstPage() ? 'disabled' : '' }}">
                                    @if ($datas->onFirstPage())
                                        <span class="page-link">Previous</span>
                                    @else
                                        <a class="page-link" href="{{ $datas->previousPageUrl() }}">Previous</a>
                                    @endif
                                </li>
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
                        --}}

                        <!-- /////////////////////////////////// -->
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="discardTyreModal" tabindex="-1" aria-labelledby="discardTyreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discardTyreModalLabel">Discard Tyre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="discardTyreForm">
                    @csrf
                    <label> Note <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="note" id="note"></textarea>
                    <span class="error text-danger" id="note_error"></span>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary submitBtn">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
    
@endsection

@section('js')

<script type="text/javascript" src="{{ asset('public/customjs/tyre/index.js') }}?v={{ uniqid() }}"></script>

@endsection





