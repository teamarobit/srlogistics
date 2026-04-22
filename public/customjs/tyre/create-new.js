/* ==========================================================================
   Tyre Create-New — page script
   - SD-1: external JS only
   - SD-3: $.ajax() form submission
   - SD-4: inline <span class="text-danger..."> validation errors
   - SD-7: Toast.fire() for all notifications
   ========================================================================== */

/* ---------- SD-7 Toast mixin (define once at top) ---------- */
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

/* Prevent Dropzone auto-discovery (we init manually) */
if (typeof Dropzone !== 'undefined') {
    Dropzone.autoDiscover = false;
}

/* ---------- Constants ---------- */
const TCN_MAX_IMAGES = 4;
const TCN_MAX_SIZE_MB = 3;
let tcnDzInstance = null;

/* ---------- Helpers ---------- */
function tcnClearValidationErrors() {
    $('.field-error').remove();
}

function tcnShowValidationErrors(errors) {
    tcnClearValidationErrors();
    $.each(errors, function (field, messages) {
        // Convert dotted/bracketed field names to valid selector
        var baseField = field.split('.')[0];
        var $input = $('[name="' + baseField + '"]').first();
        if (!$input.length) {
            $input = $('[name="' + baseField + '[]"]').first();
        }
        if ($input.length) {
            var $target = $input;
            // If inside input-group or a radio-card picker, push error after the group
            var $group = $input.closest('.input-group');
            if ($group.length) $target = $group;
            var $locGroup = $input.closest('.badd-loc-group');
            if ($locGroup.length) $target = $locGroup;
            $('<span class="text-danger small d-block mt-1 field-error"></span>')
                .text(messages[0])
                .insertAfter($target);
        }
    });
    var $first = $('.field-error').first();
    if ($first.length) {
        $('html, body').animate({ scrollTop: $first.offset().top - 120 }, 300);
    }
}

function tcnAddDays(dateStr, months) {
    if (!dateStr || isNaN(parseInt(months, 10))) return '';
    var d = new Date(dateStr);
    if (isNaN(d.getTime())) return '';
    d.setMonth(d.getMonth() + parseInt(months, 10));
    var y = d.getFullYear();
    var m = String(d.getMonth() + 1).padStart(2, '0');
    var day = String(d.getDate()).padStart(2, '0');
    return y + '-' + m + '-' + day;
}

function tcnRecalcWarranty() {
    var purchase = $('#tcnPurchaseDate').val();
    var months = $('#tcnWarrantyMonths').val();
    $('#tcnWarrantyExpiry').val(tcnAddDays(purchase, months));
}

function tcnRecalcEndOfLife() {
    var purchase = $('#tcnPurchaseDate').val();
    var months = $('#tcnFixedLife').val();
    $('#tcnEndOfLife').val(tcnAddDays(purchase, months));
}

