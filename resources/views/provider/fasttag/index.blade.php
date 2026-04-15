@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Provider/fasttag-index.css') }}">


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
                            
                            <h5 class="d-inline-block mb-0">Fasttag Provider</h5>
                            <a href="{{ route('fasttagprovider.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Fasttag Provider</a>
                            
                            <form action="{{ route('fasttagprovider.index') }}" id="searchform" class="d-inline-block">
                                <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                    <input type="text" name="name" id="search_name" value="{{ old('name', $search_name) }}" class="form-control" placeholder="Search by Name">
                                </div>
                                <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                      <select name="status" id="search_status" class="form-select select2">
                                          <option value="">Filter by Status</option>
                                          <option value="Active" {{ old('status', $search_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                          <option value="Inactive" {{ old('status', $search_status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                      </select>
                                </div>
                              
                            </form>
                            
                            <a href="{{ route('fasttagprovider.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover invoice-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse($datas as $key => $value)
                            <tr>
                                
                                <td>{{ $value->name ?? '' }}</td>
                                <td>{{ $value->code ?? '' }}</td>
                                <td>
                                    <span class="badge bg-{{ $value->status == 'Active' ? 'success' : 'danger' }}">
                                        {{ $value->status }}
                                    </span>
                                </td>
                                <td>
                                    {{$value->createdby?->name}}
                                    <span class="text-secondary d-block">{{$value->createdby?->email}}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                      <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="uil uil-ellipsis-h"></i>
                                      </span>
                                      <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                        <li><a class="dropdown-item" href="{{ route('fasttagprovider.edit', $value->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                        {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $value->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No data found.
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
    var LISTING      = "{{route('fasttagprovider.index')}}";
    
    var DELETE_DATA  = "{{route('fasttagprovider.delete')}}";
    
   
</script>
<script type="text/javascript" src="{{ asset('customjs/provider/fasttag/index.js') }}"></script>
@endsection