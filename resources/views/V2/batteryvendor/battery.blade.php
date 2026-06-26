@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
@php
    $statusClass = ['In Stock'=>'is-active','Installed'=>'is-inactive','In Repair'=>'is-warn','Condemned'=>'is-black','Disposed'=>'is-black'];
@endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.batteryvendor.index') }}">Battery Vendors</a> · {{ $v['company'] }} · Battery</div></div>
        @include('V2.batteryvendor.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <form method="GET" action="{{ route('contact.v2.batteryvendor.battery', $v['id']) }}" class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Batteries Supplied by this Vendor</h3>
                <select class="cv2-select" name="brand" onchange="this.form.submit()">
                    <option value="">All Brands</option>
                    @foreach($brands as $b)
                        <option value="{{ $b }}" {{ $search_brand === $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
                <select class="cv2-select" name="bstatus" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ $search_status === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
                <button type="button" class="cv2-btn cv2-btn-primary cv2-btn-sm" id="cv2AddBatteryBtn" data-bs-toggle="modal" data-bs-target="#cv2BatteryModal"><i class="bi bi-plus-lg"></i>Add Battery</button>
            </form>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Serial No</th><th>Brand</th><th>Model</th><th>Capacity</th><th>Voltage</th><th>Warranty</th><th>Purchase Date</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($batteries as $bat)
                        <tr>
                            <td class="cv2-t-mono">{{ $bat->battery_serial }}</td>
                            <td>{{ $bat->battery_brand }}</td>
                            <td>{{ $bat->battery_model ?? '—' }}</td>
                            <td class="cv2-t-mono">{{ rtrim(rtrim(number_format($bat->battery_capacity, 2), '0'), '.') }} Ah</td>
                            <td class="cv2-t-mono">{{ $bat->battery_voltage }}</td>
                            <td>{{ $bat->battery_warranty_months ? $bat->battery_warranty_months.' mo' : '—' }}</td>
                            <td>{{ $bat->battery_purchase_date ? $bat->battery_purchase_date->format('d M y') : '—' }}</td>
                            <td><span class="cv2-badge {{ $statusClass[$bat->current_status] ?? 'is-inactive' }}"><span class="cv2-badge-dot"></span>{{ $bat->current_status }}</span></td>
                            <td class="cv2-actions">
                                <a href="javascript:void(0)" class="cv2-ic-btn cv2-edit-battery" data-id="{{ $bat->id }}" title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-battery-item" data-id="{{ $bat->id }}" title="Delete"><i class="bi bi-trash3"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center cv2-empty">No batteries linked to this vendor yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="cv2-pager">
                <span>Showing {{ $batteries->firstItem() ?? 0 }}–{{ $batteries->lastItem() ?? 0 }} of {{ $batteries->total() }}</span>
                {{ $batteries->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div></div>
</div>

{{-- Add / Edit Battery modal --}}
<div class="modal fade cv2-modal" id="cv2BatteryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="cv2BatteryModalTitle">Add Battery</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2BatteryForm"
              action="{{ route('contact.v2.batteryvendor.battery.save') }}"
              data-save-url="{{ route('contact.v2.batteryvendor.battery.save') }}"
              data-update-base="{{ url('contacts/v2/battery-vendors/battery') }}"
              data-get-base="{{ url('contacts/v2/battery-vendors/battery') }}">
          @csrf
          <input type="hidden" name="vendor_id" value="{{ $v['id'] }}">
          <input type="hidden" name="battery_id" id="cv2BatteryId" value="">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Serial No <span class="req">*</span></label><input type="text" name="battery_serial" placeholder="e.g. AMR-TT-00231"></div>
            <div class="cv2-field"><label class="cv2-label">Brand <span class="req">*</span></label><input type="text" name="battery_brand" placeholder="e.g. Amaron"></div>
            <div class="cv2-field"><label class="cv2-label">Model</label><input type="text" name="battery_model" placeholder="Model no"></div>
            <div class="cv2-field"><label class="cv2-label">Capacity (Ah) <span class="req">*</span></label><input type="number" step="0.01" name="battery_capacity" placeholder="150"></div>
            <div class="cv2-field"><label class="cv2-label">Voltage <span class="req">*</span></label><input type="text" name="battery_voltage" placeholder="e.g. 12V" maxlength="10"></div>
            <div class="cv2-field"><label class="cv2-label">Warranty (months)</label><input type="number" name="battery_warranty_months" placeholder="48" min="0"></div>
            <div class="cv2-field"><label class="cv2-label">Purchase Date</label><input type="date" name="battery_purchase_date"></div>
            <div class="cv2-field"><label class="cv2-label">Unit Price (₹)</label><input type="number" step="0.01" name="battery_purchase_cost" placeholder="0" min="0"></div>
            <div class="cv2-field"><label class="cv2-label">Status</label>
              <div class="cv2-radio-group">
                @foreach($statuses as $i => $st)
                <span class="cv2-radio"><input type="radio" name="current_status" id="bs_{{ $i }}" value="{{ $st }}" {{ $i === 0 ? 'checked' : '' }}><label for="bs_{{ $i }}">{{ $st }}</label></span>
                @endforeach
              </div>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Remarks</label><textarea name="battery_notes" rows="2" placeholder="Optional"></textarea></div>
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
@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.7') }}"></script>
<script src="{{ asset('js/V2/batteryvendor.js?v=2.0') }}"></script>
@endsection
