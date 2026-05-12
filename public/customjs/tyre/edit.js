/**
 * Tyre Edit — edit.js v2.0
 * Matches create-new.js design system.
 * SD-1: No inline JS in blade. SD-3: $.ajax only. SD-7: Toast mixin.
 */

// ── SD-7: Toast mixin (defined once at top of file) ──────────────────────────
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

Dropzone.autoDiscover = false;

// ── Constants ─────────────────────────────────────────────────────────────────
var GST_RATE      = 0.28;
var MAX_FILES     = 4;
var MAX_FILE_SIZE = 2; // MB

var $form     = null;
var dzInstance = null;

// ── Validation helpers (SD-4: red text below field, no red borders) ───────────
function showValidationErrors(errors) {
    clearValidationErrors();
    var firstScrolled = false;
    $.each(errors, function(field, messages) {
        var $input = $('[name="' + field + '"]');
        if ($input.length) {
            var $target = $input.last();
            $('<span class="text-danger small d-block mt-1 field-error">' + messages[0] + '</span>')
                .insertAfter($target);
            if (! firstScrolled) {
                $('html, body').animate({ scrollTop: $target.offset().top - 120 }, 300);
                firstScrolled = true;
            }
        }
    });
}

function clearValidationErrors() {
    $('.field-error').remove();
}

// ── Price auto-calculation ────────────────────────────────────────────────────
function calcTyrePrice() {
    var taxable = parseFloat($('#tceTaxable').val()) || 0;
    var gst     = parseFloat((taxable * GST_RATE).toFixed(2));
    var total   = parseFloat((taxable + gst).toFixed(2));
    $('#tceGst').val(taxable > 0 ? gst   : '');
    $('#tceTotal').val(taxable > 0 ? total : '');
}

function calcFTPrice() {
    var taxable = parseFloat($('#tceFTTaxable').val()) || 0;
    var gst     = parseFloat((taxable * GST_RATE).toFixed(2));
    var total   = parseFloat((taxable + gst).toFixed(2));
    $('#tceFTGst').val(taxable > 0 ? gst   : '');
    $('#tceFTTotal').val(taxable > 0 ? total : '');
}

// ── Date auto-calculations ────────────────────────────────────────────────────
function addMonthsToDate(dateStr, months) {
    if (! dateStr || isNaN(months) || months < 0) return '';
    var d = new Date(dateStr);
    if (isNaN(d.getTime())) return '';
    d.setMonth(d.getMonth() + parseInt(months, 10));
    return d.toISOString().slice(0, 10);
}

function calcWarrantyExpiry() {
    var date   = $('#tcePurchaseDate').val();
    var months = parseInt($('#tceWarrantyMonths').val(), 10) || 0;
    $('#tceWarrantyExpiry').val(addMonthsToDate(date, months));
}

function calcEndOfLife() {
    var date   = $('#tcePurchaseDate').val();
    var months = parseInt($('#tceFixedLife').val(), 10) || 0;
    $('#tceEndOfLife').val(addMonthsToDate(date, months));
}

// ── Radio chip active state ───────────────────────────────────────────────────
function initRadioChips() {
    $(document).on('click', '.tcn-radio-chip', function() {
        var $row = $(this).closest('.tcn-radio-row');
        $row.find('.tcn-radio-chip').removeClass('active');
        $(this).addClass('active');
    });
}

// ── Flap / Tube toggle ────────────────────────────────────────────────────────
function initFlapTubeToggle() {
    $('#tceFlapTubeRow').on('click', '.tcn-radio-chip', function() {
        var val = $(this).find('input[type=radio]').val();
        $('#tceFlapTubePriceLabel').text(val + ' Price');
        $('#tceFlapTubePriceSection').removeClass('d-none');
        $('#tceFlapChip, #tceTubeChip').removeClass('active');
        $(this).addClass('active');
    });
}

