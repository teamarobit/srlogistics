/**
 * Battery Tagging Page — SR Logistics
 * SD-1:  No inline JS in blade
 * SD-3:  $.ajax() only — no fetch()
 * SD-4:  Errors as <span class="text-danger"> below field
 * SD-7:  Toast mixin for all notifications
 * SD-8:  No findOrFail() in AJAX (backend)
 * SD-9:  HTTP status codes on every response (backend)
 * v2.4  — Take Action modal (Replace Battery); History btn commented out
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

/* ── Remove Battery — disabled (button replaced by Take Action) ─────── */
/* $(document).on('click', '.btn-vbt-remove-confirm', function () { ... }); */

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

/* ══════════════════════════════════════════════════════════════════════
   TAKE ACTION MODAL — Replace Battery  (bam- prefix)
   ══════════════════════════════════════════════════════════════════════ */

/* ── BAM: clear all error spans ─────────────────────────────────────── */
function bamClearErrors() {
    $('#batteryTakeActionModal .bam-field-error').text('');
}

/* ── BAM: show validation errors ────────────────────────────────────── */
function bamShowErrors(errors) {
    bamClearErrors();
    var errorMap = {
        'replacement_reason'      : '#bamErrReason',
        'battery_condition'       : '#bamErrCondition',
        'battery_source'          : '#bamErrSource',
        'warehouse_battery_id'    : '#bamErrWarehouseBattery',
        'battery_brand'           : '#bamErrDirBrand',
        'battery_serial_number'   : '#bamErrDirSerial',
        'replacement_date'        : '#bamErrRplDate',
        'old_battery_destination' : '#bamErrOldDest',
        'old_dest_warehouse_id'   : '#bamErrOldDestWarehouse',
        'old_dest_workshop_id'    : '#bamErrOldDestWorkshop',
        'notes'                   : '#bamErrNotes',
    };
    $.each(errors, function (field, messages) {
        if (errorMap[field]) {
            $(errorMap[field]).text(messages[0]);
        }
    });
    // Scroll to first visible error
    var $first = $('#batteryTakeActionModal .bam-field-error:visible').filter(function () {
        return $(this).text().trim() !== '';
    }).first();
    if ($first.length) {
        $('#batteryTakeActionModal .modal-body').animate({
            scrollTop: $first.offset().top - 160
        }, 300);
    }
}

/* ── BAM: Source card active toggle ─────────────────────────────────── */
$(document).on('change', 'input[name="battery_source"]', function () {
    var src = $(this).val();
    // Update card active state
    $('#bamSourceGrid .bam-source-card').removeClass('active');
    $(this).closest('.bam-source-card').addClass('active');
    // Show/hide panels
    $('#bamPanelWarehouse').removeClass('active');
    $('#bamPanelDirect').removeClass('active');
    if (src === 'SR Warehouse') {
        $('#bamPanelWarehouse').addClass('active');
        $('#bamPanelDirect input, #bamPanelDirect select').prop('disabled', true);
        $('#bamPanelWarehouse select, #bamPanelWarehouse input').prop('disabled', false);
        bamReloadWarehouseBatteries();
    } else {
        $('#bamPanelDirect').addClass('active');
        $('#bamPanelWarehouse input, #bamPanelWarehouse select').prop('disabled', true);
        $('#bamPanelDirect input, #bamPanelDirect select').prop('disabled', false);
        $('#bamWarehouseBatterySelect').val('').prop('disabled', true);
        $('#bamWhBrand').val('');
        $('#bamWhSerial').val('');
    }
});

/* ── BAM: Reload warehouse batteries via AJAX ───────────────────────── */
function bamReloadWarehouseBatteries() {
    var condition  = $('#bamConditionSelect').val();
    var $select    = $('#bamWarehouseBatterySelect');
    var $stateMsg  = $('#bamBatteryDropdownState');
    var availUrl   = $('#batteryTakeActionModal').data('available-url');

    $('#bamWhBrand').val('');
    $('#bamWhSerial').val('');

    if (!condition) {
        $select.prop('disabled', true)
               .html('<option value="">— Select condition first —</option>');
        $stateMsg.text('Select a Battery Condition above to load available stock.');
        return;
    }

    $select.prop('disabled', true).html('<option value="">Loading…</option>');
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
                      + ' data-brand="'  + $('<div>').text(b.brand).html()  + '"'
                      + ' data-serial="' + $('<div>').text(b.serial).html() + '"'
                      + '>' + $('<div>').text(b.label).html() + '</option>';
            });
            $select.prop('disabled', false).html(opts);
            $stateMsg.text(res.batteries.length + ' batter' + (res.batteries.length === 1 ? 'y' : 'ies') + ' available.');
        },
        error: function () {
            $select.html('<option value="">— Failed to load —</option>');
            $stateMsg.text('Could not load batteries. Please try again.');
        }
    });
}

