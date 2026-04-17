/**
 * Warehouse Master — Index Page JS
 * SR Logistics | public/js/Warehouse/index.js v1.1
 *
 * SD-1:  No inline JS in blade. All logic here.
 * SD-7:  Toast.fire() for all notifications — never bare Swal.fire() for toasts.
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

    function filterTable() {
        var type   = $('#whTypeTabs .nav-link.active').data('type');
        var status = $('#whStatusFilter').val().toLowerCase();
        var search = $('#whSearch').val().toLowerCase();

        $('#whTable tbody tr').each(function () {
            var $r = $(this);
            var ok = (!type   || $r.data('type')   === type)
                  && (!status || $r.data('status')  === status)
                  && (!search || $r.data('name').includes(search)
                              || $r.data('city').includes(search)
                              || String($r.data('code')).includes(search));
            $r.toggle(ok);
        });
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
            confirmButtonColor: '#dc2626',
            cancelButtonColor:  '#6c757d',
            confirmButtonText:  'Yes, Delete',
            cancelButtonText:   'Cancel',
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
