/* Insurance Providers — index.js */
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

(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /* ── Toast ── */
    function showToast(msg, ok) {
        ok = ok !== false;
        // const el = document.getElementById('ipToast');
        // document.getElementById('ipToastMsg').textContent = msg;
        // el.classList.remove('bg-success', 'bg-danger', 'text-white');
        // el.classList.add(ok ? 'bg-success' : 'bg-danger', 'text-white');
        // bootstrap.Toast.getOrCreateInstance(el, { delay: 3500 }).show();

        Toast.fire({
            icon: ok ? 'success' : 'error',
            title: msg
        });
    }

    /* ── Clear errors ── */
    function clearErrors(prefix) {
        document.querySelectorAll('[id^="' + prefix + '_"][id$="_error"]').forEach(function (el) { el.textContent = ''; });
        document.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
    }

    /* ── AJAX helper — uses FormData to support file uploads ── */
    function apiFetch(url, method, formEl) {
        const fd = new FormData(formEl);
        if (method !== 'POST') { fd.append('_method', method); }
        return fetch(url, {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body   : fd,
        }).then(function (r) { return r.json(); });
    }

    /* ── Logo preview helper ── */
    function bindLogoPreview(inputId, previewId, placeholderIcon, imgEl) {
        var input = document.getElementById(inputId);
        if (!input) { return; }
        input.addEventListener('change', function () {
            if (!this.files || !this.files[0]) { return; }
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = document.getElementById(previewId);
                if (imgEl) {
                    imgEl.src = e.target.result;
                    imgEl.classList.remove('d-none');
                    if (placeholderIcon) { placeholderIcon.style.display = 'none'; }
                } else {
                    // For add modal: replace inner HTML
                    preview.innerHTML = '<img src="' + e.target.result + '" class="ip-logo-img" alt="Preview">';
                }
            };
            reader.readAsDataURL(this.files[0]);
        });
    }

    bindLogoPreview('add_contact_image', 'add_logo_preview', null, null);

    /* ── ADD ── */
    document.getElementById('addProviderForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('add');
        var btn = document.getElementById('addProviderBtn');
        var sp  = document.getElementById('addSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(window.IP_SAVE, 'POST', this)
            .then(function (d) {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addProviderModal')).hide();
                    document.getElementById('addProviderForm').reset();
                    showToast(d.message);
                    setTimeout(function () { location.reload(); }, 900);
                } else if (d.data) {
                    Object.entries(d.data).forEach(function (entry) {
                        var f    = entry[0]; var msgs = entry[1];
                        var el   = document.getElementById('add_' + f + '_error');
                        var inp  = document.getElementById('add_' + f);
                        if (el)  { el.textContent = Array.isArray(msgs) ? msgs[0] : msgs; }
                        if (inp) { inp.classList.add('is-invalid'); }
                    });
                } else {
                    showToast(d.message || 'An error occurred.', false);
                }
            })
            .catch(function () { showToast('Server error. Please try again.', false); })
            .finally(function () { btn.disabled = false; sp.classList.add('d-none'); });
    });

    /* ── Open edit modal ── */
    window.openEditModal = function (id) {
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editProviderModal'));
        document.getElementById('editLoadingSpinner').classList.remove('d-none');
        document.getElementById('editFormFields').classList.add('d-none');
        document.getElementById('edit_id').value = id;
        clearErrors('edit');
        modal.show();

        fetch(window.IP_JSON_URL + '/' + id + '/json', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (!d.success) { showToast('Could not load provider.', false); modal.hide(); return; }
            var c = d.contact;
            document.getElementById('edit_company_name').value = c.company_name || '';
            document.getElementById('edit_contact_name').value = c.contact_name || '';
            document.getElementById('edit_contact_code').value = c.contact_code || '';
            document.getElementById('edit_phone').value        = c.phone        || '';
            document.getElementById('edit_email').value        = c.email        || '';
            document.getElementById('edit_gst_number').value   = c.gst_number   || '';
            $('#edit_state_id').val(c.state_id || '').trigger('change');
            var statusVal   = c.status || 'Active';
            var statusRadio = document.querySelector('input[name="status"][value="' + statusVal + '"]');
            if (statusRadio) { statusRadio.checked = true; }

            /* ── Show current logo ── */
            var logoImg         = document.getElementById('edit_logo_img');
            var logoPlaceholder = document.getElementById('edit_logo_placeholder');
            if (c.contact_image) {
                logoImg.src = '/media/contact/' + c.contact_image;
                logoImg.classList.remove('d-none');
                if (logoPlaceholder) { logoPlaceholder.style.display = 'none'; }
            } else {
                logoImg.classList.add('d-none');
                logoImg.src = '';
                if (logoPlaceholder) { logoPlaceholder.style.display = ''; }
            }

            /* ── Re-bind logo preview for new upload ── */
            var editInput = document.getElementById('edit_contact_image');
            if (editInput) {
                var newInput = editInput.cloneNode(true);
                editInput.parentNode.replaceChild(newInput, editInput);
                newInput.addEventListener('change', function () {
                    if (!this.files || !this.files[0]) { return; }
                    var reader = new FileReader();
                    reader.onload = function (ev) {
                        logoImg.src = ev.target.result;
                        logoImg.classList.remove('d-none');
                        if (logoPlaceholder) { logoPlaceholder.style.display = 'none'; }
                    };
                    reader.readAsDataURL(this.files[0]);
                });
            }

            document.getElementById('editLoadingSpinner').classList.add('d-none');
            document.getElementById('editFormFields').classList.remove('d-none');
        })
        .catch(function () { showToast('Failed to load provider.', false); modal.hide(); });
    };

    /* ── EDIT ── */
    document.getElementById('editProviderForm').addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors('edit');
        var id  = document.getElementById('edit_id').value;
        var btn = document.getElementById('editProviderBtn');
        var sp  = document.getElementById('editSpinner');
        btn.disabled = true; sp.classList.remove('d-none');

        apiFetch(window.IP_JSON_URL + '/' + id + '/update', 'POST', this)
            .then(function (d) {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editProviderModal')).hide();
                    showToast(d.message);
                    setTimeout(function () { location.reload(); }, 900);
                } else if (d.data) {
                    Object.entries(d.data).forEach(function (entry) {
                        var f   = entry[0]; var msgs = entry[1];
                        var el  = document.getElementById('edit_' + f + '_error');
                        var inp = document.getElementById('edit_' + f);
                        if (el)  { el.textContent = Array.isArray(msgs) ? msgs[0] : msgs; }
                        if (inp) { inp.classList.add('is-invalid'); }
                    });
                } else {
                    showToast(d.message || 'An error occurred.', false);
                }
            })
            .catch(function () { showToast('Server error.', false); })
            .finally(function () { btn.disabled = false; sp.classList.add('d-none'); });
    });

    /* ── Toggle status ── */
    window.toggleStatus = function (id, currentStatus) {
        var action = currentStatus === 'Active' ? 'Deactivate' : 'Activate';
        if (!confirm(action + ' this provider?')) { return; }
        fetch(window.IP_JSON_URL + '/' + id + '/toggle-status', {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d.success) { showToast(d.message); setTimeout(function () { location.reload(); }, 700); }
            else           { showToast(d.message || 'Could not update status.', false); }
        })
        .catch(function () { showToast('Server error.', false); });
    };

    /* ── Delete ── */
    window.deleteProvider = function (id, name) {
        if (!confirm('Remove "' + name + '"?\n\nThis can be restored by an administrator.')) { return; }
        fetch(window.IP_JSON_URL + '/' + id, {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
            body   : '_method=DELETE',
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d.success) {
                showToast(d.message);
                var row = document.getElementById('ip-row-' + id);
                if (row) { row.style.transition = 'opacity .3s'; row.style.opacity = '0'; setTimeout(function () { row.remove(); }, 300); }
            } else {
                showToast(d.message || 'Could not delete.', false);
            }
        })
        .catch(function () { showToast('Server error.', false); });
    };

    /* ── Select2 init ── */
    $(document).ready(function () {
        $('#add_state_id').select2({ dropdownParent: $('#addProviderModal'),  width: '100%', placeholder: '— Select State —', allowClear: true });
        $('#edit_state_id').select2({ dropdownParent: $('#editProviderModal'), width: '100%', placeholder: '— Select State —', allowClear: true });
    });

    /* ── Clear add modal on close ── */
    document.getElementById('addProviderModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('addProviderForm').reset();
        document.getElementById('add_logo_preview').innerHTML = '<i class="uil uil-building ip-logo-placeholder-icon"></i>';
        document.querySelectorAll('#addProviderForm .is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
        document.querySelectorAll('#addProviderForm [id$="_error"]').forEach(function (el) { el.textContent = ''; });
    });

    /* ── Enter key on search ── */
    var searchInput = document.querySelector('input[name="name"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); document.getElementById('ipFilterForm').submit(); }
        });
    }

}());
