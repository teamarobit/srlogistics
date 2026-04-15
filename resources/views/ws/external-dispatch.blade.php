@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/external-dispatch.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">External Dispatch</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">External Dispatch</h5>
                    <span class="text-muted" style="font-size:12px;">Vehicles sent to Brand ASC, Authorised SC, or Third-Party workshops</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('ws.external.tracker') }}" class="btn btn-outline-secondary btn-sm"><i class="uil uil-map-marker me-1"></i>Tracker View</a>
                    <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#newDispatchModal">
                        <i class="uil uil-plus me-1"></i> New Dispatch
                    </button>
                </div>
            </div>

            {{-- Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-truck"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">8</div><div class="sc-stat-label">Active External Jobs</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-building"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">5</div><div class="sc-stat-label">At Brand ASC</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-store"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">3</div><div class="sc-stat-label">At Third Party</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">11</div><div class="sc-stat-label">Returned This Month</div></div>
                    </div>
                </div>
            </div>

            {{-- Filter --}}
            <div class="sc-card mb-3">
                <div class="row g-2 align-items-end p-1">
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">Status</label>
                        <select class="form-select form-select-sm">
                            <option value="">All</option>
                            <option>Dispatched</option>
                            <option>Under Diagnosis</option>
                            <option>Repair Started</option>
                            <option>Ready to Collect</option>
                            <option>Returned</option>
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
                        <label class="sc-form-label">Vehicle</label>
                        <select class="form-select form-select-sm select2-vehicle-ext" multiple></select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="sc-form-label">From Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <button class="btn btn-outline-secondary btn-sm w-100 mt-1"><i class="uil uil-times"></i></button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Dispatch #</th>
                                <th>Vehicle</th>
                                <th>Workshop</th>
                                <th>Type</th>
                                <th>Problem</th>
                                <th>Dispatched</th>
                                <th>Est. Return</th>
                                <th>TAT</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $dispatches = [
                                ['EXT-2026-0008','KA-05-AB-1234','Tata Prima 4928','Tata Motors ASC, Hebbal','Brand ASC','Engine knocking noise','07-Apr-2026','14-Apr-2026',4,'diagnosing'],
                                ['EXT-2026-0007','MH-12-XY-9876','Ashok Leyland 1916','AL Authorized SC, Pune','Brand ASC','Gearbox overhaul','05-Apr-2026','12-Apr-2026',6,'repairing'],
                                ['EXT-2026-0006','DL-01-CD-4567','Bharat Benz 2523','Benz ASC, Delhi','Warranty','AC compressor failure','03-Apr-2026','10-Apr-2026',8,'ready'],
                                ['EXT-2026-0005','GJ-03-ZZ-7890','Tata 407 LPT','Ram Auto Works, Ahmedabad','Third Party','Body dent repair','01-Apr-2026','08-Apr-2026',10,'repairing'],
                                ['EXT-2026-0004','RJ-14-GA-1111','Eicher Pro 3015','Eicher ASC, Jaipur','Brand ASC','Engine rebuild','28-Mar-2026','11-Apr-2026',14,'ready'],
                                ['EXT-2026-0003','UP-32-BT-5544','Volvo FH 400','Volvo ASC, Noida','Warranty','AdBlue system fault','25-Mar-2026','05-Apr-2026',17,'returned'],
                            ];
                            $statusMap = ['dispatched'=>'sc-dsp-dispatched','diagnosing'=>'sc-dsp-diagnosing','repairing'=>'sc-dsp-repairing','ready'=>'sc-dsp-ready','returned'=>'sc-dsp-returned'];
                            $statusLabel = ['dispatched'=>'Dispatched','diagnosing'=>'Under Diagnosis','repairing'=>'Repair Started','ready'=>'Ready to Collect','returned'=>'Returned'];
                            $typeMap = ['Brand ASC'=>'sc-ext-brand','Third Party'=>'sc-ext-third','Warranty'=>'sc-ext-warranty'];
                            @endphp
                            @foreach($dispatches as $d)
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;color:#032671;">{{ $d[0] }}</td>
                                <td><div class="sc-veh-cell"><span class="sc-reg-badge">{{ $d[1] }}</span><span class="sc-veh-model">{{ $d[2] }}</span></div></td>
                                <td style="font-size:12px;">{{ $d[3] }}</td>
                                <td><span class="{{ $typeMap[$d[4]] }}">{{ $d[4] }}</span></td>
                                <td style="font-size:12px;max-width:160px;">{{ $d[5] }}</td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $d[6] }}</td>
                                <td class="text-nowrap {{ in_array($d[8],[10,14,17]) && $d[9]!=='returned' ? 'text-danger fw-semibold' : '' }}" style="font-size:12px;">{{ $d[7] }}</td>
                                <td><span class="{{ $d[8] > 7 && $d[9]!=='returned' ? 'sc-tat-overdue' : ($d[8] > 4 ? 'sc-tat-warning' : 'sc-tat-ok') }}">{{ $d[8] }}d</span></td>
                                <td><span class="{{ $statusMap[$d[9]] }}">{{ $statusLabel[$d[9]] }}</span></td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <a href="{{ route('ws.external.tracker') }}" class="sc-action-btn" title="Track"><i class="uil uil-map-marker"></i></a>
                                        <button class="sc-action-btn" title="Update Status"><i class="uil uil-sync"></i></button>
                                        @if($d[9]==='ready')
                                        <a href="{{ route('ws.external.return') }}" class="sc-action-btn" title="Process Return" style="color:#10863f;border-color:#10863f;"><i class="uil uil-truck"></i></a>
                                        @else
                                        <button class="sc-action-btn" title="View Details"><i class="uil uil-eye"></i></button>
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