/* Reload warehouse list when condition changes inside take action modal */
$(document).on('change', '#bamConditionSelect', function () {
    if ($('input[name="battery_source"]:checked').val() === 'SR Warehouse') {
        bamReloadWarehouseBatteries();
    }
});

/* Auto-fill brand + serial when warehouse battery selected */
$(document).on('change', '#bamWarehouseBatterySelect', function () {
    var $opt = $(this).find('option:selected');
    $('#bamWhBrand').val($opt.data('brand') || '');
    $('#bamWhSerial').val($opt.data('serial') || '');
});

/* ── BAM: Photo previews ─────────────────────────────────────────────── */
function bamBindPhotoPreview(inputId, thumbId) {
    $(document).on('change', '#' + inputId, function () {
        var file = this.files && this.files[0];
        if (!file) { $('#' + thumbId).hide().attr('src', ''); return; }
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + thumbId).attr('src', e.target.result).css('display', 'block');
        };
        reader.readAsDataURL(file);
    });
}
bamBindPhotoPreview('bamPhotoDamage',   'bamThumbDamage');
bamBindPhotoPreview('bamPhotoSerial',   'bamThumbSerial');
bamBindPhotoPreview('bamPhotoOdometer', 'bamThumbOdometer');

/* ── BAM: Populate modal header when Take Action button clicked ───────── */
$(document).on('click', '.btn-vbt-take-action', function () {
    var $btn   = $(this);
    var slot   = $btn.data('slot')   || '—';
    var serial = $btn.data('serial') || '—';
    var brand  = $btn.data('brand')  || '';
    var rag    = $btn.data('rag')    || 'grey';
    var batteryId  = $btn.data('battery-id');
    var availUrl   = $btn.data('available-url');
    var replaceUrl = $btn.data('replace-url');

    // Set header info
    $('#bamSlotLabel').text(slot);
    $('#bamSerialText').text(serial);
    $('#bamBrandText').text(brand ? '· ' + brand : '');

    // RAG badge
    var ragMap = {
        green  : { cls: 'rag-green',  txt: '🟢 Green'  },
        yellow : { cls: 'rag-yellow', txt: '🟡 Yellow' },
        red    : { cls: 'rag-red',    txt: '🔴 Red'    },
    };
    var ragInfo = ragMap[rag] || { cls: 'rag-grey', txt: '⚫ Not Set' };
    $('#bamRagBadge')
        .removeClass('rag-green rag-yellow rag-red rag-grey')
        .addClass(ragInfo.cls)
        .text(ragInfo.txt);

    // Life % and KM left
    var lifePct   = $btn.data('life-pct');
    var actualKm  = $btn.data('actual-km');
    var lifeStr   = '';
    if (lifePct !== '' && lifePct !== undefined) {
        lifeStr = lifePct + '% Life';
    }
    if (actualKm !== '' && actualKm !== undefined && actualKm > 0) {
        lifeStr += (lifeStr ? ' · ' : '') + Number(actualKm).toLocaleString('en-IN') + ' KM';
    }
    $('#bamLifeText').text(lifeStr);

    // Store URLs on modal element
    $('#batteryTakeActionModal').data('available-url', availUrl);
    $('#batteryTakeActionModal').data('replace-url', replaceUrl);

    // Populate old dest dropdowns from data store
    bamPopulateOldDestDropdowns();
});

/* ── BAM: Submit Replace Battery ────────────────────────────────────── */
$(document).on('click', '#bamRplSubmitBtn', function () {
    bamClearErrors();

    var replaceUrl = $('#batteryTakeActionModal').data('replace-url');
    var $btn       = $(this);
    var $text      = $('#bamRplSubmitText');
    var $spin      = $('#bamRplSubmitSpinner');

    $text.html('Saving…');
    $spin.removeClass('d-none');
    $btn.prop('disabled', true);

    var formData = new FormData($('#bamReplaceForm')[0]);

    $.ajax({
        url         : replaceUrl,
        method      : 'POST',
        data        : formData,
        processData : false,
        contentType : false,
        headers     : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept'      : 'application/json'
        },
        success: function (res) {
            Toast.fire({ icon: 'success', title: res.message || 'Battery replaced.' });
            setTimeout(function () { window.location.href = res.redirect; }, 1200);
        },
        error: function (xhr) {
            $btn.prop('disabled', false);
            $text.html('<i class="uil uil-exchange me-1"></i>Replace Battery');
            $spin.addClass('d-none');
            if (xhr.status === 422 && xhr.responseJSON) {
                if (xhr.responseJSON.errors) {
                    bamShowErrors(xhr.responseJSON.errors);
                } else {
                    Toast.fire({ icon: 'error', title: xhr.responseJSON.message || 'Validation error.' });
                }
            } else {
                Toast.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
            }
        }
    });
});

