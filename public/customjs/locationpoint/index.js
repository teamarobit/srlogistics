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
    
    
    $('#search_location_type').data('select2').$container.find('.select2-selection__placeholder').text('Filter by Location Type');
    $('#search_contact_type').data('select2').$container.find('.select2-selection__placeholder').text('Filter by Contact Type');
    $('#search_city_id').data('select2').$container.find('.select2-selection__placeholder').text('Filter by City');
    
    
    $('#search_location, #search_location_type, #search_contact_type, #search_city_id').on('change blur', function () { 
        $('#searchform').submit();
    });
    
    
    
    
    
    
    
    
    
    
});







