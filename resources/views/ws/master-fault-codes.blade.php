@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/Master/fault-codes.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="side-wrap">
            @include('includes.leftbar')
            <div class="main-wrap">

                <div class="container-fluid page-head">
                    <div class="row align-items-center">
                        <div class="col-12 d-flex flex-wrap align-items-center gap-2">
                            <h5 class="mb-0 me-1">Fault / Complaint Codes</h5>
                            <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#addFcModal">
                                <i class="uil uil-plus me-1"></i> Add Code
                            </button>
                            <select class="form-select form-select-sm" id="filterFcSystem" style="width:150px;">
                                <option value="">All Systems</option>
                                <option>Engine</option>
                                <option>Brakes</option>
                                <option>Electrical</option>
                                <option>Transmission</option>
                                <option>Tyres & Wheels</option>
                                <option>Suspension</option>
                                <option>Cooling System</option>
                                <option>Body & Cabin</option>
                                <option>Fuel System</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterFcSeverity" style="width:130px;">
                                <option value="">All Severity</option>
                                <option>Critical</option>
                                <option>Major</option>
                                <option>Minor</option>
                                <option>Advisory</option>
                            </select>
                            <select class="form-select form-select-sm" id="filterFcStatus" style="width:110px;">
                                <option value="">All Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" id="filterFcSearch" placeholder="Search code / symptom…" style="width:200px;">
                            <button class="btn btn-primary btn-sm" id="btnClearFc">
                                <i class="uil uil-history me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-2">
                    <table class="table table-hover invoice-table mb-0" id="fcTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Complaint / Symptom</th>
                                <th>System</th>
                                <th>Severity</th>
                                <th>Probable Cause</th>
                                <th>Suggested Service</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $faultCodes = [
                                // [Code, Complaint/Symptom, System, Severity, Probable Cause, Suggested Service]
                                ['FC-001', 'Engine Oil Leaking',               'Engine',          'Major',    'Worn gasket or seal',           'Gasket / Seal Replacement'],
                                ['FC-002', 'Engine Overheating',               'Cooling System',  'Critical', 'Low coolant / Thermostat fault','Coolant Flush & Thermostat Check'],
                                ['FC-003', 'Excessive Engine Smoke (Black)',    'Engine',          'Major',    'Rich fuel mixture / injector',  'Fuel Injector Service'],
                                ['FC-004', 'Engine Not Starting',              'Electrical',      'Critical', 'Battery / starter motor fault', 'Battery / Starter Check'],
                                ['FC-005', 'Brake Noise (Squealing)',           'Brakes',          'Major',    'Worn brake pads',               'Brake Pad Replacement'],
                                ['FC-006', 'Brake Pedal Spongy / Low',         'Brakes',          'Critical', 'Air in brake lines / fluid low','Brake Bleed & Fluid Top-Up'],
                                ['FC-007', 'Vehicle Pulling to One Side',      'Tyres & Wheels',  'Major',    'Tyre pressure / alignment',     'Wheel Alignment & Tyre Check'],
                                ['FC-008', 'Tyre Abnormal Wear',               'Tyres & Wheels',  'Minor',    'Misalignment / over-inflation', 'Wheel Alignment & Rotation'],
                                ['FC-009', 'Gear Shifting Hard / Grinding',    'Transmission',    'Major',    'Low gear oil / clutch wear',    'Gear Oil Change & Clutch Check'],
                                ['FC-010', 'Clutch Slipping',                  'Transmission',    'Major',    'Worn clutch plate',             'Clutch Plate Replacement'],
                                ['FC-011', 'Battery Draining Fast',            'Electrical',      'Major',    'Alternator / battery ageing',   'Battery & Alternator Test'],
                                ['FC-012', 'AC Not Cooling',                   'Cooling System',  'Minor',    'Low refrigerant / compressor',  'AC Gas Recharge & Service'],
                                ['FC-013', 'Suspension Noise (Knocking)',       'Suspension',      'Major',    'Worn shock absorbers / bushes', 'Shock & Bush Inspection'],
                                ['FC-014', 'Fuel Consumption High',            'Fuel System',     'Advisory', 'Clogged air/fuel filter',       'Filter Replacement & Tuneup'],
                                ['FC-015', 'Headlamp Not Working',             'Electrical',      'Minor',    'Blown bulb / fuse fault',       'Bulb / Fuse Replacement'],
                                ['FC-016', 'Check Engine Light On',            'Engine',          'Advisory', 'Sensor fault / loose connector','OBD Scan & Diagnosis'],
                                ['FC-017', 'Steering Hard / Heavy',            'Suspension',      'Major',    'Power steering fluid low',      'PS Fluid Top-Up & Check'],
                                ['FC-018', 'Vehicle Vibrating at Speed',       'Tyres & Wheels',  'Major',    'Wheel imbalance / worn tyre',   'Wheel Balancing & Tyre Check'],
                                ['FC-019', 'Coolant Level Dropping',           'Cooling System',  'Major',    'Radiator leak / hose crack',    'Radiator & Hose Inspection'],
                                ['FC-020', 'Door / Panel Damage Reported',     'Body & Cabin',    'Minor',    'Impact / accident damage',      'Body & Paint Assessment'],
                            ];
                            $severityColors = [
                                'Critical' => 'bg-danger',
                                'Major'    => 'bg-warning text-dark',
                                'Minor'    => 'bg-info text-dark',
                                'Advisory' => 'bg-secondary',
                            ];
                            $systemColors = [
                                'Engine'          => 'bg-danger',
                                'Brakes'          => 'bg-warning text-dark',
                                'Electrical'      => 'bg-info text-dark',
                                'Transmission'    => 'bg-dark',
                                'Tyres & Wheels'  => 'bg-secondary',
                                'Suspension'      => 'bg-success',
                                'Cooling System'  => 'bg-primary',
                                'Body & Cabin'    => 'bg-light text-dark border',
                                'Fuel System'     => 'bg-warning text-dark',
                            ];
                            @endphp
                            @foreach($faultCodes as $fc)
                            <tr data-system="{{ strtolower($fc[2]) }}"
                                data-severity="{{ strtolower($fc[3]) }}"
                                data-status="active"
                                data-name="{{ strtolower($fc[0]) }} {{ strtolower($fc[1]) }}">
                                <td>
                                    <span class="fw-bold" style="color:#032671;font-size:12px;">{{ $fc[0] }}</span>
                                </td>
                                <td class="fw-semibold">{{ $fc[1] }}</td>
                                <td>
                                    <span class="badge {{ $systemColors[$fc[2]] ?? 'bg-secondary' }}" style="font-size:11px;">{{ $fc[2] }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $severityColors[$fc[3]] ?? 'bg-secondary' }}">{{ $fc[3] }}</span>
                                </td>
                                <td style="font-size:12px;color:#555;max-width:200px;">{{ $fc[4] }}</td>
                                <td style="font-size:12px;color:#032671;">{{ $fc[5] }}</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td class="text-end">
                                    <div class="dropdown dot-dd">
                                        <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-h"></i>
                                        </span>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item btn-edit-fc" href="javascript:void(0)"
                                                    data-code="{{ $fc[0] }}" data-complaint="{{ $fc[1] }}"
                                                    data-system="{{ $fc[2] }}" data-severity="{{ $fc[3] }}"
                                                    data-cause="{{ $fc[4] }}" data-service="{{ $fc[5] }}"
                                                    data-status="Active"
                                                    data-bs-toggle="modal" data-bs-target="#editFcModal">
                                                    <i class="uil uil-pen me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item btn-toggle-fc text-danger" href="javascript:void(0)"
                                                    data-name="{{ $fc[0] }}" data-current="Active">
                                                    <i class="uil uil-ban me-2"></i>Deactivate
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-3 py-2 border-top mt-0">
                    <small class="text-muted" id="fcCount">Showing {{ count($faultCodes) }} fault codes</small>
                    &nbsp;|&nbsp;
                    <small class="text-danger fw-semibold">
                        @php $critical = collect($faultCodes)->where(3, 'Critical')->count(); @endphp
                        {{ $critical }} Critical
                    </small>
                    &nbsp;|&nbsp;
                    <small class="text-warning fw-semibold">
                        @php $major = collect($faultCodes)->where(3, 'Major')->count(); @endphp
                        {{ $major }} Major
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addFcModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-exclamation-triangle me-2"></i>Add Fault Code</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addFcCode" placeholder="e.g. FC-021">
                        <div class="form-text">Unique fault code.</div>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label fw-semibold">Complaint / Symptom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addFcComplaint" placeholder="e.g. Exhaust Blowing / Noisy">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">System / Component <span class="text-danger">*</span></label>
                        <select class="form-select" id="addFcSystem">
                            <option value="">— Select —</option>
                            <option>Engine</option>
                            <option>Brakes</option>
                            <option>Electrical</option>
                            <option>Transmission</option>
                            <option>Tyres & Wheels</option>
                            <option>Suspension</option>
                            <option>Cooling System</option>
                            <option>Body & Cabin</option>
                            <option>Fuel System</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Severity</label>
                        <select class="form-select" id="addFcSeverity">
                            <option>Critical</option>
                            <option>Major</option>
                            <option>Minor</option>
                            <option>Advisory</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Probable Cause</label>
                        <input type="text" class="form-control" id="addFcCause" placeholder="e.g. Cracked exhaust manifold / gasket failure">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Suggested Service / Action</label>
                        <input type="text" class="form-control" id="addFcService" placeholder="e.g. Exhaust Manifold Inspection & Repair">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="addFcStatus">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Additional Notes</label>
                        <textarea class="form-control" rows="2" placeholder="Any technician notes or diagnostic hints…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnSaveFc">
                    <i class="uil uil-save me-1"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editFcModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-pen me-2"></i>Edit Fault Code</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Code</label>
                        <input type="text" class="form-control" id="editFcCode" readonly>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label fw-semibold">Complaint / Symptom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editFcComplaint">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">System</label>
                        <select class="form-select" id="editFcSystem">
                            <option>Engine</option><option>Brakes</option><option>Electrical</option>
                            <option>Transmission</option><option>Tyres & Wheels</option><option>Suspension</option>
                            <option>Cooling System</option><option>Body & Cabin</option><option>Fuel System</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Severity</label>
                        <select class="form-select" id="editFcSeverity">
                            <option>Critical</option><option>Major</option><option>Minor</option><option>Advisory</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Probable Cause</label>
                        <input type="text" class="form-control" id="editFcCause">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Suggested Service</label>
                        <input type="text" class="form-control" id="editFcService">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="editFcStatus">
                            <option>Active</option><option>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" id="btnUpdateFc">
                    <i class="uil uil-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {

    /* ── Populate Edit modal ── */
    $(document).on('click', '.btn-edit-fc', function () {
        var b = $(this);
        $('#editFcCode').val(b.data('code'));
        $('#editFcComplaint').val(b.data('complaint'));
        $('#editFcSystem').val(b.data('system'));
        $('#editFcSeverity').val(b.data('severity'));
        $('#editFcCause').val(b.data('cause'));
        $('#editFcService').val(b.data('service'));
        $('#editFcStatus').val(b.data('status'));
    });

    /* ── Save ── */
    $('#btnSaveFc').on('click', function () {
        if (!$('#addFcCode').val().trim() || !$('#addFcComplaint').val().trim() || !$('#addFcSystem').val()) {
            Swal.fire({ icon:'warning', title:'Required Fields', text:'Please fill in Code, Complaint and System.', confirmButtonColor:'#032671' });
            return;
        }
        Swal.fire({ icon:'success', title:'Fault Code Saved', timer:1500, showConfirmButton:false });
        $('#addFcModal').modal('hide');
    });

    $('#btnUpdateFc').on('click', function () {
        Swal.fire({ icon:'success', title:'Updated', timer:1500, showConfirmButton:false });
        $('#editFcModal').modal('hide');
    });

    /* ── Toggle ── */
    $(document).on('click', '.btn-toggle-fc', function () {
        var name = $(this).data('name'), current = $(this).data('current');
        var action = current === 'Active' ? 'Deactivate' : 'Activate';
        Swal.fire({
            title: action + ' Fault Code?',
            text: name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: current === 'Active' ? '#ea0027' : '#10863f',
            confirmButtonText: action
        }).then(r => { if (r.isConfirmed) Swal.fire({ icon:'success', title:'Done', timer:1400, showConfirmButton:false }); });
    });

    /* ── Client-side filter ── */
    function filterFc() {
        var system   = $('#filterFcSystem').val().toLowerCase();
        var severity = $('#filterFcSeverity').val().toLowerCase();
        var status   = $('#filterFcStatus').val().toLowerCase();
        var search   = $('#filterFcSearch').val().toLowerCase();
        var count    = 0;
        $('#fcTable tbody tr').each(function () {
            var $tr = $(this);
            var match = true;
            if (system   && $tr.data('system').indexOf(system)     === -1) match = false;
            if (severity && $tr.data('severity').indexOf(severity) === -1) match = false;
            if (status   && $tr.data('status').indexOf(status)     === -1) match = false;
            if (search   && $tr.data('name').indexOf(search)       === -1) match = false;
            $tr.toggle(match);
            if (match) count++;
        });
        $('#fcCount').text('Showing ' + count + ' fault codes');
    }

    $('#filterFcSystem,#filterFcSeverity,#filterFcStatus').on('change', filterFc);
    $('#filterFcSearch').on('keyup', filterFc);
    $('#btnClearFc').on('click', function () {
        $('#filterFcSystem,#filterFcSeverity,#filterFcStatus').val('');
        $('#filterFcSearch').val('');
        filterFc();
    });
});
</script>
@endsection
