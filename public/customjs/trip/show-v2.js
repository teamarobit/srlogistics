/**
 * Trip Details v2 — show-v2.js
 * SD-1: All logic in external JS file — no inline scripts in blade.
 * SD-7: Toast mixin defined at top.
 * v3.6 | 2026-06-03 — tab persistence across page refresh
 * v4.6 | 2026-06-15 — SOS → Pause → Resume operator flow (prototype, client-side)
 * v4.7 | 2026-06-15 — SOS / Resume events injected into the Status Timeline
 * v4.8 | 2026-06-16 — SOS incident location: auto GPS capture + editable Leaflet map
 * v4.9 | 2026-06-16 — SOS submit Toast now success (was error)
 * v5.0 | 2026-06-16 — Resume modal: vehicle picker mirrors Vehicle Allocation tab
 *                     (suggested cards + OR + Add/Allocate); card pick → inline Assign
 * v5.1 | 2026-06-16 — Resume modal: change-vehicle/driver notes; change-driver shows the
 *                     driver's currently-assigned vehicle card; condition notes (not on
 *                     another ongoing trip)
 * v5.2 | 2026-06-16 — Eway+LR: Unassigned E-Ways modal (select-all + live selected count/qty,
 *                     status filter) + nested Add Eway form modal (GSTIN + bill numbers)
 */

/* =============================================================
   TOAST MIXIN (SD-7)
   ============================================================= */
const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: function (toast) {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

/* =============================================================
   SELECT2 — force modal dropdowns to always open BELOW the field
   (Select2 flips upward inside a scrollable Bootstrap modal). Runs
   at load so the patched prototype is bound by every later init.
   Non-modal selects keep Select2's native above/below behaviour.
   ============================================================= */
(function () {
    if (!(window.jQuery && $.fn.select2 && $.fn.select2.amd)) { return; }
    try {
        var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');
        if (!AttachBody || AttachBody.prototype.__td2BelowPatched) { return; }
        var original = AttachBody.prototype._positionDropdown;
        AttachBody.prototype._positionDropdown = function () {
            var inModal = this.$dropdownParent && this.$dropdownParent.closest('.modal').length > 0;
            if (!inModal) { return original.apply(this, arguments); }
            var $op = this.$dropdownParent;
            if ($op.css('position') === 'static') { $op = $op.offsetParent(); }
            var offset = this.$container.offset();
            var height = this.$container.outerHeight(false);
            var parentOffset = { top: 0, left: 0 };
            if ($.contains(document.body, $op[0]) || $op[0].isConnected) { parentOffset = $op.offset(); }
            this.$dropdownContainer.css({
                top:  offset.top + height - parentOffset.top,
                left: offset.left - parentOffset.left
            });
            this.$dropdown.removeClass('select2-dropdown--above select2-dropdown--below').addClass('select2-dropdown--below');
            this.$container.removeClass('select2-container--above select2-container--below').addClass('select2-container--below');
        };
        AttachBody.prototype.__td2BelowPatched = true;
    } catch (e) { /* Select2 not ready — keep native behaviour */ }
})();

/* =============================================================
   PROTO CONFIG
   ─────────────────────────────────────────────────────────────
   PROTOTYPE_MODE = true   → use PROTO_CONFIG hardcoded values.
   PROTOTYPE_MODE = false  → read from blade data-* attributes on #tripApp.

   To test different scenarios, change PROTO_CONFIG values below.
   See docs/Features/TripDetails/dev-notes.md for full test matrix.
   ============================================================= */
var PROTOTYPE_MODE = true;

var PROTO_CONFIG = {
    tripType    : 'Own Booking',      // 'Own Booking' | 'Outside Booking'
    vehicleType : 'Own',              // 'Own' | 'External'
    tripStatus  : 'In Transit',        // 'Initiated' | 'Vehicle Assigned' | 'Loading' | 'In Transit' | 'Completed' | 'Cancelled'
    userRole    : 'Admin',            // 'Admin' | 'Tracking'
    hasDamagePod: false               // true | false
};

/* Read from blade data attributes when backend is wired */
var $app = $('#tripApp');
var tripConfig = PROTOTYPE_MODE ? PROTO_CONFIG : {
    tripType    : $app.data('trip-type')      || 'Own Booking',
    vehicleType : $app.data('vehicle-type')   || 'Own',
    tripStatus  : $app.data('trip-status')    || 'Initiated',
    userRole    : $app.data('user-role')      || 'Admin',
    hasDamagePod: $app.data('has-damage-pod') === '1'
};

/* =============================================================
   CONDITIONAL VISIBILITY RULES
   ─────────────────────────────────────────────────────────────
   Each function handles one condition axis.
   All called together in applyConditionalVisibility() on DOM ready.
   ============================================================= */

/**
 * CONDITION 1 — Trip Type
 * Own Booking   : show Eway+LR, Profit or Loss | hide Memo
 * Outside Booking: show Memo | hide Eway+LR, Profit or Loss
 */
function applyTripTypeRules() {
    var isOutside = (tripConfig.tripType === 'Outside Booking');

    /* Eway + LR tab */
    $('#td2-ewayLr-tab').closest('li').toggle(!isOutside);

    /* Profit or Loss (Billing Summary) tab */
    $('#td2-profitLoss-tab').closest('li').toggle(!isOutside);

    /* Memo tab — Outside Booking only */
    $('#td2-memo-tab').closest('li').toggle(isOutside);
}

/**
 * CONDITION 2 — Vehicle Allocation Type
 * Own vehicle    : show Trip Payout, Expenses, Profit or Loss | hide Broker Payment
 * External vehicle: show Broker Payment | hide Trip Payout, Expenses, Profit or Loss
 */
function applyVehicleTypeRules() {
    var isExternal = (tripConfig.vehicleType === 'External');

    /* Trip Payout tab */
    $('#td2-tripPayout-tab').closest('li').toggle(!isExternal);

    /* Expenses tab */
    $('#td2-expenses-tab').closest('li').toggle(!isExternal);

    /* Profit or Loss tab — also hidden by trip type rule; force hide if external */
    if (isExternal) {
        $('#td2-profitLoss-tab').closest('li').hide();
    }

    /* Broker Payment tab — External vehicle only */
    $('#td2-brokerPayment-tab').closest('li').toggle(isExternal);
}

/**
 * CONDITION 3 — User Role
 * Admin    : show Status dropdown, Reviews, full P&L tab
 * Tracking : hide Status dropdown, Reviews, P&L tab (sees Expenses only)
 */
/**
 * CONDITION 3 — User Role (dev-notes §4)
 * Admin    : show Status dropdown, Reviews, full P&L tab
 * Tracking : hide Status dropdown, Reviews, P&L tab (sees Expenses only)
 * Elements are CONDITIONAL, never deleted (dev-notes core principle).
 */
function applyRoleRules() {
    var isAdmin = (tripConfig.userRole === 'Admin');

    /* Status dropdown in right sidebar */
    $('.status-sidebar-wrap').toggle(isAdmin);

    /* Reviews section in right sidebar */
    $('.reviews-sidebar-wrap').toggle(isAdmin);

    /* Profit or Loss tab hidden from Tracking Person */
    if (!isAdmin) {
        $('#td2-profitLoss-tab').closest('li').hide();
    }
}

/**
 * CONDITION 4 — Trip Status
 * Start Tracking  : show only when status = 'Vehicle Assigned'
 * Settle Trip     : show only when status = 'Ongoing' or 'In Transit'
 * Cancel Trip     : hide when status = 'Completed' or 'Cancelled'
 */
function applyStatusRules() {
    var s = tripConfig.tripStatus;
    var settleStatuses  = ['Loading', 'In Transit', 'Ongoing'];
    var hideCancel      = ['Completed', 'Cancelled'];

    $('#startTrackingBtn').toggle(s === 'Vehicle Assigned');
    $('#settleTripBtn').toggle(settleStatuses.indexOf(s) !== -1);
    $('#cancelTripBtn').toggle(hideCancel.indexOf(s) === -1);
}

/**
 * CONDITION 5 — Damage / Shortage POD
 * If any POD has acknowledgement = Damaged | Short,
 * the Settle Trip button is disabled with tooltip.
 */
function applyDamagePodRules() {
    if (tripConfig.hasDamagePod) {
        $('#settleTripBtn')
            .prop('disabled', true)
            .attr('title', 'Cannot settle — Damaged/Short POD pending resolution')
            .addClass('opacity-50');
    }
}

/**
 * CONDITION 6 — Trip Lifecycle Stepper
 * Activates the correct step based on tripConfig.tripStatus.
 */
function updateStepper() {
    var statusOrder = ['Initiated', 'Vehicle Assigned', 'In Transit', 'Completed'];
    var $stepper    = $('#td2Stepper');
    var s           = tripConfig.tripStatus;

    /* Map aliases to canonical status */
    if (s === 'Vehicle Not Assigned' || s === 'New')                                                      { s = 'Initiated'; }
    if (s === 'Ongoing' || s === 'Reported' || s === 'Delayed' || s === 'Detained' ||
        s === 'Unloaded' || s === 'Breakdown' || s === 'In Repair' || s === 'Accident' ||
        s === 'Loading')                                                                                  { s = 'In Transit'; }

    if (s === 'Cancelled') {
        $stepper.addClass('td2-stepper-cancelled');
        return;
    }

    var currentIdx = statusOrder.indexOf(s);

    $stepper.find('.td2-step').each(function (i) {
        var $step = $(this);
        $step.removeClass('td2-step-done td2-step-active td2-step-pending');
        if (i < currentIdx) {
            $step.addClass('td2-step-done');
        } else if (i === currentIdx) {
            $step.addClass('td2-step-active');
        } else {
            $step.addClass('td2-step-pending');
        }
    });

    $stepper.find('.td2-step-line').each(function (i) {
        $(this).toggleClass('td2-step-line-done', i < currentIdx);
    });
}

/**
 * Master init — runs all conditional rules in correct order.
 */
function applyConditionalVisibility() {
    applyTripTypeRules();
    applyVehicleTypeRules();  /* must run after trip type — may override profitLoss */
    applyRoleRules();         /* must run last — role can hide what vehicle type showed */
    applyStatusRules();
    applyDamagePodRules();
    updateStepper();          /* v2.0 — trip lifecycle stepper */
}

/* =============================================================
   OVERLAY PANELS
   ─────────────────────────────────────────────────────────────
   attachment-popup, map-popup, bill-popup
   Toggle .show class to slide in/out.
   ============================================================= */
function closeAllOverlays() {
    $('.td2-overlay').removeClass('show');
}

/* Attachment overlay */
$(document).on('click', '#attachmentBtn', function () {
    closeAllOverlays();
    $('.attachment-popup').addClass('show');
});

/* Bill Entry overlay */
$(document).on('click', '.td2-bill-click', function () {
    closeAllOverlays();
    $('.bill-popup').addClass('show');
});

/* Map / Vehicle Detail overlay — eye button or card click.
   Cards with data-vd-view="vahan" (External/Vendor) show the VAHAN details
   block in place of the live-location map. */
$(document).on('click', '.td2-open-map', function (e) {
    e.stopPropagation();
    closeAllOverlays();

    var showVahan = $(this).data('vd-view') === 'vahan';
    $('.map-popup .td2-map-embed').toggleClass('d-none', showVahan);
    $('.map-popup .td2-vd-vahan-view').toggleClass('d-none', !showVahan);

    $('.map-popup').addClass('show');
});

/* Close any overlay */
$(document).on('click', '.close-overlay', function () {
    closeAllOverlays();
});

/* Close overlay on ESC key */
$(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
        closeAllOverlays();
    }
});

