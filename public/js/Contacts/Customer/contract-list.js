$(document).ready(function(){
    
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
    
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    
    $('#search_customer').data('select2').$container.find('.select2-selection__placeholder').text('Filter by Customer');
    $('#search_contractno').data('select2').$container.find('.select2-selection__placeholder').text('Filter by Contract No');
    
    
    $(function () {

        $('#start_daterange, #end_daterange').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD-MM-YYYY'
            }
        });
    
        // Apply → set value + submit form
        $('#start_daterange, #end_daterange').on('apply.daterangepicker', function(ev, picker) {
    
            $(this).val(
                picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY')
            );
    
            // submit immediately after selecting range
            $('#searchform').submit();
        });
    
        // Clear → reset + submit
        $('#start_daterange, #end_daterange').on('cancel.daterangepicker', function() {
            $(this).val('');
            $('#searchform').submit();
        });
    
    });
    
    
    $('#search_customer, #search_contractno').on('change blur', function() { 
        $('#searchform').submit();
    });
    
    
    
    
    
});






