@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/HR/skillset-index.css') }}">


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
                                <h5 class="d-inline-block mb-0">Skill Set</h5>
                                <a href="{{ route('skillset.create') }}" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Skill Set</a>
                                
                                <form action="{{ route('skillset.index') }}" id="searchform" class="d-inline-block">
                                    
                                    <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                        <input type="text" name="skillset" id="search_skillset" value="{{ old('skillset', $search_skillset_name) }}" class="form-control" placeholder="Search by Skill Set">
                                    </div>
                                    
                                </form>
                                
                                <a href="{{ route('skillset.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-hover invoice-table mb-0">
                            <thead>
                                <tr>
                                    <th>Skill Set</th>
                                    <th>Pre-requisite & Notes</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @forelse($skillsets as $key => $skillset)
                                    <tr>
                                        <td>{{ $skillset->name ?? '' }}</td>
                                        <td>{{ $skillset->pre_requisite_notes ?? '' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $skillset->status == 'Active' ? 'success' : 'danger' }}">
                                                {{ $skillset->status }}
                                            </span>
                                        </td>
                                        <td>
                                            {{$skillset->createdby?->name}}
                                            <span class="text-secondary d-block">{{$skillset->createdby?->email}}</span>
                                        </td>
                                        
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                              <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                              </span>
                                              <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="{{ route('skillset.edit', $skillset->id) }}"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                {{--<li><a class="dropdown-item text-danger deleteSkillset" data-id="{{ $skillset->id }}" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            No skill set found.
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                    
                    @if ($skillsets->hasPages())
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-end">
                    
                            {{-- Previous --}}
                            <li class="page-item {{ $skillsets->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $skillsets->previousPageUrl() }}">Previous</a>
                            </li>
                    
                            {{-- Page Numbers --}}
                            @foreach ($skillsets->getUrlRange(1, $skillsets->lastPage()) as $page => $url)
                                <li class="page-item {{ $skillsets->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                    
                            {{-- Next --}}
                            <li class="page-item {{ $skillsets->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $skillsets->nextPageUrl() }}">Next</a>
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
    var SKILLSETS = "{{ route('skillset.index') }}";
    
    var DELETE_SKILLSET  = "{{route('skillset.delete')}}";
    
</script>
<script type="text/javascript" src="{{ asset('customjs/skillset/index.js') }}"></script>

@endsection