/* ---------- Dropzone ---------- */
function tcnInitDropzone() {
    var el = document.getElementById('tcnDropzone');
    if (!el || typeof Dropzone === 'undefined') return;
    if (el.dropzone) return; // already inited

    tcnDzInstance = new Dropzone(el, {
        url: '/upload/images',                // placeholder; actual files POSTed with the form
        paramName: 'files',
        maxFiles: TCN_MAX_IMAGES,
        maxFilesize: TCN_MAX_SIZE_MB,
        acceptedFiles: '.webp,.jpg,.jpeg,.png',
        addRemoveLinks: true,
        parallelUploads: TCN_MAX_IMAGES,
        autoProcessQueue: false,
        uploadMultiple: true,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    tcnDzInstance.on('maxfilesexceeded', function (file) {
        tcnDzInstance.removeFile(file);
        Toast.fire({ icon: 'error', title: 'Maximum ' + TCN_MAX_IMAGES + ' images allowed.' });
    });

    tcnDzInstance.on('error', function (file, message) {
        tcnDzInstance.removeFile(file);
        var msg = typeof message === 'string' ? message : (message.error || 'Invalid file.');
        Toast.fire({ icon: 'error', title: msg });
    });
}

/* ---------- Radio chip toggles ---------- */
function tcnBindRadioChips() {
    $(document).on('change', '.tcn-radio-chip input[type="radio"]', function () {
        var name = $(this).attr('name');
        $('input[type="radio"][name="' + name + '"]').each(function () {
            var $chip = $(this).closest('.tcn-radio-chip');
            if (this.checked) {
                $chip.addClass('active');
            } else {
                $chip.removeClass('active');
            }
        });
    });
    // Initialize active state for pre-checked radios
    $('.tcn-radio-chip input[type="radio"]:checked').each(function () {
        $(this).closest('.tcn-radio-chip').addClass('active');
    });
}

/* ---------- Initial Condition card group ---------- */
function tcnBindInitialCondition() {
    $(document).on('click', '#tcnInitCondGroup .badd-cond-opt', function () {
        $('#tcnInitCondGroup .badd-cond-opt').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
    });
}

/* ---------- Stock Location mode switch (Standard ↔ Fitment) ---------- */
function tcnApplyLocationMode(mode) {
    if (mode === 'Fitment') {
        // Hide standard options (hint, Not assigned, Warehouses, Workshops)
        $('.tcn-loc-standard').hide();
        // Show Fitment Tyre option and mark it as selected
        $('.badd-loc-fitment-only').css('display', 'flex').addClass('active');
        $('#tcnLocFitment').prop('checked', true);
    } else {
        // Hide Fitment option
        $('.badd-loc-fitment-only').hide().removeClass('active');
        $('#tcnLocFitment').prop('checked', false);
        // Show standard options
        $('.tcn-loc-standard').show();
    }
}

/* ---------- Source toggle (Existing / New PO / Fitment) ---------- */
function tcnBindSourceToggle() {
    $('#tcnSourceToggle').on('click', '.badd-source-option', function () {
        $('.badd-source-option').removeClass('active');
        $(this).addClass('active');
        var mode = $(this).find('input[type="radio"]').val();
        $(this).find('input[type="radio"]').prop('checked', true);

        // Hide all mode sections, then show the active one
        $('#tcnModeExisting, #tcnModeNewPO, #tcnModeFitment').removeClass('active');

        if (mode === 'Existing') {
            $('#tcnModeExisting').addClass('active');
            $('#tcnSourceNote').prop('required', true);
            $('#tcnPoGrnSelect').prop('required', false);
            $('#tcnFitmentSourceNote').prop('required', false);
        } else if (mode === 'New PO') {
            $('#tcnModeNewPO').addClass('active');
            $('#tcnPoGrnSelect').prop('required', true);
            $('#tcnSourceNote').prop('required', false);
            $('#tcnFitmentSourceNote').prop('required', false);
        } else if (mode === 'Fitment') {
            $('#tcnModeFitment').addClass('active');
            $('#tcnFitmentSourceNote').prop('required', true);
            $('#tcnSourceNote').prop('required', false);
            $('#tcnPoGrnSelect').prop('required', false);
        }

        $('#tcnSourceNote, #tcnPoGrnSelect, #tcnFitmentSourceNote').removeClass('is-invalid');

        // Update stock location display based on mode
        tcnApplyLocationMode(mode);
    });
}

/* ---------- File zone click-to-open (invoice attachment) ---------- */
function tcnBindInvoiceFileZone() {
    $(document).on('click', '#tcnFileZone', function (e) {
        if ($(e.target).is('input')) return;
        $('#tcnInvoiceFile').trigger('click');
    });
    $(document).on('change', '#tcnInvoiceFile', function () {
        var f = this.files && this.files[0];
        if (!f) return;
        if (f.size > 5 * 1024 * 1024) {
            Toast.fire({ icon: 'error', title: 'Invoice file must be under 5 MB.' });
            this.value = '';
            return;
        }
        $('#tcnFileZone .badd-file-text').text(f.name);
    });

    // Fitment invoice file zone
    $(document).on('click', '#tcnFitmentFileZone', function (e) {
        if ($(e.target).is('input')) return;
        $('#tcnFitmentInvoiceFile').trigger('click');
    });
    $(document).on('change', '#tcnFitmentInvoiceFile', function () {
        var f = this.files && this.files[0];
        if (!f) return;
        if (f.size > 5 * 1024 * 1024) {
            Toast.fire({ icon: 'error', title: 'Invoice file must be under 5 MB.' });
            this.value = '';
            return;
        }
        $('#tcnFitmentFileZone .badd-file-text').text(f.name);
    });
}

/* ---------- Button state ---------- */
function tcnSetSaving(isSaving) {
    var $btn = $('#tcnSubmit');
    if (isSaving) {
        $btn.prop('disabled', true);
        $('#tcnSubmitText').addClass('d-none');
        $('#tcnSubmitSpinner').removeClass('d-none');
    } else {
        $btn.prop('disabled', false);
        $('#tcnSubmitText').removeClass('d-none');
        $('#tcnSubmitSpinner').addClass('d-none');
    }
}

/* ---------- Stock Location picker (mirrors Battery #batLocGroup pattern) ---------- */
function tcnBindLocationPicker() {
    $('#tcnLocGroup').on('click', '.badd-loc-option', function () {
        $('#tcnLocGroup .badd-loc-option').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
    });
}

/* ---------- Form submit (SD-3 $.ajax) ---------- */
function tcnBindSubmit() {
    $('#tcnAddForm').on('submit', function (e) {
        e.preventDefault();
        tcnClearValidationErrors();
        tcnSetSaving(true);

        var formEl = this;
        var formData = new FormData(formEl);

        // Append queued Dropzone files (since autoProcessQueue is false)
        if (tcnDzInstance && tcnDzInstance.getAcceptedFiles().length) {
            tcnDzInstance.getAcceptedFiles().forEach(function (file) {
                formData.append('files[]', file, file.name);
            });
        }

        $.ajax({
            url: $(formEl).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Tyre added successfully.' });
                setTimeout(function () {
                    window.location.href = res.redirect_url || $(formEl).data('dashboard-url');
                }, 1200);
            },
            error: function (xhr) {
                tcnSetSaving(false);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    tcnShowValidationErrors(xhr.responseJSON.errors);
                    Toast.fire({ icon: 'error', title: 'Please fix the highlighted fields.' });
                } else {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong. Please try again.';
                    Toast.fire({ icon: 'error', title: msg });
                }
            }
        });
    });
}

/* ---------- Bootstrapping ---------- */
$(document).ready(function () {

    /* Select2 */
    $('.tcn-select2').each(function () {
        $(this).select2({
            placeholder: $(this).find('option[value=""]').text() || 'Select...',
            width: '100%',
            allowClear: false
        });
    });

    /* Select2 for PO / GRN picker (matches Battery pattern) */
    $('.select2-po-grn').select2({ width: '100%', placeholder: 'Search PO or GRN...' });

    /* Dropzone */
    tcnInitDropzone();

    /* UI bindings */
    tcnBindRadioChips();
    tcnBindInitialCondition();
    tcnBindSourceToggle();
    tcnBindInvoiceFileZone();
    tcnBindLocationPicker();
    tcnBindSubmit();

    /* Auto-calcs */
    $('#tcnPurchaseDate, #tcnWarrantyMonths').on('change input', tcnRecalcWarranty);
    $('#tcnPurchaseDate, #tcnFixedLife').on('change input', tcnRecalcEndOfLife);
    tcnRecalcWarranty();
    tcnRecalcEndOfLife();
});
