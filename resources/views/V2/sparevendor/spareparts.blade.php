@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.sparevendor.index') }}">Spare Vendors</a> · {{ $v['company'] }} · Spare Parts</div></div>
        @include('V2.sparevendor.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Supplied Spare Parts</h3>
                <select class="cv2-select"><option>All Categories</option><option>Engine Parts</option><option>Brake System</option><option>Filters</option><option>Transmission</option></select>
                <select class="cv2-select"><option>All Status</option><option>Available</option><option>On Order</option><option>Discontinued</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2SparePartModal"><i class="bi bi-plus-lg"></i>Add Spare Part</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Part</th><th>Category</th><th>Part No</th><th>Brand</th><th>Unit</th><th>Unit Price</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">Oil Filter — Element</span><div class="cv2-t-sub">Spin-on, full-flow</div></td><td><span class="cv2-pill">Filters</span></td><td class="cv2-t-mono">OF-2290</td><td>Bosch</td><td>Piece</td><td class="cv2-t-mono">₹340</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Available</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2SparePartModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Brake Pad Set (Front)</span><div class="cv2-t-sub">Ceramic, low dust</div></td><td><span class="cv2-pill">Brake System</span></td><td class="cv2-t-mono">BP-1180</td><td>TVS</td><td>Set</td><td class="cv2-t-mono">₹1,250</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Available</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2SparePartModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Clutch Plate</span><div class="cv2-t-sub">Heavy-duty</div></td><td><span class="cv2-pill">Transmission</span></td><td class="cv2-t-mono">CP-4471</td><td>Luk</td><td>Piece</td><td class="cv2-t-mono">₹2,890</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>On Order</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2SparePartModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Headlamp Assembly</span><div class="cv2-t-sub">LED, RHS</div></td><td><span class="cv2-pill">Electricals</span></td><td class="cv2-t-mono">HL-7780</td><td>Lumax</td><td>Piece</td><td class="cv2-t-mono">₹4,150</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Available</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2SparePartModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Spare Part modal --}}
<div class="modal fade cv2-modal" id="cv2SparePartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Spare Part</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2SparePartForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Part Name <span class="req">*</span></label><input type="text" name="part_name"></div>
            <div class="cv2-field"><label class="cv2-label">Category <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="category_id" style="width:100%;"><option value="">Choose category</option><option>Engine Parts</option><option>Brake System</option><option>Filters</option><option>Electricals</option><option>Transmission</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Part Number</label><input type="text" name="part_no"></div>
            <div class="cv2-field"><label class="cv2-label">Brand</label><input type="text" name="brand"></div>
            <div class="cv2-field"><label class="cv2-label">Unit</label><select class="cv2-select cv2-modal-select" name="unit" style="width:100%;"><option value="">Choose unit</option><option>Piece</option><option>Set</option><option>Litre</option><option>Box</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Unit Price (₹)</label><input type="number" name="unit_price" step="0.01"></div>
            <div class="cv2-field"><label class="cv2-label">Status</label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="part_status" id="ps_av" value="Available" checked><label for="ps_av">Available</label></span>
                <span class="cv2-radio"><input type="radio" name="part_status" id="ps_oo" value="On Order"><label for="ps_oo">On Order</label></span>
                <span class="cv2-radio"><input type="radio" name="part_status" id="ps_dc" value="Discontinued"><label for="ps_dc">Discontinued</label></span>
              </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Notes</label><textarea name="notes" rows="2"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2SparePartForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Spare Part</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>
<script src="{{ asset('js/V2/sparevendor.js?v=1.0') }}"></script>
@endsection
