@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/add-vehicle-type.css') }}">

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
                            <div class="col-12 col-md-6">
                                <h5>Edit Department</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                  <div class="container-fluid">

                    <form action="{{route('department.update')}}" method="POST" id="addForm">
                        @csrf
                        
                        <input type="hidden" name="departmentid" id="edit_departmentid_input" value="{{ $department->id }}">

                      <div class="form-group row pb-1">
                        <div class="col-12 col-md-3">
                            <label>Department Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="department_name" value="{{ old('department_name', $department->name) }}" class="form-control">
                            <small class="error text-danger" id="add_department_name_error"></small>
                        </div>
                      </div>
                      
                      <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Department Head Name</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="department_head_name" value="{{ old('department_head_name', $department->department_head_name) }}" class="form-control">
                            <small class="error text-danger" id="add_department_head_name_error"></small>
                        </div>
                      </div>
                      
                      <div class="form-group row pb-1">
                          <div class="col-12 col-md-3">
                            <label>Number of Employees</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="number_of_employees" value="{{ old('number_of_employees', $department->no_of_employees) }}" class="form-control numericonly">
                            <small class="error text-danger" id="add_number_of_employees_error"></small>
                        </div>
                      </div>
                      
                      <div class="form-group row pb-1">
                        <div class="col-12 col-md-3">
                            <label>Branch </label>
                        </div>
                        <div class="col-12 col-md-6">
                            <select class="form-select select2" name="branch_id[]" multiple data-placeholder="Filter by branch"> 
                                <option value="">Filter by branch</option> 
                                @forelse ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ in_array($branch->id, $department->branches->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $branch->location }}
                                </option>
                                @empty
                                    <option value="" disabled>No branch available!</option>
                                @endforelse
                            </select>
                            <small class="error text-danger" id="add_branch_id_error"></small>
                            
                        </div>
                      </div>
                        
                        
                      <div class="form-group row pb-">

                          <div class="col-12 col-md-3">
                              <label>Status <span class="text-danger">*</span></label>
                          </div>

                          <div class="col-12 col-md-6">
                              <div class="d-flex flex-wrap">
                                  <div class="form-check d-flex me-2">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ $department->status == 'Active' ? 'checked' : '' }} >
                                      <label class="form-check-label" for="exampleRadios1">
                                          Active
                                      </label>
                                  </div>
    
                                  <div class="form-check d-flex">
                                      <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ $department->status == 'Inactive' ? 'checked' : '' }} >
                                      <label class="form-check-label" for="exampleRadios2">
                                          Inactive
                                      </label>
                                  </div>     
                              </div>
                              <small class="error text-danger" id="add_status_error"></small>
                          </div>
                          
                      </div>

                                             
                      
                      <div class="text-right">
                          <button class="btn btn-dark mb-4" id="addBtn">Save</button>
                          
                          <a href="{{ route('department.index') }}" class="btn btn-danger mb-4"> Close </a>
                      </div>

                  </form>                   
                  
                  </div>
                </div>

            </div>

        </div>
    </div>
            
</div>

@endsection

@section('js')

<script>
var DEPARTMENTS = "{{ route('department.index') }}";
</script>

<script type="text/javascript" src="{{asset('customjs/department/create.js')}}"></script>

@endsection