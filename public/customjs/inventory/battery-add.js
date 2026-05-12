/* ==========================================================================
   Battery Add — page script  v2.0
   SD-1: external JS only
   SD-3: $.ajax() form submission
   SD-4: field-error spans, no red borders
   SD-7: Toast.fire() for all notifications
   ========================================================================== */

/* ---------- Prevent Dropzone auto-discovery ---------- */
if (typeof Dropzone !== 'undefined') { Dropzone.autoDiscover = false; }

/* ---------- Constants ---------- */
const BAN_MAX_FILES  = 4;
const BAN_MAX_SIZE   = 3; // MB
let banDzInstance    = null;

/* ---------- SD-7 Toast mixin ---------- */
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

/* ---------- Validation helpers ---------- */
function banClearErrors() { $('.field-error').remove(); }

function banShowErrors(errors) {
    banClearErrors();
    $.each(errors, function (field, messages) {
        var base   = field.split('.')[0];
        var $input = $('[name="' + base + '"]').first();
        if (!$input.length) $input = $('[name="' + base + '[]"]').first();
        if (!$input.length) return;
        var $target = $input;
        var $grp    = $input.closest('.input-group');
        if ($grp.length) $target = $grp;
        $('<span class="text-danger small d-block mt-1 field-error"></span>')
            .text(messages[0])
            .insertAfter($target);
    });
    var $first = $('.field-error').first();
    if ($first.length) $('html, body').animate({ scrollTop: $first.offset().top - 120 }, 300);
}

/* ---------- Date helpers ---------- */
function banAddMonths(dateStr, months) {
    var m = parseInt(months, 10);
    if (!dateStr || isNaN(m) || m <= 0) return '';
    var d = new Date(dateStr);
    if (isNaN(d.getTime())) return '';
    d.setMonth(d.getMonth() + m);
    return d.getFullYear() + '-'
         + String(d.getMonth() + 1).padStart(2, '0') + '-'
         + String(d.getDate()).padStart(2, '0');
}

function banRecalcWarrantyExpiry() {
    $('#banWarrantyExpiry').val(banAddMonths($('#banPurchaseDate').val(), $('#banWarrantyMonths').val()));
}

function banRecalcEndOfLife() {
    $('#banEndOfLife').val(banAddMonths($('#banIssueDate').val(), $('#banFixedLifeMonths').val()));
}

