@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/onroad-service.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">On-Road Service</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">On-Road Service</h5>
                    <span class="text-muted" style="font-size:12px;">Manage breakdown dispatch and roadside assistance calls</span>
                </div>
                <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#logBreakdownModal">
                    <i class="uil uil-plus me-1"></i> Log Breakdown
                </button>
            </div>

            {{-- Summary Cards --}}
            <div class="row g-3 mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-red">
                        <div class="sc-stat-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">2</div><div class="sc-stat-label">Active Breakdowns</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-truck"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">1</div><div class="sc-stat-label">Technician Dispatched</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-phone"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">1</div><div class="sc-stat-label">Third-Party Logged</div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">8</div><div class="sc-stat-label">Resolved This Month</div></div>
                    </div>
                </div>
            </div>

            {{-- On-Road Jobs Table --}}
            <div class="sc-table-card">
                <div class="sc-table-head d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                    <span class="fw-semibold" style="font-size:13px;">All On-Road Calls</span>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width:150px;">
                            <option>All Statuses</option>
                            <option>Open</option>
                            <option>Technician Dispatched</option>
                            <option>Third-Party Contacted</option>
                            <option>En Route</option>
                            <option>Resolved</option>
                        </select>
                        <select class="form-select form-select-sm" style="width:140px;">
                            <option>All Types</option>
                            <option>Own Technician</option>
                            <option>Third Party</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Call #</th>
                                <th>Vehicle</th>
                                <th>Breakdown Location</th>
                                <th>Type</th>
                                <th>Reported By</th>
                                <th>Reported At</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="sc-row-critical">
                                <td class="fw-semibold">ORS-2026-0012</td>
                                <td><div class="sc-veh-cell"><span class="sc-reg-badge">KA-05-AB-1234</span><span class="sc-veh-model">Tata Prima</span></div></td>
                                <td>
                                    <span style="font-size:12px;">NH-4, Belgaum Bypass, KM 342</span>
                                    <a href="#" class="sc-location-link"><i class="uil uil-map-marker ms-1"></i></a>
                                </td>
                                <td><span class="badge sc-type-own">Own Technician</span></td>
                                <td>Raju Singh (Driver)</td>
                                <td class="text-nowrap">11-Apr 06:30</td>
                                <td>Ramesh Kumar</td>
                                <td><span class="badge sc-ors-dispatched">Dispatched</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details" data-bs-toggle="modal" data-bs-target="#viewOrsModal"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Update Status"><i class="uil uil-sync"></i></button>
                                        <button class="sc-action-btn" title="Close Call"><i class="uil uil-check"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="sc-row-critical">
                                <td class="fw-semibold">ORS-2026-0011</td>
                                <td><div class="sc-veh-cell"><span class="sc-reg-badge">MH-12-XY-9876</span><span class="sc-veh-model">Ashok Leyland</span></div></td>
                                <td>
                                    <span style="font-size:12px;">Pune-Nashik Highway, near Shirdi</span>
                                    <a href="#" class="sc-location-link"><i class="uil uil-map-marker ms-1"></i></a>
                                </td>
                                <td><span class="badge sc-type-third">Third Party</span></td>
                                <td>Vijay (Driver)</td>
                                <td class="text-nowrap">11-Apr 08:15</td>
                                <td>
                                    <span style="font-size:12px;">Royal Road Services</span><br>
                                    <small class="text-muted">+91 98001 23456</small>
                                </td>
                                <td><span class="badge sc-ors-thirdparty">3rd Party Contacted</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details" data-bs-toggle="modal" data-bs-target="#viewOrsModal"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Update Status"><i class="uil uil-sync"></i></button>
                                        <button class="sc-action-btn" title="Close Call"><i class="uil uil-check"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">ORS-2026-0010</td>
                                <td><div class="sc-veh-cell"><span class="sc-reg-badge">DL-01-CD-4567</span><span class="sc-veh-model">Bharat Benz</span></div></td>
                                <td><span style="font-size:12px;">Delhi–Jaipur Highway, KM 78</span></td>
                                <td><span class="badge sc-type-own">Own Technician</span></td>
                                <td>Deepak (Driver)</td>
                                <td class="text-nowrap">09-Apr 14:00</td>
                                <td>Manoj Patil</td>
                                <td><span class="badge sc-ors-resolved">Resolved</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Print Report"><i class="uil uil-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- /.main-wrap --}}
    </div>{{-- /.wrapper --}}

</div>{{-- /.layout-wrapper --}}

{{-- Log Breakdown Modal --}}
<div class="modal fade" id="logBreakdownModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-exclamation-triangle me-2 text-danger"></i>Log Breakdown / On-Road Call</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="sc-form-label">Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-vehicle-ors">
                            <option value="">Search by Reg No. or Model…</option>
                            <option value="1">KA-05-AB-1234 — Tata Prima</option>
                            <option value="2">MH-12-XY-9876 — Ashok Leyland</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="sc-form-label">KM at Incident</label>
                        <input type="text" class="form-control form-control-sm bg-light" readonly placeholder="Auto from vehicle">
                    </div>
                    <div class="col-md-3">
                        <label class="sc-form-label">Reported At <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Breakdown Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="Highway, landmark, KM marker…">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Reported By <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="Driver name / phone">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Breakdown Type</label>
                        <select class="form-select form-select-sm">
                            <option>Tyre Puncture / Blowout</option>
                            <option>Engine Failure</option>
                            <option>Brake Failure</option>
                            <option>Electrical Issue</option>
                            <option>Accident Damage</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Response Type <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="orsType" id="orsOwn" value="own" checked>
                                <label class="form-check-label" for="orsOwn" style="font-size:13px;">Own Technician Dispatch</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="orsType" id="orsThird" value="third">
                                <label class="form-check-label" for="orsThird" style="font-size:13px;">Third-Party Log</label>
                            </div>
                        </div>
                    </div>
                    {{-- Own technician fields --}}
                    <div class="col-md-6" id="ors-tech-field">
                        <label class="sc-form-label">Assign Technician <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option>Ramesh Kumar</option>
                            <option>Manoj Patil</option>
                            <option>Arun Kumar</option>
                        </select>
                    </div>
                    {{-- Third-party fields (hidden by default) --}}
                    <div class="col-md-6 d-none" id="ors-third-name">
                        <label class="sc-form-label">Service Provider Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="Roadside service provider">
                    </div>
                    <div class="col-md-6 d-none" id="ors-third-phone">
                        <label class="sc-form-label">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="+91 XXXXX XXXXX">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Notes</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Additional details about the breakdown…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Log Breakdown</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    $('.select2-vehicle-ors').select2({ placeholder: 'Search by Reg No…', width: '100%', dropdownParent: $('#logBreakdownModal') });

    // Toggle own/third-party fields
    $('input[name="orsType"]').on('change', function() {
        if ($(this).val() === 'own') {
            $('#ors-tech-field').removeClass('d-none');
            $('#ors-third-name, #ors-third-phone').addClass('d-none');
        } else {
            $('#ors-tech-field').addClass('d-none');
            $('#ors-third-name, #ors-third-phone').removeClass('d-none');
        }
    });
});
</script>
@endsection
