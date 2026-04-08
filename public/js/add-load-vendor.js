$(document).ready(function(){

    // Person add/remove
    $('.add-person').click(function(){
        $('.added-person').show();
    });

    $('#filebtn').click(function(){
        $('#fileInput').click();
    });

    $('.close-sec').click(function(){
        $('.added-person').hide();
    });

    // Address add/remove
    $('.add-address').click(function(){
        $('.added-sec').show();
    });

    $('.close-address').click(function(){
        $('.added-sec').hide();
    });
  
    $('.status-trigger').on('change', function () {
    $('.statusblacklist').toggle(this.id === 'blacklist');
    });


    // Checkbox add/remove class
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });

    // GST form autofill
    $('#gstForm').submit(function(e){
        e.preventDefault();

        const gstNumber = $('#gstNumber').val().trim();

        if (gstNumber === "") {
            alert("Please enter GST number");
            return;
        }

        // Mock GST Data (replace with API response later)
        const gstData = {
            "27AAACT2727Q1ZW": {
                name: "Suman Das",
                addr1: "13th Floor, Arch Square X2,",
                addr2: "EP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091",
                city: "Kolkata",
                state: "West Bengal",
                pin: "700091"
            }
        };

        if (gstData[gstNumber]) {
            const data = gstData[gstNumber];
            $('#gstName').val(data.name);
            $('#gstAddr1').val(data.addr1);
            $('#gstAddr2').val(data.addr2);
            $('#gstCity').val(data.city);
            $('#gstState').val(data.state);
            $('#gstPin').val(data.pin);
        } else {
            alert("GST number not found. Please fill details manually.");
        }
    });

});

// tel-input-start
  const phoneInputs = document.querySelectorAll("#phone, #phone2, #phone3");

  phoneInputs.forEach(input => {
    window.intlTelInput(input, {
      //initialCountry: "in", // default (in, bd, us)
      //onlyCountries: ["in"],
      utilsScript:
        "https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.2/build/js/utils.js"
    });
  });
  
// tel-input-End

// Select2 inside Bootstrap Modal (dropdown fix)
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('.select2').select2({
            dropdownParent: $(this)
        });
    });

  
