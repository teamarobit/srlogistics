@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/job-card-list.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Workshop Job Cards</li>
                </ol>
            </nav>

            {{-- SC Context Bar --}}
            <div class="loc-ctx-bar">
                <div class="loc-ctx-left">
                    <i class="uil uil-wrench loc-ctx-icon"></i>
                    <span class="loc-ctx-label">Workshop:</span>
                    <select class="loc-ctx-select">
                        <option value="">All Workshops</option>
                        <option value="WS-HYD">WS-HYD — Bangalore Workshop</option>
                        <option value="WS-HYD">WS-HYD — Hyderabad Workshop</option>
                    </select>
                </div>
                <div style="font-size:11px;color:#adb5bd;">Job cards are scoped to a service centre location</div>
            </div>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Workshop Job Cards</h5>
                    <span class="text-muted" style="font-size:12px;">All service centres — filter by location above</span>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="uil uil-export me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="uil uil-file-alt me-2"></i>Export Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="uil uil-file-pdf-alt me-2"></i>Export PDF</a></li>
                        </ul>
                    </div>
                    <button class="btn sc-btn-navy btn-sm">
                        <i class="uil uil-plus me-1"></i> New Job Card
                    </button>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-2 col-md-4 col-6">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Pending Parts">Pending Parts</option>
                            <option value="Quality Check">Quality Check</option>
                            <option value="Completed">Completed</option>
                            <option value="Billed">Billed</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <label class="sc-form-label">Vehicle</label>
                        <select class="form-select form-select-sm select2-vehicle" multiple placeholder="All Vehicles">
                            <option value="1">KA-05-AB-1234 — Tata Prima</option>
                            <option value="2">MH-12-XY-9876 — Ashok Leyland</option>
                            <option value="3">DL-01-CD-4567 — Bharat Benz</option>
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
                        <label class="sc-form-label">Search JC Number</label>
                        <input type="text" class="form-control form-control-sm" placeholder="JC-2026-0001...">
                    </div>
                    <div class="col-lg-1 col-md-4 col-4 d-flex align-items-end">
                        <button class="btn btn-outline-secondary btn-sm w-100">
                            <i class="uil uil-times"></i> Clear
                        </button>
                    </div>
                </div>
            </div>

            {{-- Results Counter --}}
            <div class="d-flex align-items-center justify-content-between mb-2">
                <small class="text-muted">Showing <strong>12</strong> of <strong>48</strong> job cards</small>
                <div class="d-flex align-items-center gap-2">
                    <label class="sc-form-label mb-0 me-1" style="font-size:12px;">Rows</label>
                    <select class="form-select form-select-sm" style="width:80px;">
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            {{-- Job Cards Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0 sc-jc-table">
                        <colgroup>
                            <col style="width:135px;">  {{-- JC Number --}}
                            <col style="width:170px;">  {{-- Vehicle --}}
                            <col style="width:115px;">  {{-- SR Number --}}
                            <col style="width:120px;">  {{-- Technician --}}
                            <col style="width:125px;">  {{-- Status --}}
                            <col style="width:95px;">   {{-- Started --}}
                            <col style="width:115px;">  {{-- Est. Delivery --}}
                            <col style="width:105px;">  {{-- Grand Total --}}
                            <col style="width:130px;">  {{-- Actions --}}
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="sortable">JC Number <i class="uil uil-sort ms-1"></i></th>
                                <th class="sortable">Vehicle <i class="uil uil-sort ms-1"></i></th>
                                <th class="sortable">SR No. <i class="uil uil-sort ms-1"></i></th>
                                <th class="sortable">Technician <i class="uil uil-sort ms-1"></i></th>
                                <th class="sortable">Status <i class="uil uil-sort ms-1"></i></th>
                                <th class="sortable">Started <i class="uil uil-sort ms-1"></i></th>
                                <th class="sortable">Est. Delivery <i class="uil uil-sort ms-1"></i></th>
                                <th class="sortable text-end">Total (₹) <i class="uil uil-sort ms-1"></i></th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Row 1: Open --}}
                            <tr>
                                <td><a href="{{ route('ws.workshop.job-details', 1) }}" class="sc-jc-link">JC-2026-0048</a></td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">KA-05-AB-1234</span>
                                        <span class="sc-veh-model">Tata Prima 4928</span>
                                    </div>
                                </td>
                                <td><span class="sc-sr-link">SR-2026-0101</span></td>
                                <td class="text-nowrap">Ramesh K.</td>
                                <td><span class="badge sc-status-open">Open</span></td>
                                <td class="sc-date-cell">11-Apr-26<br><span class="sc-time-sub">09:30</span></td>
                                <td class="text-nowrap">13-Apr-2026</td>
                                <td class="text-end fw-semibold">₹&nbsp;4,500</td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('ws.workshop.job-details', 1) }}" class="sc-action-btn" title="View"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Edit"><i class="uil uil-pen"></i></button>
                                        <button class="sc-action-btn" title="Close Job" disabled><i class="uil uil-lock"></i></button>
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Row 2: In Progress --}}
                            <tr>
                                <td><a href="{{ route('ws.workshop.job-details', 2) }}" class="sc-jc-link">JC-2026-0047</a></td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">MH-12-XY-9876</span>
                                        <span class="sc-veh-model">Ashok Leyland 1916</span>
                                    </div>
                                </td>
                                <td><span class="sc-sr-link">SR-2026-0099</span></td>
                                <td class="text-nowrap">Suresh M.</td>
                                <td><span class="badge sc-status-inprogress">In Progress</span></td>
                                <td class="sc-date-cell">10-Apr-26<br><span class="sc-time-sub">14:15</span></td>
                                <td class="text-nowrap">12-Apr-2026</td>
                                <td class="text-end fw-semibold">₹&nbsp;12,800</td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('ws.workshop.job-details', 2) }}" class="sc-action-btn" title="View"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Edit"><i class="uil uil-pen"></i></button>
                                        <button class="sc-action-btn" title="Close Job" disabled><i class="uil uil-lock"></i></button>
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Row 3: Pending Parts --}}
                            <tr>
                                <td><a href="{{ route('ws.workshop.job-details', 3) }}" class="sc-jc-link">JC-2026-0046</a></td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">DL-01-CD-4567</span>
                                        <span class="sc-veh-model">Bharat Benz 2523</span>
                                    </div>
                                </td>
                                <td><span class="sc-sr-link">SR-2026-0097</span></td>
                                <td class="text-nowrap"><span class="text-muted fst-italic" style="font-size:12px;">Unassigned</span></td>
                                <td><span class="badge sc-status-pendingparts">Pending Parts</span></td>
                                <td class="sc-date-cell">09-Apr-26<br><span class="sc-time-sub">11:00</span></td>
                                <td class="text-nowrap text-danger fw-semibold">10-Apr-2026 <i class="uil uil-exclamation-triangle" title="Overdue"></i></td>
                                <td class="text-end fw-semibold">₹&nbsp;8,250</td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('ws.workshop.job-details', 3) }}" class="sc-action-btn" title="View"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Edit"><i class="uil uil-pen"></i></button>
                                        <button class="sc-action-btn" title="Close Job" disabled><i class="uil uil-lock"></i></button>
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Row 4: Quality Check --}}
                            <tr>
                                <td><a href="{{ route('ws.workshop.job-details', 4) }}" class="sc-jc-link">JC-2026-0045</a></td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">GJ-03-ZZ-7890</span>
                                        <span class="sc-veh-model">Tata 407 LPT</span>
                                    </div>
                                </td>
                                <td><span class="sc-sr-link">SR-2026-0095</span></td>
                                <td class="text-nowrap">Manoj P.</td>
                                <td><span class="badge sc-status-qc">Quality Check</span></td>
                                <td class="sc-date-cell">08-Apr-26<br><span class="sc-time-sub">10:00</span></td>
                                <td class="text-nowrap">11-Apr-2026</td>
                                <td class="text-end fw-semibold">₹&nbsp;3,100</td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('ws.workshop.job-details', 4) }}" class="sc-action-btn" title="View"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Edit"><i class="uil uil-pen"></i></button>
                                        <button class="sc-action-btn" title="Close Job" disabled><i class="uil uil-lock"></i></button>
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Row 5: Completed --}}
                            <tr>
                                <td><a href="{{ route('ws.workshop.job-details', 5) }}" class="sc-jc-link">JC-2026-0044</a></td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">RJ-14-GA-1111</span>
                                        <span class="sc-veh-model">Eicher Pro 3015</span>
                                    </div>
                                </td>
                                <td><span class="sc-sr-link">SR-2026-0092</span></td>
                                <td class="text-nowrap">Vijay T.</td>
                                <td><span class="badge sc-status-completed">Completed</span></td>
                                <td class="sc-date-cell">07-Apr-26<br><span class="sc-time-sub">09:00</span></td>
                                <td class="text-nowrap">10-Apr-2026</td>
                                <td class="text-end fw-semibold">₹&nbsp;6,900</td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('ws.workshop.job-details', 5) }}" class="sc-action-btn" title="View"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Edit"><i class="uil uil-pen"></i></button>
                                        <button class="sc-action-btn sc-action-btn-danger" title="Close Job" data-bs-toggle="modal" data-bs-target="#closeJobModal"><i class="uil uil-lock"></i></button>
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Row 6: Billed --}}
                            <tr class="sc-row-billed">
                                <td><a href="{{ route('ws.workshop.job-details', 6) }}" class="sc-jc-link">JC-2026-0043</a></td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">UP-32-BT-5544</span>
                                        <span class="sc-veh-model">Volvo FH 400</span>
                                    </div>
                                </td>
                                <td><span class="sc-sr-link">SR-2026-0090</span></td>
                                <td class="text-nowrap">Ramesh K.</td>
                                <td><span class="badge sc-status-billed">Billed</span></td>
                                <td class="sc-date-cell">05-Apr-26<br><span class="sc-time-sub">08:30</span></td>
                                <td class="text-nowrap">08-Apr-2026</td>
                                <td class="text-end fw-semibold">₹&nbsp;21,450</td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('ws.workshop.job-details', 6) }}" class="sc-action-btn" title="View"><i class="uil uil-eye"></i></a>
                                        <button class="sc-action-btn" title="Edit" disabled><i class="uil uil-pen"></i></button>
                                        <button class="sc-action-btn" title="Close Job" disabled><i class="uil uil-lock"></i></button>
                                        <button class="sc-action-btn" title="Print"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                    <small class="text-muted">Page 1 of 4</small>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>{{-- /.main-wrap --}}
    </div>{{-- /.wrapper --}}

</div>{{-- /.layout-wrapper --}}

{{-- Close Job Confirmation Modal --}}
<div class="modal fade" id="closeJobModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-lock me-2 text-danger"></i>Close Job Card</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Are you sure you want to close job card <strong id="closeJcNum">JC-2026-0044</strong>?</p>
                <p class="text-muted mb-0" style="font-size:13px;">This will mark the job as <strong>Billed</strong> and lock all edits. This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm">Close Job</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    // Select2 for vehicle filter
    $('.select2-vehicle').select2({
        placeholder: 'All Vehicles',
        allowClear: true,
        width: '100%'
    });

    // Close job action
    $('.sc-action-btn-danger').on('click', function() {
        var jcNum = $(this).closest('tr').find('.sc-jc-link').text();
        $('#closeJcNum').text(jcNum);
        $('#closeJobModal').modal('show');
    });
});
</script>
@endsection
