@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/appointment.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Appointments</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Appointments</h5>
                    <span class="text-muted" style="font-size:12px;">Schedule and manage workshop appointments</span>
                </div>
                <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#newApptModal">
                    <i class="uil uil-plus me-1"></i>New Appointment
                </button>
            </div>

            {{-- KPI Cards --}}
            <div class="row g-3 mb-3">
                @php
                $kpis = [
                    ['7','Today','uil-calendar-alt','#e3ecff','#032671'],
                    ['3','Pending Confirm','uil-clock','#fff3e0','#e65100'],
                    ['12','This Week','uil-calendar-alt','#e6f4ea','#10863f'],
                    ['2','Cancelled Today','uil-times-circle','#fdecea','#ea0027'],
                ];
                @endphp
                @foreach($kpis as $k)
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card">
                        <div class="sc-stat-icon" style="background:{{ $k[3] }};">
                            <i class="uil {{ $k[2] }}" style="color:{{ $k[4] }};"></i>
                        </div>
                        <div>
                            <div class="sc-stat-num">{{ $k[0] }}</div>
                            <div class="sc-stat-lbl">{{ $k[1] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Date Strip --}}
            <div class="sc-card mb-3">
                <div class="sc-card-head d-flex align-items-center justify-content-between">
                    <span class="sc-card-title">Select Date</span>
                    <span style="font-size:11px;color:#485D6B;">April 2026</span>
                </div>
                <div class="p-3">
                    @php
                    $days = [
                        ['Mon','7','Apr',2],
                        ['Tue','8','Apr',4],
                        ['Wed','9','Apr',3],
                        ['Thu','10','Apr',7,true],
                        ['Fri','11','Apr',5],
                        ['Sat','12','Apr',1],
                        ['Sun','13','Apr',0,false,true],
                        ['Mon','14','Apr',6],
                        ['Tue','15','Apr',2],
                    ];
                    @endphp
                    <div class="cal-strip">
                        @foreach($days as $d)
                        <div class="cal-day {{ isset($d[4]) && $d[4] ? 'active' : '' }} {{ isset($d[5]) && $d[5] ? 'off-day' : '' }}">
                            <span class="cd-dow">{{ $d[0] }}</span>
                            <span class="cd-date">{{ $d[1] }}</span>
                            <span class="cd-month">{{ $d[2] }}</span>
                            <span class="cd-count" style="{{ isset($d[4]) && $d[4] ? '' : 'color:#032671;' }}">{{ $d[3] > 0 ? $d[3].' appt' : '—' }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="sc-card mb-3">
                <div class="p-3 d-flex flex-wrap gap-2 align-items-center">
                    <select class="form-select form-select-sm" style="width:140px;">
                        <option>All Types</option>
                        <option>Routine Maintenance</option>
                        <option>Breakdown</option>
                        <option>Tyre Service</option>
                        <option>Battery Service</option>
                    </select>
                    <select class="form-select form-select-sm" style="width:140px;">
                        <option>All Statuses</option>
                        <option>Confirmed</option>
                        <option>Pending</option>
                        <option>Rescheduled</option>
                        <option>Cancelled</option>
                    </select>
                    <input type="text" class="form-control form-control-sm" style="width:180px;" placeholder="Search vehicle...">
                    <button class="btn btn-sm btn-outline-secondary"><i class="uil uil-filter me-1"></i>Filter</button>
                    <button class="btn btn-sm sc-btn-navy ms-auto" onclick="window.print()"><i class="uil uil-print me-1"></i>Print List</button>
                </div>
            </div>

            {{-- Appointments Table --}}
            <div class="sc-card">
                <div class="sc-card-head">
                    <span class="sc-card-title">Appointments — Thu 10 Apr 2026</span>
                </div>
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Appt #</th>
                                <th>Time</th>
                                <th>Vehicle</th>
                                <th>Service Type</th>
                                <th>Driver</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $appts = [
                                ['APT-0401','09:00','TN01 AB1234','Routine Maintenance','Ramesh Kumar','confirmed','gate'],
                                ['APT-0402','09:30','TN02 CD5678','Tyre Service','Selvam P','confirmed','jobcard'],
                                ['APT-0403','10:00','TN03 EF9012','Battery Service','Vijay R','pending','confirm'],
                                ['APT-0404','10:30','TN04 GH3456','PM Service','Anand K','confirmed','gate'],
                                ['APT-0405','11:00','TN05 IJ7890','Breakdown','Murugan S','rescheduled','reschedule'],
                                ['APT-0406','13:00','TN06 KL2345','Engine Oil','Rajan T','confirmed','jobcard'],
                                ['APT-0407','14:00','TN07 MN6789','Tyre Service','Karan B','pending','confirm'],
                                ['APT-0408','15:30','TN08 OP0123','Accident / Body','Prasad V','cancelled','reschedule'],
                            ];
                            $statusMap = ['confirmed'=>'done','pending'=>'open','rescheduled'=>'hold','cancelled'=>'cancel'];
                            @endphp
                            @foreach($appts as $a)
                            <tr>
                                <td class="fw-semibold text-primary">{{ $a[0] }}</td>
                                <td>{{ $a[1] }}</td>
                                <td class="fw-semibold">{{ $a[2] }}</td>
                                <td>
                                    @php
                                    $typeClass = match(true) {
                                        str_contains($a[3],'Tyre') => 'tyre',
                                        str_contains($a[3],'Battery') => 'battery',
                                        str_contains($a[3],'Breakdown') => 'breakdown',
                                        str_contains($a[3],'Accident') => 'accident',
                                        str_contains($a[3],'PM') => 'pm',
                                        default => 'routine'
                                    };
                                    @endphp
                                    <span class="appt-type-chip {{ $typeClass }}">{{ $a[3] }}</span>
                                </td>
                                <td>{{ $a[4] }}</td>
                                <td><span class="sc-badge-{{ $statusMap[$a[5]] }}">{{ ucfirst($a[5]) }}</span></td>
                                <td>
                                    @if($a[6] === 'gate')
                                        <a href="{{ route('ws.in-token.index') }}" class="btn btn-xs sc-btn-navy me-1" style="font-size:11px;padding:2px 8px;">Gate IN</a>
                                    @elseif($a[6] === 'jobcard')
                                        <a href="{{ route('ws.workshop.job-list') }}" class="btn btn-xs sc-btn-green me-1" style="font-size:11px;padding:2px 8px;">Job Card</a>
                                    @elseif($a[6] === 'confirm')
                                        <button class="btn btn-xs sc-btn-green me-1 btn-confirm-appt" data-appt="{{ $a[0] }}" style="font-size:11px;padding:2px 8px;">Confirm</button>
                                        <button class="btn btn-xs btn-outline-danger btn-cancel-appt" data-appt="{{ $a[0] }}" style="font-size:11px;padding:2px 8px;">Cancel</button>
                                    @elseif($a[6] === 'reschedule')
                                        <button class="btn btn-xs btn-outline-secondary btn-reschedule-appt" data-appt="{{ $a[0] }}" style="font-size:11px;padding:2px 8px;">Reschedule</button>
                                    @endif
                                    <button class="btn btn-xs btn-outline-secondary ms-1" style="font-size:11px;padding:2px 8px;" onclick="window.print()"><i class="uil uil-print"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- end main-wrap --}}
    </div>{{-- end wrapper --}}
