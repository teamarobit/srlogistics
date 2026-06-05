{{-- Trip show-v2 — ewayLr tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Eway + LR</h5>
                                    <button class="btn btn-primary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#addEwayTable">
                                        + Add Eway
                                    </button>
                                </div>
                                <div class="td2-pane-body">

                                    {{-- ─── E-Way Bills ─── --}}
                                    <div class="td2-docs-section">
                                        <div class="td2-docs-header">
                                            <p class="td2-docs-title">E-Way Bills</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addEwayTable">
                                                + Add Eway
                                            </button>
                                        </div>

                                        {{-- Eway Card 1 --}}
                                        <div class="td2-doc-card">
                                            <div class="td2-card-accent td2-card-accent-orange"></div>
                                            <div class="td2-doc-card-body">
                                                <div class="td2-dot-menu-wrap dropdown">
                                                    <button class="td2-dot-trigger dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">&#8942;</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}">View Details</a></li>
                                                        {{-- Print REMOVED per feedback.md §6/§19 --}}
                                                    </ul>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Number</div>
                                                        <div class="td2-doc-val">#INV-2025-001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Date</div>
                                                        <div class="td2-doc-val">02/11/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Number</div>
                                                        <div class="td2-doc-val">#LR001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Date</div>
                                                        <div class="td2-doc-val">20/10/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Quantity</div>
                                                        <div class="td2-doc-val">40 Units</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Value with Tax</div>
                                                        <div class="td2-doc-val">&#8377;1,000</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Gross Weight</div>
                                                        <div class="td2-doc-val">10 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Charged Weight</div>
                                                        <div class="td2-doc-val">20 KG</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Eway Card 2 --}}
                                        <div class="td2-doc-card">
                                            <div class="td2-card-accent td2-card-accent-blue"></div>
                                            <div class="td2-doc-card-body">
                                                <div class="td2-dot-menu-wrap dropdown">
                                                    <button class="td2-dot-trigger dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">&#8942;</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}">View Details</a></li>
                                                        {{-- Print REMOVED per feedback.md §6/§19 --}}
                                                    </ul>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Number</div>
                                                        <div class="td2-doc-val">#INV-2025-001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Invoice Date</div>
                                                        <div class="td2-doc-val">02/11/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Number</div>
                                                        <div class="td2-doc-val">#LR001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Date</div>
                                                        <div class="td2-doc-val">20/10/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Quantity</div>
                                                        <div class="td2-doc-val">40 Units</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Value with Tax</div>
                                                        <div class="td2-doc-val">&#8377;1,000</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Gross Weight</div>
                                                        <div class="td2-doc-val">10 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Charged Weight</div>
                                                        <div class="td2-doc-val">20 KG</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ─── Lorry Receipts ─── --}}
                                    <div class="td2-docs-section">
                                        <div class="td2-docs-header">
                                            <p class="td2-docs-title">Lorry Receipts</p>
                                            <a href="{{ route('trip.lr.create') }}" class="btn btn-primary btn-sm">+ Add LR</a>
                                        </div>

                                        {{-- LR Card 1 --}}
                                        <div class="td2-doc-card">
                                            <div class="td2-card-accent td2-card-accent-green"></div>
                                            <div class="td2-doc-card-body">
                                                <div class="td2-dot-menu-wrap dropdown">
                                                    <button class="td2-dot-trigger dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">&#8942;</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('trip.lr.print') }}">View Details</a></li>
                                                        {{-- Print REMOVED per feedback.md §6/§19 --}}
                                                    </ul>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-2">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Vehicle Number</div>
                                                        <div class="td2-doc-val">WB-12-AB-1237</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Vehicle Size</div>
                                                        <div class="td2-doc-val">14 FT</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-3">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Number</div>
                                                        <div class="td2-doc-val">#LR001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Party LR#</div>
                                                        <div class="td2-doc-val">PTY-20251020</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">LR Date</div>
                                                        <div class="td2-doc-val">20/10/2025</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-3">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Seal Number</div>
                                                        <div class="td2-doc-val">SEAL-001</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Transport Mode</div>
                                                        <div class="td2-doc-val">Road</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Payment Terms</div>
                                                        <div class="td2-doc-val">To Pay</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row td2-doc-row-3">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Consignor</div>
                                                        <div class="td2-doc-val">Britania Kolkata</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Consignee</div>
                                                        <div class="td2-doc-val">Samsung Hydrabad</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Billing Party</div>
                                                        <div class="td2-doc-val">Gitanjali LLP</div>
                                                    </div>
                                                </div>
                                                <div class="td2-doc-row">
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Gross Weight</div>
                                                        <div class="td2-doc-val">10 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item">
                                                        <div class="td2-doc-label">Charged Weight</div>
                                                        <div class="td2-doc-val">20 KG</div>
                                                    </div>
                                                    <div class="td2-doc-item col-span-2">
                                                        <div class="td2-doc-label">Remarks</div>
                                                        <div class="td2-doc-val">Handle with care</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
