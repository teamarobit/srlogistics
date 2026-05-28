/* =========================================================
   Battery Details Page — battery-details.js  v4.0
   ========================================================= */

// ── Read config injected by blade via data-* (SD-1 compliant) ──────────────
var _cfg             = document.getElementById('batteryDetailsConfig') || {};
var PDF_LOGO         = (_cfg.dataset && _cfg.dataset.pdfLogo)         || '';
var OTHER_LOGO       = (_cfg.dataset && _cfg.dataset.otherLogo)       || '';
var CSRF_TOKEN       = (_cfg.dataset && _cfg.dataset.csrf)
                         || ($('meta[name="csrf-token"]').attr('content') || '');
var MAINT_STORE_URL  = (_cfg.dataset && _cfg.dataset.maintStoreUrl)   || '';
var REPAIR_STORE_URL = (_cfg.dataset && _cfg.dataset.repairStoreUrl)  || '';

// ── Toast mixin (SD-7) ───────────────────────────────────────────────────────
const Toast = Swal.mixin({
    toast             : true,
    position          : 'top',
    showConfirmButton : false,
    timer             : 3000,
    timerProgressBar  : true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

// ── Dropzone ─────────────────────────────────────────────────────────────────
Dropzone.autoDiscover = false;

const MAX_ATTACHMENTS = 2;
var dzInstance     = null;
var editDzInstance = null;

function initDropzone() {
    var el = document.getElementById('myDropzone');
    if (!el || el.dropzone) return;

    dzInstance = new Dropzone(el, {
        url             : '/upload/images',
        paramName       : 'files',
        maxFiles        : MAX_ATTACHMENTS,
        maxFilesize     : 2,
        acceptedFiles   : '.webp,.jpg,.jpeg,.png,.pdf',
        addRemoveLinks  : true,
        parallelUploads : MAX_ATTACHMENTS,
        autoProcessQueue: false,
        headers         : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    dzInstance.on('maxfilesexceeded', function (file) {
        dzInstance.removeFile(file);
        Toast.fire({ icon: 'error', title: 'Maximum 2 attachments allowed!' });
    });
}

function editInitDropzone() {
    var el = document.getElementById('edit_myDropzone');
    if (!el || el.dropzone) return;

    editDzInstance = new Dropzone(el, {
        url             : '/upload/images',
        paramName       : 'files',
        maxFiles        : MAX_ATTACHMENTS,
        maxFilesize     : 2,
        acceptedFiles   : '.webp,.jpg,.jpeg,.png,.pdf',
        addRemoveLinks  : true,
        parallelUploads : MAX_ATTACHMENTS,
        autoProcessQueue: false,
        headers         : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    editDzInstance.on('maxfilesexceeded', function (file) {
        editDzInstance.removeFile(file);
        Toast.fire({ icon: 'error', title: 'Maximum 2 attachments allowed!' });
    });
}

// ── Date-range picker helper ─────────────────────────────────────────────────
function setDateRangePicker(selector, date) {
    var picker = $(selector).data('daterangepicker');
    if (!date) { $(selector).val(''); return; }
    var formatted = moment(date, 'DD/MM/YYYY');
    if (picker) {
        picker.setStartDate(formatted);
        picker.setEndDate(formatted);
    }
    $(selector).val(formatted.format('DD/MM/YYYY'));
}

// ── Set date picker from Y-m-d string ────────────────────────────────────────
function setDatePickerFromYmd(selector, ymdStr) {
    var picker = $(selector).data('daterangepicker');
    if (!ymdStr) { $(selector).val(''); return; }
    var d = moment(ymdStr, 'YYYY-MM-DD');
    if (picker) { picker.setStartDate(d); picker.setEndDate(d); }
    $(selector).val(d.format('DD/MM/YYYY'));
}

// ── Document ready ───────────────────────────────────────────────────────────
$(document).ready(function () {

    // ── Init Dropzones ────────────────────────────────────────────────────
    initDropzone();
    editInitDropzone();

    // ── Date pickers ──────────────────────────────────────────────────────
    var datePickerOptions = {
        singleDatePicker : true,
        showDropdowns    : true,
        autoApply        : true,
        locale           : { format: 'DD/MM/YYYY' }
    };
    $('#doc_issue_date, #doc_expiry_date').daterangepicker(datePickerOptions);
    $('#edit_doc_issue_date, #edit_doc_expiry_date').daterangepicker(datePickerOptions);

    // Maintenance date pickers
    var maintDateOpts = { singleDatePicker: true, showDropdowns: true, autoApply: true, locale: { format: 'DD/MM/YYYY' } };
    $('#maint_last_done, #maint_next_due').daterangepicker(maintDateOpts);
    $('#edit_maint_last_done, #edit_maint_next_due').daterangepicker(maintDateOpts);

    // Repair date pickers
    $('#rep_date').daterangepicker(maintDateOpts);
    $('#edit_rep_date').daterangepicker(maintDateOpts);

    // ── Select2 for document type ─────────────────────────────────────────
    $('#attachmenttype_dd').select2({
        placeholder    : 'Search Document Type...',
        dropdownParent : $('#documentForm'),
        tags           : true
    });

    $('#edit_attachmenttype_dd').select2({
        placeholder    : 'Search Document Type...',
        dropdownParent : $('#editDocumentForm'),
        tags           : true
    });

    // ── Set-reminder toggle — Add modal ───────────────────────────────────
    $('#setReminder').on('change', function () {
        $(this).closest('.form-group').find('.days-beforeexpiry').toggle(this.checked);
    });

    // ── Set-reminder toggle — Edit modal ──────────────────────────────────
    $('#edit_setReminder').on('change', function () {
        $('#edit_reminder_wrap').toggle(this.checked);
        if (!this.checked) { $('#edit_reminder_days').val(''); }
    });

    // ── Notes modal ───────────────────────────────────────────────────────
    $(document).on('click', '.showMore', function () {
        $('#bdet-modal-notes-content').text($(this).data('notes'));
    });

    // ── Populate Edit Document modal ──────────────────────────────────────
    $(document).on('click', '.item-edit', function () {
        var btn = $(this);

        $('#editDocumentForm').attr('action', btn.data('url'));
        $('#edit_attachmenttype_dd').val(btn.data('attachment_type')).trigger('change');
        $('input[name="document_number"]', '#editDocumentForm').val(btn.data('document_number'));
        $('#edit_document_notes').val(btn.data('notes'));

        setDateRangePicker('#edit_doc_issue_date',  btn.data('issue_date'));
        setDateRangePicker('#edit_doc_expiry_date', btn.data('expiry_date'));

        var hasReminder = btn.data('has_reminder');
        if (hasReminder === 'Yes') {
            $('#edit_setReminder').prop('checked', true);
            $('#edit_reminder_wrap').show();
            $('#edit_reminder_days').val(btn.data('reminder_days'));
        } else {
            $('#edit_setReminder').prop('checked', false);
            $('#edit_reminder_wrap').hide();
            $('#edit_reminder_days').val('');
        }

        if (editDzInstance) { editDzInstance.removeAllFiles(true); }
    });

    // ── View Files (file preview modal) ───────────────────────────────────
    $(document).on('click', '.view-files', function () {
        var files     = $(this).data('files');
        var container = $('#filePreviewContainer1');
        container.html('');

        if (!files || files.length === 0) {
            container.html('<p class="text-muted">No files available.</p>');
            $('#filePreviewModal').modal('show');
            return;
        }

        files.forEach(function (file) {
            var isImage  = file.file_type && file.file_type.startsWith('image/');
            var isPdf    = file.file_type === 'application/pdf';
            var fileSize = file.file_size ? (file.file_size / 1024).toFixed(2) + ' KB' : '';
            var date     = file.created_at
                            ? new Date(file.created_at).toLocaleDateString('en-GB')
                            : '';

            var preview;
            if (isPdf) {
                preview = '<img src="' + PDF_LOGO + '" class="me-3" style="width:50px;">';
            } else if (isImage) {
                preview = '<img src="' + file.url + '" class="me-3" style="width:50px;height:50px;object-fit:cover;">';
            } else {
                preview = '<img src="' + OTHER_LOGO + '" class="me-3" style="width:50px;">';
            }

            var name      = file.file_name || 'Attachment';
            var shortName = name.length > 15 ? name.substring(0, 15) + '...' : name;

            var html = '<div class="col-12 col-md-4 attachment-box mb-3">'
                + '<div class="preview-img d-block w-100 border rounded p-2">'
                + '<div class="d-flex justify-content-between">'
                + '<div class="d-flex">'
                + '<a href="' + file.url + '" download="' + name + '">' + preview + '</a>'
                + '<div style="font-size:14px;">'
                + '<a href="' + file.url + '" download="' + name + '"><p class="mb-0 file-name">' + shortName + '</p></a>'
                + '<p class="mb-0">Size: <span class="text-secondary">' + fileSize + '</span></p>'
                + '</div></div>'
                + '<div class="float-end">'
                + '<i class="uil-trash-alt text-danger delete-attachment-btn" data-url="' + file.delete_url + '" style="cursor:pointer;font-size:18px;"></i>'
                + '</div></div>'
                + '<small class="text-secondary d-block mt-2">Attached on ' + date + '</small>'
                + '</div></div>';

            container.append(html);
        });

        $('#filePreviewModal').modal('show');
    });

    // ── Delete attachment ─────────────────────────────────────────────────
    $(document.body).on('click', '.delete-attachment-btn', function () {
        var url = $(this).data('url');

        Swal.fire({
            position          : 'center',
            icon              : 'warning',
            title             : 'Are you sure you want to delete this file?',
            showConfirmButton : true,
            showCancelButton  : true,
            confirmButtonText : 'Yes, Delete It',
            cancelButtonText  : 'Cancel',
            confirmButtonColor: '#1F75A8',
            reverseButtons    : true
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    method  : 'DELETE',
                    url     : url,
                    headers : { 'X-CSRF-TOKEN': CSRF_TOKEN },
                    dataType: 'json',
                    success : function (response) {
                        Toast.fire({ icon: 'success', title: response.message })
                             .then(function () { location.reload(true); });
                    },
                    error   : function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message)
                                    || 'Something went wrong.';
                        Toast.fire({ icon: 'error', title: msg });
                    }
                });
            } else {
                Toast.fire({ icon: 'info', title: 'No action taken.' });
            }
        });
    });

    // ── Trigger Add Document form ─────────────────────────────────────────
    $(document).on('click', '.docSubmitForm', function () {
        $('form#documentForm').submit();
    });

    // ── Trigger Edit Document form ────────────────────────────────────────
    $(document).on('click', '.editDocSubmitForm', function () {
        $('form#editDocumentForm').submit();
    });

    // ── Add Document AJAX submit ──────────────────────────────────────────
    $('form#documentForm').on('submit', function (e) {
        e.preventDefault();

        $('.error').html('');
        var submitBtn = $('.docSubmitForm');
        var btnText   = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

        var formData = new FormData(this);
        if (dzInstance) {
            dzInstance.files.forEach(function (file) {
                formData.append('files[]', file);
            });
        }

        $.ajax({
            method     : 'POST',
            url        : $(this).attr('action'),
            data       : formData,
            processData: false,
            contentType: false,
            dataType   : 'json',
            success    : function (response) {
                Toast.fire({
                    icon    : 'success',
                    title   : response.message,
                    didClose: function () { location.reload(true); }
                });
                submitBtn.html(btnText).attr('disabled', false);
            },
            error      : function (xhr) {
                var response = xhr.responseJSON || {};
                Toast.fire({ icon: 'error', title: response.message || 'Something went wrong.' });
                if (response.data) {
                    $.each(response.data, function (index, value) {
                        $('#document_' + index + '_error').text(value[0]);
                    });
                }
                submitBtn.html(btnText).attr('disabled', false);
            }
        });

        return false;
    });

    // ── Edit Document AJAX submit ─────────────────────────────────────────
    $('form#editDocumentForm').on('submit', function (e) {
        e.preventDefault();

        $('.error').html('');
        var submitBtn = $('.editDocSubmitForm');
        var btnText   = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

        var formData = new FormData(this);
        if (editDzInstance) {
            editDzInstance.files.forEach(function (file) {
                formData.append('files[]', file);
            });
        }

        $.ajax({
            method     : 'POST',
            url        : $(this).attr('action'),
            data       : formData,
            processData: false,
            contentType: false,
            dataType   : 'json',
            success    : function (response) {
                Toast.fire({
                    icon    : 'success',
                    title   : response.message,
                    didClose: function () { location.reload(true); }
                });
                submitBtn.html(btnText).attr('disabled', false);
            },
            error      : function (xhr) {
                var response = xhr.responseJSON || {};
                Toast.fire({ icon: 'error', title: response.message || 'Something went wrong.' });
                if (response.data) {
                    $.each(response.data, function (index, value) {
                        $('#edit_document_' + index + '_error').text(value[0]);
                    });
                }
                submitBtn.html(btnText).attr('disabled', false);
            }
        });

        return false;
    });

    // ── Comment form ──────────────────────────────────────────────────────
    $('form#bdet-commentForm').on('submit', function (e) {
        e.preventDefault();

        $('.error').html('');
        var submitBtn = $('.submitBtn', $(this));
        var btnText   = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading…</span></div>').attr('disabled', true);

        $.ajax({
            method  : 'POST',
            url     : $(this).attr('action'),
            data    : $(this).serialize(),
            dataType: 'json',
            success : function (response) {
                Toast.fire({
                    icon    : 'success',
                    title   : response.message,
                    didClose: function () { location.reload(true); }
                });
                submitBtn.html(btnText).attr('disabled', false);
            },
            error   : function (xhr) {
                var response = xhr.responseJSON || {};
                if (xhr.status === 422 && response.errors) {
                    $('#bdet-comment_error').text(
                        response.errors.comment ? response.errors.comment[0] : ''
                    );
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Something went wrong.' });
                }
                submitBtn.html(btnText).attr('disabled', false);
            }
        });

        return false;
    });

    // ── Movement log filter ───────────────────────────────────────────────
    $('#bdet-log-type-filter').on('change', function () {
        var val     = $(this).val();
        var events  = $('.bdet-tl-event');
        if (!val) {
            events.show();
            $('#bdet-log-empty').hide();
            return;
        }
        var visible = 0;
        events.each(function () {
            if ($(this).data('event-type') === val) { $(this).show(); visible++; }
            else { $(this).hide(); }
        });
        $('#bdet-log-empty').toggle(visible === 0);
    });

    // ── Active tab persistence ────────────────────────────────────────────
    var baseUrl    = window.location.origin + window.location.pathname;
    var storageKey = 'activeNav_' + baseUrl;
    var savedNav   = sessionStorage.getItem(storageKey);

    $(document).on('click', '.nav_click', function () {
        sessionStorage.setItem(storageKey, $(this).data('bs-target'));
    });

    var targetEl = savedNav
        ? document.querySelector('.nav_click[data-bs-target="' + savedNav + '"]')
        : document.querySelector('.nav_click');

    if (targetEl) {
        var tab = new bootstrap.Tab(targetEl);
        tab.show();
    }

    // ── Allocated Vehicles — date pickers ─────────────────────────────────
    $('#bdet-veh-daterange').daterangepicker({
        autoUpdateInput: false,
        locale         : { format: 'DD/MM/YYYY', cancelLabel: 'Clear' }
    });
    $('#bdet-veh-daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        filterAllocatedVehicles();
    });
    $('#bdet-veh-daterange').on('cancel.daterangepicker', function () {
        $(this).val('');
        filterAllocatedVehicles();
    });

    // ── Allocated Vehicles — search filter ───────────────────────────────
    $('#bdet-veh-search').on('input', filterAllocatedVehicles);

    $('#bdet-veh-reset').on('click', function () {
        $('#bdet-veh-daterange').val('');
        $('#bdet-veh-search').val('');
        filterAllocatedVehicles();
    });

    function filterAllocatedVehicles() {
        var searchVal  = $('#bdet-veh-search').val().toLowerCase().trim();
        var dateRange  = $('#bdet-veh-daterange').val().trim();
        var startDate  = null, endDate = null;

        if (dateRange) {
            var parts  = dateRange.split(' - ');
            startDate  = parts[0] ? moment(parts[0], 'DD/MM/YYYY') : null;
            endDate    = parts[1] ? moment(parts[1], 'DD/MM/YYYY') : null;
        }

        var rows    = $('#bdet-alloc-table tbody tr').not('#bdet-veh-empty-row');
        var visible = 0;

        rows.each(function () {
            var veh     = $(this).data('vehicle') || '';
            var fitment = $(this).data('fitment') || '';
            var matchVeh   = !searchVal  || veh.includes(searchVal);
            var matchDate  = true;
            if (startDate && fitment) {
                var fDate = moment(fitment, 'YYYY-MM-DD');
                matchDate = fDate.isSameOrAfter(startDate) && (!endDate || fDate.isSameOrBefore(endDate));
            }
            if (matchVeh && matchDate) { $(this).show(); visible++; }
            else { $(this).hide(); }
        });

        $('#bdet-veh-empty-row').toggle(visible === 0 && rows.length > 0);
    }

    // ── Maintenance — Save Schedule ───────────────────────────────────────
    $('#bdet-maint-save-btn').on('click', function () {
        var $btn    = $(this);
        var $txt    = $('#bdet-maint-save-txt');
        var $form   = $('#bdet-maint-form');

        var item    = $('#maint_item').val().trim();
        var status  = $('#maint_status').val();
        var valid   = true;

        $('#maint_item_err, #maint_status_err').text('');

        if (!item) {
            $('#maint_item_err').text('Maintenance item is required.');
            valid = false;
        }
        if (!status) {
            $('#maint_status_err').text('Status is required.');
            valid = false;
        }
        if (!valid) { return; }

        $btn.prop('disabled', true);
        $txt.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…');

        $.ajax({
            method     : 'POST',
            url        : MAINT_STORE_URL,
            data       : $form.serialize(),
            dataType   : 'json',
            success    : function (res) {
                Toast.fire({ icon: 'success', title: res.message, didClose: function () { location.reload(true); } });
                $btn.prop('disabled', false);
                $txt.text('Save Schedule');
            },
            error      : function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                Toast.fire({ icon: 'error', title: msg });
                $btn.prop('disabled', false);
                $txt.text('Save Schedule');
            }
        });
    });

    // ── Maintenance — Populate Edit modal ─────────────────────────────────
    $(document).on('click', '.bdet-maint-edit', function () {
        var btn = $(this);
        $('#bdet-maint-edit-form').attr('action', btn.data('update-url'));
        $('#edit_maint_item').val(btn.data('item'));
        $('#edit_maint_type').val(btn.data('type'));
        $('#edit_maint_status').val(btn.data('status'));
        $('#edit_maint_odometer').val(btn.data('odometer'));
        $('#edit_maint_scheduled_km').val(btn.data('scheduled-km'));
        $('#edit_maint_cost').val(btn.data('cost'));
        $('#edit_maint_notes').val(btn.data('notes'));

        var setDP = function (sel, val) {
            var picker = $(sel).data('daterangepicker');
            if (!val) { $(sel).val(''); return; }
            var d = moment(val, 'DD/MM/YYYY');
            if (picker) { picker.setStartDate(d); picker.setEndDate(d); }
            $(sel).val(d.format('DD/MM/YYYY'));
        };
        setDP('#edit_maint_last_done', btn.data('last-done'));
        setDP('#edit_maint_next_due',  btn.data('next-due'));
    });

    // ── Maintenance — Update Schedule ─────────────────────────────────────
    $('#bdet-maint-update-btn').on('click', function () {
        var $btn  = $(this);
        var $txt  = $('#bdet-maint-update-txt');
        var $form = $('#bdet-maint-edit-form');

        var status = $('#edit_maint_status').val();
        $('#edit_maint_status_err').text('');
        if (!status) {
            $('#edit_maint_status_err').text('Status is required.');
            return;
        }

        $btn.prop('disabled', true);
        $txt.html('<span class="spinner-border spinner-border-sm me-1"></span>Updating…');

        $.ajax({
            method   : 'POST',
            url      : $form.attr('action'),
            data     : $form.serialize(),
            dataType : 'json',
            success  : function (res) {
                Toast.fire({ icon: 'success', title: res.message, didClose: function () { location.reload(true); } });
                $btn.prop('disabled', false);
                $txt.text('Update Schedule');
            },
            error    : function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                Toast.fire({ icon: 'error', title: msg });
                $btn.prop('disabled', false);
                $txt.text('Update Schedule');
            }
        });
    });

    // ── Maintenance sub-tab filter ────────────────────────────────────────
    $('#bdet-maint-filter-type, #bdet-maint-filter-status').on('change', filterMaintSchedules);
    $('#bdet-maint-filter-vehicle').on('input', filterMaintSchedules);
    $('#bdet-maint-filter-reset').on('click', function () {
        $('#bdet-maint-filter-type').val('');
        $('#bdet-maint-filter-status').val('');
        $('#bdet-maint-filter-vehicle').val('');
        $('#bdet-maint-filter-daterange').val('');
        filterMaintSchedules();
    });

    function filterMaintSchedules() {
        var typeVal    = $('#bdet-maint-filter-type').val().toLowerCase();
        var statusVal  = $('#bdet-maint-filter-status').val().toLowerCase();
        var vehicleVal = $('#bdet-maint-filter-vehicle').val().toLowerCase().trim();
        var rows       = $('#bdet-maint-tbody tr').not('#bdet-maint-empty-row');
        var visible    = 0;

        rows.each(function () {
            var rowType    = $(this).data('type')    || '';
            var rowStatus  = $(this).data('status')  || '';
            var rowVehicle = $(this).data('vehicle') || '';
            var matchType    = !typeVal    || rowType    === typeVal;
            var matchStatus  = !statusVal  || rowStatus  === statusVal;
            var matchVehicle = !vehicleVal || rowVehicle.includes(vehicleVal);
            if (matchType && matchStatus && matchVehicle) { $(this).show(); visible++; }
            else { $(this).hide(); }
        });
        $('#bdet-maint-empty-row').toggle(visible === 0 && rows.length > 0);
    }

    // ── Repair sub-tab — Action button swap ───────────────────────────────
    $('#bdet-pills-repair-tab').on('shown.bs.tab', function () {
        $('#bdet-maint-action-btn')
            .attr('data-bs-target', '#bdet-add-repair')
            .html('<i class="uil uil-plus me-1"></i>Add Repair');
    });
    $('#bdet-pills-maint-tab').on('shown.bs.tab', function () {
        $('#bdet-maint-action-btn')
            .attr('data-bs-target', '#bdet-add-maintenance')
            .html('<i class="uil uil-plus me-1"></i>Schedule Maintenance');
    });

    // ── Repair — Save ─────────────────────────────────────────────────────
    $('#bdet-repair-save-btn').on('click', function () {
        var $btn  = $(this);
        var $txt  = $('#bdet-repair-save-txt');
        var $form = $('#bdet-repair-form');

        var category = $('#rep_category').val();
        var type     = $('#rep_type').val();
        var valid    = true;

        $('#rep_category_err, #rep_type_err').text('');

        if (!category) {
            $('#rep_category_err').text('Repair category is required.');
            valid = false;
        }
        if (!type) {
            $('#rep_type_err').text('Repair type is required.');
            valid = false;
        }
        if (!valid) { return; }

        $btn.prop('disabled', true);
        $txt.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…');

        $.ajax({
            method   : 'POST',
            url      : REPAIR_STORE_URL,
            data     : $form.serialize(),
            dataType : 'json',
            success  : function (res) {
                Toast.fire({ icon: 'success', title: res.message, didClose: function () { location.reload(true); } });
                $btn.prop('disabled', false);
                $txt.text('Save Repair');
            },
            error    : function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                Toast.fire({ icon: 'error', title: msg });
                $btn.prop('disabled', false);
                $txt.text('Save Repair');
            }
        });
    });

    // ── Repair — Populate Edit modal ──────────────────────────────────────
    $(document).on('click', '.bdet-repair-edit-btn', function () {
        var btn = $(this);
        $('#bdet-repair-edit-form').attr('action', btn.data('update-url'));
        $('#edit_rep_category').val(btn.data('category'));
        $('#edit_rep_type').val(btn.data('type'));
        $('#edit_rep_km').val(btn.data('km'));
        $('#edit_rep_cost').val(btn.data('cost'));
        $('#edit_rep_notes').val(btn.data('notes'));
        setDatePickerFromYmd('#edit_rep_date', btn.data('date'));
    });

    // ── Repair — Update ───────────────────────────────────────────────────
    $('#bdet-repair-update-btn').on('click', function () {
        var $btn  = $(this);
        var $txt  = $('#bdet-repair-update-txt');
        var $form = $('#bdet-repair-edit-form');

        var category = $('#edit_rep_category').val();
        var type     = $('#edit_rep_type').val();
        var valid    = true;

        $('#edit_rep_category_err, #edit_rep_type_err').text('');

        if (!category) {
            $('#edit_rep_category_err').text('Repair category is required.');
            valid = false;
        }
        if (!type) {
            $('#edit_rep_type_err').text('Repair type is required.');
            valid = false;
        }
        if (!valid) { return; }

        $btn.prop('disabled', true);
        $txt.html('<span class="spinner-border spinner-border-sm me-1"></span>Updating…');

        $.ajax({
            method   : 'POST',
            url      : $form.attr('action'),
            data     : $form.serialize(),
            dataType : 'json',
            success  : function (res) {
                Toast.fire({ icon: 'success', title: res.message, didClose: function () { location.reload(true); } });
                $btn.prop('disabled', false);
                $txt.text('Update Repair');
            },
            error    : function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                Toast.fire({ icon: 'error', title: msg });
                $btn.prop('disabled', false);
                $txt.text('Update Repair');
            }
        });
    });

    // ── Repair — Delete ───────────────────────────────────────────────────
    $(document).on('click', '.bdet-repair-delete-btn', function () {
        var url = $(this).data('delete-url');
        var id  = $(this).data('id');

        Swal.fire({
            position          : 'center',
            icon              : 'warning',
            title             : 'Delete this repair record?',
            showConfirmButton : true,
            showCancelButton  : true,
            confirmButtonText : 'Yes, Delete',
            cancelButtonText  : 'Cancel',
            confirmButtonColor: '#dc3545',
            reverseButtons    : true
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    method  : 'POST',
                    url     : url,
                    data    : { _token: CSRF_TOKEN },
                    dataType: 'json',
                    success : function (res) {
                        Toast.fire({ icon: 'success', title: res.message });
                        $('#bdet-repair-row-' + id).remove();
                        var remaining = $('#bdet-repair-tbody tr').not('#bdet-repair-empty-row').length;
                        if (remaining === 0) { $('#bdet-repair-empty-row').show(); }
                    },
                    error   : function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong.';
                        Toast.fire({ icon: 'error', title: msg });
                    }
                });
            }
        });
    });

    // ── Repair filter ─────────────────────────────────────────────────────
    $('#bdet-rep-filter-category').on('change', filterRepairs);
    $('#bdet-rep-filter-reset').on('click', function () {
        $('#bdet-rep-filter-category').val('');
        $('#bdet-rep-filter-daterange').val('');
        filterRepairs();
    });

    $('#bdet-rep-filter-daterange').daterangepicker({
        autoUpdateInput: false,
        locale         : { format: 'DD/MM/YYYY', cancelLabel: 'Clear' }
    });
    $('#bdet-rep-filter-daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        filterRepairs();
    });
    $('#bdet-rep-filter-daterange').on('cancel.daterangepicker', function () {
        $(this).val('');
        filterRepairs();
    });

    function filterRepairs() {
        var categoryVal = $('#bdet-rep-filter-category').val().toLowerCase();
        var dateRange   = $('#bdet-rep-filter-daterange').val().trim();
        var startDate   = null, endDate = null;

        if (dateRange) {
            var parts = dateRange.split(' - ');
            startDate = parts[0] ? moment(parts[0], 'DD/MM/YYYY') : null;
            endDate   = parts[1] ? moment(parts[1], 'DD/MM/YYYY') : null;
        }

        var rows    = $('#bdet-repair-tbody tr').not('#bdet-repair-empty-row');
        var visible = 0;

        rows.each(function () {
            var rowCat  = $(this).data('category') || '';
            var rowDate = $(this).data('date') || '';
            var matchCat  = !categoryVal || rowCat === categoryVal;
            var matchDate = true;
            if (startDate && rowDate) {
                var d = moment(rowDate, 'YYYY-MM-DD');
                matchDate = d.isSameOrAfter(startDate) && (!endDate || d.isSameOrBefore(endDate));
            }
            if (matchCat && matchDate) { $(this).show(); visible++; }
            else { $(this).hide(); }
        });
        $('#bdet-repair-empty-row').toggle(visible === 0 && rows.length > 0);
    }

    // ── Maintenance date-range filter (filter by next_due_date) ──────────
    $('#bdet-maint-filter-daterange').daterangepicker({
        autoUpdateInput: false,
        locale         : { format: 'DD/MM/YYYY', cancelLabel: 'Clear' }
    });
    $('#bdet-maint-filter-daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        filterMaintSchedules();
    });
    $('#bdet-maint-filter-daterange').on('cancel.daterangepicker', function () {
        $(this).val('');
        filterMaintSchedules();
    });

});
