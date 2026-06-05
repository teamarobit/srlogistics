{{-- Trip show-v2 — brokerPayment tab content (extracted partial) --}}
                                <div class="td2-pane-header">
                                    <h5 class="td2-pane-title">Broker Payment</h5>
                                </div>
                                <div class="td2-pane-body">
                                    <span class="td2-conditional-note">External Vehicle Only</span>
                                    <div class="td2-lock-note">Vehicle number and freight amount cannot be changed after allocation. Contact Admin to modify.</div>

                                    {{-- Payment type radio --}}
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="brokerPaymentType"
                                                   id="bpAdvance" value="Advance Request" checked>
                                            <label class="form-check-label" for="bpAdvance">Advance Request</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="brokerPaymentType"
                                                   id="bpBalance" value="Balance Request">
                                            <label class="form-check-label" for="bpBalance">Balance Request</label>
                                        </div>
                                    </div>

                                    {{-- Addition (Credit) --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Addition (Credit)</p>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Freight</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control td2-broker-locked"
                                                       value="35,000" readonly>
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Bonus</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Loading/Unloading Labour</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="2,000">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Halting</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="1,000">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Others</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Deduction (Debit) --}}
                                    <div class="td2-section">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Deduction (Debit)</p>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">TDS</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="3,500">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Damage/Shortage Charges</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Mamul</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" value="500">
                                            </div>
                                        </div>
                                        <div class="td2-broker-row">
                                            <span class="td2-broker-label">Others</span>
                                            <div class="input-group td2-broker-input">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" class="form-control" placeholder="—">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Net Payable --}}
                                    <div class="td2-section td2-broker-net">
                                        <div class="td2-section-header">
                                            <p class="td2-section-head-title">Net Payable</p>
                                        </div>
                                        <div class="td2-broker-net-row">
                                            <span>Gross Addition</span>
                                            <span>₹38,000</span>
                                        </div>
                                        <div class="td2-broker-net-row">
                                            <span>Total Deduction</span>
                                            <span>₹4,000</span>
                                        </div>
                                        <div class="td2-broker-net-row">
                                            <span>Net Payable</span>
                                            <span>₹34,000</span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-primary td2-broker-submit">Submit Payment Request</button>
                                    </div>
                                </div>
