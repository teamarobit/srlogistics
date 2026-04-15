@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/billing.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ws.dashboard') }}">Workshop</a></li>
                    <li class="breadcrumb-item active">Workshop Billing</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Workshop Billing</h5>
                    <span class="text-muted" style="font-size:12px;">Generate and manage workshop invoices</span>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="uil uil-export me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="uil uil-file-alt me-2"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="uil uil-file-pdf-alt me-2"></i>PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Summary Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-receipt-alt"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">18</div>
                            <div class="sc-stat-label">Pending Bills</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">₹ 1,24,500</div>
                            <div class="sc-stat-label">Collected This Month</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">₹ 38,200</div>
                            <div class="sc-stat-label">Outstanding</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-file-alt"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">43</div>
                            <div class="sc-stat-label">Invoices This Month</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-2 col-md-4 col-6">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm">
                            <option>All</option>
                            <option>Draft</option>
                            <option>Generated</option>
                            <option>Paid</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <label class="sc-form-label">Vehicle</label>
                        <select class="form-select form-select-sm select2-vehicle">
                            <option value="">All Vehicles</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <label class="sc-form-label">From Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <label class="sc-form-label">To Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-2 col-md-4 col-8">
                        <label class="sc-form-label">Payment Mode</label>
                        <select class="form-select form-select-sm">
                            <option>All Modes</option>
                            <option>Cash</option>
                            <option>Cheque</option>
                            <option>Online Transfer</option>
                            <option>Credit Note</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-4 col-4 d-flex align-items-end">
                        <button class="btn btn-outline-secondary btn-sm w-100"><i class="uil uil-times"></i> Clear</button>
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
                                <th>JC Number</th>
                                <th>Vehicle</th>
                                <th>Date</th>
                                <th class="text-end">Labour (₹)</th>
                                <th class="text-end">Parts (₹)</th>
                                <th class="text-end">GST (₹)</th>
                                <th class="text-end">Grand Total (₹)</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-navy">INV-2026-0043</td>
                                <td><a href="{{ route('ws.workshop.job-details', 6) }}" class="sc-jc-link">JC-2026-0043</a></td>
                                <td><span class="sc-reg-badge">UP-32-BT-5544</span></td>
                                <td class="text-nowrap">08-Apr-2026</td>
                                <td class="text-end">₹ 3,600</td>
                                <td class="text-end">₹ 14,100</td>
                                <td class="text-end">₹ 3,204</td>
                                <td class="text-end fw-bold text-navy">₹ 20,904</td>
                                <td>Online Transfer</td>
                                <td><span class="badge sc-bill-paid">Paid</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Invoice"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Print Invoice"><i class="uil uil-print"></i></button>
                                        <button class="sc-action-btn" title="Download PDF"><i class="uil uil-file-download-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-navy">INV-2026-0044</td>
                                <td><a href="{{ route('ws.workshop.job-details', 5) }}" class="sc-jc-link">JC-2026-0044</a></td>
                                <td><span class="sc-reg-badge">RJ-14-GA-1111</span></td>
                                <td class="text-nowrap">10-Apr-2026</td>
                                <td class="text-end">₹ 2,400</td>
                                <td class="text-end">₹ 3,450</td>
                                <td class="text-end">₹ 1,053</td>
                                <td class="text-end fw-bold text-navy">₹ 6,903</td>
                                <td>—</td>
                                <td><span class="badge sc-bill-generated">Generated</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Invoice"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Print Invoice"><i class="uil uil-print"></i></button>
                                        <button class="sc-action-btn" title="Record Payment" data-bs-toggle="modal" data-bs-target="#recordPaymentModal"><i class="uil uil-money-bill"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">DRAFT</td>
                                <td><a href="{{ route('ws.workshop.job-details', 4) }}" class="sc-jc-link">JC-2026-0045</a></td>
                                <td><span class="sc-reg-badge">GJ-03-ZZ-7890</span></td>
                                <td class="text-nowrap text-muted">—</td>
                                <td class="text-end text-muted">₹ 1,800</td>
                                <td class="text-end text-muted">₹ 980</td>
                                <td class="text-end text-muted">₹ 500</td>
                                <td class="text-end fw-bold text-muted">₹ 3,280</td>
                                <td>—</td>
                                <td><span class="badge sc-bill-draft">Draft</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Invoice"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Generate Invoice"><i class="uil uil-file-check-alt"></i></button>
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="sc-subtotal-row">
                                <td colspan="4" class="text-end fw-semibold">Total (Filtered)</td>
                                <td class="text-end fw-bold">₹ 7,800</td>
                                <td class="text-end fw-bold">₹ 18,530</td>
                                <td class="text-end fw-bold">₹ 4,757</td>
                                <td class="text-end fw-bold text-navy">₹ 31,087</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>{{-- /.main-wrap --}}
    </div>{{-- /.wrapper --}}

</div>{{-- /.layout-wrapper --}}

{{-- Record Payment Modal --}}
<div class="modal fade" id="recordPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-money-bill me-2 text-success"></i>Record Payment</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Invoice</label>
                        <input type="text" class="form-control form-control-sm bg-light" readonly value="INV-2026-0044 — ₹ 6,903">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Amount Received (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Payment Mode <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option>Cash</option>
                            <option>Cheque</option>
                            <option>Online Transfer</option>
                            <option>Credit Note</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Payment Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Reference # (Optional)</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Cheque / UTR no.">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-green btn-sm">Record Payment</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    $('.select2-vehicle').select2({ placeholder: 'All Vehicles', allowClear: true, width: '100%' });
});
</script>
@endsection
