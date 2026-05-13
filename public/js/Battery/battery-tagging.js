/**
 * Battery Tagging Page — SR Logistics
 * SD-1:  No inline JS in blade
 * SD-3:  $.ajax() only — no fetch()
 * SD-4:  Errors as <span class="text-danger"> below field
 * SD-7:  Toast mixin for all notifications
 * SD-8:  No findOrFail() in AJAX (backend)
 * SD-9:  HTTP status codes on every response (backend)
 * v2.2  — Condition-triggered AJAX for SR Warehouse battery list; RAG Status removed
 */

/* ── Toast mixin (SD-7) ─────────────────────────────────────────────── */
const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

/* ── Validation helpers (SD-4) ──────────────────────────────────────── */
function showValidationErrors(errors) {
    clearValidationErrors();
    $.each(errors, function (field, messages) {
        // Try named error span first (e.g. #err_battery_brand)
        var $errSpan = $('#err_' + field);
        if ($errSpan.length) {
            $errSpan.text(messages[0]);
            return;
        }
        // Fallback: insert after input
        var $input = $('#tagBatteryModal [name="' + field + '"]');
        if ($input.length) {
            $('<span class="text-danger small d-block mt-1 field-error">'
                + messages[0] + '</span>').insertAfter($input);
        }
    });
    // Scroll to first error
    var $firstErr = $('#tagBatteryModal .field-error:visible').first();
    if ($firstErr.length) {
        $('#tagBatteryModal .modal-body').animate({
            scrollTop: $firstErr.offset().top - 160
        }, 300);
    }
}

function clearValidationErrors() {
    // Remove dynamically inserted spans
    $('.field-error').not('[id]').remove();
    // Clear named error spans
    $('[id^="err_"]').text('');
}

/* ── Source Toggle ──────────────────────────────────────────────────── */
function applySourceToggle() {
    var src = $('input[name="battery_source"]:checked').val();
    if (src === 'SR Warehouse') {
        $('#srcWarehouseSection').removeClass('d-none');
        $('#srcDirectSection').addClass('d-none');
        // Direct fields are disabled so they won't serialize
        $('#srcDirectSection input, #srcDirectSection select').prop('disabled', true);
        $('#srcWarehouseSection select, #srcWarehouseSection input').prop('disabled', false);
        // Warehouse battery select stays disabled until condition chosen
        reloadWarehouseBatteries();
    } else {
        $('#srcDirectSection').removeClass('d-none');
        $('#srcWarehouseSection').addClass('d-none');
        $('#srcWarehouseSection input, #srcWarehouseSection select').prop('disabled', true);
        $('#srcDirectSection input, #srcDirectSection select').prop('disabled', false);
        // Clear warehouse select
        $('#warehouseBatterySelect').val('').prop('disabled', true);
        $('#wh_batteryBrand').val('');
        $('#wh_batterySerial').val('');
    }
}

$(document).on('change', 'input[name="battery_source"]', function () {
    applySourceToggle();
});

