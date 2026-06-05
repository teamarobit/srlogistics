{{-- Trip show-v2 — vehAlloc tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Vehicle Allocation</h5>
                                </div>
                                <div class="td2-pane-body">
                                    <div id="td2AllocSelectView">

                                    {{-- Part A: Suggested Vehicles Accordion --}}
                                    <div class="td2-section">
                                        <div class="accordion td2-veh-accordion" id="td2SuggestedVeh">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header mb-2">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#td2VehCollapse">
                                                        <i class="uil uil-bolt-alt td2-veh-acc-icon"></i>
                                                        <span class="td2-veh-acc-title">Select from Suggested Vehicles</span>
                                                        <span class="td2-veh-acc-count">3</span>
                                                        <span class="td2-veh-acc-pill">Recommended</span>
                                                    </button>
                                                </h2>
                                                <div id="td2VehCollapse" class="accordion-collapse collapse show">
                                                    <div class="accordion-body p-0">

                                                        {{-- Vehicle Card 1 --}}
                                                        <div class="td2-veh-card-wrap">
                                                            <input type="radio" name="td2VehSelect" id="td2Veh1" class="td2-veh-radio">
                                                            <label for="td2Veh1" class="td2-veh-card td2-veh-card-green td2-open-map">
                                                                <div class="td2-vc-header">
                                                                    <div class="td2-vc-num">WB-12-AB-1237</div>                                                                </div>
                                                                <div class="td2-vc-grid">
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Name</span>
                                                                        <span class="td2-vc-val">Ashok Ray</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Number</span>
                                                                        <span class="td2-vc-val">+91 8879402641</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">About Driver</span>
                                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-green"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">10 Mo</span></span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Status</span>
                                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Availability</span>
                                                                        <span class="td2-vc-val">Yes</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Live Location</span>
                                                                        <span class="td2-vc-val">Kolkata</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                                        <span class="td2-vc-val">5th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>5 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>7 Trips</span></div>"></i></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Associated Since</span>
                                                                        <span class="td2-vc-val">10 Years 5 Months</span>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                        {{-- Vehicle Card 2 --}}
                                                        <div class="td2-veh-card-wrap">
                                                            <input type="radio" name="td2VehSelect" id="td2Veh2" class="td2-veh-radio">
                                                            <label for="td2Veh2" class="td2-veh-card td2-veh-card-red td2-open-map">
                                                                <div class="td2-vc-header">
                                                                    <div class="td2-vc-num">WB-34-CD-5678</div>                                                                </div>
                                                                <div class="td2-vc-grid">
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Name</span>
                                                                        <span class="td2-vc-val">Ranjit Das</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Number</span>
                                                                        <span class="td2-vc-val">+91 9432101234</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">About Driver</span>
                                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-yellow"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">4 Mo</span></span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Status</span>
                                                                        <span class="td2-vc-val"><span class="td2-veh-status-onway">Not Empty ✗</span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Availability</span>
                                                                        <span class="td2-vc-val">On the Way (2 days)</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Live Location</span>
                                                                        <span class="td2-vc-val">Mumbai</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                                        <span class="td2-vc-val">3rd <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>8 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>4 Trips</span></div>"></i></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Associated Since</span>
                                                                        <span class="td2-vc-val">7 Years 2 Months</span>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                        {{-- Vehicle Card 3 --}}
                                                        <div class="td2-veh-card-wrap">
                                                            <input type="radio" name="td2VehSelect" id="td2Veh3" class="td2-veh-radio">
                                                            <label for="td2Veh3" class="td2-veh-card td2-veh-card-yellow td2-open-map">
                                                                <div class="td2-vc-header">
                                                                    <div class="td2-vc-num">WB-56-EF-9012</div>                                                                </div>
                                                                <div class="td2-vc-grid">
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Name</span>
                                                                        <span class="td2-vc-val">Manoj Kumar</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Driver Number</span>
                                                                        <span class="td2-vc-val">+91 7654321098</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">About Driver</span>
                                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-green"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">14 Mo</span></span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Status</span>
                                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Availability</span>
                                                                        <span class="td2-vc-val">Yes</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Live Location</span>
                                                                        <span class="td2-vc-val">Durgapur</span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                                        <span class="td2-vc-val">8th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>3 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>9 Trips</span></div>"></i></span>
                                                                    </div>
                                                                    <div class="td2-vc-item">
                                                                        <span class="td2-vc-label">Associated Since</span>
                                                                        <span class="td2-vc-val">4 Years 9 Months</span>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- OR Divider --}}
                                    <div class="td2-or-divider"><span>OR</span></div>

                                    {{-- Part C: Add / Allocate Vehicle Form --}}
                                    <div class="td2-section td2-alloc-section">

                                        {{-- Section header --}}
                                        <div class="td2-alloc-head">
                                            <span class="td2-alloc-head-icon"><i class="uil uil-truck"></i></span>
                                            <div class="td2-alloc-head-text">
                                                <p class="td2-alloc-head-title">Add / Allocate Vehicle</p>
                                                <p class="td2-alloc-head-sub">Pick a vehicle from your own fleet or assign an external vendor vehicle to this trip.</p>
                                            </div>
                                        </div>

                                        {{-- Vehicle source toggle --}}
                                        <div class="td2-alloc-source mb-3">
                                            <span class="td2-alloc-source-label">Select any of these below</span>
                                            <div class="td2-veh-type-toggle">
                                                <input type="radio" name="td2VehType" id="td2OwnVeh" value="Own" class="td2-vtype-radio td2-own-veh" checked>
                                                <label for="td2OwnVeh" class="td2-vtype-label">Own Vehicle</label>
                                                <input type="radio" name="td2VehType" id="td2ExtVeh" value="External" class="td2-vtype-radio td2-ext-veh">
                                                <label for="td2ExtVeh" class="td2-vtype-label">External / Vendor</label>
                                            </div>
                                        </div>

                                        {{-- If Own Vehicle --}}
                                        <div class="td2-if-own td2-alloc-body">
                                            <div class="mb-3">
                                                <label class="form-label">Select Vehicle</label>
                                                <select class="form-select td2-own-veh-select" id="td2OwnVehSelect">
                                                    <option value="">Select vehicle...</option>
                                                    <option>WB-12-AB-1237</option>
                                                    <option>WB-34-CD-5678</option>
                                                    <option>WB-56-EF-9012</option>
                                                </select>
                                            </div>

                                            {{-- VAHAN Details collapsible --}}
                                            <div class="td2-vahan-wrap">
                                                <button class="td2-vahan-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#td2VahanDetails">
                                                    <i class="uil uil-file-info-alt"></i> VAHAN Details <i class="uil uil-angle-down ms-auto"></i>
                                                </button>
                                                <div id="td2VahanDetails" class="collapse">
                                                    <div class="td2-vahan-list">
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Owner Name</span>
                                                            <span class="td2-vahan-val">Rajesh Kumar</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Address</span>
                                                            <span class="td2-vahan-val">12, Park Street, Kolkata - 700016</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Status</span>
                                                            <span class="td2-vahan-val">Active</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Registration Date</span>
                                                            <span class="td2-vahan-val">15/03/2018</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">Fitness Certificate Expiry</span>
                                                            <span class="td2-vahan-val">14/03/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Insurance Expiry</span>
                                                            <span class="td2-vahan-val">22/07/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">Tax Expiry</span>
                                                            <span class="td2-vahan-val">31/03/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">Permit Expiry</span>
                                                            <span class="td2-vahan-val">20/11/2025</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">PUCC Expiry</span>
                                                            <span class="td2-vahan-val">10/06/2026</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-exclamation-circle td2-vahan-stat td2-vahan-stat-alert"></i>
                                                            <span class="td2-vahan-key">National Permit Expiry</span>
                                                            <span class="td2-vahan-val">20/11/2025</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Permit Type</span>
                                                            <span class="td2-vahan-val">National</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">PUCC Number</span>
                                                            <span class="td2-vahan-val">PUC2024WB1237</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Permit Number</span>
                                                            <span class="td2-vahan-val">WB/NP/2022/001237</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Insurer</span>
                                                            <span class="td2-vahan-val">New India Assurance</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Insurance Number</span>
                                                            <span class="td2-vahan-val">NIA/2024/098765</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Financier</span>
                                                            <span class="td2-vahan-val">SBI Bank</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Class</span>
                                                            <span class="td2-vahan-val">Medium Goods Vehicle</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Body Type</span>
                                                            <span class="td2-vahan-val">Closed Body</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Fuel Type</span>
                                                            <span class="td2-vahan-val">Diesel</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Chassis Number</span>
                                                            <span class="td2-vahan-val">MAT451351MDE12345</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Engine Number</span>
                                                            <span class="td2-vahan-val">4HK1-WB12345</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Manufacturer</span>
                                                            <span class="td2-vahan-val">Tata Motors</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Norms Type</span>
                                                            <span class="td2-vahan-val">BS-VI</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Model</span>
                                                            <span class="td2-vahan-val">LPT 1618</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">GVW</span>
                                                            <span class="td2-vahan-val">16180 KG</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">Wheelbase</span>
                                                            <span class="td2-vahan-val">4200 MM</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">FASTag ID</span>
                                                            <span class="td2-vahan-val">WB12AB1237FT</span>
                                                        </div>
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-check-circle td2-vahan-stat td2-vahan-stat-ok"></i>
                                                            <span class="td2-vahan-key">TID</span>
                                                            <span class="td2-vahan-val">TID20240012370</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Selected vehicle summary — same card style as Suggested Vehicles --}}
                                            <div class="td2-veh-card td2-veh-card-green td2-open-map mt-3">
                                                <div class="td2-vc-header">
                                                    <div class="td2-vc-num">WB-12-AB-1237</div>
                                                </div>
                                                <div class="td2-vc-grid">
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Name</span>
                                                        <span class="td2-vc-val">Ashok Ray</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Number</span>
                                                        <span class="td2-vc-val">+91 8879402641</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">About Driver</span>
                                                        <span class="td2-vc-val"><span class="td2-bhv-wrap"><span class="td2-bhv-dot td2-bhv-green"></span><span class="td2-bhv-label">Behaviour</span><span class="td2-bhv-exp">10 Mo</span></span></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Status</span>
                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Availability</span>
                                                        <span class="td2-vc-val">Yes</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Live Location</span>
                                                        <span class="td2-vc-val">Kolkata</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                        <span class="td2-vc-val">5th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>5 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>7 Trips</span></div>"></i></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Associated Since</span>
                                                        <span class="td2-vc-val">10 Years 5 Months</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- If External Vehicle --}}
                                        <div class="td2-if-ext td2-alloc-body">
                                            <div class="mb-3">
                                                <label class="form-label">Vendor</label>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <select class="form-select" id="td2ExtVendorSelect">
                                                        <option value="">Select vendor...</option>
                                                        <option>ABC Logistics</option>
                                                        <option>XYZ Transport</option>
                                                        <option>MNC Logistics</option>
                                                    </select>
                                                    <a href="{{ route('contact.vehiclevendor.create') }}" target="_blank" rel="noopener" class="text-nowrap small">+ Add Vendor</a>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Vehicle</label>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <select class="form-select" id="td2ExtVehicleSelect">
                                                        <option value="">Select vehicle...</option>
                                                        <option>WB-99-ZZ-0001</option>
                                                        <option>DL-01-XX-5050</option>
                                                    </select>
                                                    <a href="{{ route('vehiclemanagement.create') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm text-nowrap">+ Add Vehicle</a>
                                                </div>
                                            </div>

                                            {{-- VAHAN Details collapsible (external) --}}
                                            <div class="td2-vahan-wrap mb-3">
                                                <button class="td2-vahan-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#td2VahanDetailsExt">
                                                    <i class="uil uil-file-info-alt"></i> VAHAN Details <i class="uil uil-angle-down ms-auto"></i>
                                                </button>
                                                <div id="td2VahanDetailsExt" class="collapse">
                                                    <div class="td2-vahan-list">
                                                        @php
                                                            $extVahanFields = [
                                                                'Owner Name', 'Address', 'Status', 'Registration Date',
                                                                'Fitness Certificate Expiry', 'Insurance Expiry', 'Tax Expiry',
                                                                'Permit Expiry', 'PUCC Expiry', 'National Permit Expiry',
                                                                'Permit Type', 'PUCC Number', 'Permit Number', 'Insurer',
                                                                'Insurance Number', 'Financier', 'Class', 'Body Type',
                                                                'Fuel Type', 'Chassis Number', 'Engine Number', 'Manufacturer',
                                                                'Norms Type', 'Model', 'GVW', 'Wheelbase', 'FASTag ID', 'TID',
                                                            ];
                                                        @endphp
                                                        @foreach ($extVahanFields as $extVahanField)
                                                        <div class="td2-vahan-row">
                                                            <i class="uil uil-minus-circle td2-vahan-stat td2-vahan-stat-na"></i>
                                                            <span class="td2-vahan-key">{{ $extVahanField }}</span>
                                                            <span class="td2-vahan-val td2-vahan-val-empty">—</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Selected vehicle summary — same card style (RAG-coloured border); driver fields blank for external --}}
                                            {{-- data-vd-view="vahan": open Vehicle Details with VAHAN view instead of the map --}}
                                            <div class="td2-veh-card td2-veh-card-green td2-open-map mb-3" data-vd-view="vahan">
                                                <div class="td2-vc-header">
                                                    <div class="td2-vc-num">WB-99-ZZ-0001</div>
                                                </div>
                                                <div class="td2-vc-grid">
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Name</span>
                                                        <span class="td2-vc-val">—</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Driver Number</span>
                                                        <span class="td2-vc-val">—</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">About Driver</span>
                                                        <span class="td2-vc-val">—</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Status</span>
                                                        <span class="td2-vc-val"><span class="td2-veh-status-empty">Empty ✓</span></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Availability</span>
                                                        <span class="td2-vc-val">Yes</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Live Location</span>
                                                        <span class="td2-vc-val">Mumbai</span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Vehicle Rank</span>
                                                        <span class="td2-vc-val">5th <i class="uil uil-info-circle ms-1" style="cursor:pointer;font-size:1rem;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-custom-class="rank-tooltip" data-bs-title="<div class='rtt-header'>Trip Breakdown</div><div class='rtt-row'><span class='rtt-label'>Total Trips</span><span class='rtt-val'>12</span></div><div class='rtt-row'><span class='rtt-label'>Line</span><span class='rtt-val'>5 Trips</span></div><div class='rtt-row'><span class='rtt-label'>Local</span><span class='rtt-val'>7 Trips</span></div>"></i></span>
                                                    </div>
                                                    <div class="td2-vc-item">
                                                        <span class="td2-vc-label">Associated Since</span>
                                                        <span class="td2-vc-val">10 Years 5 Months</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    </div>{{-- /#td2AllocSelectView --}}

                                    {{-- Allocated Vehicle view — shown after Assign; hidden until then --}}
                                    <div id="td2AllocatedView" style="display:none;">

                                        <div class="td2-section">
                                            <div class="td2-alloc-done-head">
                                                <h6 class="td2-alloc-done-title"><i class="uil uil-check-circle"></i> Allocated Vehicle</h6>
                                                <button type="button" class="btn btn-primary td2-change-alloc-btn">Change Allocation</button>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Vehicle Number</span><span class="td2-di-value">WB-12-AB-1237</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Status</span><span class="td2-di-value">In Trip</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Live Location</span><span class="td2-di-value">Kolkata</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Empty Since</span><span class="td2-di-value">12/09/2025</span></div></div>

                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Driver Name</span><span class="td2-di-value">Ashoke Roy</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Driver Number</span><span class="td2-di-value">+91 9876543210</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Driver RAG Status</span><span class="td2-di-value"><span class="td2-rag td2-rag-yellow">Yellow</span></span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Associated Since</span><span class="td2-di-value">12/01/2026</span></div></div>

                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Trip Start Date &amp; Time</span><span class="td2-di-value">12/01/2026 | 12:00 AM</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Trip End Date &amp; Time</span><span class="td2-di-value">15/01/2026 | 01:00 PM</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Trip Created By</span><span class="td2-di-value">Andrew Jackson</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Trip Created On</span><span class="td2-di-value">20/12/2025</span></div></div>
                                            </div>
                                        </div>

                                        <div class="td2-section">
                                            <div class="td2-map-embed">
                                                <div class="td2-map-proto-badge">
                                                    <span class="td2-map-proto-dot"></span>
                                                    <span class="td2-map-proto-tag">Live Tracking</span>
                                                </div>
                                                <iframe
                                                    src="https://maps.google.com/maps?saddr=Kolkata,West+Bengal&daddr=Durgapur,West+Bengal&output=embed"
                                                    width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy"
                                                    referrerpolicy="no-referrer-when-downgrade"
                                                    title="Vehicle Live Location"></iframe>
                                            </div>
                                        </div>

                                        <div class="td2-section">
                                            <div class="row g-3">
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Vehicle Age</span><span class="td2-di-value">10 Year 5 month</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Vehicle Size</span><span class="td2-di-value">14 FT – XXM 14M × 9M × 12M</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Vehicle Capacity</span><span class="td2-di-value">1000KG</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Live Location</span><span class="td2-di-value">Kolkata</span></div></div>

                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Availability</span><span class="td2-di-value">Free</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Estimated Time of Arrival</span><span class="td2-di-value">12/11/2025 | 12:00 PM</span></div></div>
                                            </div>
                                        </div>

                                        <div class="td2-section">
                                            <p class="td2-section-title">Vehicle Rank</p>
                                            <div class="row g-3">
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Total Trip</span><span class="td2-di-value">10</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Line</span><span class="td2-di-value">4</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Local</span><span class="td2-di-value">6</span></div></div>
                                            </div>
                                        </div>

                                        <div class="td2-section">
                                            <p class="td2-section-title">Last Trip Details</p>
                                            <div class="row g-3">
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Trip Type</span><span class="td2-di-value">Line</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Customer</span><span class="td2-di-value">John Doe</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Source</span><span class="td2-di-value">Kolkata</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Destination</span><span class="td2-di-value">Delhi</span></div></div>

                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Stop 1</span><span class="td2-di-value">Durgapur</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Stop 2</span><span class="td2-di-value">Patna</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Duration</span><span class="td2-di-value">15 Hours</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Route</span><span class="td2-di-value"><span class="td2-alloc-route-pill">KOL - DEL</span></span></div></div>

                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Start Date &amp; Time</span><span class="td2-di-value">06/11/2025 | 12:00 PM</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Expected End Date &amp; Time</span><span class="td2-di-value">12/11/2025 | 12:00 PM</span></div></div>
                                                <div class="col-md-3 col-sm-6"><div class="td2-di"><span class="td2-di-label">Actual End Date &amp; Time</span><span class="td2-di-value">16/11/2025 | 12:00 PM</span></div></div>
                                            </div>
                                        </div>

                                    </div>{{-- /#td2AllocatedView --}}

                                </div>
