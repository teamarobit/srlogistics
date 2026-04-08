@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/add-toll-master.css') }}">

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
                                  <h5 class="d-inline-block mb-0">Expense Type</h5>
                                  <a href="javascript:void(0)" class="btn btn-theme mb-0 ms-2" data-bs-toggle="modal" data-bs-target="#addModal"><i class="uil uil-plus me-1"></i>Expense Type</a>
                                  <form action="{{ route('expense.index') }}" method="GET" id="searchform" class="d-inline-block">
                                      <div class="search-wrap d-inline-block ms-2" style="width: 180px;">
                                          <input type="text" name="name" id="search_name" value="{{ $search_name ?? '' }}" class="form-control" placeholder="Search by Expense Type" />
                                      </div>
                                      
                                      <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                        <select name="status" id="search_status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="Active" {{ $search_status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $search_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                      </div>
                                  </form>
                                  
                                  <a href="{{ route('expense.index') }}" class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</a>
                                  
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
                                            <th>Expense Name</th>
                                            <th>Terms Of Expense</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse($datas as $value)
                                        <tr>
                                            <td>{{ $value->name ?? '-' }}</td>
                                            <td>{{ $value->terms_of_expense ?? '-' }}</td>
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
                                                    <li><a class="dropdown-item editRecord" data-id="{{ $value->id }}" href="javascript:void(0)"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                    {{--<li><a class="dropdown-item text-danger deleteRecord" data-id="{{ $value->id }}" data-actmodelid="14" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>--}}
                                                    
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

                            <!-- /////////////////////////////////// -->
                        </div>
                    </div>


                </div>

        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Expense Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
      </div>
      <div class="modal-body">
          
            <form action="{{route('expense.save')}}" method="POST" id="addForm">
                @csrf
                
                <div class="form-group">
                    <label>Expense Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"/>
                    <small class="error text-danger" id="add_name_error"></small>
                </div>
                
                <div class="form-group">
                    <label>Terms Of Expense </label>
                    <input type="text" name="terms_of_expense" class="form-control"/>
                    <small class="error text-danger" id="add_terms_of_expense_error"></small>
                </div>
                
                
                <div class="form-group row">
                    <div class="col-12 col-md-3">
                        <label>Status <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-12 col-md-6 d-flex">
                        <div class="form-check d-flex me-2">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" autocompleted="">
                            <label class="form-check-label" for="exampleRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check d-flex">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" autocompleted="">
                            <label class="form-check-label" for="exampleRadios2">
                                Inactive
                            </label>
                        </div>   
                    </div>
                    <small class="error text-danger" id="add_status_error"></small>
                </div>
                          
                <div class="text-end">
                    <button type="button" id="addBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
            
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vehicle Group</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
      </div>
      <div class="modal-body">
          
            <form action="{{route('expense.update')}}" method="POST" id="editForm">
                @csrf
                
                <input type="hidden" name="id" id="edit_id_input">
                
                <div class="form-group">
                    <label>Expense Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="edit_name_input" class="form-control"/>
                    <small class="error text-danger" id="edit_name_error"></small>
                </div>
                
                <div class="form-group">
                    <label>Terms Of Expense </label>
                    <input type="text" name="terms_of_expense" id="edit_terms_of_expense_input" class="form-control"/>
                    <small class="error text-danger" id="edit_terms_of_expense_error"></small>
                </div>
                
                
                
                <div class="form-group row">
                    <div class="col-12 col-md-3">
                        <label>Status <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-12 col-md-6 d-flex">
                        <div class="form-check d-flex me-2">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" autocompleted="">
                            <label class="form-check-label" for="exampleRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check d-flex">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" autocompleted="">
                            <label class="form-check-label" for="exampleRadios2">
                                Inactive
                            </label>
                        </div>   
                    </div>
                    <small class="error text-danger" id="edit_status_error"></small>
                </div>
                          
                <div class="text-end">
                    <button type="button" id="updateBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
            
      </div>
    </div>
  </div>
</div>



    
@endsection

@section('js')

<script>
var LISTING = "{{ route('expense.index') }}";
var EDIT_RECORD = "{{ route('expense.edit', ':id') }}";
var DELETE_RECORD = "{{ route('expense.delete') }}";
</script>

<script type="text/javascript" src="{{asset('public/customjs/expense/index.js')}}"></script>

@endsection



