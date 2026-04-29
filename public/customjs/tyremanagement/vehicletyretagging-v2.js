/* ═══════════════════════════════════════════════════════════════════════════
   SR Logistics — Tyre Tagging v2 JS  |  vehicletyretagging-v2.js  v1.0
   Handles:
     • All v1 behaviour (SVG RAG, SVG↔card sync, Allocate Tyre, Add Spare)
     • Take Action Modal (v2 — new):
         – Open handler: populate header from data-* attributes
         – Tab switching (Replace / Rotate / Alignment)
         – Replace tab: reason, damage resp, driver fine conditional,
           source card selection, 4 source panels, old tyre destination/action
         – Rotate tab: reason cards, interval alert, health alert,
           dynamic mapping rows, invoice photo
         – Alignment tab: overdue/early alerts, invoice photo
         – Photo thumbnail previews throughout
         – Submit stub (Toast — backend wired in future sprint)
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
        resetSpareTyreDropdown();
        $('#spareTyreConditionSelect').val('');
        $('#spareTyreTypeSelect').val('');
        $('#spareFitmentDateInput').val('');
        $('#spareKmAtFitmentInput').val('');
        clearSpareFormErrors();
    });

    function resetSpareTyreDropdown() {
        $('#spareTyreIdSelect').prop('disabled', true).html('<option value="">— Select condition &amp; type first —</option>');
        $('#spareTyreDropdownState').text('— Select condition & type to load available tyres —').removeClass('text-danger text-success text-warning').addClass('text-muted');
        $('#spareTyreHealthPreview').addClass('d-none');
    }

    // ── A12. SPARE AJAX TYRE DROPDOWN ────────────────────────────────────────
    function maybeFetchSpareTyres() {
        const condition = $('#spareTyreConditionSelect').val();
        const type      = $('#spareTyreTypeSelect').val();
        if (!condition || !type) { resetSpareTyreDropdown(); return; }

        $('#spareTyreIdSelect').prop('disabled', true).html('<option value="">Loading…</option>');
        $('#spareTyreDropdownState').text('Fetching…').removeClass('text-danger text-success text-warning text-muted').addClass('text-muted');
        $('#spareTyreHealthPreview').addClass('d-none');

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
                    options += `<option value="${t.id}" data-health="${t.health_pct ?? ''}" data-rag="${t.rag_status}" data-brand="${t.tyre_brand ?? ''}">${ragEmoji} ${t.tyre_serial_number ?? 'N/A'} — ${t.tyre_brand ?? ''}${healthLabel}</option>`;
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

    // ── A13. SPARE TYRE SELECTED → HEALTH PREVIEW ────────────────────────────
    $(document).on('change', '#spareTyreIdSelect', function () {
        const $opt      = $(this).find('option:selected');
        const healthPct = $opt.data('health');
        const rag       = $opt.data('rag') || 'grey';
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

    // ── A14. SAVE ADD SPARE ───────────────────────────────────────────────────
    $('#saveAddSpare').on('click', function () {
        const $btn      = $(this);
        const tyreId    = $('#spareTyreIdSelect').val();
        const fitment   = $('#spareFitmentDateInput').val();
        const kmFitment = $('#spareKmAtFitmentInput').val();

        clearSpareFormErrors();
        let hasError = false;
        if (!$('#spareTyreConditionSelect').val()) { showSpareError('spare_err_condition',    'Tyre condition is required.'); hasError = true; }
        if (!$('#spareTyreTypeSelect').val())      { showSpareError('spare_err_tyre_type',    'Tyre type is required.');      hasError = true; }
        if (!tyreId)                               { showSpareError('spare_err_tyre_id',      'Please select a tyre.');       hasError = true; }
        if (!fitment)                              { showSpareError('spare_err_fitment_date', 'Fitment date is required.');   hasError = true; }
        if (hasError) return;

        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        $.ajax({
            url: addSpareUrl, method: 'POST',
            data: { _token: csrfToken, tyre_id: tyreId, fitment_date: fitment, km_at_fitment: kmFitment || null },
            dataType: 'json',
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
    }


    /* ════════════════════════════════════════════════════════════════════════
       SECTION B — TAKE ACTION MODAL (v2 NEW)
    ════════════════════════════════════════════════════════════════════════ */

    /* ── State: which position/mapping is the modal open for ─────────────── */
    let _tamCurrentPos       = '';
    let _tamCurrentMappingId = '';
    let _tamCurrentLifePct   = null;
    let _tamActiveTab        = 'replace';

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
            $sel.append(`<option value="${s.id}">${s.serial} — ${s.brand || 'N/A'}${lifeTxt} (${s.pos})</option>`);
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

    /* ── B6. OLD TYRE DESTINATION ────────────────────────────────────────── */
    $(document).on('change', 'input[name="old_tyre_destination"]', function () {
        const val = $(this).val();

        /* Deactivate all pills */
        $('.tam-old-source-pill').removeClass('active');
        $(this).closest('.tam-old-source-pill').addClass('active');

        /* Reset conditionals */
        $('#tamOwnVehicleOverLimitAlert').addClass('d-none');
        $('#tamOldOtherVehicleWrap').hide();
        $('#tamOldDestVehicleNo').val('');

        if (val === 'Own Vehicle' || val === 'Spare Tyre') {
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

    /* Old tyre action pill selection */
    $(document).on('change', 'input[name="old_tyre_action"]', function () {
        $('.tam-old-action-pill').removeClass('active');
        $(this).closest('.tam-old-action-pill').addClass('active');
        $('#tamErrOldAction').text('');
    });

    /* ── B7. ROTATE TAB — REASON CARD SELECTION ─────────────────────────── */
    $(document).on('change', 'input[name="rotation_reason"]', function () {
        const val = $(this).val();

        /* Activate reason card */
        $('.tam-reason-card').removeClass('active');
        $(this).closest('.tam-reason-card').addClass('active');

        /* Health alert: if tyre life > 60% and reason is "Tyre Weak" */
        if (val === 'Tyre Weak' && _tamCurrentLifePct !== null && _tamCurrentLifePct > 60) {
            $('#tamRotateWeakHealthText').text(
                'This tyre has ' + _tamCurrentLifePct + '% life remaining. ' +
                'Marking it as weak may indicate potential tyre damage. Please verify before proceeding.'
            );
            $('#tamRotateWeakHealthAlert').removeClass('d-none');
        } else {
            $('#tamRotateWeakHealthAlert').addClass('d-none');
        }

        /* Interval alert: for Scheduled Maintenance check last rotation KM */
        if (val === 'Scheduled Maintenance Tyre Rotation') {
            tamCheckRotationInterval();
        } else {
            $('#tamRotIntervalAlert').addClass('d-none');
        }

        $('#tamErrRotReason').text('');
    });

    function tamCheckRotationInterval() {
        /* Client-side check using allMappings data */
        const currentKm = typeof lastKnownKm !== 'undefined' ? lastKnownKm : 0;
        if (!currentKm) { $('#tamRotIntervalAlert').addClass('d-none'); return; }

        /* Find interval data from allMappings */
        const mapping = (typeof allMappings !== 'undefined') ?
            allMappings.find(function (m) { return m.pos === _tamCurrentPos; }) : null;

        /* If we don't have interval data, skip the check */
        if (!mapping) { $('#tamRotIntervalAlert').addClass('d-none'); return; }

        /* Data lives on tyre object — we don't have it here so skip */
        $('#tamRotIntervalAlert').addClass('d-none');
    }

    /* ── B8. ROTATE TAB — DYNAMIC MAPPING ROWS ──────────────────────────── */
    let _tamMappingRowCount = 0;

    $(document).on('click', '#tamBtnAddMapping', function () {
        _tamMappingRowCount++;
        const rowId = 'tamMapRow' + _tamMappingRowCount;
        const fromOptions = tamBuildPositionOptions('');
        const toOptions   = tamBuildPositionOptions('');

        const $row = $(`
            <div class="tam-mapping-row" id="${rowId}">
                <select class="form-select form-select-sm tam-map-from" name="rotation_mapping[${_tamMappingRowCount}][from]">
                    <option value="">— From —</option>
                    ${fromOptions}
                </select>
                <span class="tam-mapping-arrow"><i class="uil uil-arrow-right"></i></span>
                <select class="form-select form-select-sm tam-map-to" name="rotation_mapping[${_tamMappingRowCount}][to]">
                    <option value="">— To —</option>
                    ${toOptions}
                </select>
                <button type="button" class="tam-btn-remove-row" data-row="${rowId}" title="Remove row">
                    <i class="uil uil-trash"></i>
                </button>
            </div>
        `);

        /* Hide empty notice */
        $('#tamMappingEmpty').hide();
        $('#tamMappingRows').append($row);
        $('#tamErrRotMapping').text('');
    });

    $(document).on('click', '.tam-btn-remove-row', function () {
        const rowId = $(this).data('row');
        $('#' + rowId).remove();
        if ($('#tamMappingRows .tam-mapping-row').length === 0) {
            $('#tamMappingEmpty').show();
        }
    });

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

    /* ── B11. DONOR VEHICLE LOOKUP STUB ─────────────────────────────────── */
    $(document).on('click', '#tamBtnLookupVehicle', function () {
        const vehicleNo = $('#tamOtherVehicleNo').val().trim();
        if (!vehicleNo) {
            $('#tamErrOtherVehicle').text('Enter a vehicle number to look up.');
            return;
        }
        /* Full AJAX lookup wired in next sprint when backend endpoint exists */
        Toast.fire({ icon: 'info', title: 'Vehicle lookup — backend wiring coming soon.' });
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

        /* ── Backend stub: show Coming Soon toast (remove when endpoint is live) ── */
        Toast.fire({
            icon : 'info',
            title: '✅ Validation passed! Backend submission wiring coming in next sprint.'
        });

        /* ── When backend is ready, replace the Toast above with this AJAX pattern:
        const $btn = $(this);
        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);
        const fd = tamBuildFormData();
        const url = takeActionBaseUrl + '/' + _tamActiveTab + '-tyre';
        $.ajax({
            url: url, method: 'POST', data: fd, contentType: false, processData: false, dataType: 'json',
            success: function (res) {
                $('#takeActionModal').modal('hide');
                Toast.fire({ icon: 'success', title: res.message || 'Action logged!',
                    didClose: function () { window.location.reload(); } });
            },
            error: function (xhr) {
                $btn.html('<i class="uil uil-check me-1"></i>' + $('#tamSubmitLabel').text()).prop('disabled', false);
                const res = xhr.responseJSON || {};
                Toast.fire({ icon: 'error', title: res.message || 'Submission failed.' });
            }
        });
        ── */
    });

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
        if (!$('input[name="old_tyre_destination"]:checked').val()) {
            $('#tamErrOldDest').text('Please select a destination for the removed tyre.');
            ok = false;
        } else { $('#tamErrOldDest').text(''); }

        /* Old tyre action */
        if (!$('input[name="old_tyre_action"]:checked').val()) {
            $('#tamErrOldAction').text('Please select an action for the old tyre.');
            ok = false;
        } else { $('#tamErrOldAction').text(''); }

        if (!ok) {
            Toast.fire({ icon: 'warning', title: 'Please fill all required fields in the Replace tab.' });
        }
        return ok;
    }

    /* ── B14. VALIDATE ROTATE TAB ────────────────────────────────────────── */
    function tamValidateRotateTab() {
        let ok = true;

        if (!$('input[name="rotation_reason"]:checked').val()) {
            $('#tamErrRotReason').text('Please select a rotation reason.');
            ok = false;
        } else { $('#tamErrRotReason').text(''); }

        if (!$('#tamRotDate').val()) {
            $('#tamErrRotDate').text('Rotation date is required.');
            ok = false;
        } else { $('#tamErrRotDate').text(''); }

        if ($('#tamRotKm').val() === '') {
            $('#tamErrRotKm').text('KM at rotation is required.');
            ok = false;
        } else { $('#tamErrRotKm').text(''); }

        if ($('#tamMappingRows .tam-mapping-row').length === 0) {
            $('#tamErrRotMapping').text('Please add at least one mapping row.');
            ok = false;
        } else {
            /* Check each row has From and To selected */
            let rowOk = true;
            $('#tamMappingRows .tam-mapping-row').each(function () {
                if (!$(this).find('.tam-map-from').val() || !$(this).find('.tam-map-to').val()) {
                    rowOk = false;
                }
            });
            if (!rowOk) {
                $('#tamErrRotMapping').text('Each mapping row must have both From and To positions selected.');
                ok = false;
            } else { $('#tamErrRotMapping').text(''); }
        }

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
        $('.tam-old-source-pill').removeClass('active');
        $('.tam-old-action-pill').removeClass('active');
        $('#tamOwnVehicleOverLimitAlert').addClass('d-none');
        $('#tamOldOtherVehicleWrap').hide();
        $('#tamOtherPosAlert').addClass('d-none');
        $('#tamNoSpareAlert').addClass('d-none');
        $('#tamSpareFieldsWrap').show();

        /* Clear all Replace error spans */
        $('#tamPaneReplace .tam-field-error').text('');
        $('#tamErrRplSource').text('');

        /* Reset Rotate form */
        $('#tamRotateForm')[0] && $('#tamRotateForm')[0].reset();
        $('.tam-reason-card').removeClass('active');
        $('#tamRotateWeakHealthAlert').addClass('d-none');
        $('#tamRotIntervalAlert').addClass('d-none');
        /* Remove all mapping rows */
        _tamMappingRowCount = 0;
        $('#tamMappingRows .tam-mapping-row').remove();
        $('#tamMappingEmpty').show();
        $('#tamPaneRotate .tam-field-error').text('');

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