{{-- New Dispatch Modal --}}
<div class="modal fade" id="newDispatchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-truck me-2"></i>New External Dispatch</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm select2-vehicle-disp" style="width:100%;"></select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Workshop Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="dispExtSc" placeholder="e.g. Tata Motors ASC, Bangalore">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Workshop Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" id="dispScType">
                            <option value="">— Select type —</option>
                            <option>Brand ASC</option>
                            <option>Third Party</option>
                            <option>Warranty</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Workshop Contact / Phone</label>
                        <input type="text" class="form-control form-control-sm" id="dispScPhone" placeholder="Auto-filled from master data">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Dispatch Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">KM at Dispatch</label>
                        <input type="number" class="form-control form-control-sm" placeholder="Current odometer">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Est. Return Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Problem Description <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Describe the fault or work required..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Estimated Cost (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Warranty Claim?</label>
                        <select class="form-select form-select-sm">
                            <option value="0">No — Chargeable</option>
                            <option value="1">Yes — Under Warranty</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Documents Sent</label>
                        <div class="d-flex flex-wrap gap-3 mt-1">
                            @foreach(['RC Copy','Insurance Copy','Service History','Warranty Card','Delivery Note'] as $doc)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="doc_{{ $loop->index }}">
                                <label class="form-check-label" for="doc_{{ $loop->index }}" style="font-size:12px;">{{ $doc }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Create Dispatch</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
    // Vehicle selects
    $('.select2-vehicle-ext').select2({ width: '100%', placeholder: 'All Vehicles', allowClear: true });
    $('.select2-vehicle-disp').select2({ width: '100%', placeholder: 'Search vehicle...', allowClear: true, dropdownParent: $('#newDispatchModal') });

    // Create Dispatch button
    $('#newDispatchModal .modal-footer .sc-btn-navy').on('click', function () {
        var veh  = $('#newDispatchModal .select2-vehicle-disp').val();
        var sc   = $('#dispExtSc').val().trim();
        var type = $('#dispScType').val();

        if (!veh || !sc || !type) {
            Swal.fire({ icon: 'warning', title: 'Missing Fields', text: 'Please select Vehicle, enter Workshop name, and Workshop Type.', confirmButtonColor: '#032671' });
            return;
        }
        $('#newDispatchModal').modal('hide');
        Swal.fire({
            icon: 'success', title: 'Dispatch Created',
            html: 'Vehicle dispatched to <strong>' + sc + '</strong>.',
            confirmButtonColor: '#10863f'
        });
    });
});
</script>
@endsection