/* ── Warehouse Battery Loader ───────────────────────────────────────── */
function reloadWarehouseBatteries() {
    var condition = $('#batteryConditionSelect').val();
    var $select   = $('#warehouseBatterySelect');
    var $stateMsg = $('#batteryDropdownState');
    var availUrl  = $('#tagBatteryForm').data('available-url');

    // Reset auto-fill
    $('#wh_batteryBrand').val('');
    $('#wh_batterySerial').val('');

    if (!condition) {
        $select.prop('disabled', true)
               .html('<option value="">— Select condition first —</option>');
        $stateMsg.text('Select a Battery Condition above to load available stock.');
        return;
    }

    $select.prop('disabled', true)
           .html('<option value="">Loading…</option>');
    $stateMsg.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading batteries…');

    $.ajax({
        url    : availUrl,
        method : 'GET',
        data   : { condition: condition },
        headers: { 'Accept': 'application/json' },
        success: function (res) {
            if (!res.batteries || res.batteries.length === 0) {
                $select.html('<option value="">— No batteries in stock for this condition —</option>');
                $stateMsg.text('No batteries in stock for the selected condition.');
                return;
            }
            var opts = '<option value="">— Select a battery —</option>';
            $.each(res.batteries, function (i, b) {
                opts += '<option value="' + b.id + '"'
                      + ' data-brand="'   + $('<div>').text(b.brand).html()   + '"'
                      + ' data-serial="'  + $('<div>').text(b.serial).html()  + '"'
                      + ' data-model="'   + $('<div>').text(b.model).html()   + '"'
                      + ' data-capacity="'+ $('<div>').text(b.capacity).html()+ '"'
                      + ' data-voltage="' + $('<div>').text(b.voltage).html() + '"'
                      + '>' + $('<div>').text(b.label).html() + '</option>';
            });
            $select.prop('disabled', false).html(opts);
            $stateMsg.text(res.batteries.length + ' batter' + (res.batteries.length === 1 ? 'y' : 'ies') + ' available.');
        },
        error  : function () {
            $select.html('<option value="">— Failed to load —</option>');
            $stateMsg.text('Could not load batteries. Please try again.');
        }
    });
}

/* Reload warehouse list whenever condition changes (SR Warehouse mode only) */
$(document).on('change', '#batteryConditionSelect', function () {
    if ($('input[name="battery_source"]:checked').val() === 'SR Warehouse') {
        reloadWarehouseBatteries();
    }
});

/* When a warehouse battery is selected, auto-fill Brand + Serial */
$(document).on('change', '#warehouseBatterySelect', function () {
    var $opt = $(this).find('option:selected');
    $('#wh_batteryBrand').val($opt.data('brand') || '');
    $('#wh_batterySerial').val($opt.data('serial') || '');
});

/* ── Attachment previews ─────────────────────────────────────────────── */
function bindPhotoPreview(inputId, previewId) {
    $(document).on('change', '#' + inputId, function () {
        var file = this.files && this.files[0];
        if (!file) {
            $('#' + previewId).addClass('d-none').find('img').attr('src', '');
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + previewId).removeClass('d-none').find('img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    });
}

bindPhotoPreview('photoSerial',   'previewSerial');
bindPhotoPreview('photoFitment',  'previewFitment');
bindPhotoPreview('photoOdometer', 'previewOdometer');

/* ── Tag Battery Form submit ────────────────────────────────────────── */
$(document).on('submit', '#tagBatteryForm', function (e) {
    e.preventDefault();
    clearValidationErrors();

    var $form = $(this);
    var $btn  = $('#btnTagBattery');
    var $text = $('#btnTagBatteryText');
    var $spin = $('#btnTagBatterySpinner');

    $text.html('Saving…');
    $spin.removeClass('d-none');
    $btn.prop('disabled', true);

    var formData = new FormData(this);

    $.ajax({
        url         : $form.attr('action'),
        method      : 'POST',
        data        : formData,
        processData : false,
        contentType : false,
        headers     : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept'      : 'application/json'
        },
        success: function (res) {
            Toast.fire({ icon: 'success', title: res.message || 'Battery tagged.' });
            setTimeout(function () { window.location.href = res.redirect; }, 1200);
        },
        error: function (xhr) {
            $btn.prop('disabled', false);
            $text.html('<i class="uil uil-battery-bolt me-1"></i>Tag Battery');
            $spin.addClass('d-none');
            if (xhr.status === 422 && xhr.responseJSON) {
                if (xhr.responseJSON.errors) {
                    showValidationErrors(xhr.responseJSON.errors);
                } else {
                    Toast.fire({ icon: 'error', title: xhr.responseJSON.message || 'Validation error.' });
                }
            } else {
                Toast.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
            }
        }
    });
});

/* ── Remove Battery ─────────────────────────────────────────────────── */
$(document).on('click', '.btn-vbt-remove-confirm', function () {
    var removeUrl = $(this).data('remove-url');
    var serialNo  = $(this).data('serial') || 'this battery';

    Swal.fire({
        title             : 'Remove Battery?',
        html              : 'Are you sure you want to remove <strong>' + serialNo + '</strong> from this vehicle?',
        icon              : 'warning',
        showCancelButton  : true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor : '#6b7280',
        confirmButtonText : 'Yes, Remove',
        cancelButtonText  : 'Cancel',
    }).then(function (result) {
        if (!result.isConfirmed) return;

        $.ajax({
            url    : removeUrl,
            method : 'POST',
            data   : { _token: $('meta[name="csrf-token"]').attr('content') },
            headers: { 'Accept': 'application/json' },
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Battery removed.' });
                setTimeout(function () { window.location.href = res.redirect; }, 1200);
            },
            error  : function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message)
                          ? xhr.responseJSON.message
                          : 'Failed to remove battery.';
                Toast.fire({ icon: 'error', title: msg });
            }
        });
    });
});

