@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/technician-dashboard.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Technician Dashboard</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Technician Dashboard</h5>
                    <span class="text-muted" style="font-size:12px;">Real-time technician workload and job assignment</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="uil uil-refresh me-1"></i> Refresh
                    </button>
                </div>
            </div>

            {{-- Summary Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-users-alt"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">6</div>
                            <div class="sc-stat-label">Total Technicians</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">3</div>
                            <div class="sc-stat-label">Available</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-wrench"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">2</div>
                            <div class="sc-stat-label">Working on Job</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-coffee"></i></div>
                        <div class="sc-stat-body">
                            <div class="sc-stat-val">1</div>
                            <div class="sc-stat-label">On Break</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanban Board --}}
            <div class="row g-3">

                {{-- Available --}}
                <div class="col-lg-4">
                    <div class="sc-kanban-lane sc-kanban-available">
                        <div class="sc-kanban-header">
                            <span class="sc-kanban-dot sc-dot-green"></span>
                            Available
                            <span class="sc-kanban-count">3</span>
                        </div>

                        <div class="sc-tech-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="sc-tech-avatar-sm" style="background:#10863f;">VT</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:13px;">Vijay Tiwari</div>
                                    <div class="text-muted" style="font-size:11px;">Engine &amp; Transmission</div>
                                </div>
                                <span class="badge sc-avail-badge ms-auto">Available</span>
                            </div>
                            <div class="sc-tech-stats">
                                <span><i class="uil uil-check-circle text-success me-1"></i>8 jobs today</span>
                                <span><i class="uil uil-clock me-1 text-muted"></i>Since 09:00</span>
                            </div>
                            <button class="btn sc-btn-navy btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#assignJobModal">
                                <i class="uil uil-plus me-1"></i> Assign Job
                            </button>
                        </div>

                        <div class="sc-tech-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="sc-tech-avatar-sm" style="background:#0097a7;">MP</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:13px;">Manoj Patil</div>
                                    <div class="text-muted" style="font-size:11px;">Electricals &amp; AC</div>
                                </div>
                                <span class="badge sc-avail-badge ms-auto">Available</span>
                            </div>
                            <div class="sc-tech-stats">
                                <span><i class="uil uil-check-circle text-success me-1"></i>5 jobs today</span>
                                <span><i class="uil uil-clock me-1 text-muted"></i>Since 10:30</span>
                            </div>
                            <button class="btn sc-btn-navy btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#assignJobModal">
                                <i class="uil uil-plus me-1"></i> Assign Job
                            </button>
                        </div>

                        <div class="sc-tech-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="sc-tech-avatar-sm" style="background:#6f42c1;">AK</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:13px;">Arun Kumar</div>
                                    <div class="text-muted" style="font-size:11px;">Tyres &amp; Suspension</div>
                                </div>
                                <span class="badge sc-avail-badge ms-auto">Available</span>
                            </div>
                            <div class="sc-tech-stats">
                                <span><i class="uil uil-check-circle text-success me-1"></i>3 jobs today</span>
                                <span><i class="uil uil-clock me-1 text-muted"></i>Since 11:00</span>
                            </div>
                            <button class="btn sc-btn-navy btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#assignJobModal">
                                <i class="uil uil-plus me-1"></i> Assign Job
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Working on Job --}}
                <div class="col-lg-4">
                    <div class="sc-kanban-lane sc-kanban-working">
                        <div class="sc-kanban-header">
                            <span class="sc-kanban-dot sc-dot-amber"></span>
                            Working on Job
                            <span class="sc-kanban-count">2</span>
                        </div>

                        <div class="sc-tech-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="sc-tech-avatar-sm" style="background:#032671;">RK</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:13px;">Ramesh Kumar</div>
                                    <div class="text-muted" style="font-size:11px;">Engine &amp; Brakes</div>
                                </div>
                                <span class="badge sc-wip-badge ms-auto">WIP</span>
                            </div>
                            <div class="sc-current-job-box">
                                <div class="fw-semibold text-navy" style="font-size:12px;">JC-2026-0048</div>
                                <div style="font-size:12px;">KA-05-AB-1234 · Tata Prima</div>
                                <div class="text-muted" style="font-size:11px;">General Service + Brake Pads</div>
                                <div class="sc-job-timer mt-1"><i class="uil uil-clock me-1"></i>2h 15m elapsed</div>
                            </div>
                            <div class="sc-tech-stats mt-2">
                                <span><i class="uil uil-check-circle text-success me-1"></i>10 jobs today</span>
                            </div>
                            <a href="{{ route('ws.workshop.job-details', 1) }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                <i class="uil uil-eye me-1"></i> View Job Card
                            </a>
                        </div>

                        <div class="sc-tech-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="sc-tech-avatar-sm" style="background:#E65100;">SM</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:13px;">Suresh Mehta</div>
                                    <div class="text-muted" style="font-size:11px;">General Service</div>
                                </div>
                                <span class="badge sc-wip-badge ms-auto">WIP</span>
                            </div>
                            <div class="sc-current-job-box">
                                <div class="fw-semibold text-navy" style="font-size:12px;">JC-2026-0047</div>
                                <div style="font-size:12px;">MH-12-XY-9876 · Ashok Leyland</div>
                                <div class="text-muted" style="font-size:11px;">Engine Overhaul</div>
                                <div class="sc-job-timer mt-1"><i class="uil uil-clock me-1"></i>4h 30m elapsed</div>
                            </div>
                            <div class="sc-tech-stats mt-2">
                                <span><i class="uil uil-check-circle text-success me-1"></i>7 jobs today</span>
                            </div>
                            <a href="{{ route('ws.workshop.job-details', 2) }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                <i class="uil uil-eye me-1"></i> View Job Card
                            </a>
                        </div>
                    </div>
                </div>

                {{-- On Break --}}
                <div class="col-lg-4">
                    <div class="sc-kanban-lane sc-kanban-break">
                        <div class="sc-kanban-header">
                            <span class="sc-kanban-dot sc-dot-grey"></span>
                            On Break
                            <span class="sc-kanban-count">1</span>
                        </div>

                        <div class="sc-tech-card sc-tech-card-muted">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="sc-tech-avatar-sm" style="background:#6c757d;">PD</div>
                                <div>
                                    <div class="fw-semibold" style="font-size:13px;">Prakash Dubey</div>
                                    <div class="text-muted" style="font-size:11px;">Tyres &amp; Alignment</div>
                                </div>
                                <span class="badge sc-break-badge ms-auto">Break</span>
                            </div>
                            <div class="sc-tech-stats">
                                <span><i class="uil uil-check-circle text-success me-1"></i>4 jobs today</span>
                                <span class="text-muted"><i class="uil uil-clock me-1"></i>Break since 13:00</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /.row --}}

        </div>{{-- /.main-wrap --}}
    </div>{{-- /.wrapper --}}

</div>{{-- /.layout-wrapper --}}

{{-- Assign Job Modal --}}
<div class="modal fade" id="assignJobModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-plus-circle me-2 text-navy"></i>Assign Job Card</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Job Card <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-jc">
                            <option>JC-2026-0046 — DL-01-CD-4567 (Pending Parts)</option>
                            <option>JC-2026-0045 — GJ-03-ZZ-7890 (Quality Check)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Assign To <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm bg-light" readonly value="Vijay Tiwari">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Notes (Optional)</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Special instructions..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Assign</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    $('.select2-jc').select2({ width: '100%', dropdownParent: $('#assignJobModal') });
});
</script>
@endsection
