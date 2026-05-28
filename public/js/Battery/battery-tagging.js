/**
 * Battery Tagging Page — SR Logistics
 * SD-1:  No inline JS in blade
 * SD-3:  $.ajax() only — no fetch()
 * SD-4:  Errors as <span class="text-danger"> below field
 * SD-7:  Toast mixin for all notifications
 * SD-8:  No findOrFail() in AJAX (backend)
 * SD-9:  HTTP status codes on every response (backend)
 * v2.7  — Direct Fitment battery picker (dropdown + life health preview + condition filter)
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
        var $errSpan = $('#err_' + field);
        if ($errSpan.length) {
            $errSpan.text(messages[0]);
            return;
        }
        var $input = $('#tagBatteryModal [name="' + field + '"]');
        if ($input.length) {
            $('<span class="text-danger small d-block mt-1 field-error">'
                + messages[0] + '</span>').insertAfter($input);
        }
    });
    var $firstErr = $('#tagBatteryModal .field-error:visible').first();
    if ($firstErr.length) {
        $('#tagBatteryModal .modal-body').animate({
            scrollTop: $firstErr.offset().top - 160
        }, 300);
    }
}

function clearValidationErrors() {
    $('.field-error').not('[id]').remove();
    $('[id^="err_"]').text('');
}

/* ══════════════════════════════════════════════════════════════════════
   DIRECT FITMENT — Battery picker helpers
   ══════════════════════════════════════════════════════════════════════ */

/**
 * Reset the Direct Fitment dropdown + health preview + auto-fill fields.
 */
function resetDirectFitmentBatteries() {
    $('#directBatterySelect')
        .prop('disabled', true)
        .html('<option value="">— Loading… —</option>');
    $('#dfBatteryDropdownState')
        .text('— Loading available Direct Fitment batteries… —')
        .removeClass('text-danger text-success text-warning')
        .addClass('text-muted');
    $('#dfBatteryHealthPreview').addClass('d-none');
    $('#df_batteryBrand, #df_batterySerial, #df_batteryModel, #df_batteryCapacity').val('');
}

/**
 * Fetch batteries where battery_source_mode = 'Fitment' AND not in vehiclebatteries (Active).
 * Passes optional condition filter. Populates #directBatterySelect.
 */
function fetchDirectFitmentBatteries() {
    var condition  = $('#batteryConditionSelect').val();
    var dfUrl      = $('#tagBatteryForm').data('direct-fitment-url');
    var $select    = $('#directBatterySelect');
    var $stateMsg  = $('#dfBatteryDropdownState');

    resetDirectFitmentBatteries();

    var params = {};
    if (condition) { params.condition = condition; }

    $.ajax({
        url    : dfUrl,
        method : 'GET',
        data   : params,
        headers: { 'Accept': 'application/json' },
        success: function (res) {
            if (!res.batteries || res.batteries.length === 0) {
                $select.html('<option value="">— No Direct Fitment batteries available —</option>');
                $stateMsg.text('No Direct Fitment batteries available for the selected condition.')
                         .removeClass('text-muted text-success text-warning')
                         .addClass('text-danger');
                return;
            }
            var opts = '<option value="">— Select a battery —</option>';
            $.each(res.batteries, function (i, b) {
                opts += '<option value="' + b.id + '"'
                      + ' data-brand="'    + $('<div>').text(b.brand).html()    + '"'
                      + ' data-serial="'   + $('<div>').text(b.serial).html()   + '"'
                      + ' data-model="'    + $('<div>').text(b.model).html()    + '"'
                      + ' data-capacity="' + $('<div>').text(b.capacity).html() + '"'
                      + ' data-life="'     + (b.life_pct !== null ? b.life_pct : '') + '"'
                      + ' data-rag="'      + $('<div>').text(b.rag).html()      + '"'
                      + '>' + $('<div>').text(b.label).html() + '</option>';
            });
            $select.prop('disabled', false).html(opts);
            $stateMsg.text(res.batteries.length + ' batter' + (res.batteries.length === 1 ? 'y' : 'ies') + ' available.')
                     .removeClass('text-muted text-danger text-warning')
                     .addClass('text-success');
        },
        error: function () {
            $select.html('<option value="">— Failed to load —</option>');
            $stateMsg.text('Could not load Direct Fitment batteries. Please try again.')
                     .removeClass('text-muted text-success text-warning')
                     .addClass('text-danger');
        }
    });
}

/* ── Direct Fitment battery selection — auto-fill + health preview ───── */
$(document).on('change', '#directBatterySelect', function () {
    var $opt     = $(this).find('option:selected');
    var lifePct  = $opt.data('life');
    var rag      = $opt.data('rag') || 'grey';

    $('#df_batteryBrand').val($opt.data('brand')    || '');
    $('#df_batterySerial').val($opt.data('serial')  || '');
    $('#df_batteryModel').val($opt.data('model')    || '');
    $('#df_batteryCapacity').val($opt.data('capacity') ? $opt.data('capacity') + ' Ah' : '');

    var $preview = $('#dfBatteryHealthPreview');

    if (!$(this).val() || lifePct === '' || lifePct === undefined || lifePct === null) {
        $preview.addClass('d-none');
        return;
    }

    var ragColours = {
        green : { bar: '#22c55e', badge: 'bat-rag-green', label: '🟢 Good'     },
        amber : { bar: '#f59e0b', badge: 'bat-rag-amber', label: '🟡 Monitor'  },
        red   : { bar: '#ef4444', badge: 'bat-rag-red',   label: '🔴 Critical' },
        grey  : { bar: '#94a3b8', badge: 'bat-rag-grey',  label: '⚫ No data'  },
    };
    var colours = ragColours[rag] || ragColours.grey;

    $('#dfBatHealthBarFill').css('width', lifePct + '%').css('background-color', colours.bar);
    $('#dfBatHealthPctText').text(lifePct + '%');
    $('#dfBatHealthRagBadge')
        .text(colours.label)
        .attr('class', 'bat-health-rag-badge ms-2 ' + colours.badge);
    $preview.removeClass('d-none');
});

