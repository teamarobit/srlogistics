/* =====================================================================
   SR Logistics — Spare Part Vendor Module V2 (Gate 2 — live wiring)
   Module-specific add-on to customer.js (loaded alongside it).
   External JS only (SD-1). customer.js drives form submit (#cv2CustomerForm /
   #cv2EditForm), intl-tel, Select2, status->blacklist, contact-person repeater
   and validation-error display. This file adds:
     - E3 bank-details repeater (bank_id[] select + single Primary via primary_bank)
     - List page toggle-status + delete (jQuery $.ajax — SD-3, Toast — SD-7)
   ===================================================================== */
$(function () {
    'use strict';

    var CSRF = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });

    /* SD-7 — local Toast (customer.js defines its own in a separate closure). */
    var Toast = Swal.mixin({
        toast: true, position: 'top', showConfirmButton: false,
        timer: 3000, timerProgressBar: true,
        didOpen: function (t) {
            t.addEventListener('mouseenter', Swal.stopTimer);
            t.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    /* ================= E3: Bank-details repeater ================= */
    function bankOptionsHtml() {
        var $first = $('#cv2BankWrap select[name="bank_id[]"]').first();
        return $first.length ? $first.html() : '<option value="">Choose bank</option>';
    }

    function cv2BankRowHtml() {
        return '<div class="cv2-repeat-row">' +
            '<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>' +
            '<div class="cv2-form-grid is-3">' +
              '<div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>' +
                '<select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;">' + bankOptionsHtml() + '</select></div>' +
              '<div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" placeholder="Account no"></div>' +
              '<div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" placeholder="SBIN0001234"></div>' +
              '<div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Primary</label>' +
                '<div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="primary_bank" value=""><label>Primary</label></span></div>' +
              '</div>' +
            '</div></div>';
    }

    /* Keep primary_bank radio values aligned to the bank_id[] array index. */
    function renumberBankPrimary() {
        $('#cv2BankWrap .cv2-repeat-row').each(function (i) {
            $(this).find('input[name="primary_bank"]').val(i);
        });
        if ($('#cv2BankWrap input[name="primary_bank"]:checked').length === 0) {
            $('#cv2BankWrap input[name="primary_bank"]').first().prop('checked', true);
        }
    }
    renumberBankPrimary();

    $('#cv2AddBank').on('click', function () {
        var $row = $(cv2BankRowHtml()).appendTo('#cv2BankWrap');
        try { $row.find('select[name="bank_id[]"]').select2({ width: '100%' }); } catch (e) {}
        renumberBankPrimary();
    });

    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        if ($('#cv2BankWrap .cv2-repeat-row').length <= 1) {
            Toast.fire({ icon: 'error', title: 'At least one bank account is required.' });
            return;
        }
        $(this).closest('.cv2-repeat-row').remove();
        renumberBankPrimary();
    });

    /* ================= List page — toggle status ================= */
    $(document).on('click', '.cv2-toggle-spare', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/contacts/v2/sparevendors/' + id + '/toggle-status',
            method: 'POST',
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Status updated.' });
                setTimeout(function () { window.location.reload(); }, 800);
            },
            error: function (xhr) {
                var m = (xhr.responseJSON || {}).message || 'Something went wrong.';
                Toast.fire({ icon: 'error', title: m });
            }
        });
    });

    /* ================= Documents page — delete ================= */
    $(document).on('click', '.cv2-del-spare-doc', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this document?', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post('/contacts/v2/sparevendors/attachment/delete', { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 800);
            }).fail(function (xhr) {
                var m = (xhr.responseJSON || {}).message || 'Something went wrong.';
                Toast.fire({ icon: 'error', title: m });
            });
        });
    });

    /* ================= List page — delete (SoftDeletes) ================= */
    $(document).on('click', '.cv2-del-spare', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this spare vendor?', text: 'This cannot be undone.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.ajax({
                url: '/contacts/v2/sparevendors/' + id,
                method: 'POST',
                data: { _method: 'DELETE' },
                success: function (res) {
                    Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                    setTimeout(function () { window.location.reload(); }, 800);
                },
                error: function (xhr) {
                    var m = (xhr.responseJSON || {}).message || 'Something went wrong.';
                    Toast.fire({ icon: 'error', title: m });
                }
            });
        });
    });
});
