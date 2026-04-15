@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/external-billing.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ws.dashboard') }}">Workshop</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ws.external.dispatch') }}">External Dispatch</a></li>
                    <li class="breadcrumb-item active">Billing</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">External Workshop Billing</h5>
                    <span class="text-muted" style="font-size:12px;">Invoices received from external workshops &amp; ASCs — payment tracking</span>
                </div>
                <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#recordInvoiceModal">
                    <i class="uil uil-plus me-1"></i> Record Invoice
                </button>
            </div>

            {{-- Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-invoice"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹2.8L</div><div class="sc-stat-label">Pending Payment</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-file-alt"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">7</div><div class="sc-stat-label">Open Invoices</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹6.1L</div><div class="sc-stat-label">Paid This Month</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-shield-slash"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">₹42K</div><div class="sc-stat-label">Under Warranty</div></div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end p-1">
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Payment Status</label>
                        <select class="form-select form-select-sm">
                            <option value="">All</option>
                            <option>Pending</option>
                            <option>Paid</option>
                            <option>Under Dispute</option>
                            <option>Warranty — No Charge</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">SC Type</label>
                        <select class="form-select form-select-sm">
                            <option value="">All</option>
                            <option>Brand ASC</option>
                            <option>Third Party</option>
                            <option>Warranty</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="sc-form-label">External Workshop / Vendor</label>
                        <select class="form-select form-select-sm select2-extbill-vendor" multiple></select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Invoice From</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <button class="btn btn-outline-secondary btn-sm w-100 mt-1"><i class="uil uil-times"></i></button>
                    </div>
                </div>
            </div>

            {{-- Billing Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Dispatch #</th>
                                <th>Vehicle</th>
                                <th>Workshop</th>
                                <th>Type</th>
                                <th>Invoice Date</th>
                                <th>Invoice Amt (₹)</th>
                                <th>Warranty Cover</th>
                                <th>Net Payable (₹)</th>
                                <th>Payment Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $bills = [
                                ['EINV-2026-0007','EXT-2026-0004','RJ-14-GA-1111','Eicher Pro 3015','Eicher ASC, Jaipur','Brand ASC','10-Apr-2026',148000,0,148000,'pending'],
                                ['EINV-2026-0006','EXT-2026-0005','GJ-03-ZZ-7890','Tata 407 LPT','Ram Auto Works','Third Party','09-Apr-2026',32500,0,32500,'pending'],
                                ['EINV-2026-0005','EXT-2026-0006','DL-01-CD-4567','Bharat Benz 2523','Benz ASC, Delhi','Warranty','08-Apr-2026',42000,42000,0,'warranty'],
                                ['EINV-2026-0004','EXT-2026-0002','HR-26-YZ-8877','Ashok Leyland 1916','AL Auth SC, Hsr','Brand ASC','01-Apr-2026',95000,0,95000,'paid'],
                                ['EINV-2026-0003','EXT-2026-0001','PB-10-CD-3344','Eicher 5016','Third Party WS','Third Party','25-Mar-2026',28000,0,28000,'dispute'],
                                ['EINV-2026-0002','EXT-2026-0009','TN05-IJ-7890','Tata Prima 5530','Tata Motors ASC','Brand ASC','20-Mar-2026',76500,0,76500,'paid'],
                                ['EINV-2026-0001','EXT-2026-0008','KA-05-AB-1234','Tata Prima 4928','Tata Motors ASC','Brand ASC','15-Mar-2026',54000,0,54000,'paid'],
                            ];
                            $billStatusMap   = ['pending'=>'sc-ext-bill-pending','paid'=>'sc-ext-bill-paid','dispute'=>'sc-ext-bill-dispute','warranty'=>'sc-ext-bill-warranty'];
                            $billStatusLabel = ['pending'=>'Pending','paid'=>'Paid','dispute'=>'Under Dispute','warranty'=>'Warranty — No Charge'];
                            $typeMap = ['Brand ASC'=>'sc-ext-brand','Third Party'=>'sc-ext-third','Warranty'=>'sc-ext-warranty'];
                            @endphp
                            @foreach($bills as $b)
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;color:#032671;">{{ $b[0] }}</td>
                                <td><a href="{{ route('ws.external.dispatch') }}" style="font-size:12px;color:#032671;font-weight:600;">{{ $b[1] }}</a></td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">{{ $b[2] }}</span>
                                        <span class="sc-veh-model">{{ $b[3] }}</span>
                                    </div>
                                </td>
                                <td style="font-size:12px;">{{ $b[4] }}</td>
                                <td><span class="{{ $typeMap[$b[5]] }}">{{ $b[5] }}</span></td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $b[6] }}</td>
                                <td style="font-size:12px;font-weight:600;">₹{{ number_format($b[7]) }}</td>
                                <td style="font-size:12px;">@if($b[8] > 0) <span class="sc-ext-bill-warranty">₹{{ number_format($b[8]) }}</span> @else <span class="text-muted">—</span> @endif</td>
                                <td style="font-size:12px;font-weight:700;color:{{ $b[9] > 0 ? '#032671' : '#10863f' }};">@if($b[9] > 0) ₹{{ number_format($b[9]) }} @else Nil @endif</td>
                                <td><span class="{{ $billStatusMap[$b[10]] }}">{{ $billStatusLabel[$b[10]] }}</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Invoice" data-bs-toggle="modal" data-bs-target="#invoiceDetailModal"><i class="uil uil-eye"></i></button>
                                        @if($b[10] === 'pending')
                                        <button class="sc-action-btn" title="Record Payment" data-bs-toggle="modal" data-bs-target="#recordPaymentModal" style="color:#10863f;border-color:#10863f;"><i class="uil uil-money-bill"></i></button>
                                        <button class="sc-action-btn" title="Mark Dispute" data-bs-toggle="modal" data-bs-target="#disputeModal" style="color:#EA0027;border-color:#EA0027;"><i class="uil uil-exclamation-triangle"></i></button>
                                        @endif
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Record Invoice Modal --}}
<div class="modal fade" id="recordInvoiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-invoice me-2"></i>Record External Workshop Invoice</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="sc-form-label">Dispatch # <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-dispatch-ref" style="width:100%;"></select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Invoice # <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="Invoice number from external workshop">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Invoice Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Invoice Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Warranty Covered Amount (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00 — leave blank if not applicable">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">GST / Tax (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Work Done Summary</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Brief description of work done by external workshop..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Parts Cost (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Labour Cost (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Documents Attached</label>
                        <div class="d-flex flex-wrap gap-3 mt-1">
                            @foreach(['Invoice Copy','Job Card Copy','Parts Challan','Warranty Certificate','Photos (After Repair)'] as $doc)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="billdoc_{{ $loop->index }}">
                                <label class="form-check-label" for="billdoc_{{ $loop->index }}" style="font-size:12px;">{{ $doc }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Save Invoice</button>
            </div>
        </div>
    </div>
</div>

{{-- Invoice Detail Modal --}}
<div class="modal fade" id="invoiceDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-file-alt me-2"></i>Invoice — EINV-2026-0007</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- Invoice summary card --}}
                <div class="sc-ext-inv-summary mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Vehicle</div>
                            <div class="sc-veh-cell mt-1">
                                <span class="sc-reg-badge">RJ-14-GA-1111</span>
                                <span class="sc-veh-model">Eicher Pro 3015</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Workshop</div>
                            <div style="font-size:12px;margin-top:4px;">Eicher ASC, Jaipur</div>
                        </div>
                        <div class="col-6">
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Dispatch #</div>
                            <div style="font-size:12px;color:#032671;font-weight:600;margin-top:4px;">EXT-2026-0004</div>
                        </div>
                        <div class="col-6">
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Invoice Date</div>
                            <div style="font-size:12px;margin-top:4px;">10-Apr-2026</div>
                        </div>
                    </div>
                </div>
                {{-- Cost breakdown --}}
                <table class="table sc-table mb-3">
                    <thead>
                        <tr><th>Item</th><th class="text-end">Amount (₹)</th></tr>
                    </thead>
                    <tbody>
                        <tr><td style="font-size:12px;">Engine rebuild — parts</td><td class="text-end" style="font-size:12px;">₹98,000</td></tr>
                        <tr><td style="font-size:12px;">Labour charges</td><td class="text-end" style="font-size:12px;">₹32,000</td></tr>
                        <tr><td style="font-size:12px;">GST @ 18%</td><td class="text-end" style="font-size:12px;">₹18,000</td></tr>
                        <tr class="table-active">
                            <td style="font-size:12px;font-weight:700;">Total</td>
                            <td class="text-end" style="font-size:13px;font-weight:700;color:#032671;">₹1,48,000</td>
                        </tr>
                        <tr><td style="font-size:12px;color:#adb5bd;">Warranty Covered</td><td class="text-end" style="font-size:12px;color:#adb5bd;">₹0</td></tr>
                        <tr>
                            <td style="font-size:12px;font-weight:700;color:#10863f;">Net Payable</td>
                            <td class="text-end" style="font-size:13px;font-weight:700;color:#10863f;">₹1,48,000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size:11px;color:#6c757d;">Payment Status:</span>
                    <span class="sc-ext-bill-pending">Pending</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn sc-btn-navy btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#recordPaymentModal">Record Payment</button>
            </div>
        </div>
    </div>
