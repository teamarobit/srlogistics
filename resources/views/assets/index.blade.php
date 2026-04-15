@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/Assets/index.css?v=1.0') }}">
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
                                <h5 class="d-inline-block mb-0">Asset Master</h5>
                                <a href="{{ route('asset.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Add Asset</a>
                                <form action="{{ route('asset.index') }}" id="searchform" class="d-inline-block">
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                        <select name="status" id="search_status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="Assigned" {{ request('status')=='Assigned' ? 'selected' : '' }}>Assigned</option>
                                            <option value="Unassigned" {{ request('status')=='Unassigned' ? 'selected' : '' }}>Unassigned</option>
                                        </select>
                                    </div>
                                    
                                    <a href="{{ route('asset.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                                    
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <table class="table table-hover invoice-table mb-0">
                            <thead>
                                <tr>
                                    <th>Asset Name</th>
                                    <th>Asset Type</th>
                                    <th>Asset Id</th>
                                    <th>Purchase Date</th>
                                    <th>Warranty</th>
                                    <th>Warranty End</th>
                                    <!--<th>Amount</th>-->
                                    <th style="width: 100px">Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($datas as $data)
                                <tr>
                                    <td>{{ $data->name ?? '-' }}</td>
                                    
                                    @php
                                        $typeClass = match($data->type) {
                                            'Motor Vehicle' => 'bg-success',
                                            'Electronics'   => 'bg-warning',
                                            default         => 'bg-secondary',
                                        };
                                    @endphp
                                    <td><span class="badge {{ $typeClass }}">{{ $data->type ?? '-' }}</span></td>
                                    <td>{{ $data->asset_no ?? '-' }}</td>
                                    <td>
                                        {{ $data->issue_date 
                                            ? \Carbon\Carbon::parse($data->issue_date)->format('d-m-Y') 
                                            : '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $start = $data->warranty_start_date;
                                            $end   = $data->warranty_end_date;
                                        @endphp
                                    
                                        @if($start && $end)
                                            {{ \Carbon\Carbon::parse($start)->diff(\Carbon\Carbon::parse($end))->format('%y Year(s) %m Month(s) %d Day(s)') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $data->warranty_end_date 
                                            ? \Carbon\Carbon::parse($data->warranty_end_date)->format('d-m-Y') 
                                            : '-' }}
                                    </td>
                                    {{--<td>₹ {{ number_format($data->amount ?? 0, 2) }}</td>--}}
                                    
                                    <td>
                                        <div class="employee-etc profile-status">
                                            <span class="btn btn-secondary dropdown-toggle">
                                                @if($data->is_assigned)
                                                    <i class="fa fa-dot-circle-o text-success mr-2"></i>
                                                    Assigned
                                                @else
                                                    <i class="fa fa-dot-circle-o text-danger mr-2"></i>
                                                    Unassigned
                                                @endif
                                                
                                                <i class="uil uil-angle-down ml-1"></i>
                                            </span>
                                        </div>
                                    </td>
                                    
                                    
                                    
                                    {{--<td>
                                        <div class="dropdown employee-etc profile-status">
                                    
                                            <span class="btn btn-secondary dropdown-toggle"
                                                  data-bs-toggle="dropdown"
                                                  aria-expanded="false">
                                    
                                                @if($data->status == 'Assigned')
                                                    <i class="fa fa-dot-circle-o text-success me-2"></i>
                                                    Assigned
                                                @else
                                                    <i class="fa fa-dot-circle-o text-danger me-2"></i>
                                                    Unassigned
                                                @endif
                                    
                                            </span>
                                    
                                            <ul class="dropdown-menu">
                                    
                                                @if($data->status != 'Unassigned')
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('asset.changestatus', [$data->id, 'Unassigned']) }}">
                                                        <i class="fa fa-dot-circle-o text-danger me-2"></i>
                                                        Unassign
                                                    </a>
                                                </li>
                                                @endif
                                    
                                                @if($data->status != 'Assigned')
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('asset.changestatus', [$data->id, 'Assigned']) }}">
                                                        <i class="fa fa-dot-circle-o text-success me-2"></i>
                                                        Assign
                                                    </a>
                                                </li>
                                                @endif
                                    
                                            </ul>
                                        </div>
                                    </td>--}}

                                    <td class="text-end">
                                        <div class="dropdown dot-dd">
                                          <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-h"></i>
                                          </span>
                                          <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                            <li><a class="dropdown-item" href="{{ route('asset.edit',$data->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                            {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $data->id }}" data-actmodelid="37" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                          </ul>
                                        </div>
                                    </td>
                                    
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
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
    var ASSETS        = "{{route('asset.index')}}";
    
    var DELETE_ASSET  = "{{route('asset.delete')}}";
    
   
</script>
<script type="text/javascript" src="{{ asset('js/Assets/index.js') }}"></script>
@endsection