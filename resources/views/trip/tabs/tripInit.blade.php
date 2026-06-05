{{-- Trip show-v2 — tripInit tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Trip Initiations</h5>
                                    <a href="{{ route('trip.edit', 1) }}" class="td2-icon-btn" title="Edit Trip">
                                        <i class="uil uil-edit-alt"></i>
                                    </a>
                                </div>
                                <div class="td2-pane-body">

                                    {{-- Section 1: Info Grid --}}
                                    <div class="td2-section">
                                        <div class="row g-3">
                                            {{-- Row 1 --}}
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip ID</span>
                                                    <span class="td2-di-value">#001</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip Type</span>
                                                    <span class="td2-di-value">Own Booking</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip Category</span>
                                                    <span class="td2-di-value">Line</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Internal Trip ID</span>
                                                    <span class="td2-di-value">#001001765</span>
                                                </div>
                                            </div>

                                            {{-- Row 2 --}}
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Trip Date</span>
                                                    <span class="td2-di-value">25/10/2025</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">RAG Status</span>
                                                    <span class="td2-di-value"><span class="td2-rag td2-rag-red">Red</span></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Load Vendor</span>
                                                    <span class="td2-di-value">Blue Dart</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Customer</span>
                                                    <span class="td2-di-value">Nestle</span>
                                                </div>
                                            </div>

                                            {{-- Row 3 --}}
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Vehicle Type</span>
                                                    <span class="td2-di-value">Large Truck</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Vehicle Size</span>
                                                    <span class="td2-di-value">14 FT – XXM 14M × 9M × 12M</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Consigner</span>
                                                    <span class="td2-di-value">Britania Kolkata</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Consignee</span>
                                                    <span class="td2-di-value">Samsung Hydrabad</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 2: Route Strip --}}
                                    <div class="td2-section td2-section-compact">
                                        <div class="td2-route-strip">
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Source</span>
                                                <span class="td2-rs-dot td2-rs-dot-source"></span>
                                                <span class="td2-rs-name">Kolkata</span>
                                            </div>
                                            <span class="td2-rs-arrow">›</span>
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Stop 1</span>
                                                <span class="td2-rs-dot td2-rs-dot-mid"></span>
                                                <span class="td2-rs-name">Kolaghat</span>
                                            </div>
                                            <span class="td2-rs-arrow">›</span>
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Stop 2</span>
                                                <span class="td2-rs-dot td2-rs-dot-mid"></span>
                                                <span class="td2-rs-name">Patna</span>
                                            </div>
                                            <span class="td2-rs-arrow">›</span>
                                            <div class="td2-rs-stop">
                                                <span class="td2-rs-label">Destination</span>
                                                <span class="td2-rs-dot td2-rs-dot-dest"></span>
                                                <span class="td2-rs-name">Mumbai</span>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Route</span>
                                                    <span class="td2-di-value">Kolkata - Mumbai</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Distance</span>
                                                    <span class="td2-di-value">150 KM</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Priority</span>
                                                    <span class="td2-di-value"><span class="td2-priority td2-priority-urgent">Urgent</span></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="td2-di">
                                                    <span class="td2-di-label">Tarpaulin</span>
                                                    <span class="td2-di-value"><span class="td2-tarp-yes"><i class="uil uil-check-circle"></i> Yes</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 3: Comment --}}
                                    <div class="td2-section">
                                        <div class="td2-di">
                                            <span class="td2-di-label">Comment</span>
                                            <p class="td2-comment-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                        </div>
                                    </div>

                                </div>
