@extends('layouts.app')

@section('css')
    
    <link rel="stylesheet" href="{{ asset('public/css/tyremanagement/vehicletyretagging.css') }}">
    
@endsection

@section('content')
    <div class="layout-wrapper">
        
        @include('includes.header')
        <!--bottom header-->
       
        <div class="vehicledtl-bd srlog-bdwrapper">
            
            <div class="topbar-bd">
                
                <div class="item1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h1>Tyre Management Details</h1>
                            </div>
                            <!--<div class="col-12 col-md-6 text-end">-->
                            <!--    <button class="btn btn-primary submitBtn mt-2 mb-2">Save</button>-->
                            <!--    <a href="{{ route('fleetdashboard.getVehicleDetails', $vehicle->id) }}" class="btn btn-secondary mt-2 mb-2">Close</a>-->
                            <!--</div>-->
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <form class="vehicle-itemtab pt-4" id="addTyreForm" action="{{ route('fleetdashboard.saveTyreDetails', $vehicle->id) }}">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="card left-wrap">
                                <h5>Truck Tyre Layout 6 Wheeler</h5>
                                <input hidden id="type" value="{{ $vehicle->mounted_tyre_count }}" />
                                <div id="container-img">
                                    <!-- SVG will be rendered here -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-9">
                            <h6>Mounted Tyre</h6>
                            @forelse($tyrepositions as $tyreposition)
                                @if(!in_array($tyreposition->code, ['S1']))
                                    <div id="{{ $tyreposition->code }}" class="card mt-4 mandtory_tyre_positions">
                                        <input type="hidden" value="{{ $tyreposition->id }}">
                                        <h6>Tyre Details - {{ $tyreposition->code }} <span class="text-danger" style="font-size: 14px">*</span></h6>
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addTyre" style="max-width: max-content; margin: 0 auto;">+ Add Tyre Details</button>
                                        
                                        <div class="row">
                                            <div class="col">
                                                <label>Tyre Conditions</label>
                                                <p class="mb-0">New</p>
                                            </div>
                                            <div class="col">
                                                <label>Tyre Serial Number</label>
                                                <p class="mb-0">789</p>
                                            </div>
                                            <div class="col">
                                                <label>Tyre Remaining Run KM</label>
                                                <p class="mb-0">15KM</p>
                                            </div>
                                            <div class="col">
                                                <label>Life%</label>
                                                <p class="life-percent badge mb-0">50%</p>
                                            </div>
                                            <div class="col text-end">
                                                <!--<label>Action</label>-->
                                                <!--<div class="icon-wrap">-->
                                                <!--    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addTyre"><i class="uil uil-pen"></i></a>-->
                                                <!--    <a href="javascript:void(0)" class="text-danger ms-1"><i class="uil uil-trash-alt"></i></a>-->
                                                <!--</div>-->
                                                <a href="tyre-action.php" class="btn btn-success p-3">Take Action</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                            
                            <hr>
                            <h6>Spare Tyre</h6>
                            <div class="spare-card-wrap">
                                <div class="card mt-4">
                                    <h6>Tyre Details - S1</h6>
                                    <div class="row">
                                        <div class="col">
                                            <label>Tyre Conditions</label>
                                            <p class="mb-0">New</p>
                                        </div>
                                        <div class="col">
                                            <label>Tyre Serial Number</label>
                                            <p class="mb-0">789</p>
                                        </div>
                                        <div class="col">
                                            <label>Tyre Remaining Run KM</label>
                                            <p class="mb-0">15KM</p>
                                        </div>
                                        <div class="col">
                                            <label>Life%</label>
                                            <p class="life-percent badge mb-0">20%</p>
                                        </div>
                                        <div class="col text-end">
                                            <!--<label>Action</label>-->
                                            <!--<div class="icon-wrap">-->
                                            <!--    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addTyre"><i class="uil uil-pen"></i></a>-->
                                            <!--    <a href="javascript:void(0)" class="text-danger ms-1"><i class="uil uil-trash-alt"></i></a>-->
                                            <!--</div>-->
                                            <a href="tyre-action.php" class="btn btn-success p-3">Take Action</a>
                                            <div class="icon-wrap">
                                                <a href="javascript:void(0)" class="text-danger"><i class="uil uil-trash-alt"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-4 spare-wrap text-center">
                                <h6>Tyre Details - S2</h6>
                                <!--<p class="text-center">No data found. Spare tyre details is not added yet</p>-->
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addTyre" style="max-width: max-content; margin: 0 auto;">+ Add Spare Tyre Details</button>
                                <a href="javascript:void(0)" class="btn btn-secondary mt-3 add-spare "><i class="uil uil-times-circle me-1"></i>Close</a>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-secondary mt-3 add-spare">+ Add Spare Tyre</a>
                        </div>
                        
                        <!--<div class="col-12 text-end mt-4">-->
                        <!--    <button type="button" id="addTyreBtn" class="btn btn-primary">Save</button>-->
                        <!--    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <!--</div>-->
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!--Modal-->
    <div class="modal fade" id="addTyre" tabindex="-1" aria-labelledby="addTyreText" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="addTyreText">Add Tyre</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label>Tyre Condition<span class="text-danger ms-1">*</span></label>
                    <select class="form-select">
                        <option value="">Select Tyre Condition</option>
                        <option value="New">New</option>
                        <option value="Re-thread">Rethread</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tyre Type<span class="text-danger ms-1">*</span></label>
                    <select class="form-select">
                        <option value="">Select Tyre Type</option>
                        <option value="Radial">Radial</option>
                        <option value="Nylon">Nylon</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tyre<span class="text-danger ms-1">*</span></label>
                    <select class="form-select">
                        <option>Select Tyre</option>
                        <option>C1</option>
                        <option>D1</option>
                        <option>Co3</option>
                        <option>Ci2</option>
                        <option>Di2</option>
                        <option>Do3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Fitment Date<span class="text-danger ms-1">*</span></label>
                    <input type="date" class="form-control">
                </div>
                <div class="form-group">
                    <label>Km at Fitment<span class="text-danger ms-1">*</span></label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" aria-describedby="basic-addon2">
                      <span class="input-group-text" id="basic-addon2">KM</span>
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('js')
<script>
    const sixWheelTruckPath = "{{ asset('public/arobittyre_management/6-wheel-new.svg') }}";
    const tenWheelTruckPath = "{{ asset('public/arobittyre_management/10-wheel-new.svg') }}";
</script>

<script type="text/javascript" src="{{ asset('public/arobittyre_management/fleet-tyre.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/customjs/tyremanagement/vehicletyretagging.js') }}?v={{ uniqid() }}"></script>


@endsection


