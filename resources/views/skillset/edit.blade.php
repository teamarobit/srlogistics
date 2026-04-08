@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/add-designation.css') }}">

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
                                <h5>Edit Skill Set</h5>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="addroute-bd">
                      <div class="container-fluid">

                         <form action="{{route('skillset.update')}}" method="POST" id="editForm">
                            @csrf
                            
                            <input type="hidden" name="skillsetid" id="edit_skillsetid_input" value="{{ $skillset->id }}">
                            
                          <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Skill Set  <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="skillset_name" value="{{ $skillset->name ?? '' }}" class="form-control">
                                <small class="error text-danger" id="edit_skillset_name_error"></small>
                            </div>
                          </div>
                          
                          <div class="form-group row pb-1">
                            <div class="col-12 col-md-3">
                                <label>Pre-requisite & Notes </label>
                            </div>
                            <div class="col-12 col-md-6">
                                <textarea name="pre_requisite_notes" class="form-control" rows="3" placeholder="">{{ $skillset->pre_requisite_notes ?? '' }}</textarea>
                                <small class="error text-danger" id="edit_pre_requisite_notes_error"></small>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row pb-">
                              <div class="col-12 col-md-3"><label>Status <span class="text-danger">*</span></label></div>
    
                              <div class="col-12 col-md-6">
                                  <div class="d-flex flex-wrap">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="Active" {{ $skillset->status == 'Active' ? 'checked' : '' }} >
                                          <label class="form-check-label" for="exampleRadios1">
                                              Active
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="Inactive" {{ $skillset->status == 'Inactive' ? 'checked' : '' }} >
                                          <label class="form-check-label" for="exampleRadios2">
                                              Inactive
                                          </label>
                                      </div>
                                  </div>
                                  <small class="error text-danger" id="edit_status_error"></small>
                              </div>
                              
                          
                          </div>
                          

                          <div class="text-right">
                              <button class="btn btn-dark mb-4" id="editBtn">Save</button>
                              
                              <a href="{{ route('skillset.index') }}" class="btn btn-danger mb-4"> Close </a>
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
var SKILLSETS = "{{ route('skillset.index') }}";
</script>

<script type="text/javascript" src="{{asset('public/customjs/skillset/edit.js')}}"></script>

@endsection