/* =============================================================
   SOS PANEL
   ─────────────────────────────────────────────────────────────
   Checkbox group — multi-select.
   "Other" checkbox reveals a free-text input.
   ============================================================= */

/* Toggle free-text input when "Other" is checked */
$(document).on('change', '.td2-sos-other-chk', function () {
    var $input = $(this).closest('.td2-scard').find('.td2-sos-other-input');
    if ($(this).is(':checked')) {
        $input.slideDown(150);
    } else {
        $input.slideUp(150);
    }
});

/* SOS Submit — placeholder (no AJAX wired in prototype) */
$(document).on('click', '.td2-sos-submit-btn', function () {
    var selected = [];
    $('.sos-sidebar-wrap .form-check-input:checked').each(function () {
        selected.push($(this).val());
    });
    var otherText = $('.td2-sos-other-input input').val().trim();
    if (otherText) { selected.push('Other: ' + otherText); }

    if (selected.length === 0) {
        Toast.fire({ icon: 'warning', title: 'Select at least one SOS type.' });
        return;
    }

    /* Prototype: just show confirmation toast */
    Toast.fire({ icon: 'success', title: 'SOS reported: ' + selected.join(', ') });
});

/* =============================================================
   HISTORY — Add Comment
   ============================================================= */
$(document).on('click', '#td2HistoryCommentBtn', function () {
    var text = $('#td2HistoryComment').val().trim();
    if (!text) {
        Toast.fire({ icon: 'warning', title: 'Please enter a comment.' });
        return;
    }

    var now    = new Date();
    var date   = now.toLocaleDateString('en-GB', { day:'2-digit', month:'2-digit', year:'numeric' });
    var time   = now.toLocaleTimeString('en-GB', { hour:'2-digit', minute:'2-digit' });
    var initials = 'ME'; /* placeholder — replace with blade-rendered user initials */

    var $item = $(
        '<div class="td2-history-item td2-history-item-new">' +
            '<div class="td2-history-av">' + initials + '</div>' +
            '<div class="td2-history-detail">' +
                '<span class="td2-history-name">You</span>' +
                '<span class="td2-history-date">' + date + ' | ' + time + '</span>' +
                '<p class="td2-history-text">' + $('<div>').text(text).html() + '</p>' +
            '</div>' +
        '</div>'
    );

    $('.td2-history-list').prepend($item);
    $('#td2HistoryComment').val('');
    Toast.fire({ icon: 'success', title: 'Comment added.' });
});

/* =============================================================
   SPRINT 2 — Vehicle Allocation
   ============================================================= */

/* Own Vehicle / External toggle */
$(document).on('change', '.td2-own-veh', function () {
    $('.td2-if-own').show();
    $('.td2-if-ext').hide();
});

$(document).on('change', '.td2-ext-veh', function () {
    $('.td2-if-own').hide();
    $('.td2-if-ext').show();
});

/* VAHAN Details + selected vehicle card — reveal only after a vehicle is picked.
   Hidden by default in the blade; shown (accordion expanded) on selection. */
function td2ToggleVahan($scope, collapseSelector, show) {
    var collapseEl = document.querySelector(collapseSelector);
    if (show) {
        $scope.find('.td2-vahan-wrap').show();
        $scope.find('.td2-veh-card').show();
        if (collapseEl) { bootstrap.Collapse.getOrCreateInstance(collapseEl).show(); }
    } else {
        if (collapseEl) { bootstrap.Collapse.getOrCreateInstance(collapseEl).hide(); }
        $scope.find('.td2-vahan-wrap').hide();
        $scope.find('.td2-veh-card').hide();
    }
}

$(document).on('change', '#td2OwnVehSelect', function () {
    td2ToggleVahan($(this).closest('.td2-if-own'), '#td2VahanDetails', !!$(this).val());
});

$(document).on('change', '#td2ExtVehicleSelect', function () {
    td2ToggleVahan($(this).closest('.td2-if-ext'), '#td2VahanDetailsExt', !!$(this).val());
});

/* Edit Trip: + Add Stop */
$(document).on('click', '.td2-add-stop-btn', function () {
    var $clone = $('.td2-edit-stop-item').first().clone();
    $clone.find('input, select').val('');
    $(this).before($clone);
});

$(document).on('click', '.td2-remove-stop', function () {
    $(this).closest('.td2-edit-stop-item').remove();
});

/* Edit Trip: customer/load-broker label swap on trip type change */
$(document).on('change', '#td2EditTripType', function () {
    var isOutside = $(this).val() === 'Outside Booking';
    $('.td2-edit-cust-label').text(isOutside ? 'Load Broker' : 'Customer');
});

/* Select2 init for edit trip modal fields */
$(document).on('shown.bs.modal', '#editTrip', function () {
    $('.select2-modal', this).select2({ dropdownParent: $(this), width: '100%' });
});

/* Select2 init for Assign Vehicle modal fields */
$(document).on('shown.bs.modal', '#assignModal', function () {
    $('.select2-modal', this).select2({ dropdownParent: $(this), width: '100%' });
});

/* Select2 init for Driver Transaction modal — Expense Head supports
   selecting an existing head OR typing a new one (tags: true). */
