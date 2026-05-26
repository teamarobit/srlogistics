@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/Provider/fasttag-edit.css?v=1.2') }}">


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
                                    Edit Fasttag Provider
                                </div>
                                <h5>Edit Fasttag Provider</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                  <div class="container-fluid">

                    <form action="{{route('fasttagprovider.update')}}" method="POST" id="editForm">
                        @csrf

                        <input type="hidden" name="recordid" id="edit_id_input" value="{{ $record->id }}">

                      <div class="form-group row pb-1">
                        <div class="col-12 col-md-3">
                            <label for="provider_name">Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" name="provider_name" id="provider_name" value="{{ $record->name ?? '' }}" class="form-control">
                            <small class="error text-danger" id="edit_provider_name_error"></small>
                        </div>
                      </div>



                      <div class="form-group row pb-">

                          <div class="col-12 col-md-3">
                              <label for="status_active">Status <span class="text-danger">*</span></label>
                          </div>

                          <div class="col-12 col-md-6 d-flex">
                              <div class="form-check d-flex me-2">
                                  <input class="form-check-input" type="radio" name="status" id="status_active" value="Active" {{ $record->status == 'Active' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="status_active">
                                      Active
                                  </label>
                              </div>

                              <div class="form-check d-flex">
                                  <input class="form-check-input" type="radio" name="status" id="status_inactive" value="Inactive" {{ $record->status == 'Inactive' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="status_inactive">
                                      Inactive
                                  </label>
                              </div>
                          </div>
                          <small class="error text-danger" id="edit_status_error"></small>
                      </div>



                      <div class="text-right">
                          <button type="button" class="btn btn-primary mb-4" id="editBtn">Save</button>

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

<div id="fasttag-edit-data"
     data-listing-url="{{ route('fasttagprovider.index') }}"
     style="display:none;"></div>

<script type="text/javascript" src="{{asset('customjs/provider/fasttag/edit.js?v=1.1')}}"></script>

@endsection
