{{-- Trip show-v2 — tripPayout tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Trip Payout</h5>
                                </div>
                                <div class="td2-pane-body">
                                    <p class="td2-payout-subhead">Trip ID: #TRIP001 | Vehicle: XY-55-TY6788 | Driver: Ramesh Singh</p>

                                    {{-- Payout stat cards --}}
                                    <div class="td2-payout-stats row g-3 mb-2">
                                        {{-- Card 1: Diesel --}}
                                        <div class="col-md-4">
                                            <div class="td2-stat-card">
                                                <p class="td2-stat-card-title">Diesel</p>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Fixed Diesel</span>
                                                    <span class="td2-stat-val">200 L</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Issued Diesel</span>
                                                    <span class="td2-stat-val">150 L</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Pending Diesel</span>
                                                    <span class="td2-stat-val">50 L</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Card 2: Advance --}}
                                        <div class="col-md-4">
                                            <div class="td2-stat-card">
                                                <p class="td2-stat-card-title">Advance</p>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Fixed Advance</span>
                                                    <span class="td2-stat-val">₹10,000</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Issued Advance</span>
                                                    <span class="td2-stat-val">₹6,000</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Pending Advance</span>
                                                    <span class="td2-stat-val">₹4,000</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Card 3: Margin --}}
                                        <div class="col-md-4">
                                            <div class="td2-stat-card">
                                                <p class="td2-stat-card-title">Margin</p>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Fuel Rate</span>
                                                    <span class="td2-stat-val">₹90 / L</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Diesel Margin</span>
                                                    <span class="td2-stat-val">70 L × ₹90 = ₹6,300</span>
                                                </div>
                                                <div class="td2-stat-row">
                                                    <span class="td2-stat-label">Advance Margin</span>
                                                    <span class="td2-stat-val">₹4,000</span>
                                                </div>
                                                <div class="td2-stat-row td2-stat-total">
                                                    <span class="td2-stat-label">Total</span>
                                                    <span class="td2-stat-val">₹10,300</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="td2-payout-disclaimer">⚠ Trip Margin can apply across multiple trips. Figures shown are for this trip only.</p>

                                    {{-- Driver Transactions --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Driver Transactions</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#driverExpense">
                                                + Add Expense
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Expense Head</th>
                                                        <th>Expense Type</th>
                                                        <th>Debit (₹)</th>
                                                        <th>Credit (₹)</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Vehicle Challan</td>
                                                        <td>Credit</td>
                                                        <td>—</td>
                                                        <td>200</td>
                                                        <td>Traffic challan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Material Shortage</td>
                                                        <td>Debit</td>
                                                        <td>100</td>
                                                        <td>—</td>
                                                        <td>Short delivery</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