$(document).on('shown.bs.modal', '#driverExpense', function () {
    var $head = $('#td2ExpenseHead');
    if ($head.length && !$head.hasClass('select2-hidden-accessible')) {
        $head.select2({
            dropdownParent: $(this),
            width: '100%',
            tags: true,
            placeholder: 'Select or add an expense head',
            allowClear: true
        });
    }

    /* Date & Time — single date + time picker (daterangepicker, already loaded
       in layouts.app). Replaces the native datetime-local control. */
    var $expDate = $('#td2ExpenseDate');
    if ($expDate.length && typeof $.fn.daterangepicker === 'function' && !$expDate.data('daterangepicker')) {
        $expDate.daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: false,
            timePickerIncrement: 1,
            autoUpdateInput: false,
            parentEl: '#driverExpense',
            locale: { format: 'DD MMM YYYY, hh:mm A', cancelLabel: 'Clear' }
        });
        $expDate.on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD MMM YYYY, hh:mm A'));
        });
        $expDate.on('cancel.daterangepicker', function () {
            $(this).val('');
        });
    }
});

/* =============================================================
   Assign  ->  Allocated Vehicle view  (Vehicle Allocation tab)
   On Assign: hide the selection view, reveal the allocated view.
   Change Allocation: return to the selection view.
   ============================================================= */
$(document).on('submit', '#assignVehicleForm', function (e) {
    e.preventDefault();
    var modalEl = document.getElementById('assignModal');
    if (modalEl) {
        (bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl)).hide();
    }
    $('.td2-overlay').removeClass('show');   // close the Vehicle Details side panel
    $('#td2AllocSelectView').hide();
    $('#td2AllocatedView').fadeIn(150);
    Toast.fire({ icon: 'success', title: 'Vehicle assigned to trip.' });
});

$(document).on('click', '.td2-change-alloc-btn', function () {
    $('#td2AllocatedView').hide();
    $('#td2AllocSelectView').fadeIn(150);
});

/* Daterangepicker for edit trip date */
$(document).on('shown.bs.modal', '#editTrip', function () {
    if ($('#td2EditDateRange').length && typeof $.fn.daterangepicker !== 'undefined') {
        $('#td2EditDateRange').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            startDate: moment(),
            locale: { format: 'DD/MM/YYYY' }
        });
    }
});

/* =============================================================
   SPRINT 4 — Financial Tabs
   ============================================================= */

/* Broker Payment type toggle (radio — no dynamic hide needed, just visual) */
$(document).on('change', 'input[name="brokerPaymentType"]', function () {
    var type = $(this).val();
    Toast.fire({ icon: 'info', title: 'Payment type: ' + type });
});

/* Memo save — prototype only */
$(document).on('click', '.td2-memo-save', function () {
    Toast.fire({ icon: 'success', title: 'Memo saved (prototype).' });
});

/* Broker Payment submit — prototype only */
$(document).on('click', '.td2-broker-submit', function () {
    Toast.fire({ icon: 'success', title: 'Payment request submitted (prototype).' });
});

/* =============================================================
   SPRINT 5 — STAR RATING
   ─────────────────────────────────────────────────────────────
   Each .td2-star-row holds 5 .td2-star icons + a hidden input.
   Hover highlights up to hovered star; click locks the rating.
   ============================================================= */
$(document).on('mouseenter', '.td2-star', function () {
    var $row = $(this).closest('.td2-star-row');
    var val  = parseInt($(this).data('val'), 10);
    $row.find('.td2-star').each(function (i) {
        $(this).toggleClass('active', i < val);
    });
});

$(document).on('mouseleave', '.td2-star-row', function () {
    var $row    = $(this);
    var current = parseInt($row.find('input[type="hidden"]').val(), 10) || 0;
    $row.find('.td2-star').each(function (i) {
        $(this).toggleClass('active', i < current);
    });
});

$(document).on('click', '.td2-star', function () {
    var $row = $(this).closest('.td2-star-row');
    var val  = parseInt($(this).data('val'), 10);
    $row.find('input[type="hidden"]').val(val);
    $row.find('.td2-star').each(function (i) {
        $(this).toggleClass('active', i < val);
    });
});

/* =============================================================
   SPRINT 5 — FILE UPLOAD (ATTACHMENT PANEL)
   ============================================================= */

/* Drag-over highlight */
$(document).on('dragover', '#td2UploadZone', function (e) {
    e.preventDefault();
    $(this).addClass('dragover');
});

$(document).on('dragleave', '#td2UploadZone', function () {
    $(this).removeClass('dragover');
});

$(document).on('drop', '#td2UploadZone', function (e) {
    e.preventDefault();
    $(this).removeClass('dragover');
    var files = e.originalEvent.dataTransfer.files;
    if (files && files.length) {
        handleFileAttach(files);
    }
});

/* Browse-file input change */
$(document).on('change', '.td2-file-input', function () {
    if (this.files && this.files.length) {
        handleFileAttach(this.files);
    }
    $(this).val(''); /* reset so same file can be re-selected */
});

function handleFileAttach(files) {
    var iconMap = { pdf: 'td2-ficon-pdf', jpg: 'td2-ficon-img', jpeg: 'td2-ficon-img',
                    png: 'td2-ficon-img', doc: 'td2-ficon-doc', docx: 'td2-ficon-doc',
                    xls: 'td2-ficon-doc', xlsx: 'td2-ficon-doc' };
    var uiconMap = { pdf: 'uil-file-pdf', jpg: 'uil-image', jpeg: 'uil-image',
                     png: 'uil-image', doc: 'uil-file-alt', docx: 'uil-file-alt',
                     xls: 'uil-file-spreadsheet', xlsx: 'uil-file-spreadsheet' };

    $.each(files, function (i, file) {
        var ext      = file.name.split('.').pop().toLowerCase();
        var iconCls  = iconMap[ext]  || 'td2-ficon-doc';
        var uiconCls = uiconMap[ext] || 'uil-file-alt';
        var sizeMB   = (file.size / 1048576).toFixed(1);
        var today    = new Date();
        var dateStr  = ('0'+today.getDate()).slice(-2) + '/' +
                       ('0'+(today.getMonth()+1)).slice(-2) + '/' + today.getFullYear();

        var html = '<div class="td2-file-item td2-new-file">' +
            '<div class="td2-file-icon ' + iconCls + '"><i class="uil ' + uiconCls + '"></i></div>' +
            '<div class="td2-file-info">' +
                '<span class="td2-file-name">' + $('<span>').text(file.name).html() + '</span>' +
                '<span class="td2-file-meta">' + ext.toUpperCase() + ' · ' + sizeMB + ' MB · ' + dateStr + '</span>' +
            '</div>' +
            '<div class="td2-file-actions">' +
                '<button class="td2-file-btn" type="button" title="Download"><i class="uil uil-download-alt"></i></button>' +
                '<button class="td2-file-btn td2-file-del" type="button" title="Delete"><i class="uil uil-trash-alt"></i></button>' +
            '</div>' +
        '</div>';

        $('#td2FileList').append(html);
    });

    Toast.fire({ icon: 'success', title: files.length + ' file(s) added.' });
}

/* Delete file item */
$(document).on('click', '.td2-file-del', function () {
    $(this).closest('.td2-file-item').fadeOut(200, function () { $(this).remove(); });
});

/* =============================================================
   SPRINT 5 — BILL ENTRY PANEL (save prototype)
   ============================================================= */
$(document).on('click', '.td2-bill-save-btn', function () {
    Toast.fire({ icon: 'success', title: 'Bill entry saved (prototype).' });
    closeAllOverlays();
});

/* =============================================================
   SPRINT 5 — REVIEW MODAL
   ============================================================= */
$(document).on('click', '.td2-review-save-btn', function () {
    var driverRating = $('#addReviewForm input[name="driver_rating"]').val();
    if (!driverRating) {
        Toast.fire({ icon: 'warning', title: 'Please rate driver performance.' });
        return;
    }
    Toast.fire({ icon: 'success', title: 'Review saved (prototype).' });
    $('#addReview').modal('hide');
    $('#addReviewForm')[0].reset();
    $('#addReview .td2-star').removeClass('active');
    $('#addReview input[type="hidden"]').val('');
});

/* =============================================================
   SPRINT 5 — CHANGE STATUS MODAL
   ============================================================= */

/* Update Status = route-stage progression only. Disruptions (Halt, Breakdown,
   Accident, etc.) moved to the SOS panel, so the old "Other" sub-status
   dropdown was removed from the modal. */
$(document).on('click', '.td2-status-save-btn', function () {
    if (!$('#td2StatusSelect').val()) {
        Toast.fire({ icon: 'warning', title: 'Please select a status.' });
        return;
    }
    Toast.fire({ icon: 'success', title: 'Status updated (prototype).' });
    $('#changeStatus').modal('hide');
});