/* ── View Battery Logs (AJAX) ───────────────────────────────────────── */
$(document).on('click', '.btn-vbt-view-logs', function () {
    var logsUrl = $(this).data('logs-url');
    var serial  = $(this).data('serial') || 'Battery';
    var $modal  = $('#batteryLogsModal');

    $modal.find('#batteryLogsTitle').text('Log History — ' + serial);
    $modal.find('#batteryLogsBody').html(
        '<div class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div> Loading…</div>'
    );
    $modal.modal('show');

    $.ajax({
        url    : logsUrl,
        method : 'GET',
        headers: { 'Accept': 'application/json' },
        success: function (res) {
            if (!res.logs || res.logs.length === 0) {
                $modal.find('#batteryLogsBody').html(
                    '<p class="text-muted text-center py-3">No log entries found.</p>'
                );
                return;
            }
            var html = '';
            $.each(res.logs, function (i, log) {
                var iconClass = 'vbt-log-tagged';
                var iconChar  = 'T';
                if (log.action === 'Removed') { iconClass = 'vbt-log-removed'; iconChar = 'R'; }
                if (log.action === 'Updated') { iconClass = 'vbt-log-updated'; iconChar = 'U'; }

                html += '<div class="vbt-log-row">';
                html += '  <div class="vbt-log-icon ' + iconClass + '">' + iconChar + '</div>';
                html += '  <div class="vbt-log-meta">';
                html += '    <div class="vbt-log-action">' + log.action + '</div>';
                if (log.source && log.source !== '—') {
                    html += '    <div class="vbt-log-notes" style="font-size:0.72rem;color:#6b7280;">Source: ' + log.source + '</div>';
                }
                if (log.notes) {
                    html += '    <div class="vbt-log-notes">' + log.notes + '</div>';
                }
                html += '    <div class="vbt-log-date">' + log.created_at;
                if (log.fitment_date && log.fitment_date !== '—') {
                    html += ' · Fitment: ' + log.fitment_date;
                }
                if (log.actual_km && log.actual_km !== '—') {
                    html += ' · KM: ' + log.actual_km;
                }
                html += '</div>';
                html += '  </div>';
                html += '</div>';
            });
            $modal.find('#batteryLogsBody').html(html);
        },
        error: function () {
            $modal.find('#batteryLogsBody').html(
                '<p class="text-danger text-center py-3">Failed to load logs.</p>'
            );
        }
    });
});

/* ── Reset tag modal on close ───────────────────────────────────────── */
$('#tagBatteryModal').on('hidden.bs.modal', function () {
    var $form = $(this).find('form')[0];
    if ($form) $form.reset();
    clearValidationErrors();

    // Reset button state
    $('#btnTagBattery').prop('disabled', false);
    $('#btnTagBatteryText').html('<i class="uil uil-battery-bolt me-1"></i>Tag Battery');
    $('#btnTagBatterySpinner').addClass('d-none');

    // Reset attachment previews
    $('#previewSerial, #previewFitment, #previewOdometer').addClass('d-none').find('img').attr('src', '');

    // Reset source toggle to default
    $('#srcSRWarehouse').prop('checked', true);
    applySourceToggle();
});

/* ── Init on page load ──────────────────────────────────────────────── */
$(function () {
    applySourceToggle();
});
