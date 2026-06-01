@extends('layouts.app')

@section('css')
<link href="{{ asset('css/lr/create.css?v=2.3') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    {{-- Full-width page — no sidebar (see frontend-design SKILL: full-width template) --}}
    <div class="srlog-bdwrapper lr-full-wrap">

        {{-- ══════════════════════════════════════════════════
             ACTION BAR — sticky, breadcrumb left / buttons right
        ══════════════════════════════════════════════════ --}}
        <div class="lr-action-bar d-flex align-items-center justify-content-between">
            <div>
                <div class="lr-breadcrumb">
                    <a href="{{ route('trip.index') }}">Trips</a>
                    <span class="lr-sep">›</span>
                    Add LR
                </div>
                <h5>Add LR</h5>
            </div>
            <div>
                {{--
                    SD-3: Submit handled via $.ajax() in create.js.
                    ACTION TODO: Change form action to route('trip.lr.store')
                    once that route is registered in routes/web.php.
                --}}
                <button type="submit" form="lrCreateForm" id="lr-save-btn"
                        class="btn btn-primary me-2" style="padding:8px 28px;">
                    Save LR
                </button>
                <a href="{{ route('trip.index') }}" class="btn btn-theme" style="padding:8px 28px;">
                    Close
                </a>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             MAIN FORM
             SD-1: No inline JS. All logic in js/lr/create.js.
             SD-3: Submit via $.ajax() — action="#" until store route exists.
        ══════════════════════════════════════════════════ --}}
        <form id="lrCreateForm" action="#" method="POST" novalidate>
            @csrf

            <div class="lr-content-pad">

                {{-- ── CARD 1: Trip Context ──────────────────── --}}
                <div class="lr-trip-banner">
                    <div class="lr-trip-chip">
                        <span class="lr-trip-chip-label">Source</span>
                        <span class="lr-trip-chip-value">Kolkata</span>
                    </div>
                    <div class="lr-trip-chip">
                        <span class="lr-trip-chip-label">Destination</span>
                        <span class="lr-trip-chip-value">Durgapur</span>
                    </div>
                    <div class="lr-trip-chip">
                        <span class="lr-trip-chip-label">Vehicle Number</span>
                        <span class="lr-trip-chip-value">WB-12-FV5667</span>
                    </div>
                    <div class="lr-trip-chip">
                        <span class="lr-trip-chip-label">Vehicle Size</span>
                        <span class="lr-trip-chip-value">32-FT SXL</span>
                    </div>
                </div>

                {{-- ── CARD 2: LR Details ────────────────────── --}}
                <div class="lr-form-card">
                    <p class="lr-section-title">LR Details</p>
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label" for="lr_number">
                                LR # <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="lr_number" id="lr_number"
                                   value="{{ old('lr_number') }}" maxlength="50" placeholder="e.g. LR-2025-001"
                                   autocomplete="off">
                            <span class="text-danger small d-block mt-1 lr-field-error" id="err-lr_number">
                                @error('lr_number'){{ $message }}@enderror
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="lr_party_number">LR Party #</label>
                            <input type="text" class="form-control" name="lr_party_number" id="lr_party_number"
                                   value="{{ old('lr_party_number') }}" maxlength="50" autocomplete="off">
                            <span class="text-danger small d-block mt-1 lr-field-error" id="err-lr_party_number"></span>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="lr_date">
                                LR Date <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control lr-datepicker" name="lr_date" id="lr_date"
                                   value="{{ old('lr_date') }}" placeholder="Select date" autocomplete="off" readonly>
                            <span class="text-danger small d-block mt-1 lr-field-error" id="err-lr_date">
                                @error('lr_date'){{ $message }}@enderror
                            </span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="lr_gross_weight">Gross Weight</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="gross_weight" id="lr_gross_weight"
                                       value="{{ old('gross_weight') }}" step="0.01" min="0" placeholder="0.00">
                                <span class="input-group-text">MT</span>
                            </div>
                            <span class="text-danger small d-block mt-1 lr-field-error" id="err-gross_weight"></span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="lr_seal_number">Seal Number(s)</label>
                            <input type="text" class="form-control" name="seal_numbers" id="lr_seal_number"
                                   value="{{ old('seal_numbers') }}" data-role="tagsinput"
                                   placeholder="Type and press Enter or comma">
                            <span class="text-danger small d-block mt-1 lr-field-error" id="err-seal_numbers"></span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="lr_transport_mode">Transport Mode</label>
                            <select class="form-select" name="transport_mode" id="lr_transport_mode">
                                <option value="">Select mode</option>
                                <option value="Road" {{ old('transport_mode') === 'Road' ? 'selected' : '' }}>Road</option>
                                <option value="Rail" {{ old('transport_mode') === 'Rail' ? 'selected' : '' }}>Rail</option>
                                <option value="Air"  {{ old('transport_mode') === 'Air'  ? 'selected' : '' }}>Air</option>
                                <option value="Sea"  {{ old('transport_mode') === 'Sea'  ? 'selected' : '' }}>Sea</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tarpaulin</label>
                            <div class="d-flex align-items-center gap-3 mt-1 pt-1">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="tarpaulin"
                                           id="tarp_yes" value="Yes"
                                           {{ old('tarpaulin') === 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tarp_yes">Yes</label>
                                </div>
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="tarpaulin"
                                           id="tarp_no" value="No"
                                           {{ old('tarpaulin', 'No') === 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tarp_no">No</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>{{-- /lr-form-card LR Details --}}

                {{-- ── CARD 3: Parties ───────────────────────── --}}
                <div class="lr-form-card">
                    <p class="lr-section-title">Parties</p>
                    <div class="row">
                        <div class="col-md-4 lr-party-col">
                            <p class="lr-party-label">Consigner Name &amp; Address</p>
                            <p class="lr-party-line">Britania Kolkata</p>
                            <p class="lr-party-line">13946 Desiree Burgs Suite 113</p>
                            <p class="lr-party-line">Port Clintonborough</p>
                            <p class="lr-party-line">Georgia 974-395</p>
                            <p class="lr-party-line mb-0">Phone: (006)-336-077</p>
                        </div>
                        <div class="col-md-4 lr-party-col">
                            <p class="lr-party-label">Consignee Name &amp; Address</p>
                            <p class="lr-party-line">Samsung Hydrabad</p>
                            <p class="lr-party-line">13946 Desiree Burgs Suite 113</p>
                            <p class="lr-party-line">Port Clintonborough</p>
                            <p class="lr-party-line">Georgia 974-395</p>
                            <p class="lr-party-line mb-0">Phone: (006)-336-077</p>
                        </div>
                        <div class="col-md-4 lr-party-col">
                            <p class="lr-party-label">Ship to Party Details</p>
                            <p class="lr-party-line">Samsung Hydrabad</p>
                            <p class="lr-party-line">13946 Desiree Burgs Suite 113</p>
                            <p class="lr-party-line">Port Clintonborough</p>
                            <p class="lr-party-line">Georgia 974-395</p>
                            <p class="lr-party-line mb-0">Phone: (006)-336-077</p>
                        </div>
                    </div>
                </div>{{-- /lr-form-card Parties --}}

                {{-- ── CARD 4: Items Table ───────────────────── --}}
                <div class="lr-items-card">
                    <div class="lr-items-card-head">
                        <p class="lr-section-title">Items</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table lr-items-table">
                            <thead>
                                <tr>
                                    <th style="width:42px;">S.N</th>
                                    <th style="width:148px;">
                                        Invoice Number
                                        <span class="th-sub">Invoice Date</span>
                                    </th>
                                    <th style="width:160px;">
                                        Product Name
                                        <span class="th-sub">Description</span>
                                    </th>
                                    <th style="width:88px;">No. of Units</th>
                                    <th style="width:128px;">
                                        CFT Volume
                                        <span class="th-sub">Weight (MT)</span>
                                    </th>
                                    <th style="width:110px;">Goods Value (₹)</th>
                                    <th style="width:158px;">
                                        EWAY Bill No.
                                        <span class="th-sub">EWAY Bill Date</span>
                                    </th>
                                    <th style="width:120px;">Valid Till</th>
                                    <th class="text-end" style="width:118px;">Freight Amt (₹)</th>
                                    <th style="width:42px;"></th>
                                </tr>
                            </thead>
                            <tbody id="lr-items-tbody">
                                {{-- Row 0 — always present, no delete icon --}}
                                <tr>
                                    <td class="lr-sn">1</td>
                                    <td>
                                        <input type="text"   class="form-control w-100 mb-1"
                                               name="items[0][invoice_number]" placeholder="Invoice No.">
                                        <input type="text"   class="form-control w-100 lr-datepicker"
                                               name="items[0][invoice_date]" placeholder="Select date" autocomplete="off" readonly>
                                    </td>
                                    <td>
                                        <input type="text"   class="form-control w-100 mb-1"
                                               name="items[0][product_name]" placeholder="Product name">
                                        <textarea           class="form-control w-100"
                                               name="items[0][description]" rows="1" placeholder="Description"></textarea>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control w-100"
                                               name="items[0][units]" min="0" step="1" placeholder="0">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control w-100 mb-1"
                                               name="items[0][cft_volume]" min="0" step="0.01" placeholder="0.00">
                                        <input type="number" class="form-control w-100"
                                               name="items[0][weight_mt]" min="0" step="0.01" placeholder="0.00">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control w-100"
                                               name="items[0][goods_value]" min="0" step="0.01" placeholder="0.00">
                                    </td>
                                    <td>
                                        <input type="text"   class="form-control w-100 mb-1"
                                               name="items[0][eway_bill_number]" placeholder="EWAY Bill No.">
                                        <input type="text"   class="form-control w-100 lr-datepicker"
                                               name="items[0][eway_bill_date]" placeholder="Select date" autocomplete="off" readonly>
                                    </td>
                                    <td>
                                        <input type="text"   class="form-control w-100 lr-datepicker"
                                               name="items[0][valid_till]" placeholder="Select date" autocomplete="off" readonly>
                                    </td>
                                    <td class="text-end">
                                        <input type="number" class="form-control w-100 lr-freight-input"
                                               name="items[0][freight_amount]" min="0" step="0.01" placeholder="0.00">
                                    </td>
                                    <td class="lr-delete-wrap">
                                        {{-- No delete icon on row 1 --}}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" class="text-end pe-3">Total Freight:</td>
                                    <td class="text-end">
                                        <span id="lr-freight-total">0.00</span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="lr-items-card-foot">
                        <button type="button" id="lr-add-item" class="btn btn-success btn-sm">
                            <i class="uil uil-plus me-1"></i> Add Item
                        </button>
                    </div>
                </div>{{-- /lr-items-card --}}

                {{-- ── CARD 5: Notes ────────────────────────── --}}
                <div class="lr-form-card">
                    <p class="lr-section-title">Notes</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" for="lr_notice">Notice</label>
                            <textarea class="form-control" name="notice" id="lr_notice"
                                      rows="3">{{ old('notice') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="lr_rules">Rules</label>
                            <textarea class="form-control" name="rules" id="lr_rules"
                                      rows="3">{{ old('rules') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="lr_remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="lr_remarks"
                                      rows="3">{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                </div>{{-- /lr-form-card Notes --}}

            </div>{{-- /lr-content-pad --}}
        </form>

    </div>{{-- /srlog-bdwrapper lr-full-wrap --}}

</div>{{-- /layout-wrapper --}}
@endsection

@section('js')
{{-- SD-1: All JS in external file. Path: public/js/lr/create.js --}}
<script src="{{ asset('js/lr/create.js?v=2.1') }}"></script>
@endsection