/* =============================================================
   SPRINT 5 — DRIVER EXPENSE MODAL
   ============================================================= */
$(document).on('click', '.td2-driver-exp-save', function () {
    Toast.fire({ icon: 'success', title: 'Driver transaction added (prototype).' });
    $('#driverExpense').modal('hide');
    $('#driverExpenseForm')[0].reset();
    if ($('#td2ExpenseHead').hasClass('select2-hidden-accessible')) {
        $('#td2ExpenseHead').val('').trigger('change');
    }
    $('#td2ExpenseDate').val('');
});

/* =============================================================
   SPRINT 5 — ADD VEHICLE MODAL
   ============================================================= */
$(document).on('click', '.td2-addveh-save', function () {
    Toast.fire({ icon: 'success', title: 'Vehicle added (prototype).' });
    $('#addVeh').modal('hide');
    $('#addVehForm')[0].reset();
});

/* =============================================================
   SPRINT 5 — ADDITION / DEDUCTION / TRANSACTION MODALS
   ============================================================= */
$(document).on('click', '.td2-addition-save', function () {
    Toast.fire({ icon: 'success', title: 'Addition saved (prototype).' });
    $('#addAddition').modal('hide');
    $('#addAdditionForm')[0].reset();
});

$(document).on('click', '.td2-deduction-save', function () {
    Toast.fire({ icon: 'success', title: 'Deduction saved (prototype).' });
    $('#addDeduction').modal('hide');
    $('#addDeductionForm')[0].reset();
});

$(document).on('click', '.td2-txn-save', function () {
    Toast.fire({ icon: 'success', title: 'Transaction saved (prototype).' });
    $('#addTransaction').modal('hide');
    $('#addTransactionForm')[0].reset();
});

/* =============================================================
   SOS — FLOATING FAB + PANEL + HISTORY
   ============================================================= */

// In-memory SOS log (prototype — replaced by AJAX when backend is wired)
var sosLog = [];

/* =============================================================
   PAUSE / RESUME STATE (prototype — client-side)
   ─────────────────────────────────────────────────────────────
   tripState mirrors a future trips.trip_status = 'Paused'.
   activeSos holds the id of the SOS event that paused the trip.
   Visibility of the Paused badge / Resume buttons / locked
   Update Status link is driven by the body.td2-trip-paused class
   so it survives the lazy-loaded vehStatus tab being (re)injected.
   ============================================================= */
var tripState = 'Ongoing';   // 'Ongoing' | 'Paused'
var activeSos = null;        // SOS event id that paused the trip

function setTripPaused(paused, sosId) {
    tripState = paused ? 'Paused' : 'Ongoing';
    activeSos = paused ? (sosId || null) : null;
    $('body').toggleClass('td2-trip-paused', paused);
}

/* Short "DD/MM/YYYY HH:MM" timestamp helper */
function td2Now() {
    var n = new Date();
    return ('0'+n.getDate()).slice(-2) + '/' +
           ('0'+(n.getMonth()+1)).slice(-2) + '/' + n.getFullYear() +
           ' ' + ('0'+n.getHours()).slice(-2) + ':' + ('0'+n.getMinutes()).slice(-2);
}

/* =============================================================
   SOS — INCIDENT LOCATION (auto GPS capture + editable map)
   ─────────────────────────────────────────────────────────────
   Prototype, client-side. Uses Leaflet + OpenStreetMap tiles
   (no API key) and Nominatim for reverse geocoding. The marker
   is locked by default; "Edit" makes it draggable / tap-to-place.
   Captured lat/lng/address are written to the hidden inputs and
   ride along in the SOS submit event.
   ============================================================= */
var sosMap        = null;   // Leaflet map instance
var sosMarker     = null;   // draggable marker
var sosMapEditing = false;  // edit mode on/off
var sosLocReady   = false;  // a coordinate has been captured

/* Fallback centre — trip origin (Kolkata) until GPS resolves. */
var SOS_DEFAULT_LAT = 22.5726;
var SOS_DEFAULT_LNG = 88.3639;

/* Custom red SOS pin (matches panel theme) */
function sosPinIcon() {
    return L.divIcon({
        className: '',
        html: '<div class="td2-sos-pin">' +
              '<span class="td2-sos-pin-pulse"></span>' +
              '<span class="td2-sos-pin-dot"></span></div>',
        iconSize: [26, 26],
        iconAnchor: [13, 13]
    });
}

/* Update the small status pill */
function setSosLocStatus(state, text) {
    var $pill = $('#td2SosLocStatus');
    $pill.removeClass('is-locating is-located is-editing is-error');
    if (state) { $pill.addClass(state); }
    $pill.find('.td2-sos-loc-status-txt').text(text);
}

/* Persist the captured coordinate to hidden inputs + coord line */
function setSosCoords(lat, lng) {
    sosLocReady = true;
    $('#td2SosLat').val(lat);
    $('#td2SosLng').val(lng);
    $('#td2SosLocCoords').text(Number(lat).toFixed(5) + ', ' + Number(lng).toFixed(5));
}

/* Reverse geocode (Nominatim) → human address. Best-effort. */
function sosReverseGeocode(lat, lng) {
    $('#td2SosLocAddr').text('Fetching address…');
    $.ajax({
        url: 'https://nominatim.openstreetmap.org/reverse',
        method: 'GET',
        timeout: 8000,
        data: { format: 'json', lat: lat, lon: lng, zoom: 16, addressdetails: 1 },
        success: function (res) {
            var addr = (res && res.display_name) ? res.display_name : 'Address unavailable';
            $('#td2SosLocAddr').text(addr);
            $('#td2SosAddress').val(addr);
        },
        error: function () {
            $('#td2SosLocAddr').text('Address lookup unavailable');
            $('#td2SosAddress').val('');
        }
    });
}

/* Move marker + map to a coordinate and refresh meta */
function sosSetLocation(lat, lng, recenter) {
    if (!sosMap) { return; }
    if (sosMarker) {
        sosMarker.setLatLng([lat, lng]);
    }
    if (recenter) {
        sosMap.setView([lat, lng], 15, { animate: true });
    }
    setSosCoords(lat, lng);
    sosReverseGeocode(lat, lng);
}

