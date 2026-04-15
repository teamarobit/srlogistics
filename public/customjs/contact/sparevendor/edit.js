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

const csrfToken = $('meta[name="csrf-token"]').attr('content');

Dropzone.autoDiscover = false;

const dropzones = [];
const MAX_ATTACHMENTS = 4;
let attachmentIndex = 0;

function initDropzone(id) {
    const el = document.getElementById(`dropzone${id}`);
    if (!el) return;
    if (el.dropzone) return;
    if (!window.UPLOAD_URL) { console.error("Dropzone cannot initialize: UPLOAD_URL not defined"); return; }
    const dz = new Dropzone(el, {
        url: window.UPLOAD_URL,
        paramName: "file",
        maxFiles: 2,
        maxFilesize: 2,
        acceptedFiles: ".pdf,.jpg,.jpeg,.png",
        addRemoveLinks: true,
        autoProcessQueue: false,
        headers: { "X-CSRF-TOKEN": csrfToken }
    });
    dz.on("maxfilesexceeded", function(file) {
        dz.removeFile(file);
        Toast.fire({ icon: 'error', title: "Maximum 2 attachments allowed!" });
    });
    dropzones.push({ id, dz });
}


// ADD ATTACHMENT
$('#add_attachment_btn').on('click', function () {
    if (dropzones.length >= MAX_ATTACHMENTS) {
        Toast.fire({ icon: "error", title: "Maximum 4 attachments allowed." });
        return;
    }
    attachmentIndex++;
    const formData = new FormData();
    formData.append('rowindex', attachmentIndex);
    formData.append('form_type', 'Edit');
    $(this).prop('disabled', true);
    $.ajax({
        url: window.ATTACHMENT_WRAPPER, type: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        data: formData, processData: false, contentType: false, dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#uploadContainer').append(res.data.formelements);
                initDropzone(res.data.rowindex);
            } else { Toast.fire({ icon: "error", title: res.message }); }
        },
        complete: function () { $('#add_attachment_btn').prop('disabled', false); }
    });
});

// REMOVE ATTACHMENT
$(document).on('click', '.remove-attachment-btn', function () {
    const indexId = $(this).data('rowindex');
    Swal.fire({
        icon: 'warning', title: 'Remove this attachment?',
        showCancelButton: true, confirmButtonText: 'Yes, remove', cancelButtonText: 'Cancel', reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) return;
        const dzIndex = dropzones.findIndex(d => d.id == indexId);
        if (dzIndex !== -1) { dropzones[dzIndex].dz.destroy(); dropzones.splice(dzIndex, 1); }
        $('#hrl_' + indexId).remove();
        $('#attsec_' + indexId).remove();
    });
});


