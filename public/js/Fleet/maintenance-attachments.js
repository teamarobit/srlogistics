/*
 * Fleet Dashboard — Maintenance sub-tabs
 * Attachment viewer modal.
 *
 * Every attachment pill in the Maintenance sub-tabs carries:
 *   data-attach-title="<vehicle> — <label>"
 *   data-attach-files='[{"name":"...","type":"pdf|jpg","size":"412 KB"}]'
 *
 * SD-1: all logic lives here, never inline in the blade.
 * SD-3: jQuery delegated handler (rows may later be re-rendered over AJAX).
 */
$(document).ready(function () {

    var Toast = Swal.mixin({
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

    var ICONS = {
        pdf:  'uil-file-alt',
        jpg:  'uil-image',
        jpeg: 'uil-image',
        png:  'uil-image',
        xlsx: 'uil-file-check-alt'
    };

    function iconFor(type) {
        return ICONS[String(type).toLowerCase()] || 'uil-file';
    }

    function escapeHtml(str) {
        return $('<div>').text(str == null ? '' : str).html();
    }

    function buildCard(file) {
        var type = String(file.type || '').toLowerCase();
        return '' +
            '<div class="mtn-attach-item mtn-attach-item-' + escapeHtml(type) + '">' +
                '<span class="mtn-attach-thumb"><i class="uil ' + iconFor(type) + '"></i></span>' +
                '<div class="mtn-attach-meta">' +
                    '<p class="mtn-attach-name" title="' + escapeHtml(file.name) + '">' + escapeHtml(file.name) + '</p>' +
                    '<span class="mtn-attach-sub">' + escapeHtml(type.toUpperCase()) + ' &middot; ' + escapeHtml(file.size) + '</span>' +
                '</div>' +
                '<div class="mtn-attach-actions">' +
                    '<a href="javascript:void(0)" class="mtn-attach-btn mtn-attach-view" title="View"><i class="uil uil-eye"></i></a>' +
                    '<a href="javascript:void(0)" class="mtn-attach-btn mtn-attach-dl" title="Download"><i class="uil uil-download-alt"></i></a>' +
                '</div>' +
            '</div>';
    }

    // Only pills that actually carry attachment data. The Completed Scheduled
    // Maintenance tab reuses .mtn-attach for its "View Details" pill, which
    // opens #remarks instead and must not be hijacked here.
    $(document).on('click', '.mtn-attach[data-attach-files]', function (e) {
        e.preventDefault();

        var $pill = $(this);
        var title = $pill.data('attach-title') || 'Attachments';
        var files = $pill.data('attach-files');

        if (typeof files === 'string') {
            try {
                files = JSON.parse(files);
            } catch (err) {
                files = [];
            }
        }
        if (!Array.isArray(files)) {
            files = [];
        }

        $('#mtnAttachmentsLabel').text(title);

        var $grid  = $('#mtnAttachmentsGrid').empty();
        var $empty = $('#mtnAttachmentsEmpty');
        var $count = $('#mtnAttachmentsCount');

        if (files.length === 0) {
            $grid.addClass('d-none');
            $count.addClass('d-none');
            $empty.removeClass('d-none');
        } else {
            $empty.addClass('d-none');
            $grid.removeClass('d-none');
            $count.removeClass('d-none')
                  .text(files.length + (files.length === 1 ? ' attachment' : ' attachments'));

            var html = '';
            for (var i = 0; i < files.length; i++) {
                html += buildCard(files[i]);
            }
            $grid.html(html);
        }

        var el = document.getElementById('mtnAttachments');
        bootstrap.Modal.getOrCreateInstance(el).show();
    });

    // Static shell — no files are stored yet. Tell the user rather than 404.
    $(document).on('click', '.mtn-attach-view, .mtn-attach-dl', function (e) {
        e.preventDefault();
        Toast.fire({
            icon: 'info',
            title: 'File storage is not wired up yet.'
        });
    });

});
