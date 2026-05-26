@extends('layouts.app')

@section('css')


<link rel="stylesheet" href="{{ asset('css/hisabcategory/create.css') }}">

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
                                <h5>Add Hisab Category</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addroute-bd">
                    <div class="container-fluid">
                        <form>
                            
                            <div class="form-group row pb-1">
                                  <div class="col-12 col-md-3">
                                      <label>Hisab Category Name <span class="text-danger">*</span></label>
                                  </div>
        
                                  <div class="col-12 col-md-6 d-flex">
                                      <input type="text" class="form-control" />
                                  </div>
                            </div>
                            
                            <div class="form-group row pb-1">
                                  <div class="col-12 col-md-3">
                                      <label>Type <span class="text-danger">*</span></label>
                                  </div>
        
                                  <div class="col-12 col-md-6 d-flex">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="hisabType" id="hisab_line" value="line">
                                          <label class="form-check-label if-line" for="hisab_line">
                                              Line
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="hisabType" id="hisab_local" value="local">
                                          <label class="form-check-label if-local" for="hisab_local">
                                              Local
                                          </label>
                                      </div>                             
                                  </div>
                            </div>
                            
                            <!--<div class="line-wrap">-->
                            <!--    <div class="form-group row pb-1 align-items-center">-->
                            <!--      <div class="col-12 col-md-3">-->
                            <!--          <label>Any Local Customer</label>-->
                            <!--      </div>-->
        
                            <!--      <div class="col-12 col-md-6">-->
                            <!--          <input type="text" class="form-control" />-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <!--<div class="local-wrap">-->
                            <!--    <div class="form-group row pb-1 align-items-center">-->
                            <!--      <div class="col-12 col-md-3">-->
                            <!--          <label>Any Customer across India</label>-->
                            <!--      </div>-->
        
                            <!--      <div class="col-12 col-md-6">-->
                            <!--          <input type="text" class="form-control" />-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <div class="form-group row pb-1">
                                  <div class="col-12 col-md-3">
                                      <label>Hisab Category Type <span class="text-danger">*</span></label>
                                  </div>
        
                                  <div class="col-12 col-md-9 d-flex">
                                      <div class="form-check d-flex me-2 if-opt1">
                                          <input class="form-check-input" type="radio" name="bhattaType" id="bhatta_opt1" value="opt1">
                                          <label class="form-check-label" for="bhatta_opt1">
                                              Monthly Fixed + Diesel Margin
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex me-2 if-opt2">
                                          <input class="form-check-input" type="radio" name="bhattaType" id="bhatta_opt2" value="opt2">
                                          <label class="form-check-label" for="bhatta_opt2">
                                              Minimum Fixed+ Diesel Margin
                                          </label>
                                      </div>    
                                      
                                      <div class="form-check d-flex if-opt3">
                                          <input class="form-check-input" type="radio" name="bhattaType" id="bhatta_opt3" value="opt3">
                                          <label class="form-check-label" for="bhatta_opt3">
                                              Per KM  
                                          </label>
                                      </div>
                                  </div>
                            </div>
                            
                            <div class="opt1-wrap">
                                <div class="form-group row pb-1">
                                      <div class="col-12 col-md-3">
                                          <label>Bhatta Amount <span class="text-danger">*</span></label>
                                      </div>
            
                                      <div class="col-12 col-md-6 d-flex">
                                          <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="35,000" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">₹</span>
                                          </div>
                                      </div>
                                </div>
                            </div>
                            
                            <div class="opt2-wrap">
                                <div class="form-group row pb-1">
                                      <div class="col-12 col-md-3">
                                          <label>Bhatta Amount <span class="text-danger">*</span></label>
                                      </div>
            
                                      <div class="col-12 col-md-6 d-flex">
                                          <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="10,000" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">₹</span>
                                          </div>
                                      </div>
                                </div>
                            </div>
                            
                            <div class="opt3-wrap">
                                <div class="form-group row pb-1">
                                      <div class="col-12 col-md-3">
                                          <label>Bhatta Amount <span class="text-danger">*</span></label>
                                      </div>
            
                                      <div class="col-12 col-md-6 d-flex">
                                          <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="21" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">₹</span>
                                          </div>
                                      </div>
                                </div>
                            </div>
                            
                            <div class="form-group row pb-1">
                                  <div class="col-12 col-md-3">
                                      <label>Emission Type</label>
                                  </div>
        
                                  <div class="col-12 col-md-6 d-flex">
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="emissionType" id="opt1" value="opt1">
                                          <label class="form-check-label" for="opt1">
                                              BS3
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex me-2">
                                          <input class="form-check-input" type="radio" name="emissionType" id="opt2" value="opt2">
                                          <label class="form-check-label" for="opt2">
                                              BS3&4
                                          </label>
                                      </div>    
                                      
                                      <div class="form-check d-flex">
                                          <input class="form-check-input" type="radio" name="emissionType" id="opt3" value="opt3">
                                          <label class="form-check-label" for="opt3">
                                              BS6  
                                          </label>
                                      </div>
                                  </div>
                            </div>
                            
                            <div class="form-group row pb-1">
                                  <div class="col-12 col-md-3">
                                      <label>Fuel Mileage Fixed <span class="text-danger">*</span></label>
                                  </div>
        
                                  <div class="col-12 col-md-6 d-flex">
                                      <select class="form-select select2">
                                          <option>Choose</option>
                                          <option>5</option>
                                          <option>5.3</option>
                                          <option>6</option>
                                      </select>
                                  </div>
                                  
                                  <div class="col-12 col-md-3">
                                      <a href="javascript:void(0)" class="text-success" data-bs-toggle="modal" data-bs-target="#addMileage">+ Fuel Mileage Fixed</a>
                                  </div>
                            </div>
                            
                            <div class="card">
                                <div class="form-group row pb-1">
                                      <div class="col-12 col-md-3">
                                          <label>Border Expense <span class="text-danger">*</span></label>
                                      </div>
            
                                      <div class="col-12 col-md-9 d-flex">
                                          <div class="form-check d-flex me-2 if-driver">
                                              <input class="form-check-input" type="radio" name="borderEXP" id="driver" value="Driver">
                                              <label class="form-check-label" for="driver">
                                                  Driver
                                              </label>
                                          </div>
            
                                          <div class="form-check d-flex if-srl">
                                              <input class="form-check-input" type="radio" name="borderEXP" id="SRL" value="SRL">
                                              <label class="form-check-label" for="SRL">
                                                  SRL
                                              </label>
                                          </div> 
                                          
                                          <p class="srl-text text-success ms-5" style="font-size: 14px;">Border Expense will be paid by SRL</p>
                                      </div>
                                </div>
                                
                                <div class="driver-wrap">
                                    <div class="form-group row pb-1">
                                          <div class="col-12 col-md-3">
                                              <label>Capping Applicable <span class="text-danger">*</span></label>
                                          </div>
                
                                          <div class="col-12 col-md-9 d-flex">
                                              <div class="form-check d-flex me-2 if-cap-yes">
                                                  <input class="form-check-input" type="radio" name="capping" id="cap_yes" value="Yes">
                                                  <label class="form-check-label" for="cap_yes">
                                                      Yes
                                                  </label>
                                              </div>
                
                                              <div class="form-check d-flex if-cap-no">
                                                  <input class="form-check-input" type="radio" name="capping" id="cap_no" value="No">
                                                  <label class="form-check-label" for="cap_no">
                                                      No
                                                  </label>
                                              </div>
                                              
                                              <p class="cap-no-text text-success ms-5" style="font-size: 14px;">Border Expense will be paid by Driver</p>
                                          </div>
                                    </div>
                                </div>
                                
                                <div class="cap-yes-wrap">
                                    <div class="form-group row pb-1">
                                          <div class="col-12 col-md-3">
                                              <label>Border Capping Amount <span class="text-danger">*</span></label>
                                          </div>
                
                                          <div class="col-12 col-md-6">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" aria-describedby="basic-addon2">
                                                    <span class="input-group-text" id="basic-addon2">₹</span>
                                                </div>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <!--loading-->
                                <div class="form-group row pb-1">
                                      <div class="col-12 col-md-3">
                                          <label>Loading <span class="text-danger">*</span></label>
                                      </div>
            
                                      <div class="col-12 col-md-9 d-flex">
                                          <div class="form-check d-flex me-2 if-loading-driver">
                                              <input class="form-check-input" type="radio" name="Loading" id="load_driver" value="Load Driver">
                                              <label class="form-check-label" for="load_driver">
                                                  Driver
                                              </label>
                                          </div>
            
                                          <div class="form-check d-flex if-loading-srl">
                                              <input class="form-check-input" type="radio" name="Loading" id="load_SRL" value="Load SRL">
                                              <label class="form-check-label" for="load_SRL">
                                                  SRL
                                              </label>
                                          </div> 
                                          
                                          <p class="loading-srl-text text-success ms-5" style="font-size: 14px;">Loading charges will be paid by SRL</p>
                                      </div>
                                </div>
                                
                                <div class="loading-driver-wrap">
                                    <div class="form-group row pb-1">
                                          <div class="col-12 col-md-3">
                                              <label>Capping Applicable <span class="text-danger">*</span></label>
                                          </div>
                
                                          <div class="col-12 col-md-9 d-flex">
                                              <div class="form-check d-flex me-2 if-loading-cap-yes">
                                                  <input class="form-check-input" type="radio" name="load_capping" id="load_cap_yes" value="Loading Yes">
                                                  <label class="form-check-label" for="load_cap_yes">
                                                      Yes
                                                  </label>
                                              </div>
                
                                              <div class="form-check d-flex if-loading-cap-no">
                                                  <input class="form-check-input" type="radio" name="load_capping" id="load_cap_no" value="Loading No">
                                                  <label class="form-check-label" for="load_cap_no">
                                                      No
                                                  </label>
                                              </div>
                                              
                                              <p class="loading-cap-no-text text-success ms-5" style="font-size: 14px;">Loading charges will be paid by Driver</p>
                                          </div>
                                    </div>
                                </div>
                                
                                <div class="loading-cap-yes-wrap">
                                    <div class="form-group row pb-1">
                                          <div class="col-12 col-md-3">
                                              <label>Loading Capping Amount <span class="text-danger">*</span></label>
                                          </div>
                
                                          <div class="col-12 col-md-6">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" aria-describedby="basic-addon2">
                                                    <span class="input-group-text" id="basic-addon2">₹</span>
                                                </div>
                                          </div>
                                    </div>
                                </div>
                                <!------>
                            </div>
                            
                            <div class="card">
                                <!--unloading-->
                                <div class="form-group row pb-1">
                                      <div class="col-12 col-md-3">
                                          <label>Unloading <span class="text-danger">*</span></label>
                                      </div>
            
                                      <div class="col-12 col-md-9 d-flex">
                                          <div class="form-check d-flex me-2 if-unloading-driver">
                                              <input class="form-check-input" type="radio" name="Unloading" id="unload_driver" value="Unload Driver">
                                              <label class="form-check-label" for="unload_driver">
                                                  Driver
                                              </label>
                                          </div>
            
                                          <div class="form-check d-flex if-unloading-srl">
                                              <input class="form-check-input" type="radio" name="Unloading" id="unload_SRL" value="Unload SRL">
                                              <label class="form-check-label" for="unload_SRL">
                                                  SRL
                                              </label>
                                          </div> 
                                          
                                          <p class="unloading-srl-text text-success ms-5" style="font-size: 14px;">Unloading charges will be paid by SRL</p>
                                      </div>
                                </div>
                                
                                <div class="unloading-driver-wrap">
                                    <div class="form-group row pb-1">
                                          <div class="col-12 col-md-3">
                                              <label>Capping Applicable <span class="text-danger">*</span></label>
                                          </div>
                
                                          <div class="col-12 col-md-9 d-flex">
                                              <div class="form-check d-flex me-2 if-unloading-cap-yes">
                                                  <input class="form-check-input" type="radio" name="unload_capping" id="unload_cap_yes" value="Unloading Yes">
                                                  <label class="form-check-label" for="unload_cap_yes">
                                                      Yes
                                                  </label>
                                              </div>
                
                                              <div class="form-check d-flex if-unloading-cap-no">
                                                  <input class="form-check-input" type="radio" name="unload_capping" id="unload_cap_no" value="Unloading No">
                                                  <label class="form-check-label" for="unload_cap_no">
                                                      No
                                                  </label>
                                              </div>
                                              
                                              <p class="unloading-cap-no-text text-success ms-5" style="font-size: 14px;">Unloading charges will be paid by Driver</p>
                                          </div>
                                    </div>
                                </div>
                                
                                <div class="unloading-cap-yes-wrap">
                                    <div class="form-group row pb-1">
                                          <div class="col-12 col-md-3">
                                              <label>Unloading Capping Amount <span class="text-danger">*</span></label>
                                          </div>
                
                                          <div class="col-12 col-md-6">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" aria-describedby="basic-addon2">
                                                    <span class="input-group-text" id="basic-addon2">₹</span>
                                                </div>
                                          </div>
                                    </div>
                                </div>
                                <!------>
                            </div>
                            
                            <!--fooding-->
                            <div class="form-group row pb-1">
                                  <div class="col-12 col-md-3">
                                      <label>Fooding <span class="text-danger">*</span></label>
                                  </div>
        
                                  <div class="col-12 col-md-9 d-flex">
                                      <div class="form-check d-flex me-2 if-applicable">
                                          <input class="form-check-input" type="radio" name="fooding" id="applicable" value="Applicable">
                                          <label class="form-check-label" for="applicable">
                                              Applicable
                                          </label>
                                      </div>
        
                                      <div class="form-check d-flex if-NA">
                                          <input class="form-check-input" type="radio" name="fooding" id="na" value="NA">
                                          <label class="form-check-label" for="na">
                                              Not Applicable
                                          </label>
                                      </div> 
                                  </div>
                            </div>
                            
                            <div class="applicable-wrap">
                                <div class="form-group row pb-1">
                                      <div class="col-12 col-md-3">
                                          <label>Fooding Amount <span class="text-danger">*</span></label>
                                      </div>
            
                                      <div class="col-12 col-md-6">
                                          <div class="input-group mb-3">
                                                <input type="text" class="form-control" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2">₹</span>
                                          </div>
                                      </div>
                                </div>
                            </div>
                            <!------>
                          
                            <div class="text-right">
                                <button class="btn btn-dark mb-4">Save</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!--modal-->
<div class="modal fade" aria-labelledby="exampleModalLabel" aria-hidden="true" id="addMileage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Fuel Mileage Fixed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Fuel Mileage Fixed</label>
                        <input type="text" class="form-control" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')


<script type="text/javascript" src="{{ asset('customjs/hisabcategory/create.js') }}"></script>


@endsection
