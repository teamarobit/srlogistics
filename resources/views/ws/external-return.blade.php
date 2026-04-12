@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/external-return.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active">Vehicle Return</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">External Workshop — Vehicle Return</h5>
                    <span class="text-muted" style="font-size:12px;">Process collection of vehicles returned from external workshops &amp; ASCs</span>
                </div>
                <a href="{{ route('ws.external.tracker') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="uil uil-map-marker me-1"></i> Tracker View
                </a>
            </div>

            {{-- Stats --}}
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-navy">
                        <div class="sc-stat-icon"><i class="uil uil-truck"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">2</div><div class="sc-stat-label">Ready to Collect</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-green">
                        <div class="sc-stat-icon"><i class="uil uil-check-circle"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">11</div><div class="sc-stat-label">Returned This Month</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-amber">
                        <div class="sc-stat-icon"><i class="uil uil-clock"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">1</div><div class="sc-stat-label">Pending Bill Clearance</div></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="sc-stat-card sc-stat-grey">
                        <div class="sc-stat-icon"><i class="uil uil-calendar-alt"></i></div>
                        <div class="sc-stat-body"><div class="sc-stat-val">13d</div><div class="sc-stat-label">Avg External TAT</div></div>
                    </div>
                </div>
            </div>

            {{-- Ready to Collect Section --}}
            <div class="sc-ext-section-label mb-2">Ready to Collect</div>
            <div class="row g-3 mb-4">

                @php
                $readyVehicles = [
                    ['EXT-2026-0004','RJ-14-GA-1111','Eicher Pro 3015','Eicher ASC, Jaipur','Brand ASC','Engine rebuild','28-Mar-2026','11-Apr-2026',14,'EINV-2026-0007','pending'],
                    ['EXT-2026-0006','DL-01-CD-4567','Bharat Benz 2523','Benz ASC, Delhi','Warranty','AC compressor failure','03-Apr-2026','10-Apr-2026',8,'EINV-2026-0005','warranty'],
                ];
                @endphp

                @foreach($readyVehicles as $rv)
                <div class="col-lg-6">
                    <div class="sc-ext-return-card">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div>
                                <div class="sc-veh-cell">
                                    <span class="sc-reg-badge">{{ $rv[1] }}</span>
                                    <span class="sc-veh-model">{{ $rv[2] }}</span>
                                </div>
                            </div>
                            <span class="sc-dsp-ready">Ready to Collect</span>
                        </div>
                        <div class="sc-ext-return-meta">
                            <div><i class="uil uil-building me-1"></i>{{ $rv[3] }}</div>
                            <div><i class="uil uil-wrench me-1"></i>{{ $rv[5] }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-2 mb-3">
                            <div style="font-size:11px;color:#6c757d;">Dispatched: <strong>{{ $rv[6] }}</strong></div>
                            <div style="font-size:11px;color:#6c757d;">Completed: <strong>{{ $rv[7] }}</strong></div>
                            <span class="{{ $rv[8] > 10 ? 'sc-tat-overdue' : ($rv[8] > 6 ? 'sc-tat-warning' : 'sc-tat-ok') }}">{{ $rv[8] }}d TAT</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span style="font-size:11px;color:#6c757d;">Invoice: </span>
                                <a href="{{ route('ws.external.billing') }}" style="font-size:12px;color:#032671;font-weight:600;">{{ $rv[9] }}</a>
                                <span class="ms-2 {{ $rv[10] === 'warranty' ? 'sc-ext-bill-warranty' : ($rv[10] === 'paid' ? 'sc-ext-bill-paid' : 'sc-ext-bill-pending') }}">
                                    {{ $rv[10] === 'warranty' ? 'Warranty' : ($rv[10] === 'paid' ? 'Paid' : 'Payment Pending') }}
                                </span>
                            </div>
                            <button class="btn sc-btn-navy btn-sm" style="font-size:11px;" data-bs-toggle="modal" data-bs-target="#collectModal" data-dispatch="{{ $rv[0] }}" data-reg="{{ $rv[1] }}">
                                <i class="uil uil-truck me-1"></i> Process Collection
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Return History --}}
            <div class="sc-ext-section-label mb-2">Return History</div>
            <div class="sc-table-card">
                <div class="table-responsive">
                    <table class="table sc-table mb-0">
                        <thead>
                            <tr>
                                <th>Dispatch #</th>
                                <th>Vehicle</th>
                                <th>Workshop</th>
                                <th>Work Done</th>
                                <th>Dispatched</th>
                                <th>Returned</th>
                                <th>TAT</th>
                                <th>Invoice</th>
                                <th>Bill Status</th>
                                <th>Collected By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $returns = [
                                ['EXT-2026-0010','KL-09-PQ-5566','Volvo FH 400','Volvo ASC','Warranty','Turbocharger replacement','30-Mar-2026','10-Apr-2026',11,'EINV-2026-0006','warranty','Suresh P'],
                                ['EXT-2026-0003','UP-32-BT-5544','Volvo FH 400','Volvo ASC, Noida','Warranty','AdBlue system fault','25-Mar-2026','05-Apr-2026',11,'EINV-2026-0004','paid','Ramesh K'],
                                ['EXT-2026-0002','HR-26-YZ-8877','Ashok Leyland 1916','AL Auth SC','Brand ASC','Clutch plate replacement','20-Mar-2026','01-Apr-2026',12,'EINV-2026-0003','paid','Ravi V'],
                                ['EXT-2026-0001','PB-10-CD-3344','Eicher Pro 3015','Third Party WS','Third Party','Body dent + paint','12-Mar-2026','25-Mar-2026',13,'EINV-2026-0002','dispute','Arjun S'],
                            ];
                            $billLabelMap = ['paid'=>'sc-ext-bill-paid','warranty'=>'sc-ext-bill-warranty','pending'=>'sc-ext-bill-pending','dispute'=>'sc-ext-bill-dispute'];
                            $billLabels   = ['paid'=>'Paid','warranty'=>'Warranty','pending'=>'Pending','dispute'=>'Disputed'];
                            $typeMap2 = ['Brand ASC'=>'sc-ext-brand','Third Party'=>'sc-ext-third','Warranty'=>'sc-ext-warranty'];
                            @endphp
                            @foreach($returns as $r)
                            <tr>
                                <td class="fw-semibold" style="font-size:12px;color:#032671;">{{ $r[0] }}</td>
                                <td>
                                    <div class="sc-veh-cell">
                                        <span class="sc-reg-badge">{{ $r[1] }}</span>
                                        <span class="sc-veh-model">{{ $r[2] }}</span>
                                    </div>
                                </td>
                                <td style="font-size:12px;">{{ $r[3] }}</td>
                                <td style="font-size:12px;max-width:140px;">{{ $r[5] }}</td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $r[6] }}</td>
                                <td class="text-nowrap" style="font-size:12px;">{{ $r[7] }}</td>
                                <td><span class="{{ $r[8] > 14 ? 'sc-tat-overdue' : ($r[8] > 9 ? 'sc-tat-warning' : 'sc-tat-ok') }}">{{ $r[8] }}d</span></td>
                                <td><a href="{{ route('ws.external.billing') }}" style="font-size:12px;color:#032671;font-weight:600;">{{ $r[9] }}</a></td>
                                <td><span class="{{ $billLabelMap[$r[10]] }}">{{ $billLabels[$r[10]] }}</span></td>
                                <td style="font-size:12px;">{{ $r[11] }}</td>
                                <td class="text-center">
                                    <div class="sc-row-actions">
                                        <button class="sc-action-btn" title="View Details"><i class="uil uil-eye"></i></button>
                                        <button class="sc-action-btn" title="Print Return Note"><i class="uil uil-print"></i></button>
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

