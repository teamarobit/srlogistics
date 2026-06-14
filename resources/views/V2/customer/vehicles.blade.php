@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
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
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Vehicle</th><th>Period</th><th>Allowed KM</th><th>Fixed Amount</th><th>Extra / KM</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">AS01GC4471</span><div class="cv2-t-sub">Tata LPT 1613 · 10T</div></td><td>01 Apr 26 – 31 Mar 27</td><td class="cv2-t-mono">8,000</td><td class="cv2-t-mono">₹85,000</td><td class="cv2-t-mono">₹22</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2VehicleModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">AS01HF9982</span><div class="cv2-t-sub">Ashok Leyland · 20T</div></td><td>01 Jan 26 – 31 Dec 26</td><td class="cv2-t-mono">10,000</td><td class="cv2-t-mono">₹1,10,000</td><td class="cv2-t-mono">₹26</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Active</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2VehicleModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
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
        <form id="cv2VehicleForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Vehicle Number <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="vehicle_id" style="width:100%;"><option value="">Choose vehicle</option><option>AS01GC4471 — Tata LPT 1613</option><option>AS01HF9982 — Ashok Leyland</option></select></div>
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
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
