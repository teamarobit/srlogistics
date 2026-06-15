@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · {{ $v['company'] }} · Route</div></div>
        @include('V2.vehiclevendor.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Routes Covered</h3>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2RouteModal"><i class="bi bi-plus-lg"></i>Add Route</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Route</th><th>Distance</th><th>Vehicle Type</th><th>Rate</th><th>Transit</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">Guwahati → Dibrugarh</span><div class="cv2-t-sub">NH-27 · via Nagaon</div></td><td class="cv2-t-mono">438 km</td><td><span class="cv2-pill">Truck 10T</span></td><td class="cv2-t-mono">₹28,000</td><td>1 day</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2RouteModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Guwahati → Silchar</span><div class="cv2-t-sub">NH-6 · hill route</div></td><td class="cv2-t-mono">315 km</td><td><span class="cv2-pill">Trailer 20T</span></td><td class="cv2-t-mono">₹34,500</td><td>2 days</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2RouteModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Dibrugarh → Tinsukia</span><div class="cv2-t-sub">NH-37</div></td><td class="cv2-t-mono">48 km</td><td><span class="cv2-pill">Container 12T</span></td><td class="cv2-t-mono">₹6,200</td><td>Same day</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>Inactive</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2RouteModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Route modal --}}
<div class="modal fade cv2-modal" id="cv2RouteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Route</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2RouteForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Source City <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="source_city_id" style="width:100%;"><option value="">Choose source</option><option>Guwahati</option><option>Dibrugarh</option><option>Silchar</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Destination City <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="destination_city_id" style="width:100%;"><option value="">Choose destination</option><option>Dibrugarh</option><option>Silchar</option><option>Tinsukia</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Distance (km) <span class="req">*</span></label><input type="text" name="distance_km" placeholder="438"></div>
            <div class="cv2-field"><label class="cv2-label">Vehicle Type <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="vehicle_type_id" style="width:100%;"><option value="">Choose type</option><option>Truck 10T</option><option>Trailer 20T</option><option>Container 12T</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Rate (₹) <span class="req">*</span></label><input type="text" name="rate" placeholder="28000"></div>
            <div class="cv2-field"><label class="cv2-label">Transit Time</label><input type="text" name="transit_time" placeholder="1 day"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Status <span class="req">*</span></label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="r_status" id="rs_act" value="Active" checked><label for="rs_act">Active</label></span>
                <span class="cv2-radio"><input type="radio" name="r_status" id="rs_ina" value="Inactive"><label for="rs_ina">Inactive</label></span>
              </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Remarks</label><textarea name="remarks" rows="2" placeholder="Via / notes"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2RouteForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Route</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/vehiclevendor.js?v=1.0') }}"></script>@endsection
