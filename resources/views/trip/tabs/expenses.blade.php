{{-- Trip show-v2 — expenses tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Expenses</h5>
                                    <button class="btn btn-primary btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#addExpense">
                                        + Add Expense
                                    </button>
                                </div>
                                <div class="td2-pane-body">
                                    {{-- Expense summary cards --}}
                                    <div class="td2-exp-summary row g-2 mb-3">
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Diesel</span>
                                                <span class="td2-exp-amt">₹15,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Toll Charges</span>
                                                <span class="td2-exp-amt">₹10,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Driver Advance</span>
                                                <span class="td2-exp-amt">₹50,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Maintenance</span>
                                                <span class="td2-exp-amt">₹3,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Fooding</span>
                                                <span class="td2-exp-amt">₹5,000</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="td2-exp-card">
                                                <span class="td2-exp-head">Misc. Exp</span>
                                                <span class="td2-exp-amt">₹2,000</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="td2-exp-total-card">
                                                <span class="td2-exp-total-label">Total</span>
                                                <span class="td2-exp-total-amt">₹85,000</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Expense detail table --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Expense Detail</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="td2-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Expense Head</th>
                                                        <th>Date &amp; Time</th>
                                                        <th>Recorded By</th>
                                                        <th>Description</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Diesel</td>
                                                        <td>25/10/2025 10:00 AM</td>
                                                        <td>Ramesh Singh</td>
                                                        <td>Fuel fill-up Kolkata</td>
                                                        <td>Debit</td>
                                                        <td>₹5,000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Toll Charges</td>
                                                        <td>25/10/2025 02:00 PM</td>
                                                        <td>Ramesh Singh</td>
                                                        <td>NH-6 toll</td>
                                                        <td>Debit</td>
                                                        <td>₹800</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Driver Advance</td>
                                                        <td>26/10/2025 09:00 AM</td>
                                                        <td>Admin</td>
                                                        <td>Pre-trip advance</td>
                                                        <td>Debit</td>
                                                        <td>₹6,000</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
