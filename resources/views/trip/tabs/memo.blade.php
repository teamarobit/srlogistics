{{-- Trip show-v2 — memo tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Memo</h5>
                                </div>
                                <div class="td2-pane-body">
                                    <span class="td2-conditional-note">Outside Booking Only</span>

                                    {{-- Memo form --}}
                                    <form class="td2-memo-form" action="#">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Memo Number</label>
                                                <input type="text" class="form-control bg-light" name="memo_number"
                                                       value="Memo00120" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Load Vendor Name</label>
                                                <input type="text" class="form-control bg-light" name="vendor_name"
                                                       value="Samsung" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Date</label>
                                                <input type="date" class="form-control" name="memo_date"
                                                       value="2026-06-01">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Vehicle Num</label>
                                                <input type="text" class="form-control bg-light" name="vehicle_num"
                                                       value="WB-12-VH-1234" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Source</label>
                                                <select class="form-select" name="source">
                                                    <option value="">Choose...</option>
                                                    <option selected>Kolkata</option>
                                                    <option>Chennai</option>
                                                    <option>Delhi</option>
                                                    <option>Mumbai</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Destination</label>
                                                <select class="form-select" name="destination">
                                                    <option value="">Choose...</option>
                                                    <option>Kolkata</option>
                                                    <option>Chennai</option>
                                                    <option>Delhi</option>
                                                    <option>Mumbai</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Weight</label>
                                                <input type="text" class="form-control bg-light" name="weight"
                                                       value="7mt/9mt" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Freight</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="freight">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Advance</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="advance">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Balance</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="balance">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Halting</label>
                                                <input type="text" class="form-control" name="halting">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Multi Points</label>
                                                <input type="text" class="form-control" name="multi_points"
                                                       placeholder="Point 1, Point 2">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Loading Charges</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="loading_charges">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Unloading Charges</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" name="unloading_charges">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Remarks</label>
                                                <textarea class="form-control" name="remarks" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Memo Transactions --}}
                                    <div class="td2-section mt-4">
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
                                                        <th>Mode</th>
                                                        <th>Amount</th>
                                                        <th>Notes</th>
                                                        <th>Advance Received</th>
                                                        <th>Balance Received</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>12/11/2025</td>
                                                        <td>Advance</td>
                                                        <td>Cash</td>
                                                        <td>₹5,000</td>
                                                        <td>—</td>
                                                        <td>₹5,000</td>
                                                        <td>—</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-primary td2-memo-save">Save Memo</button>
                                    </div>
                                </div>
