
$(document).ready(function() {

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


    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });


    // ── Fetch vehicle info ────────────────────────────────────────────────────
    $('#fetchData').on('click', function () {
        let vc_no = $('#vc_no').val().trim();

        if (vc_no === '') {
            Toast.fire({ icon: 'error', title: 'Please enter vehicle number!' });
            return;
        }

        $.ajax({
            url: FETCH_VEHICLE_INFO,
            type: 'POST',
            data: { vc_no: vc_no },
            beforeSend: function () {
                $('#fetchData').prop('disabled', true);
                $('.fetched-data').html('<p class="text-center p-3">Fetching vehicle data...</p>');
            },
            success: function (response) {
                $('.fetched-data').html(response);
            },
            error: function () {
                $('.fetched-data').html('<p class="text-danger text-center p-3">Vehicle not found</p>');
            },
            complete: function () {
                $('#fetchData').prop('disabled', false);
            }
        });
    });


    // ── Load vehicle sizes when a vehicle type is selected ───────────────────
    $(document).on('click', '.vehicleTypeId', function () {
        let vehicleTypeId = $(this).val();
        let url = VEHICLETYPE_SIZES.replace(':id', vehicleTypeId);

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('#vehicle_size').prop('disabled', true).html('<option>Loading...</option>');
            },
            success: function (response) {
                let options = '<option value="">Choose</option>';

                if (response.success && response.sizes.length > 0) {
                    response.sizes.forEach(function (size) {
                        options += `<option value="${size.id}">${size.name} - ${size.height} * ${size.width} * ${size.length}</option>`;
                    });
                } else {
                    options += '<option value="">No sizes found</option>';
                }

                $('#vehicle_size').html(options).prop('disabled', false);
            },
            error: function () {
                $('#vehicle_size').html('<option value="">Error loading sizes</option>').prop('disabled', false);
            }
        });
    });


    // ── Clear validation error on user input (BUG-04) ────────────────────────
    $(document).on('input change', 'input, select, textarea', function () {
        let name = $(this).attr('name');
        if (name) {
            $('#add_' + name + '_error').text('');
        }
    });


    // ── Form submit ───────────────────────────────────────────────────────────
    $(document).on('click', '#addBtn', function () {
        $('form#addForm').submit();
    });

    // Indian vehicle-number format: 2 letters + 2 digits + 1-2 letters + 4 digits (e.g. TS09QA1234)
    var VC_NO_REGEX = /^[A-Z]{2}[0-9]{2}[A-Z]{1,2}[0-9]{4}$/;

    $('form#addForm').on('submit', function () {
        var formData = new FormData(this);

        // clear previous errors
        $('small.error').text('');

        // Vehicle Number format check (block submit + inline error)
        var vcNo = ($('#vc_no').val() || '').trim();
        if (!VC_NO_REGEX.test(vcNo)) {
            $('#add_vc_no_error').text('Enter a valid vehicle number, e.g. TS09QA1234 (no spaces or dashes).');
            return false;
        }

        $('#addBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>')
            .attr('disabled', true);

        $.ajax({
            method: 'POST',
            data: formData,
            url: $(this).attr('action'),
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                Toast.fire({ icon: 'success', title: response.message || 'Saved successfully!' });
                $('#addBtn').html('Save').attr('disabled', false);
                setTimeout(function () { window.location.href = LISTING; }, 1500);
            },

            error: function (xhr) {
                $('#addBtn').html('Save').prop('disabled', false);

                let response = {};
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (e) {
                    Toast.fire({ icon: 'error', title: 'Something went wrong!' });
                    return;
                }

                Toast.fire({ icon: 'error', title: response.message || 'Please check validation errors.' });

                const errors = response.data || response.errors || {};
                Object.entries(errors).forEach(([field, messages]) => {
                    $('#add_' + field + '_error').text(messages[0]);
                });
            }
        });

        return false;
    });

});