</div>{{-- end layout-wrapper --}}


{{-- New Appointment Modal --}}
<div class="modal fade" id="newApptModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;font-weight:700;">New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Modal Stepper --}}
                <div class="sc-stepper mb-3" id="apptStepper">
                    <div class="sc-step active" data-step="1"><span class="sc-step-num">1</span><span class="sc-step-label">Vehicle & SR</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="2"><span class="sc-step-num">2</span><span class="sc-step-label">Service Type</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="3"><span class="sc-step-num">3</span><span class="sc-step-label">Date & Slot</span></div>
                    <div class="sc-step-line"></div>
                    <div class="sc-step" data-step="4"><span class="sc-step-num">4</span><span class="sc-step-label">Contact</span></div>
                </div>

                {{-- Step A1 --}}
                <div class="appt-modal-step" id="apptStep1">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label>Vehicle Number <span class="text-danger">*</span></label>
                            <select class="form-select select2-vehicle-modal" style="width:100%;">
                                <option value="">Search vehicle...</option>
                                <option>TN01 AB1234</option>
                                <option>TN02 CD5678</option>
                                <option>TN03 EF9012</option>
                                <option>TN04 GH3456</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Linked SR Reference</label>
                            <select class="form-select">
                                <option value="">Select SR (optional)...</option>
                                <option>SR-2398 – Engine Oil</option>
                                <option>SR-2397 – Tyre Service</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn sc-btn-navy btn-sm appt-next-btn" data-next="apptStep2">Next <i class="uil uil-arrow-right ms-1"></i></button>
                    </div>
                </div>

                {{-- Step A2 --}}
                <div class="appt-modal-step" id="apptStep2" style="display:none;">
                    <div class="row g-2 mb-3">
                        @foreach([['🔧','Routine PM','routine'],['🛞','Tyre Service','tyre'],['🔋','Battery','battery'],['🚨','Breakdown','breakdown'],['🚗','Accident','accident'],['📋','Insurance','insurance']] as $t)
                        <div class="col-4 col-md-2">
                            <div class="sr-type-card appt-type-sel" data-type="{{ $t[2] }}">
                                <span class="st-icon">{{ $t[0] }}</span>
                                <span class="st-lbl">{{ $t[1] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <button class="btn btn-outline-secondary btn-sm appt-back-btn" data-back="apptStep1"><i class="uil uil-arrow-left me-1"></i>Back</button>
                        <button class="btn sc-btn-navy btn-sm appt-next-btn" data-next="apptStep3">Next <i class="uil uil-arrow-right ms-1"></i></button>
                    </div>
                </div>

                {{-- Step A3 --}}
                <div class="appt-modal-step" id="apptStep3" style="display:none;">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label>Appointment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-12">
                            <label>Available Slots</label>
                            <div class="row g-2 mt-1">
                                @foreach(['09:00','09:30','10:00','10:30','11:00','11:30','13:00','13:30','14:00','14:30','15:00','15:30'] as $slot)
                                <div class="col-3 col-md-2">
                                    <div class="slot-pick-card {{ in_array($slot,['09:00','10:00','13:00']) ? 'slot-full' : '' }}">{{ $slot }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Assign Technician</label>
                            <select class="form-select">
                                <option>Auto-assign</option>
                                <option>Ravi Kumar</option>
                                <option>Suresh M</option>
                                <option>Arjun S</option>
                                <option>Murugan P</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary btn-sm appt-back-btn" data-back="apptStep2"><i class="uil uil-arrow-left me-1"></i>Back</button>
                        <button class="btn sc-btn-navy btn-sm appt-next-btn" data-next="apptStep4">Next <i class="uil uil-arrow-right ms-1"></i></button>
                    </div>
                </div>

                {{-- Step A4 --}}
                <div class="appt-modal-step" id="apptStep4" style="display:none;">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label>Contact Name</label>
                            <input type="text" class="form-control" placeholder="Driver / fleet manager name">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Contact Mobile</label>
                            <input type="text" class="form-control" placeholder="Mobile number">
                        </div>
                        <div class="col-12">
                            <label>Notes / Instructions</label>
                            <textarea class="form-control" rows="2" placeholder="Any special instructions for the workshop..."></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary btn-sm appt-back-btn" data-back="apptStep3"><i class="uil uil-arrow-left me-1"></i>Back</button>
                        <button class="btn sc-btn-green btn-sm" id="btnSaveAppt"><i class="uil uil-check me-1"></i>Save Appointment</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- PRN-02 Appointment Slip (print only) --}}
<div class="print-only" id="prnAppt">
    <div class="sc-prn-head">
        <div><strong>SR Logistics</strong><br><small>Appointment Slip</small></div>
        <div class="text-end"><strong>APT-0401</strong><br><small>10 Apr 2026, 09:00</small></div>
    </div>
    <table style="width:100%;font-size:12px;border-collapse:collapse;">
        <tr><td style="padding:4px 8px;border:1px solid #ddd;width:40%;">Vehicle</td><td style="padding:4px 8px;border:1px solid #ddd;">TN01 AB1234</td></tr>
        <tr><td style="padding:4px 8px;border:1px solid #ddd;">Service Type</td><td style="padding:4px 8px;border:1px solid #ddd;">Routine Maintenance</td></tr>
        <tr><td style="padding:4px 8px;border:1px solid #ddd;">Status</td><td style="padding:4px 8px;border:1px solid #ddd;">Confirmed</td></tr>
    </table>
</div>
@endsection

@section('js')
<script>
$(function () {

    // Select2
    $('.select2-vehicle-modal').select2({ dropdownParent: $('#newApptModal'), placeholder: 'Search vehicle...', allowClear: true, width: '100%' });

    // Modal stepper navigation
    $(document).on('click', '.appt-next-btn', function () {
        const next = $(this).data('next');
        $('.appt-modal-step').hide();
        $('#' + next).show();
        const stepNum = parseInt(next.replace('apptStep', ''));
        updateApptStepper(stepNum);
    });
    $(document).on('click', '.appt-back-btn', function () {
        const back = $(this).data('back');
        $('.appt-modal-step').hide();
        $('#' + back).show();
        const stepNum = parseInt(back.replace('apptStep', ''));
        updateApptStepper(stepNum);
    });
    function updateApptStepper(n) {
        $('#apptStepper .sc-step').each(function () {
            const s = parseInt($(this).data('step'));
            $(this).removeClass('active done');
            if (s < n)  $(this).addClass('done');
            if (s === n) $(this).addClass('active');
        });
        $('#apptStepper .sc-step-line').each(function (i) {
            $(this).removeClass('done');
            if (i < n - 1) $(this).addClass('done');
        });
    }

    // Slot selection
    $(document).on('click', '.slot-pick-card:not(.slot-full)', function () {
        $('.slot-pick-card').removeClass('selected');
        $(this).addClass('selected');
    });

    // Service type selection (modal)
    $(document).on('click', '.appt-type-sel', function () {
        $('.appt-type-sel').removeClass('selected');
        $(this).addClass('selected');
    });

    // Save appointment
    $('#btnSaveAppt').click(function () {
        Swal.fire({
            icon: 'success',
            title: 'Appointment Saved!',
            text: 'APT-0409 confirmed for TN01 AB1234 on 10 Apr 2026 at 09:30.',
            confirmButtonColor: '#032671'
        }).then(() => {
            $('#newApptModal').modal('hide');
        });
    });

    // Confirm appointment
    $(document).on('click', '.btn-confirm-appt', function () {
        const appt = $(this).data('appt');
        Swal.fire({
            title: 'Confirm Appointment?',
            text: appt + ' will be marked as Confirmed.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10863f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Confirmed!', text: appt + ' is now confirmed.', timer: 1500, showConfirmButton: false });
            }
        });
    });

    // Cancel appointment
    $(document).on('click', '.btn-cancel-appt', function () {
        const appt = $(this).data('appt');
        Swal.fire({
            title: 'Cancel Appointment?',
            text: appt + ' will be cancelled.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea0027',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'info', title: 'Cancelled', text: appt + ' has been cancelled.', timer: 1500, showConfirmButton: false });
            }
        });
    });

    // Reschedule
    $(document).on('click', '.btn-reschedule-appt', function () {
        const appt = $(this).data('appt');
        Swal.fire({
            title: 'Reschedule ' + appt + '?',
            html: '<input type="date" id="rescheduleDate" class="form-control mt-2" value="{{ date("Y-m-d") }}">',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#032671',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Reschedule'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Rescheduled!', text: appt + ' has been rescheduled.', timer: 1500, showConfirmButton: false });
            }
        });
    });

    // Reset modal on close
    $('#newApptModal').on('hidden.bs.modal', function () {
        $('.appt-modal-step').hide();
        $('#apptStep1').show();
        updateApptStepper(1);
        $('.sr-type-card').removeClass('selected');
        $('.slot-pick-card').removeClass('selected');
    });

});
</script>
@endsection
