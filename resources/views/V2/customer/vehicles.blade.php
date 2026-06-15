@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Vehicle Allocation</div></div>
        @include('V2.customer.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Allocated Vehicles</h3>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2VehicleModal"><i class="bi bi-plus-lg"></i>Allocate Vehicle</button>
            </div>
            <div class="cv2-card-b is-flush" id="cv2VehiclesList" data-list-url="{{ route('contact.v2.customer.vehicles.list', $c['id']) }}">
                <div class="text-center cv2-empty" style="padding:24px;">Loading…</div>
            </div>
        </div>
    </div></div>
</div>

{{-- Allocate Vehicle modal --}}
<div class="modal fade cv2-modal" id="cv2VehicleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Allocate Vehicle</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2VehicleForm" action="{{ route('contact.v2.customer.vehicle.save') }}" method="POST" data-list-url="{{ route('contact.v2.customer.vehicles.list', $c['id']) }}">
          @csrf
          <input type="hidden" name="contact_id" value="{{ $c['id'] }}">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Vehicle Number <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="vehicle_id" style="width:100%;">
                <option value="">Choose vehicle</option>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                @endforeach
              </select>
            </div>
            <div class="cv2-field"><label class="cv2-label">Start Date <span class="req">*</span></label><input type="date" name="v_start_date"></div>
            <div class="cv2-field"><label class="cv2-label">End Date <span class="req">*</span></label><input type="date" name="v_end_date"></div>
            <div class="cv2-field is-full"><label class="cv2-label">KM Allowed <span class="req">*</span></label><input type="text" name="v_allowed_km"></div>
            <div class="cv2-field"><label class="cv2-label">Fixed Amount <span class="req">*</span></label><input type="text" name="v_fixed_amount" placeholder="₹"></div>
            <div class="cv2-field"><label class="cv2-label">Extra Amount / KM <span class="req">*</span></label><input type="text" name="v_extra_amount_per_km" placeholder="₹"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2VehicleForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Allocate</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.4') }}"></script>@endsection
