@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/srlbranch-master-list.css') }}">

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

                    <div class="topbar">
                       <div class="container-fluid page-head">
                          <div class="row align-items-end">
                              <div class="col-12">

                                  <h5 class="d-inline-block mb-0">Branch</h5>
                                  
                                  <a href="{{ route('branch.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Branch</a>
                                  
                                  <form action="{{ route('branch.index') }}" id="searchform" class="d-inline-block">
                                      <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                        <select name="type" id="search_branch_type" class="form-select">
                                            <option value="">Branch Type</option>
                                            <option value="Head Office"
                                                {{ request('type')=='Head Office' ? 'selected' : '' }}>
                                                Head Office
                                            </option>
                                            <option value="Branch Office"
                                                {{ request('type')=='Branch Office' ? 'selected' : '' }}>
                                                Branch Office
                                            </option>
                                        </select>
                                      </div>
                                      
                                      <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                          <!--<input type="text" class="form-control" placeholder="Filter by City" />-->
                                          <select name="city" id="search_city_id" class="form-select select2">
                                                <option value="">Filter by City</option>

                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ request('city') == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                          </select>
                                      </div>
                                      
                                      <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                        <select name="status" id="search_status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="Active" {{ $search_status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $search_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                      </div>
                                      
                                  </form>
                                  <a href="{{ route('branch.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
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
                                            <th>Branch Location</th>
                                            <th>Branch Head</th>
                                            <th>Branch Type</th>
                                            <th>Branch Start Date</th>
                                            <th>Number of Employee</th>
                                            <th>Branch Ownership</th>
                                            <th>City</th>
                                            <th>Created By</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse($branches as $branch)
                                        <tr>
                                            <td>{{ $branch->location ?? '' }}</td>
                                            <td>{{ $branch->head_name ?? '' }}</td>
                                            <td>
                                                {{ $branch->type 
                                                    ? implode(', ', json_decode($branch->type, true)) 
                                                    : '-' 
                                                }}
                                            </td>
                                            <td>{{ $branch->start_date ? \Carbon\Carbon::parse($branch->start_date)->format('d-m-Y') : '-' }}</td>
                                            <td>{{ $branch->no_of_employee ?? '' }}</td>
                                            <td>{{ $branch->branch_ownership ?? '' }}</td>
                                            <td>{{ $branch->city->name ?? '-' }}</td>
                                            <td>
                                                {{ $branch->createdBy->name ?? '-' }}
                                                <span class="text-secondary d-block">{{ $branch->createdBy->email ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $branch->status == 'Active' ? 'success' : 'danger' }}">
                                                    {{ $branch->status }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown dot-dd">
                                                  <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-h"></i>
                                                  </span>
                                                  <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                    <li><a class="dropdown-item" href="{{ route('branch.edit',$branch->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                    {{--<li><a class="dropdown-item text-danger deleteBranch" data-id="{{ $branch->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                                  </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">
                                                No branches found!
                                            </td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            
                            
                            @if ($branches->hasPages())
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination">
                            
                                    {{-- Previous --}}
                                    <li class="page-item {{ $branches->onFirstPage() ? 'disabled' : '' }}">
                                        @if ($branches->onFirstPage())
                                            <span class="page-link">Previous</span>
                                        @else
                                            <a class="page-link" href="{{ $branches->previousPageUrl() }}">Previous</a>
                                        @endif
                                    </li>
                            
                                    {{-- Page Numbers --}}
                                    @foreach ($branches->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $branches->currentPage() == $page ? 'active' : '' }}"
                                            aria-current="{{ $branches->currentPage() == $page ? 'page' : '' }}">
                                            
                                            @if ($branches->currentPage() == $page)
                                                <span class="page-link">{{ $page }}</span>
                                            @else
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                            
                                    {{-- Next --}}
                                    <li class="page-item {{ $branches->hasMorePages() ? '' : 'disabled' }}">
                                        @if ($branches->hasMorePages())
                                            <a class="page-link" href="{{ $branches->nextPageUrl() }}">Next</a>
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
    var BRANCHES = "{{ route('branch.index') }}";
    
    var DELETE_BRANCH  = "{{route('branch.delete')}}";
    
</script>
<script type="text/javascript" src="{{ asset('customjs/branch/index.js') }}?v={{ time() }}"></script>
@endsection