/* Build the Leaflet map once (lazily, when the panel first opens) */
function initSosMap() {
    if (sosMap || typeof L === 'undefined') { return; }

    sosMap = L.map('td2SosMap', {
        center: [SOS_DEFAULT_LAT, SOS_DEFAULT_LNG],
        zoom: 13,
        zoomControl: true,
        attributionControl: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(sosMap);

    sosMarker = L.marker([SOS_DEFAULT_LAT, SOS_DEFAULT_LNG], {
        icon: sosPinIcon(),
        draggable: false
    }).addTo(sosMap);

    /* When dragging the pin (edit mode) — update on drop */
    sosMarker.on('dragend', function () {
        var p = sosMarker.getLatLng();
        sosSetLocation(p.lat, p.lng, false);
    });

    /* Tap the map (edit mode only) to move the pin */
    sosMap.on('click', function (e) {
        if (!sosMapEditing) { return; }
        sosSetLocation(e.latlng.lat, e.latlng.lng, false);
    });

    /* Initial GPS capture */
    sosLocate(false);
}

/* Capture the device's current location */
function sosLocate(announce) {
    if (!navigator.geolocation) {
        setSosLocStatus('is-error', 'GPS unavailable');
        $('#td2SosLocAddr').text('Location services not available — edit manually');
        return;
    }
    setSosLocStatus('is-locating', 'Locating…');
    navigator.geolocation.getCurrentPosition(
        function (pos) {
            var lat = pos.coords.latitude;
            var lng = pos.coords.longitude;
            sosSetLocation(lat, lng, true);
            setSosLocStatus('is-located', 'Current location captured');
            if (announce) { Toast.fire({ icon: 'success', title: 'Location updated to current position' }); }
        },
        function () {
            setSosLocStatus('is-error', 'Location denied');
            $('#td2SosLocAddr').text('Couldn’t get current location — tap “Edit” to set it manually');
            /* Keep the default centre as an editable starting point */
            setSosCoords(SOS_DEFAULT_LAT, SOS_DEFAULT_LNG);
        },
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
    );
}

/* Toggle edit mode on the map */
function setSosMapEditing(on) {
    sosMapEditing = on;
    $('#td2SosMap').closest('.td2-sos-map-shell').toggleClass('is-editing', on);
    $('#td2SosMapHint').toggleClass('d-none', !on);
    var $btn = $('#td2SosEditLocBtn');
    $btn.toggleClass('is-active', on);
    $btn.find('.td2-sos-map-btn-lbl').text(on ? 'Done' : 'Edit');
    $btn.find('i').attr('class', on ? 'uil uil-check' : 'uil uil-edit');
    if (sosMarker) { sosMarker.dragging[on ? 'enable' : 'disable'](); }
    if (on) {
        setSosLocStatus('is-editing', 'Adjust the pin');
    } else if (sosLocReady) {
        setSosLocStatus('is-located', 'Location set');
    }
}

/* Edit / Done toggle */
$(document).on('click', '#td2SosEditLocBtn', function () {
    setSosMapEditing(!sosMapEditing);
});

/* "Use my current location" button */
$(document).on('click', '#td2SosGpsBtn', function () {
    sosLocate(true);
});

/* ── Open / close SOS panel ── */
$('#td2SosFabBtn').on('click', function () {
    $('#td2SosPanel').addClass('show');
    /* Leaflet must size against a visible container — init/refresh after the
       slide-in transition so the map renders at full width. */
    setTimeout(function () {
        initSosMap();
        if (sosMap) { sosMap.invalidateSize(); }
    }, 380);
});

$('#td2SosPanelClose').on('click', function () {
    $('#td2SosPanel').removeClass('show');
});

/* ── View History link (inside panel) ── */
$('#td2SosHistoryBtn').on('click', function () {
    $('#td2SosPanel').removeClass('show');
    renderSosHistory();
    $('#sosHistory').modal('show');
});

/* ── "Other" free-text chip (no checkbox — always visible as textarea) ── */

/* ── Add custom incident type (common icon for all user-added incidents) ── */
$('#td2SosAddIncidentBtn').on('click', function () {
    Swal.fire({
        title: 'Add Incident',
        input: 'text',
        inputLabel: 'Incident name',
        inputPlaceholder: 'e.g. Tyre Burst',
        showCancelButton: true,
        confirmButtonText: 'Add',
        confirmButtonColor: '#dc2626',
        inputValidator: function (value) {
            if (!$.trim(value)) { return 'Please enter an incident name.'; }
        }
    }).then(function (result) {
        if (!result.isConfirmed) { return; }
        var name = $.trim(result.value);
        var tag  = name.replace(/\s/g, '');

        /* Build chip via DOM (avoids HTML injection) — common icon for all custom incidents */
        var $input  = $('<input type="checkbox" checked>').val(name);
        var $span   = $('<span></span>')
            .append($('<i class="uil uil-exclamation-octagon"></i>'))
            .append(document.createTextNode(' #' + tag));
        var $remove = $('<button type="button" class="td2-sos-chip-remove" aria-label="Remove incident" title="Remove">&times;</button>');
        var $chip   = $('<label class="td2-sos-chip td2-sos-chip-custom"></label>')
            .append($input).append($span).append($remove);

        $('#td2SosAddIncidentBtn').before($chip);
        Toast.fire({ icon: 'success', title: 'Incident added: #' + tag });
    });
});

/* ── Remove a custom-added incident ── */
$('#td2SosCheckboxes').on('click', '.td2-sos-chip-remove', function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).closest('.td2-sos-chip').remove();
});

/* ── Submit SOS ── */
$('#td2SosSubmitBtn').on('click', function () {
    var selected = [];
    $('#td2SosCheckboxes input:checked').each(function () {
        selected.push('#' + $(this).val().replace(/\s/g, ''));
    });
    var manual = $.trim($('#td2SosManual').val());
    if (manual) selected.push('Note: ' + manual);

    if (!selected.length) {
        Toast.fire({ icon: 'warning', title: 'Select at least one incident type.' });
        return;
    }

    var pauseTrip = $('#td2SosPauseToggle').is(':checked');

    var event = {
        id      : Date.now(),
        tags    : selected,
        manual  : manual,
        time    : td2Now(),
        reporter: tripConfig.userRole,
        status  : 'Active',
        pausesTrip  : pauseTrip,
        /* Captured incident location (prototype — client-side) */
        lat     : $('#td2SosLat').val()     || null,
        lng     : $('#td2SosLng').val()     || null,
        address : $('#td2SosAddress').val() || null,
        resolvedBy  : null,
        resolvedTime: null,
        resolutionNote: null
    };

    sosLog.unshift(event);

    /* "Pause this trip?" ON → move the trip to Paused and surface Resume. */
    if (pauseTrip) {
        setTripPaused(true, event.id);
    }

    updateSosBadge();
    renderTimelineEvents();

    /* Reset form (toggle returns to its default ON state) */
    $('#td2SosCheckboxes input').prop('checked', false);
    $('#td2SosManual').val('');
    $('#td2SosPauseToggle').prop('checked', true);
    if (sosMapEditing) { setSosMapEditing(false); }   /* leave edit mode */
    $('#td2SosPanel').removeClass('show');

    Toast.fire({
        icon : 'success',
        title: pauseTrip
            ? 'SOS reported — trip paused: ' + selected.join(', ')
            : 'SOS reported: ' + selected.join(', ')
    });
});

/* Close the SOS slide panel when the in-panel Resume button opens the modal */
$('#td2SosResumeBtn').on('click', function () {
    $('#td2SosPanel').removeClass('show');
});

/* ── Resolve SOS event (delegated — history list) ── */
$(document).on('click', '.td2-sos-event-resolve-btn', function () {
    var id   = parseInt($(this).data('id'), 10);
    var now  = new Date();
    var ts   = ('0'+now.getDate()).slice(-2) + '/' +
               ('0'+(now.getMonth()+1)).slice(-2) + '/' + now.getFullYear() +
               ' ' + ('0'+now.getHours()).slice(-2) + ':' + ('0'+now.getMinutes()).slice(-2);

    var ev = sosLog.find(function (e) { return e.id === id; });
    if (ev) {
        ev.status       = 'Resolved';
        ev.resolvedBy   = tripConfig.userRole;
        ev.resolvedTime = ts;
    }
    updateSosBadge();
    renderSosHistory();
    renderTimelineEvents();
    Toast.fire({ icon: 'success', title: 'SOS marked as resolved.' });
});

/* =============================================================
   RESUME TRIP MODAL (prototype — client-side)
   ─────────────────────────────────────────────────────────────
   Date/Time/Note + a further-action choice (resume only / change
   vehicle / driver / both) + a mandatory reason. On confirm the
   active SOS is resolved, the trip is un-paused, and the action is
   recorded on the SOS timeline.
   ============================================================= */

/* Show/hide the vehicle + driver selects based on the chosen action */
function syncResumeActionFields() {
    var action = $('#resumeTripForm input[name="resume_action"]:checked').val();
    var needVehicle = (action === 'change_vehicle' || action === 'change_both');
    var needDriver  = (action === 'change_driver'  || action === 'change_both');
    $('#td2ResumeVehicleWrap').toggleClass('d-none', !needVehicle);
    $('#td2ResumeDriverWrap').toggleClass('d-none', !needDriver);
}

function clearResumeErrors() {
    $('#resumeTripForm .td2-resume-err').text('');
}

/* Reset the vehicle-allocation picker (suggested cards + Add/Allocate) to a clean state */
function resumeVehReset() {
    $('input[name="td2ResumeVehSelect"]').prop('checked', false);
    $('#td2ResumeOwnVehSelect, #td2ResumeExtVehicleSelect, #td2ResumeExtVendorSelect').val('');
    $('#td2ResumeOwnVeh').prop('checked', true);
    $('.td2-resume-if-own').show();
    $('.td2-resume-if-ext').hide();
    $('#td2ResumeAssignedVehicle').val('');
    $('#td2ResumeAssignWrap').addClass('d-none').removeAttr('data-reg');
    $('#td2ResumeAssignPick').html('');
    $('#td2ResumeAssignBtn').prop('disabled', false)
        .html('<i class="uil uil-check me-1"></i> Assign Vehicle');
}

/* Reset the driver picker (selected driver's assigned-vehicle card) to a clean state */
function resumeDriverReset() {
    $('#td2ResumeDriverVehWrap').addClass('d-none');
    $('.td2-resume-driver-veh-card').addClass('d-none');
}

/* A driver was picked → reveal that driver's currently-assigned vehicle card
   (mirrors the Vehicle Allocation tab's selected-vehicle summary). */
