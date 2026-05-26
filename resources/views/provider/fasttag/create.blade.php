@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Provider/fasttag-create.css?v=1.2') }}">


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
                            <div class="col-12 col-md-12">
                                {{-- breadcrumb --}}
                                <div class="ft-breadcrumb">
                                    <a href="{{ route('adminconsole.index') }}">Admin Console</a>
                                    <span class="sep">›</span>
                                    <span>Provider Master</span>
                                    <span class="sep">›</span>
                                    <a href="{{ route('fasttagprovider.index') }}">Fasttag Provider</a>
                                    <span class="sep">›</span>
                                    Add Fasttag Provider
                                </div>
                                <h5>Add Fasttag Provider</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                  <div class="container-fluid">

                    <form action="{{route('fasttagprovider.save')}}" method="POST" id="addForm">
                        @csrf

                      <div class="form-group row pb-1">
                        <div class="col-12 col-md-3">
                            <label for="provider_name">Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="provider_name" id="provider_name" value="" class="form-control">
                            <small class="error text-danger" id="add_provider_name_error"></small>
                        </div>
                      </div>


                      <div class="form-group row">

                          <div class="col-12 col-md-3">
                              <label for="status_active">Status <span class="text-danger">*</span></label>
                          </div>

                          <div class="col-12 col-md-6">
                              <div class="d-flex flex-wrap">
                                  <div class="form-check d-flex me-2">
                                      <input class="form-check-input" type="radio" name="status" id="status_active" value="Active" autocompleted="">
                                      <label class="form-check-label" for="status_active">
                                          Active
                                      </label>
                                  </div>

                                  <div class="form-check d-flex">
                                      <input class="form-check-input" type="radio" name="status" id="status_inactive" value="Inactive" autocompleted="">
                                      <label class="form-check-label" for="status_inactive">
                                          Inactive
                                      </label>
                                  </div>
                              </div>
                              <small class="error text-danger" id="add_status_error"></small>
                          </div>

                      </div>



                      <div class="text-right">
                          <button type="button" class="btn btn-primary mb-4" id="addBtn">Save</button>

                          <a href="{{ route('fasttagprovider.index') }}" class="btn btn-danger mb-4"> Close </a>
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

<div id="fasttag-create-data"
     data-listing-url="{{ route('fasttagprovider.index') }}"
     style="display:none;"></div>

<script type="text/javascript" src="{{asset('customjs/provider/fasttag/create.js?v=1.1')}}"></script>

@endsection




