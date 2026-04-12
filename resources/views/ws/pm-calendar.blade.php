@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/pm-calendar.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">PM Calendar</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Preventive Maintenance Calendar</h5>
                    <span class="text-muted" style="font-size:12px;">Track and schedule all vehicle PM tasks by KM and time</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#logPmModal">
                        <i class="uil uil-check-circle me-1"></i> Log Completed PM
                    </button>
                    <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#schedulePmModal">
                        <i class="uil uil-plus me-1"></i> Schedule PM
                    </button>
                </div>
            </div>

            {{-- Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-red">
                        <div class="sc-stat-icon"><i class="uil uil-exclamation-triangle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">7</div><div class="sc-stat-label">Overdue</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-clock"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">5</div><div class="sc-stat-label">Due This Week</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-calendar-alt"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">18</div><div class="sc-stat-label">Due Next 30 Days</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">24</div><div class="sc-stat-label">Completed This Month</div></div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end p-1">
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option>Overdue</option>
                            <option>Due This Week</option>
                            <option>Upcoming</option>
                            <option>Completed</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Service Type</label>
                        <select class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option>Engine Oil Change</option>
                            <option>Tyre Rotation</option>
                            <option>Brake Inspection</option>
                            <option>PM Service</option>
                            <option>Filter Change</option>
                            <option>Battery Check</option>
                            <option>Wheel Alignment</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="sc-form-label">Vehicle</label>
                        <select class="form-select form-select-sm select2-vehicle-pm" multiple placeholder="All Vehicles"></select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Due By</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-1 col-md-4">
                        <button class="btn btn-outline-secondary btn-sm w-100 mt-1"><i class="uil uil-times"></i> Clear</button>
                    </div>
                </div>
            </div>

            {{-- PM Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Vehicle</th>
                                <th>Service Type</th>
                                <th>Last Done</th>
                                <th>Last KM</th>
                                <th>Current KM</th>
                                <th>KM Progress</th>
                                <th>Next Due (KM)</th>
                                <th>Next Due (Date)</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $pmRows = [
                                ['KA-05-AB-1234','Tata Prima 4928','Engine Oil Change','15-Jan-2026','1,10,500','1,24,580',10000,'1,20,500','28-Mar-2026','overdue',88],
                                ['MH-12-XY-9876','Ashok Leyland 1916','Brake Inspection','01-Feb-2026','58,200','61,200',10000,'68,200','15-Apr-2026','due',94],
                                ['DL-01-CD-4567','Bharat Benz 2523','Tyre Rotation','10-Mar-2026','98,000','1,02,400',20000,'1,18,000','10-May-2026','upcoming',22],
                                ['GJ-03-ZZ-7890','Tata 407 LPT','PM Service','05-Feb-2026','49,500','52,100',15000,'64,500','05-May-2026','upcoming',17],
                                ['RJ-14-GA-1111','Eicher Pro 3015','Filter Change','20-Mar-2026','95,800','98,450',10000,'1,05,800','20-Apr-2026','due',97],
                                ['UP-32-BT-5544','Volvo FH 400','Wheel Alignment','01-Jan-2026','2,05,200','2,10,300',10000,'2,15,200','01-Apr-2026','overdue',51],
                            ];
                            @endphp

                            @foreach($pmRows as $row)
                            @php
                                $statusClass = match($row[9]) {
                                    'overdue'  => 'sc-row-pm-overdue',
                                    'due'      => 'sc-row-pm-due',
                                    default    => ''
                                };
                                $barClass = $row[10] >= 95 ? 'sc-km-bar-danger' : ($row[10] >= 80 ? 'sc-km-bar-warning' : 'sc-km-bar-ok');
                                $svcClass = match(true) {
                                    str_contains($row[2],'Oil')      => 'sc-svc-oil',
                                    str_contains($row[2],'Tyre')     => 'sc-svc-tyre',
                                    str_contains($row[2],'Brake')    => 'sc-svc-brake',
                                    str_contains($row[2],'PM')       => 'sc-svc-pm',
                                    str_contains($row[2],'Filter')   => 'sc-svc-filter',
                                    str_contains($row[2],'Battery')  => 'sc-svc-battery',
                                    str_contains($row[2],'Align')    => 'sc-svc-alignment',
                                    default                          => 'sc-svc-other'
                                };
                                $pmBadge = match($row[9]) {
                                    'overdue'  => 'sc-pm-overdue',
                                    'due'      => 'sc-pm-due',
                                    'upcoming' => 'sc-pm-upcoming',
                                    default    => 'sc-pm-done'
                                };
                                $pmLabel = ucfirst($row[9]);
                            @endphp
                            <tr class="{{ $statusClass }}">
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">{{ $row[0] }}</span>
                                        <span class="sc-veh-model">{{ $row[1] }}</span>
                                    </div>
                                </td>
                                <td><span class="sc-svc-chip {{ $svcClass }}">{{ $row[2] }}</span></td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $row[3] }}</td>
                                <td style="font-size:12px;">{{ $row[4] }}</td>
                                <td class="fw-semibold" style="font-size:12px;">{{ $row[5] }}</td>
                                <td style="min-width:100px;">
                                    <div class="sc-km-bar-wrap">
                                        <div class="sc-km-bar {{ $barClass }}" style="width:{{ min($row[10],100) }}%;"></div>
                                    </div>
                                    <div style="font-size:10px;color:#adb5bd;margin-top:2px;">{{ $row[10] }}% used</div>
                                </td>
                                <td style="font-size:12px;">{{ $row[6] }}</td>
                                <td class="text-nowrap {{ $row[9]==='overdue' ? 'text-danger fw-semibold' : ($row[9]==='due' ? 'text-warning fw-semibold' : '') }}" style="font-size:12px;">{{ $row[8] }}</td>
                                <td><span class="{{ $pmBadge }}">{{ $pmLabel }}</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="Log as Done" data-bs-toggle="modal" data-bs-target="#logPmModal"><i class="uil uil-check text-success"></i></button>
                                        <button class="sc-action-btn" title="View History"><i class="uil uil-history"></i></button>
                                        <button class="sc-action-btn btn-pm-sched" title="Schedule" data-reg="{{ $row[0] }}" data-bs-toggle="modal" data-bs-target="#schedulePmModal"><i class="uil uil-calendar-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-between px-3 py-2 border-top">
                    <small class="text-muted">Showing 6 of 42 vehicles</small>
                    <nav><ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul></nav>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Log Completed PM Modal --}}