$(document).on('change', '#td2ResumeDriverSelect', function () {
    var key = $(this).find('option:selected').attr('data-driver-key') || '';
    $('.td2-resume-driver-veh-card').addClass('d-none');
    if (key) {
        $('.td2-resume-driver-veh-card[data-driver-key="' + key + '"]').removeClass('d-none');
        $('#td2ResumeDriverVehWrap').removeClass('d-none');
        $('#resumeTripForm .td2-resume-err[data-for="driver"]').text('');
    } else {
        $('#td2ResumeDriverVehWrap').addClass('d-none');
    }
});

/* Own / External toggle — scoped to the Resume modal */
$(document).on('change', '.td2-resume-own-veh', function () {
    $('.td2-resume-if-own').show();
    $('.td2-resume-if-ext').hide();
});
$(document).on('change', '.td2-resume-ext-veh', function () {
    $('.td2-resume-if-own').hide();
    $('.td2-resume-if-ext').show();
});

/* A vehicle was picked (suggested card OR own/external select) → reveal Assign button.
   No nested modal opens — the user just confirms with the inline Assign button. */
$(document).on('change', '.td2-resume-veh-pick', function () {
    var reg;
    if ($(this).is('input[type="radio"]')) {
        reg = $(this).val();
        $('#td2ResumeOwnVehSelect, #td2ResumeExtVehicleSelect').val('');
    } else {
        reg = $(this).val();
        $('input[name="td2ResumeVehSelect"]').prop('checked', false);
        if (this.id === 'td2ResumeOwnVehSelect') { $('#td2ResumeExtVehicleSelect').val(''); }
        else { $('#td2ResumeOwnVehSelect').val(''); }
    }

    /* A new pick invalidates any previous assignment */
    $('#td2ResumeAssignedVehicle').val('');
    $('#td2ResumeAssignBtn').prop('disabled', false)
        .html('<i class="uil uil-check me-1"></i> Assign Vehicle');

    if (reg) {
        $('#td2ResumeAssignPick').html('Selected: <strong>' + reg + '</strong>');
        $('#td2ResumeAssignWrap').removeClass('d-none').attr('data-reg', reg);
        $('#resumeTripForm .td2-resume-err[data-for="vehicle"]').text('');
    } else {
        $('#td2ResumeAssignWrap').addClass('d-none').removeAttr('data-reg');
    }
});

/* Assign the picked vehicle to the resume (prototype — client side only) */
$(document).on('click', '#td2ResumeAssignBtn', function () {
    var reg = $('#td2ResumeAssignWrap').attr('data-reg') || '';
    if (!reg) { return; }
    $('#td2ResumeAssignedVehicle').val(reg);
    $(this).prop('disabled', true)
        .html('<i class="uil uil-check-circle me-1"></i> Assigned · ' + reg);
    $('#resumeTripForm .td2-resume-err[data-for="vehicle"]').text('');
    Toast.fire({ icon: 'success', title: 'Vehicle assigned.' });
});

/* Prep modal each time it opens */
$(document).on('shown.bs.modal', '#resumeTripModal', function () {
    var n = new Date();
    $('#td2ResumeDate').val(n.getFullYear() + '-' +
        ('0'+(n.getMonth()+1)).slice(-2) + '-' + ('0'+n.getDate()).slice(-2));
    $('#td2ResumeTime').val(('0'+n.getHours()).slice(-2) + ':' + ('0'+n.getMinutes()).slice(-2));

    /* Reset to "Resume only" and hide the conditional allocation fields */
    $('#resumeTripForm input[name="resume_action"][value="resume_only"]').prop('checked', true);
    $('#td2ResumeReason').val('');
    $('#td2ResumeNote').val('');
    clearResumeErrors();
    resumeVehReset();
    resumeDriverReset();
    syncResumeActionFields();

    /* Select2 inside the modal needs dropdownParent (frontend skill PART 7) */
    $('.select2-modal', this).each(function () {
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({ dropdownParent: $('#resumeTripModal'), width: '100%' });
        }
        $(this).val('').trigger('change');
    });
});

$(document).on('change', '#resumeTripForm input[name="resume_action"]', syncResumeActionFields);

/* Confirm resume */
$(document).on('click', '.td2-resume-confirm-btn', function () {
    clearResumeErrors();

    var action = $('#resumeTripForm input[name="resume_action"]:checked').val();
    var reason = $.trim($('#td2ResumeReason').val());
    var vehicle = $('#td2ResumeAssignedVehicle').val();
    var driver  = $('#td2ResumeDriverSelect').val();
    var ok = true;

    if (!reason) {
        $('#resumeTripForm .td2-resume-err[data-for="reason"]').text('Reason is required.');
        ok = false;
    }
    if ((action === 'change_vehicle' || action === 'change_both') && !vehicle) {
        $('#resumeTripForm .td2-resume-err[data-for="vehicle"]').text('Please select a vehicle and click Assign.');
        ok = false;
    }
    if ((action === 'change_driver' || action === 'change_both') && !driver) {
        $('#resumeTripForm .td2-resume-err[data-for="driver"]').text('Please select the new driver.');
        ok = false;
    }
    if (!ok) { return; }

    /* Build a human-readable summary of the resume action */
    var actionLabels = {
        resume_only   : 'Resumed (no change)',
        change_vehicle: 'Resumed + changed vehicle',
        change_driver : 'Resumed + changed driver',
        change_both   : 'Resumed + changed vehicle & driver'
    };
    var parts = [actionLabels[action] || 'Resumed'];
    if (vehicle && (action === 'change_vehicle' || action === 'change_both')) { parts.push('Vehicle → ' + vehicle); }
    if (driver  && (action === 'change_driver'  || action === 'change_both')) { parts.push('Driver → ' + driver); }
    parts.push('Reason: ' + reason);
    var note = $.trim($('#td2ResumeNote').val());
    if (note) { parts.push('Note: ' + note); }
    var summary = parts.join(' · ');

    /* Resolve the SOS that paused the trip and record the resume on its timeline */
    var ev = sosLog.find(function (e) { return e.id === activeSos; });
    if (ev) {
        ev.status         = 'Resolved';
        ev.resolvedBy     = tripConfig.userRole;
        ev.resolvedTime   = td2Now();
        ev.resolutionNote = summary;
    }

    setTripPaused(false);
    updateSosBadge();
    renderSosHistory();
    renderTimelineEvents();

    var modalEl = document.getElementById('resumeTripModal');
    if (modalEl) {
        (bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl)).hide();
    }

    Toast.fire({ icon: 'success', title: 'Trip resumed.' });
});

/* ── Update badge + FAB pulse ── */
function updateSosBadge() {
    var active = sosLog.filter(function (e) { return e.status === 'Active'; }).length;
    var $badge = $('#td2SosBadge');
    var $btn   = $('#td2SosFabBtn');

    if (active > 0) {
        $badge.text(active).removeClass('d-none');
        $btn.addClass('td2-sos-active');
        $('#td2SosActiveAlert').removeClass('d-none');
        $('#td2SosActiveText').text(active + ' active SOS on this trip');
    } else {
        $badge.addClass('d-none');
        $btn.removeClass('td2-sos-active');
        $('#td2SosActiveAlert').addClass('d-none');
    }
}

/* ── Render SOS history modal ── */
function renderSosHistory() {
    var active   = sosLog.filter(function (e) { return e.status === 'Active'; }).length;
    var resolved = sosLog.filter(function (e) { return e.status === 'Resolved'; }).length;

    $('#td2SosStatActive').text(active);
    $('#td2SosStatResolved').text(resolved);
    $('#td2SosStatTotal').text(sosLog.length);

    var $list = $('#td2SosHistoryList');

    if (!sosLog.length) {
        $list.html('<div class="td2-sos-empty-state" id="td2SosEmptyState">' +
            '<i class="uil uil-shield-check"></i>' +
            '<p>No SOS incidents reported on this trip.</p></div>');
        return;
    }

    var html = '';
    $.each(sosLog, function (i, ev) {
        var isResolved = (ev.status === 'Resolved');
        var tagHtml = '';
        $.each(ev.tags, function (j, tag) {
            tagHtml += '<span class="td2-sos-event-tag">' + $('<span>').text(tag).html() + '</span>';
        });

        var statusHtml = isResolved
            ? '<span class="td2-sos-event-status td2-sos-status-resolved"><i class="uil uil-check-circle"></i> Resolved</span>'
            : '<span class="td2-sos-event-status td2-sos-status-active"><i class="uil uil-exclamation-circle"></i> Active</span>';

        var resolveBtn = !isResolved
            ? '<button class="td2-sos-event-resolve-btn" data-id="' + ev.id + '" type="button">Mark Resolved</button>'
            : '';

        var resolutionHtml = isResolved
            ? '<div class="td2-sos-event-resolution"><strong>Resolved by ' + ev.resolvedBy + '</strong> at ' + ev.resolvedTime +
              (ev.resolutionNote ? '<br>' + $('<span>').text(ev.resolutionNote).html() : '') + '</div>'
            : '';

        html += '<div class="td2-sos-event ' + (isResolved ? 'td2-sos-resolved' : '') + '">' +
            '<div class="td2-sos-event-header">' +
                '<div class="td2-sos-event-tags">' + tagHtml + '</div>' +
                statusHtml + resolveBtn +
            '</div>' +
            '<div class="td2-sos-event-body">' +
                '<div class="td2-sos-event-meta">Reported by <strong>' + ev.reporter + '</strong> at ' + ev.time + '</div>' +
                (ev.manual ? '<p class="td2-sos-event-note">"' + $('<span>').text(ev.manual).html() + '"</p>' : '') +
                resolutionHtml +
            '</div>' +
        '</div>';
    });

    $list.html(html);
}

