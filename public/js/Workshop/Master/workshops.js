/* ==========================================================================
   Workshop Master — workshops.js  v1.2
   SD-1: All JS in external file only (no inline logic in blade)
   SD-3: $.ajax() for all form submissions
   SD-4: Validation errors as <span class="text-danger small d-block mt-1">
   SD-7: Toast mixin at top; Toast.fire() for all notifications
   v1.2: State/City Select2 dropdowns with AJAX city cascade (SCR-WS-M-001)
   v1.6: intl-tel-input phone (India default) + pincode(6)/mobile(10) validation
   v1.7: use global .telinput init (v25) — removed conflicting v17 import
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
                var $after = $input;
                if ($input.hasClass('select2-hidden-accessible')) {
                    $after = $input.next('.select2-container');
                } else if ($input.closest('.iti').length) {
                    // intl-tel-input wraps the input — place error after the widget
                    $after = $input.closest('.iti');
                }
                $('<span class="text-danger small d-block mt-1 field-error">' + messages[0] + '</span>')
                    .insertAfter($after);
            }
        });
    }

    /* ── intl-tel-input ──────────────────────────────────────────────────
       Phone fields carry class "telinput" and are initialised by the global
       initTelInputs() in layouts.app (intl-tel-input v25, India default).
       Do NOT re-import the library here — a second version overrides
       window.intlTelInput and breaks the v25 CSS (flag rendered above input). */

    /* Keep only national digits (max 10) in the input before serialize */
    function nationalPhone($input) {
        var digits = ($input.val() || '').replace(/\D/g, '').slice(0, 10);
        $input.val(digits);
    }

    /* Restrict pincode + phone inputs to digits as the user types */
    $('#addWsPincode, #editWsPincode').on('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 6);
    });
    $('#addWsPhone, #editWsPhone').on('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

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

    /* ── Reset Edit modal on close ──────────────────────────────────────── */
    $('#editWsModal').on('hidden.bs.modal', function () {
        clearValidationErrors('#editWsModal');
        /* Reset edit-modal ownership fields to a neutral state */
        $('.ws-edit-external-only').hide();
        $('.opt-edit-external').hide();
        $('.ws-edit-own-only').show();
        $('.opt-edit-own').show();
        $('#editWsType').val('');
        $('#btnUpdateWs').prop('disabled', false).html('<i class="uil uil-save me-1"></i> Update');
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
            if (status && String($tr.data('status')) !== status) { match = false; }
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

    /* ── Refresh button: reload fresh data from server ──────────────────── */
    $('#wsRefreshBtn').on('click', function () {
        var $btn = $(this);
        $btn.prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-1" role="status"></span>Refreshing…');
        location.reload();
    });

    /* ── SD-3: Add form submission ───────────────────────────────────────── */
    $('#addWsForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors('#addWsModal');

        var $form = $(this);
        var $btn  = $('#btnSaveWs');
        nationalPhone($('#addWsPhone'));
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

    /* ── Edit modal: apply ownership-driven visibility ───────────────────── */
    function applyEditOwnership(ownership) {
        var isOwn = ownership === 'Own';
        $('.ws-edit-own-only').toggle(isOwn);
        $('.ws-edit-external-only').toggle(!isOwn);
        $('.opt-edit-own').toggle(isOwn);
        $('.opt-edit-external').toggle(!isOwn);
    }

    /* ── Edit modal: populate fields ─────────────────────────────────────── */
    $(document).on('click', '.btn-edit-ws', function () {
        var b = $(this);
        clearValidationErrors('#editWsModal');

        $('#editWsId').val(b.data('id'));
        $('#editWsCode').val(b.data('code'));
        $('#editWsName').val(b.data('name'));
        $('#editWsOwnership').val(b.data('ownership'));
        $('#editWsOwnershipHidden').val(b.data('ownership'));

        /* Apply show/hide before setting type so correct optgroup is visible */
        applyEditOwnership(b.data('ownership'));

        $('#editWsType').val(b.data('type'));
        $('#editWsBrand').val(b.data('brand') || '');
        $('#editWsManager').val(b.data('manager') || '');
        $('#editWsPhone').val(String(b.data('phone') || '').replace(/\D/g, '').slice(-10));
        $('#editWsEmail').val(b.data('email')   || '');
        $('#editWsTechs').val(b.data('techs')   || 0);
        $('#editWsNotes').val(b.data('notes')   || '');
        $('#editWsStatus').val(b.data('status'));
        $('#editWsAddress').val(b.data('address'));
        $('#editWsPincode').val(b.data('pincode'));

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
        nationalPhone($('#editWsPhone'));
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
            // confirmButtonColor: current === 'Active' ? '#ea0027' : '#10863f',
            confirmButtonColor:'#1F75A8',
            reverseButtons: true,
            confirmButtonText:  action
        }).then(function (r) {
            if (!r.isConfirmed) { return; }

            var baseUrl = $('#wsTable').data('destroy-url');
            var url     = baseUrl.replace('__ID__', id);

            $.ajax({
                url:     url,
                method:  'POST',
                data:    { _token: $('meta[name="csrf-token"]').attr('content') },
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