{{-- Collect / Process Return Modal --}}
<div class="modal fade" id="collectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-truck me-2"></i>Process Vehicle Collection — EXT-2026-0004</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Vehicle summary --}}
                <div class="sc-ext-return-summary mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;">Vehicle</div>
                            <div class="sc-veh-cell mt-1">
                                <span class="sc-reg-badge">RJ-14-GA-1111</span>
                                <span class="sc-veh-model">Eicher Pro 3015</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;">Workshop</div>
                            <div style="font-size:12px;margin-top:4px;">Eicher ASC, Jaipur</div>
                        </div>
                        <div class="col-md-4">
                            <div style="font-size:10px;color:#adb5bd;font-weight:700;text-transform:uppercase;">Work Done</div>
                            <div style="font-size:12px;margin-top:4px;">Engine rebuild</div>
                        </div>
                    </div>
                </div>

                {{-- Return checklist --}}
                <div class="sc-ins-detail-label mb-2">Return Inspection Checklist</div>
                <div class="sc-ext-chk-grid mb-3">
                    @foreach([
                        'Engine starts normally','No abnormal noise','All reported work completed',
                        'No new damage observed','Fluids topped up','All parts returned / replaced',
                        'External SC job card received','Invoice / bill received','Test drive done',
                    ] as $item)
                    <div class="sc-ext-chk-item">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="sc-insp-btn" data-state="0">
                                <span class="insp-ok">✓ OK</span>
                                <span class="insp-fail">✗ Fail</span>
                                <span class="insp-na">— N/A</span>
                            </div>
                            <span style="font-size:12px;">{{ $item }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="sc-form-label">Collection Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">KM at Collection</label>
                        <input type="number" class="form-control form-control-sm" placeholder="Odometer reading on collection">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Collected By (Driver/Staff) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" placeholder="Name of person who collected">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Driver / Staff ID</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Employee ID">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Post-Return Observations</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any observations, issues noticed, or pending items..."></textarea>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chkBillCleared">
                            <label class="form-check-label" for="chkBillCleared" style="font-size:12px;">Invoice payment processed / warranty confirmed</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Confirm Collection</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(function() {
    // Inspection toggle: 0=blank, 1=ok, 2=fail, 3=na → cycles
    $(document).on('click', '.sc-insp-btn', function() {
        var s = parseInt($(this).data('state'));
        s = (s + 1) % 4;
        $(this).data('state', s)
               .removeClass('active-ok active-fail active-na')
               .addClass(s===1?'active-ok':s===2?'active-fail':s===3?'active-na':'');
    });
});
</script>
@endsection