<div class="modal fade" id="logPmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-check-circle me-2 text-success"></i>Log Completed PM</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-vehicle-log">
                            <option value="">Search vehicle...</option>
                            <option value="KA-05-AB-1234" data-reg="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima 4928</option>
                            <option value="MH-12-XY-9876" data-reg="MH-12-XY-9876">MH-12-XY-9876 — Ashok Leyland 1916</option>
                            <option value="DL-01-CD-4567" data-reg="DL-01-CD-4567">DL-01-CD-4567 — Bharat Benz 2523</option>
                            <option value="GJ-03-ZZ-7890" data-reg="GJ-03-ZZ-7890">GJ-03-ZZ-7890 — Tata 407 LPT</option>
                            <option value="RJ-14-GA-1111" data-reg="RJ-14-GA-1111">RJ-14-GA-1111 — Eicher Pro 3015</option>
                            <option value="UP-32-BT-5544" data-reg="UP-32-BT-5544">UP-32-BT-5544 — Volvo FH 400</option>
                            <option value="TN01-AB-1234" data-reg="TN01-AB-1234">TN01-AB-1234 — Tata Prima 5530</option>
                            <option value="TN02-CD-5678" data-reg="TN02-CD-5678">TN02-CD-5678 — Ashok Leyland 1615</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Service Type <span class="text-danger">*</span></label>
                        <div class="sc-svc-type-grid">
                            <div class="sc-svc-type-btn selected" data-svc="oil"><i class="uil uil-tint me-1"></i>Engine Oil</div>
                            <div class="sc-svc-type-btn" data-svc="tyre"><i class="uil uil-circle me-1"></i>Tyre Rotation</div>
                            <div class="sc-svc-type-btn" data-svc="brake"><i class="uil uil-stopwatch me-1"></i>Brake Check</div>
                            <div class="sc-svc-type-btn" data-svc="pm"><i class="uil uil-wrench me-1"></i>PM Service</div>
                            <div class="sc-svc-type-btn" data-svc="filter"><i class="uil uil-filter me-1"></i>Filter Change</div>
                            <div class="sc-svc-type-btn" data-svc="alignment"><i class="uil uil-arrows-h me-1"></i>Alignment</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Done Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">KM at Service <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" placeholder="e.g. 98450">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Next Due (KM)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="Auto or override">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Next Due (Date)</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Done By / Workshop</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Technician name or workshop name">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any notes about the service..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Save PM Record</button>
            </div>
        </div>
    </div>
</div>