$(document).ready(function(){

    initDropzone(0);

    $('.table .form-control').each(function(index, value) {
        if($(this).val().length){ $(this).addClass('has-val'); }
    });
    $('.select2').select2();

    setupDependentSelect('.dependent-select', 'Choose city');

    function setupDependentSelect(firstSelectSelector, placeholder) {
        $(document).on('change', firstSelectSelector, function () {
            let $this = $(this);
            let targetId = $this.data('target');
            let $target = $('#' + targetId);
            let url = $this.find(':selected').data('url');
            $target.empty().append(`<option value="">Loading...</option>`);
            if (!url) { $target.html(`<option value="">${placeholder}</option>`); return; }
            $.ajax({
                url: url, type: 'GET',
                success: function (res) {
                    if ($target.hasClass("select2-hidden-accessible")) { $target.select2('destroy'); }
                    $target.empty().append(`<option value="">${placeholder}</option>`);
                    $.each(res, function (i, item) { $target.append(`<option value="${item.id}">${item.name}</option>`); });
                    $target.select2({ width: '100%' });
                },
                error: function (xhr) {
                    let message = (xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors)[0][0] : xhr.responseJSON?.message) || 'Something went wrong.';
                    Toast.fire({ icon: 'error', title: message });
                }
            });
        });
    }

    // Blacklist toggle
    $(document).on('click', '.contact-status', function () {
        if ($(this).val() === 'Blacklisted') { $('.statusblacklist').show(); }
        else { $('.statusblacklist').hide(); }
    });

    // Specialisation chips
    $(document).on('change', '.spec-chip input[type=checkbox]', function () {
        $(this).closest('.spec-chip').toggleClass('selected', this.checked);
    });


    // ── Edit Attachment Modal ─────────────────────────────────────────────────
    $(document).on('click', '.edit-attachment-btn', function () {
        let id = $(this).data('id');
        $('#attachment_id').val(id);
        $('#editAttachmentModal').modal('show');
    });

    $(document).on("click", "#editAttachmentBtn", function () {
        $('form#editAttachmentForm').submit();
    });

    $('form#editAttachmentForm').on("submit", function (e) {
        e.preventDefault();
        $button = $('#editAttachmentBtn');
        var formData = new FormData(this);
        $('.error').html('');
        $button.html('<div class="spinner-border spinner-border-sm" role="status"></div>').attr('disabled', true);
        $.ajax({
            method: 'POST', data: formData, url: $(this).attr('action'),
            processData: false, contentType: false, dataType: 'json',
            success: function (response) {
                Toast.fire({ icon: 'success', title: response.message });
                $button.html('Save').attr('disabled', false);
                $('#editAttachmentModal').modal('hide');
                setTimeout(function () { location.reload(); }, 1000);
            },
            error: function (data) {
                $button.html('Update').attr('disabled', false);
                if (data.status === 422 && data.responseJSON.data?.attachment_file) {
                    $('#edit_attachment_file_error').html(data.responseJSON.data.attachment_file[0]);
                } else {
                    Toast.fire({ icon: 'error', title: 'Something went wrong' });
                }
            }
        });
        return false;
    });


    // ── Contact Persons ───────────────────────────────────────────────────────
    var contactperson_rowindex = 0;

    $(document).on('click', '.add-person', function (e) {
        e.preventDefault();
        var idx = contactperson_rowindex++;
        var formData = new FormData();
        formData.append('rowindex', idx);
        $.ajax({
            headers: { 'X-CSRF-TOKEN': csrfToken },
            method: 'POST', url: CONTACTPERSON_WRAPPER,
            data: formData, processData: false, contentType: false, dataType: 'json',
            success: function (response) {
                if (response.html) {
                    const $newSection = $(response.html);
                    $('#contactPersonContainer').append($newSection);
                    $newSection.find('.select2').select2();
                }
            }
        });
    });

    $(document).on('click', '.close-sec', function (e) {
        e.preventDefault();
        $(this).closest('.contact-person').remove();
    });


    // ── Bank Details ──────────────────────────────────────────────────────────
    var bank_rowindex = 0;

    $(document).on('click', '.add-bank', function (e) {
        e.preventDefault();
        var idx = bank_rowindex++;
        var formData = new FormData();
        formData.append('rowindex', idx);
        $.ajax({
            headers: { 'X-CSRF-TOKEN': csrfToken },
            method: 'POST', url: BANK_WRAPPER,
            data: formData, processData: false, contentType: false, dataType: 'json',
            success: function (response) {
                if (response.html) {
                    const $newSection = $(response.html);
                    $('#bankDetailsContainer').append($newSection);
                    $newSection.find('.select2').select2();
                }
            }
        });
    });

    $(document).on('click', '.close-bank', function (e) {
        e.preventDefault();
        $(this).closest('.bank-data').remove();
    });

    $(document).on('change', '.bank-status[value="Yes"]', function () {
        if ($(this).is(':checked')) { $('.bank-status[value="Yes"]').not(this).prop('checked', false); }
    });


    // ── Delete Attachment ─────────────────────────────────────────────────────
    $(document.body).on('click', '.delete-attachment-btn', function () {
        var url = $(this).data('url');
        Swal.fire({
            position: 'center', icon: 'warning', title: 'Are you sure to delete it?',
            showConfirmButton: true, showCancelButton: true,
            confirmButtonText: 'Yes, Delete It', cancelButtonText: 'Do not delete',
            confirmButtonColor: '#1F75A8', reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    method: 'POST', data: {}, url: url,
                    processData: false, contentType: false,
                    error: function (data) {
                        var response = $.parseJSON(data.responseText);
                        if (response.success === true) {
                            Toast.fire({ icon: 'success', title: response.message });
                            location.reload(true);
                        } else {
                            Toast.fire({ icon: 'error', title: response.message });
                        }
                    }
                });
            } else {
                Toast.fire({ icon: 'info', title: 'No action taken.' });
            }
        });
    });


    // ── Save / Update ─────────────────────────────────────────────────────────
    $(document).on("click", "#editContactBtn", function (e) {
        $('form#editContactForm').submit();
    });

    $('form#editContactForm').on("submit", function (e) {
        e.preventDefault();

        $button = $('#editContactBtn');
        var formData = new FormData(this);

        dropzones.forEach(({ dz, id }) => {
            const coattachtype = $(`#coattachtypes_${id}`).val();
            formData.append(`attachtypes[${id}]`, coattachtype);
            dz.files.forEach((file) => {
                if (file.status !== 'removed') { formData.append(`files[${id}][]`, file); }
            });
        });

        // TDS Declaration validation
        let tdsPercentage = parseFloat($('input[name="tds_percentage"]').val());
        if (tdsPercentage === 0) {
            let hasTdsDeclaration = false;
            $('select[name="coattachtypes[]"]').each(function () {
                if ($(this).val() == 8) { hasTdsDeclaration = true; }
            });
            if (!hasTdsDeclaration) {
                let existing = $('#existing_attachtypes').val();
                if (existing) {
                    try {
                        let existingArray = JSON.parse(existing).map(Number);
                        if (existingArray.includes(8)) { hasTdsDeclaration = true; }
                    } catch (e) {}
                }
            }
            if (!hasTdsDeclaration) {
                $("#edit_coattachtype_0_error").text("TDS Declaration document is mandatory when TDS % is 0.");
                return false;
            }
        }

        $('.error').html('');
        $button.html('<div class="spinner-border spinner-border-sm" role="status"></div>').attr('disabled', true);

        $.ajax({
            method: 'POST', data: formData, url: $(this).attr('action'),
            processData: false, contentType: false, dataType: 'json',
            success: function (response) {
                if (response.success === true) {
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#editContactBtn').html('Save').attr('disabled', false);
                    setTimeout(function () { window.location.href = CONTACTS; }, 1000);
                } else {
                    Toast.fire({ icon: 'error', title: response.message });
                    $('#editContactBtn').html('Save').attr('disabled', false);
                }
            },
            error: function (data) {
                var response = $.parseJSON(data.responseText);
                if (response.success === true) {
                    Toast.fire({ icon: 'success', title: response.message, didClose: () => { window.location.href = CONTACTS; } });
                } else {
                    Toast.fire({ icon: 'error', title: response.message });
                    $.each(response.data || {}, function (index, value) {
                        if (index.includes('.')) {
                            if (index.split('.').length === 3) {
                                $('#edit_' + index.split('.').splice(0, 2).join('_') + '_error').text(value.join(''));
                            } else if (index.split('.').length === 2) {
                                $('#edit_' + index.split('.').join('_') + '_error').text(value);
                            }
                        } else {
                            $('#edit_' + index + '_error').text(value);
                        }
                    });
                }
                $button.html('Save').attr('disabled', false);
            }
        });

        return false;
    });

});