// ── Stock location active highlight ──────────────────────────────────────────
function initStockLocation() {
    $('#tceLocGroup').on('click', '.badd-loc-option', function() {
        $('#tceLocGroup .badd-loc-option').removeClass('active');
        $(this).addClass('active');
    });
}

// ── Select2 vendor dropdown ───────────────────────────────────────────────────
function initVendorSelect2() {
    $('#tceVendor').select2({
        placeholder: 'Select vendor...',
        width: '100%'
    });
}

// ── Dropzone (new image uploads) ──────────────────────────────────────────────
function initDropzone() {
    var el = document.getElementById('tceDropzone');
    if (! el) return;
    if (el.dropzone) return; // prevent double-init

    dzInstance = new Dropzone(el, {
        url: '/upload/images',         // placeholder — files appended to FormData manually
        paramName: 'files',
        maxFiles: MAX_FILES,
        maxFilesize: MAX_FILE_SIZE,
        acceptedFiles: '.jpg,.jpeg,.png,.webp',
        addRemoveLinks: true,
        parallelUploads: MAX_FILES,
        autoProcessQueue: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    dzInstance.on('maxfilesexceeded', function(file) {
        dzInstance.removeFile(file);
        Toast.fire({ icon: 'error', title: 'Maximum ' + MAX_FILES + ' images allowed.' });
    });
}

// ── Form submit (SD-3: $.ajax; FormData for file support) ─────────────────────
function initFormSubmit() {
    $form.on('submit', function(e) {
        e.preventDefault();
        clearValidationErrors();

        // Button state
        $('#tceSubmitText').html('<i class="uil uil-clock me-1"></i>Saving…');
        $('#tceSubmitSpinner').removeClass('d-none');
        $('#tceSubmit').prop('disabled', true);

        var formData = new FormData(this);

        // Append new dropzone files
        if (dzInstance && dzInstance.files.length > 0) {
            $.each(dzInstance.files, function(i, file) {
                formData.append('files[]', file);
            });
        }

        $.ajax({
            url         : $form.attr('action'),
            method      : 'POST',
            data        : formData,
            processData : false,
            contentType : false,
            dataType    : 'json',
            success     : function(response) {
                Toast.fire({
                    icon  : 'success',
                    title : response.message,
                    didClose: function() {
                        window.location.href = response.redirect_url ||
                                               $form.data('dashboard-url');
                    }
                });
            },
            error: function(xhr) {
                var res = xhr.responseJSON || {};

                // Reset button
                $('#tceSubmitText').html('<i class="uil uil-check me-1"></i>Update Tyre');
                $('#tceSubmitSpinner').addClass('d-none');
                $('#tceSubmit').prop('disabled', false);

                if (xhr.status === 422 && (res.errors || res.data)) {
                    showValidationErrors(res.errors || res.data);
                    Toast.fire({ icon: 'error', title: res.message || 'Please fix the highlighted fields.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Something went wrong. Please try again.' });
                }
            }
        });
    });
}

// ── Initialise on DOM ready ───────────────────────────────────────────────────
$(document).ready(function() {
    $form = $('#tyrEditForm');

    // Select2
    initVendorSelect2();

    // Dropzone
    initDropzone();

    // Radio chips
    initRadioChips();

    // Flap/Tube toggle
    initFlapTubeToggle();

    // Stock location active highlight
    initStockLocation();

    // Price: trigger on page load to populate GST + Total from existing taxable value
    calcTyrePrice();

    // Dates: trigger on page load to populate auto-calc readonly fields
    calcWarrantyExpiry();
    calcEndOfLife();

    // Live recalculation listeners
    $('#tceTaxable').on('input', calcTyrePrice);
    $('#tceFTTaxable').on('input', calcFTPrice);
    $('#tcePurchaseDate, #tceWarrantyMonths').on('change input', calcWarrantyExpiry);
    $('#tcePurchaseDate, #tceFixedLife').on('change input', calcEndOfLife);

    // Form submit
    initFormSubmit();
});
