@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Rate Chart</div></div>
        @include('V2.customer.partials.workspace-head')
        @php
            $allPricings = $contractPricings->flatten();
            $vehTypeData = $vehicletypes->map(function ($vt) {
                return [
                    'id'    => $vt->id,
                    'name'  => $vt->name,
                    'sizes' => $vt->sizes->map(function ($s) { return ['id' => $s->id, 'name' => $s->name]; })->values(),
                ];
            })->values();
            $vtSizes = [];
            foreach ($vehicletypes as $vt) {
                $vtSizes[$vt->id] = $vt->sizes->map(function ($s) { return ['id' => $s->id, 'name' => $s->name]; })->values();
            }
        @endphp
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Contract Pricing</h3>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2RateModal"><i class="bi bi-plus-lg"></i>Add Rate Chart</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Route</th><th>Vehicle Type / Size</th><th>Freight</th><th>Applicable</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($allPricings as $pricing)
                            @php $veh = $pricing->vehicles->first(); @endphp
                            <tr>
                                <td>
                                    <span class="cv2-t-name">{{ optional(optional($pricing->contractroute)->route)->name ?? '—' }}</span>
                                    <div class="cv2-t-sub">{{ optional($pricing->customerContract)->contract_no ?? '' }}</div>
                                </td>
                                <td>
                                    @forelse($pricing->vehicles as $v)
                                        {{ optional($v->vehicleType)->name ?? '—' }} · {{ optional($v->vehicleTypeSize)->name ?? '—' }}@if(!$loop->last)<br>@endif
                                    @empty — @endforelse
                                </td>
                                <td class="cv2-t-mono">{{ $veh ? '₹'.number_format($veh->price ?? 0, 2) : '—' }}</td>
                                <td>
                                    {{ $pricing->applicable_start_date ? \Carbon\Carbon::parse($pricing->applicable_start_date)->format('d M y') : '—' }} – {{ $pricing->applicable_end_date ? \Carbon\Carbon::parse($pricing->applicable_end_date)->format('d M y') : '—' }}
                                </td>
                                <td class="cv2-actions">
                                    <a href="javascript:void(0)" class="cv2-ic-btn cv2-pricing-labour" data-id="{{ $pricing->id }}" title="Labour charges"><i class="bi bi-people"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn cv2-pricing-vehicles" data-id="{{ $pricing->id }}" title="Vehicle freight"><i class="bi bi-truck"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn cv2-pricing-history" data-id="{{ $pricing->id }}" title="History"><i class="bi bi-clock-history"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-pricing" data-id="{{ $pricing->id }}" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center cv2-empty">No rate charts added yet.</td></tr>
                        @endforelse
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
        <form id="cv2RateForm" action="{{ route('contact.v2.customer.contract.pricing.save') }}" method="POST"
              data-routes-url="{{ url('contacts/v2/customers/contract') }}"
              data-points-setup-url="{{ url('contacts/v2/customers/contract') }}"
              data-ratechart-url="{{ route('contact.v2.customer.ratechart', $c['id']) }}">
          @csrf
          <input type="hidden" name="contact_id" value="{{ $c['id'] }}">
          <input type="hidden" name="midpoint_count" id="cv2MidpointCount" value="0">
          <script type="application/json" id="cv2VehTypeData">{!! json_encode($vehTypeData) !!}</script>
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Contract <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="customercontract_id" id="cv2RateContract" style="width:100%;">
                <option value="">Choose contract</option>
                @foreach($contracts as $contract)
                    @php
                        $today  = \Carbon\Carbon::today();
                        $status = 'Inactive';
                        if ($contract->contract_type_id == 6) { $status = 'Life Time'; }
                        elseif ($contract->start_date && $contract->end_date && $contract->start_date <= $today && $contract->end_date >= $today) { $status = 'Active'; }
                    @endphp
                    <option value="{{ $contract->id }}" data-status="{{ $status }}">{{ $contract->contract_no }} ({{ $status }})</option>
                @endforeach
              </select>
            </div>
            <div class="cv2-field"><label class="cv2-label">Route <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="customercontract_route_id" id="cv2RateRoute" style="width:100%;"><option value="">Choose route</option></select>
            </div>
            <div class="cv2-field"><label class="cv2-label">Source Loading Point <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="contract_source_city_id" id="cv2RateSource" style="width:100%;"><option value="">Choose source</option></select>
            </div>
            <div class="cv2-field"><label class="cv2-label">Destination Unloading Point <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="contract_destination_city_id" id="cv2RateDest" style="width:100%;"><option value="">Choose destination</option></select>
            </div>
            <div class="cv2-field"><label class="cv2-label">Applicable Date Range <span class="req">*</span></label><input type="text" class="cv2-daterange" id="cv2AppRange" data-start="#cv2AppStart" data-end="#cv2AppEnd" placeholder="Select date range" readonly><input type="hidden" name="applicable_start_date" id="cv2AppStart"><input type="hidden" name="applicable_end_date" id="cv2AppEnd"></div>
            <div class="cv2-field"><label class="cv2-label">Retrospective Date Range <span class="req">*</span></label><input type="text" class="cv2-daterange" id="cv2RetroRange" data-start="#cv2RetroStart" data-end="#cv2RetroEnd" placeholder="Select date range" readonly><input type="hidden" name="retrospective_start_date" id="cv2RetroStart"><input type="hidden" name="retrospective_end_date" id="cv2RetroEnd"></div>
          </div>

          <div id="cv2MidpointSections"></div>

          <div style="display:flex;align-items:center;justify-content:space-between;margin:18px 0 10px;">
            <p class="cv2-section-title" style="margin:0;">Vehicle Pricing <span class="req">*</span></p>
            <a href="javascript:void(0)" class="cv2-link" id="cv2AddVehRow"><i class="bi bi-plus-lg"></i> Add vehicle</a>
          </div>
          <div id="cv2VehRows">
            <div class="cv2-veh-row">
              <div class="cv2-field"><label class="cv2-label">Vehicle Type</label>
                <select class="cv2-select cv2-modal-select" name="vehicle_type_id[]" style="width:100%;">
                  <option value="">Type</option>
                  @foreach($vehicletypes as $vt)
                      <option value="{{ $vt->id }}" data-sizes='{!! json_encode($vtSizes[$vt->id]) !!}'>{{ $vt->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="cv2-field"><label class="cv2-label">Vehicle Size</label>
                <select class="cv2-select cv2-modal-select" name="vehicletype_size_id[]" style="width:100%;"><option value="">Size</option></select>
              </div>
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
{{-- Generic result modal for labour charges / vehicle freight / history --}}
<div class="modal fade cv2-modal" id="cv2InfoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" id="cv2InfoModalContent">
      <div class="modal-header"><h5 class="modal-title" id="cv2InfoTitle">Details</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body" id="cv2InfoBody"></div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.7') }}"></script>@endsection
                                            