/* ---------- Dropzone ---------- */
function banInitDropzone() {
    var el = document.getElementById('banDropzone');
    if (!el || typeof Dropzone === 'undefined' || el.dropzone) return;

    banDzInstance = new Dropzone(el, {
        url: '/upload/images',
        paramName: 'files',
        maxFiles: BAN_MAX_FILES,
        maxFilesize: BAN_MAX_SIZE,
        acceptedFiles: '.webp,.jpg,.jpeg,.png,.pdf',
        addRemoveLinks: true,
        parallelUploads: BAN_MAX_FILES,
        autoProcessQueue: false,
        uploadMultiple: true,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    banDzInstance.on('maxfilesexceeded', function (file) {
        banDzInstance.removeFile(file);
        Toast.fire({ icon: 'error', title: 'Maximum ' + BAN_MAX_FILES + ' files allowed.' });
    });

    banDzInstance.on('error', function (file, message) {
        banDzInstance.removeFile(file);
        var msg = typeof message === 'string' ? message : (message.error || 'Invalid file.');
        Toast.fire({ icon: 'error', title: msg });
    });
}

/* ---------- Warranty alert visibility helper ---------- */
function banUpdateWarrantyAlert() {
    var condition      = $('input[type="radio"][name="battery_condition"]:checked').val();
    var warrantyMonths = parseInt($('#banWarrantyMonths').val(), 10) || 0;
    var show = (condition === 'Replaced Under Warranty') && (warrantyMonths > 0);
    $('#banWarrantyAlert').toggleClass('d-none', !show);
}

/* ---------- Radio chip binding (Battery Condition) ---------- */
function banBindRadioChips() {
    $(document).on('change', '.ban-radio-chip input[type="radio"]', function () {
        var name = $(this).attr('name');
        $('input[type="radio"][name="' + name + '"]').each(function () {
            $(this).closest('.ban-radio-chip').toggleClass('active', this.checked);
        });
        /* Warranty alert re-evaluate */
        if (name === 'battery_condition') {
            banUpdateWarrantyAlert();
        }
    });
    /* Init active state for pre-checked radios */
    $('.ban-radio-chip input[type="radio"]:checked').each(function () {
        $(this).closest('.ban-radio-chip').addClass('active');
    });
}

/* ---------- Source toggle ---------- */
function banBindSourceToggle() {
    $('#banSourceToggle').on('click', '.badd-source-option', function () {
        $('.badd-source-option').removeClass('active');
        $(this).addClass('active');
        var mode = $(this).find('input[type="radio"]').val();
        $(this).find('input[type="radio"]').prop('checked', true);

        $('#banModeExisting, #banModeNewPO, #banModeFitment').removeClass('active');
        $('#banSourceNote').prop('required', false);
        $('#banPoGrnSelect').prop('required', false);
        $('#banFitmentSourceNote').prop('required', false);

        if (mode === 'Existing') {
            $('#banModeExisting').addClass('active');
            $('#banSourceNote').prop('required', true);
        } else if (mode === 'New PO') {
            $('#banModeNewPO').addClass('active');
            $('#banPoGrnSelect').prop('required', true);
        } else {
            $('#banModeFitment').addClass('active');
            $('#banFitmentSourceNote').prop('required', true);
        }

        banApplyLocationMode(mode);
    });
}

/* ---------- Location mode (Standard ↔ Fitment) ---------- */
function banApplyLocationMode(mode) {
    if (mode === 'Fitment') {
        $('.ban-loc-standard').hide();
        $('.badd-loc-fitment-only').css('display', 'flex').addClass('active');
        $('#banLocFitment').prop('checked', true);
    } else {
        $('.badd-loc-fitment-only').hide().removeClass('active');
        $('#banLocFitment').prop('checked', false);
        $('.ban-loc-standard').show();
    }
}

/* ---------- Location picker ---------- */
function banBindLocationPicker() {
    $('#banLocGroup').on('click', '.badd-loc-option', function () {
        $('#banLocGroup .badd-loc-option').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
    });
}

/* ---------- Invoice file zone ---------- */
function banBindFileZones() {
    $(document).on('click', '#banFileZone', function (e) {
        if ($(e.target).is('input')) return;
        $('#banInvoiceFile').trigger('click');
    });
    $(document).on('change', '#banInvoiceFile', function () {
        var f = this.files && this.files[0];
        if (!f) return;
        if (f.size > 10 * 1024 * 1024) {
            Toast.fire({ icon: 'error', title: 'File must be under 10 MB.' });
            this.value = '';
            return;
        }
        $('#banFileZone .badd-file-text').text(f.name);
    });

    $(document).on('click', '#banFitmentFileZone', function (e) {
        if ($(e.target).is('input')) return;
        $('#banFitmentInvoiceFile').trigger('click');
    });
    $(document).on('change', '#banFitmentInvoiceFile', function () {
        var f = this.files && this.files[0];
        if (!f) return;
        if (f.size > 10 * 1024 * 1024) {
            Toast.fire({ icon: 'error', title: 'File must be under 10 MB.' });
            this.value = '';
            return;
        }
        $('#banFitmentFileZone .badd-file-text').text(f.name);
    });
}

/* ---------- Button state ---------- */
function banSetSaving(on) {
    $('#banSubmit').prop('disabled', on);
    $('#banSubmitText').toggleClass('d-none', on);
    $('#banSubmitSpinner').toggleClass('d-none', !on);
}

/* ---------- Form submit (SD-3) ---------- */
function banBindSubmit() {
    $('#banAddForm').on('submit', function (e) {
        e.preventDefault();
        banClearErrors();
        banSetSaving(true);

        var formData = new FormData(this);

        if (banDzInstance) {
            banDzInstance.getAcceptedFiles().forEach(function (file) {
                formData.append('files[]', file, file.name);
            });
        }

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Battery added successfully.' });
                setTimeout(function () {
                    window.location.href = res.redirect_url || $('#banAddForm').data('dashboard-url');
                }, 1200);
            },
            error: function (xhr) {
                banSetSaving(false);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    banShowErrors(xhr.responseJSON.errors);
                    Toast.fire({ icon: 'error', title: 'Please fix the highlighted fields.' });
                } else {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                    Toast.fire({ icon: 'error', title: msg });
                }
            }
        });
    });
}

/* ---------- Boot ---------- */
$(document).ready(function () {

    /* Select2 */
    $('.ban-select2').each(function () {
        $(this).select2({
            placeholder: $(this).find('option[value=""]').text() || 'Select...',
            width: '100%',
            allowClear: false
        });
    });

    /* Dropzone */
    banInitDropzone();

    /* UI */
    banBindRadioChips();
    banBindSourceToggle();
    banBindLocationPicker();
    banBindFileZones();
    banBindSubmit();

    /* Auto-calcs */
    $('#banPurchaseDate, #banWarrantyMonths').on('change input', banRecalcWarrantyExpiry);
    $('#banIssueDate, #banFixedLifeMonths').on('change input', banRecalcEndOfLife);

    /* Warranty months = 0 → treat as non-warranty → hide alert */
    $('#banWarrantyMonths').on('change input', banUpdateWarrantyAlert);

});
