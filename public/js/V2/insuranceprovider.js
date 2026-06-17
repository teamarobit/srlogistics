/* =====================================================================
   SR Logistics — Insurance Vendor Module V2 (Gate 2 — live AJAX wiring)
   cotype_id = 9. Flat record (E8) — single Add/Edit modal, no submodules.
   External JS only (SD-1). jQuery + Select2 + intl-tel-input + SweetAlert2.
   All submits via $.ajax (SD-3). Toast.fire for notifications (SD-7).
   Validation errors rendered into .cv2-err spans below each field (SD-4).
   intl-tel getNumber() used; national digits + dial code written back
   before serialize (SD-12/13).
   ===================================================================== */
$(function () {
    'use strict';

    var CSRF = $('meta[name="csrf-token"]').attr('content');

    /* SD-7 — Toast mixin (defined once per file) */
    var Toast = Swal.mixin({
        toast: true, position: 'top', showConfirmButton: false,
        timer: 3000, timerProgressBar: true,
        didOpen: function (t) {
            t.addEventListener('mouseenter', Swal.stopTimer);
            t.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    /* CSRF + JSON accept on every AJAX request */
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });

    var $modal = $('#cv2IpModal');
    var $form  = $('#cv2IpForm');

    /* ===============================================================
     | intl-tel-input registry (SD-12/13)
     | =============================================================== */
    var itiMap = [];
    function initPhone(el) {
        if (!el || el.dataset.itiDone === '1') { return null; }
        if (typeof window.intlTelInput !== 'function') { return null; }
        var iti = window.intlTelInput(el, {
            initialCountry: 'in', separateDialCode: true, preferredCountries: ['in'],
            utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js'
        });
        el.dataset.itiDone = '1';
        itiMap.push({ el: el, iti: iti });
        return iti;
    }
    function getIti(el) {
        for (var i = 0; i < itiMap.length; i++) { if (itiMap[i].el === el) { return itiMap[i].iti; } }
        return null;
    }
    // Write national 10-digit number to the input + dial code to the hidden field.
    function writePhone() {
        itiMap.forEach(function (rec) {
            try {
                var dc = (rec.iti.getSelectedCountryData() || {}).dialCode || '';
                var full = rec.iti.getNumber() || rec.el.value || '';
                var nat = full.replace('+' + dc, '').replace(/\D/g, '');
                rec.el.value = nat;
                if ($(rec.el).attr('name') === 'phone') {
                    $('#cv2IpPhoneCode').val(dc ? '+' + dc : '');
                }
            } catch (e) {}
        });
    }
    initPhone(document.getElementById('cv2IpPhone'));

    /* ===============================================================
     | SD-4 — validation error helpers (render into .cv2-err)
     | =============================================================== */
    function clearErr() { $form.find('.cv2-err').text(''); }
    function showErr(errors) {
        clearErr();
        if (!errors) { return; }
        $.each(errors, function (field, msgs) {
            var msg = Array.isArray(msgs) ? msgs[0] : msgs;
            var $in = $form.find('[name="' + field + '"]');
            var $f = $in.closest('.cv2-field');
            if ($f.length) { $f.find('.cv2-err').text(msg); }
        });
    }
    function handleErr(xhr) {
        if (xhr.status === 422) {
            var j = xhr.responseJSON || {};
            var errs = j.data || j.errors;
            if (errs && typeof errs === 'object') { showErr(errs); }
            if (j.message && !(errs && typeof errs === 'object')) { Toast.fire({ icon: 'error', title: j.message }); }
        } else {
            Toast.fire({ icon: 'error', title: 'Something went wrong.' });
        }
    }

    /* ===============================================================
     | Select2 inside modal (dropdownParent so it isn't clipped)
     | =============================================================== */
    $modal.on('shown.bs.modal', function () {
        $modal.find('.cv2-modal-select').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) { return; }
            try { $(this).select2({ width: '100%', dropdownParent: $modal }); } catch (e) {}
        });
    });

    /* ===============================================================
     | Add / Edit modal helpers
     | =============================================================== */
    function resetForm() {
        $form[0].reset();
        $('#cv2IpEditId').val('');
        $('#cv2IpPhoneCode').val('');
        clearErr();
        $('#cv2IpModalTitle').text('Add Insurance Vendor');
        $('#cv2IpPreview').empty();
        var iti = getIti(document.getElementById('cv2IpPhone'));
        if (iti) { try { iti.setNumber(''); } catch (e) {} }
        $('#cv2IpState').val('').trigger('change');
        $('input[name="status"][value="Active"]').prop('checked', true);
    }
    $('#cv2IpAddBtn').on('click', resetForm);

    /* logo dropzone -> hidden file input + preview */
    $('#cv2IpDrop').on('click', function () { $('#cv2IpFile').trigger('click'); });
    $('#cv2IpFile').on('change', function () {
        var f = this.files && this.files[0];
        if (f) {
            $('#cv2IpPreview').html('<img src="' + URL.createObjectURL(f) + '" alt="logo" style="max-height:60px;border-radius:8px;">');
        }
    });

    /* ===============================================================
     | Create / Update (multipart via FormData)
     | =============================================================== */
    $form.on('submit', function (e) {
        e.preventDefault();
        writePhone();
        clearErr();
        var id  = $('#cv2IpEditId').val();
        var url = id ? $form.data('update-url').replace('__ID__', id) : $form.data('save-url');
        var fd  = new FormData($form[0]);
        $.ajax({
            url: url, method: 'POST', data: fd, processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: (res && res.message) || 'Saved.' });
                $modal.modal('hide');
                setTimeout(function () { window.location.reload(); }, 900);
            },
            error: handleErr
        });
    });

    /* ---- Edit -> fetch JSON, prefill, open modal ---- */
    $(document).on('click', '.cv2-ip-edit', function () {
        var url = $(this).data('url');
        $.get(url, function (res) {
            if (!res || !res.success) {
                Toast.fire({ icon: 'error', title: (res && res.message) || 'Not found.' });
                return;
            }
            var c = res.contact;
            resetForm();
            $('#cv2IpEditId').val(c.id);
            $('#cv2IpModalTitle').text('Edit Insurance Vendor');
            $form.find('[name="company_name"]').val(c.company_name || '');
            $form.find('[name="contact_name"]').val(c.contact_name || '');
            $form.find('[name="contact_code"]').val(c.contact_code || '');
            $form.find('[name="email"]').val(c.email || '');
            $form.find('[name="gst_number"]').val(c.gst_number || '');
            $('#cv2IpState').val(c.state_id || '').trigger('change');
            $('input[name="status"][value="' + (c.status || 'Active') + '"]').prop('checked', true);
            var iti = getIti(document.getElementById('cv2IpPhone'));
            if (iti) {
                try { iti.setNumber('' + (c.ph_prefix || '') + (c.phone || '')); }
                catch (e) { try { iti.setNumber(c.phone || ''); } catch (e2) {} }
            }
            if (c.contact_image) {
                $('#cv2IpPreview').html('<img src="' + $form.data('media-base') + c.contact_image + '" alt="logo" style="max-height:60px;border-radius:8px;">');
            }
            $modal.modal('show');
        }).fail(handleErr);
    });

    /* ---- Toggle status ---- */
    $(document).on('click', '.cv2-ip-toggle', function () {
        var url = $(this).data('url');
        $.post(url, {}, function (res) {
            if (res && res.success) {
                Toast.fire({ icon: 'success', title: res.message || 'Status updated.' });
                setTimeout(function () { window.location.reload(); }, 800);
            }
        }).fail(handleErr);
    });

    /* ---- Delete (soft) — Swal confirm then DELETE ---- */
    $(document).on('click', '.cv2-ip-del', function () {
        var url = $(this).data('url');
        Swal.fire({
            title: 'Delete this insurance vendor?',
            text: 'This will move the record to trash.',
            icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Yes, delete', cancelButtonText: 'Cancel'
        }).then(function (r) {
            if (r.isConfirmed) {
                $.ajax({
                    url: url, method: 'DELETE',
                    success: function (res) {
                        Toast.fire({ icon: 'success', title: (res && res.message) || 'Deleted.' });
                        setTimeout(function () { window.location.reload(); }, 800);
                    },
                    error: handleErr
                });
            }
        });
    });
});
