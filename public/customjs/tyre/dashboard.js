/* ─────────────────────────────────────────────────────────────────────────────
   Tyre Dashboard — v2.0
   Covers: tab restoration, column sort, YTD change-status AJAX, discard modal
───────────────────────────────────────────────────────────────────────────── */

const baseUrl    = window.location.origin + window.location.pathname;
const storageKey = `activeNav_${baseUrl}`;

$(document).ready(function () {

    /* ── Toast mixin ─────────────────────────────────────────────────────── */
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

    /* ── Bootstrap Tooltips ─────────────────────────────────────────────── */
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => new bootstrap.Tooltip(el));

    /* ── Daterangepicker ────────────────────────────────────────────────── */
    if ($.fn.daterangepicker) {
        $('.expiry_date').daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            locale: { format: 'MM/DD/YYYY' }
        });
    }

    /* ── Legacy search-input auto-submit ────────────────────────────────── */
    $('.search_input').on('change blur', function () {
        $('#searchform').submit();
    });

    /* ── Tab number → filter-form mapping ──────────────────────────────── */
    const tabFormMap = {
        '1': 'filter-form-1',
        '2': 'filter-form-2',
        '3': 'filter-form-3',
        '4': 'filter-form-4',
        '5': 'filter-form-5',
        '6': 'filter-form-6',
        '7': 'filter-form-7',
        '8': 'filter-form-8',
    };

    /* ── Tab Restoration: URL param → localStorage → first tab ─────────── */
    const urlParams      = new URLSearchParams(window.location.search);
    const activeTabParam = urlParams.get('active_tab');   // e.g. "tab-ready"

    let targetTabEl = null;

    if (activeTabParam) {
        // Filter form submitted — URL carries the active tab
        targetTabEl = document.querySelector(`.nav_click[data-bs-target="#${activeTabParam}"]`);
        if (targetTabEl) {
            localStorage.setItem(storageKey, `#${activeTabParam}`);
        }
    }

    if (!targetTabEl) {
        const savedNav = localStorage.getItem(storageKey);
        if (savedNav) {
            targetTabEl = document.querySelector(`.nav_click[data-bs-target="${savedNav}"]`);
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
        $(`.sortable[data-col="${currentSort}"]`).each(function () {
            $(this).addClass('sort-active');
            $(this).find('.sort-icon').text(currentDirection === 'asc' ? '↑' : '↓');
        });
    }

    /* ── Column Sort: click handler ─────────────────────────────────────── */
    $(document).on('click', '.sortable', function () {
        const col    = $(this).data('col');
        const tabNum = String($(this).closest('table[data-tab]').data('tab'));
        const formId = tabFormMap[tabNum];
        if (!formId) return;

        const $form = $('#' + formId);
        if (!$form.length) return;

        // Toggle direction if same column, else reset to asc
        const isSameCol    = ($form.find('input[name="sort"]').val() === col);
        const prevDir      = $form.find('input[name="direction"]').val() || 'asc';
        const newDirection = (isSameCol && prevDir === 'asc') ? 'desc' : 'asc';

        $form.find('input[name="sort"]').val(col);
        $form.find('input[name="direction"]').val(newDirection);

        $form.submit();
    });

    /* ── Filter auto-submit on dropdown change ──────────────────────────── */
    // Any select inside any of the 8 filter forms → submit that form immediately
    $(document).on('change', 'form[id^="filter-form-"] select', function () {
        $(this).closest('form').submit();
    });

    // Serial-number text inputs → submit on Enter key (blur already handled by browser default)
    $(document).on('keydown', 'form[id^="filter-form-"] input[type="text"]', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).closest('form').submit();
        }
    });

    /* ── YTD "Change Status" AJAX ───────────────────────────────────────── */
    $(document).on('click', '.ytd-change-status', function (e) {
        e.preventDefault();

        const newStatus = $(this).data('status');
        const url       = $(this).data('url');

        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Change Tyre Status?',
            html: `Move this tyre to <strong>${newStatus}</strong>?`,
            showCancelButton: true,
            confirmButtonText: `Yes, Move to ${newStatus}`,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-warning btn-lg me-2',
                cancelButton:  'btn btn-secondary btn-lg me-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method:   'POST',
                    url:      url,
                    data: {
                        tyre_status: newStatus,
                        _token:      $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (response) {
                        Toast.fire({
                            icon:  'success',
                            title: response.message || 'Status updated successfully.',
                            didClose: function () { location.reload(true); }
                        });
                    },
                    error: function (xhr) {
                        const msg = xhr.responseJSON?.message || 'Failed to update status.';
                        Toast.fire({ icon: 'error', title: msg });
                    }
                });
            } else {
                Toast.fire({ icon: 'info', title: 'No action taken.' });
            }
        });
    });

    /* ── Discard Tyre Modal (preserved from v1) ─────────────────────────── */
    $(document.body).on('click', '.mark_as_discard', function () {
        $('#discardTyreForm').attr('action', $(this).data('url'));
        $('#discardTyreModal').modal('show');
    });

    $(document).on('click', '.submitBtn', function () {
        $('#discardTyreForm').submit();
    });

    $('form#discardTyreForm').on('submit', function (e) {
        e.preventDefault();
        const formData  = new FormData(this);
        const actionUrl = $(this).attr('action');

        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Are you sure to discard?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Discard It',
            cancelButtonText: 'Do not discard',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger btn-lg me-2',
                cancelButton:  'btn btn-primary btn-lg me-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $('.submitBtn')
                    .html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>')
                    .attr('disabled', true);
                $('.error').html('');

                $.ajax({
                    method:      'POST',
                    data:        formData,
                    url:         actionUrl,
                    processData: false,
                    contentType: false,
                    dataType:    'json',
                    success: function (response) {
                        Toast.fire({
                            icon:  'success',
                            title: response.message,
                            didClose: function () { location.reload(true); }
                        });
                        $('#discardTyreModal').modal('hide');
                        $('.submitBtn').html('Save');
                    },
                    error: function (data) {
                        const response = data.responseJSON;
                        Toast.fire({ icon: 'error', title: response.message });
                        $.each(response.data, function (index, value) {
                            $('#' + index + '_error').text(value[0]);
                        });
                        $('.submitBtn').html('Save').attr('disabled', false);
                    }
                });
            } else {
                Toast.fire({ icon: 'info', title: 'No action taken.' });
            }
        });

        return false;
    });

});