/* =============================================================
   STATUS TIMELINE — inject SOS / Resume events
   ─────────────────────────────────────────────────────────────
   The Vehicle Status tab (#td2StatusTimeline) is lazy-loaded, so
   this runs on every SOS / resume / resolve AND when the tab
   mounts (td2:tab-loaded). It is idempotent: clears prior dynamic
   entries (.td2-tl-dynamic) and re-appends from sosLog.
   ============================================================= */
function td2Esc(s) { return $('<span>').text(s == null ? '' : s).html(); }

function tlEntry(kind, icon, title, badge, time, note) {
    var markerCls = (kind === 'sos') ? 'td2-tl-marker-sos' : 'td2-tl-marker-resume';
    return '<div class="td2-tl-item td2-tl-dynamic td2-tl-' + kind + '">' +
        '<span class="td2-tl-marker ' + markerCls + '"><i class="uil ' + icon + '"></i></span>' +
        '<div class="td2-tl-body">' +
            '<div class="td2-tl-head">' +
                '<span class="td2-tl-title">' + td2Esc(title) + '</span>' +
                (badge ? '<span class="td2-tl-badge td2-tl-badge-sos">' + td2Esc(badge) + '</span>' : '') +
                '<span class="td2-tl-time">' + td2Esc(time) + '</span>' +
            '</div>' +
            (note ? '<p class="td2-tl-note">' + td2Esc(note) + '</p>' : '') +
        '</div>' +
    '</div>';
}

function renderTimelineEvents() {
    var $tl = $('#td2StatusTimeline');
    if (!$tl.length) { return; }              /* Vehicle Status tab not mounted yet */
    $tl.find('.td2-tl-dynamic').remove();      /* clear prior dynamic entries */

    var html = '';
    /* sosLog is newest-first; render oldest → newest so the timeline reads chronologically */
    for (var i = sosLog.length - 1; i >= 0; i--) {
        var ev = sosLog[i];
        var incidents = $.grep(ev.tags, function (t) { return t.charAt(0) === '#'; }).join(', ');
        var sosNote   = incidents + (ev.manual ? ' — "' + ev.manual + '"' : '');

        html += tlEntry('sos', 'uil-exclamation-triangle', 'SOS Reported',
            ev.pausesTrip ? 'Trip paused' : '',
            'Reported by ' + ev.reporter + ' · ' + ev.time,
            sosNote);

        if (ev.status === 'Resolved') {
            var isResume = !!ev.resolutionNote;
            html += tlEntry('resume', isResume ? 'uil-play-circle' : 'uil-check-circle',
                isResume ? 'Trip Resumed' : 'SOS Resolved', '',
                (isResume ? 'Resumed by ' : 'Resolved by ') + ev.resolvedBy + ' · ' + ev.resolvedTime,
                isResume ? ev.resolutionNote : null);
        }
    }
    $tl.append(html);
}

/* Re-render the timeline when the Vehicle Status tab mounts (lazy-loaded) */
$(document).on('td2:tab-loaded', function (e, key) {
    if (key === 'vehStatus') { renderTimelineEvents(); }
});

/* =============================================================
   TAB PERSISTENCE — remember last active tab across page refresh
   sessionStorage key is scoped to the trip URL so each trip
   remembers its own active tab independently.
   ============================================================= */
var TAB_STORAGE_KEY = 'td2_active_tab_' + window.location.pathname;

/* Save active tab whenever the user switches */
$(document).on('shown.bs.tab', '#td2Tab button[data-bs-toggle="pill"]', function () {
    sessionStorage.setItem(TAB_STORAGE_KEY, $(this).attr('data-bs-target'));
});

/**
 * Restore the last active tab after conditional visibility rules have run.
 * Only restores if the saved tab button is still visible (not hidden by rules).
 */
function restoreActiveTab() {
    var saved = sessionStorage.getItem(TAB_STORAGE_KEY);
    if (!saved) { return; }

    var $btn = $('#td2Tab button[data-bs-target="' + saved + '"]');

    /* Guard: tab must exist and its <li> must be visible after rule application */
    if ($btn.length && $btn.closest('li').is(':visible')) {
        var tabInstance = new bootstrap.Tab($btn[0]);
        tabInstance.show();
    }
}

/* =============================================================
   DOM READY
   ============================================================= */
$(document).ready(function () {

    /* Apply all conditional visibility rules on page load */
    applyConditionalVisibility();

    /* Restore last active tab AFTER visibility rules so hidden tabs are not restored */
    restoreActiveTab();

    /* Initialise Bootstrap tooltips */
    var tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });

    /* Searchable dropdowns — Add / Allocate Vehicle section (Select2) */
    $('#td2OwnVehSelect').select2({ placeholder: 'Select vehicle...', width: '100%', allowClear: true });
    $('#td2ExtVendorSelect').select2({ placeholder: 'Select vendor...', width: '100%', allowClear: true });
    $('#td2ExtVehicleSelect').select2({ placeholder: 'Select vehicle...', width: '100%', allowClear: true });

});

/* =============================================================
   EWAY + LR — Unassigned E-Ways modal (#addEwayTable)
   Select-all + live "Selected" count and "Selected Quantity".
   ============================================================= */
function td2EwayRefreshSummary() {
    /* Only count data rows (exclude the empty-state row) */
    var $rows = $('#td2EwayTable tbody tr:visible').not('.td2-eway-empty-row');
    var $checked = $rows.find('.td2-eway-row-check:checked');
    var qty = 0;
    $checked.each(function () { qty += parseFloat($(this).data('qty')) || 0; });

    $('#td2EwayTotal').text($rows.length);
    $('#td2EwaySelected').text($checked.length);
    $('#td2EwaySelQty').text(qty.toFixed(2));

    /* Highlight selected rows */
    $rows.removeClass('td2-eway-selected');
    $checked.closest('tr').addClass('td2-eway-selected');

    /* Keep the header checkbox in sync with the visible rows */
    var $allRowChecks = $rows.find('.td2-eway-row-check');
    $('#td2EwayCheckAll').prop('checked', $allRowChecks.length > 0 && $checked.length === $allRowChecks.length);
    $('#td2EwayCheckAll').prop('disabled', $allRowChecks.length === 0);
}

/* Combined filter — search text + status. Hides non-matching rows,
   shows the empty-state row when nothing matches, then recomputes summary. */
function td2EwayApplyFilters() {
    var term   = $.trim(($('#td2EwaySearch').val() || '')).toLowerCase();
    var status = $('#td2EwayStatusFilter').val();
    var shown  = 0;

    $('#td2EwayTable tbody tr').not('.td2-eway-empty-row').each(function () {
        var $row = $(this);
        var statusOk = !status || $row.data('status') === status;
        var textOk   = !term || $row.text().toLowerCase().indexOf(term) !== -1;
        var match    = statusOk && textOk;

        $row.toggle(match);
        if (!match) { $row.find('.td2-eway-row-check').prop('checked', false); }
        if (match)  { shown++; }
    });

    $('#td2EwayEmptyRow').prop('hidden', shown !== 0).toggle(shown === 0);
    td2EwayRefreshSummary();
}

/* Header select-all toggles every visible data row */
$(document).on('change', '#td2EwayCheckAll', function () {
    var on = $(this).is(':checked');
    $('#td2EwayTable tbody tr:visible').not('.td2-eway-empty-row')
        .find('.td2-eway-row-check').prop('checked', on);
    td2EwayRefreshSummary();
});

/* Any row checkbox change updates the summary */
$(document).on('change', '.td2-eway-row-check', td2EwayRefreshSummary);

