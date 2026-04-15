@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/insurance.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('fleetdashboard.index') }}">Fleet</a></li>
                    <li class="breadcrumb-item active">Insurance Claims</li>
                </ol>
            </nav>

            {{-- Page Header --}}
            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">Insurance Claims</h5>
                    <span class="text-muted" style="font-size:12px;">Claims tracking · Policy expiry monitoring · Surveyor management</span>
                </div>
                <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#newClaimModal">
                    <i class="uil uil-plus me-1"></i>New Claim
                </button>
            </div>

            {{-- Summary chips — real data from controller --}}
            <div class="d-flex flex-wrap gap-2 mb-3">
                <div style="background:#e3ecff;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-file-alt" style="color:#032671;font-size:14px;"></i>
                    <span style="font-size:13px;color:#032671;font-weight:700;">{{ $summary['open'] ?? 0 }}</span>
                    <span style="font-size:11px;color:#555;">Open Claims</span>
                </div>
                <div style="background:#fff3e0;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-clock" style="color:#e65100;font-size:14px;"></i>
                    <span style="font-size:13px;color:#e65100;font-weight:700;">{{ $summary['pending'] ?? 0 }}</span>
                    <span style="font-size:11px;color:#555;">Pending Survey/Approval</span>
                </div>
                <div style="background:#e6f4ea;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-check-circle" style="color:#10863f;font-size:14px;"></i>
                    <span style="font-size:13px;color:#10863f;font-weight:700;">{{ $summary['approved'] ?? 0 }}</span>
                    <span style="font-size:11px;color:#555;">Approved / Settled</span>
                </div>
                <div style="background:#f0f2f7;border-radius:6px;padding:6px 14px;display:flex;align-items:center;gap:8px;">
                    <i class="uil uil-layers" style="color:#6c757d;font-size:14px;"></i>
                    <span style="font-size:13px;color:#6c757d;font-weight:700;">{{ $summary['total'] ?? 0 }}</span>
                    <span style="font-size:11px;color:#555;">Total Claims</span>
                </div>
            </div>

            {{-- Tab Navigation --}}
            <ul class="nav ins-tab-nav mb-0" id="insTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="claims-tab" data-bs-toggle="tab" href="#tabClaims" role="tab">
                        <i class="uil uil-file-alt me-1"></i>Claims
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="policy-tab" data-bs-toggle="tab" href="#tabPolicy" role="tab">
                        <i class="uil uil-shield me-1"></i>Policy Expiry Tracker
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                {{-- ── TAB 1: Claims ── --}}
                <div class="tab-pane fade show active" id="tabClaims" role="tabpanel">

                    {{-- Filter bar --}}
                    <div class="d-flex flex-wrap align-items-center gap-2 py-2 px-1 border-bottom mb-0" style="background:#fafbfc;">
                        <select class="form-select form-select-sm" style="width:130px;" id="fltStatus">
                            <option value="">All Statuses</option>
                            <option>Filed</option>
                            <option>Under Survey</option>
                            <option>Approved</option>
                            <option>Settled</option>
                            <option>Rejected</option>
                        </select>
                        <select class="form-select form-select-sm" style="width:140px;" id="fltType">
                            <option value="">All Types</option>
                            <option>Own Damage</option>
                            <option>Third Party</option>
                            <option>Theft</option>
                            <option>Fire</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" style="width:160px;" placeholder="Search vehicle / claim #" id="fltSearch">
                        <input type="date" class="form-control form-control-sm" style="width:130px;" id="fltFrom">
                        <button class="btn btn-outline-secondary btn-sm" id="fltReset"><i class="uil uil-times"></i></button>
                        <span class="ms-auto text-muted" style="font-size:11px;" id="claimCount">6 claims</span>
                    </div>

                    {{-- Claims Table --}}
                    <div class="sc-table-card">
                        <div class="table-responsive">
                            <table class="table ins-table mb-0" id="claimsTable">
                                <thead>
                                    <tr>
                                        <th>Claim #</th>
                                        <th>Vehicle</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Policy · Surveyor</th>
                                        <th>Job Card</th>
                                        <th style="text-align:right;">Claimed · Settled</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($claims as $c)
                                    <tr data-search="{{ strtolower($c->claim_number.' '.($c->vehicle->vehicle_no ?? '').' '.($c->damage_type ?? '')) }}"
                                        data-status="{{ strtolower(str_replace(' ', '-', $c->status)) }}"
                                        data-type="{{ strtolower($c->damage_type ?? '') }}">
                                        <td style="white-space:nowrap;">
                                            <a href="{{ route('fleet.insurance.detail', $c->id) }}" class="fw-semibold" style="color:#032671;font-size:11px;text-decoration:none;">{{ $c->claim_number }}</a>
                                        </td>
                                        <td>
                                            <span class="ins-reg">{{ $c->vehicle->vehicle_no ?? '—' }}</span>
                                            <div class="ins-model">{{ $c->vehicle->basicinfo->model ?? $c->vehicle->vehicletype->name ?? '' }}</div>
                                        </td>
                                        <td class="text-nowrap" style="color:#6c757d;">
                                            {{ $c->incident_date ? $c->incident_date->format('d M y') : '—' }}
                                        </td>
                                        <td>
                                            <span style="background:#e3ecff;color:#032671;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;">
                                                {{ $c->damage_type ?? '—' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="font-size:11px;font-weight:600;color:#032671;font-family:monospace;">{{ $c->policy_no ?? '—' }}</div>
                                            <div class="ins-model">{{ $c->insurer ?? '' }}</div>
                                        </td>
                                        <td>
                                            @if($c->linked_job_card)
                                                <a href="#" style="font-size:12px;color:#032671;font-weight:600;text-decoration:none;">{{ $c->linked_job_card }}</a>
                                            @else
                                                <span style="color:#adb5bd;font-size:12px;">—</span>
                                            @endif
                                        </td>
                                        <td style="text-align:right;">
                                            @if($c->repair_cost_estimate > 0)
                                                <div class="ins-amt-claimed">₹{{ number_format($c->repair_cost_estimate) }}</div>
                                            @else
                                                <div class="ins-amt-pending">—</div>
                                            @endif
                                            @if($c->amount_received)
                                                <div class="ins-amt-settled">✔ ₹{{ number_format($c->amount_received) }}</div>
                                            @elseif($c->excess_paid)
                                                <div class="ins-amt-settled">Excess ₹{{ number_format($c->excess_paid) }}</div>
                                            @else
                                                <div class="ins-amt-pending" style="font-size:10px;">pending</div>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'Filed'               => 'background:#e3ecff;color:#032671',
                                                    'Surveyor Assigned'   => 'background:#e3f4ff;color:#0061a8',
                                                    'Survey in Progress'  => 'background:#fff3e0;color:#c45a00',
                                                    'Insurer Approved'    => 'background:#e6f4ea;color:#1a7a36',
                                                    'Settlement Received' => 'background:#d4edda;color:#155724',
                                                    'Closed'              => 'background:#e9ecef;color:#495057',
                                                    'Rejected'            => 'background:#fde8e8;color:#c0392b',
                                                ];
                                                $sc = $statusColors[$c->status] ?? 'background:#e9ecef;color:#495057';
                                            @endphp
                                            <span style="{{ $sc }};font-size:10px;font-weight:700;padding:2px 9px;border-radius:10px;white-space:nowrap;">
                                                {{ $c->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown dot-dd">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="uil uil-ellipsis-h"></i>
                                                </span>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('fleet.insurance.detail', $c->id) }}"><i class="uil uil-eye me-2"></i>View Details</a></li>
                                                    @if(!in_array($c->status, ['Closed','Rejected','Settlement Received']))
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="openUpdateStatus({{ $c->id }}, '{{ $c->status }}'); return false;">
                                                            <i class="uil uil-clipboard-notes me-2"></i>Update Status
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if($c->status === 'Insurer Approved')
                                                    <li>
                                                        <a class="dropdown-item text-success" href="#"
                                                            onclick="openSettlement({{ $c->id }}, '{{ $c->settlement_mode }}'); return false;">
                                                            <i class="uil uil-money-bill me-2"></i>Record Settlement
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="uil uil-file-alt" style="font-size:32px;display:block;margin-bottom:8px;opacity:.3;"></i>
                                            No claims found. <a href="#" data-bs-toggle="modal" data-bs-target="#newClaimModal">File the first claim →</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-3 py-2 border-top d-flex align-items-center justify-content-between" style="background:#fafbfc;">
                            <small class="text-muted">{{ $claims->total() }} claim{{ $claims->total() !== 1 ? 's' : '' }}</small>
                            <div>{{ $claims->links() }}</div>
                        </div>
                    </div>

                </div>

                {{-- ── TAB 2: Policy Expiry Tracker (claimed vehicles only) ── --}}
                <div class="tab-pane fade" id="tabPolicy" role="tabpanel">

                    <div class="d-flex flex-wrap align-items-center gap-2 py-2 px-1 border-bottom mb-0" style="background:#fafbfc;">
                        <select class="form-select form-select-sm" style="width:160px;" id="polFltStatus">
                            <option value="">All Statuses</option>
                            <option value="expired">Expired</option>
                            <option value="expiring">Expiring ≤ 30 days</option>
                            <option value="ok">Valid (has active claim)</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" style="width:180px;" placeholder="Search vehicle / insurer" id="polFltSearch">
                        <button class="btn btn-outline-secondary btn-sm" id="polFltReset"><i class="uil uil-times"></i></button>
                        <span class="ms-auto text-muted" style="font-size:11px;">
                            <i class="uil uil-info-circle me-1"></i>
                            Showing only vehicles with active insurance claims
                        </span>
                        <span class="text-muted" style="font-size:11px;" id="polCount">{{ $expiringPolicies->count() }} vehicle{{ $expiringPolicies->count() !== 1 ? 's' : '' }}</span>
                    </div>

                    <div class="sc-table-card">
                        <div class="table-responsive">
                            <table class="table pol-table mb-0" id="policyTable">
                                <thead>
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Insurer</th>
                                        <th>Policy No.</th>
                                        <th>Expiry Date</th>
                                        <th>Days Left</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expiringPolicies as $p)
                                    <tr data-status="{{ $p['chip_status'] }}"
                                        data-search="{{ strtolower(($p['vehicle']->vehicle_no ?? '').' '.($p['insurer'] ?? '')) }}"
                                        data-vehicle-id="{{ $p['vehicle']->id }}">
                                        <td>
                                            <span class="ins-reg">{{ $p['vehicle']->vehicle_no ?? '—' }}</span>
                                        </td>
                                        <td style="color:#555;">{{ $p['insurer'] ?? '—' }}</td>
                                        <td style="font-size:11px;font-family:monospace;color:#555;">{{ $p['policy_no'] ?? '—' }}</td>
                                        <td class="{{ $p['chip_status'] === 'expired' ? 'pol-exp-critical' : ($p['chip_status'] === 'expiring' ? 'pol-exp-warning' : 'pol-exp-ok') }}">
                                            {{ $p['expiry']->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if($p['days_left'] < 0)
                                                <span style="color:#ea0027;font-weight:700;font-size:12px;">{{ abs($p['days_left']) }} days ago</span>
                                            @elseif($p['days_left'] <= 30)
                                                <span style="color:#e65100;font-weight:700;font-size:12px;">{{ $p['days_left'] }} days</span>
                                            @else
                                                <span style="color:#888;font-size:12px;">{{ $p['days_left'] }} days</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p['chip_status'] === 'expired')
                                                <span class="pol-chip-expired">Expired</span>
                                            @elseif($p['chip_status'] === 'expiring')
                                                <span class="pol-chip-expiring">Expiring Soon</span>
                                            @else
                                                <span class="pol-chip-ok">Valid</span>
                                            @endif
                                        </td>
                                        <td style="max-width:200px;">
                                            @if($p['note'])
                                                <span class="pol-note-text" style="font-size:11px;color:#444;">{{ $p['note'] }}</span>
                                                <a href="javascript:void(0)" class="ms-1 pol-edit-note"
                                                   data-vehicle-id="{{ $p['vehicle']->id }}"
                                                   data-note="{{ $p['note'] }}"
                                                   style="font-size:11px;color:#032671;">Edit</a>
                                            @else
                                                <a href="javascript:void(0)" class="pol-add-note"
                                                   data-vehicle-id="{{ $p['vehicle']->id }}"
                                                   style="font-size:11px;color:#9098b1;">+ Add note</a>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown dot-dd">
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-h"></i>
                                                </span>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('fleetdashboard.getVehicleDetails', $p['vehicle']->id) }}"><i class="uil uil-eye me-2"></i>View Vehicle</a></li>
                                                    <li><a class="dropdown-item pol-add-note" href="javascript:void(0)"
                                                           data-vehicle-id="{{ $p['vehicle']->id }}"
                                                           data-note="{{ $p['note'] ?? '' }}">
                                                           <i class="uil uil-notes me-2"></i>{{ $p['note'] ? 'Edit Note' : 'Add Note' }}</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)"
                                                           data-bs-toggle="modal" data-bs-target="#newClaimModal"
                                                           onclick="prefillClaimVehicleById({{ $p['vehicle']->id }})">
                                                           <i class="uil uil-file-plus-alt me-2"></i>File New Claim</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="uil uil-shield-check" style="font-size:28px;display:block;margin-bottom:6px;"></i>
                                            No active claims with insurance data found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-3 py-2 border-top" style="background:#fafbfc;">
                            <small class="text-muted" id="polCountFt">{{ $expiringPolicies->count() }} vehicle{{ $expiringPolicies->count() !== 1 ? 's' : '' }} with active claims</small>
                        </div>
                    </div>

                </div>

                {{-- ── Note Modal ── --}}
                <div class="modal fade" id="polNoteModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-header py-2">
                                <h6 class="modal-title" style="font-size:13px;"><i class="uil uil-notes me-2"></i>Insurance Note</h6>
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="noteVehicleId">
                                <textarea id="noteText" class="form-control form-control-sm" rows="4"
                                    style="resize:none;" placeholder="e.g. Renewal in progress, agent contacted…"></textarea>
                                <small class="text-muted" style="font-size:10px;">This note is visible only on the insurance page.</small>
                            </div>
                            <div class="modal-footer py-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm" id="saveNoteBtn">
                                    <i class="uil uil-save me-1"></i>Save Note
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- end tab-content --}}

            </div>{{-- /main-wrap --}}
    </div>{{-- /wrapper --}}
