/**
 * Warehouse Master — Index Page JS
 * SR Logistics | public/js/Warehouse/index.js v1.2
 *
 * SD-1:  No inline JS in blade. All logic here.
 * SD-7:  Toast.fire() for all notifications — never bare Swal.fire() for toasts.
 *
 * v1.2 (2026-05-25): BUG-001 fix — Reset button now clears search, status,
 *                    and type tab and re-runs filter. BUG-005 — empty-state
 *                    row toggled when client filter returns zero matches.
 *                    BUG-006 — explicit showDenyButton:false on delete swal.
 */

// SD-7: Define Toast mixin once at top of file
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

$(function () {

    // ── Flash toast on page load (from session flash) ─────────
    var $flash = $('#flashSuccess');
    if ($flash.length) {
        Toast.fire({ icon: 'success', title: $flash.text() });
    }

    // ── Filter: type tabs ─────────────────────────────────────
    $('#whTypeTabs .nav-link').on('click', function (e) {
        e.preventDefault();
        $('#whTypeTabs .nav-link').removeClass('active');
        $(this).addClass('active');
        filterTable();
    });

    $('#whSearch, #whStatusFilter').on('input change', filterTable);

    // ── BUG-001 fix: Reset button clears filters and re-shows full list ──
    $('.btn-reset').on('click', function (e) {
        e.preventDefault();
        $('#whSearch').val('');
        $('#whStatusFilter').val('');
        $('#whTypeTabs .nav-link').removeClass('active');
        $('#whTypeTabs .nav-link').filter(function () {
            return $(this).data('type') === '' || $(this).data('type') == null;
        }).addClass('active');
        filterTable();
    });

    function filterTable() {
        var type   = $('#whTypeTabs .nav-link.active').data('type');
        var status = $('#whStatusFilter').val().toLowerCase();
        var search = $('#whSearch').val().toLowerCase();

        var visibleCount = 0;
        var $dataRows = $('#whTable tbody tr').not('#whNoResults').not('.wh-server-empty');

        $dataRows.each(function () {
            var $r = $(this);
            var ok = (!type   || $r.data('type')   === type)
                  && (!status || $r.data('status')  === status)
                  && (!search || ($r.data('name') || '').toString().includes(search)
                              || ($r.data('city') || '').toString().includes(search)
                              || String($r.data('code') || '').includes(search));
            $r.toggle(ok);
            if (ok) visibleCount++;
        });

        // ── BUG-005 fix: show empty-state row when filters return zero matches ──
        if ($dataRows.length > 0) {
            $('#whNoResults').toggleClass('d-none', visibleCount > 0);
        }
    }

    // ── Delete (soft delete via AJAX) ─────────────────────────
    // Swal.fire() with showCancelButton is correct for confirmations (SD-7 exception)
    $(document).on('click', '.btn-delete-wh', function () {
        var id    = $(this).data('id');
        var name  = $(this).data('name');
        var token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Delete Warehouse?',
            html: 'Are you sure you want to delete <strong>' + name + '</strong>?<br>This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            showDenyButton: false,
            confirmButtonColor: '#dc2626',
            cancelButtonColor:  '#6c757d',
            confirmButtonText:  'Yes, Delete',
            cancelButtonText:   'Cancel',
            // BUG-006 fix: remove the hidden swal2-deny element from DOM (a11y nit)
            didOpen: function (popup) {
                var deny = popup.querySelector('.swal2-deny');
                if (deny) deny.remove();
            },
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: '/warehouse/master/' + id,
                type: 'DELETE',
                data: { _token: token },
                headers: { 'Accept': 'application/json' },
                success: function (res) {
                    if (res.success) {
                        Toast.fire({ icon: 'success', title: res.message });
                        setTimeout(function () { location.reload(); }, 800);
                    }
                },
                error: function (xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message
                        : 'Could not delete. Please try again.';
                    Toast.fire({ icon: 'error', title: msg });
                }
            });
        });
    });

});
