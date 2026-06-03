/**
 * Trip Details v2 — show-v2.js
 * SD-1: All logic in external JS file — no inline scripts in blade.
 * SD-7: Toast mixin defined at top.
 * v3.6 | 2026-06-03 — tab persistence across page refresh
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
    var statusOrder = ['Initiated', 'Vehicle Assigned', 'Loading', 'In Transit', 'Completed'];
    var $stepper    = $('#td2Stepper');
    var s           = tripConfig.tripStatus;

    /* Map aliases to canonical status */
    if (s === 'Vehicle Not Assigned' || s === 'New')                                                      { s = 'Initiated'; }
    if (s === 'Ongoing' || s === 'Reported' || s === 'Delayed' || s === 'Detained' ||
        s === 'Unloaded' || s === 'Breakdown' || s === 'In Repair' || s === 'Accident')                  { s = 'In Transit'; }

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

/* Map / Vehicle Detail overlay — eye button or card click */
$(document).on('click', '.td2-open-map', function (e) {
    e.stopPropagation();
    closeAllOverlays();
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
$(document).on('click', '.td2-status-save-btn', function () {
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

/* ── Open / close SOS panel ── */
$('#td2SosFabBtn').on('click', function () {
    $('#td2SosPanel').addClass('show');
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

/* ── Submit SOS ── */
$('#td2SosSubmitBtn').on('click', function () {
    var selected = [];
    $('#td2SosCheckboxes input:checked').each(function () {
        selected.push('#' + $(this).val().replace(/\s/g, ''));
    });
    var manual = $.trim($('#td2SosManual').val());
    if (manual) selected.push('#Manual: ' + manual);

    if (!selected.length) {
        Toast.fire({ icon: 'warning', title: 'Select at least one incident type.' });
        return;
    }

    var now    = new Date();
    var dateStr = ('0'+now.getDate()).slice(-2) + '/' +
                  ('0'+(now.getMonth()+1)).slice(-2) + '/' + now.getFullYear() +
                  ' ' + ('0'+now.getHours()).slice(-2) + ':' + ('0'+now.getMinutes()).slice(-2);

    var event = {
        id      : Date.now(),
        tags    : selected,
        manual  : manual,
        time    : dateStr,
        reporter: 'Admin',
        status  : 'Active',
        resolvedBy  : null,
        resolvedTime: null,
        resolutionNote: null
    };

    sosLog.unshift(event);
    updateSosBadge();

    /* Reset form */
    $('#td2SosCheckboxes input').prop('checked', false);
    $('#td2SosManual').val('');
    $('#td2SosPanel').removeClass('show');

    Toast.fire({ icon: 'error', title: 'SOS reported: ' + selected.join(', ') });
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
    Toast.fire({ icon: 'success', title: 'SOS marked as resolved.' });
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
            ? '<div class="td2-sos-event-resolution"><strong>Resolved by ' + ev.resolvedBy + '</strong> at ' + ev.resolvedTime + '</div>'
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

});
