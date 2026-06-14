@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Rate Chart</div></div>
        @include('V2.customer.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Contract Pricing</h3>
                <select class="cv2-select"><option>CTR-2026-014 (Monthly)</option><option>CTR-2025-188 (Lifetime)</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2RateModal"><i class="bi bi-plus-lg"></i>Add Rate Chart</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Route</th><th>Vehicle Type / Size</th><th>Freight</th><th>Applicable</th><th>TDS</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">Guwahati → Dibrugarh</span><div class="cv2-t-sub">via Jorhat · 1 midpoint</div></td><td>Truck · 10T</td><td class="cv2-t-mono">₹28,500</td><td>01 Apr 26 – 30 Jun 26</td><td><span class="cv2-pill">2%</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" title="Labour charges"><i class="bi bi-people"></i></a><a href="javascript:void(0)" class="cv2-ic-btn" title="Vehicle freight"><i class="bi bi-truck"></i></a><a href="javascript:void(0)" class="cv2-ic-btn" title="History"><i class="bi bi-clock-history"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Guwahati → Silchar</span><div class="cv2-t-sub">direct</div></td><td>Trailer · 20T</td><td class="cv2-t-mono">₹41,000</td><td>01 Apr 26 – 31 Mar 27</td><td><span class="cv2-pill">2%</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" title="Labour charges"><i class="bi bi-people"></i></a><a href="javascript:void(0)" class="cv2-ic-btn" title="Vehicle freight"><i class="bi bi-truck"></i></a><a href="javascript:void(0)" class="cv2-ic-btn" title="History"><i class="bi bi-clock-history"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="cv2-pager"><span><i class="bi bi-info-circle"></i> Pricing is immutable — edits create a new versioned snapshot (full history retained).</span></div>
        </div>
    </div></div>
</div>

{{-- Add Rate Chart modal --}}
<div class="modal fade cv2-modal" id="cv2RateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Rate Chart</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2RateForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Contract <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="customercontract_id" style="width:100%;"><option value="">Choose contract</option><option>CTR-2026-014 (Monthly)</option><option>CTR-2025-188 (Lifetime)</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Route <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="customercontract_route_id" style="width:100%;"><option value="">Choose route</option><option>Guwahati → Dibrugarh</option><option>Guwahati → Silchar</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Source Loading Point <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="contract_source_city_id" style="width:100%;"><option value="">Choose source</option><option>Guwahati</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Destination Unloading Point <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="contract_destination_city_id" style="width:100%;"><option value="">Choose destination</option><option>Dibrugarh</option><option>Silchar</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Applicable Date Range <span class="req">*</span></label><input type="text" class="cv2-daterange" name="applicable_date_range" placeholder="Select date range" readonly></div>
            <div class="cv2-field"><label class="cv2-label">Retrospective Date Range <span class="req">*</span></label><input type="text" class="cv2-daterange" name="retrospective_date_range" placeholder="Select date range" readonly></div>
          </div>

          <div style="display:flex;align-items:center;justify-content:space-between;margin:18px 0 10px;">
            <p class="cv2-section-title" style="margin:0;">Vehicle Pricing <span class="req">*</span></p>
            <a href="javascript:void(0)" class="cv2-link" id="cv2AddVehRow"><i class="bi bi-plus-lg"></i> Add vehicle</a>
          </div>
          <div id="cv2VehRows">
            <div class="cv2-veh-row">
              <div class="cv2-field"><label class="cv2-label">Vehicle Type</label><select class="cv2-select cv2-modal-select" name="vehicle_type_id[]" style="width:100%;"><option value="">Type</option><option>Truck</option><option>Trailer</option></select></div>
              <div class="cv2-field"><label class="cv2-label">Vehicle Size</label><select class="cv2-select cv2-modal-select" name="vehicletype_size_id[]" style="width:100%;"><option value="">Size</option><option>10T</option><option>20T</option></select></div>
              <div class="cv2-field"><label class="cv2-label">Weight</label><input type="text" name="vehicletype_weight[]"></div>
              <div class="cv2-field"><label class="cv2-label">Price (₹)</label><input type="text" name="vehicletype_price[]"></div>
              <div></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2RateForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Rate Chart</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
