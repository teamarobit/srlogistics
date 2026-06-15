@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.index') }}">Tyre Vendors</a> · {{ $v['company'] }} · Tyre</div></div>
        @include('V2.tyrevendor.partials.workspace-head')

        {{-- E4: supplied-items sub-page (Tyre). NO size field (E7). --}}
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Supplied Tyres</h3>
                <select class="cv2-select"><option>All Status</option><option>In Stock</option><option>Fitted</option><option>Scrapped</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2TyreModal"><i class="bi bi-plus-lg"></i>Add Tyre</button>
            </div>
            <div class="cv2-card-b is-flush">
                @if($v['tyres'] > 0)
                <table class="cv2-table">
                    <thead><tr><th>Serial No</th><th>Brand</th><th>Pattern</th><th>Position</th><th>Purchase Date</th><th>Cost</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td class="cv2-t-mono">TYR-MRF-0091</td><td><span class="cv2-t-name">MRF</span></td><td>Steel Muscle S1J4</td><td>Front-Left</td><td>14 Apr 26</td><td class="cv2-t-mono">₹22,400</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Fitted</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2TyreModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td class="cv2-t-mono">TYR-MRF-0092</td><td><span class="cv2-t-name">MRF</span></td><td>Steel Muscle S1J4</td><td>—</td><td>14 Apr 26</td><td class="cv2-t-mono">₹22,400</td><td><span class="cv2-badge is-warn"><span class="cv2-badge-dot"></span>In Stock</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2TyreModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td class="cv2-t-mono">TYR-MRF-0093</td><td><span class="cv2-t-name">MRF</span></td><td>ZVTV</td><td>Rear-Right</td><td>02 Mar 26</td><td class="cv2-t-mono">₹19,900</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>Scrapped</span></td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2TyreModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
                @else
                <div class="cv2-empty"><i class="bi bi-record-circle"></i><h4>No tyres supplied yet</h4><p>Tyres received from this vendor will appear here.</p></div>
                @endif
            </div>
            @if($v['tyres'] > 0)
            <div class="cv2-pager">
                <span>Showing 1–3 of {{ $v['tyres'] }}</span>
                <div class="cv2-pages">
                    <a href="javascript:void(0)"><i class="bi bi-chevron-left"></i></a>
                    <a href="javascript:void(0)" class="is-active">1</a>
                    <a href="javascript:void(0)">2</a>
                    <a href="javascript:void(0)"><i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
            @endif
        </div>
    </div></div>
</div>

{{-- Add Tyre modal (E4) --}}
<div class="modal fade cv2-modal" id="cv2TyreModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Tyre</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2TyreForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Serial No <span class="req">*</span></label><input type="text" name="serial_no" placeholder="TYR-XXXX-0000"></div>
            <div class="cv2-field"><label class="cv2-label">Brand <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="brand" style="width:100%;"><option value="">Choose brand</option><option>MRF</option><option>Apollo</option><option>JK Tyre</option><option>CEAT</option><option>Bridgestone</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Pattern</label><input type="text" name="pattern" placeholder="e.g. Steel Muscle"></div>
            <div class="cv2-field"><label class="cv2-label">Position</label><select class="cv2-select cv2-modal-select" name="position" style="width:100%;"><option value="">Unassigned</option><option>Front-Left</option><option>Front-Right</option><option>Rear-Left</option><option>Rear-Right</option><option>Spare</option></select></div>
            <div class="cv2-field"><label class="cv2-label">Purchase Date</label><input type="date" name="purchase_date"></div>
            <div class="cv2-field"><label class="cv2-label">Cost (₹)</label><input type="text" name="cost" placeholder="22400"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Status</label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="tyre_status" id="ts_stock" value="In Stock" checked><label for="ts_stock">In Stock</label></span>
                <span class="cv2-radio"><input type="radio" name="tyre_status" id="ts_fit" value="Fitted"><label for="ts_fit">Fitted</label></span>
                <span class="cv2-radio"><input type="radio" name="tyre_status" id="ts_scrap" value="Scrapped"><label for="ts_scrap">Scrapped</label></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2TyreForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Tyre</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