{{-- Schedule PM Modal --}}
<div class="modal fade" id="schedulePmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-calendar-alt me-2"></i>Schedule PM</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-vehicle-sched">
                            <option value="">Search vehicle...</option>
                            <option value="KA-05-AB-1234">KA-05-AB-1234 — Tata Prima 4928</option>
                            <option value="MH-12-XY-9876">MH-12-XY-9876 — Ashok Leyland 1916</option>
                            <option value="DL-01-CD-4567">DL-01-CD-4567 — Bharat Benz 2523</option>
                            <option value="GJ-03-ZZ-7890">GJ-03-ZZ-7890 — Tata 407 LPT</option>
                            <option value="RJ-14-GA-1111">RJ-14-GA-1111 — Eicher Pro 3015</option>
                            <option value="UP-32-BT-5544">UP-32-BT-5544 — Volvo FH 400</option>
                            <option value="TN01-AB-1234">TN01-AB-1234 — Tata Prima 5530</option>
                            <option value="TN02-CD-5678">TN02-CD-5678 — Ashok Leyland 1615</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Service Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option value="">— Select —</option>
                            <option>Engine Oil Change</option>
                            <option>Tyre Rotation</option>
                            <option>Brake Inspection</option>
                            <option>PM Service</option>
                            <option>Filter Change</option>
                            <option>Battery Check</option>
                            <option>Wheel Alignment</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Scheduled Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="sc-form-label">Target KM</label>
                        <input type="number" class="form-control form-control-sm" placeholder="KM at which to do PM">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Notes</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any scheduling notes..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Schedule</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    // Select2 — filter bar (multi)
    $('.select2-vehicle-pm').select2({
        width: '100%',
        placeholder: 'All Vehicles',
        allowClear: true
    });

    // Select2 — Log PM modal
    $('.select2-vehicle-log').select2({
        width: '100%',
        placeholder: 'Search vehicle...',
        allowClear: true,
        dropdownParent: $('#logPmModal')
    });

    // Select2 — Schedule PM modal
    $('.select2-vehicle-sched').select2({
        width: '100%',
        placeholder: 'Search vehicle...',
        allowClear: true,
        dropdownParent: $('#schedulePmModal')
    });

    // Service type chip toggle (Log PM modal)
    $(document).on('click', '.sc-svc-type-btn', function() {
        $('.sc-svc-type-btn').removeClass('selected');
        $(this).addClass('selected');
    });

    // Row "Schedule" icon → pre-select vehicle in modal
    $(document).on('click', '.btn-pm-sched', function() {
        var reg = $(this).data('reg');
        if (reg) {
            $('#schedulePmModal .select2-vehicle-sched').val(reg).trigger('change');
        }
    });

    // Save PM Record (Log modal)
    $('#logPmModal .modal-footer .sc-btn-navy').on('click', function() {
        var veh = $('#logPmModal .select2-vehicle-log').val();
        var svc = $('#logPmModal .sc-svc-type-btn.selected').text().trim();
        var date = $('#logPmModal input[type=date]').first().val();
        var km = $('#logPmModal input[type=number]').first().val();

        if (!veh || !date || !km) {
            Swal.fire({ icon: 'warning', title: 'Missing Fields', text: 'Please fill in Vehicle, Done Date and KM at Service.', confirmButtonColor: '#032671' });
            return;
        }
        $('#logPmModal').modal('hide');
        Swal.fire({ icon: 'success', title: 'PM Record Saved', html: '<strong>' + svc + '</strong> logged for <strong>' + veh + '</strong> at <strong>' + parseInt(km).toLocaleString('en-IN') + ' KM</strong>.', confirmButtonColor: '#10863f' });
    });

    // Schedule button (Schedule PM modal)
    $('#schedulePmModal .modal-footer .sc-btn-navy').on('click', function() {
        var veh = $('#schedulePmModal .select2-vehicle-sched').val();
        var svc = $('#schedulePmModal select.form-select:not(.select2-vehicle-sched)').val();
        var date = $('#schedulePmModal input[type=date]').val();

        if (!veh || !svc || !date) {
            Swal.fire({ icon: 'warning', title: 'Missing Fields', text: 'Please select a Vehicle, Service Type and Scheduled Date.', confirmButtonColor: '#032671' });
            return;
        }
        $('#schedulePmModal').modal('hide');
        Swal.fire({ icon: 'success', title: 'PM Scheduled', html: '<strong>' + svc + '</strong> scheduled for <strong>' + veh + '</strong> on <strong>' + date + '</strong>.', confirmButtonColor: '#10863f' });
    });
});
</script>
@endsection