/* Search + status filter inputs */
$(document).on('input', '#td2EwaySearch', td2EwayApplyFilters);
$(document).on('change', '#td2EwayStatusFilter', td2EwayApplyFilters);

/* Reset filters */
$(document).on('click', '#td2EwayResetFilters', function () {
    $('#td2EwaySearch').val('');
    $('#td2EwayStatusFilter').val('');
    td2EwayApplyFilters();
});

/* Reset filters + summary each time the modal opens */
$(document).on('shown.bs.modal', '#addEwayTable', function () {
    $('#td2EwaySearch').val('');
    $('#td2EwayStatusFilter').val('');
    td2EwayApplyFilters();
});

/* Add to Trip */
$(document).on('click', '#td2EwayAddToTrip', function () {
    var n = $('#td2EwayTable tbody .td2-eway-row-check:checked').length;
    if (n === 0) {
        Toast.fire({ icon: 'error', title: 'Select at least one e-way.' });
        return;
    }
    var modalEl = document.getElementById('addEwayTable');
    if (modalEl) {
        (bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl)).hide();
    }
    Toast.fire({ icon: 'success', title: n + ' e-way(s) added to trip.' });
});

/* =============================================================
   EWAY + LR — Add Eway form modal (#addEwayForm)
   ============================================================= */
$(document).on('shown.bs.modal', '#addEwayForm', function () {
    $('.select2-modal', this).select2({ dropdownParent: $(this), width: '100%' });
});

function td2ClearEwayFormErrors() {
    $('#addEwayFormEl .td2-eway-err').text('');
}

$(document).on('submit', '#addEwayFormEl', function (e) {
    e.preventDefault();
    td2ClearEwayFormErrors();

    var gstin   = $('#td2EwayGstin').val();
    var billNos = $.trim($('#td2EwayBillNos').val());
    var ok = true;

    if (!gstin) {
        $('#addEwayFormEl .td2-eway-err[data-for="gstin"]').text('GSTIN is required.');
        ok = false;
    }
    if (!billNos) {
        $('#addEwayFormEl .td2-eway-err[data-for="eway_bill_numbers"]').text('Enter at least one e-way bill number.');
        ok = false;
    }
    if (!ok) { return; }

    /* Prototype: no backend yet — confirm + reset + return to the table modal */
    var modalEl = document.getElementById('addEwayForm');
    if (modalEl) {
        (bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl)).hide();
    }
    this.reset();
    if ($('#td2EwayGstin').hasClass('select2-hidden-accessible')) { $('#td2EwayGstin').val('').trigger('change'); }
    Toast.fire({ icon: 'success', title: 'Eway saved.' });
});

/* =============================================================
   ADD POD — LR-POD modal (#addPOD)  [v5.5 | 2026-06-17]
   Select2 init + attachment dropzone/preview + prototype submit.
   ============================================================= */
$(document).on('shown.bs.modal', '#addPOD', function () {
    $('.select2-modal', this).select2({ dropdownParent: $(this), width: '100%' });
});

function td2PodHumanSize(bytes) {
    if (bytes >= 1048576) { return (bytes / 1048576).toFixed(1) + ' MB'; }
    if (bytes >= 1024)    { return (bytes / 1024).toFixed(1) + ' KB'; }
    return bytes + ' B';
}

/* Render the preview grid from the file input + toggle the drop prompt */
function td2PodRenderPreview() {
    var input    = document.getElementById('td2PodFiles');
    var $preview = $('#td2PodPreview').empty();
    var files    = input && input.files ? input.files : [];

    Array.prototype.forEach.call(files, function (file) {
        var $pip = $('<span class="td2-pip"></span>');
        if (file.type && file.type.indexOf('image/') === 0) {
            $pip.append('<img class="td2-image-thumb" src="' + URL.createObjectURL(file) + '" alt="">');
        } else {
            $pip.append('<span class="td2-pip-fileicon"><i class="uil uil-file-alt"></i></span>');
        }
        $pip.append(
            '<div class="td2-file-name-wrap"><p>' + $('<div>').text(file.name).html() +
            '</p><small>' + td2PodHumanSize(file.size) + '</small></div>'
        );
        $pip.append('<span class="td2-file-remove" title="Remove"><i class="uil uil-trash-alt"></i></span>');
        $preview.append($pip);
    });

    $('#td2PodDzPrompt').toggle(files.length === 0);
}

$(document).on('change', '#td2PodFiles', td2PodRenderPreview);

/* Remove a previewed attachment (rebuilds the input FileList) */
$(document).on('click', '#td2PodPreview .td2-file-remove', function () {
    var idx   = $(this).closest('.td2-pip').index();
    var input = document.getElementById('td2PodFiles');
    var dt    = new DataTransfer();
    Array.prototype.forEach.call(input.files, function (f, i) { if (i !== idx) { dt.items.add(f); } });
    input.files = dt.files;
    td2PodRenderPreview();
});

/* Drag & drop onto the dropzone */
(function () {
    function dz() { return document.getElementById('td2PodDropzone'); }
    $(document).on('dragover dragenter', '#td2PodDropzone', function (e) {
        e.preventDefault(); e.stopPropagation();
        $(this).addClass('is-dragover');
    });
    $(document).on('dragleave dragend', '#td2PodDropzone', function (e) {
        e.preventDefault(); e.stopPropagation();
        $(this).removeClass('is-dragover');
    });
    $(document).on('drop', '#td2PodDropzone', function (e) {
        e.preventDefault(); e.stopPropagation();
        $(this).removeClass('is-dragover');
        var dropped = e.originalEvent.dataTransfer.files;
        if (!dropped || !dropped.length) { return; }
        var input = document.getElementById('td2PodFiles');
        var dt    = new DataTransfer();
        Array.prototype.forEach.call(input.files, function (f) { dt.items.add(f); });
        Array.prototype.forEach.call(dropped,     function (f) { dt.items.add(f); });
        input.files = dt.files;
        td2PodRenderPreview();
    });
})();

/* Prototype submit: no backend yet — validate required ack, confirm, reset */
$(document).on('submit', '#td2PodForm', function (e) {
    e.preventDefault();

    if (!$('#td2PodAck').val()) {
        Toast.fire({ icon: 'error', title: 'Please select an acknowledgement.' });
        return;
    }

    var modalEl = document.getElementById('addPOD');
    if (modalEl) {
        (bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl)).hide();
    }
    this.reset();
    $('#td2PodPreview').empty();
    $('#td2PodDzPrompt').show();
    if ($('#td2PodAck').hasClass('select2-hidden-accessible')) { $('#td2PodAck').val('').trigger('change'); }
    Toast.fire({ icon: 'success', title: 'POD saved.' });
});

/* =============================================================
   ADD EXPENSE MODAL (#addExpense — Expenses tab)
   Expense Head supports selecting an existing head OR typing a new
   one (Select2 tags: true). Date & Time uses the single-date +
   time daterangepicker. Prototype only — no persistence (SD-1: all
   logic lives here, not inline in the blade).
   ============================================================= */
$(document).on('shown.bs.modal', '#addExpense', function () {
    var $head = $('#td2AddExpenseHead');
    if ($head.length && !$head.hasClass('select2-hidden-accessible')) {
        $head.select2({
            dropdownParent: $(this),
            width: '100%',
            tags: true,
            placeholder: 'Select or add an expense head',
            allowClear: true
        });
    }

    /* Date & Time — single date + time picker (daterangepicker, already
       loaded in layouts.app). */
    var $expDate = $('#td2AddExpenseDate');
    if ($expDate.length && typeof $.fn.daterangepicker === 'function' && !$expDate.data('daterangepicker')) {
        $expDate.daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: false,
            timePickerIncrement: 1,
            autoUpdateInput: false,
            parentEl: '#addExpense',
            locale: { format: 'DD MMM YYYY, hh:mm A', cancelLabel: 'Clear' }
        });
        $expDate.on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD MMM YYYY, hh:mm A'));
        });
        $expDate.on('cancel.daterangepicker', function () {
            $(this).val('');
        });
    }
});

/* Save (prototype) — Toast + reset, no persistence per "nothing dynamic". */
$(document).on('click', '.td2-add-exp-save', function () {
    Toast.fire({ icon: 'success', title: 'Expense added (prototype).' });
    $('#addExpense').modal('hide');
    if ($('#addExpenseForm').length) { $('#addExpenseForm')[0].reset(); }
    if ($('#td2AddExpenseHead').hasClass('select2-hidden-accessible')) {
        $('#td2AddExpenseHead').val('').trigger('change');
    }
    $('#td2AddExpenseDate').val('');
});
