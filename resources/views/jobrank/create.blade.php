@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/HR/jobrank-create.css') }}">


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
                                <h5>Add Job Rank</h5>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="addroute-bd">
                      <div class="container-fluid">

                        <form action="{{route('jobrank.save')}}" method="POST" id="addForm">
                            @csrf
                            
                          <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Department <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <select name="department_id" id="department_id" class="form-select select2">
                                    <option value="">Select Department</option>
                                
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error text-danger" id="add_department_id_error"></small>
                            </div>
                          </div> 

                          <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Designation  <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <select name="designation_id" id="designation_id" class="form-select select2">
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}">
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="error text-danger" id="add_designation_id_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Job Rank  <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="jobrank_name" id="jobrank_name" class="form-control">
                                <small class="error text-danger" id="add_jobrank_name_error"></small>
                            </div>
                          </div>
                          
                              
                        <div class="form-group row pb-">
                          <div class="col-12 col-md-3">
                              <label>Status <span class="text-danger">*</span></label>
                          </div>

                          <div class="col-12 col-md-6 d-flex">
                              <div class="form-check d-flex me-2">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active">
                                  <label class="form-check-label" for="exampleRadios1">
                                      Active
                                  </label>
                              </div>

                              <div class="form-check d-flex">
                                  <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive">
                                  <label class="form-check-label" for="exampleRadios2">
                                      Inactive
                                  </label>
                              </div>     
                          </div>
                          <small class="error text-danger" id="add_status_error"></small>
                        </div>
                          


                          <div class="text-right">
                              <button id="addBtn" class="btn btn-dark mb-4">Save</button>
                              
                              <a href="{{ route('jobrank.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var JOBRANKS = "{{ route('jobrank.index') }}";

var DESIGNATION_URL = "{{ route('designation.getDepartmentWiseDesignations', '__ID__') }}";
</script>

<script type="text/javascript" src="{{asset('customjs/jobrank/create.js')}}"></script>

@endsection




