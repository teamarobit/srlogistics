@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
@php $lock = !empty($isExited) ? 'is-locked' : ''; @endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Driver Bhatta</div></div>
        @include('V2.driver.partials.workspace-head')

        <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(4,1fr);">
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-wallet2"></i></span></div><div class="cv2-kpi-val">₹0</div><div class="cv2-kpi-lbl">Opening Balance ({{ $d['hisab'] }})</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-arrow-down-circle"></i></span></div><div class="cv2-kpi-val">₹33,600</div><div class="cv2-kpi-lbl">Total Credit</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-arrow-up-circle"></i></span></div><div class="cv2-kpi-val">₹28,200</div><div class="cv2-kpi-lbl">Total Debit</div></div>
            <div class="cv2-kpi"><div class="cv2-kpi-top"><span class="cv2-kpi-ic is-warn"><i class="bi bi-cash-stack"></i></span></div><div class="cv2-kpi-val">₹5,400</div><div class="cv2-kpi-lbl">Current Balance (Cr)</div></div>
        </div>

        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Bhatta Ledger</h3>
                <select class="cv2-select"><option>All Types</option><option>Credit</option><option>Debit</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm {{ $lock }}" data-bs-toggle="modal" data-bs-target="#cv2BhattaModal"><i class="bi bi-plus-lg"></i>Add Bhatta Entry</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Date</th><th>Trip / Reference</th><th>Particulars</th><th>Type</th><th style="text-align:right;">Amount</th><th style="text-align:right;">Balance</th></tr></thead>
                    <tbody>
                        <tr><td>12 Jun 26</td><td class="cv2-t-mono">TRIP-4471-118</td><td>GHY → DBR trip allowance</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Credit</span></td><td class="cv2-t-mono" style="text-align:right;">₹2,400</td><td class="cv2-t-mono" style="text-align:right;">₹5,400</td></tr>
                        <tr><td>09 Jun 26</td><td class="cv2-t-mono">FUEL-9920</td><td>Diesel advance</td><td><span class="cv2-badge is-black"><span class="cv2-badge-dot"></span>Debit</span></td><td class="cv2-t-mono" style="text-align:right;">₹3,000</td><td class="cv2-t-mono" style="text-align:right;">₹3,000</td></tr>
                        <tr><td>05 Jun 26</td><td class="cv2-t-mono">TRIP-4471-115</td><td>GHY → SCL trip allowance</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Credit</span></td><td class="cv2-t-mono" style="text-align:right;">₹2,800</td><td class="cv2-t-mono" style="text-align:right;">₹6,000</td></tr>
                        <tr><td>01 Jun 26</td><td class="cv2-t-mono">ADV-2210</td><td>Cash advance</td><td><span class="cv2-badge is-black"><span class="cv2-badge-dot"></span>Debit</span></td><td class="cv2-t-mono" style="text-align:right;">₹3,200</td><td class="cv2-t-mono" style="text-align:right;">₹3,200</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="cv2-pager"><span>Showing 1–4 of 14</span><div class="cv2-pages"><a href="javascript:void(0)" class="is-active">1</a><a href="javascript:void(0)">2</a><a href="javascript:void(0)">3</a></div></div>
        </div>
    </div></div>
</div>

<div class="modal fade cv2-modal" id="cv2BhattaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Bhatta Entry</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2BhattaForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Date <span class="req">*</span></label><input type="date" name="entry_date"></div>
            <div class="cv2-field"><label class="cv2-label">Type <span class="req">*</span></label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="entry_type" id="bt_cr" value="Credit"><label for="bt_cr">Credit</label></span>
                <span class="cv2-radio"><input type="radio" name="entry_type" id="bt_dr" value="Debit"><label for="bt_dr">Debit</label></span>
              </div>
            </div>
            <div class="cv2-field"><label class="cv2-label">Trip / Reference</label><input type="text" name="reference"></div>
            <div class="cv2-field"><label class="cv2-label">Amount (₹) <span class="req">*</span></label><input type="number" name="amount" min="0"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Particulars</label><textarea name="particulars" rows="2"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2BhattaForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Entry</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=1.0') }}"></script>@endsection
