@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/insurance-claim-detail.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">
            <div class="ins-detail-wrap">

                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb sc-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('fleetdashboard.index') }}">Fleet</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('fleet.insurance.index') }}">Insurance Claims</a></li>
                        <li class="breadcrumb-item active">CLM-2024-0048</li>
                    </ol>
                </nav>

                {{-- Claim Header --}}
                <div class="claim-header-card">
                    <div>
                        <div>
                            <span class="claim-no">CLM-2024-0048</span>
                            <span class="claim-type-badge">Own Damage</span>
                        </div>
                        <div class="claim-meta mt-2">
                            <strong>Vehicle:</strong>
                            <span class="ins-reg ms-1 me-2">TS09 AB1234</span>
                            Tata Prima 4928.S
                            &nbsp;·&nbsp;
                            <strong>Insurer:</strong> ICICI Lombard
                            &nbsp;·&nbsp;
                            <strong>Insurer Ref:</strong> ICICI/2024/DEC/48291
                        </div>
                        <div class="claim-meta mt-1">
                            <strong>Incident:</strong> 08 Dec 2024
                            &nbsp;·&nbsp;
                            <strong>Filed:</strong> 09 Dec 2024
                            &nbsp;·&nbsp;
                            <strong>Job Card:</strong>
                            <a href="#" style="color:#032671;">JC-HYD-2024-1182</a>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-2">
                        <span class="claim-status-badge badge-survey">
                            <i class="uil uil-user-check"></i> Survey in Progress
                        </span>
                        {{-- Settlement mode chip --}}
                        <span style="background:#e3ecff;color:#032671;font-size:10px;font-weight:700;padding:2px 10px;border-radius:10px;letter-spacing:.3px;">
                            REIMBURSEMENT
                        </span>
                        {{-- For Cashless, swap above chip to: --}}
                        {{-- <span style="background:#e6f4ea;color:#10863f;font-size:10px;font-weight:700;padding:2px 10px;border-radius:10px;letter-spacing:.3px;">CASHLESS</span> --}}
                        <div style="font-size:11px;color:#888;">Last updated: 15 Dec 2024</div>
                    </div>
                </div>

                {{-- ═══ REIMBURSEMENT PIPELINE (own or external WS — we file & recover) ═══ --}}
                {{-- Switch to cashless pipeline below when claim_type = cashless --}}
                <div class="claim-pipeline" id="pipelineReimbursement">
                    <div class="pip-step done">
                        <i class="uil uil-file-alt pip-icon"></i>
                        Claim Filed
                        <span class="pip-date">09 Dec 2024</span>
                    </div>
                    <div class="pip-step done">
                        <i class="uil uil-user-check pip-icon"></i>
                        Surveyor Assigned
                        <span class="pip-date">10 Dec 2024</span>
                    </div>
                    <div class="pip-step active">
                        <i class="uil uil-clipboard-alt pip-icon"></i>
                        Survey in Progress
                        <span class="pip-date">12 Dec 2024</span>
                    </div>
                    <div class="pip-step">
                        <i class="uil uil-check-circle pip-icon"></i>
                        Insurer Approved
                        <span class="pip-date">—</span>
                    </div>
                    <div class="pip-step">
                        <i class="uil uil-money-bill pip-icon"></i>
                        Settlement Received
                        <span class="pip-date">—</span>
                    </div>
                </div>

                {{-- ═══ CASHLESS PIPELINE (external SC files — we only pay excess) ═══ --}}
                {{-- Uncomment and use when claim_type = cashless --}}
                {{--
                <div class="claim-pipeline" id="pipelineCashless">
                    <div class="pip-step done">
                        <i class="uil uil-bell pip-icon"></i>
                        We Were Notified
                        <span class="pip-date">08 Dec 2024</span>
                    </div>
                    <div class="pip-step done">
                        <i class="uil uil-store pip-icon"></i>
                        External SC Filed Claim
                        <span class="pip-date">09 Dec 2024</span>
                    </div>
                    <div class="pip-step active">
                        <i class="uil uil-clipboard-alt pip-icon"></i>
                        Survey in Progress
                        <span class="pip-date">10 Dec 2024</span>
                    </div>
                    <div class="pip-step">
                        <i class="uil uil-check-circle pip-icon"></i>
                        Insurer Approved
                        <span class="pip-date">—</span>
                    </div>
                    <div class="pip-step">
                        <i class="uil uil-money-withdraw pip-icon"></i>
                        Excess Paid by Us
                        <span class="pip-date">—</span>
                    </div>
                    <div class="pip-step">
                        <i class="uil uil-truck pip-icon"></i>
                        Vehicle Returned
                        <span class="pip-date">—</span>
                    </div>
                </div>
                --}}

                {{-- ═══ REIMBURSEMENT Financial Bar ═══ --}}
                <div class="fin-bar" id="finBarReimbursement">
                    <div class="fin-cell repair">
                        <div class="fin-label">Repair Cost</div>
                        <div class="fin-amount">₹2,28,500</div>
                        <div class="fin-pending">Workshop estimate</div>
                    </div>
                    <div class="fin-cell claimed">
                        <div class="fin-label">We Claimed</div>
                        <div class="fin-amount">₹2,40,000</div>
                        <div class="fin-pending">As submitted to insurer</div>
                    </div>
                    <div class="fin-cell approved">
                        <div class="fin-label">Insurer Approved</div>
                        <div class="fin-amount">₹1,85,000</div>
                        <div class="fin-pending">Surveyor assessment</div>
                    </div>
                    <div class="fin-cell received">
                        <div class="fin-label">We Received</div>
                        <div class="fin-amount">₹0</div>
                        <div class="fin-pending">Awaiting settlement</div>
                    </div>
                </div>

                {{-- ═══ CASHLESS Financial Bar ═══ --}}
                {{-- Uncomment and use instead of above when claim_type = cashless --}}
                {{--
                <div class="fin-bar" id="finBarCashless">
                    <div class="fin-cell repair">
                        <div class="fin-label">Repair Cost (SC Estimate)</div>
                        <div class="fin-amount">₹1,60,000</div>
                        <div class="fin-pending">External SC estimate</div>
                    </div>
                    <div class="fin-cell approved">
                        <div class="fin-label">Insurer Approved</div>
                        <div class="fin-amount">₹1,35,000</div>
                        <div class="fin-pending">Paid directly to SC</div>
                    </div>
                    <div class="fin-cell" style="background:#fff8e1;">
                        <div class="fin-label" style="color:#888;">Excess We Pay</div>
                        <div class="fin-amount" style="color:#e65100;">₹25,000</div>
                        <div class="fin-pending">Compulsory excess</div>
                    </div>
                    <div class="fin-cell" style="background:#f0faf3;">
                        <div class="fin-label" style="color:#888;">Excess Paid</div>
                        <div class="fin-amount" style="color:#10863f;">₹0</div>
                        <div class="fin-pending">Not yet paid</div>
                    </div>
                </div>
                --}}

                {{-- Action Bar --}}
                <div class="ins-action-bar">
                    <button class="btn btn-ins-primary" data-bs-toggle="modal" data-bs-target="#modalChaseLog">
                        <i class="uil uil-phone-alt me-1"></i>Log Follow-Up
                    </button>
                    <button class="btn btn-ins-success" data-bs-toggle="modal" data-bs-target="#modalSettlement">
                        <i class="uil uil-money-bill me-1"></i>Record Settlement Received
                    </button>
                    <button class="btn btn-ins-outline" data-bs-toggle="modal" data-bs-target="#modalUpdateStatus">
                        <i class="uil uil-edit-alt me-1"></i>Update Status
                    </button>
                    <button class="btn btn-ins-outline">
                        <i class="uil uil-print me-1"></i>Print
                    </button>
                    <button class="btn btn-ins-danger ms-auto">
                        <i class="uil uil-times me-1"></i>Close Claim
                    </button>
                </div>

                <div class="row g-3">

                    {{-- LEFT: Incident + Surveyor --}}
                    <div class="col-lg-7">

                        {{-- Incident Summary --}}
                        <div class="ins-sec-card">
                            <div class="ins-sec-head">
                                <i class="uil uil-exclamation-triangle"></i> Incident Summary
                            </div>
                            <div class="ins-sec-body">
                                <div class="kv-row mb-3">
                                    <div class="kv-item">
                                        <div class="kv-label">Incident Date & Time</div>
                                        <div class="kv-value">08 Dec 2024, ~06:30 AM</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Location</div>
                                        <div class="kv-value">NH-44, Near Shadnagar Toll, Telangana</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Driver</div>
                                        <div class="kv-value">Suresh Nayak</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Third Party Involved</div>
                                        <div class="kv-value">No</div>
                                    </div>
                                </div>
                                <div class="remark-box">
                                    Vehicle lost control on wet road near Shadnagar toll (fog). Front bumper, radiator grille, headlamp assembly, and front chassis crossmember damaged. No injuries. Vehicle towed to WS-HYD.
                                </div>
                            </div>
                        </div>

                        {{-- Surveyor --}}
                        <div class="ins-sec-card">
                            <div class="ins-sec-head">
                                <i class="uil uil-user-check"></i> Surveyor
                            </div>
                            <div class="ins-sec-body">
                                <div class="surv-card">
                                    <div class="surv-avatar"><i class="uil uil-user"></i></div>
                                    <div>
                                        <div class="surv-name">Mr. Abhishek Reddy</div>
                                        <div class="surv-meta">AR Loss Assessors Pvt Ltd · Assigned by ICICI Lombard</div>
                                        <div class="surv-phone"><i class="uil uil-phone-alt me-1" style="font-size:12px;"></i>+91 98400 77310</div>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <div class="kv-label">Survey Date</div>
                                        <div class="kv-value">12 Dec 2024</div>
                                        <div class="mt-2">
                                            <span style="background:#fff3e0;color:#e65100;font-size:10px;font-weight:700;padding:2px 9px;border-radius:10px;">Report Pending</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="kv-label mb-1">Surveyor's Assessment Note</div>
                                    <div class="remark-box">
                                        Physical inspection done 12 Dec. Damage to bumper, radiator, headlamp, and crossmember confirmed. Depreciation applied on headlamp assembly (40%). Final report expected by 20 Dec 2024.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Policy Info (minimal — just what's needed for the claim) --}}
                        <div class="ins-sec-card">
                            <div class="ins-sec-head">
                                <i class="uil uil-shield-check"></i> Policy Reference
                            </div>
                            <div class="ins-sec-body">
                                <div class="kv-row">
                                    <div class="kv-item">
                                        <div class="kv-label">Policy No.</div>
                                        <div class="kv-value" style="font-family:monospace;font-size:12px;">ICICILOM/CV/2025/TS09AB1234</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Coverage Type</div>
                                        <div class="kv-value">Comprehensive</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Policy Valid Until</div>
                                        <div class="kv-value">14 Apr 2027</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Compulsory Excess</div>
                                        <div class="kv-value">₹25,000 (borne by us)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Repair & Workshop ── --}}
                        <div class="ins-sec-card">
                            <div class="ins-sec-head">
                                <i class="uil uil-wrench"></i> Repair & Workshop
                            </div>
                            <div class="ins-sec-body">

                                {{-- Repair type indicator --}}
                                <div class="d-flex gap-2 mb-3">
                                    <div style="background:#e3ecff;border-radius:6px;padding:6px 14px;display:inline-flex;align-items:center;gap:7px;">
                                        <i class="uil uil-home-alt" style="color:#032671;font-size:15px;"></i>
                                        <span style="font-size:12px;font-weight:700;color:#032671;">Own Workshop (WS-HYD)</span>
                                    </div>
                                    <div style="font-size:11px;color:#888;align-self:center;">Reimbursement claim — insurer pays us after repair</div>
                                </div>

                                <div class="kv-row mb-3">
                                    <div class="kv-item">
                                        <div class="kv-label">Workshop</div>
                                        <div class="kv-value">WS-HYD — SR Logistics Workshop, Hyderabad</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Repair Started</div>
                                        <div class="kv-value">15 Dec 2024 <span style="font-size:11px;color:#888;">(post-survey)</span></div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Estimated Completion</div>
                                        <div class="kv-value">22 Dec 2024</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Repair Status</div>
                                        <div class="kv-value"><span style="background:#fff3e0;color:#e65100;font-size:10px;font-weight:700;padding:2px 9px;border-radius:10px;">In Progress</span></div>
                                    </div>
                                </div>

                                {{-- What if it were external WS — shown as alternate example below, hidden for now --}}
                                {{-- For External SC claims, show: SC Name, Address, Contact, Cashless/Reimbursement --}}

                                <div class="kv-row">
                                    <div class="kv-item">
                                        <div class="kv-label">Claim Settlement Mode</div>
                                        <div class="kv-value">Reimbursement</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Workshop Estimate (incl. GST)</div>
                                        <div class="kv-value">₹2,28,500</div>
                                    </div>
                                    <div class="kv-item">
                                        <div class="kv-label">Final Repair Invoice</div>
                                        <div class="kv-value"><span style="background:#fff3e0;color:#e65100;font-size:10px;font-weight:700;padding:2px 9px;border-radius:10px;">Pending — repair in progress</span></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>{{-- /col-lg-7 --}}

                    {{-- RIGHT: Chase Log + Timeline --}}
                    <div class="col-lg-5">

                        {{-- Follow-Up / Chase Log --}}
                        <div class="ins-sec-card">
                            <div class="ins-sec-head">
                                <i class="uil uil-phone-alt"></i> Follow-Up Log
                                <button class="btn btn-ins-outline btn-sm ms-auto" style="font-size:11px;padding:2px 10px;" data-bs-toggle="modal" data-bs-target="#modalChaseLog">
                                    + Add
                                </button>
                            </div>
                            <div class="ins-sec-body">
                                <div class="timeline">

                                    <div class="tl-item">
                                        <div class="tl-dot active"></div>
                                        <div class="tl-date">15 Dec 2024, 11:30 AM</div>
                                        <div class="tl-event">Called ICICI Lombard — Policy Helpdesk</div>
                                        <div class="tl-note">Surveyor report expected by 20 Dec. Asked to follow up if not received. Spoke with: Priya (ref: TKT-84210).</div>
                                    </div>

                                    <div class="tl-item">
                                        <div class="tl-dot done"></div>
                                        <div class="tl-date">12 Dec 2024, 10:00 AM</div>
                                        <div class="tl-event">Surveyor visited WS-HYD</div>
                                        <div class="tl-note">Inspection done. Abhishek Reddy reviewed damage. Asked for original repair estimate copy — provided.</div>
                                    </div>

                                    <div class="tl-item">
                                        <div class="tl-dot done"></div>
                                        <div class="tl-date">10 Dec 2024, 2:15 PM</div>
                                        <div class="tl-event">ICICI confirmed surveyor assignment</div>
                                        <div class="tl-note">AR Loss Assessors assigned. Survey scheduled for 12 Dec.</div>
                                    </div>

                                    <div class="tl-item">
                                        <div class="tl-dot done"></div>
                                        <div class="tl-date">09 Dec 2024, 9:45 AM</div>
                                        <div class="tl-event">Claim filed with ICICI Lombard</div>
                                        <div class="tl-note">Claim registered online. Insurer ref: ICICI/2024/DEC/48291.</div>
                                    </div>

                                    <div class="tl-item">
                                        <div class="tl-dot done"></div>
                                        <div class="tl-date">08 Dec 2024, 6:30 AM</div>
                                        <div class="tl-event">Incident reported by driver</div>
                                        <div class="tl-note">Suresh Nayak called in. Vehicle towed to WS-HYD.</div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>{{-- /col-lg-5 --}}
                </div>{{-- /row --}}

            </div>{{-- /ins-detail-wrap --}}
        </div>
    </div>
