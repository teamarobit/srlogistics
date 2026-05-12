/* ═══════════════════════════════════════════════════════════════════════════
   SR Logistics — Tyre Tagging v2 JS  |  vehicletyretagging-v2.js  v2.0
   Handles:
     • All v1 behaviour (SVG RAG, SVG↔card sync, Allocate Tyre, Add Spare)
     • Take Action Modal (v2 — new):
         – Open handler: populate header from data-* attributes
         – Tab switching (Replace / Rotate / Alignment)
         – Replace tab: reason, damage resp, driver fine conditional,
           source card selection, 4 source panels, old tyre destination/action
           Donor vehicle ≠ current vehicle validation (client + server)
           tamSubmitReplace() — full AJAX POST to /log-replace
         – Rotate tab: reason cards, interval alert, health alert,
           dynamic mapping rows, invoice photo
         – Alignment tab: overdue/early alerts, invoice photo
           tamSubmitAlignment() — full AJAX POST to /log-alignment
         – Photo thumbnail previews throughout
         – Full form reset on modal close
   ═══════════════════════════════════════════════════════════════════════════ */

/* ── Toast mixin ──────────────────────────────────────────────────────────── */
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

    /* ════════════════════════════════════════════════════════════════════════
       SECTION A — INHERITED V1 FUNCTIONALITY
       (SVG RAG, card sync, Allocate Tyre modal, Add Spare modal)
    ════════════════════════════════════════════════════════════════════════ */

    // ── A1. RAG-COLOR SVG ────────────────────────────────────────────────────
    const tyreCount = parseInt($('#type').val(), 10) || 10;
    applyRagColors();
    showMountedCards(tyreCount);

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

    // ── A2. SVG CLICK → SCROLL + HIGHLIGHT CARD ──────────────────────────────
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

    // ── A3. HOVER SYNC SVG ↔ CARD ────────────────────────────────────────────
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

    // ── A4. OPEN ALLOCATE TYRE MODAL ─────────────────────────────────────────
    $(document).on('click', '.btn-add-tyre', function () {
        const pos       = $(this).data('position') || '';
        const mappingId = $(this).data('mapping-id') || '';

        $('#modalPositionLabel').text(pos);
        $('#addTyrePositionCode').val(pos);
        $('#addTyreMappingId').val(mappingId);

        $('#srcWarehouse').prop('checked', true);
        showWarehouseSection();

        $('#tyreConditionSelect').val('');
        $('#tyreTypeSelect').val('');
        resetTyreDropdown();

        $('#wh_tyreBrand').val('');
        $('#wh_tyreSerial').val('');
        $('#directTyreBrand').val('');
        $('#directTyreSerial').val('');

        $('#fitmentDateInput').val('');
        $('#kmAtFitmentInput').val('');
        $('#kmOdoHint').addClass('d-none');
        $('#kmOdoWarning').addClass('d-none');

        if (typeof lastKnownKm !== 'undefined' && lastKnownKm && lastKnownDate) {
            const formatted = new Date(lastKnownDate).toLocaleDateString('en-IN', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
            $('#kmHintKm').text(lastKnownKm.toLocaleString('en-IN'));
            $('#kmHintDate').text(formatted);
            $('#kmOdoHint').removeClass('d-none');
        }

        $('#photoSerial, #photoFitment, #photoOdometer').val('');
        $('#previewSerial, #previewFitment, #previewOdometer').addClass('d-none').find('img').attr('src', '');

        clearFormErrors();
    });

    function showWarehouseSection() {
        $('#srcWarehouseSection').removeClass('d-none');
        $('#srcDirectSection').addClass('d-none');
        $('#directTyreBrand').removeAttr('required');
        $('#directTyreSerial').removeAttr('required');
    }

    function showDirectSection() {
        $('#srcWarehouseSection').addClass('d-none');
        $('#srcDirectSection').removeClass('d-none');
        resetTyreDropdown();
        $('#wh_tyreBrand').val('');
        $('#wh_tyreSerial').val('');
    }

    function resetTyreDropdown() {
        $('#tyreIdSelect')
            .prop('disabled', true)
            .html('<option value="">— Select condition &amp; type first —</option>');
        $('#tyreDropdownState')
            .text('— Select condition & type to load available tyres —')
            .removeClass('text-danger text-success text-warning')
            .addClass('text-muted');
        $('#tyreHealthPreview').addClass('d-none');
        $('#wh_tyreBrand').val('');
        $('#wh_tyreSerial').val('');
    }

    // ── A5. SOURCE TOGGLE ────────────────────────────────────────────────────
    $(document).on('change', 'input[name="tyre_source"]', function () {
        clearFormErrors();
        if ($(this).val() === 'SR Warehouse') {
            showWarehouseSection();
        } else {
            showDirectSection();
        }
    });

    // ── A6. AJAX TYRE DROPDOWN ───────────────────────────────────────────────
    function maybeFetchTyres() {
        if ($('#srcWarehouse').is(':checked') === false) return;
        const condition = $('#tyreConditionSelect').val();
        const type      = $('#tyreTypeSelect').val();

        if (!condition || !type) { resetTyreDropdown(); return; }

        $('#tyreIdSelect').prop('disabled', true).html('<option value="">Loading…</option>');
        $('#tyreDropdownState').text('Fetching…').removeClass('text-danger text-success text-warning text-muted').addClass('text-muted');
        $('#tyreHealthPreview').addClass('d-none');
        $('#wh_tyreBrand').val('');
        $('#wh_tyreSerial').val('');

        $.ajax({
            url: getTyreListUrl, method: 'GET', data: { condition, type }, dataType: 'json',
            success: function (res) {
                const tyres = res.tyres || [];
                if (tyres.length === 0) {
                    $('#tyreIdSelect').prop('disabled', true).html('<option value="">No tyres available</option>');
                    $('#tyreDropdownState').text('No warehouse tyres match.').removeClass('text-muted text-success text-warning').addClass('text-danger');
                    return;
                }
                let options = '<option value="">— Select Tyre —</option>';
                tyres.forEach(function (t) {
                    const healthLabel = t.health_pct !== null ? ` [${t.health_pct}% health]` : ' [health N/A]';
                    const ragEmoji = t.rag_status === 'green' ? '🟢' : t.rag_status === 'amber' ? '🟡' : t.rag_status === 'red' ? '🔴' : '⚫';
                    options += `<option value="${t.id}" data-health="${t.health_pct ?? ''}" data-rag="${t.rag_status}" data-brand="${t.tyre_brand ?? ''}" data-serial="${t.tyre_serial_number ?? ''}">${ragEmoji} ${t.tyre_serial_number ?? 'N/A'} — ${t.tyre_brand ?? ''}${healthLabel}</option>`;
                });
                $('#tyreIdSelect').prop('disabled', false).html(options);
                $('#tyreDropdownState').text(`${tyres.length} tyre(s) available.`).removeClass('text-muted text-danger text-warning').addClass('text-success');
            },
            error: function () {
                $('#tyreIdSelect').prop('disabled', true).html('<option value="">Error loading tyres</option>');
                $('#tyreDropdownState').text('Failed to load tyres.').removeClass('text-muted text-success text-warning').addClass('text-danger');
            }
        });
    }
    $('#tyreConditionSelect, #tyreTypeSelect').on('change', maybeFetchTyres);

    // ── A7. TYRE SELECTED → HEALTH PREVIEW ───────────────────────────────────
    $(document).on('change', '#tyreIdSelect', function () {
        const $opt      = $(this).find('option:selected');
        const healthPct = $opt.data('health');
        const rag       = $opt.data('rag') || 'grey';
        $('#wh_tyreBrand').val($opt.data('brand') || '');
        $('#wh_tyreSerial').val($opt.data('serial') || '');

        if (!$(this).val() || healthPct === '') { $('#tyreHealthPreview').addClass('d-none'); return; }
        const pct = parseFloat(healthPct);
        if (!isNaN(pct)) {
            $('#healthBarFill').css('width', pct + '%').removeClass('rag-bg-green rag-bg-amber rag-bg-red rag-bg-grey').addClass('rag-bg-' + rag);
            $('#healthPctText').text(pct + '%');
        }
        const ragLabel = rag === 'green' ? '🟢 Good' : rag === 'amber' ? '🟡 Moderate' : rag === 'red' ? '🔴 Critical' : '⚫ Unknown';
        $('#healthRagBadge').text(ragLabel).removeClass('rag-badge rag-green rag-amber rag-red rag-grey').addClass('rag-badge rag-' + rag);
        $('#tyreHealthPreview').removeClass('d-none');
    });

    // ── A8. ODOMETER VALIDATION ───────────────────────────────────────────────
    function validateOdometer() {
        if (typeof lastKnownKm === 'undefined' || !lastKnownKm || !lastKnownDate) return true;
        const fitDate = $('#fitmentDateInput').val();
        const kmVal   = $('#kmAtFitmentInput').val();
        if (!fitDate || kmVal === '') { $('#kmOdoWarning').addClass('d-none'); return true; }
        const fDate = new Date(fitDate), lDate = new Date(lastKnownDate);
        const enteredKm = parseFloat(kmVal);
        if (fDate >= lDate && enteredKm < lastKnownKm) {
            const formatted = lDate.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
            $('#kmOdoWarningText').text('KM must be ≥ ' + lastKnownKm.toLocaleString('en-IN') + ' (last recorded on ' + formatted + ').');
            $('#kmOdoWarning').removeClass('d-none');
            return false;
        }
        $('#kmOdoWarning').addClass('d-none');
        return true;
    }
    $('#fitmentDateInput, #kmAtFitmentInput').on('change input', validateOdometer);

    // ── A9. PHOTO PREVIEWS (Allocate Tyre modal) ──────────────────────────────
    function setupPhotoPreview(inputId, previewId) {
        $(document).on('change', '#' + inputId, function () {
            const file = this.files[0];
            if (!file) { $('#' + previewId).addClass('d-none'); return; }
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#' + previewId).find('img').attr('src', e.target.result);
                $('#' + previewId).removeClass('d-none');
            };
            reader.readAsDataURL(file);
        });
    }
    setupPhotoPreview('photoSerial',   'previewSerial');
    setupPhotoPreview('photoFitment',  'previewFitment');
    setupPhotoPreview('photoOdometer', 'previewOdometer');

    // ── A10. SAVE ALLOCATE TYRE ───────────────────────────────────────────────
    $('#saveAddTyre').on('click', function () {
        const $btn      = $(this);
        const source    = $('input[name="tyre_source"]:checked').val();
        const condition = $('#tyreConditionSelect').val();
        const type      = $('#tyreTypeSelect').val();
        const fitment   = $('#fitmentDateInput').val();
        const km        = $('#kmAtFitmentInput').val();
        const mappingId = $('#addTyreMappingId').val();

        clearFormErrors();
        let hasError = false;
        if (!source)    { showError('err_tyre_source',    'Tyre source is required.');    hasError = true; }
        if (!condition) { showError('err_tyre_condition', 'Tyre condition is required.'); hasError = true; }
        if (!type)      { showError('err_tyre_type',      'Tyre type is required.');      hasError = true; }
        if (source === 'SR Warehouse') {
            if (!$('#tyreIdSelect').val()) { showError('err_tyre_id', 'Please select a tyre.'); hasError = true; }
        } else {
            if (!$('#directTyreBrand').val().trim())  { showError('err_tyre_brand',         'Tyre brand is required.');         hasError = true; }
            if (!$('#directTyreSerial').val().trim()) { showError('err_tyre_serial_number', 'Tyre serial number is required.'); hasError = true; }
        }
        if (!fitment) { showError('err_fitment_date', 'Fitment date is required.'); hasError = true; }
        if (!validateOdometer()) { showError('err_km_at_fitment', $('#kmOdoWarningText').text()); hasError = true; }
        if (hasError) return;
        if (!mappingId) { Toast.fire({ icon: 'error', title: 'Mapping ID missing.' }); return; }

        const fd = new FormData();
        fd.append('_token', csrfToken);
        fd.append('tyre_source', source);
        fd.append('tyre_condition', condition);
        fd.append('tyre_type', type);
        fd.append('fitment_date', fitment);
        if (km) fd.append('km_at_fitment', km);
        if (source === 'SR Warehouse') {
            fd.append('tyre_id', $('#tyreIdSelect').val());
        } else {
            fd.append('tyre_brand', $('#directTyreBrand').val().trim());
            fd.append('tyre_serial_number', $('#directTyreSerial').val().trim());
        }
        const photoFields = { photo_serial: '#photoSerial', photo_fitment: '#photoFitment', photo_odometer: '#photoOdometer' };
        $.each(photoFields, function (fieldName, selector) {
            const input = $(selector)[0];
            if (input && input.files && input.files[0]) fd.append(fieldName, input.files[0]);
        });

        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        $.ajax({
            url: `${addTyreBaseUrl}/${mappingId}/add-tyre`, method: 'POST',
            data: fd, contentType: false, processData: false, dataType: 'json',
            success: function (res) {
                $('#addTyre').modal('hide');
                Toast.fire({ icon: 'success', title: res.message || 'Tyre allocated successfully!',
                    didClose: function () { window.location.href = res.redirect_url || window.location.href; } });
            },
            error: function (xhr) {
                $btn.html('<i class="uil uil-tag-alt me-1"></i>Save &amp; Allocate Tyre').prop('disabled', false);
                const res = xhr.responseJSON || {};
                if (xhr.status === 422 && res.errors) {
                    $.each(res.errors, function (field, messages) { showError('err_' + field, messages[0]); });
                    Toast.fire({ icon: 'warning', title: res.message || 'Validation failed.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Something went wrong.' });
                }
            }
        });
    });

    function showError(id, msg) {
        const $el = $('#' + id);
        $el.text(msg).show();
        $el.prev('select, input, .input-group').addClass('is-invalid');
    }
    function clearFormErrors() {
        $('#addTyreInlineForm .invalid-feedback').text('').hide();
        $('#addTyreInlineForm select, #addTyreInlineForm input').removeClass('is-invalid');
        $('#kmOdoWarning').addClass('d-none');
    }

    // ── A11. OPEN ADD SPARE MODAL ────────────────────────────────────────────
    $(document).on('click', '.btn-add-spare-slot', function () {
        // Reset source toggle to Warehouse
        $('#spareSrcWarehouse').prop('checked', true);
        showSpareWarehouseSection();

        // Reset condition + type
        $('#spareTyreConditionSelect').val('');
        $('#spareTyreTypeSelect').val('');
        resetSpareTyreDropdown();

        // Reset auto-fill + direct fitment fields
        $('#spareWh_tyreBrand').val('');
        $('#spareWh_tyreSerial').val('');
        $('#spareDirectTyreBrand').val('');
        $('#spareDirectTyreSerial').val('');

        // Reset date / km
        $('#spareFitmentDateInput').val('');
        $('#spareKmAtFitmentInput').val('');
        $('#spareKmOdoHint').addClass('d-none');
        $('#spareKmOdoWarning').addClass('d-none');

        // Show odometer hint if vehicle has a last recorded KM
        if (typeof lastKnownKm !== 'undefined' && lastKnownKm && lastKnownDate) {
            const formatted = new Date(lastKnownDate).toLocaleDateString('en-IN', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
            $('#spareKmHintKm').text(lastKnownKm.toLocaleString('en-IN'));
            $('#spareKmHintDate').text(formatted);
            $('#spareKmOdoHint').removeClass('d-none');
        }

        // Reset photos
        $('#sparePhotoSerial, #sparePhotoFitment, #sparePhotoOdometer').val('');
        $('#sparePreviewSerial, #sparePreviewFitment, #sparePreviewOdometer').addClass('d-none').find('img').attr('src', '');

        clearSpareFormErrors();
    });

    function showSpareWarehouseSection() {
        $('#spareWarehouseSection').removeClass('d-none');
        $('#spareDirectSection').addClass('d-none');
        $('#spareDirectTyreBrand').removeAttr('required');
        $('#spareDirectTyreSerial').removeAttr('required');
    }

    function showSpareDirectSection() {
        $('#spareWarehouseSection').addClass('d-none');
        $('#spareDirectSection').removeClass('d-none');
        resetSpareTyreDropdown();
        $('#spareWh_tyreBrand').val('');
        $('#spareWh_tyreSerial').val('');
    }

    function resetSpareTyreDropdown() {
        $('#spareTyreIdSelect')
            .prop('disabled', true)
            .html('<option value="">— Select condition &amp; type first —</option>');
        $('#spareTyreDropdownState')
            .text('— Select condition & type to load available tyres —')
            .removeClass('text-danger text-success text-warning')
            .addClass('text-muted');
        $('#spareTyreHealthPreview').addClass('d-none');
        $('#spareWh_tyreBrand').val('');
        $('#spareWh_tyreSerial').val('');
    }

    // ── A11b. SPARE SOURCE TOGGLE ────────────────────────────────────────────
    $(document).on('change', 'input[name="spare_tyre_source"]', function () {
        clearSpareFormErrors();
        if ($(this).val() === 'SR Warehouse') {
            showSpareWarehouseSection();
        } else {
            showSpareDirectSection();
        }
    });

    // ── A12. SPARE AJAX TYRE DROPDOWN ────────────────────────────────────────
    function maybeFetchSpareTyres() {
        if ($('#spareSrcWarehouse').is(':checked') === false) return;
        const condition = $('#spareTyreConditionSelect').val();
        const type      = $('#spareTyreTypeSelect').val();
        if (!condition || !type) { resetSpareTyreDropdown(); return; }

        $('#spareTyreIdSelect').prop('disabled', true).html('<option value="">Loading…</option>');
        $('#spareTyreDropdownState').text('Fetching…').removeClass('text-danger text-success text-warning text-muted').addClass('text-muted');
        $('#spareTyreHealthPreview').addClass('d-none');
        $('#spareWh_tyreBrand').val('');
        $('#spareWh_tyreSerial').val('');

        $.ajax({
            url: getTyreListUrl, method: 'GET', data: { condition, type }, dataType: 'json',
            success: function (res) {
                const tyres = res.tyres || [];
                if (tyres.length === 0) {
                    $('#spareTyreIdSelect').prop('disabled', true).html('<option value="">No tyres available</option>');
                    $('#spareTyreDropdownState').text('No warehouse tyres match.').removeClass('text-muted text-success text-warning').addClass('text-danger');
                    return;
                }
                let options = '<option value="">— Select Tyre —</option>';
                tyres.forEach(function (t) {
                    const healthLabel = t.health_pct !== null ? ` [${t.health_pct}% health]` : ' [health N/A]';
                    const ragEmoji = t.rag_status === 'green' ? '🟢' : t.rag_status === 'amber' ? '🟡' : t.rag_status === 'red' ? '🔴' : '⚫';
                    options += `<option value="${t.id}" data-health="${t.health_pct ?? ''}" data-rag="${t.rag_status}" data-brand="${t.tyre_brand ?? ''}" data-serial="${t.tyre_serial_number ?? ''}">${ragEmoji} ${t.tyre_serial_number ?? 'N/A'} — ${t.tyre_brand ?? ''}${healthLabel}</option>`;
                });
                $('#spareTyreIdSelect').prop('disabled', false).html(options);
                $('#spareTyreDropdownState').text(`${tyres.length} tyre(s) available.`).removeClass('text-muted text-danger text-warning').addClass('text-success');
            },
            error: function () {
                $('#spareTyreIdSelect').prop('disabled', true).html('<option value="">Error loading tyres</option>');
                $('#spareTyreDropdownState').text('Failed to load tyres.').removeClass('text-muted text-success text-warning').addClass('text-danger');
            }
        });
    }
    $('#spareTyreConditionSelect, #spareTyreTypeSelect').on('change', maybeFetchSpareTyres);

    // ── A13. SPARE TYRE SELECTED → HEALTH PREVIEW + AUTO-FILL ────────────────
    $(document).on('change', '#spareTyreIdSelect', function () {
        const $opt      = $(this).find('option:selected');
        const healthPct = $opt.data('health');
        const rag       = $opt.data('rag') || 'grey';

        // Auto-fill brand + serial (read-only display fields)
        $('#spareWh_tyreBrand').val($opt.data('brand') || '');
        $('#spareWh_tyreSerial').val($opt.data('serial') || '');

        if (!$(this).val() || healthPct === '') { $('#spareTyreHealthPreview').addClass('d-none'); return; }
        const pct = parseFloat(healthPct);
        if (!isNaN(pct)) {
            $('#spareHealthBarFill').css('width', pct + '%').removeClass('rag-bg-green rag-bg-amber rag-bg-red rag-bg-grey').addClass('rag-bg-' + rag);
            $('#spareHealthPctText').text(pct + '%');
        }
        const ragLabel = rag === 'green' ? '🟢 Good' : rag === 'amber' ? '🟡 Moderate' : rag === 'red' ? '🔴 Critical' : '⚫ Unknown';
        $('#spareHealthRagBadge').text(ragLabel).removeClass('rag-badge rag-green rag-amber rag-red rag-grey').addClass('rag-badge rag-' + rag);
        $('#spareTyreHealthPreview').removeClass('d-none');
    });

    // ── A13b. SPARE ODOMETER VALIDATION ─────────────────────────────────────
    function validateSpareOdometer() {
        if (typeof lastKnownKm === 'undefined' || !lastKnownKm || !lastKnownDate) return true;
        const fitDate = $('#spareFitmentDateInput').val();
        const kmVal   = $('#spareKmAtFitmentInput').val();
        if (!fitDate || kmVal === '') { $('#spareKmOdoWarning').addClass('d-none'); return true; }
        const fDate = new Date(fitDate), lDate = new Date(lastKnownDate);
        const enteredKm = parseFloat(kmVal);
        if (fDate >= lDate && enteredKm < lastKnownKm) {
            const formatted = lDate.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
            $('#spareKmOdoWarningText').text('KM must be ≥ ' + lastKnownKm.toLocaleString('en-IN') + ' (last recorded on ' + formatted + ').');
            $('#spareKmOdoWarning').removeClass('d-none');
            return false;
        }
        $('#spareKmOdoWarning').addClass('d-none');
        return true;
    }
    $('#spareFitmentDateInput, #spareKmAtFitmentInput').on('change input', validateSpareOdometer);

    // ── A13c. SPARE PHOTO PREVIEWS ───────────────────────────────────────────
    setupPhotoPreview('sparePhotoSerial',   'sparePreviewSerial');
    setupPhotoPreview('sparePhotoFitment',  'sparePreviewFitment');
    setupPhotoPreview('sparePhotoOdometer', 'sparePreviewOdometer');

    // ── A14. SAVE ADD SPARE ───────────────────────────────────────────────────
    $('#saveAddSpare').on('click', function () {
        const $btn      = $(this);
        const source    = $('input[name="spare_tyre_source"]:checked').val();
        const condition = $('#spareTyreConditionSelect').val();
        const type      = $('#spareTyreTypeSelect').val();
        const fitment   = $('#spareFitmentDateInput').val();
        const km        = $('#spareKmAtFitmentInput').val();

        clearSpareFormErrors();
        let hasError = false;
        if (!source)    { showSpareError('spare_err_tyre_source', 'Tyre source is required.');    hasError = true; }
        if (!condition) { showSpareError('spare_err_condition',   'Tyre condition is required.'); hasError = true; }
        if (!type)      { showSpareError('spare_err_tyre_type',   'Tyre type is required.');      hasError = true; }
        if (source === 'SR Warehouse') {
            if (!$('#spareTyreIdSelect').val()) { showSpareError('spare_err_tyre_id', 'Please select a tyre.'); hasError = true; }
        } else {
            if (!$('#spareDirectTyreBrand').val().trim())  { showSpareError('spare_err_tyre_brand',         'Tyre brand is required.');         hasError = true; }
            if (!$('#spareDirectTyreSerial').val().trim()) { showSpareError('spare_err_tyre_serial_number', 'Tyre serial number is required.'); hasError = true; }
        }
        if (!fitment) { showSpareError('spare_err_fitment_date', 'Fitment date is required.'); hasError = true; }
        if (!validateSpareOdometer()) { showSpareError('spare_err_km_at_fitment', $('#spareKmOdoWarningText').text()); hasError = true; }
        if (hasError) return;

        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        const fd = new FormData();
        fd.append('_token', csrfToken);
        fd.append('fitment_date', fitment);
        if (km) fd.append('km_at_fitment', km);
        if (source === 'SR Warehouse') {
            fd.append('tyre_id', $('#spareTyreIdSelect').val());
        } else {
            fd.append('tyre_brand',         $('#spareDirectTyreBrand').val().trim());
            fd.append('tyre_serial_number', $('#spareDirectTyreSerial').val().trim());
        }
        const sparePhotoFields = {
            photo_serial:   '#sparePhotoSerial',
            photo_fitment:  '#sparePhotoFitment',
            photo_odometer: '#sparePhotoOdometer'
        };
        $.each(sparePhotoFields, function (fieldName, selector) {
            const input = $(selector)[0];
            if (input && input.files && input.files[0]) fd.append(fieldName, input.files[0]);
        });

        $.ajax({
            url: addSpareUrl, method: 'POST',
            data: fd, contentType: false, processData: false, dataType: 'json',
            success: function (res) {
                $('#addSpare').modal('hide');
                Toast.fire({ icon: 'success', title: res.message || 'Spare tyre added successfully!',
                    didClose: function () { window.location.href = res.redirect_url || window.location.href; } });
            },
            error: function (xhr) {
                $btn.html('<i class="uil uil-save me-1"></i>Save &amp; Add Spare').prop('disabled', false);
                const res = xhr.responseJSON || {};
                if (xhr.status === 422 && res.errors) {
                    $.each(res.errors, function (field, messages) { showSpareError('spare_err_' + field, messages[0]); });
                    Toast.fire({ icon: 'warning', title: res.message || 'Validation failed.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Something went wrong.' });
                }
            }
        });
    });

    function showSpareError(id, msg) {
        const $el = $('#' + id);
        $el.text(msg).show();
        $el.prev('select, input, .input-group').addClass('is-invalid');
    }
    function clearSpareFormErrors() {
        $('#addSpareInlineForm .invalid-feedback').text('').hide();
        $('#addSpareInlineForm select, #addSpareInlineForm input').removeClass('is-invalid');
        $('#spareKmOdoWarning').addClass('d-none');
    }


    /* ════════════════════════════════════════════════════════════════════════
       SECTION B — TAKE ACTION MODAL (v2 NEW)
    ════════════════════════════════════════════════════════════════════════ */

    /* ── State: which position/mapping is the modal open for ─────────────── */
    let _tamCurrentPos       = '';
    let _tamCurrentMappingId = '';
    let _tamCurrentLifePct   = null;
    let _tamActiveTab        = 'replace';

    /* ── State: donor vehicle lookup results ─────────────────────────────── */
    let _tamDonorPositions   = [];   /* array of position objects from lookupVehicleByNumber */

    /* ── B1. OPEN TAKE ACTION MODAL ─────────────────────────────────────── */
    $(document).on('click', '.btn-open-take-action', function () {
        const $btn         = $(this);
        _tamCurrentPos       = $btn.data('position')     || '';
        _tamCurrentMappingId = $btn.data('mapping-id')   || '';
        const serial         = $btn.data('tyre-serial')  || '—';
        const brand          = $btn.data('tyre-brand')   || '';
        const rag            = $btn.data('rag')          || 'grey';
        _tamCurrentLifePct   = parseFloat($btn.data('life-pct')) || null;
        const remainKm       = $btn.data('remaining-km') || '';

        /* Populate header */
        $('#tamPosLabel').text(_tamCurrentPos || '—');
        $('#tamSerialText').text(serial);
        $('#tamBrandText').text(brand ? ' · ' + brand : '');

        const ragLabels = { green: '🟢 Good', amber: '🟡 Moderate', red: '🔴 Critical', grey: '⚫ Untagged' };
        $('#tamRagBadge')
            .text(ragLabels[rag] || ragLabels.grey)
            .removeClass('rag-green rag-amber rag-red rag-grey')
            .addClass(rag !== 'grey' ? 'rag-' + rag : 'rag-grey');

        $('#tamLifeText').text(
            _tamCurrentLifePct !== null
                ? _tamCurrentLifePct + '% Life' + (remainKm ? ' · ' + Number(remainKm).toLocaleString('en-IN') + ' KM left' : '')
                : ''
        );

        /* Pre-fill hidden fields */
        $('#tamRplMappingId').val(_tamCurrentMappingId);
        $('#tamRplPosition').val(_tamCurrentPos);
        $('#tamAlnMappingId').val(_tamCurrentMappingId);

        /* Activation callbacks */
        _tamActiveTab = 'replace';
        tamActivateTab('replace');

        /* Populate spare select */
        tamPopulateSpareSelect();

        /* Populate position dropdowns in any existing mapping rows */
        tamRefreshMappingDropdowns();

        /* Alignment: check overdue/early */
        tamCheckAlignmentAlerts();
    });

    /* ── B2. TAB SWITCHING ───────────────────────────────────────────────── */
    $(document).on('click', '.tam-tab-btn', function () {
        const tab = $(this).data('tab');
        tamActivateTab(tab);
    });

    function tamActivateTab(tab) {
        _tamActiveTab = tab;

        /* Buttons */
        $('.tam-tab-btn').removeClass('active');
        $(`.tam-tab-btn[data-tab="${tab}"]`).addClass('active');

        /* Panes */
        $('.tam-tab-pane').removeClass('active');
        const paneMap = { replace: 'tamPaneReplace', rotate: 'tamPaneRotate', alignment: 'tamPaneAlignment' };
        $('#' + (paneMap[tab] || 'tamPaneReplace')).addClass('active');

        /* Footer info */
        const footerMap = {
            replace   : 'Select source, fill details, then click Submit to log the replacement.',
            rotate    : 'Define the tyre position mapping and submit to log the rotation.',
            alignment : 'Enter alignment date & KM, attach invoice, then submit.'
        };
        $('#tamFooterInfo').html('<i class="uil uil-info-circle me-1"></i>' + (footerMap[tab] || ''));

        /* Submit label */
        const labelMap = { replace: 'Log Replacement', rotate: 'Log Rotation', alignment: 'Log Alignment' };
        $('#tamSubmitLabel').text(labelMap[tab] || 'Submit');
    }

    /* ── B3. REPLACE TAB — DAMAGE REASON → DRIVER FINE ──────────────────── */
    $(document).on('change', '#tamRplDamageReason', function () {
        if ($(this).val() === 'Driver') {
            $('#tamDriverFineWrap').show();
        } else {
            $('#tamDriverFineWrap').hide();
            $('#tamDriverFineAmount').val('');
        }
    });

    /* ── B4. REPLACE TAB — SOURCE CARD SELECTION ────────────────────────── */
    $(document).on('change', 'input[name="replacement_source"]', function () {
        const src = $(this).val();

        /* Deactivate all source cards */
        $('.tam-source-card').removeClass('active');
        $(this).closest('.tam-source-card').addClass('active');

        /* Hide all source panels */
        $('.tam-src-panel:not(#tamOldTyreSection)').hide();

        if (src === 'SR Garage') {
            $('#tamPanelGarage').show();
        } else if (src === 'Direct Fitment') {
            $('#tamPanelDirect').show();
        } else if (src === 'Same Vehicle Spare') {
            $('#tamPanelSpare').show();
            tamCheckSpareAvailability();
        } else if (src === 'Another Vehicle') {
            $('#tamPanelOtherVehicle').show();
        }

        /* Always show old tyre section once a source is chosen */
        $('#tamOldTyreSection').show();
        $('#tamErrRplSource').text('');
    });

    /* ── B5. POPULATE SPARE SELECT ───────────────────────────────────────── */
    function tamPopulateSpareSelect() {
        const spares = (typeof spareTyresList !== 'undefined') ? spareTyresList : [];
        const $sel   = $('#tamSpareSelect');
        $sel.empty().append('<option value="">— Select Spare Tyre —</option>');
        spares.forEach(function (s) {
            const lifeTxt = s.life !== null ? ` [${s.life}% life]` : '';
            $sel.append(`<option value="${s.id}">Pos ${s.pos}: ${s.serial} — ${s.brand || 'N/A'}${lifeTxt}</option>`);
        });
    }

    function tamCheckSpareAvailability() {
        const spares = (typeof spareTyresList !== 'undefined') ? spareTyresList : [];
        if (spares.length === 0) {
            $('#tamNoSpareAlert').removeClass('d-none');
            $('#tamSpareFieldsWrap').hide();
        } else {
            $('#tamNoSpareAlert').addClass('d-none');
            $('#tamSpareFieldsWrap').show();
        }
    }

    /* ── B6. OLD TYRE DESTINATION — Replace tab ─────────────────────────── */
    $(document).on('change', 'input[name="old_tyre_destination"]', function () {
        const val = $(this).val();

        /* Deactivate pills in Replace tab only */
        $('#tamOldSourceGrid .tam-old-source-pill').removeClass('active');
        $(this).closest('.tam-old-source-pill').addClass('active');

        /* Reset all conditionals */
        $('#tamOwnVehicleOverLimitAlert').addClass('d-none');
        $('#tamOldOtherVehicleWrap').hide();
        $('#tamOldDestVehicleNo').val('');
        $('#tamErrOldDestVehicleNo').text('');
        $('#tamOldDestPosition').val('');
        $('#tamErrOldDestPosition').text('');
        $('#tamOldDestWarehouseWrap').addClass('d-none');
        $('#tamOldDestWarehouseId').val('');
        $('#tamOldDestWorkshopWrap').addClass('d-none');
        $('#tamOldDestWorkshopId').val('');

        if (val === 'SR Garage') {
            $('#tamOldDestWarehouseWrap').removeClass('d-none');
            tamPopulateOldDestWarehouse();
        } else if (val === 'Workshop') {
            $('#tamOldDestWorkshopWrap').removeClass('d-none');
            tamPopulateOldDestWorkshop();
        } else if (val === 'Own Vehicle') {
            /* Check if spare limit exceeded (max 2 spares assumed) */
            const spares = (typeof spareTyresList !== 'undefined') ? spareTyresList : [];
            if (spares.length >= 2) {
                $('#tamOwnVehicleOverLimitAlert').removeClass('d-none');
            }
        } else if (val === 'Another Vehicle') {
            $('#tamOldOtherVehicleWrap').show();
        }

        $('#tamErrOldDest').text('');
    });

    /* ── Populate warehouse dropdown in Old Tyre Destination ──────────── */
    function tamPopulateOldDestWarehouse() {
        const $sel = $('#tamOldDestWarehouseId');
        const whs  = (typeof warehousesList !== 'undefined') ? warehousesList : [];
        $sel.empty().append('<option value="">— Select Warehouse —</option>');
        whs.forEach(function (w) {
            const typeTxt = w.type ? ' (' + w.type + ')' : '';
            $sel.append(`<option value="${w.id}">${w.name}${typeTxt}</option>`);
        });
    }

    /* ── Populate workshop dropdown in Old Tyre Destination ───────────── */
    function tamPopulateOldDestWorkshop() {
        const $sel = $('#tamOldDestWorkshopId');
        const wks  = (typeof workshopsList !== 'undefined') ? workshopsList : [];
        $sel.empty().append('<option value="">— Select Workshop —</option>');
        wks.forEach(function (w) {
            $sel.append(`<option value="${w.id}">${w.name}</option>`);
        });
    }

    /* Old tyre action pill selection — Replace tab */
    $(document).on('change', 'input[name="old_tyre_action"]', function () {
        $('#tamOldActionGrid .tam-old-action-pill').removeClass('active');
        $(this).closest('.tam-old-action-pill').addClass('active');
        $('#tamErrOldAction').text('');

        /* Show/hide Warranty Claim attachment section */
        if ($(this).val() === 'Warranty Claim') {
            $('#tamWarrantyClaimSection').removeClass('d-none');
        } else {
            $('#tamWarrantyClaimSection').addClass('d-none');
        }
    });

    /* ── B8. ROTATE TAB — DYNAMIC MAPPING ROWS ──────────────────────────── */
    let _tamMappingRowCount = 0;

    $(document).on('click', '#tamBtnAddMapping', function () {
        _tamMappingRowCount++;
        const rowId = 'tamMapRow' + _tamMappingRowCount;

        /* Build initial empty selects — tamRefreshAllMappingDropdowns will
           immediately filter out already-used positions after append */
        const $row = $(`
            <div class="tam-mapping-row" id="${rowId}">
                <select class="form-select form-select-sm tam-map-from" name="rotation_mapping[${rowId}][from]">
                    <option value="">— From —</option>
                </select>
                <span class="tam-mapping-arrow"><i class="uil uil-arrow-right"></i></span>
                <select class="form-select form-select-sm tam-map-to" name="rotation_mapping[${rowId}][to]">
                    <option value="">— To —</option>
                </select>
                <button type="button" class="tam-btn-remove-row" data-row="${rowId}" title="Remove row">
                    <i class="uil uil-trash"></i>
                </button>
            </div>
        `);

        /* Append row, then refresh options (excludes positions used by other rows) */
        $('#tamMappingEmpty').hide();
        $('#tamMappingRows').append($row);
        $('#tamErrRotMapping').text('');
        tamRefreshAllMappingDropdowns();
        tamSyncRotationDetails();
    });

    $(document).on('click', '.tam-btn-remove-row', function () {
        const rowId = $(this).data('row');
        /* Remove corresponding detail row first */
        $('#tamRotDetailsRows [data-map-row="' + rowId + '"]').remove();
        $('#' + rowId).remove();
        if ($('#tamMappingRows .tam-mapping-row').length === 0) {
            $('#tamMappingEmpty').show();
            $('#tamRotDetailsRows').html(
                '<div class="tam-mapping-empty" id="tamRotDetailsEmpty">' +
                '<i class="uil uil-info-circle me-1"></i>Add mapping rows above to fill rotation details' +
                '</div>'
            );
        }
        tamRefreshAllMappingDropdowns();
    });

    /* ── B8b. MAPPING FROM/TO CHANGE — sync label + restrict used positions ─ */
    $(document).on('change', '.tam-map-from, .tam-map-to', function () {
        tamRefreshAllMappingDropdowns();
        tamSyncRotationDetails();
    });

    /* ── B8c. tamSyncRotationDetails — keeps detail rows in step with mapping ── */
    function tamSyncRotationDetails() {
        const $mapRows = $('#tamMappingRows .tam-mapping-row');

        if ($mapRows.length === 0) {
            $('#tamRotDetailsRows').html(
                '<div class="tam-mapping-empty" id="tamRotDetailsEmpty">' +
                '<i class="uil uil-info-circle me-1"></i>Add mapping rows above to fill rotation details' +
                '</div>'
            );
            return;
        }

        /* Remove any detail rows for mapping rows that no longer exist */
        $('#tamRotDetailsRows .tam-rot-detail-row').each(function () {
            if ($('#' + $(this).data('map-row')).length === 0) {
                $(this).remove();
            }
        });

        /* Add / update a detail row for each mapping row */
        $mapRows.each(function () {
            const rowId   = $(this).attr('id');
            const fromVal = $(this).find('.tam-map-from').val() || '—';
            const toVal   = $(this).find('.tam-map-to').val()   || '—';
            const label   = fromVal + ' &rarr; ' + toVal;

            const $existing = $('#tamRotDetailsRows [data-map-row="' + rowId + '"]');

            if ($existing.length) {
                /* Just refresh the label — never touch entered values */
                $existing.find('.tam-rot-detail-pair-label').html(
                    '<i class="uil uil-arrows-h me-1" style="font-size:14px;"></i>' + label
                );
            } else {
                /* Build a fresh detail row */
                const $dr = $(
                    '<div class="tam-rot-detail-row" data-map-row="' + rowId + '">' +
                        '<div class="tam-rot-detail-pair-label">' +
                            '<i class="uil uil-arrows-h me-1" style="font-size:14px;"></i>' + label +
                        '</div>' +
                        '<div class="row g-2">' +
                            '<div class="col-md-4">' +
                                '<label class="form-label fw-semibold" style="font-size:12px;">Rotation Date <span class="text-danger">*</span></label>' +
                                '<input type="date" class="form-control form-control-sm tam-rot-detail-date" name="rotation_details[' + rowId + '][date]">' +
                                '<span class="tam-field-error tam-rot-detail-err-date"></span>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<label class="form-label fw-semibold" style="font-size:12px;">KM at Rotation (From Tyre) <span class="text-danger">*</span></label>' +
                                '<div class="input-group input-group-sm">' +
                                    '<input type="number" class="form-control tam-rot-detail-km-from" name="rotation_details[' + rowId + '][km_from]" min="0" placeholder="0">' +
                                    '<span class="input-group-text">KM</span>' +
                                '</div>' +
                                '<span class="tam-field-error tam-rot-detail-err-km-from"></span>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<label class="form-label fw-semibold" style="font-size:12px;">KM at Rotation (To Tyre) <span class="text-danger">*</span></label>' +
                                '<div class="input-group input-group-sm">' +
                                    '<input type="number" class="form-control tam-rot-detail-km-to" name="rotation_details[' + rowId + '][km_to]" min="0" placeholder="0">' +
                                    '<span class="input-group-text">KM</span>' +
                                '</div>' +
                                '<span class="tam-field-error tam-rot-detail-err-km-to"></span>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                );
                $('#tamRotDetailsRows').append($dr);
            }
        });

        /* Re-order detail rows to match mapping row order */
        $mapRows.each(function () {
            const rowId = $(this).attr('id');
            $('#tamRotDetailsRows').append($('#tamRotDetailsRows [data-map-row="' + rowId + '"]'));
        });

        $('#tamErrRotDetails').text('');
    }

    /* ── B8d. tamRefreshAllMappingDropdowns — prevent duplicate position use ─
       Each tyre position may appear at most once across ALL From and To columns.
       After any From/To change, every row's dropdowns are rebuilt to only show
       positions not already claimed by another row.                            */
    function tamRefreshAllMappingDropdowns() {
        const $rows = $('#tamMappingRows .tam-mapping-row');
        if ($rows.length === 0) return;

        const allPositions = (typeof allMappings !== 'undefined')
            ? allMappings.map(function (m) { return m.pos; }).filter(Boolean)
            : [];

        /* Snapshot: rowId → { from, to } */
        const rowSelections = {};
        $rows.each(function () {
            const id = $(this).attr('id');
            rowSelections[id] = {
                from: $(this).find('.tam-map-from').val() || '',
                to:   $(this).find('.tam-map-to').val()   || '',
            };
        });

        /* Rebuild each row's dropdowns */
        $rows.each(function () {
            const rowId    = $(this).attr('id');
            const $fromSel = $(this).find('.tam-map-from');
            const $toSel   = $(this).find('.tam-map-to');
            const curFrom  = rowSelections[rowId].from;
            const curTo    = rowSelections[rowId].to;

            /* Positions locked by OTHER rows (in From OR To column) */
            const usedByOthers = new Set();
            $.each(rowSelections, function (id, sel) {
                if (id === rowId) return;
                if (sel.from) usedByOthers.add(sel.from);
                if (sel.to)   usedByOthers.add(sel.to);
            });

            /* From options: exclude positions used by others + this row's To */
            let fromHtml = '<option value="">— From —</option>';
            allPositions.forEach(function (pos) {
                if (usedByOthers.has(pos)) return;
                if (pos === curTo)         return;   /* From ≠ To */
                const sel = pos === curFrom ? ' selected' : '';
                fromHtml += '<option value="' + pos + '"' + sel + '>' + pos + '</option>';
            });

            /* To options: exclude positions used by others + this row's From */
            let toHtml = '<option value="">— To —</option>';
            allPositions.forEach(function (pos) {
                if (usedByOthers.has(pos)) return;
                if (pos === curFrom)       return;   /* To ≠ From */
                const sel = pos === curTo ? ' selected' : '';
                toHtml += '<option value="' + pos + '"' + sel + '>' + pos + '</option>';
            });

            $fromSel.html(fromHtml);
            $toSel.html(toHtml);
        });

        $('#tamErrRotMapping').text('');
    }

    function tamBuildPositionOptions(selectedVal) {
        const positions = (typeof allMappings !== 'undefined') ?
            allMappings.map(function (m) { return m.pos; }).filter(Boolean) : [];

        let opts = '';
        positions.forEach(function (pos) {
            const sel = pos === selectedVal ? ' selected' : '';
            opts += `<option value="${pos}"${sel}>${pos}</option>`;
        });
        return opts;
    }

    function tamRefreshMappingDropdowns() {
        /* Rebuild options in existing rows on modal re-open */
        $('#tamMappingRows .tam-mapping-row').each(function () {
            const fromVal = $(this).find('.tam-map-from').val();
            const toVal   = $(this).find('.tam-map-to').val();
            $(this).find('.tam-map-from').html('<option value="">— From —</option>' + tamBuildPositionOptions(fromVal));
            $(this).find('.tam-map-to').html('<option value="">— To —</option>' + tamBuildPositionOptions(toVal));
        });
    }

    /* ── B9. ALIGNMENT TAB — OVERDUE / EARLY ALERTS ─────────────────────── */
    function tamCheckAlignmentAlerts() {
        $('#tamAlnOverdueAlert').addClass('d-none');
        $('#tamAlnEarlyAlert').addClass('d-none');

        /* Find alignment data from tyre card (data passed in allMappings is limited)
           For now we use lastKnownKm as a proxy for current KM.
           Full logic will be wired when backend endpoint is created. */
        const currentKm = typeof lastKnownKm !== 'undefined' ? lastKnownKm : null;
        if (!currentKm) return;

        /* We cannot access tyre alignment_interval_km or last_alignment_km
           without a backend call, so we leave the alert hidden by default.
           The backend submit will return any overdue status. */
    }

    /* ── B10. PHOTO THUMB PREVIEWS (Take Action modal) ───────────────────── */
    /* All inputs with tam-photo-thumb sibling inside a tam-photo-slot */
    $(document).on('change', '.tam-photo-slot input[type="file"]', function () {
        const $slot  = $(this).closest('.tam-photo-slot');
        const $thumb = $slot.find('.tam-photo-thumb');
        const file   = this.files[0];

        if (!file || !file.type.startsWith('image/')) {
            $thumb.hide().attr('src', '');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            $thumb.attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    });

    /* ── B11. DONOR VEHICLE LOOKUP ───────────────────────────────────────── */

    /* Helper — reset all donor-panel state to blank */
    function tamResetDonorPanel() {
        _tamDonorPositions = [];
        $('#tamDonorInfoBanner').addClass('d-none');
        $('#tamDonorRegLabel').text('');
        $('#tamDonorTyreCount').text('');
        $('#tamDonorPositionWrap').addClass('d-none');
        $('#tamOtherPositionSelect').html('<option value="">— Select a position —</option>');
        $('#tamDonorMappingId').val('');
        $('#tamDonorTyrePreview').addClass('d-none');
        $('#tamDonorNoTyreAlert').addClass('d-none');
        /* Clear preview fields */
        $('#tamDonorTyreSerial').text('—');
        $('#tamDonorTyreBrand').text('—');
        $('#tamDonorTyreCondition').text('—');
        $('#tamDonorTyreType').text('—');
        $('#tamDonorHealthFill').css('width', '0%').removeClass('rag-bg-green rag-bg-amber rag-bg-red rag-bg-grey').addClass('rag-bg-grey');
        $('#tamDonorHealthPct').text('—');
        $('#tamDonorTyreRag').text('⚫ Untagged').removeClass('rag-green rag-amber rag-red').addClass('rag-grey');
    }

    /* B11a — LOOKUP BUTTON CLICK */
    $(document).on('click', '#tamBtnLookupVehicle', function () {
        const vehicleNo = $('#tamOtherVehicleNo').val().trim();
        const $btn      = $(this);

        /* Validation */
        if (!vehicleNo) {
            $('#tamErrOtherVehicle').text('Enter a vehicle registration number to look up.');
            return;
        }
        $('#tamErrOtherVehicle').text('');

        /* Reset previous results */
        tamResetDonorPanel();

        /* Loading state */
        const originalHtml = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Looking up…').prop('disabled', true);

        $.ajax({
            url      : lookupVehicleUrl,
            method   : 'GET',
            data     : { vehicle_number: vehicleNo },
            dataType : 'json',
            success  : function (res) {
                $btn.html(originalHtml).prop('disabled', false);

                if (!res.success || !res.vehicle) {
                    $('#tamErrOtherVehicle').text(res.message || 'Vehicle not found.');
                    return;
                }

                /* Validation: donor vehicle must not be the current vehicle */
                if (res.vehicle.id === vehicleId) {
                    $('#tamErrOtherVehicle').text(
                        'Donor vehicle cannot be the same as the current vehicle. Use "Same Vehicle Spare" instead.'
                    );
                    return;
                }

                /* Store positions for position-select handler */
                _tamDonorPositions = res.positions || [];

                /* Show success banner */
                $('#tamDonorRegLabel').text(res.vehicle.reg_number);
                $('#tamDonorTyreCount').text(
                    res.total_with_tyre + ' tyre(s) fitted across ' + _tamDonorPositions.length + ' position(s)'
                );
                $('#tamDonorInfoBanner').removeClass('d-none');

                /* Populate position select — only positions that have a tyre */
                let opts = '<option value="">— Select a position —</option>';
                _tamDonorPositions.forEach(function (p) {
                    if (p.has_tyre) {
                        const lifeTxt = p.life_pct !== null ? ' [' + p.life_pct + '% life]' : '';
                        opts += '<option value="' + p.position_code + '">' + p.position_code + lifeTxt + '</option>';
                    }
                });

                if (res.total_with_tyre === 0) {
                    /* No positions have tyres — show warning, no dropdown */
                    $('#tamDonorNoTyreAlert').removeClass('d-none');
                } else {
                    $('#tamOtherPositionSelect').html(opts);
                    $('#tamDonorPositionWrap').removeClass('d-none');
                }
            },
            error    : function (xhr) {
                $btn.html(originalHtml).prop('disabled', false);
                const res = xhr.responseJSON || {};
                if (xhr.status === 422) {
                    $('#tamErrOtherVehicle').text(res.message || 'Vehicle not found. Check the registration number.');
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Lookup failed. Please try again.' });
                }
            }
        });
    });

    /* B11b — POSITION SELECT CHANGE → populate tyre preview */
    $(document).on('change', '#tamOtherPositionSelect', function () {
        const posCode = $(this).val();

        /* Clear preview */
        $('#tamDonorMappingId').val('');
        $('#tamDonorTyrePreview').addClass('d-none');
        $('#tamDonorNoTyreAlert').addClass('d-none');

        if (!posCode) return;

        /* Find position object */
        const pos = _tamDonorPositions.find(function (p) { return p.position_code === posCode; });
        if (!pos) return;

        /* Store mapping_id for form submission */
        $('#tamDonorMappingId').val(pos.mapping_id || '');

        if (!pos.has_tyre) {
            $('#tamDonorNoTyreAlert').removeClass('d-none');
            return;
        }

        /* Populate preview card */
        $('#tamDonorTyreSerial').text(pos.serial || '—');
        $('#tamDonorTyreBrand').text(pos.brand || '—');
        $('#tamDonorTyreCondition').text(pos.condition || '—');
        $('#tamDonorTyreType').text(pos.type || '—');

        const pct = parseFloat(pos.life_pct);
        const rag = pos.rag || 'grey';

        if (!isNaN(pct)) {
            $('#tamDonorHealthFill')
                .css('width', pct + '%')
                .removeClass('rag-bg-green rag-bg-amber rag-bg-red rag-bg-grey')
                .addClass('rag-bg-' + rag);
            $('#tamDonorHealthPct').text(pct + '%');
        } else {
            $('#tamDonorHealthFill').css('width', '0%').addClass('rag-bg-grey');
            $('#tamDonorHealthPct').text('N/A');
        }

        const ragLabel = rag === 'green' ? '🟢 Good' : rag === 'amber' ? '🟡 Moderate' : rag === 'red' ? '🔴 Critical' : '⚫ Unknown';
        $('#tamDonorTyreRag')
            .text(ragLabel)
            .removeClass('rag-green rag-amber rag-red rag-grey')
            .addClass('rag-' + rag);

        $('#tamDonorTyrePreview').removeClass('d-none');
    });

    /* ── B12. SUBMIT TAKE ACTION MODAL ──────────────────────────────────── */
    $(document).on('click', '#tamSubmitBtn', function () {
        if (_tamActiveTab === 'replace') {
            if (!tamValidateReplaceTab()) return;
        } else if (_tamActiveTab === 'rotate') {
            if (!tamValidateRotateTab()) return;
        } else if (_tamActiveTab === 'alignment') {
            if (!tamValidateAlignmentTab()) return;
        }

        if (_tamActiveTab === 'alignment') {
            tamSubmitAlignment($(this));
        } else if (_tamActiveTab === 'replace') {
            tamSubmitReplace($(this));
        } else if (_tamActiveTab === 'rotate') {
            tamSubmitRotate($(this));
        }
    });

    /* ── B12r. ROTATE AJAX SUBMIT ────────────────────────────────────────── */
    function tamSubmitRotate($btn) {
        const fd = new FormData($('#tamRotateForm')[0]);
        fd.append('_token', csrfToken);

        const originalLabel = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        $.ajax({
            url         : takeActionBaseUrl + '/log-rotate',
            method      : 'POST',
            data        : fd,
            contentType : false,
            processData : false,
            dataType    : 'json',
            success     : function (res) {
                $('#takeActionModal').modal('hide');
                Toast.fire({
                    icon    : 'success',
                    title   : res.message || 'Tyre rotation logged successfully!',
                    didClose: function () { window.location.reload(); }
                });
            },
            error       : function (xhr) {
                $btn.html(originalLabel).prop('disabled', false);
                const res = xhr.responseJSON || {};
                if (xhr.status === 422 && res.errors) {
                    const firstField = Object.keys(res.errors)[0];
                    const firstMsg   = res.errors[firstField][0];
                    Toast.fire({ icon: 'warning', title: res.message || firstMsg || 'Validation failed.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Submission failed. Please try again.' });
                }
            }
        });
    }

    /* ── B12a. ALIGNMENT AJAX SUBMIT ─────────────────────────────────────── */
    function tamSubmitAlignment($btn) {
        const fd = new FormData();
        fd.append('_token', csrfToken);
        fd.append('mapping_id',     _tamCurrentMappingId);
        fd.append('alignment_date', $('#tamAlnDate').val());
        fd.append('alignment_km',   $('#tamAlnKm').val());

        const invoiceInput = document.getElementById('tamAlnInvoice');
        if (invoiceInput && invoiceInput.files && invoiceInput.files[0]) {
            fd.append('alignment_invoice', invoiceInput.files[0]);
        }

        const originalLabel = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        $.ajax({
            url: takeActionBaseUrl + '/log-alignment',
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                $('#takeActionModal').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Alignment logged successfully!',
                    didClose: function () { window.location.reload(); }
                });
            },
            error: function (xhr) {
                $btn.html(originalLabel).prop('disabled', false);
                const res = xhr.responseJSON || {};
                if (xhr.status === 422 && res.errors) {
                    /* Show first validation error */
                    const firstField = Object.keys(res.errors)[0];
                    const firstMsg   = res.errors[firstField][0];
                    Toast.fire({ icon: 'warning', title: firstMsg || res.message || 'Validation failed.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Submission failed. Please try again.' });
                }
            }
        });
    }

    /* ── B12b. REPLACE AJAX SUBMIT ───────────────────────────────────────── */
    function tamSubmitReplace($btn) {
        const src = $('input[name="replacement_source"]:checked').val();

        const fd = new FormData();
        fd.append('_token',                csrfToken);
        fd.append('mapping_id',            _tamCurrentMappingId);
        fd.append('replacement_reason',    $('#tamRplReason').val());
        fd.append('damage_reason',         $('#tamRplDamageReason').val());
        fd.append('driver_fine_amount',    $('#tamDriverFineAmount').val() || '');
        fd.append('replacement_source',    src);
        fd.append('old_tyre_destination',          $('input[name="old_tyre_destination"]:checked').val() || '');
        fd.append('old_dest_warehouse_id',        $('#tamOldDestWarehouseId').val() || '');
        fd.append('old_dest_workshop_id',         $('#tamOldDestWorkshopId').val() || '');
        fd.append('old_tyre_destination_vehicle', $('#tamOldDestVehicleNo').val().trim() || '');
        fd.append('old_tyre_destination_position', $('#tamOldDestPosition').val() || '');
        // fd.append('old_tyre_action', $('input[name="old_tyre_action"]:checked').val() || ''); // disabled 2026-05-11

        // Damage photos (common to all sources)
        ['damage_photo_1', 'damage_photo_2', 'damage_photo_3'].forEach(function (name) {
            const el = document.getElementById(name);
            if (el && el.files && el.files[0]) { fd.append(name, el.files[0]); }
        });

        // Source-specific fields and photos
        if (src === 'SR Garage') {
            fd.append('new_tyre_condition_garage', $('#tamGarCondition').val());
            fd.append('new_tyre_type_garage',      $('#tamGarType').val());
            fd.append('new_tyre_brand_garage',     $('#tamGarBrand').val());
            fd.append('new_tyre_serial_garage',    $('#tamGarSerial').val());
            fd.append('replacement_date_garage',   $('#tamGarDate').val());
            fd.append('replacement_km_garage',     $('#tamGarKm').val() || '');
            ['garage_serial_photo', 'garage_fitment_photo', 'garage_odometer_photo'].forEach(function (name) {
                const el = document.getElementById(name);
                if (el && el.files && el.files[0]) { fd.append(name, el.files[0]); }
            });
        } else if (src === 'Direct Fitment') {
            fd.append('new_tyre_condition_direct', $('#tamDirCondition').val());
            fd.append('new_tyre_type_direct',      $('#tamDirType').val());
            fd.append('new_tyre_brand_direct',     $('#tamDirBrand').val());
            fd.append('new_tyre_serial_direct',    $('#tamDirSerial').val());
            fd.append('replacement_date_direct',   $('#tamDirDate').val());
            fd.append('replacement_km_direct',     $('#tamDirKm').val() || '');
            ['direct_serial_photo', 'direct_fitment_photo', 'direct_odometer_photo'].forEach(function (name) {
                const el = document.getElementById(name);
                if (el && el.files && el.files[0]) { fd.append(name, el.files[0]); }
            });
        } else if (src === 'Same Vehicle Spare') {
            fd.append('spare_tyre_mapping_id',  $('#tamSpareSelect').val());
            fd.append('replacement_date_spare', $('#tamSpareDate').val());
            fd.append('replacement_km_spare',   $('#tamSpareKm').val() || '');
            ['spare_serial_photo', 'spare_fitment_photo', 'spare_odometer_photo'].forEach(function (name) {
                const el = document.getElementById(name);
                if (el && el.files && el.files[0]) { fd.append(name, el.files[0]); }
            });
        } else if (src === 'Another Vehicle') {
            fd.append('donor_mapping_id',         $('#tamDonorMappingId').val());
            fd.append('replacement_date_other',   $('#tamOtherDate').val());
            fd.append('replacement_km_other',     $('#tamOtherKm').val() || '');
            ['other_serial_photo', 'other_fitment_photo', 'other_odometer_photo'].forEach(function (name) {
                const el = document.getElementById(name);
                if (el && el.files && el.files[0]) { fd.append(name, el.files[0]); }
            });
        }

        const originalLabel = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        $.ajax({
            url         : takeActionBaseUrl + '/log-replace',
            method      : 'POST',
            data        : fd,
            contentType : false,
            processData : false,
            dataType    : 'json',
            success     : function (res) {
                $('#takeActionModal').modal('hide');
                Toast.fire({
                    icon    : 'success',
                    title   : res.message || 'Tyre replacement logged successfully!',
                    didClose: function () { window.location.reload(); }
                });
            },
            error       : function (xhr) {
                $btn.html(originalLabel).prop('disabled', false);
                const res = xhr.responseJSON || {};
                if (xhr.status === 422 && res.errors) {
                    const firstField = Object.keys(res.errors)[0];
                    const firstMsg   = res.errors[firstField][0];

                    /* Route known fields to their inline error spans */
                    if (firstField === 'donor_vehicle_number') {
                        $('#tamErrOtherVehicle').text(firstMsg);
                    } else if (firstField === 'old_tyre_destination') {
                        /* Spare capacity exceeded — show under the destination pills */
                        $('#tamErrOldDest').text(firstMsg);
                    }

                    Toast.fire({ icon: 'warning', title: res.message || firstMsg || 'Validation failed.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Submission failed. Please try again.' });
                }
            }
        });
    }

    /* ── B13. VALIDATE REPLACE TAB ───────────────────────────────────────── */
    function tamValidateReplaceTab() {
        let ok = true;

        /* Reason */
        if (!$('#tamRplReason').val()) {
            $('#tamErrRplReason').text('Replacement reason is required.');
            ok = false;
        } else { $('#tamErrRplReason').text(''); }

        /* Damage reason */
        if (!$('#tamRplDamageReason').val()) {
            $('#tamErrRplDamageReason').text('Damage responsibility is required.');
            ok = false;
        } else { $('#tamErrRplDamageReason').text(''); }

        /* Driver fine */
        if ($('#tamRplDamageReason').val() === 'Driver' && !$('#tamDriverFineAmount').val()) {
            $('#tamErrDriverFine').text('Driver fine amount is required when Driver is responsible.');
            ok = false;
        } else { $('#tamErrDriverFine').text(''); }

        /* Source */
        const src = $('input[name="replacement_source"]:checked').val();
        if (!src) {
            $('#tamErrRplSource').text('Please select a replacement tyre source.');
            ok = false;
        } else { $('#tamErrRplSource').text(''); }

        /* Source-specific validation */
        if (src === 'Same Vehicle Spare') {
            if (!$('#tamSpareSelect').val()) {
                $('#tamErrSpareSelect').text('Please select a spare tyre.');
                ok = false;
            } else { $('#tamErrSpareSelect').text(''); }
        }

        /* Old tyre destination */
        const oldDest = $('input[name="old_tyre_destination"]:checked').val();
        if (!oldDest) {
            $('#tamErrOldDest').text('Please select a destination for the removed tyre.');
            ok = false;
        } else { $('#tamErrOldDest').text(''); }

        /* Warehouse required when SR Garage selected */
        if (oldDest === 'SR Garage' && !$('#tamOldDestWarehouseId').val()) {
            $('#tamErrOldDestWarehouse').text('Please select a warehouse.');
            ok = false;
        } else { $('#tamErrOldDestWarehouse').text(''); }

        /* Workshop required when Workshop selected */
        if (oldDest === 'Workshop' && !$('#tamOldDestWorkshopId').val()) {
            $('#tamErrOldDestWorkshop').text('Please select a workshop.');
            ok = false;
        } else { $('#tamErrOldDestWorkshop').text(''); }

        /* Another Vehicle: vehicle number + position required */
        if (oldDest === 'Another Vehicle') {
            if (!$('#tamOldDestVehicleNo').val().trim()) {
                $('#tamErrOldDestVehicleNo').text('Please enter the destination vehicle number.');
                ok = false;
            } else { $('#tamErrOldDestVehicleNo').text(''); }

            if (!$('#tamOldDestPosition').val()) {
                $('#tamErrOldDestPosition').text('Please select a position on the destination vehicle.');
                ok = false;
            } else { $('#tamErrOldDestPosition').text(''); }
        } else {
            $('#tamErrOldDestVehicleNo').text('');
            $('#tamErrOldDestPosition').text('');
        }

        /* Old tyre action — validation disabled (section commented out 2026-05-11) */
        // if (!$('input[name="old_tyre_action"]:checked').val()) {
        //     $('#tamErrOldAction').text('Please select an action for the old tyre.');
        //     ok = false;
        // } else { $('#tamErrOldAction').text(''); }

        if (!ok) {
            Toast.fire({ icon: 'warning', title: 'Please fill all required fields in the Replace tab.' });
        }
        return ok;
    }

    /* ── B14. VALIDATE ROTATE TAB ────────────────────────────────────────── */
    function tamValidateRotateTab() {
        let ok = true;

        /* 1. Mapping rows — must have at least one row */
        if ($('#tamMappingRows .tam-mapping-row').length === 0) {
            $('#tamErrRotMapping').text('Please add at least one mapping row.');
            ok = false;
        } else {
            let rowOk   = true;
            const usedPositions = new Set();
            let dupPos  = false;

            $('#tamMappingRows .tam-mapping-row').each(function () {
                const fromVal = $(this).find('.tam-map-from').val();
                const toVal   = $(this).find('.tam-map-to').val();

                /* Both positions must be selected */
                if (!fromVal || !toVal) { rowOk = false; return; }

                /* From ≠ To */
                if (fromVal === toVal) { dupPos = true; return; }

                /* Each position must be unique across all From + To columns */
                if (usedPositions.has(fromVal) || usedPositions.has(toVal)) {
                    dupPos = true; return;
                }
                usedPositions.add(fromVal);
                usedPositions.add(toVal);
            });

            if (!rowOk) {
                $('#tamErrRotMapping').text('Each mapping row must have both From and To positions selected.');
                ok = false;
            } else if (dupPos) {
                $('#tamErrRotMapping').text('Each position can only be used once. Remove the duplicate and try again.');
                ok = false;
            } else {
                $('#tamErrRotMapping').text('');
            }
        }

        /* 2. Rotation Details — one row per mapping pair, all fields required */
        let detailOk = true;
        $('#tamRotDetailsRows .tam-rot-detail-row').each(function () {
            const $dr = $(this);

            if (!$dr.find('.tam-rot-detail-date').val()) {
                $dr.find('.tam-rot-detail-err-date').text('Required');
                detailOk = false;
            } else {
                $dr.find('.tam-rot-detail-err-date').text('');
            }

            if ($dr.find('.tam-rot-detail-km-from').val() === '') {
                $dr.find('.tam-rot-detail-err-km-from').text('Required');
                detailOk = false;
            } else {
                $dr.find('.tam-rot-detail-err-km-from').text('');
            }

            if ($dr.find('.tam-rot-detail-km-to').val() === '') {
                $dr.find('.tam-rot-detail-err-km-to').text('Required');
                detailOk = false;
            } else {
                $dr.find('.tam-rot-detail-err-km-to').text('');
            }
        });
        if (!detailOk) {
            $('#tamErrRotDetails').text('Please complete all rotation details above.');
            ok = false;
        } else {
            $('#tamErrRotDetails').text('');
        }

        /* 5. Rotation Reason textarea */
        if ($.trim($('#tamRotReason').val()) === '') {
            $('#tamErrRotReason').text('Rotation reason is required.');
            ok = false;
        } else { $('#tamErrRotReason').text(''); }

        if (!ok) {
            Toast.fire({ icon: 'warning', title: 'Please fill all required fields in the Rotate tab.' });
        }
        return ok;
    }

    /* ── B15. VALIDATE ALIGNMENT TAB ─────────────────────────────────────── */
    function tamValidateAlignmentTab() {
        let ok = true;

        if (!$('#tamAlnDate').val()) {
            $('#tamErrAlnDate').text('Alignment date is required.');
            ok = false;
        } else { $('#tamErrAlnDate').text(''); }

        if ($('#tamAlnKm').val() === '') {
            $('#tamErrAlnKm').text('KM at alignment is required.');
            ok = false;
        } else { $('#tamErrAlnKm').text(''); }

        if (!ok) {
            Toast.fire({ icon: 'warning', title: 'Please fill all required fields in the Alignment tab.' });
        }
        return ok;
    }

    /* ── B16. RESET TAKE ACTION MODAL ON CLOSE ───────────────────────────── */
    $('#takeActionModal').on('hidden.bs.modal', function () {
        tamResetModal();
    });

    function tamResetModal() {
        /* Reset state */
        _tamCurrentPos       = '';
        _tamCurrentMappingId = '';
        _tamCurrentLifePct   = null;

        /* Reset header */
        $('#tamPosLabel').text('—');
        $('#tamSerialText').text('—');
        $('#tamBrandText').text('');
        $('#tamRagBadge').text('⚫ Untagged').removeClass('rag-green rag-amber rag-red').addClass('rag-grey');
        $('#tamLifeText').text('');

        /* Reset tabs */
        tamActivateTab('replace');

        /* Reset Replace form */
        $('#tamReplaceForm')[0] && $('#tamReplaceForm')[0].reset();
        $('#tamDriverFineWrap').hide();
        $('.tam-source-card').removeClass('active');
        $('.tam-src-panel:not(#tamOldTyreSection)').hide();
        $('#tamOldTyreSection').hide();
        $('#tamOldSourceGrid .tam-old-source-pill').removeClass('active');
        $('#tamOldActionGrid .tam-old-action-pill').removeClass('active');
        $('#tamOwnVehicleOverLimitAlert').addClass('d-none');
        $('#tamOldOtherVehicleWrap').hide();
        $('#tamWarrantyClaimSection').addClass('d-none');
        $('#tamOtherPosAlert').addClass('d-none');
        $('#tamNoSpareAlert').addClass('d-none');
        $('#tamSpareFieldsWrap').show();

        /* Clear all Replace error spans */
        $('#tamPaneReplace .tam-field-error').text('');
        $('#tamErrRplSource').text('');

        /* Reset Rotate form */
        $('#tamRotateForm')[0] && $('#tamRotateForm')[0].reset();
        /* Remove all mapping rows and their detail rows */
        _tamMappingRowCount = 0;
        $('#tamMappingRows .tam-mapping-row').remove();
        $('#tamMappingEmpty').show();
        $('#tamRotDetailsRows').html(
            '<div class="tam-mapping-empty" id="tamRotDetailsEmpty">' +
            '<i class="uil uil-info-circle me-1"></i>Add mapping rows above to fill rotation details' +
            '</div>'
        );
        $('#tamPaneRotate .tam-field-error').text('');

        /* Reset donor vehicle lookup panel */
        $('#tamOtherVehicleNo').val('');
        $('#tamErrOtherVehicle').text('');
        tamResetDonorPanel();

        /* Reset Alignment form */
        $('#tamAlignForm')[0] && $('#tamAlignForm')[0].reset();
        $('#tamAlnOverdueAlert').addClass('d-none');
        $('#tamAlnEarlyAlert').addClass('d-none');
        $('#tamPaneAlignment .tam-field-error').text('');

        /* Reset all photo thumbs inside Take Action modal */
        $('#takeActionModal .tam-photo-thumb').hide().attr('src', '');

        /* Reset footer */
        $('#tamFooterInfo').html('<i class="uil uil-info-circle me-1"></i>Select a tab and fill the required fields to proceed.');
        $('#tamSubmitLabel').text('Submit');
        $('#tamSubmitBtn').prop('disabled', false).html('<i class="uil uil-check me-1"></i><span id="tamSubmitLabel">Submit</span>');
    }

});
