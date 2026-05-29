$(document).ready(function () {

    /* ── Toast mixin (SD-7) ────────────────────────────────────── */
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: function (toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    $('.select2-modal').select2({
        dropdownParent: $('#editTrip')
    });
    
    $('.if-debit').click(function(){
        $('.debit-wrap').show();
        $('.credit-wrap').hide();
    });
  
    $('.if-credit').click(function(){
        $('.debit-wrap').hide();
        $('.credit-wrap').show();
    })
    
    $('#daterange').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        startDate: moment(),
        locale: {
        format: 'DD/MM/YYYY'
        }
    });

    const input = document.querySelector("#telinput");
    window.intlTelInput(input, {
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.15.0/build/js/utils.js"),
    });

});