{{-- Trip show-v2 — profitLoss tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Profit or Loss</h5>
                                    <div class="td2-pane-actions">
                                        <button class="btn btn-outline-primary btn-sm td2-bill-click" type="button">
                                            Bill Entry
                                        </button>
                                        <a href="#" class="btn btn-success btn-sm">Finalise Bill</a>
                                    </div>
                                </div>
                                <div class="td2-pane-body">
                                    {{-- P&L Summary card --}}
                                    <div class="td2-pl-card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="td2-pl-section-title">Total Income</p>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Freight</span>
                                                    <span class="td2-pl-val">₹35,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Loading/Unloading</span>
                                                    <span class="td2-pl-val">₹2,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Multi-Point</span>
                                                    <span class="td2-pl-val">₹1,500</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Halting</span>
                                                    <span class="td2-pl-val">₹1,000</span>
                                                </div>
                                                <div class="td2-pl-subtotal">
                                                    <span>TOTAL INCOME</span>
                                                    <span>₹39,500</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="td2-pl-section-title">Total Expense</p>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Diesel</span>
                                                    <span class="td2-pl-val">₹15,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Toll Charges</span>
                                                    <span class="td2-pl-val">₹10,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Driver Advance</span>
                                                    <span class="td2-pl-val">₹50,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Maintenance</span>
                                                    <span class="td2-pl-val">₹3,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Fooding</span>
                                                    <span class="td2-pl-val">₹5,000</span>
                                                </div>
                                                <div class="td2-pl-row">
                                                    <span class="td2-pl-label">Misc. Exp</span>
                                                    <span class="td2-pl-val">₹2,000</span>
                                                </div>
                                                <div class="td2-pl-subtotal">
                                                    <span>TOTAL EXPENSE</span>
                                                    <span>₹85,000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td2-pl-result td2-pl-loss">
                                            <span>PROFIT / LOSS</span>
                                            <span>–₹45,500</span>
                                        </div>
                                    </div>

                                    {{-- Addition table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Addition</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addAddition">
                                                + Add Addition
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Addition Head</th>
                                                        <th>Amount</th>
                                                        <th>Recorded By</th>
                                                        <th>Date</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Fixed Fee</td>
                                                        <td>₹7,000</td>
                                                        <td>Vinay Goyel</td>
                                                        <td>12/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Loading/Unloading Charge</td>
                                                        <td>₹1,000</td>
                                                        <td>Abhishek Nayak</td>
                                                        <td>13/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Deduction table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Deduction</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addDeduction">
                                                + Add Deduction
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Deduction Head</th>
                                                        <th>Amount</th>
                                                        <th>Recorded By</th>
                                                        <th>Date</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TDS</td>
                                                        <td>₹7,000</td>
                                                        <td>Vinay Goyel</td>
                                                        <td>12/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mamul</td>
                                                        <td>₹3,000</td>
                                                        <td>Vinay Goyel</td>
                                                        <td>12/11/2025</td>
                                                        <td>—</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Transaction table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Transactions</p>
                                            <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#addTransaction">
                                                + Add Transaction
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Mode of Payment</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>12/11/2025</td>
                                                        <td>Advance</td>
                                                        <td>Cash</td>
                                                        <td>₹3,000</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Summary totals --}}
                                    <div class="td2-section td2-pl-totals">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Summary</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <span>Total Addition</span>
                                                <span>5,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span>Total Deduction</span>
                                                <span>10,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span>Net Payable</span>
                                                <span>15,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span>Net Amount Paid</span>
                                                <span>3,000.00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="td2-pl-due">Due Balance</span>
                                                <span class="td2-pl-due">9,000.00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
