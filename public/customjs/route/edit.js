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
    
    
    /* ================= SELECT2 INIT ================= */
    function initSelect2(context = document) {
        $(context).find('.select2-tags').select2({
            tags: true,
            width: '100%',
            placeholder: 'Choose or type a city',
            allowClear: true
        });
    }

    initSelect2();
    
    
    /* ================= DEPENDENT SELECT ================= */
    // Setup dependent selects (state -> city)
    setupDependentSelect('.dependent-select', 'Choose city');

    function setupDependentSelect(firstSelectSelector, placeholder = 'Select option...') {

        $(document).on('change', firstSelectSelector, function () {

            let $this = $(this);
            let targetId = $this.data('target');
            let $target = $('#' + targetId);
            let url = $this.find(':selected').data('url');

            // Reset city
            $target.empty().append(`<option value="">Loading...</option>`);

            if (!url) {
                $target.html(`<option value="">${placeholder}</option>`);
                return;
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function (res) {

                    // Destroy old Select2
                    if ($target.hasClass("select2-hidden-accessible")) {
                        $target.select2('destroy');
                    }

                    $target.empty().append(`<option value="">${placeholder}</option>`);

                    // Append options dynamically
                    $.each(res, function (i, item) {
                        $target.append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    });

                    // Re-init Select2 with tagging
                    $target.select2({
                        tags: true,          // enable tagging
                        width: '100%',
                        placeholder: placeholder,
                        allowClear: true
                    });
                },
                error: function (xhr) {

                    let message = 'Something went wrong.';
                
                    if (xhr.responseJSON) {
                
                        if (xhr.responseJSON.errors) {
                            message = Object.values(xhr.responseJSON.errors)[0][0];
                        } else if (xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                
                    } else if (xhr.responseText) {
                        message = xhr.responseText;
                    }
                
                    Toast.fire({
                        icon: 'error',
                        title: message
                    });
                
                }
            });
        });
    }
    
    
    /* ================= TOGGLE DELETE ICONS ================= */
    function toggleDeleteIcons() {

        // TOLL
        if ($('.toll-row').length > 1) {
            $('.toll-row .removeTollField').show();
            $('.toll-row:first .removeTollField').hide();
        } else {
            $('.toll-row .removeTollField').hide();
        }

        // RTO
        if ($('.rto-row').length > 1) {
            $('.rto-row .removeRtoField').show();
            $('.rto-row:first .removeRtoField').hide();
        } else {
            $('.rto-row .removeRtoField').hide();
        }
    }

    toggleDeleteIcons();
     
    
    
    /* ================= ADD TOLL ================= */
    $(document).on('click', '.addTollField', function () {

        let $wrapper = $('.toll-wrapper');
        let $row = $wrapper.find('.toll-row:first').clone();

        // destroy select2 before clone append
        $row.find('select.select2-hidden-accessible').select2('destroy');

        // reset values
        $row.find('input').val('');
        $row.find('select').val('');

        $wrapper.append($row);

        // re-init select2
        initSelect2($row);

        toggleDeleteIcons();
    });

    /* ================= REMOVE TOLL ================= */
    $(document).on('click', '.removeTollField', function () {
        if ($('.toll-row').length > 1) {
            $(this).closest('.toll-row').remove();
            toggleDeleteIcons();
        }
    });

    /* ================= ADD RTO ================= */
    $(document).on('click', '.addRtoField', function () {

        let $wrapper = $('.rto-wrapper');
        let $row = $wrapper.find('.rto-row:first').clone();

        $row.find('select.select2-hidden-accessible').select2('destroy');
        $row.find('input').val('');
        $row.find('select').val('');

        $wrapper.append($row);

        initSelect2($row);

        toggleDeleteIcons();
    });
    

    /* ================= REMOVE RTO ================= */
    $(document).on('click', '.removeRtoField', function () {
        if ($('.rto-row').length > 1) {
            $(this).closest('.rto-row').remove();
            toggleDeleteIcons();
        }
    });
    
    //==========================================================================
    
    $(document).on('change', '.toll-select', function () {

        let selectedVal = $(this).val();
        let $currentSelect = $(this);
    
        if (!selectedVal) return;
    
        let duplicate = false;
    
        $('.toll-select').not($currentSelect).each(function () {
            if ($(this).val() === selectedVal) {
                duplicate = true;
                return false; // break loop
            }
        });
    
        if (duplicate) {
            Toast.fire({
                    icon: 'error',
                    title: 'This Tollstation is already selected. Please choose another one.'
                });
            
            // reset current select + charges
            $currentSelect.val('');
            let $row = $currentSelect.closest('.toll-row');
            $row.find('.toll-large, .toll-medium, .toll-small').val('');
            return;
        }
    
        /* ================= FETCH CHARGES ================= */
    
        let tollId = selectedVal;
        let $row = $currentSelect.closest('.toll-row');
        
        //console.log("tollId:- "+tollId);
    
        $.ajax({
            url: '/get-toll-charges/' + tollId,
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $row.find('.toll-large').val(res.data.large_vehicle_charge);
                    $row.find('.toll-medium').val(res.data.medium_vehicle_charge);
                    $row.find('.toll-small').val(res.data.small_vehicle_charge);
                }
            },
            error: function () {
                $row.find('.toll-large, .toll-medium, .toll-small').val('');
            }
        });
    });
    

    //==========================================================================
    
    $(document).on('change', '.rto-select', function () {

        let selectedVal = $(this).val();
        let $currentSelect = $(this);
    
        if (!selectedVal) return;
    
        let duplicate = false;
    
        $('.rto-select').not($currentSelect).each(function () {
            if ($(this).val() === selectedVal) {
                duplicate = true;
                return false; // break loop
            }
        });
    
        if (duplicate) {
            Toast.fire({
                    icon: 'error',
                    title: 'This RTO is already selected. Please choose another one.'
                });
            
            // reset current select + charges
            $currentSelect.val('');
            let $row = $currentSelect.closest('.rto-row');
            $row.find('.rto-large, .rto-medium, .rto-small').val('');
            return;
        }
    
        /* ================= FETCH CHARGES ================= */
    
        let rtoId = selectedVal;
        let $row = $currentSelect.closest('.rto-row');
    
        $.ajax({
            url: '/get-rto-charges/' + rtoId,
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $row.find('.rto-large').val(res.data.charge_for_large_truck);
                    $row.find('.rto-medium').val(res.data.charge_for_medium_truck);
                    $row.find('.rto-small').val(res.data.charge_for_small_truck);
                }
            },
            error: function () {
                $row.find('.rto-large, .rto-medium, .rto-small').val('');
            }
        });
    });
    
    
    
    
    //==========================================================================
    
    function validateRouteCities(currentSelect) {

        let currentValue = currentSelect.val();
    
        if (!currentValue) return;
    
        let duplicate = false;
    
        $('#sourceCity, #destinationCity, .midpointCity')
            .not(currentSelect)
            .each(function () {
    
                if ($(this).val() === currentValue) {
                    duplicate = true;
                    return false; // break loop
                }
            });
    
        if (duplicate) {
    
            Toast.fire({
                icon: 'error',
                title: 'Duplicate city not allowed in route'
            });
    
            // Clear only current select properly (Select2 safe)
            currentSelect.val(null).trigger('change');
        }
    }


    
    let routeInitialized = false;

    function updateRouteName() {
    
        // Prevent overwrite on first load
        if(!routeInitialized){
            routeInitialized = true;
            return;
        }
    
        let parts = [];
    
        // SOURCE
        let sourceCityText  = $('#sourceCity option:selected').text();
        let sourceStateText = $('#sourceState option:selected').text();
    
        if ($('#sourceCity').val()) {
            parts.push(sourceCityText);
        } else if ($('#sourceState').val()) {
            parts.push(sourceStateText);
        }
    
        // MIDPOINTS
        $('.add-stop').each(function () {
    
            let cityText  = $(this).find('.midpointCity option:selected').text();
            let stateText = $(this).find('.midpointState option:selected').text();
    
            if ($(this).find('.midpointCity').val()) {
                parts.push(cityText);
            } else if ($(this).find('.midpointState').val()) {
                parts.push(stateText);
            }
    
        });
    
        // DESTINATION
        let destinationCityText  = $('#destinationCity option:selected').text();
        let destinationStateText = $('#destinationState option:selected').text();
    
        if ($('#destinationCity').val()) {
            parts.push(destinationCityText);
        } else if ($('#destinationState').val()) {
            parts.push(destinationStateText);
        }
    
        // FINAL
        if (parts.length >= 2) {
            let routeName = parts.join(' - ');
            $('.route-name').val(routeName);
            $('.route-name-span').text(routeName);
        }
    }

    
    updateRouteName();
    
    // Trigger on all relevant selects
    $(document).on(
        'change select2:select',
        '#sourceCity, #destinationCity, .midpointCity',
        function () {
    
            validateRouteCities($(this));   
    
            updateRouteName();
        }
    );
    
    
    //==========================================================================
    
    // ===== AUTO LOAD SOURCE CITY ON EDIT =====
    let $sourceState = $('#sourceState');

    if ($sourceState.val()) {
        $sourceState.trigger('change');

        // Wait until AJAX completes and options are appended
        $(document).ajaxSuccess(function (event, xhr, settings) {
            let $sourceCity = $('#sourceCity');

            if (window.editSourceCityId && $sourceCity.find('option[value="' + window.editSourceCityId + '"]').length) {
                $sourceCity.val(window.editSourceCityId).trigger('change.select2');

                // Clear after setting once
                window.editSourceCityId = null;
            }
        });
    }
    
    // ===== AUTO LOAD DESTINATION CITY ON EDIT =====
    let $destinationState = $('#destinationState');
    if ($destinationState.val()) {
        $destinationState.trigger('change');

        // Wait until AJAX completes and options are appended
        $(document).ajaxSuccess(function (event, xhr, settings) {
            let $destinationCity = $('#destinationCity');

            if (window.editDestinationCityId && $destinationCity.find('option[value="' + window.editDestinationCityId + '"]').length) {
                $destinationCity.val(window.editDestinationCityId).trigger('change.select2');

                // Clear after setting once
                window.editDestinationCityId = null;
            }
        });
    }
    
    
    
    
    
    // Midpoint JS =============================================================
    
    function isDuplicateCombination(currentRow) {

        let currentState = currentRow.find('.midpointState').val();
        let currentCity  = currentRow.find('.midpointCity').val();
    
        if (!currentState || !currentCity) return false;
    
        let isDuplicate = false;
    
        $('.add-stop').each(function () {
    
            if ($(this)[0] === currentRow[0]) return; // skip current row
    
            let state = $(this).find('.midpointState').val();
            let city  = $(this).find('.midpointCity').val();
    
            if (state === currentState && city === currentCity) {
                isDuplicate = true;
                return false; // break loop
            }
        });
    
        return isDuplicate;
    }

    
    $(document).on('click', '.add-stop-btn', function () {

        let stateOptions = '<option value="">Choose..</option>';

        states.forEach(function (state) {
            stateOptions += `
                <option value="${state.id}">
                    ${state.name}
                </option>`;
        });

        let newRow = $(`
            <div class="add-stop mt-2">
                <div class="row align-items-center">

                    <div class="col-12 col-md-3">
                        <label class="mb-md-0">Midpoint</label>
                    </div>

                    <div class="col-12 col-md-3">
                        <select class="form-select select2 midpointState"
                            name="midpoint_state_id[]">
                            ${stateOptions}
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <select class="form-select select2-tags midpointCity"
                            name="midpoint_city_id[]">
                            <option value="">Choose..</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-1 text-center">
                        <i class="uil uil-trash-alt text-danger removeMidpoint"
                            style="cursor:pointer;"></i>
                    </div>

                </div>
            </div>
        `);

        $('.add-stop-container').append(newRow);

        // Initialize select2 properly for new row
        newRow.find('.select2').select2({
            width: '100%',
            dropdownParent: newRow
        });

        newRow.find('.select2-tags').select2({
            tags: true,
            width: '100%',
            dropdownParent: newRow
        });

    });
    
    $(document).on('click', '.removeMidpoint', function() {
        let container = $('.add-stop-container');
        let rows = container.find('.add-stop');
    
        let row = $(this).closest('.add-stop');
    
        // Destroy Select2 on this row's selects before removing
        row.find('select').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });
    
        if (rows.length > 1) {
            row.remove();
        } else {
            // Clear values if only one row left
            row.find('select').val('').trigger('change');
        }
        
        // Update route name after remove
        updateRouteName();
        
    });



    
    $(document).on('change', '.midpointState', function () {

        let $state = $(this);
        let $row = $state.closest('.add-stop');
        let $city = $row.find('.midpointCity');
    
        let stateId = $state.val();
    
        $city.html('<option value="">Loading...</option>').trigger('change');
    
        if (!stateId) {
            $city.html('<option value="">Choose..</option>').trigger('change');
            return;
        }
    
        // Build correct Laravel route
        let url = getCitiesUrlTemplate.replace(':id', stateId);
    
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
    
                let options = '<option value="">Choose..</option>';
    
                $.each(response, function (index, item) {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });
    
                $city.html(options).trigger('change');
            },
            error: function (xhr) {

                let message = 'Something went wrong.';
            
                if (xhr.responseJSON) {
            
                    if (xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors)[0][0];
                    } else if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
            
                } else if (xhr.responseText) {
                    message = xhr.responseText;
                }
            
                Toast.fire({
                    icon: 'error',
                    title: message
                });
            
                console.log("AJAX ERROR:", xhr.responseText);
            }
        });
    
    });
    
    
    $(document).on('change', '.midpointCity', function () {

        let row = $(this).closest('.add-stop');
    
        if (isDuplicateCombination(row)) {
    
            Toast.fire({
                        icon: 'error',
                        title: 'This Midpoint State + City combination already exists.'
                    });
    
            // Reset city selection
            $(this).val('').trigger('change');
    
        }
    
    });

    
    
    // Midpoint JS =============================================================
    
    
    
    
    
    //==========================================================================
    
    
    $(document).on('click','#editBtn',function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(e){
        var formData = new FormData(this);
        // Ensure hidden field is included
        formData.append('routeid', $('#edit_routeid_input').val());
        
        
        
        let combinations = [];
        let duplicateFound = false;
    
        $('.add-stop').each(function () {
    
            let state = $(this).find('.midpointState').val();
            let city  = $(this).find('.midpointCity').val();
    
            if (state && city) {
    
                let combo = state + '-' + city;
    
                if (combinations.includes(combo)) {
                    duplicateFound = true;
                    return false;
                }
    
                combinations.push(combo);
            }
        });
    
        if (duplicateFound) {
            e.preventDefault();
            Toast.fire({
                        icon: 'error',
                        title: 'Duplicate midpoint combinations are not allowed.'
                    });
        }
        
        
    
        $('.error').html('');
        $('#editBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        
        
    
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                Toast.fire({
                    icon: 'success',
                    title: response.message || 'Saved successfully!'
                });
                $('#editBtn').html('Save').attr('disabled', false);
                window.location.href = ROUTES;
            },
            
            error: function (xhr) {

                $('#editBtn').html('Save').attr('disabled', false);
            
                let response = {};
                try {
                    response = JSON.parse(xhr.responseText);
                } catch(e) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    });
                    return;
                }
            
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation errors.'
                });
            
                const errors = response.data || {};
            
                // Clear previous span errors
                $('.error').text('');
            
                $.each(errors, function(field, messages){
            
                    let msg = messages[0];
            
                    // ---------------- Tollstation validation ----------------
                    if(field === 'tollstation_id' || field.startsWith('tollstation_id.')){
                        $('.tollstation-error').text(msg);
                        return;
                    }
            
                    // ---------------- RTO validation ----------------
                    if(field === 'rto_id' || field.startsWith('rto_id.')){
                        $('.rto-error').text(msg);
                        return;
                    }
            
                    // ---------------- Midpoint validation ----------------
                    if(field.startsWith('midpoint_state_id')){
                        $('.midpoint_state_error').text(msg);
                        return;
                    }
            
                    if(field.startsWith('midpoint_city_id')){
                        $('.midpoint_city_error').text(msg);
                        return;
                    }
            
                    // ---------------- Normal fields ----------------
                    $('#edit_' + field + '_error').text(msg);
            
                });
            
            }
            
        });
    
        return false;
    });

    
    
    



    
    
    


});





