/* =====================================================================
   SR Logistics — Battery Vendor Module V2 (Gate 2 — live wiring)
   Module-specific add-on to customer.js (loaded alongside it).
   External JS only (SD-1). customer.js drives the vendor form submit
   (#cv2CustomerForm / #cv2EditForm), intl-tel, Select2, status->blacklist,
   contact-person repeater and validation-error display. This file adds:
     - E3 bank-details repeater (bank_id[] + single Primary via primary_bank)
     - E6 TDS Declaration conditional notice (TDS % 0 or 1)
     - List page toggle-status + delete (SD-3 $.ajax, SD-7 Toast)
     - Documents page delete
     - E4 Battery sub-page CRUD (modal add/edit/delete by vendor_id)
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

    function failToast(xhr) {
        var m = (xhr.responseJSON || {}).message || 'Something went wrong.';
        Toast.fire({ icon: 'error', title: m });
    }

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
    if ($('#cv2BankWrap').length) { renumberBankPrimary(); }

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

    /* ================= E6: TDS Declaration conditional notice ================= */
    function cv2SyncTds() {
        var raw = $('#cv2Tds').val();
        var n = parseFloat(raw);
        var due = (raw !== '' && !isNaN(n) && (n === 0 || n === 1));
        $('#cv2TdsNotice').toggle(due);
        $('#cv2TdsDocNotice').toggle(due);
    }
    if ($('#cv2Tds').length) {
        $('#cv2Tds').on('input change', cv2SyncTds);
        cv2SyncTds();
    }

    /* ================= List page — toggle status ================= */
    $(document).on('click', '.cv2-toggle-battery', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/contacts/v2/battery-vendors/' + id + '/toggle-status',
            method: 'POST',
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Status updated.' });
                setTimeout(function () { window.location.reload(); }, 800);
            },
            error: failToast
        });
    });

    /* ================= List page — delete (SoftDeletes) ================= */
    $(document).on('click', '.cv2-del-battery', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this battery vendor?', text: 'This cannot be undone.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.ajax({
                url: '/contacts/v2/battery-vendors/' + id,
                method: 'POST',
                data: { _method: 'DELETE' },
                success: function (res) {
                    Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                    setTimeout(function () { window.location.reload(); }, 800);
                },
                error: failToast
            });
        });
    });

    /* ================= Documents page — delete ================= */
    $(document).on('click', '.cv2-del-battery-doc', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this document?', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post('/contacts/v2/battery-vendors/attachment/delete', { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 800);
            }).fail(failToast);
        });
    });

    /* ================= E4: Battery sub-page CRUD ================= */
    var $bForm = $('#cv2BatteryForm');

    function clearBatteryErrors() { $bForm.find('.field-error').remove(); }

    function showBatteryErrors(errors) {
        clearBatteryErrors();
        if (!errors) { return; }
        $.each(errors, function (field, messages) {
            var msg = Array.isArray(messages) ? messages[0] : messages;
            var $input = $bForm.find('[name="' + field + '"]');
            var $field = $input.closest('.cv2-field');
            var $span = $('<span class="text-danger small d-block mt-1 field-error"></span>').text(msg);
            if ($field.length) { $field.append($span); }
        });
    }

    function resetBatteryForm() {
        if (!$bForm.length) { return; }
        $bForm[0].reset();
        $('#cv2BatteryId').val('');
        clearBatteryErrors();
        $('#cv2BatteryModalTitle').text('Add Battery');
        $bForm.find('input[name="current_status"]').first().prop('checked', true);
    }

    $('#cv2AddBatteryBtn').on('click', resetBatteryForm);

    $(document).on('click', '.cv2-edit-battery', function () {
        var id = $(this).data('id');
        var base = $bForm.data('get-base');
        $.get(base + '/' + id, function (res) {
            if (!res || !res.success) { Toast.fire({ icon: 'error', title: 'Could not load battery.' }); return; }
            var d = res.data;
            clearBatteryErrors();
            $('#cv2BatteryId').val(d.id);
            $bForm.find('[name="battery_serial"]').val(d.battery_serial);
            $bForm.find('[name="battery_brand"]').val(d.battery_brand);
            $bForm.find('[name="battery_model"]').val(d.battery_model);
            $bForm.find('[name="battery_capacity"]').val(d.battery_capacity);
            $bForm.find('[name="battery_voltage"]').val(d.battery_voltage);
            $bForm.find('[name="battery_warranty_months"]').val(d.battery_warranty_months);
            $bForm.find('[name="battery_purchase_date"]').val(d.battery_purchase_date);
            $bForm.find('[name="battery_purchase_cost"]').val(d.battery_purchase_cost);
            $bForm.find('[name="battery_notes"]').val(d.battery_notes);
            $bForm.find('input[name="current_status"][value="' + (d.current_status || 'In Stock') + '"]').prop('checked', true);
            $('#cv2BatteryModalTitle').text('Edit Battery');
            $('#cv2BatteryModal').modal('show');
        }).fail(failToast);
    });

    $bForm.on('submit', function (e) {
        e.preventDefault();
        clearBatteryErrors();
        var id = $('#cv2BatteryId').val();
        var url = id ? ($bForm.data('update-base') + '/' + id + '/update') : $bForm.data('save-url');
        var fd = new FormData($bForm[0]);
        $.ajax({
            url: url, method: 'POST', data: fd, processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Saved.' });
                $('#cv2BatteryModal').modal('hide');
                setTimeout(function () { window.location.reload(); }, 800);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var j = xhr.responseJSON || {};
                    showBatteryErrors(j.data || j.errors);
                    Toast.fire({ icon: 'error', title: j.message || 'Please check the form.' });
                } else { failToast(xhr); }
            }
        });
    });

    $(document).on('click', '.cv2-del-battery-item', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this battery?', text: 'This cannot be undone.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post('/contacts/v2/battery-vendors/battery/delete', { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 800);
            }).fail(failToast);
        });
    });
});