/* ── BAM: Reset modal on close ──────────────────────────────────────── */
$('#batteryTakeActionModal').on('hidden.bs.modal', function () {
    var $form = $('#bamReplaceForm')[0];
    if ($form) $form.reset();
    bamClearErrors();

    // Reset button state
    $('#bamRplSubmitBtn').prop('disabled', false);
    $('#bamRplSubmitText').html('<i class="uil uil-exchange me-1"></i>Replace Battery');
    $('#bamRplSubmitSpinner').addClass('d-none');

    // Reset source cards
    $('#bamSourceGrid .bam-source-card').removeClass('active');
    $('#bamPanelWarehouse, #bamPanelDirect').removeClass('active');
    $('#bamWarehouseBatterySelect').prop('disabled', true)
        .html('<option value="">— Select condition first —</option>');
    $('#bamWhBrand').val('');
    $('#bamWhSerial').val('');
    $('#bamBatteryDropdownState').text('Select a Battery Condition above to load available stock.');

    // Reset photo thumbs
    $('#bamThumbDamage, #bamThumbSerial, #bamThumbOdometer').hide().attr('src', '');

    // Reset header
    $('#bamSlotLabel').text('—');
    $('#bamSerialText').text('—');
    $('#bamBrandText').text('');
    $('#bamLifeText').text('');
    $('#bamRagBadge').removeClass('rag-green rag-yellow rag-red').addClass('rag-grey').text('⚫ Not Set');

    // Reset old battery destination
    $('#bamOldDestGrid .bam-old-dest-pill').removeClass('active');
    $('input[name="old_battery_destination"]').prop('checked', false);
    $('#bamOldDestWarehouseWrap, #bamOldDestWorkshopWrap').addClass('d-none');
    $('#bamOldDestWarehouseId, #bamOldDestWorkshopId').val('');
    $('#bamErrOldDest, #bamErrOldDestWarehouse, #bamErrOldDestWorkshop').text('');

    // Reset notes
    $('#bamNotes').val('').attr('placeholder', 'Add any notes or remarks…');
    $('#bamNotesScrapHint').addClass('d-none');
    $('#bamErrNotes').text('');
});

/* ── BAM: Populate old dest dropdowns from data store ────────────── */
function bamPopulateOldDestDropdowns() {
    var $store     = $('#bamDataStore');
    var warehouses = [];
    var workshops  = [];

    try { warehouses = JSON.parse($store.attr('data-warehouses') || '[]'); } catch(e) {}
    try { workshops  = JSON.parse($store.attr('data-workshops')  || '[]'); } catch(e) {}

    var $whSel = $('#bamOldDestWarehouseId');
    $whSel.empty().append('<option value="">— Select Warehouse —</option>');
    $.each(warehouses, function(i, wh) {
        var label = wh.name + (wh.type ? ' (' + wh.type + ')' : '');
        $whSel.append($('<option>').val(wh.id).text(label));
    });

    var $wkSel = $('#bamOldDestWorkshopId');
    $wkSel.empty().append('<option value="">— Select Workshop —</option>');
    $.each(workshops, function(i, wk) {
        $wkSel.append($('<option>').val(wk.id).text(wk.name));
    });
}

/* ── BAM: Old Battery Destination pill toggle ────────────────────── */
$(document).on('change', 'input[name="old_battery_destination"]', function () {
    var val = $(this).val();

    // Update active pill
    $('#bamOldDestGrid .bam-old-dest-pill').removeClass('active');
    $(this).closest('.bam-old-dest-pill').addClass('active');

    // Show/hide sub-panels
    $('#bamOldDestWarehouseWrap').toggleClass('d-none', val !== 'SR Garage');
    $('#bamOldDestWorkshopWrap').toggleClass('d-none',  val !== 'Workshop');

    // Clear sub-panel errors + values when switching
    if (val !== 'SR Garage') { $('#bamOldDestWarehouseId').val(''); $('#bamErrOldDestWarehouse').text(''); }
    if (val !== 'Workshop')  { $('#bamOldDestWorkshopId').val('');  $('#bamErrOldDestWorkshop').text(''); }
    $('#bamErrOldDest').text('');

    // Notes: show "(Required for Scrap)" hint when Scrap is selected
    var isScrap = val === 'Scrap';
    $('#bamNotesScrapHint').toggleClass('d-none', !isScrap);
    $('#bamNotes').attr('placeholder', isScrap
        ? 'Required — describe the scrap reason or disposal details…'
        : 'Add any notes or remarks…'
    );
    if (!isScrap) { $('#bamErrNotes').text(''); }
});
