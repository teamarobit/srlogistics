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
    if (!window.UPLOAD_URL) {
        console.error("Dropzone cannot initialize: UPLOAD_URL not defined");
        return;
    }
    const dz = new Dropzone(el, {
        url: '/upload/images',
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
    formData.append('form_type', 'Add');
    $(this).prop('disabled', true);
    $.ajax({
        url: window.ATTACHMENT_WRAPPER,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#uploadContainer').append(res.data.formelements);
                initDropzone(res.data.rowindex);
            } else {
                Toast.fire({ icon: "error", title: res.message });
            }
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


    // ── Contact Persons ───────────────────────────────────────────────────────
    var contactperson_rowindex = 1;

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
    var bank_rowindex = 1;

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


    // ── Save ──────────────────────────────────────────────────────────────────
    $(document).on("click", "#addContactBtn", function () {
        $('form#addContactForm').submit();
    });

    $('form#addContactForm').on("submit", function (e) {
        e.preventDefault();

        $button = $('#addContactBtn');
        var formData = new FormData(this);

        dropzones.forEach(({ dz, id }) => {
            const coattachtype = $(`#coattachtypes_${id}`).val();
            formData.append(`attachtypes[${id}]`, coattachtype);
            dz.files.forEach((file) => {
                if (file.status !== 'removed') { formData.append(`files[${id}][]`, file); }
            });
        });

        $('.error').html('');
        $button.html('<div class="spinner-border spinner-border-sm" role="status"></div>').attr('disabled', true);

        $.ajax({
            method: 'POST', data: formData, url: $(this).attr('action'),
            processData: false, contentType: false, dataType: 'json',
            success: function (response) {
                if (response.success === true) {
                    Toast.fire({ icon: 'success', title: response.message, didClose: () => { window.location.href = CONTACTS; } });
                } else {
                    Toast.fire({ icon: 'error', title: response.message });
                }
                $button.html('Save').attr('disabled', false);
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
                                $('#add_' + index.split('.').splice(0, 2).join('_') + '_error').text(value.join(''));
                            } else if (index.split('.').length === 2) {
                                $('#add_' + index.split('.').join('_') + '_error').text(value);
                            }
                        } else {
                            $('#add_' + index + '_error').text(value);
                        }
                    });
                }
                $button.html('Save').attr('disabled', false);
            }
        });

        return false;
    });

});
