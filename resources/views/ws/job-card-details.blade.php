@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/job-card-details.css?v=1.0') }}" rel="stylesheet">
<link href="{{ asset('css/Workshop/job-card-details.css?v=1.0') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item"><a href="{{ route('ws.workshop.job-list') }}">Job Cards</a></li>
                    <li class="breadcrumb-item active">JC-2026-0048</li>
                </ol>
            </nav>

            {{-- Job Card Header --}}
            <div class="sc-jcd-header d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span class="sc-jcd-num-badge">JC-2026-0048 <i class="uil uil-copy ms-1" id="copyJcNum" title="Copy" style="cursor:pointer;font-size:13px;"></i></span>
                    <span class="sc-jcd-reg">KA-05-AB-1234</span>
                    <span class="badge sc-status-inprogress">In Progress</span>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Change Status
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">→ Open</a></li>
                            <li><a class="dropdown-item" href="#">→ Pending Parts</a></li>
                            <li><a class="dropdown-item" href="#">→ Quality Check</a></li>
                            <li><a class="dropdown-item" href="#">→ Completed</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm"><i class="uil uil-print me-1"></i>Print</button>
                    <button class="btn btn-outline-danger btn-sm" disabled><i class="uil uil-lock me-1"></i>Close Job</button>
                    <a href="{{ route('ws.workshop.job-list') }}" class="btn btn-link btn-sm text-muted">← Back to Job Cards</a>
                </div>
            </div>

            {{-- ─── Tab Container ─── --}}
            <div class="sc-tab-container">

            {{-- Tab Navigation --}}
            <div class="sc-tab-bar" id="jcdTabBar">
                <a class="sc-tab active" href="#" data-target="#tab-overview">Overview</a>
                <a class="sc-tab" href="#" data-target="#tab-labour">Labour</a>
                <a class="sc-tab" href="#" data-target="#tab-parts">Parts &amp; Consumables</a>
                <a class="sc-tab" href="#" data-target="#tab-checklist">Inspection</a>
                <a class="sc-tab" href="#" data-target="#tab-photos">Photos</a>
                <a class="sc-tab" href="#" data-target="#tab-billing">Billing</a>
                <a class="sc-tab" href="#" data-target="#tab-log">Activity Log</a>
                <a class="sc-tab" href="#" data-target="#tab-notes">Notes</a>
            </div>

            {{-- Tab Panel Wrapper --}}
            <div class="sc-tab-panel-wrap">

            {{-- ─── Tab Panels ─── --}}

            {{-- TAB 1: OVERVIEW --}}
            <div class="sc-tab-panel" id="tab-overview">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="sc-info-box">
                            <div class="sc-info-box-title"><i class="uil uil-truck me-2"></i>Vehicle</div>
                            <div class="sc-info-row"><span class="sc-info-label">Reg No.</span><span class="sc-info-val fw-semibold text-navy">KA-05-AB-1234</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Make</span><span class="sc-info-val">Tata</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Model</span><span class="sc-info-val">Prima 4928</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Service Type</span><span class="sc-info-val"><span class="badge sc-badge-workshop">Workshop</span></span></div>
                            <div class="sc-info-row"><span class="sc-info-label">VIN</span><span class="sc-info-val text-muted" style="font-size:11px;">MAT443261NVM12345</span></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sc-info-box">
                            <div class="sc-info-box-title"><i class="uil uil-file-alt me-2"></i>Service Request</div>
                            <div class="sc-info-row"><span class="sc-info-label">SR Number</span><span class="sc-info-val fw-semibold">SR-2026-0101</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Customer</span><span class="sc-info-val">Nationwide Transport</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Contact</span><span class="sc-info-val">+91 98765 43210</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Description</span><span class="sc-info-val">General service + brake pads replacement</span></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sc-info-box">
                            <div class="sc-info-box-title"><i class="uil uil-ticket me-2"></i>Gate Token</div>
                            <div class="sc-info-row"><span class="sc-info-label">Token #</span><span class="sc-info-val fw-semibold">GT-2026-0112</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">KM In</span><span class="sc-info-val">1,24,580 KM</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Driver</span><span class="sc-info-val">Raju Singh</span></div>
                            <div class="sc-info-row"><span class="sc-info-label">Date In</span><span class="sc-info-val">11-Apr-2026 09:15</span></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="sc-info-box">
                            <div class="sc-info-box-title"><i class="uil uil-user-circle me-2"></i>Assigned Technician</div>
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <div class="sc-tech-avatar">RK</div>
                                <div>
                                    <div class="fw-semibold">Ramesh Kumar</div>
                                    <div class="text-muted" style="font-size:12px;">Engine &amp; Brakes Specialist</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="sc-info-box">
                            <div class="sc-info-box-title"><i class="uil uil-calendar-alt me-2"></i>Estimated Delivery</div>
                            <div class="row g-2 mt-1">
                                <div class="col-8"><input type="date" class="form-control form-control-sm" value="2026-04-13"></div>
                                <div class="col-4"><button class="btn sc-btn-navy btn-sm w-100">Save</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sc-info-box">
                            <div class="sc-info-box-title"><i class="uil uil-history me-2"></i>Status Flow</div>
                            <div class="sc-status-flow mt-2">
                                <div class="sc-flow-step sc-flow-done"><div class="sc-flow-dot"></div><div class="sc-flow-label">Created</div><div class="sc-flow-date">11-Apr 09:30</div></div>
                                <div class="sc-flow-line sc-flow-line-done"></div>
                                <div class="sc-flow-step sc-flow-active"><div class="sc-flow-dot"></div><div class="sc-flow-label">In Progress</div><div class="sc-flow-date">11-Apr 10:15</div></div>
                                <div class="sc-flow-line"></div>
                                <div class="sc-flow-step sc-flow-pending"><div class="sc-flow-dot"></div><div class="sc-flow-label">Quality Check</div><div class="sc-flow-date">—</div></div>
                                <div class="sc-flow-line"></div>
                                <div class="sc-flow-step sc-flow-pending"><div class="sc-flow-dot"></div><div class="sc-flow-label">Completed</div><div class="sc-flow-date">—</div></div>
                                <div class="sc-flow-line"></div>
                                <div class="sc-flow-step sc-flow-pending"><div class="sc-flow-dot"></div><div class="sc-flow-label">Billed</div><div class="sc-flow-date">—</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: LABOUR --}}
            <div class="sc-tab-panel d-none" id="tab-labour">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 fw-semibold">Labour Items</h6>
                        <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#addLabourModal"><i class="uil uil-plus me-1"></i> Add Labour Item</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table sc-table mb-0">
                            <thead><tr><th>Description</th><th>Technician</th><th class="text-end">Hours</th><th class="text-end">Rate (₹)</th><th class="text-end">Amount (₹)</th><th class="text-center">Actions</th></tr></thead>
                            <tbody>
                                <tr>
                                    <td>General Service</td><td>Ramesh Kumar</td><td class="text-end">3.00 hrs</td><td class="text-end">₹ 500.00</td>
                                    <td class="text-end fw-semibold">₹ 1,500.00</td>
                                    <td class="text-center"><button class="sc-action-btn" title="Delete"><i class="uil uil-trash-alt text-danger"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Brake Pad Replacement</td><td>Ramesh Kumar</td><td class="text-end">1.50 hrs</td><td class="text-end">₹ 600.00</td>
                                    <td class="text-end fw-semibold">₹ 900.00</td>
                                    <td class="text-center"><button class="sc-action-btn" title="Delete"><i class="uil uil-trash-alt text-danger"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Oil Filter Change</td><td>Suresh Mehta</td><td class="text-end">0.50 hrs</td><td class="text-end">₹ 400.00</td>
                                    <td class="text-end fw-semibold">₹ 200.00</td>
                                    <td class="text-center"><button class="sc-action-btn" title="Delete"><i class="uil uil-trash-alt text-danger"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="sc-subtotal-row"><td colspan="4" class="text-end fw-semibold">Labour Subtotal</td><td class="text-end fw-bold text-navy">₹ 2,600.00</td><td></td></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TAB 3: PARTS --}}
            <div class="sc-tab-panel d-none" id="tab-parts">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 fw-semibold">Parts &amp; Consumables</h6>
                        <button class="btn sc-btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#addPartModal"><i class="uil uil-plus me-1"></i> Add Part/Consumable</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table sc-table mb-0">
                            <thead><tr><th>Item Name</th><th>Brand</th><th class="text-end">Qty</th><th>Unit</th><th class="text-end">Rate (₹)</th><th class="text-end">Amount (₹)</th><th class="text-center">Actions</th></tr></thead>
                            <tbody>
                                <tr>
                                    <td>Engine Oil 20W-50</td><td>Castrol</td><td class="text-end">6.00</td><td>ltr</td><td class="text-end">₹ 280.00</td>
                                    <td class="text-end fw-semibold">₹ 1,680.00</td>
                                    <td class="text-center"><button class="sc-action-btn" title="Delete"><i class="uil uil-trash-alt text-danger"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Brake Pads (Front)</td><td>Bosch</td><td class="text-end">1.00</td><td>set</td><td class="text-end">₹ 1,200.00</td>
                                    <td class="text-end fw-semibold">₹ 1,200.00</td>
                                    <td class="text-center"><button class="sc-action-btn" title="Delete"><i class="uil uil-trash-alt text-danger"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Oil Filter</td><td>Tata Genuine</td><td class="text-end">1.00</td><td>pcs</td><td class="text-end">₹ 220.00</td>
                                    <td class="text-end fw-semibold">₹ 220.00</td>
                                    <td class="text-center"><button class="sc-action-btn" title="Delete"><i class="uil uil-trash-alt text-danger"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="sc-subtotal-row"><td colspan="5" class="text-end fw-semibold">Parts Subtotal</td><td class="text-end fw-bold text-navy">₹ 3,100.00</td><td></td></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TAB 4: INSPECTION CHECKLIST --}}
            <div class="sc-tab-panel d-none" id="tab-checklist">
                @php
                    $checklistItems = [
                        'Exterior — Paint condition','Exterior — Glass condition','Exterior — Bumper/trim',
                        'Exterior — Lights functional','Interior — Upholstery condition','Interior — Dashboard',
                        'Interior — Steering','Engine — Condition','Engine — Oil level',
                        'Tyres — Condition','Brakes — Responsiveness','Fluids — No leaks'
                    ];
                    $preCheck = ['OK','OK','OK','Fail','OK','OK','OK','OK','OK','OK','OK','OK'];
                @endphp
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="sc-card">
                            <h6 class="mb-3 text-muted">Pre-Inspection <span class="badge bg-secondary ms-1" style="font-size:10px;">From Gate Token — Read Only</span></h6>
                            <table class="table sc-checklist-table mb-0">
                                <tbody>
                                    @foreach($checklistItems as $i => $item)
                                    <tr>
                                        <td style="font-size:13px;">{{ $i+1 }}. {{ $item }}</td>
                                        <td class="text-end">
                                            @if($preCheck[$i] === 'OK')
                                                <span class="badge bg-success" style="font-size:11px;">OK</span>
                                            @else
                                                <span class="badge bg-danger" style="font-size:11px;">Fail</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="sc-card">
                            <h6 class="mb-3">Post-Work Inspection</h6>
                            <table class="table sc-checklist-table mb-0">
                                <tbody>
                                    @foreach($checklistItems as $i => $item)
                                    <tr>
                                        <td style="font-size:13px;">{{ $i+1 }}. {{ $item }}</td>
                                        <td class="text-end">
                                            <div class="sc-toggle-group">
                                                <button class="sc-toggle-btn sc-toggle-ok" data-val="ok">OK</button>
                                                <button class="sc-toggle-btn sc-toggle-fail" data-val="fail">Fail</button>
                                                <button class="sc-toggle-btn sc-toggle-na active-na" data-val="na">N/A</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3 text-end">
                                <button class="btn sc-btn-navy btn-sm">Save Inspection</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 5: PHOTOS --}}
            <div class="sc-tab-panel d-none" id="tab-photos">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="sc-card">
                            <h6 class="mb-3 text-muted">Photos — Before Work <span class="badge bg-secondary ms-1" style="font-size:10px;">From Gate Token</span></h6>
                            <div class="sc-photo-grid">
                                <div class="sc-photo-thumb sc-photo-placeholder"><i class="uil uil-image"></i></div>
                                <div class="sc-photo-thumb sc-photo-placeholder"><i class="uil uil-image"></i></div>
                                <div class="sc-photo-thumb sc-photo-placeholder"><i class="uil uil-image"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sc-card">
                            <h6 class="mb-3">Photos — During / After Work</h6>
                            <label for="photoInput" class="sc-upload-zone" id="photoUploadZone">
                                <i class="uil uil-cloud-upload" style="font-size:36px;color:#adb5bd;"></i>
                                <p class="mb-1 mt-2" style="font-size:13px;">Drag &amp; drop photos here, or <span class="text-navy fw-semibold">click to browse</span></p>
                                <small class="text-muted">JPG, PNG — Max 10 MB per file</small>
                            </label>
                            <input type="file" id="photoInput" name="photos[]" accept="image/jpeg,image/png" multiple style="position:absolute;opacity:0;width:0;height:0;overflow:hidden;">
                            <div class="sc-photo-grid mt-3" id="photoPreviewGrid"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 6: BILLING --}}
            <div class="sc-tab-panel d-none" id="tab-billing">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="sc-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Billing Summary</h6>
                                <span class="badge sc-status-inprogress">Draft</span>
                            </div>
                            <div class="sc-bill-row"><span>Labour Subtotal</span><span>₹ 2,600.00</span></div>
                            <div class="sc-bill-row"><span>Parts Subtotal</span><span>₹ 3,100.00</span></div>
                            <div class="sc-bill-divider"></div>
                            <div class="sc-bill-row"><span class="fw-semibold">Taxable Amount</span><span class="fw-semibold">₹ 5,700.00</span></div>
                            <div class="sc-bill-row"><span>GST @ 18%</span><span>₹ 1,026.00</span></div>
                            <div class="sc-bill-divider"></div>
                            <div class="sc-bill-row sc-bill-total"><span>Grand Total</span><span>₹ 6,726.00</span></div>
                            <div class="mt-3 text-end">
                                <button class="btn btn-outline-secondary btn-sm"><i class="uil uil-print me-1"></i>Print Invoice</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 7: ACTIVITY LOG --}}
            <div class="sc-tab-panel d-none" id="tab-log">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0 fw-semibold">Activity Log</h6>
                        <small class="text-muted">All events for JC-2026-0048</small>
                    </div>
                    <div class="sc-activity-log">

                        <div class="sc-log-item">
                            <div class="sc-log-left">
                                <div class="sc-log-dot sc-log-navy"></div>
                                <div class="sc-log-line"></div>
                            </div>
                            <div class="sc-log-body">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <span class="badge sc-log-badge-navy">Job Created</span>
                                    <span class="sc-log-meta">System · 11-Apr-2026 09:30 AM</span>
                                </div>
                                <div class="sc-log-desc">Job card <strong>JC-2026-0048</strong> created from service request <strong>SR-2026-0101</strong>. Vehicle <strong>KA-05-AB-1234</strong> checked in via gate token GT-2026-0112.</div>
                            </div>
                        </div>

                        <div class="sc-log-item">
                            <div class="sc-log-left">
                                <div class="sc-log-dot sc-log-amber"></div>
                                <div class="sc-log-line"></div>
                            </div>
                            <div class="sc-log-body">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <span class="badge sc-log-badge-amber">Status Changed</span>
                                    <span class="sc-log-meta">Ramesh Kumar · 11-Apr-2026 10:15 AM</span>
                                </div>
                                <div class="sc-log-desc">Status changed: <strong>Open → In Progress</strong>. Work started on vehicle.</div>
                            </div>
                        </div>

                        <div class="sc-log-item">
                            <div class="sc-log-left">
                                <div class="sc-log-dot sc-log-teal"></div>
                                <div class="sc-log-line"></div>
                            </div>
                            <div class="sc-log-body">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <span class="badge sc-log-badge-teal">Labour Added</span>
                                    <span class="sc-log-meta">Ramesh Kumar · 11-Apr-2026 10:45 AM</span>
                                </div>
                                <div class="sc-log-desc">Labour item added: <strong>General Service</strong> — 3.0 hrs @ ₹500/hr = ₹1,500.</div>
                            </div>
                        </div>

                        <div class="sc-log-item">
                            <div class="sc-log-left">
                                <div class="sc-log-dot sc-log-teal"></div>
                                <div class="sc-log-line"></div>
                            </div>
                            <div class="sc-log-body">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <span class="badge sc-log-badge-teal">Parts Added</span>
                                    <span class="sc-log-meta">Ramesh Kumar · 11-Apr-2026 11:10 AM</span>
                                </div>
                                <div class="sc-log-desc">Part issued from inventory: <strong>Engine Oil 20W-50 (Castrol)</strong> — 6 ltr × ₹280 = ₹1,680. Stock deducted from Workshop Bay.</div>
                            </div>
                        </div>

                        <div class="sc-log-item">
                            <div class="sc-log-left">
                                <div class="sc-log-dot sc-log-teal"></div>
                                <div class="sc-log-line"></div>
                            </div>
                            <div class="sc-log-body">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <span class="badge sc-log-badge-teal">Parts Added</span>
                                    <span class="sc-log-meta">Ramesh Kumar · 11-Apr-2026 11:30 AM</span>
                                </div>
                                <div class="sc-log-desc">Part issued from inventory: <strong>Brake Pads Front — Bosch</strong> — 1 set × ₹1,200 = ₹1,200. Stock deducted from Warehouse.</div>
                            </div>
                        </div>

                        <div class="sc-log-item">
                            <div class="sc-log-left">
                                <div class="sc-log-dot sc-log-blue"></div>
                                {{-- last item — no line --}}
                            </div>
                            <div class="sc-log-body">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <span class="badge sc-log-badge-blue">Note Added</span>
                                    <span class="sc-log-meta">SC Manager · 11-Apr-2026 12:05 PM</span>
                                </div>
                                <div class="sc-log-desc">Internal note added: "Vehicle has history of oil leakage near engine gasket. Check thoroughly during service."</div>
                            </div>
                        </div>

                    </div>{{-- /.sc-activity-log --}}

                    {{-- Add Manual Log Entry --}}
                    <div class="sc-log-add-entry mt-4 pt-3 border-top">
                        <div class="d-flex gap-2 align-items-start">
                            <div class="sc-tech-avatar" style="flex-shrink:0;width:32px;height:32px;font-size:11px;">SC</div>
                            <div class="flex-grow-1">
                                <textarea class="form-control form-control-sm" rows="2" placeholder="Add a note or update to this job card…"></textarea>
                                <div class="text-end mt-2">
                                    <button class="btn sc-btn-navy btn-sm">Post Note</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 8: NOTES --}}
            <div class="sc-tab-panel d-none" id="tab-notes">
                <div>
                    <h6 class="mb-3 fw-semibold">Internal Notes</h6>
                    <textarea class="form-control" rows="8" placeholder="Add internal notes about this job card…">Vehicle has history of oil leakage near engine gasket. Check thoroughly during service.</textarea>
                    <div class="mt-2 text-end">
                        <button class="btn sc-btn-navy btn-sm">Save Notes</button>
                    </div>
                </div>
            </div>{{-- /.sc-tab-panel (notes) --}}

            </div>{{-- /.sc-tab-panel-wrap --}}
            </div>{{-- /.sc-tab-container --}}

        </div>{{-- /.main-wrap --}}
    </div>{{-- /.wrapper --}}

