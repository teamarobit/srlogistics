/* ============================================================
   Trip Module — trip.js v1.0
   Scope: resources/views/trip/index.blade.php
   SD-1: All JS in external file — no inline scripts in blade.
   SD-7: Toast.fire() for all success/error notifications.
   SD-3: $.ajax() for all form submissions.
   ============================================================ */

$(document).ready(function () {

    /* ── Toast mixin (SD-7) ────────────────────────────────────── */
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

    /* ── Filter collapse toggle ─────────────────────────────────── */
    $('#filterToggle').on('click', function () {
        $('#filterBody').slideToggle(200);
        $(this).find('.bi').toggleClass('bi-chevron-up bi-chevron-down');
    });

    /* ── RAG Status selection ────────────────────────────────────── */
    $(document).on('click', '.rag-btn', function () {
        $('.rag-btn').removeClass('rag-selected');
        $(this).addClass('rag-selected');
        $('#ragStatusInput').val($(this).data('value'));
    });

    /* ── Open Create Trip Modal ──────────────────────────────────── */
    $('#btnAddTrip').on('click', function () {
        $('#createTripForm')[0].reset();
        $('.rag-btn').removeClass('rag-selected');
        $('#ragStatusInput').val('');
        $('#midpointRow').hide();
        $('#tripModal_id').val('Auto Generated');
        $('#createTripModal').modal('show');
    });

    /* ── Midpoint toggle ─────────────────────────────────────────── */
    $('#btnAddMidpoint').on('click', function () {
        $('#midpointRow').slideDown(150);
        $(this).hide();
    });

    /* ── Create Trip Form Submit (SD-3: $.ajax) ──────────────────── */
    $('#createTripForm').on('submit', function (e) {
        e.preventDefault();

        var $btn = $('#btnSaveTrip');
        $btn.prop('disabled', true).text('Saving…');

        $.ajax({
            url: $('#createTripForm').attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                if (res.success) {
                    $('#createTripModal').modal('hide');
                    Toast.fire({ icon: 'success', title: res.message || 'Trip created!' });
                    // Reload the page to show the new trip in the list
                    setTimeout(function () { location.reload(); }, 1200);
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Failed to save trip.' });
                }
            },
            error: function (xhr) {
                var msg = 'An error occurred.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errs = xhr.responseJSON.errors;
                    msg = Object.values(errs).flat().join(' ');
                }
                Toast.fire({ icon: 'error', title: msg });
            },
            complete: function () {
                $btn.prop('disabled', false).text('Save');
            }
        });
    });

    /* ── Delete Trip ─────────────────────────────────────────────── */
    $(document).on('click', '.btn-trip-delete', function () {
        var tripId  = $(this).data('id');
        var tripRef = $(this).data('ref');

        Swal.fire({
            title: 'Delete Trip?',
            text: 'Are you sure you want to delete ' + tripRef + '? This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/trips/' + tripId,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                            setTimeout(function () { location.reload(); }, 1000);
                        } else {
                            Toast.fire({ icon: 'error', title: res.message || 'Could not delete.' });
                        }
                    },
                    error: function () {
                        Toast.fire({ icon: 'error', title: 'Server error. Please try again.' });
                    }
                });
            }
        });
    });

    /* ── Filter Reset ────────────────────────────────────────────── */
    $('#btnReset').on('click', function () {
        $('#filterForm')[0].reset();
    });

    /* ── Own / External Vehicle Tabs ─────────────────────────────── */
    $('.trip-type-tab').on('click', function () {
        $('.trip-type-tab').removeClass('active');
        $(this).addClass('active');
        var type = $(this).data('type');
        $('#tripTypeInput').val(type);
    });

    /* ── Flash message on page load (session flash) ──────────────── */
    var flashMsg = $('#flashSuccess').text().trim();
    if (flashMsg) {
        Toast.fire({ icon: 'success', title: flashMsg });
    }

    /* ── Auto-open Create Trip modal if ?open=create in URL ──────── */
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('open') === 'create') {
        $('#createTripForm')[0].reset();
        $('.rag-btn').removeClass('rag-selected');
        $('#ragStatusInput').val('');
        $('#midpointRow').hide();
        $('#tripModal_id').val('Auto Generated');
        $('#createTripModal').modal('show');
    }

});
