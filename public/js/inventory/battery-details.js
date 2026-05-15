/* =========================================================
   Battery Details Page — battery-details.js  v1.2
   ========================================================= */

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

$(document).ready(function () {

    // ── Comment form ────────────────────────────────────────────────────
    $('form#bdet-commentForm').on('submit', function (e) {
        e.preventDefault();

        $('.error').html('');
        var submitBtn     = $('.submitBtn', $(this));
        var submitBtnText = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading…</span></div>').attr('disabled', true);

        $.ajax({
            method      : 'POST',
            url         : $(this).attr('action'),
            data        : $(this).serialize(),
            dataType    : 'json',
            success     : function (response) {
                Toast.fire({
                    icon  : 'success',
                    title : response.message,
                    didClose: function () {
                        location.reload(true);
                    }
                });
                submitBtn.html(submitBtnText).attr('disabled', false);
            },
            error       : function (data) {
                var response = data.responseJSON;
                Toast.fire({ icon: 'error', title: response.message });
                if (response.errors) {
                    $.each(response.errors, function (index, value) {
                        $('#bdet-' + index + '_error').text(value[0]);
                    });
                }
                submitBtn.html(submitBtnText).attr('disabled', false);
            }
        });

        return false;
    });

    // ── Movement log filter ──────────────────────────────────────────────
    $('#bdet-log-type-filter').on('change', function () {
        var val = $(this).val();
        var events = $('.bdet-tl-event');
        if (!val) {
            events.show();
            $('#bdet-log-empty').hide();
            return;
        }
        var visible = 0;
        events.each(function () {
            if ($(this).data('event-type') === val) {
                $(this).show();
                visible++;
            } else {
                $(this).hide();
            }
        });
        $('#bdet-log-empty').toggle(visible === 0);
    });

    // ── Set-reminder toggle (Add & Edit modals) ───────────────────────────
    $(document).on('change', '.clickto-adclass', function () {
        $(this).closest('.form-group, .col-12').find('.days-beforeexpiry').toggle(this.checked);
    });

    // ── Notes modal ───────────────────────────────────────────────────────
    $(document).on('click', '.bdet-showMore', function () {
        $('#bdet-notes-content').text($(this).data('notes'));
    });

    // ── View Files modal ──────────────────────────────────────────────────
    $(document).on('click', '.bdet-view-files', function () {
        var files = $(this).data('files');
        var html  = '';
        if (!files || files.length === 0) {
            html = '<p class="text-muted">No files attached.</p>';
        } else {
            $.each(files, function (i, file) {
                var isImage = /\.(jpg|jpeg|png|webp|gif)$/i.test(file.file_name);
                if (isImage) {
                    html += '<div class="col-6 col-md-4 mb-3"><img src="' + file.url + '" class="img-fluid rounded border" /></div>';
                } else {
                    html += '<div class="col-12 mb-2"><a href="' + file.url + '" target="_blank" class="btn btn-outline-secondary btn-sm w-100"><i class="uil uil-file-alt me-1"></i>' + file.file_name + '</a></div>';
                }
            });
        }
        $('#bdet-file-preview-container').html(html);
        var modal = new bootstrap.Modal(document.getElementById('bdet-modal-files'));
        modal.show();
    });

    // ── Dropzone (Add document) ───────────────────────────────────────────
    var bdetDropzone = null;
    $('#bdet-add-document').on('shown.bs.modal', function () {
        if (bdetDropzone) { return; }
        bdetDropzone = new Dropzone('#bdet-myDropzone', {
            url              : '#',
            autoProcessQueue : false,
            maxFiles         : 5,
            maxFilesize      : 2,
            acceptedFiles    : '.jpg,.jpeg,.png,.webp,.pdf',
            addRemoveLinks   : true,
        });
    });

    $('#bdet-add-document').on('hidden.bs.modal', function () {
        if (bdetDropzone) {
            bdetDropzone.destroy();
            bdetDropzone = null;
        }
        $('form#bdet-documentForm')[0].reset();
        $('.error', '#bdet-add-document').html('');
    });

    // ── Add Document submit ───────────────────────────────────────────────
    $(document).on('click', '.bdet-docSubmitForm', function () {
        var $btn     = $(this);
        var $spinner = $('#bdet-doc-spinner');
        var $text    = $('.bdet-doc-btn-text', $btn);

        $('.error', '#bdet-add-document').html('');

        var formData = new FormData($('form#bdet-documentForm')[0]);

        // append Dropzone files
        if (bdetDropzone) {
            $.each(bdetDropzone.getAcceptedFiles(), function (i, file) {
                formData.append('files[]', file);
            });
        }

        $btn.attr('disabled', true);
        $spinner.removeClass('d-none');

        $.ajax({
            method      : 'POST',
            url         : $('form#bdet-documentForm').attr('action'),
            data        : formData,
            processData : false,
            contentType : false,
            dataType    : 'json',
            success     : function (response) {
                Toast.fire({
                    icon    : 'success',
                    title   : response.message,
                    didClose: function () { location.reload(true); }
                });
            },
            error       : function (xhr) {
                var res = xhr.responseJSON;
                Toast.fire({ icon: 'error', title: res.message || 'Upload failed.' });
                if (res.data) {
                    $.each(res.data, function (field, messages) {
                        $('#bdet-document-' + field.replace(/\./g, '-') + '-error').text(messages[0]);
                    });
                }
                $btn.attr('disabled', false);
                $spinner.addClass('d-none');
            }
        });
    });

    // ── Dropzone (Edit document) ──────────────────────────────────────────
    var bdetEditDropzone = null;
    $('#bdet-edit-document').on('shown.bs.modal', function () {
        if (bdetEditDropzone) { return; }
        bdetEditDropzone = new Dropzone('#bdet-edit-myDropzone', {
            url              : '#',
            autoProcessQueue : false,
            maxFiles         : 5,
            maxFilesize      : 2,
            acceptedFiles    : '.jpg,.jpeg,.png,.webp,.pdf',
            addRemoveLinks   : true,
        });
    });

    $('#bdet-edit-document').on('hidden.bs.modal', function () {
        if (bdetEditDropzone) {
            bdetEditDropzone.destroy();
            bdetEditDropzone = null;
        }
        $('form#bdet-editDocumentForm')[0].reset();
        $('.error', '#bdet-edit-document').html('');
    });

    // ── Populate Edit modal ────────────────────────────────────────────────
    $(document).on('click', '.bdet-item-edit', function () {
        var url            = $(this).data('url');
        var attachmentType = $(this).data('attachment_type');
        var docNumber      = $(this).data('document_number');
        var issueDate      = $(this).data('issue_date');
        var expiryDate     = $(this).data('expiry_date');
        var notes          = $(this).data('notes');
        var reminderDays   = $(this).data('reminder_days');
        var hasReminder    = $(this).data('has_reminder');

        $('form#bdet-editDocumentForm').attr('action', url);
        $('#bdet-edit-attachmenttype-dd').val(attachmentType);
        $('#bdet-edit-document-number').val(docNumber);
        $('#bdet-edit-doc-issue-date').val(issueDate);
        $('#bdet-edit-doc-expiry-date').val(expiryDate);
        $('#bdet-edit-notes').val(notes);

        if (hasReminder === 'Yes') {
            $('#bdet-edit-setReminder').prop('checked', true);
            $('#bdet-edit-reminder-days').val(reminderDays);
            $('#bdet-edit-document').find('.days-beforeexpiry').show();
        } else {
            $('#bdet-edit-setReminder').prop('checked', false);
            $('#bdet-edit-document').find('.days-beforeexpiry').hide();
        }
    });

    // ── Edit Document submit ──────────────────────────────────────────────
    $(document).on('click', '.bdet-editDocSubmitForm', function () {
        var $btn     = $(this);
        var $spinner = $('#bdet-edit-doc-spinner');

        $('.error', '#bdet-edit-document').html('');

        var formData = new FormData($('form#bdet-editDocumentForm')[0]);
        formData.append('_method', 'POST');

        if (bdetEditDropzone) {
            $.each(bdetEditDropzone.getAcceptedFiles(), function (i, file) {
                formData.append('files[]', file);
            });
        }

        $btn.attr('disabled', true);
        $spinner.removeClass('d-none');

        $.ajax({
            method      : 'POST',
            url         : $('form#bdet-editDocumentForm').attr('action'),
            data        : formData,
            processData : false,
            contentType : false,
            dataType    : 'json',
            success     : function (response) {
                Toast.fire({
                    icon    : 'success',
                    title   : response.message,
                    didClose: function () { location.reload(true); }
                });
            },
            error       : function (xhr) {
                var res = xhr.responseJSON;
                Toast.fire({ icon: 'error', title: res.message || 'Update failed.' });
                if (res.data) {
                    $.each(res.data, function (field, messages) {
                        $('#bdet-edit-document-' + field.replace(/\./g, '-') + '-error').text(messages[0]);
                    });
                }
                $btn.attr('disabled', false);
                $spinner.addClass('d-none');
            }
        });
    });

    // ── Nav tab persistence (same pattern as Tyre Details) ────────────────
    var baseUrl    = window.location.origin + window.location.pathname;
    var storageKey = 'activeNav_' + baseUrl;
    var savedNav   = localStorage.getItem(storageKey);

    $(document).on('click', '.nav_click', function () {
        var navTarget = $(this).data('bs-target');
        localStorage.setItem(storageKey, navTarget);
    });

    var targetEl;
    if (savedNav) {
        targetEl = document.querySelector('.nav_click[data-bs-target="' + savedNav + '"]');
    } else {
        targetEl = document.querySelector('.nav_click');
    }

    if (targetEl) {
        var tab = new bootstrap.Tab(targetEl);
        tab.show();
    }

});
