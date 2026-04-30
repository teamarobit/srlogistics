/* ==========================================================================
   Workshop Master — workshops.js  v1.2
   SD-1: All JS in external file only (no inline logic in blade)
   SD-3: $.ajax() for all form submissions
   SD-4: Validation errors as <span class="text-danger small d-block mt-1">
   SD-7: Toast mixin at top; Toast.fire() for all notifications
   v1.2: State/City Select2 dropdowns with AJAX city cascade (SCR-WS-M-001)
   ========================================================================== */

$(function () {

    /* ── SD-7: Toast mixin ──────────────────────────────────────────────── */
    var Toast = Swal.mixin({
        toast:            true,
        position:         'top',
        showConfirmButton: false,
        timer:            3000,
        timerProgressBar: true,
        didOpen: function (toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    /* ── SD-4: Validation error helpers ─────────────────────────────────── */
    function clearValidationErrors(scope) {
        $(scope || 'body').find('.field-error').remove();
    }

    function showValidationErrors(errors, scope) {
        clearValidationErrors(scope);
        $.each(errors, function (field, messages) {
            var $input = $(scope || 'body').find('[name="' + field + '"]').first();
            if ($input.length) {
                var $after = $input.hasClass('select2-hidden-accessible')
                    ? $input.next('.select2-container')
                    : $input;
                $('<span class="text-danger small d-block mt-1 field-error">' + messages[0] + '</span>')
                    .insertAfter($after);
            }
        });
    }

    /* ── Select2: State dropdowns (both modals) ──────────────────────────── */
    $('#addWsState').select2({
        dropdownParent: $('#addWsModal'),
        placeholder:    '— Select State —',
        width:          '100%',
        allowClear:     true,
    });

    $('#editWsState').select2({
        dropdownParent: $('#editWsModal'),
        placeholder:    '— Select State —',
        width:          '100%',
        allowClear:     true,
    });

    /* ── Select2: City dropdowns (tags:true — both modals) ──────────────── */
    $('#addWsCity').select2({
        dropdownParent: $('#addWsModal'),
        placeholder:    '— Select State first —',
        tags:           true,
        width:          '100%',
        allowClear:     true,
        createTag: function (params) {
            var term = $.trim(params.term);
            if (!term) { return null; }
            return { id: term, text: term, newTag: true };
        },
        insertTag: function (data, tag) { data.unshift(tag); },
    });

    $('#editWsCity').select2({
        dropdownParent: $('#editWsModal'),
        placeholder:    '— Select State first —',
        tags:           true,
        width:          '100%',
        allowClear:     true,
        createTag: function (params) {
            var term = $.trim(params.term);
            if (!term) { return null; }
            return { id: term, text: term, newTag: true };
        },
        insertTag: function (data, tag) { data.unshift(tag); },
    });

    /* ── City AJAX loader ────────────────────────────────────────────────── */
    /**
     * Load cities for a given stateId into $citySelect.
     * preselectName (optional): city name to pre-select after load (edit modal).
     */
    function loadCities(citiesUrl, stateId, $citySelect, preselectName) {
        $citySelect.empty().trigger('change');

        if (!stateId) { return; }

        $.getJSON(citiesUrl, { state_id: stateId }, function (cities) {
            $.each(cities, function (i, c) {
                $citySelect.append(new Option(c.name, c.name, false, false));
            });

            if (preselectName) {
                // Add option if not in list (tags mode — city might be custom)
                if (!$citySelect.find('option[value="' + preselectName + '"]').length) {
                    $citySelect.append(new Option(preselectName, preselectName, false, false));
                }
                $citySelect.val(preselectName);
            }

            $citySelect.trigger('change');
        });
    }

    /* ── Add modal: state change → reload cities ─────────────────────────── */
    $('#addWsState').on('change', function () {
        var stateId   = $(this).val();
        var citiesUrl = $('#addWsForm').data('cities-url');
        loadCities(citiesUrl, stateId, $('#addWsCity'), null);
    });

    /* pendingEditCity: city name to pre-select after state-change AJAX loads cities */
    var pendingEditCity = null;

    /* ── Edit modal: state change → reload cities ────────────────────────── */
    $('#editWsState').on('change', function () {
        var stateId   = $(this).val();
        var citiesUrl = $('#editWsForm').data('cities-url');
        var preselect = pendingEditCity;
        pendingEditCity = null; // consume immediately
        loadCities(citiesUrl, stateId, $('#editWsCity'), preselect);
    });

    /* ── Reset Add modal on close ────────────────────────────────────────── */
    $('#addWsModal').on('hidden.bs.modal', function () {
        $('#addWsForm')[0].reset();
        $('#addWsState').val(null).trigger('change');
        $('#addWsCity').empty().trigger('change');
        clearValidationErrors('#addWsModal');
        $('.ws-external-only').hide();
        $('.opt-external').hide();
        $('.ws-own-only').show();
        $('.opt-own').show();
        $('#addWsType').val('');
        $('#btnSaveWs').prop('disabled', false).html('<i class="uil uil-save me-1"></i> Save Workshop');
    });

    /* ── Ownership tab filter ────────────────────────────────────────────── */
    $('#ownershipTabs .nav-link').on('click', function (e) {
        e.preventDefault();
        $('#ownershipTabs .nav-link').removeClass('active');
        $(this).addClass('active');
        applyWsFilters();
    });

    /* ── Add modal: toggle fields by ownership ───────────────────────────── */
    $('input[name="ownership"]').on('change', function () {
        var own = $(this).val() === 'Own';
        $('.ws-own-only').toggle(own);
        $('.ws-external-only').toggle(!own);
        $('#addWsType').val('');
        $('.opt-own').toggle(own);
        $('.opt-external').toggle(!own);
    });
    /* init state */
    $('.ws-external-only').hide();
    $('.opt-external').hide();

    /* ── Unified client-side filter ──────────────────────────────────────── */
    function applyWsFilters() {
        var ownership = $('#ownershipTabs .nav-link.active').data('ownership') || '';
        var type      = $('#wsTypeFilter').val().toLowerCase();
        var status    = $('#wsStatusFilter').val().toLowerCase();
        var search    = $('#wsSearch').val().toLowerCase();
        var count     = 0;

        $('#wsTable tbody tr[data-ownership]').each(function () {
            var $tr   = $(this);
            var match = true;
            if (ownership && $tr.data('ownership') !== ownership.toLowerCase()) { match = false; }
            if (type   && $tr.data('type').indexOf(type)     === -1) { match = false; }
            if (status && $tr.data('status').indexOf(status) === -1) { match = false; }
            if (search) {
                var haystack = ($tr.data('name')  || '') + ' ' +
                               ($tr.data('city')  || '') + ' ' +
                               ($tr.data('code')  || '');
                if (haystack.indexOf(search) === -1) { match = false; }
            }
            $tr.toggle(match);
            if (match) { count++; }
        });
        $('#wsCount').text('Showing ' + count + ' workshop(s)');
    }

    $('#wsTypeFilter, #wsStatusFilter').on('change', applyWsFilters);
    $('#wsSearch').on('keyup', applyWsFilters);

    /* ── SD-3: Add form submission ───────────────────────────────────────── */
    $('#addWsForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors('#addWsModal');

        var $form = $(this);
        var $btn  = $('#btnSaveWs');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Saving…');

        $.ajax({
            url:     $form.attr('action'),
            method:  'POST',
            data:    $form.serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' },
            success: function (res) {
                if (res.success) {
                    Toast.fire({ icon: 'success', title: res.message });
                    setTimeout(function () { location.reload(); }, 1600);
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="uil uil-save me-1"></i> Save Workshop');
                if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors || {}, '#addWsModal');
                } else {
                    Toast.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
                }
            }
        });
    });

    /* ── Edit modal: populate fields ─────────────────────────────────────── */
    $(document).on('click', '.btn-edit-ws', function () {
        var b = $(this);
        clearValidationErrors('#editWsModal');

        $('#editWsId').val(b.data('id'));
        $('#editWsCode').val(b.data('code'));
        $('#editWsName').val(b.data('name'));
        $('#editWsOwnership').val(b.data('ownership'));
        $('#editWsOwnershipHidden').val(b.data('ownership'));
        $('#editWsType').val(b.data('type'));
        $('#editWsBrand').val(b.data('brand') || '');
        $('#editWsManager').val(b.data('manager') || '');
        $('#editWsPhone').val(b.data('phone')   || '');
        $('#editWsEmail').val(b.data('email')   || '');
        $('#editWsTechs').val(b.data('techs')   || 0);
        $('#editWsNotes').val(b.data('notes')   || '');
        $('#editWsStatus').val(b.data('status'));

        var stateId  = b.data('state-id') || '';
        var cityName = b.data('city')     || '';

        if (stateId) {
            // Store city name — state 'change' handler will consume it after AJAX
            pendingEditCity = cityName || null;
            $('#editWsState').val(stateId).trigger('change');
        } else {
            pendingEditCity = null;
            $('#editWsState').val(null).trigger('change');
            $('#editWsCity').empty().trigger('change');
        }
    });

    /* ── SD-3: Update form submission ────────────────────────────────────── */
    $('#btnUpdateWs').on('click', function () {
        clearValidationErrors('#editWsModal');

        var id      = $('#editWsId').val();
        var baseUrl = $('#editWsForm').data('update-url');
        var url     = baseUrl.replace('__ID__', id);

        var $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Updating…');

        $.ajax({
            url:     url,
            method:  'POST',
            data:    $('#editWsForm').serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' },
            success: function (res) {
                if (res.success) {
                    Toast.fire({ icon: 'success', title: res.message });
                    setTimeout(function () { location.reload(); }, 1500);
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="uil uil-save me-1"></i> Update');
                if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors || {}, '#editWsModal');
                } else if (xhr.status === 404) {
                    Toast.fire({ icon: 'error', title: 'Workshop not found.' });
                } else {
                    Toast.fire({ icon: 'error', title: 'Update failed. Please try again.' });
                }
            }
        });
    });

    /* ── Toggle active / inactive ────────────────────────────────────────── */
    $(document).on('click', '.btn-toggle-ws', function () {
        var id      = $(this).data('id');
        var name    = $(this).data('name');
        var current = $(this).data('current');
        var action  = current === 'Active' ? 'Deactivate' : 'Activate';

        Swal.fire({
            title:              action + ' workshop?',
            text:               '"' + name + '"',
            icon:               'warning',
            showCancelButton:   true,
            confirmButtonColor: current === 'Active' ? '#ea0027' : '#10863f',
            confirmButtonText:  action
        }).then(function (r) {
            if (!r.isConfirmed) { return; }

            var baseUrl = $('#wsTable').data('destroy-url');
            var url     = baseUrl.replace('__ID__', id);

            $.ajax({
                url:     url,
                method:  'POST',
                data:    { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content') },
                headers: { 'Accept': 'application/json' },
                success: function (res) {
                    Toast.fire({ icon: 'success', title: res.message });
                    setTimeout(function () { location.reload(); }, 1400);
                },
                error: function () {
                    Toast.fire({ icon: 'error', title: 'Action failed. Please try again.' });
                }
            });
        });
    });

});
