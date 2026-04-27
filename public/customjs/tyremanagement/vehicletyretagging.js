/* ═══════════════════════════════════════════════════════════════════════════
   SR Logistics — Tyre Tagging JS  |  vehicletyretagging.js  v4.0
   Handles:
     • SVG load → RAG coloring
     • SVG ↔ Card bidirectional sync (click / hover)
     • Allocate Tyre modal (renamed from Add Tyre):
         – Source toggle: SR Warehouse ↔ Direct Fitment
         – SR Warehouse: AJAX tyre dropdown (condition+type filter, health preview)
         – Direct Fitment: manual Brand + Serial Number entry
         – Auto-fill readonly brand/serial from warehouse selection
         – Odometer KM validation (fitment_date + lastKnownKm/lastKnownDate)
         – 3 optional photo attachments (FormData AJAX)
     • Add Spare Tyre modal: same AJAX pattern, INSERT new mapping (status=Spare)
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


    // ── 4. OPEN ALLOCATE TYRE MODAL — RESET + PRE-FILL ──────────────────────
    $(document).on('click', '.btn-add-tyre', function () {
        const pos       = $(this).data('position') || '';
        const mappingId = $(this).data('mapping-id') || '';

        // Reset all fields
        $('#modalPositionLabel').text(pos);
        $('#addTyrePositionCode').val(pos);
        $('#addTyreMappingId').val(mappingId);

        // Source: reset to SR Warehouse
        $('#srcWarehouse').prop('checked', true);
        showWarehouseSection();

        // Condition + Type
        $('#tyreConditionSelect').val('');
        $('#tyreTypeSelect').val('');
        resetTyreDropdown();

        // Auto-fill readonly fields
        $('#wh_tyreBrand').val('');
        $('#wh_tyreSerial').val('');

        // Direct Fitment fields
        $('#directTyreBrand').val('');
        $('#directTyreSerial').val('');

        // Fitment Date + KM
        $('#fitmentDateInput').val('');
        $('#kmAtFitmentInput').val('');
        $('#kmOdoHint').addClass('d-none');
        $('#kmOdoWarning').addClass('d-none');

        // Show the odometer hint if lastKnownKm is available
        if (lastKnownKm && lastKnownDate) {
            const formatted = new Date(lastKnownDate).toLocaleDateString('en-IN', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
            $('#kmHintKm').text(lastKnownKm.toLocaleString('en-IN'));
            $('#kmHintDate').text(formatted);
            $('#kmOdoHint').removeClass('d-none');
        }

        // Photos
        $('#photoSerial, #photoFitment, #photoOdometer').val('');
        $('#previewSerial, #previewFitment, #previewOdometer').addClass('d-none').find('img').attr('src', '');

        clearFormErrors();
    });

    // Show/hide warehouse vs direct fitment sections
    function showWarehouseSection() {
        $('#srcWarehouseSection').removeClass('d-none');
        $('#srcDirectSection').addClass('d-none');
        // Brand/serial in warehouse section are read-only auto-fill — no name attr needed
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

    // Reset warehouse AJAX dropdown to blank/disabled state
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


    // ── 5. SOURCE TOGGLE ─────────────────────────────────────────────────────
    $(document).on('change', 'input[name="tyre_source"]', function () {
        clearFormErrors();
        if ($(this).val() === 'SR Warehouse') {
            showWarehouseSection();
        } else {
            showDirectSection();
        }
    });


    // ── 6. AJAX TYRE DROPDOWN — fires when BOTH condition + type are set ──────
    function maybeFetchTyres() {
        // Only fetch when SR Warehouse is active
        if ($('#srcWarehouse').is(':checked') === false) return;

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
        $('#wh_tyreBrand').val('');
        $('#wh_tyreSerial').val('');

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
                                    data-serial="${t.tyre_serial_number ?? ''}">
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


    // ── 7. TYRE SELECTED → HEALTH PREVIEW + AUTO-FILL BRAND/SERIAL ───────────
    $(document).on('change', '#tyreIdSelect', function () {
        const $opt      = $(this).find('option:selected');
        const healthPct = $opt.data('health');
        const rag       = $opt.data('rag') || 'grey';
        const brand     = $opt.data('brand') || '';
        const serial    = $opt.data('serial') || '';

        // Auto-fill readonly fields
        $('#wh_tyreBrand').val(brand);
        $('#wh_tyreSerial').val(serial);

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


    // ── 8. ODOMETER VALIDATION (client-side) ─────────────────────────────────
    // Rule a: if fitmentDate >= lastKnownDate → km must be >= lastKnownKm
    // Rule b: if fitmentDate < lastKnownDate  → any km allowed
    function validateOdometer() {
        if (!lastKnownKm || !lastKnownDate) return true;

        const fitDate = $('#fitmentDateInput').val();
        const kmVal   = $('#kmAtFitmentInput').val();

        if (!fitDate || kmVal === '') {
            $('#kmOdoWarning').addClass('d-none');
            return true;
        }

        const fDate    = new Date(fitDate);
        const lDate    = new Date(lastKnownDate);
        const enteredKm = parseFloat(kmVal);

        if (fDate >= lDate && enteredKm < lastKnownKm) {
            const formatted = lDate.toLocaleDateString('en-IN', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
            $('#kmOdoWarningText').text(
                'KM must be ≥ ' + lastKnownKm.toLocaleString('en-IN')
                + ' (last recorded on ' + formatted + ').'
            );
            $('#kmOdoWarning').removeClass('d-none');
            return false;
        }

        $('#kmOdoWarning').addClass('d-none');
        return true;
    }

    $('#fitmentDateInput, #kmAtFitmentInput').on('change input', validateOdometer);


    // ── 9. PHOTO THUMBNAIL PREVIEW ────────────────────────────────────────────
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


    // ── 10. SAVE — POST VIA FormData (supports file uploads) ──────────────────
    $('#saveAddTyre').on('click', function () {
        const $btn      = $(this);
        const source    = $('input[name="tyre_source"]:checked').val();
        const condition = $('#tyreConditionSelect').val();
        const type      = $('#tyreTypeSelect').val();
        const fitment   = $('#fitmentDateInput').val();
        const km        = $('#kmAtFitmentInput').val();
        const mappingId = $('#addTyreMappingId').val();

        clearFormErrors();

        // Client-side validation
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

        // Odometer check before submit
        if (!validateOdometer()) { showError('err_km_at_fitment', $('#kmOdoWarningText').text()); hasError = true; }

        if (hasError) return;

        if (!mappingId) {
            Toast.fire({ icon: 'error', title: 'Mapping ID missing. Please close and reopen.' });
            return;
        }

        // Build FormData (needed for file uploads)
        const fd = new FormData();
        fd.append('_token',        csrfToken);
        fd.append('tyre_source',   source);
        fd.append('tyre_condition', condition);
        fd.append('tyre_type',     type);
        fd.append('fitment_date',  fitment);
        if (km) fd.append('km_at_fitment', km);

        if (source === 'SR Warehouse') {
            fd.append('tyre_id', $('#tyreIdSelect').val());
        } else {
            fd.append('tyre_brand',         $('#directTyreBrand').val().trim());
            fd.append('tyre_serial_number', $('#directTyreSerial').val().trim());
        }

        // Attach photos
        const photoFields = { photo_serial: '#photoSerial', photo_fitment: '#photoFitment', photo_odometer: '#photoOdometer' };
        $.each(photoFields, function (fieldName, selector) {
            const input = $(selector)[0];
            if (input && input.files && input.files[0]) {
                fd.append(fieldName, input.files[0]);
            }
        });

        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        $.ajax({
            url         : `${addTyreBaseUrl}/${mappingId}/add-tyre`,
            method      : 'POST',
            data        : fd,
            contentType : false,
            processData : false,
            dataType    : 'json',
            success     : function (res) {
                $('#addTyre').modal('hide');
                Toast.fire({
                    icon   : 'success',
                    title  : res.message || 'Tyre allocated successfully!',
                    didClose: function () {
                        window.location.href = res.redirect_url || window.location.href;
                    }
                });
            },
            error: function (xhr) {
                $btn.html('<i class="uil uil-tag-alt me-1"></i>Save &amp; Allocate Tyre').prop('disabled', false);
                const res = xhr.responseJSON || {};

                if (xhr.status === 422 && res.errors) {
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


    // ── 11. HELPER: show/clear inline errors (Allocate Tyre modal) ───────────
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


    // ── 12. REPLACE BUTTON (stub — future sprint) ─────────────────────────────
    $(document).on('click', '.btn-replace', function () {
        const pos = $(this).data('position');
        Toast.fire({ icon: 'info', title: 'Replace workflow for ' + pos + ' — coming soon.' });
    });


    // ── 13. OPEN ADD SPARE MODAL — RESET FORM ────────────────────────────────
    $(document).on('click', '.btn-add-spare-slot', function () {
        resetSpareTyreDropdown();
        $('#spareTyreConditionSelect').val('');
        $('#spareTyreTypeSelect').val('');
        $('#spareFitmentDateInput').val('');
        $('#spareKmAtFitmentInput').val('');
        clearSpareFormErrors();
    });

    function resetSpareTyreDropdown() {
        $('#spareTyreIdSelect')
            .prop('disabled', true)
            .html('<option value="">— Select condition &amp; type first —</option>');
        $('#spareTyreDropdownState')
            .text('— Select condition & type to load available tyres —')
            .removeClass('text-danger text-success text-warning')
            .addClass('text-muted');
        $('#spareTyreHealthPreview').addClass('d-none');
    }


    // ── 14. SPARE AJAX TYRE DROPDOWN ─────────────────────────────────────────
    function maybeFetchSpareTyres() {
        const condition = $('#spareTyreConditionSelect').val();
        const type      = $('#spareTyreTypeSelect').val();

        if (!condition || !type) {
            resetSpareTyreDropdown();
            return;
        }

        $('#spareTyreIdSelect')
            .prop('disabled', true)
            .html('<option value="">Loading…</option>');
        $('#spareTyreDropdownState')
            .text('Fetching available tyres from warehouse…')
            .removeClass('text-danger text-success text-warning text-muted')
            .addClass('text-muted');
        $('#spareTyreHealthPreview').addClass('d-none');

        $.ajax({
            url     : getTyreListUrl,
            method  : 'GET',
            data    : { condition: condition, type: type },
            dataType: 'json',
            success : function (res) {
                const tyres = res.tyres || [];

                if (tyres.length === 0) {
                    $('#spareTyreIdSelect')
                        .prop('disabled', true)
                        .html('<option value="">No tyres available in Warehouse</option>');
                    $('#spareTyreDropdownState')
                        .text('No warehouse tyres match this condition & type.')
                        .removeClass('text-muted text-success text-warning')
                        .addClass('text-danger');
                    return;
                }

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

                $('#spareTyreIdSelect')
                    .prop('disabled', false)
                    .html(options);
                $('#spareTyreDropdownState')
                    .text(`${tyres.length} tyre(s) available in Warehouse.`)
                    .removeClass('text-muted text-danger text-warning')
                    .addClass('text-success');
            },
            error: function () {
                $('#spareTyreIdSelect')
                    .prop('disabled', true)
                    .html('<option value="">Error loading tyres</option>');
                $('#spareTyreDropdownState')
                    .text('Failed to load tyres. Please try again.')
                    .removeClass('text-muted text-success text-warning')
                    .addClass('text-danger');
            }
        });
    }

    $('#spareTyreConditionSelect, #spareTyreTypeSelect').on('change', maybeFetchSpareTyres);


    // ── 15. SPARE TYRE SELECTED → HEALTH PREVIEW ─────────────────────────────
    $(document).on('change', '#spareTyreIdSelect', function () {
        const $opt      = $(this).find('option:selected');
        const healthPct = $opt.data('health');
        const rag       = $opt.data('rag') || 'grey';

        if (!$(this).val() || healthPct === '') {
            $('#spareTyreHealthPreview').addClass('d-none');
            return;
        }

        const pct = healthPct !== '' && healthPct !== undefined ? parseFloat(healthPct) : null;

        if (pct !== null) {
            $('#spareHealthBarFill')
                .css('width', pct + '%')
                .removeClass('rag-bg-green rag-bg-amber rag-bg-red rag-bg-grey')
                .addClass('rag-bg-' + rag);
            $('#spareHealthPctText').text(pct + '%');
        } else {
            $('#spareHealthPctText').text('N/A');
            $('#spareHealthBarFill').css('width', '0%');
        }

        const ragLabel = rag === 'green' ? '🟢 Good'
                       : rag === 'amber' ? '🟡 Moderate'
                       : rag === 'red'   ? '🔴 Critical'
                       : '⚫ Unknown';
        $('#spareHealthRagBadge')
            .text(ragLabel)
            .removeClass('rag-badge rag-green rag-amber rag-red rag-grey')
            .addClass('rag-badge rag-' + rag);

        $('#spareTyreHealthPreview').removeClass('d-none');
    });


    // ── 16. SAVE SPARE — POST TO addSpareTyre ────────────────────────────────
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
            url     : addSpareUrl,
            method  : 'POST',
            data    : {
                _token        : csrfToken,
                tyre_id       : tyreId,
                fitment_date  : fitment,
                km_at_fitment : kmFitment || null,
            },
            dataType: 'json',
            success : function (res) {
                $('#addSpare').modal('hide');
                Toast.fire({
                    icon    : 'success',
                    title   : res.message || 'Spare tyre added successfully!',
                    didClose: function () {
                        window.location.href = res.redirect_url || window.location.href;
                    }
                });
            },
            error: function (xhr) {
                $btn.html('<i class="uil uil-save me-1"></i>Save &amp; Add Spare').prop('disabled', false);
                const res = xhr.responseJSON || {};

                if (xhr.status === 422 && res.errors) {
                    $.each(res.errors, function (field, messages) {
                        showSpareError('spare_err_' + field, messages[0]);
                    });
                    Toast.fire({ icon: 'warning', title: res.message || 'Validation failed.' });
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Something went wrong. Please try again.' });
                }
            }
        });
    });


    // ── 17. SPARE HELPERS: show/clear inline errors ──────────────────────────
    function showSpareError(id, msg) {
        const $el = $('#' + id);
        $el.text(msg).show();
        $el.prev('select, input, .input-group').addClass('is-invalid');
    }

    function clearSpareFormErrors() {
        $('#addSpareInlineForm .invalid-feedback').text('').hide();
        $('#addSpareInlineForm select, #addSpareInlineForm input').removeClass('is-invalid');
    }

});
