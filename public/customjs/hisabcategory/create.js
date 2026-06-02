$(document).ready(function(){
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

    $('.if-opt1 input').click(function(){
        $('.opt1-wrap').show();
        $('.opt2-wrap').hide();
        $('.opt3-wrap').hide();
    })
    $('.if-opt2 input').click(function(){
        $('.opt2-wrap').show();
        $('.opt1-wrap').hide();
        $('.opt3-wrap').hide();
    })
    $('.if-opt3 input').click(function(){
        $('.opt2-wrap').hide();
        $('.opt1-wrap').hide();
        $('.opt3-wrap').show();
    })
    
    $('.if-driver input').click(function(){
        $('.srl-text').hide();
        $('.driver-wrap').show();
    })
    $('.if-srl input').click(function(){
        $('.driver-wrap').hide();
        $('.srl-text').show();
    })
    
    $('.if-cap-yes input').click(function(){
        $('.cap-yes-wrap').show();
        $('.cap-no-text').hide();
    })
    $('.if-cap-no input').click(function(){
        $('.cap-yes-wrap').hide();
        $('.cap-no-text').show();
    })
    
    // loading
    $('.if-loading-driver input').click(function(){
        $('.loading-srl-text').hide();
        $('.loading-driver-wrap').show();
    })
    $('.if-loading-srl input').click(function(){
        $('.loading-driver-wrap').hide();
        $('.loading-srl-text').show();
    })
    
    $('.if-loading-cap-yes input').click(function(){
        $('.loading-cap-yes-wrap').show();
        $('.loading-cap-no-text').hide();
    })
    $('.if-loading-cap-no input').click(function(){
        $('.loading-cap-yes-wrap').hide();
        $('.loading-cap-no-text').show();
    })
    // ..
    
    // unloading
    $('.if-unloading-driver input').click(function(){
        $('.unloading-srl-text').hide();
        $('.unloading-driver-wrap').show();
    })
    $('.if-unloading-srl input').click(function(){
        $('.unloading-driver-wrap').hide();
        $('.unloading-srl-text').show();
    })
    
    $('.if-unloading-cap-yes input').click(function(){
        $('.unloading-cap-yes-wrap').show();
        $('.unloading-cap-no-text').hide();
    })
    $('.if-unloading-cap-no input').click(function(){
        $('.unloading-cap-yes-wrap').hide();
        $('.unloading-cap-no-text').show();
    })
    // ..
    
    $('.if-applicable input').click(function(){
        $('.applicable-wrap').show();
    })
    $('.if-NA input').click(function(){
        $('.applicable-wrap').hide();
    })
})