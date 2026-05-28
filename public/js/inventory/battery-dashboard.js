/**
 * SR Logistics — Battery Dashboard
 * File: public/js/inventory/battery-dashboard.js
 * Version: 3.1
 * SD-1 : All JS here — zero inline scripts in Blade.
 * SD-3 : jQuery $.ajax() for AJAX calls.
 * SD-7 : Toast.fire() for all notifications.
 * SD-8 : find() + manual 422 — no findOrFail() in AJAX routes.
 * SD-9 : HTTP status codes on all responses.
 */

const baseUrl    = window.location.origin + window.location.pathname;
const storageKey = 'activeBatNav_' + baseUrl;

$(document).ready(function () {

    /* ── Toast mixin (SD-7) ─────────────────────────────────────────────── */
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: function (toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    /* ── Bootstrap Tooltips ─────────────────────────────────────────────── */
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(function (el) { new bootstrap.Tooltip(el); });

    /* ── Tab number → filter-form ID mapping ───────────────────────────── */
    const tabFormMap = {
        '1': 'bat-filter-form-1',
        '2': 'bat-filter-form-2',
        '3': 'bat-filter-form-3',
        '4': 'bat-filter-form-4',
        '5': 'bat-filter-form-5',
        '6': 'bat-filter-form-6',
        '7': 'bat-filter-form-7',
        '8': 'bat-filter-form-8',
    };

    /* ── Tab Restoration: URL param → localStorage → first tab ─────────── */
    const urlParams      = new URLSearchParams(window.location.search);
    const activeTabParam = urlParams.get('active_tab');   // e.g. "bat-tab-ready"

    let targetTabEl = null;

    if (activeTabParam) {
        targetTabEl = document.querySelector('.nav_click[data-bs-target="#' + activeTabParam + '"]');
        if (targetTabEl) {
            localStorage.setItem(storageKey, '#' + activeTabParam);
        }
    }

    if (!targetTabEl) {
        const savedNav = localStorage.getItem(storageKey);
        if (savedNav) {
            targetTabEl = document.querySelector('.nav_click[data-bs-target="' + savedNav + '"]');
        }
    }

    if (!targetTabEl) {
        targetTabEl = document.querySelector('.nav_click');
    }

    if (targetTabEl) {
        new bootstrap.Tab(targetTabEl).show();
    }

    /* ── Save tab on click ──────────────────────────────────────────────── */
    $(document).on('click', '.nav_click', function () {
        localStorage.setItem(storageKey, $(this).data('bs-target'));
    });

    /* ── Sort Indicators: mark active column on page load ──────────────── */
    const currentSort      = urlParams.get('sort');
    const currentDirection = urlParams.get('direction') || 'asc';

    if (currentSort) {
        $('.sortable[data-col="' + currentSort + '"]').each(function () {
            $(this).addClass('sort-active');
            $(this).find('.sort-icon').text(currentDirection === 'asc' ? '↑' : '↓');
        });
    }

    /* ── Column Sort: click handler ─────────────────────────────────────── */
    $(document).on('click', '.sortable', function () {
        var col    = $(this).data('col');
        var tabNum = String($(this).closest('table[data-tab]').data('tab'));
        var formId = tabFormMap[tabNum];
        if (!formId) return;

        var $form = $('#' + formId);
        if (!$form.length) return;

        /* Toggle direction if same column, else reset to asc */
        var isSameCol    = ($form.find('input[name="sort"]').val() === col);
        var prevDir      = $form.find('input[name="direction"]').val() || 'asc';
        var newDirection = (isSameCol && prevDir === 'asc') ? 'desc' : 'asc';

        $form.find('input[name="sort"]').val(col);
        $form.find('input[name="direction"]').val(newDirection);

        $form.submit();
    });

    /* ── Filter auto-submit on dropdown change ──────────────────────────── */
    $(document).on('change', 'form[id^="bat-filter-form-"] select', function () {
        $(this).closest('form').submit();
    });

    /* Text inputs: submit on Enter */
    $(document).on('keydown', 'form[id^="bat-filter-form-"] input[type="text"]', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).closest('form').submit();
        }
    });

    /* ── YTD Change Status: open modal ─────────────────────────────────── */
    $(document).on('click', '.bat-btn-change-status', function () {
        var batId     = $(this).data('id');
        var batSerial = $(this).data('serial');
        $('#batChangeSerial').text(batSerial || '—');
        $('#batChangeStatusModal').data('bat-id', batId).modal('show');
    });

    /* ── Store original HTML of change-status option buttons ───────────── */
    $(document).on('shown.bs.modal', '#batChangeStatusModal', function () {
        $('.bat-btn-change-status-opt').each(function () {
            if (!$(this).data('original-html')) {
                $(this).data('original-html', $(this).html());
            }
            /* reset disabled/spinner state */
            $(this).prop('disabled', false).html($(this).data('original-html'));
        });
    });

    /* ── YTD Change Status: select new status ──────────────────────────── */
    $(document).on('click', '.bat-btn-change-status-opt', function () {
        var batId     = $('#batChangeStatusModal').data('bat-id');
        var newStatus = $(this).data('new-status');
        var $btn      = $(this);

        if (!batId || !newStatus) return;

        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Change Battery Status?',
            html: 'Move this battery to <strong>' + newStatus + '</strong>?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Move to ' + newStatus,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-warning btn-lg me-2',
                cancelButton:  'btn btn-secondary btn-lg me-2'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.isConfirmed) {
                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status"></span>'
                );

                $.ajax({
                    method:   'POST',
                    url:      '/inventory/battery/' + batId + '/change-status',
                    data: {
                        new_status: newStatus,
                        _token:     $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (response) {
                        $('#batChangeStatusModal').modal('hide');
                        Toast.fire({
                            icon:  'success',
                            title: response.message || 'Battery status updated.',
                            didClose: function () { location.reload(true); }
                        });
                    },
                    error: function (xhr) {
                        $btn.prop('disabled', false).html($btn.data('original-html') || newStatus);
                        var msg = (xhr.responseJSON && xhr.responseJSON.message)
                            ? xhr.responseJSON.message
                            : 'Failed to update status.';
                        Toast.fire({ icon: 'error', title: msg });
                    }
                });
            } else {
                Toast.fire({ icon: 'info', title: 'No action taken.' });
            }
        });
    });

});
