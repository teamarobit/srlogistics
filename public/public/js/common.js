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
    
    
    $('.toggle-menu').click(function(){
        $('.collapse.navbar-collapse').addClass('mob-menu');
        $('.layout-wrapper').addClass('body-overlay'); 
    })
    
    $('.body-overlay').click(function(){
        $('.collapse.navbar-collapse').removeClass('mob-menu');
    })
    
    $('.close-nav').click(function(){
        $('.collapse.navbar-collapse').removeClass('mob-menu');
        $('.layout-wrapper').removeClass('body-overlay');
    })
    
    // $('.more-dd').hover(function(){
    //     $('.dropdown-menu').toggleClass('show');
    // })
    
    
    $('.select2').select2({
        placeholder: "Please Select"
    });
    
    

    
    // daterange picker
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        locale: {
          format: 'DD/MM/YYYY'
        }
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
      });
    });
    // --
    
    $('#addTrip').on('shown.bs.modal', function () {
        $('.select2-modal').select2({
            dropdownParent: $('#addTrip'),
            width: '100%'
        });
    });

    $('.add-stop-btn').click(function(){
        $('.add-stop').show();
    });
    
    $('.removeStop').click(function(){
        $('.add-stop').hide();
    });
    
    
    
    
    
    
    /*$(document).on('keydown', '.numericonly', function (e) {
        // Allow: backspace, delete, tab, escape, enter, and decimal point
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
    
        // Prevent non-numeric input
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
            (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
            Toast.fire({
                icon: 'warning',
                title: 'Only numbers allowed.'
            });
        }
    });*/
    

    $(document).on('input', '.numericonly', function () {
        let val = $(this).val();
    
        // Prevent multiple dots
        if ((val.match(/\./g) || []).length > 1) {
            $(this).val(val.substring(0, val.length - 1));
            return;
        }
    
        // Restrict to 6 decimal places
        if (val.includes('.')) {
            let [intPart, decPart] = val.split('.');
            if (decPart.length > 6) {
                $(this).val(intPart + '.' + decPart.substring(0, 6));
                Toast.fire({
                    icon: 'warning',
                    title: 'Only 6 decimal places allowed.'
                });
                return;
            }
        }
    
        // Restrict to maximum 9,999,999,999.999999
        let numVal = parseFloat(val);
        if (numVal > 9999999999.999999) {
            $(this).val('');
            Toast.fire({
                icon: 'warning',
                title: 'Maximum allowed is 9,999,999,999.999999'
            });
            return;
        }
    
        // Restrict total integer digits (avoid typing 15 digits before decimal)
        if (val.includes('.')) {
            let [intPart] = val.split('.');
            if (intPart.length > 10) {
                $(this).val(intPart.substring(0, 10));
                Toast.fire({
                    icon: 'warning',
                    title: 'Maximum 10 digits before decimal allowed.'
                });
            }
        } else if (val.length > 10) {
            $(this).val(val.substring(0, 10));
            Toast.fire({
                icon: 'warning',
                title: 'Maximum 10 digits before decimal allowed.'
            });
        }
    });







    
    $(document).on('keypress', '.decimalonly', function (eve) {
        if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
          eve.preventDefault();
            Toast.fire({
              icon: 'warning',
              title: 'Only decimal value allowed.'
            });
        }
        // this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
        $('.decimalonly').keyup(function(eve) {
            if($(this).val().indexOf('.') == 0) 
            {
              $(this).val($(this).val().substring(1));
            }
        });
    });
    
    
    // For Phone or WhatsApp
    $(document).on('input', '.numberonly', function () {

        const original = this.value;
        const numeric  = original.replace(/[^0-9]/g, '');
    
        if (original !== numeric) {
            Toast.fire({
                icon: 'warning',
                title: 'Only numeric value allowed.'
            });
        }
    
        this.value = numeric;
    });

    
    
    
    // Past date not allowed
    $(document).on('focus', '.common_date', function () { 
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var year = today.getFullYear();
        var todayDate = `${year}-${month}-${day}`;
        
        $(this).attr('min', todayDate);
    });
    
    
    // Future date not allowed
    $(document).on('focus', '.general_date', function () { 
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var year = today.getFullYear();
        var todayDate = `${year}-${month}-${day}`;
    
        $(this).attr('max', todayDate);
    });

    
    
});



