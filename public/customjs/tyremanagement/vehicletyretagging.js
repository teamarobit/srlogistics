/* ═══════════════════════════════════════════════════════════════════════════
   SR Logistics — Tyre Tagging JS  |  vehicletyretagging.js  v3.0
   Handles:
     • SVG load → RAG coloring
     • SVG ↔ Card bidirectional sync (click / hover)
     • Add Tyre modal: AJAX tyre dropdown (condition+type filter, health preview)
     • Real POST save → addTyreToPosition endpoint
   ═══════════════════════════════════════════════════════════════════════════ */

const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

$(document).ready(function () {

    // ── 1. LOAD & RAG-COLOR SVG ──────────────────────────────────────────────
    const svgMap   = { 6: sixWheelTruckPath, 10: tenWheelTruckPath };
    const tyreCount = parseInt($('#type').val(), 10) || 6;
    const svgPath  = svgMap[tyreCount] || svgMap[6];

    if (svgPath) {
        $.get(svgPath, function (svgData) {
            $('#container-img').html(svgData);
            applyRagColors();
            showMountedCards(tyreCount);
        }, 'text').fail(function () {
            $('#container-img').html('<p class="text-muted text-center small mt-3">SVG not available</p>');
        });
    }

    function applyRagColors() {
        if (typeof tyreRagData === 'undefined') return;
        $('#container-img .tyre-group').each(function () {
            const code = $(this).data('code');
            const rag  = tyreRagData[code] || 'grey';
            $(this).removeClass('rag-green rag-amber rag-red rag-grey rag-untagged')
                   .addClass('rag-' + rag);
        });
    }

    function showMountedCards(count) {
        $('.mandtory_tyre_positions').hide();
        $('.mandtory_tyre_positions').each(function (index) {
            if (index < count) $(this).show();
        });
    }


    // ── 2. SVG CLICK → SCROLL + HIGHLIGHT CARD ──────────────────────────────
    $(document).on('click', '.tyre-group', function () {
        const code  = $(this).data('code');
        const $card = $('#card-' + code);

        $('#container-img .tyre-group').removeClass('active-svg');
        $(this).addClass('active-svg');

        if ($card.length) {
            $('html, body').stop().animate({ scrollTop: $card.offset().top - 80 }, 500);
            $('.tyre-card').removeClass('card-highlight');
            $card.addClass('card-highlight');
            clearTimeout($card.data('ht'));
            $card.data('ht', setTimeout(() => $card.removeClass('card-highlight'), 2500));
        }
    });


    // ── 3. HOVER SYNC SVG ↔ CARD ─────────────────────────────────────────────
    $(document).on('mouseenter', '.tyre-group', function () {
        $('#card-' + $(this).data('code')).addClass('card-highlight');
    });
    $(document).on('mouseleave', '.tyre-group', function () {
        $('#card-' + $(this).data('code')).removeClass('card-highlight');
    });
    $(document).on('mouseenter', '.tyre-card', function () {
        $('.tyre-group[data-code="' + $(this).data('position') + '"]').addClass('hovered');
    });
    $(document).on('mouseleave', '.tyre-card', function () {
        $('.tyre-group[data-code="' + $(this).data('position') + '"]').removeClass('hovered');
    });


    // ── 4. OPEN ADD TYRE MODAL — RESET + PRE-FILL ────────────────────────────
    $(document).on('click', '.btn-add-tyre', function () {
        const pos       = $(this).data('position') || '';
        const mappingId = $(this).data('mapping-id') || '';

        // Reset modal state
        $('#modalPositionLabel').text(pos);
        $('#addTyrePositionCode').val(pos);
        $('#addTyreMappingId').val(mappingId);
        $('#tyreConditionSelect').val('');
        $('#tyreTypeSelect').val('');
        resetTyreDropdown();
        $('#fitmentDateInput').val('');
        $('#kmAtFitmentInput').val('');
        clearFormErrors();
    });

    // Reset tyre dropdown to blank/disabled state
    function resetTyreDropdown() {
        $('#tyreIdSelect')
            .prop('disabled', true)
            .html('<option value="">— Select condition &amp; type first —</option>');
        $('#tyreDropdownState')
            .text('— Select condition & type to load available tyres —')
            .removeClass('text-danger text-success text-warning')
            .addClass('text-muted');
        $('#tyreHealthPreview').addClass('d-none');
    }


    // ── 5. AJAX TYRE DROPDOWN — fires when BOTH condition + type are set ──────
    function maybeFetchTyres() {
        const condition = $('#tyreConditionSelect').val();
        const type      = $('#tyreTypeSelect').val();

        if (!condition || !type) {
            resetTyreDropdown();
            return;
        }

        // Loading state
        $('#tyreIdSelect')
            .prop('disabled', true)
            .html('<option value="">Loading…</option>');
        $('#tyreDropdownState')
            .text('Fetching available tyres from warehouse…')
            .removeClass('text-danger text-success text-warning text-muted')
            .addClass('text-muted');
        $('#tyreHealthPreview').addClass('d-none');

        $.ajax({
            url     : getTyreListUrl,
            method  : 'GET',
            data    : { condition: condition, type: type },
            dataType: 'json',
            success : function (res) {
                const tyres = res.tyres || [];

                if (tyres.length === 0) {
                    $('#tyreIdSelect')
                        .prop('disabled', true)
                        .html('<option value="">No tyres available in Warehouse</option>');
                    $('#tyreDropdownState')
                        .text('No warehouse tyres match this condition & type.')
                        .removeClass('text-muted text-success text-warning')
                        .addClass('text-danger');
                    return;
                }

                // Build options with health badge in label
                let options = '<option value="">— Select Tyre —</option>';
                tyres.forEach(function (t) {
                    const healthLabel = t.health_pct !== null
                        ? ` [${t.health_pct}% health]`
                        : ' [health N/A]';
                    const ragEmoji = t.rag_status === 'green'  ? '🟢'
                                   : t.rag_status === 'amber' ? '🟡'
                                   : t.rag_status === 'red'   ? '🔴'
                                   : '⚫';
                    options += `<option value="${t.id}"
                                    data-health="${t.health_pct ?? ''}"
                                    data-rag="${t.rag_status}"
                                    data-brand="${t.tyre_brand ?? ''}"
                                    data-model="${t.tyre_model ?? ''}">
                                    ${ragEmoji} ${t.tyre_serial_number ?? 'N/A'} — ${t.tyre_brand ?? ''}${healthLabel}
                                </option>`;
                });

                $('#tyreIdSelect')
                    .prop('disabled', false)
                    .html(options);
                $('#tyreDropdownState')
                    .text(`${tyres.length} tyre(s) available in Warehouse.`)
                    .removeClass('text-muted text-danger text-warning')
                    .addClass('text-success');
            },
            error: function () {
                $('#tyreIdSelect')
                    .prop('disabled', true)
                    .html('<option value="">Error loading tyres</option>');
                $('#tyreDropdownState')
                    .text('Failed to load tyres. Please try again.')
                    .removeClass('text-muted text-success text-warning')
                    .addClass('text-danger');
            }
        });
    }

    $('#tyreConditionSelect, #tyreTypeSelect').on('change', maybeFetchTyres);


    // ── 6. TYRE SELECTED → SHOW HEALTH PREVIEW ───────────────────────────────
    $(document).on('change', '#tyreIdSelect', function () {
        const $opt     = $(this).find('option:selected');
        const healthPct = $opt.data('health');
        const rag      = $opt.data('rag') || 'grey';

        if (!$(this).val() || healthPct === '') {
            $('#tyreHealthPreview').addClass('d-none');
            return;
        }

        const pct = healthPct !== '' && healthPct !== undefined ? parseFloat(healthPct) : null;

        if (pct !== null) {
            $('#healthBarFill')
                .css('width', pct + '%')
                .removeClass('rag-bg-green rag-bg-amber rag-bg-red rag-bg-grey')
                .addClass('rag-bg-' + rag);
            $('#healthPctText').text(pct + '%');
        } else {
            $('#healthPctText').text('N/A');
            $('#healthBarFill').css('width', '0%');
        }

        const ragLabel = rag === 'green' ? '🟢 Good'
                       : rag === 'amber' ? '🟡 Moderate'
                       : rag === 'red'   ? '🔴 Critical'
                       : '⚫ Unknown';
        $('#healthRagBadge')
            .text(ragLabel)
            .removeClass('rag-badge rag-green rag-amber rag-red rag-grey')
            .addClass('rag-badge rag-' + rag);

        $('#tyreHealthPreview').removeClass('d-none');
    });


    // ── 7. SAVE — POST TO addTyreToPosition ──────────────────────────────────
    $('#saveAddTyre').on('click', function () {
        const $btn       = $(this);
        const mappingId  = $('#addTyreMappingId').val();
        const tyreId     = $('#tyreIdSelect').val();
        const fitment    = $('#fitmentDateInput').val();
        const kmFitment  = $('#kmAtFitmentInput').val();

        clearFormErrors();

        // Basic client-side guard
        let hasError = false;
        if (!$('#tyreConditionSelect').val()) { showError('err_condition',  'Tyre condition is required.'); hasError = true; }
        if (!$('#tyreTypeSelect').val())      { showError('err_tyre_type',  'Tyre type is required.');      hasError = true; }
        if (!tyreId)                          { showError('err_tyre_id',    'Please select a tyre.');        hasError = true; }
        if (!fitment)                         { showError('err_fitment_date','Fitment date is required.');   hasError = true; }
        if (hasError) return;

        if (!mappingId) {
            Toast.fire({ icon: 'error', title: 'Mapping ID missing. Please close and reopen.' });
            return;
        }

        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        $.ajax({
            url     : `${addTyreBaseUrl}/${mappingId}/add-tyre`,
            method  : 'POST',
            data    : {
                _token       : csrfToken,
                tyre_id      : tyreId,
                fitment_date : fitment,
                km_at_fitment: kmFitment || null,
            },
            dataType: 'json',
            success : function (res) {
                $('#addTyre').modal('hide');
                Toast.fire({
                    icon   : 'success',
                    title  : res.message || 'Tyre tagged successfully!',
                    didClose: function () {
                        window.location.href = res.redirect_url || window.location.href;
                    }
                });
            },
            error: function (xhr) {
                $btn.html('<i class="uil uil-save me-1"></i>Save &amp; Tag Tyre').prop('disabled', false);
                const res = xhr.responseJSON || {};

                if (xhr.status === 422 && res.errors) {
                    // Show server-side validation errors inline
                    $.each(res.errors, function (field, messages) {
                        showError('err_' + field, messages[0]);
                    });
                    Toast.fire({ icon: 'warning', title: res.message || 'Validation failed.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Something went wrong. Please try again.' });
                }
            }
        });
    });


    // ── 8. HELPER: show/clear inline errors ──────────────────────────────────
    function showError(id, msg) {
        const $el = $('#' + id);
        $el.text(msg).show();
        // Also mark corresponding input as invalid
        $el.prev('select, input, .input-group').addClass('is-invalid');
    }

    function clearFormErrors() {
        $('.invalid-feedback').text('').hide();
        $('#addTyreInlineForm select, #addTyreInlineForm input').removeClass('is-invalid');
    }


    // ── 9. REPLACE BUTTON (stub — future sprint) ──────────────────────────────
    $(document).on('click', '.btn-replace', function () {
        const pos = $(this).data('position');
        Toast.fire({ icon: 'info', title: 'Replace workflow for ' + pos + ' — coming soon.' });
    });


    // ── 10. SPARE SLOT ────────────────────────────────────────────────────────
    $('.btn-add-spare-slot').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Spare slot management — coming soon.' });
    });

});