/* ── Source Toggle ──────────────────────────────────────────────────── */
function applySourceToggle() {
    var src = $('input[name="battery_source"]:checked').val();
    if (src === 'SR Warehouse') {
        $('#srcWarehouseSection').removeClass('d-none');
        $('#srcDirectSection').addClass('d-none');
        $('#srcDirectSection input, #srcDirectSection select').prop('disabled', true);
        $('#srcWarehouseSection select, #srcWarehouseSection input').prop('disabled', false);
        reloadWarehouseBatteries();
    } else {
        $('#srcDirectSection').removeClass('d-none');
        $('#srcWarehouseSection').addClass('d-none');
        $('#srcWarehouseSection input, #srcWarehouseSection select').prop('disabled', true);
        $('#srcDirectSection input, #srcDirectSection select').prop('disabled', false);
        // Clear warehouse fields
        $('#warehouseBatterySelect').val('').prop('disabled', true);
        $('#wh_batteryBrand').val('');
        $('#wh_batterySerial').val('');
        // Reset DF + fetch
        resetDirectFitmentBatteries();
        fetchDirectFitmentBatteries();
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
        error: function () {
            $select.html('<option value="">— Failed to load —</option>');
            $stateMsg.text('Could not load batteries. Please try again.');
        }
    });
}

/* Condition change — re-fetch for whichever source is active */
$(document).on('change', '#batteryConditionSelect', function () {
    var src = $('input[name="battery_source"]:checked').val();
    if (src === 'SR Warehouse') {
        reloadWarehouseBatteries();
    } else {
        resetDirectFitmentBatteries();
        fetchDirectFitmentBatteries();
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

/* ── Reset tag modal on close ───────────────────────────────────────── */
$('#tagBatteryModal').on('hidden.bs.modal', function () {
    var $form = $(this).find('form')[0];
    if ($form) $form.reset();
    clearValidationErrors();

    $('#btnTagBattery').prop('disabled', false);
    $('#btnTagBatteryText').html('<i class="uil uil-battery-bolt me-1"></i>Tag Battery');
    $('#btnTagBatterySpinner').addClass('d-none');

    $('#previewSerial, #previewFitment, #previewOdometer').addClass('d-none').find('img').attr('src', '');

    // Reset Direct Fitment section
    resetDirectFitmentBatteries();

    // Reset source toggle to default (SR Warehouse)
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
    $('#bamSourceGrid .bam-source-card').removeClass('active');
    $(this).closest('.bam-source-card').addClass('active');
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

    $('#bamSlotLabel').text(slot);
    $('#bamSerialText').text(serial);
    $('#bamBrandText').text(brand ? '· ' + brand : '');

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

    $('#batteryTakeActionModal').data('available-url', availUrl);
    $('#batteryTakeActionModal').data('replace-url', replaceUrl);

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

    $('#bamRplSubmitBtn').prop('disabled', false);
    $('#bamRplSubmitText').html('<i class="uil uil-exchange me-1"></i>Replace Battery');
    $('#bamRplSubmitSpinner').addClass('d-none');

    $('#bamSourceGrid .bam-source-card').removeClass('active');
    $('#bamPanelWarehouse, #bamPanelDirect').removeClass('active');
    $('#bamWarehouseBatterySelect').prop('disabled', true)
        .html('<option value="">— Select condition first —</option>');
    $('#bamWhBrand').val('');
    $('#bamWhSerial').val('');
    $('#bamBatteryDropdownState').text('Select a Battery Condition above to load available stock.');

    $('#bamThumbDamage, #bamThumbSerial, #bamThumbOdometer').hide().attr('src', '');

    $('#bamSlotLabel').text('—');
    $('#bamSerialText').text('—');
    $('#bamBrandText').text('');
    $('#bamLifeText').text('');
    $('#bamRagBadge').removeClass('rag-green rag-yellow rag-red').addClass('rag-grey').text('⚫ Not Set');

    $('#bamOldDestGrid .bam-old-dest-pill').removeClass('active');
    $('input[name="old_battery_destination"]').prop('checked', false);
    $('#bamOldDestWarehouseWrap, #bamOldDestWorkshopWrap').addClass('d-none');
    $('#bamOldDestWarehouseId, #bamOldDestWorkshopId').val('');
    $('#bamErrOldDest, #bamErrOldDestWarehouse, #bamErrOldDestWorkshop').text('');

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

    $('#bamOldDestGrid .bam-old-dest-pill').removeClass('active');
    $(this).closest('.bam-old-dest-pill').addClass('active');

    $('#bamOldDestWarehouseWrap').toggleClass('d-none', val !== 'SR Garage');
    $('#bamOldDestWorkshopWrap').toggleClass('d-none',  val !== 'Workshop');

    if (val !== 'SR Garage') { $('#bamOldDestWarehouseId').val(''); $('#bamErrOldDestWarehouse').text(''); }
    if (val !== 'Workshop')  { $('#bamOldDestWorkshopId').val('');  $('#bamErrOldDestWorkshop').text(''); }
    $('#bamErrOldDest').text('');

    var isScrap = val === 'Scrap';
    $('#bamNotesScrapHint').toggleClass('d-none', !isScrap);
    $('#bamNotes').attr('placeholder', isScrap
        ? 'Required — describe the scrap reason or disposal details…'
        : 'Add any notes or remarks…'
    );
    if (!isScrap) { $('#bamErrNotes').text(''); }
});
