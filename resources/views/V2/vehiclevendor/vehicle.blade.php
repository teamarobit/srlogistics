@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · {{ $v['company'] }} · Vehicle</div></div>
        @include('V2.vehiclevendor.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Supplied Vehicles</h3>
                <select class="cv2-select"><option>All Types</option><option>Truck</option><option>Trailer</option><option>Container</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2VehicleModal"><i class="bi bi-plus-lg"></i>Add Vehicle</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Vehicle No</th><th>Type</th><th>Capacity</th><th>Ownership</th><th>Model Year</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">AS01GC7741</span><div class="cv2-t-sub">Tata LPT 1613</div></td><td><span class="cv2-pill">Truck</span></td><td class="cv2-t-mono">10 T</td><td>Owned</td><td class="cv2-t-mono">2021</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2VehicleModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">AS01HF9920</span><div class="cv2-t-sub">Ashok Leyland 2820</div></td><td><span class="cv2-pill">Trailer</span></td><td class="cv2-t-mono">20 T</td><td>Leased</td><td class="cv2-t-mono">2020</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2VehicleModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">AS01JK3310</span><div class="cv2-t-sub">BharatBenz 1217C</div></td><td><span class="cv2-pill">Container</span></td><td class="cv2-t-mono">12 T</td><td>Owned</td><td class="cv2-t-mono">2022</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>Inactive</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2VehicleModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Vehicle modal --}}
<div class="modal fade cv2-modal" id="cv2VehicleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Supplied Vehicle</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2VehicleForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Vehicle Number <span class="req">*</span></label><input type="text" name="vehicle_no" placeholder="AS01GC7741"></div>
            <div class="cv2-field"><label class="cv2-label">Vehicle Type <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="vehicle_type_id" style="width:100%;"><option value="">Choose type</option><option>Truck</option><option>Trailer</option><option>Container</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Capacity (Tonnes) <span class="req">*</span></label><input type="text" name="capacity" placeholder="10"></div>
            <div class="cv2-field"><label class="cv2-label">Ownership <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="ownership" style="width:100%;"><option value="">Choose</option><option>Owned</option><option>Leased</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Model Year</label><input type="text" name="model_year" placeholder="2021"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Status <span class="req">*</span></label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="v_status" id="vs_act" value="Active" checked><label for="vs_act">Active</label></span>
                <span class="cv2-radio"><input type="radio" name="v_status" id="vs_ina" value="Inactive"><label for="vs_ina">Inactive</label></span>
              </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Remarks</label><textarea name="remarks" rows="2" placeholder="Optional"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2VehicleForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Vehicle</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/vehiclevendor.js?v=1.0') }}"></script>@endsection