</div>

{{-- Record Payment Modal --}}
<div class="modal fade" id="recordPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-money-bill me-2"></i>Record Payment</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="sc-ext-inv-summary mb-3 d-flex align-items-center justify-content-between" style="background:#f8f9fc;border:1px solid #e4e7ef;border-radius:6px;padding:10px 14px;">
                    <div>
                        <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;">Invoice</div>
                        <div style="font-size:13px;color:#032671;font-weight:700;">EINV-2026-0007</div>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;">Net Payable</div>
                        <div style="font-size:14px;font-weight:700;color:#032671;">₹1,48,000</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="sc-form-label">Payment Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Amount Paid (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Payment Mode <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option>NEFT / RTGS</option>
                            <option>Cheque</option>
                            <option>Cash</option>
                            <option>UPI</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Transaction Ref / Cheque #</label>
                        <input type="text" class="form-control form-control-sm" placeholder="UTR / Cheque number">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any notes on partial payment or deductions..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm" style="background:#10863f;border-color:#10863f;color:#fff;">Confirm Payment</button>
            </div>
        </div>
    </div>
</div>

{{-- Dispute Modal --}}
<div class="modal fade" id="disputeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-exclamation-triangle me-2" style="color:#EA0027;"></i>Flag Invoice Dispute</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Dispute Reason <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option value="">— Select reason —</option>
                            <option>Overcharged — Parts Cost</option>
                            <option>Overcharged — Labour Cost</option>
                            <option>Work Quality Issue</option>
                            <option>Warranty Not Applied</option>
                            <option>Duplicate Invoice</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Disputed Amount (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="Amount being disputed">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Expected Resolution By</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Dispute Details <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Describe the dispute clearly..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm" style="background:#EA0027;border-color:#EA0027;color:#fff;">Flag Dispute</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(function() {
    $('.select2-extbill-vendor, .select2-dispatch-ref').select2({ width: '100%', placeholder: 'Search...', dropdownParent: $('body') });
});
</script>
@endsection