</div>{{-- /.layout-wrapper --}}

{{-- Add Labour Modal --}}
<div class="modal fade" id="addLabourModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Add Labour Item</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12"><label class="sc-form-label">Description <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm" placeholder="e.g. Engine Diagnostics"></div>
                    <div class="col-12"><label class="sc-form-label">Technician <span class="text-danger">*</span></label><select class="form-select form-select-sm select2-tech"><option>Ramesh Kumar</option><option>Suresh Mehta</option><option>Manoj Patil</option></select></div>
                    <div class="col-6"><label class="sc-form-label">Hours <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" id="labourHours" min="0.25" step="0.25" placeholder="0.00"></div>
                    <div class="col-6"><label class="sc-form-label">Rate (₹) <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" id="labourRate" min="0" step="0.01" placeholder="0.00"></div>
                    <div class="col-12"><label class="sc-form-label">Amount (₹)</label><input type="text" class="form-control form-control-sm bg-light" id="labourAmount" readonly placeholder="Auto-calculated"></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn sc-btn-navy btn-sm">Add</button></div>
        </div>
    </div>
</div>

{{-- Add Part Modal --}}
<div class="modal fade" id="addPartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Add Part / Consumable</h6><button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12"><label class="sc-form-label">Item <span class="text-danger">*</span></label><select class="form-select form-select-sm select2-inventory"><option>Engine Oil 20W-50 (Castrol)</option><option>Brake Pads Front Set (Bosch)</option><option>Oil Filter (Tata Genuine)</option></select></div>
                    <div class="col-6"><label class="sc-form-label">Brand</label><input type="text" class="form-control form-control-sm bg-light" readonly value="Castrol"></div>
                    <div class="col-3"><label class="sc-form-label">Qty <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" id="partQty" min="0.01" step="0.01"></div>
                    <div class="col-3"><label class="sc-form-label">Unit <span class="text-danger">*</span></label><select class="form-select form-select-sm"><option>pcs</option><option>ltr</option><option>set</option><option>pair</option></select></div>
                    <div class="col-6"><label class="sc-form-label">Rate (₹) <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm" id="partRate" min="0" step="0.01"></div>
                    <div class="col-6"><label class="sc-form-label">Amount (₹)</label><input type="text" class="form-control form-control-sm bg-light" id="partAmount" readonly></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn sc-btn-navy btn-sm">Add</button></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {

    // ── Custom tab switching ──────────────────────────────
    $('#jcdTabBar .sc-tab').on('click', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('#jcdTabBar .sc-tab').removeClass('active');
        $(this).addClass('active');
        $('.sc-tab-panel').addClass('d-none');
        $(target).removeClass('d-none');
    });

    // ── Copy JC number ────────────────────────────────────
    $('#copyJcNum').on('click', function() {
        navigator.clipboard.writeText('JC-2026-0048').then(function() {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Copied!', showConfirmButton: false, timer: 1500 });
        });
    });

    // ── Select2 in modals ─────────────────────────────────
    $(document).on('shown.bs.modal', '#addLabourModal', function() {
        $(this).find('.select2-tech').select2({ width: '100%', dropdownParent: $(this) });
    });
    $(document).on('shown.bs.modal', '#addPartModal', function() {
        $(this).find('.select2-inventory').select2({ width: '100%', dropdownParent: $(this) });
    });

    // ── Labour amount auto-calc ───────────────────────────
    $('#labourHours, #labourRate').on('input', function() {
        var hrs  = parseFloat($('#labourHours').val()) || 0;
        var rate = parseFloat($('#labourRate').val())  || 0;
        $('#labourAmount').val('₹ ' + (hrs * rate).toFixed(2));
    });

    // ── Part amount auto-calc ─────────────────────────────
    $('#partQty, #partRate').on('input', function() {
        var qty  = parseFloat($('#partQty').val())  || 0;
        var rate = parseFloat($('#partRate').val()) || 0;
        $('#partAmount').val('₹ ' + (qty * rate).toFixed(2));
    });

    // ── Post-inspection toggles ───────────────────────────
    $(document).on('click', '.sc-toggle-btn', function() {
        $(this).closest('.sc-toggle-group').find('.sc-toggle-btn').removeClass('active-ok active-fail active-na');
        var val = $(this).data('val');
        $(this).addClass('active-' + val);
    });

    // ── Photo upload (label-based — no JS click needed) ───
    $('#photoInput').on('change', function() {
        var files = this.files;
        var grid  = $('#photoPreviewGrid');
        grid.empty();
        if (!files.length) return;
        if (files.length > 10) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'Max 10 photos allowed', showConfirmButton: false, timer: 2000 });
            return;
        }
        $.each(files, function(i, file) {
            if (!file.type.match('image.*')) return;
            if (file.size > 10 * 1024 * 1024) {
                Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: file.name + ' exceeds 10 MB', showConfirmButton: false, timer: 2000 });
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                var thumb = $('<div class="sc-photo-thumb sc-photo-preview" style="position:relative;">' +
                    '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:5px;">' +
                    '<button class="sc-photo-remove" data-index="' + i + '" title="Remove">×</button>' +
                '</div>');
                grid.append(thumb);
            };
            reader.readAsDataURL(file);
        });
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: files.length + ' photo(s) ready to upload', showConfirmButton: false, timer: 2000 });
    });

    // ── Drag & drop visual feedback ───────────────────────
    $('#photoUploadZone')
        .on('dragover', function(e) { e.preventDefault(); $(this).addClass('drag-over'); })
        .on('dragleave drop', function(e) { e.preventDefault(); $(this).removeClass('drag-over'); });

});
</script>
@endsection
