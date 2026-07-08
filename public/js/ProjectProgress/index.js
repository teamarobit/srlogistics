/* ============================================================
   Project Progress — client sign-off board (DB-backed)
   jQuery + AJAX (RULE 3). Toast.fire (RULE 7). CSRF via header.
   Status, notes and freeze are managed from the backend/DB and
   are read-only on this page (freeze switches are disabled).
   Interactive here: file upload/remove and client approval.
   ============================================================ */
$(function () {

    // Toast mixin (RULE 7) — defined once per file.
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

    const BASE = '/project-progress';
    const CSRF = $('.pp-fullwrap').data('csrf');

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF } });

    const STATUS_SLUG = {
        'Not Started': 'not_started',
        'In Design':   'in_design',
        'Design Done': 'design_done',
        'Approved':    'approved'
    };

    function errMsg(xhr) {
        if (xhr.responseJSON) {
            if (xhr.responseJSON.message) { return xhr.responseJSON.message; }
            if (xhr.responseJSON.errors) {
                return Object.values(xhr.responseJSON.errors)[0][0];
            }
        }
        return 'Something went wrong.';
    }

    // Reflect a status change on a module card.
    function paintStatus($module, statusTitle) {
        const s = STATUS_SLUG[statusTitle] || 'not_started';
        $module.attr('data-status', s);
        $module.find('.pp-status-dot').attr('data-s', s);
        $module.find('.pp-status-tag').attr('data-s', s).text(statusTitle);
    }

    // Update phase + overall progress bars from an AJAX response.
    function paintProgress($module, res) {
        const phaseId = $module.data('phase');
        if (typeof res.progress !== 'undefined') {
            $('[data-phase-bar="' + phaseId + '"]').css('width', res.progress + '%');
            $('[data-phase-pct="' + phaseId + '"]').text(res.progress + '%');
            $('[data-phase-done="' + phaseId + '"]').text(res.progress + '% done');
        }
        if (typeof res.overall !== 'undefined') {
            $('#ppOverallBar').css('width', res.overall + '%');
            $('#ppOverallPct').text(res.overall + '%');
        }
    }

    // ── Show chosen file name + upload ─────────────────────────
    $(document).on('change', '.pp-file', function () {
        const name = this.files && this.files.length ? this.files[0].name : 'No file chosen';
        $(this).closest('.pp-uploadrow').find('.pp-file-name').text(name);

        if (!this.files || !this.files.length) { return; }

        const $module = $(this).closest('.pp-module');
        const id      = $module.data('module');
        const fd      = new FormData();
        fd.append('file', this.files[0]);

        const $input = $(this);
        $.ajax({
            url: BASE + '/modules/' + id + '/upload',
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                const item =
                    '<span class="pp-file-item" data-file="' + res.file.id + '">' +
                    '<a href="' + res.file.url + '"><i class="uil uil-file-alt"></i>' + res.file.name + '</a>' +
                    '<button type="button" class="pp-file-remove" title="Remove"><i class="uil uil-times"></i></button>' +
                    '</span>';
                $module.find('.pp-filelist').append(item);
                $input.val('');
                $module.find('.pp-file-name').text('No file chosen');
                Toast.fire({ icon: 'success', title: 'File uploaded.' });
            },
            error: function (xhr) {
                $input.val('');
                $module.find('.pp-file-name').text('No file chosen');
                Toast.fire({ icon: 'error', title: errMsg(xhr) });
            }
        });
    });

    // ── Remove a file ──────────────────────────────────────────
    $(document).on('click', '.pp-file-remove', function () {
        const $item  = $(this).closest('.pp-file-item');
        const fileId = $item.data('file');

        $.ajax({
            url: BASE + '/files/' + fileId,
            method: 'DELETE',
            success: function () {
                $item.remove();
                Toast.fire({ icon: 'success', title: 'File removed.' });
            },
            error: function (xhr) { Toast.fire({ icon: 'error', title: errMsg(xhr) }); }
        });
    });

    // ── Client approval (toggle) ───────────────────────────────
    $(document).on('change', '.pp-approval-check', function () {
        const $chk    = $(this);
        const $module = $chk.closest('.pp-module');
        const id      = $module.data('module');
        const approve = $chk.is(':checked');

        $.ajax({
            url: BASE + '/modules/' + id + '/approval',
            method: 'POST',
            data: { approved: approve ? 1 : 0 },
            success: function (res) {
                paintStatus($module, res.status);
                paintProgress($module, res);
                Toast.fire({ icon: 'success', title: res.message });
            },
            error: function (xhr) {
                $chk.prop('checked', !approve);
                Toast.fire({ icon: 'error', title: errMsg(xhr) });
            }
        });
    });

});
