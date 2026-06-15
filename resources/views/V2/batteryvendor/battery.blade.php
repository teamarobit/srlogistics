@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.batteryvendor.index') }}">Battery Vendors</a> · {{ $v['company'] }} · Battery</div></div>
        @include('V2.batteryvendor.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Batteries Supplied by this Vendor</h3>
                <select class="cv2-select"><option>All Brands</option><option>Amaron</option><option>Exide</option><option>Luminous</option></select>
                <select class="cv2-select"><option>All Status</option><option>In Stock</option><option>Fitted</option><option>Scrapped</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2BatteryModal"><i class="bi bi-plus-lg"></i>Add Battery</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Serial No</th><th>Brand</th><th>Model</th><th>Capacity</th><th>Warranty</th><th>Purchase Date</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td class="cv2-t-mono">AMR-TT-00231</td><td>Amaron</td><td>AAM-TR-150</td><td class="cv2-t-mono">150 Ah</td><td>48 mo</td><td>10 May 26</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>In Stock</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2BatteryModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td class="cv2-t-mono">AMR-SMF-00198</td><td>Amaron</td><td>AAM-SMF-100</td><td class="cv2-t-mono">100 Ah</td><td>36 mo</td><td>02 May 26</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>Fitted</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2BatteryModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td class="cv2-t-mono">AMR-TT-00187</td><td>Amaron</td><td>AAM-TR-180</td><td class="cv2-t-mono">180 Ah</td><td>48 mo</td><td>21 Apr 26</td><td><span class="cv2-badge is-black"><span class="cv2-badge-dot"></span>Scrapped</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2BatteryModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="cv2-pager">
                <span>Showing 1–3 of {{ $counts['battery'] }}</span>
                <div class="cv2-pages">
                    <a href="javascript:void(0)"><i class="bi bi-chevron-left"></i></a>
                    <a href="javascript:void(0)" class="is-active">1</a>
                    <a href="javascript:void(0)">2</a>
                    <a href="javascript:void(0)"><i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div></div>
</div>

{{-- Add / Edit Battery modal --}}
<div class="modal fade cv2-modal" id="cv2BatteryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Battery</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2BatteryForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Serial No <span class="req">*</span></label><input type="text" name="serial_no" placeholder="e.g. AMR-TT-00231"></div>
            <div class="cv2-field"><label class="cv2-label">Brand <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="brand" style="width:100%;"><option value="">Choose brand…</option><option>Amaron</option><option>Exide</option><option>Luminous</option><option>SF Sonic</option><option>Okaya</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Model <span class="req">*</span></label><input type="text" name="model" placeholder="Model no"></div>
            <div class="cv2-field"><label class="cv2-label">Capacity (Ah) <span class="req">*</span></label><input type="number" name="capacity" placeholder="150"></div>
            <div class="cv2-field"><label class="cv2-label">Battery Type</label><select class="cv2-select cv2-modal-select" name="battery_type" style="width:100%;"><option value="">Choose type…</option><option>Tubular</option><option>SMF / VRLA</option><option>Flat Plate</option><option>Lithium</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Warranty (months)</label><input type="number" name="warranty_months" placeholder="48"></div>
            <div class="cv2-field"><label class="cv2-label">Purchase Date</label><input type="date" name="purchase_date"></div>
            <div class="cv2-field"><label class="cv2-label">Unit Price (₹)</label><input type="number" name="unit_price" placeholder="0"></div>
            <div class="cv2-field"><label class="cv2-label">Status</label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="battery_status" id="bs_stk" value="In Stock" checked><label for="bs_stk">In Stock</label></span>
                <span class="cv2-radio"><input type="radio" name="battery_status" id="bs_fit" value="Fitted"><label for="bs_fit">Fitted</label></span>
                <span class="cv2-radio"><input type="radio" name="battery_status" id="bs_scr" value="Scrapped"><label for="bs_scr">Scrapped</label></span>
              </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Remarks</label><textarea name="remarks" rows="2" placeholder="Optional"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2BatteryForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Battery</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