</div>{{-- /layout-wrapper --}}

{{-- ── New Claim Modal ── --}}
<div class="modal fade" id="newClaimModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-file-plus-alt me-2"></i>File New Insurance Claim</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">

                    {{-- Section: Incident --}}
                    <div class="col-12">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;border-bottom:1px solid #e4e7ef;padding-bottom:5px;margin-bottom:2px;">
                            Incident
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" id="claimVehicleId" name="vehicle_id">
                            <option value="">— Select vehicle —</option>
                            @foreach($vehicles ?? [] as $v)
                            <option value="{{ $v->id }}">{{ $v->vehicle_no }}{{ $v->basicinfo?->model ? ' — '.$v->basicinfo->model : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Incident Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" name="incidentDate">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Incident Location</label>
                        <input type="text" class="form-control form-control-sm" name="incidentLocation" placeholder="City / Highway / NH number…">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Damage Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" name="damageType">
                            <option value="">— Select —</option>
                            <option>Own Damage — Road Accident</option>
                            <option>Own Damage — Fire</option>
                            <option>Own Damage — Flood / Natural Calamity</option>
                            <option>Theft / Partial Theft</option>
                            <option>Third Party Property Damage</option>
                            <option>Third Party Injury / Death</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">FIR / Police Report #</label>
                        <input type="text" class="form-control form-control-sm" name="firNo" placeholder="If applicable">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Incident Description <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" rows="2" style="resize:none;" name="incidentDesc" placeholder="Brief description of what happened, damage observed…"></textarea>
                    </div>

                    {{-- Section: Settlement Type --}}
                    <div class="col-12 mt-1">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;border-bottom:1px solid #e4e7ef;padding-bottom:5px;margin-bottom:2px;">
                            Repair & Settlement
                        </div>
                    </div>

                    {{-- Settlement mode toggle --}}
                    <div class="col-12">
                        <label class="sc-form-label">Settlement Mode <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="settlementMode" id="modeReimburse" value="reimbursement" checked onchange="toggleSettlementMode(this.value)">
                                <label class="form-check-label" for="modeReimburse" style="font-size:13px;font-weight:600;">
                                    Reimbursement
                                    <span style="font-size:11px;color:#888;font-weight:400;display:block;">We pay repair cost → insurer pays us back</span>
                                </label>
                            </div>
                            <div class="form-check ms-4">
                                <input class="form-check-input" type="radio" name="settlementMode" id="modeCashless" value="cashless" onchange="toggleSettlementMode(this.value)">
                                <label class="form-check-label" for="modeCashless" style="font-size:13px;font-weight:600;">
                                    Cashless
                                    <span style="font-size:11px;color:#888;font-weight:400;display:block;">Workshop files with insurer → we only pay excess</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Workshop type radio — filters the dropdown below --}}
                    <div class="col-12">
                        <label class="sc-form-label">Workshop Type <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="workshop_type" id="wsOwn" value="Own" checked onchange="filterWorkshopByType('Own')">
                                <label class="form-check-label" for="wsOwn" style="font-size:13px;font-weight:600;">
                                    Own Workshop
                                    <span style="font-size:11px;color:#888;font-weight:400;display:block;">Vehicle sent to your company's own workshop</span>
                                </label>
                            </div>
                            <div class="form-check ms-4">
                                <input class="form-check-input" type="radio" name="workshop_type" id="wsExternal" value="External" onchange="filterWorkshopByType('External')">
                                <label class="form-check-label" for="wsExternal" style="font-size:13px;font-weight:600;">
                                    External Workshop / ASC
                                    <span style="font-size:11px;color:#888;font-weight:400;display:block;">Sent to empanelled 3rd party or brand ASC</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Workshop selection — always shown (user MUST pick a workshop per BA CIAA [A]) --}}
                    <div id="workshopSelectWrap" class="col-12">
                        <div style="background:#f8f9fc;border-radius:6px;padding:14px 14px 10px;border:1px solid #e4e7ef;">
                            <div style="font-size:11px;font-weight:700;color:#032671;text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;">
                                <i class="uil uil-store me-1"></i>Workshop
                            </div>
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="sc-form-label">Select Workshop <span class="text-danger">*</span></label>
                                    <select id="workshopSelect" name="workshop_id" class="form-select form-select-sm select2" style="width:100%;">
                                        <option value="">Search workshop by name, city, or type…</option>
                                        @php
                                            $ownWs     = $workshops->where('ownership','Own');
                                            $externalWs = $workshops->where('ownership','External');
                                        @endphp
                                        @if($ownWs->count())
                                        <optgroup label="Own Workshops">
                                            @foreach($ownWs as $ws)
                                            <option value="{{ $ws->id }}"
                                                data-contact="{{ $ws->manager_name }}"
                                                data-phone="{{ $ws->contact_phone }}"
                                                data-city="{{ $ws->city }}{{ $ws->state ? ', '.$ws->state : '' }}"
                                                data-ownership="Own">
                                                {{ $ws->name }}{{ $ws->city ? ' — '.$ws->city : '' }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endif
                                        @if($externalWs->count())
                                        <optgroup label="External Workshops / ASCs">
                                            @foreach($externalWs as $ws)
                                            <option value="{{ $ws->id }}"
                                                data-contact="{{ $ws->manager_name }}"
                                                data-phone="{{ $ws->contact_phone }}"
                                                data-city="{{ $ws->city }}{{ $ws->state ? ', '.$ws->state : '' }}"
                                                data-ownership="External">
                                                {{ $ws->name }}{{ $ws->city ? ' — '.$ws->city : '' }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endif
                                    </select>
                                    <small class="text-muted" style="font-size:11px;">
                                        Not listed?
                                        <a href="{{ route('ws.master.workshops') }}" target="_blank" style="color:#032671;">
                                            Add to Workshop Master
                                        </a>
                                    </small>
                                </div>

                                {{-- Auto-filled from selected workshop — read-only display --}}
                                <div class="col-md-4" id="scContactWrap" style="display:none;">
                                    <label class="sc-form-label">Contact Person</label>
                                    <input type="text" id="scContactPerson" class="form-control form-control-sm" readonly style="background:#fff;">
                                </div>
                                <div class="col-md-4" id="scPhoneWrap" style="display:none;">
                                    <label class="sc-form-label">Phone</label>
                                    <input type="text" id="scPhone" class="form-control form-control-sm" readonly style="background:#fff;">
                                </div>
                                <div class="col-md-4" id="scCityWrap" style="display:none;">
                                    <label class="sc-form-label">City / Location</label>
                                    <input type="text" id="scCity" class="form-control form-control-sm" readonly style="background:#fff;">
                                </div>

                                {{-- Cashless: claim ref from workshop/insurer --}}
                                <div id="cashlessScClaimRef" class="col-12" style="display:none;">
                                    <label class="sc-form-label">Insurer Claim Ref (raised by workshop)</label>
                                    <input type="text" name="extScClaimRef" class="form-control form-control-sm" placeholder="Claim ref number from workshop / insurer">
                                    <small class="text-muted" style="font-size:11px;">Workshop filed this cashless claim — enter the ref they shared with you</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Reimbursement: estimated repair cost --}}
                    <div id="reimburseCostField" class="col-md-6">
                        <label class="sc-form-label">Estimated Repair Cost (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="repairCost" placeholder="Workshop estimate">
                    </div>

                    {{-- Cashless: excess amount --}}
                    <div id="cashlessExcessField" class="col-md-6" style="display:none;">
                        <label class="sc-form-label">Compulsory Excess Payable (₹)</label>
                        <input type="number" class="form-control form-control-sm" name="excessAmount" placeholder="Amount we pay to SC / insurer">
                    </div>

                    <div class="col-md-6">
                        <label class="sc-form-label">Linked Job Card</label>
                        <input type="text" class="form-control form-control-sm" name="linkedJc" placeholder="JC number (if repair has started)">
                    </div>

                    {{-- Section: Claim Reference --}}
                    <div class="col-12 mt-1">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#032671;border-bottom:1px solid #e4e7ef;padding-bottom:5px;margin-bottom:2px;">
                            Insurer & Policy
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Insurer <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="insurer" placeholder="e.g. ICICI Lombard, New India…">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Policy Number</label>
                        <input type="text" class="form-control form-control-sm" name="policyNo" placeholder="Auto-filled from vehicle basicinfo">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Insurer Claim Ref #</label>
                        <input type="text" class="form-control form-control-sm" name="insurerClaimRef" placeholder="Ref given by insurer at filing">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Claim Filed Date</label>
                        <input type="date" class="form-control form-control-sm" name="claimFiledDate">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm" id="saveClaimBtn">
                    <i class="uil uil-save me-1"></i>Save Claim
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Update Status Modal ── --}}
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-clipboard-notes me-2"></i>Update Claim Status</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="updateStatusClaimId">
                <div class="mb-3">
                    <label class="sc-form-label">New Status <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="updateStatusValue">
                        <option value="Filed">Filed</option>
                        <option value="Surveyor Assigned">Surveyor Assigned</option>
                        <option value="Survey in Progress">Survey in Progress</option>
                        <option value="Insurer Approved">Insurer Approved</option>
                        <option value="Settlement Received">Settlement Received</option>
                        <option value="Closed">Closed</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="sc-form-label">Note (optional)</label>
                    <textarea class="form-control form-control-sm" id="updateStatusNote" rows="2" style="resize:none;" placeholder="Add a note about this status change…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm" id="saveStatusBtn">
                    <i class="uil uil-save me-1"></i>Update Status
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Record Settlement Modal ── --}}
<div class="modal fade" id="settlementModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-money-bill me-2"></i>Record Settlement</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="settlementClaimId">
                <input type="hidden" id="settlementModeHidden">
                <div id="settlementReimbFields">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="sc-form-label">Amount Approved (₹)</label>
                            <input type="number" class="form-control form-control-sm" id="sAmountApproved" placeholder="As approved by insurer">
                        </div>
                        <div class="col-md-6">
                            <label class="sc-form-label">Amount Received (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" id="sAmountReceived" placeholder="Actual amount received">
                        </div>
                    </div>
                </div>
                <div id="settlementCashlessFields" style="display:none;">
                    <div class="mb-2">
                        <label class="sc-form-label">Excess Paid (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" id="sExcessPaid" placeholder="Excess amount paid to SC">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="sc-form-label">Settlement Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm" id="sSettlementDate">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success btn-sm" id="saveSettlementBtn">
                    <i class="uil uil-check me-1"></i>Record Settlement
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Claim Detail Modal ── --}}
<div class="modal fade" id="claimDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-file-alt me-2"></i>Claim Details — INS-2026-0006</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2 mb-3">
                    @foreach([
                        ['Vehicle',      '<span class="ins-reg">TS09-AB-1234</span><div class="ins-model">Tata Prima 4928.S</div>'],
                        ['Claim Type',   '<span class="sc-ins-type-od">Own Damage</span>'],
                        ['Status',       '<span class="sc-ins-filed">Filed</span>'],
                        ['Incident Date','08-Apr-2026'],
                        ['Policy Ref',   '<span style="color:#032671;font-weight:700;font-family:monospace;">POL-TT-4421</span>'],
                        ['Job Card',     '<a href="#" style="color:#032671;font-weight:700;text-decoration:none;">WJC-2026-0024</a>'],
                        ['Claimed Amt',  '₹85,000'],
                        ['Surveyor',     'Rajesh Kumar'],
                        ['FIR #',        'FIR/NEL/2026/0412'],
                    ] as $dbox)
                    <div class="col-md-4">
                        <div class="sc-ins-detail-box">
                            <div class="sc-ins-detail-label">{{ $dbox[0] }}</div>
                            <div class="sc-ins-detail-val">{!! $dbox[1] !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="sc-ins-desc-box mb-3">
                    <div class="sc-ins-detail-label mb-1">Incident Description</div>
                    <div style="font-size:12px;color:#444;line-height:1.6;">Vehicle collided with a stationary truck at NH-48, Bangalore. Front bumper, bonnet, and radiator damaged. Driver safe. FIR filed at Nelamangala PS.</div>
                </div>
                <div class="sc-ins-detail-label mb-2">Claim Timeline</div>
                <div class="sc-activity-log">
                    @php $claimLog = [
                        ['navy','08-Apr-2026','Claim Filed','Filed by Ravi Verma. Documents: Claim Form, RC Copy, Photos.'],
                        ['amber','09-Apr-2026','Surveyor Assigned','Rajesh Kumar (New India Assurance) assigned for inspection.'],
                        ['teal','10-Apr-2026','Survey Visit','Surveyor visited workshop. Damage assessment in progress.'],
                    ]; @endphp
                    @foreach($claimLog as $log)
                    <div class="sc-log-item">
                        <div class="sc-log-left">
                            <div class="sc-log-dot sc-log-{{ $log[0] }}"></div>
                            <div class="sc-log-line"></div>
                        </div>
                        <div class="sc-log-body">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="sc-log-badge sc-log-badge-{{ $log[0] }}">{{ $log[2] }}</span>
                                <span class="sc-log-meta">{{ $log[1] }}</span>
                            </div>
                            <div style="font-size:12px;color:#444;">{{ $log[3] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#updateClaimModal" data-bs-dismiss="modal">Update Status</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Update Claim Modal ── --}}
<div class="modal fade" id="updateClaimModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-clipboard-notes me-2"></i>Update Claim Status</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">New Status <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option>Filed</option><option>Under Survey</option>
                            <option>Approved</option><option>Settled</option><option>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Surveyor Name</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Surveyor assigned">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Survey Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Assessed Amount (₹)</label>
                        <input type="number" class="form-control form-control-sm" placeholder="0">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Insurer Reference #</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Insurer's internal ref">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Notes</label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Update notes…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Save Update</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Settlement Modal ── --}}
<div class="modal fade" id="settlementModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-money-bill me-2"></i>Record Claim Settlement</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="sc-form-label">Settlement Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" placeholder="0">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Settlement Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Payment Mode</label>
                        <select class="form-select form-select-sm">
                            <option>NEFT / RTGS</option>
                            <option>Cheque</option>
                            <option>Direct to Workshop</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Transaction Ref / Cheque #</label>
                        <input type="text" class="form-control form-control-sm" placeholder="UTR / Cheque number">
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Remarks</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any deductions or shortfall notes…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm" style="background:#10863f;color:#fff;border-color:#10863f;">Mark Settled</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

/* ── New Claim Modal — Settlement & Workshop type toggles ── */
function toggleSettlementMode(mode) {
    if (mode === 'cashless') {
        $('#cashlessExcessField').show();
        $('#reimburseCostField').hide();
        // If external SC is selected, show the claim ref field
        if ($('input[name="workshopType"]:checked').val() === 'external') {
            $('#cashlessScClaimRef').show();
        }
    } else {
        $('#cashlessExcessField').hide();
        $('#reimburseCostField').show();
        $('#cashlessScClaimRef').hide();
    }
}

// Workshop type is now auto-determined by the workshop selected — no radio toggle needed.

// Reset modal on open
$('#newClaimModal').on('show.bs.modal', function () {
    $('input[name="settlementMode"][value="reimbursement"]').prop('checked', true);
    $('input[name="workshop_type"][value="Own"]').prop('checked', true);
    $('#cashlessExcessField').hide();
    $('#reimburseCostField').show();
    $('#cashlessScClaimRef').hide();
    $('#workshopSelect').val(null).trigger('change');
    filterWorkshopByType('Own');
    $('#scContactWrap, #scPhoneWrap, #scCityWrap').hide();
});

// Init Select2 on workshop dropdown
$('#workshopSelect').select2({
    dropdownParent: $('#newClaimModal'),
    placeholder: 'Search workshop by name or city…',
    allowClear: true,
    width: '100%'
});

// Filter workshop dropdown options when Own / External radio changes
function filterWorkshopByType(type) {
    // Reset dropdown first
    $('#workshopSelect').val(null).trigger('change');
    $('#scContactWrap, #scPhoneWrap, #scCityWrap').hide();

    // Show only relevant optgroup options
    $('#workshopSelect option[data-ownership]').each(function () {
        $(this).prop('disabled', $(this).data('ownership') !== type);
    });

    // Show/hide cashless claim-ref based on workshop type + settlement mode
    if (type === 'External' && $('input[name="settlementMode"]:checked').val() === 'cashless') {
        $('#cashlessScClaimRef').show();
    } else {
        $('#cashlessScClaimRef').hide();
    }
}

// Auto-fill contact/phone/city when a workshop is selected
$('#workshopSelect').on('change', function () {
    var sel = $(this).find(':selected');
    var contact = sel.data('contact') || '';
    var phone   = sel.data('phone')   || '';
    var city    = sel.data('city')    || '';
    if ($(this).val()) {
        $('#scContactPerson').val(contact);
        $('#scPhone').val(phone);
        $('#scCity').val(city);
        $('#scContactWrap, #scPhoneWrap, #scCityWrap').show();
    } else {
        $('#scContactWrap, #scPhoneWrap, #scCityWrap').hide();
    }
});

$(function () {

    var CSRF = '{{ csrf_token() }}';

    /* ── Save New Claim ── */
    $('#saveClaimBtn').on('click', function () {
        var data = {
            _token:                 CSRF,
            vehicle_id:             $('#claimVehicleId').val(),
            incident_date:          $('[name="incidentDate"]').val(),
            incident_location:      $('[name="incidentLocation"]').val(),
            damage_type:            $('[name="damageType"]').val(),
            fir_no:                 $('[name="firNo"]').val(),
            incident_description:   $('[name="incidentDesc"]').val(),
            settlement_mode:        $('input[name="settlementMode"]:checked').val() === 'reimbursement' ? 'Reimbursement' : 'Cashless',
            workshop_type:          $('input[name="workshop_type"]:checked').val() || 'Own',
            workshop_id:            $('#workshopSelect').val(),
            external_sc_claim_ref:  $('[name="extScClaimRef"]').val(),
            repair_cost_estimate:   $('[name="repairCost"]').val(),
            excess_payable:         $('[name="excessAmount"]').val(),
            linked_job_card:        $('[name="linkedJc"]').val(),
            insurer:                $('[name="insurer"]').val(),
            policy_no:              $('[name="policyNo"]').val(),
            insurer_claim_ref:      $('[name="insurerClaimRef"]').val(),
            claim_filed_date:       $('[name="claimFiledDate"]').val(),
        };

        if (!data.vehicle_id || !data.incident_date || !data.damage_type || !data.insurer) {
            Swal.fire({ icon: 'warning', title: 'Required fields missing', text: 'Please fill Vehicle, Incident Date, Damage Type, and Insurer.', confirmButtonColor: '#032671' });
            return;
        }

        var btn = $(this).prop('disabled', true).text('Saving…');
        $.post('{{ route("fleet.insurance.store") }}', data)
            .done(function (res) {
                $('#newClaimModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Claim Filed',
                    text: res.claim_number + ' created successfully.',
                    confirmButtonColor: '#032671',
                }).then(function () {
                    window.location.href = res.redirect;
                });
            })
            .fail(function (xhr) {
                var msg = xhr.responseJSON?.message || 'Something went wrong.';
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            })
            .always(function () { btn.prop('disabled', false).html('<i class="uil uil-save me-1"></i>Save Claim'); });
    });

    /* ── Open Update Status modal ── */
    window.openUpdateStatus = function (id, currentStatus) {
        $('#updateStatusClaimId').val(id);
        $('#updateStatusValue').val(currentStatus);
        $('#updateStatusNote').val('');
        var modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        modal.show();
    };

    /* ── Save Status Update ── */
    $('#saveStatusBtn').on('click', function () {
        var id  = $('#updateStatusClaimId').val();
        var btn = $(this).prop('disabled', true).text('Saving…');
        $.post('/fleet/insurance/' + id + '/update-status', {
            _token: CSRF,
            status: $('#updateStatusValue').val(),
            note:   $('#updateStatusNote').val(),
        })
        .done(function (res) {
            $('#updateStatusModal').modal('hide');
            Swal.fire({ icon: 'success', title: 'Status Updated', text: res.message, timer: 2000, showConfirmButton: false });
            setTimeout(function () { location.reload(); }, 2000);
        })
        .fail(function (xhr) {
            Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Failed to update.' });
        })
        .always(function () { btn.prop('disabled', false).html('<i class="uil uil-save me-1"></i>Update Status'); });
    });

    /* ── Open Settlement modal ── */
    window.openSettlement = function (id, mode) {
        $('#settlementClaimId').val(id);
        $('#settlementModeHidden').val(mode);
        $('#sAmountApproved, #sAmountReceived, #sExcessPaid, #sSettlementDate').val('');
        if (mode === 'Cashless') {
            $('#settlementReimbFields').hide();
            $('#settlementCashlessFields').show();
        } else {
            $('#settlementReimbFields').show();
            $('#settlementCashlessFields').hide();
        }
        var modal = new bootstrap.Modal(document.getElementById('settlementModal'));
        modal.show();
    };

    /* ── Save Settlement ── */
    $('#saveSettlementBtn').on('click', function () {
        var id   = $('#settlementClaimId').val();
        var mode = $('#settlementModeHidden').val();
        var btn  = $(this).prop('disabled', true).text('Saving…');
        $.post('/fleet/insurance/' + id + '/settlement', {
            _token:           CSRF,
            settlement_mode:  mode,
            amount_approved:  $('#sAmountApproved').val(),
            amount_received:  $('#sAmountReceived').val(),
            excess_paid:      $('#sExcessPaid').val(),
            settlement_date:  $('#sSettlementDate').val(),
        })
        .done(function (res) {
            $('#settlementModal').modal('hide');
            Swal.fire({ icon: 'success', title: 'Settlement Recorded', text: res.message, timer: 2500, showConfirmButton: false });
            setTimeout(function () { location.reload(); }, 2500);
        })
        .fail(function (xhr) {
            Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Failed to record.' });
        })
        .always(function () { btn.prop('disabled', false).html('<i class="uil uil-check me-1"></i>Record Settlement'); });
    });

    /* ── Vehicle dropdown for new claim (use real $vehicles) ── */
    // Build from server-side select — see modal

    /* ── Claims filter ── */
    function filterClaims() {
        var st  = $('#fltStatus').val().toLowerCase();
        var ty  = $('#fltType').val().toLowerCase();
        var srch = $('#fltSearch').val().toLowerCase();
        var count = 0;
        $('#claimsTable tbody tr').each(function () {
            var $tr = $(this);
            var ok = true;
            if (st   && ($tr.data('status') || '').toLowerCase().indexOf(st) === -1) ok = false;
            if (ty   && ($tr.data('type') || '').toLowerCase().indexOf(ty)   === -1) ok = false;
            if (srch && ($tr.data('search') || '').indexOf(srch)             === -1) ok = false;
            $tr.toggle(ok);
            if (ok) count++;
        });
    }
    $('#fltStatus,#fltType').on('change', filterClaims);
    $('#fltSearch').on('keyup', filterClaims);
    $('#fltReset').on('click', function () {
        $('#fltStatus,#fltType').val('');
        $('#fltSearch').val('');
        filterClaims();
    });

    /* ── Policy filter ── */
    function filterPolicies() {
        var st   = $('#polFltStatus').val();
        var srch = $('#polFltSearch').val().toLowerCase();
        $('#policyTable tbody tr').each(function () {
            var $tr = $(this);
            var ok = true;
            if (st   && $tr.data('status') !== st)              ok = false;
            if (srch && ($tr.data('search') || '').indexOf(srch) === -1) ok = false;
            $tr.toggle(ok);
        });
    }
    $('#polFltStatus').on('change', filterPolicies);
    $('#polFltSearch').on('keyup', filterPolicies);
    $('#polFltReset').on('click', function () {
        $('#polFltStatus').val('');
        $('#polFltSearch').val('');
        filterPolicies();
    });

    /* ── Add / Edit Note ── */
    function openNoteModal(vehicleId, existingNote) {
        $('#noteVehicleId').val(vehicleId);
        $('#noteText').val(existingNote || '');
        $('#polNoteModal').modal('show');
    }

    // "Add note" / "Edit" links in the table
    $(document).on('click', '.pol-add-note, .pol-edit-note', function () {
        var vid  = $(this).data('vehicle-id');
        var note = $(this).data('note') || '';
        openNoteModal(vid, note);
    });

    // Save note via AJAX
    $('#saveNoteBtn').on('click', function () {
        var vehicleId = $('#noteVehicleId').val();
        var note      = $('#noteText').val().trim();
        if (!note) { Swal.fire('Required', 'Please enter a note.', 'warning'); return; }

        $.ajax({
            url: '/sc/maintenance/insurance/vehicle/' + vehicleId + '/note',
            type: 'POST',
            data: { note: note, _token: '{{ csrf_token() }}' },
            success: function (res) {
                if (res.success) {
                    $('#polNoteModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Note saved', timer: 1500, showConfirmButton: false });
                    // Update the note cell inline
                    var $row = $('#policyTable tbody tr[data-vehicle-id="' + vehicleId + '"]');
                    $row.find('.pol-add-note').replaceWith(
                        '<span class="pol-note-text" style="font-size:11px;color:#444;">' + note + '</span>' +
                        ' <a href="javascript:void(0)" class="ms-1 pol-edit-note" data-vehicle-id="' + vehicleId + '" data-note="' + note + '" style="font-size:11px;color:#032671;">Edit</a>'
                    );
                    $row.find('.pol-edit-note').data('note', note);
                } else {
                    Swal.fire('Error', res.message || 'Could not save.', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Server error. Please try again.', 'error');
            }
        });
    });

});
</script>
@endsection