</div>

{{-- ── Modal: Log Follow-Up ─────────────────────────────────────── --}}
<div class="modal fade" id="modalChaseLog" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-phone-alt me-2"></i>Log Follow-Up</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Contact Method</label>
                        <select class="form-select form-select-sm">
                            <option>Phone Call</option>
                            <option>Email</option>
                            <option>In Person</option>
                            <option>WhatsApp</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Spoke With / Contact Name</label>
                        <input type="text" class="form-control form-control-sm" placeholder="e.g. Priya — ICICI Helpdesk">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">What was discussed / outcome <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Summary of the follow-up…" style="resize:none;"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Next Follow-Up Date</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" onclick="Swal.fire({icon:'success',title:'Follow-up Logged',timer:1500,showConfirmButton:false});$('#modalChaseLog').modal('hide');">
                    <i class="uil uil-save me-1"></i>Save
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Modal: Record Settlement Received ───────────────────────── --}}
<div class="modal fade" id="modalSettlement" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-money-bill me-2"></i>Record Settlement Received</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Date Received <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Amount Received (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" placeholder="0.00">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Payment Mode</label>
                        <select class="form-select form-select-sm">
                            <option>NEFT</option>
                            <option>RTGS</option>
                            <option>Cheque</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">UTR / Cheque No.</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Transaction ref">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea class="form-control form-control-sm" rows="2" placeholder="Any remarks on the settlement…" style="resize:none;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" onclick="Swal.fire({icon:'success',title:'Settlement Recorded',timer:1500,showConfirmButton:false});$('#modalSettlement').modal('hide');">
                    <i class="uil uil-save me-1"></i>Save Settlement
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Modal: Update Status ─────────────────────────────────────── --}}
<div class="modal fade" id="modalUpdateStatus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="uil uil-edit-alt me-2"></i>Update Claim Status</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Status <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm">
                        <option>Filed — Awaiting Surveyor</option>
                        <option selected>Survey in Progress</option>
                        <option>Survey Done — Awaiting Insurer Approval</option>
                        <option>Insurer Approved — Awaiting Settlement</option>
                        <option>Partially Settled</option>
                        <option>Fully Settled</option>
                        <option>Rejected</option>
                        <option>Closed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Remarks</label>
                    <textarea class="form-control form-control-sm" rows="3" placeholder="What changed?" style="resize:none;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-theme btn-sm" onclick="Swal.fire({icon:'success',title:'Status Updated',timer:1500,showConfirmButton:false});$('#modalUpdateStatus').modal('hide');">
                    <i class="uil uil-save me-1"></i>Save
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
