/* =====================================================================
 * Trip — Resume page (prototype, client-side)
 * ---------------------------------------------------------------------
 * Full-page replacement for the former #resumeTripModal. Same concept:
 *   Date / Time / Note + a further-action choice (resume only / change
 *   vehicle / driver / both) + a mandatory reason.
 * On confirm the inputs are validated and the user is redirected to the
 * trip details page (data-details-url on #resumeTripForm).
 *
 * v1.0 | 2026-06-17 — extracted from show-v2.js Resume modal logic.
 * ===================================================================== */

$(function () {

    'use strict';

    /* SD-7 — Toast mixin (defined once per JS file) */
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

    var $form = $('#resumeTripForm');
    if (!$form.length) { return; }

    var DETAILS_URL = $form.data('details-url');

    /* Show/hide the vehicle + driver sections based on the chosen action */
    function syncResumeActionFields() {
        var action = $form.find('input[name="resume_action"]:checked').val();
        var needVehicle = (action === 'change_vehicle' || action === 'change_both');
        var needDriver  = (action === 'change_driver'  || action === 'change_both');
        $('#td2ResumeVehicleWrap').toggleClass('d-none', !needVehicle);
        $('#td2ResumeDriverWrap').toggleClass('d-none', !needDriver);
    }

    function clearResumeErrors() {
        $form.find('.td2-resume-err').text('');
    }

    /* Reset the vehicle-allocation picker (suggested cards + Add/Allocate) */
    function resumeVehReset() {
        $('input[name="td2ResumeVehSelect"]').prop('checked', false);
        $('#td2ResumeOwnVehSelect, #td2ResumeExtVehicleSelect, #td2ResumeExtVendorSelect').val('');
        $('#td2ResumeOwnVeh').prop('checked', true);
        $('.td2-resume-if-own').show();
        $('.td2-resume-if-ext').hide();
        $('#td2ResumeAssignedVehicle').val('');
        $('#td2ResumeAssignWrap').addClass('d-none').removeAttr('data-reg');
        $('#td2ResumeAssignPick').html('');
        $('#td2ResumeAssignBtn').prop('disabled', false)
            .html('<i class="uil uil-check me-1"></i> Assign Vehicle');
        renderAllocVehCard(null);
    }

    /* Build a single grid item for the detail card */
    function vcItem(label, val) {
        return '<div class="td2-vc-item"><span class="td2-vc-label">' + label +
            '</span><span class="td2-vc-val">' + (val || '—') + '</span></div>';
    }

    /* Render the selected-vehicle detail card from an <option>'s data-* attributes.
       Pass a null/empty option to hide the card. */
    function renderAllocVehCard($opt) {
        if (!$opt || !$opt.length || !$opt.val()) {
            $('#td2ResumeAllocVehWrap').addClass('d-none');
            $('#td2ResumeAllocVehCard').html('');
            return;
        }
        var d = {
            reg:         $opt.val(),
            driver:      $opt.data('driver'),
            phone:       $opt.data('phone'),
            rag:         $opt.data('rag') || 'green',
            bhv:         $opt.data('bhv') || 'green',
            bhvExp:      $opt.data('bhv-exp') || '',
            status:      $opt.data('status') || 'empty',
            statusLabel: $opt.data('status-label') || '',
            avail:       $opt.data('avail'),
            loc:         $opt.data('loc'),
            rank:        $opt.data('rank'),
            since:       $opt.data('since')
        };

        var html =
            '<div class="td2-veh-card td2-veh-card-' + d.rag + '">' +
                '<div class="td2-vc-header"><div class="td2-vc-num">' + d.reg + '</div></div>' +
                '<div class="td2-vc-grid">' +
                    vcItem('Driver Name', d.driver) +
                    vcItem('Driver Number', d.phone) +
                    '<div class="td2-vc-item"><span class="td2-vc-label">About Driver</span>' +
                        '<span class="td2-vc-val"><span class="td2-bhv-wrap">' +
                            '<span class="td2-bhv-dot td2-bhv-' + d.bhv + '"></span>' +
                            '<span class="td2-bhv-label">Behaviour</span>' +
                            '<span class="td2-bhv-exp">' + d.bhvExp + '</span>' +
                        '</span></span></div>' +
                    '<div class="td2-vc-item"><span class="td2-vc-label">Status</span>' +
                        '<span class="td2-vc-val"><span class="td2-veh-status-' + d.status + '">' +
                            d.statusLabel + '</span></span></div>' +
                    vcItem('Availability', d.avail) +
                    vcItem('Live Location', d.loc) +
                    vcItem('Vehicle Rank', d.rank) +
                    vcItem('Associated Since', d.since) +
                '</div>' +
            '</div>';

        $('#td2ResumeAllocVehCard').html(html);
        $('#td2ResumeAllocVehWrap').removeClass('d-none');
    }

    /* Reset the driver picker (selected driver's assigned-vehicle card) */
    function resumeDriverReset() {
        $('#td2ResumeDriverVehWrap').addClass('d-none');
        $('.td2-resume-driver-veh-card').addClass('d-none');
    }

    /* A driver was picked → reveal that driver's currently-assigned vehicle card */
    $(document).on('change', '#td2ResumeDriverSelect', function () {
        var key = $(this).find('option:selected').attr('data-driver-key') || '';
        $('.td2-resume-driver-veh-card').addClass('d-none');
        if (key) {
            $('.td2-resume-driver-veh-card[data-driver-key="' + key + '"]').removeClass('d-none');
            $('#td2ResumeDriverVehWrap').removeClass('d-none');
            $form.find('.td2-resume-err[data-for="driver"]').text('');
        } else {
            $('#td2ResumeDriverVehWrap').addClass('d-none');
        }
    });

    /* Own / External toggle — switching source clears any pick + detail card */
    $(document).on('change', '.td2-resume-own-veh', function () {
        $('.td2-resume-if-own').show();
        $('.td2-resume-if-ext').hide();
        $('#td2ResumeExtVehicleSelect, #td2ResumeExtVendorSelect').val('');
        renderAllocVehCard(null);
    });
    $(document).on('change', '.td2-resume-ext-veh', function () {
        $('.td2-resume-if-own').hide();
        $('.td2-resume-if-ext').show();
        $('#td2ResumeOwnVehSelect').val('');
        renderAllocVehCard(null);
    });

    /* A vehicle was picked (suggested card OR own/external select) → reveal Assign button. */
    $(document).on('change', '.td2-resume-veh-pick', function () {
        var reg;
        if ($(this).is('input[type="radio"]')) {
            reg = $(this).val();
            $('#td2ResumeOwnVehSelect, #td2ResumeExtVehicleSelect').val('');
            /* Suggested card already shows its own details — hide the alloc detail card */
            renderAllocVehCard(null);
        } else {
            reg = $(this).val();
            $('input[name="td2ResumeVehSelect"]').prop('checked', false);
            if (this.id === 'td2ResumeOwnVehSelect') { $('#td2ResumeExtVehicleSelect').val(''); }
            else { $('#td2ResumeOwnVehSelect').val(''); }
            /* Own / External pick → render the selected vehicle's detail card */
            renderAllocVehCard($(this).find('option:selected'));
        }

        /* A new pick invalidates any previous assignment */
        $('#td2ResumeAssignedVehicle').val('');
        $('#td2ResumeAssignBtn').prop('disabled', false)
            .html('<i class="uil uil-check me-1"></i> Assign Vehicle');

        if (reg) {
            $('#td2ResumeAssignPick').html('Selected: <strong>' + reg + '</strong>');
            $('#td2ResumeAssignWrap').removeClass('d-none').attr('data-reg', reg);
            $form.find('.td2-resume-err[data-for="vehicle"]').text('');
        } else {
            $('#td2ResumeAssignWrap').addClass('d-none').removeAttr('data-reg');
        }
    });

    /* Assign the picked vehicle (prototype — client side only) */
    $(document).on('click', '#td2ResumeAssignBtn', function () {
        var reg = $('#td2ResumeAssignWrap').attr('data-reg') || '';
        if (!reg) { return; }
        $('#td2ResumeAssignedVehicle').val(reg);
        $(this).prop('disabled', true)
            .html('<i class="uil uil-check-circle me-1"></i> Assigned · ' + reg);
        $form.find('.td2-resume-err[data-for="vehicle"]').text('');
        Toast.fire({ icon: 'success', title: 'Vehicle assigned.' });
    });

    /* Re-sync section visibility whenever the action changes */
    $(document).on('change', '#resumeTripForm input[name="resume_action"]', syncResumeActionFields);

    /* Confirm resume → validate, then redirect to the trip details page */
    $(document).on('click', '.td2-resume-confirm-btn', function () {
        clearResumeErrors();

        var action  = $form.find('input[name="resume_action"]:checked').val();
        var reason  = $.trim($('#td2ResumeReason').val());
        var vehicle = $('#td2ResumeAssignedVehicle').val();
        var driver  = $('#td2ResumeDriverSelect').val();
        var ok = true;

        if (!reason) {
            $form.find('.td2-resume-err[data-for="reason"]').text('Reason is required.');
            ok = false;
        }
        if ((action === 'change_vehicle' || action === 'change_both') && !vehicle) {
            $form.find('.td2-resume-err[data-for="vehicle"]').text('Please select a vehicle and click Assign.');
            ok = false;
        }
        if ((action === 'change_driver' || action === 'change_both') && !driver) {
            $form.find('.td2-resume-err[data-for="driver"]').text('Please select the new driver.');
            ok = false;
        }
        if (!ok) { return; }

        var $btn = $(this);
        $btn.prop('disabled', true)
            .html('<i class="uil uil-play-circle me-1"></i> Resuming…');

        Toast.fire({ icon: 'success', title: 'Trip resumed.' });

        /* Redirect to the trip details page */
        setTimeout(function () {
            if (DETAILS_URL) { window.location.href = DETAILS_URL; }
        }, 900);
    });

    /* ── Page init ── */
    (function initResumePage() {
        var n = new Date();
        $('#td2ResumeDate').val(n.getFullYear() + '-' +
            ('0' + (n.getMonth() + 1)).slice(-2) + '-' + ('0' + n.getDate()).slice(-2));
        $('#td2ResumeTime').val(('0' + n.getHours()).slice(-2) + ':' + ('0' + n.getMinutes()).slice(-2));

        resumeVehReset();
        resumeDriverReset();
        syncResumeActionFields();

        /* Select2 for the driver dropdown */
        $('.select2-modal').each(function () {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2({ width: '100%' });
            }
        });
    })();

});
