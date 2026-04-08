
// 
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

    // Checkbox add/remove class
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });
    
    
    // work type
    $(".office-work input[type=checkbox]").click(function () {
        if ($(this).is(':checked')) {
            $('.office-work-wrap').show();
        } else {
            $('.office-work-wrap').hide();
        }
    });
    
    $(".service-center input[type=checkbox]").click(function () {
        if ($(this).is(':checked')) {
            $('.service-center-wrap').show();
        } else {
            $('.service-center-wrap').hide();
        }
    });
});

// 
// dropzone

    Dropzone.autoDiscover = false;

    function initDropzone(el) {
      return new Dropzone(el, {
        url: "/upload",
        addRemoveLinks: true,
        dictRemoveFile: "✖",
        maxFiles: 2,
        acceptedFiles: "image/*",
        parallelUploads: 2,
        uploadMultiple: false
      });
    }

    // Show Add New only on last row
    function updateButtons() {
      $(".item-row").each(function (index) {
        if (index === $(".item-row").length - 1) {
          $(this).find(".add-item").show();   // last row → show Add New
        } else {
          $(this).find(".add-item").hide();   // others → hide Add New
        }
      });
    }

    $(document).ready(function () {
      // Init first dropzone
      initDropzone("#demo-upload-1");
      updateButtons();

      // Add New Row
      $(document).on("click", ".add-item", function () {
        var newItem = $(".item-row").first().clone();

        // Reset values
        newItem.find("select").val("Select ID");
        newItem.find("input, textarea").val("");
        newItem.find(".dz-preview").remove();

        // Unique Dropzone ID
        var newId = "demo-upload-" + ($(".item-row").length + 1);
        newItem.find(".dropzone").attr("id", newId);

        // Insert after current row
        $(this).closest(".item-row").after(newItem);

        // Init Dropzone for new row
        initDropzone("#" + newId);

        // Update button visibility
        updateButtons();
      });

      // Remove Row
      $(document).on("click", ".remove-item", function () {
        if ($(".item-row").length > 1) {
          $(this).closest(".item-row").remove();
          updateButtons();
        } else {
          alert("At least one document upload section is required.");
        }
      });
    });

// dropzone

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

// $(document).ready(function() {
//     $('#change-vehicle').on('change', function() {
//         if ($(this).is(':checked')) {
//             $('.reason_wrap').show(); 
//         } else {
//             $('.reason_wrap').hide();
//         }
//     });
// });

// $(document).ready(function() {
//     // Targeting by class ".status-trigger" instead of name
//     $('.status-trigger').change(function() {
//         var selectedValue = $(this).val();

//         $('.status_wrap').show();

//         $('.status-content').hide();
        
//         $('.status' + selectedValue).show();
//     });
// });

// $(document).ready(function () {
    
//     $('.onleave_wrap, .voluntary_wrap').hide();

//     $('input[name="voluntaryexe"]').on('change', function () {

//         if (this.value === 'on1leave') {
//             $('.onleave_wrap').show();
//             $('.voluntary_wrap').hide();
//         } 
//         else if (this.value === 'voluntary2exit') {
//             $('.voluntary_wrap').show();
//             $('.onleave_wrap').hide();
//         }
//     });
// });

// // 
// $(document).ready(function () {
//   var today = moment();
//   $('#daterange').daterangepicker({
//     startDate: today,
//     endDate: today,
//     opens: 'left'
//   }, function (start, end) {
//     console.log(
//       "A new date selection was made: " +
//       start.format('YYYY-MM-DD') +
//       ' to ' +
//       end.format('YYYY-MM-DD')
//     );
//   });
// });
// // 

// // 

// $(document).ready(function() {
//     // Click event for Add button
//     $(".btn_addexp").click(function(e) {
//         e.preventDefault();

//         var $clone = $(".item_experience").first().clone();

//         $clone.find("input").val("");

//         $clone.find(".remove_exp").show();

//         $("#experience_container").append($clone);
//     });

//     $(document).on("click", ".remove_exp", function(e) {
//         e.preventDefault();
        
//         $(this).closest(".item_experience").remove();
//     });
// });

// 

$(document).ready(function() {

    // 1. Vehicle Change Toggle
    $('#change-vehicle').on('change', function() {
        $('.reason_wrap').toggle($(this).is(':checked'));
    });

    // 2. Status Trigger Selection
    $('.status-trigger').on('change', function() {
        var selectedValue = $(this).val();
        $('.status_wrap').show();
        $('.status-content').hide();
        $('.status' + selectedValue).show();
    });

    // 3. Leave vs Exit Radio Toggle
    $('.onleave_wrap, .voluntary_wrap').hide();
    $('input[name="voluntaryexe"]').on('change', function() {
        if (this.value === 'on1leave') {
            $('.onleave_wrap').show();
            $('.voluntary_wrap').hide();
        } else if (this.value === 'voluntary2exit') {
            $('.voluntary_wrap').show();
            $('.onleave_wrap').hide();
        }
    });

    // 4. Date Range Picker Initialization
    var today = moment();
    $('#daterange').daterangepicker({
        startDate: today,
        endDate: today,
        opens: 'left'
    }, function(start, end) {
        console.log("New selection: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD'));
    });

    // 5. Dynamic Experience Fields (Add/Remove)
    // $(".btn_addexp").click(function(e) {
    //     e.preventDefault();
    //     var $clone = $(".item_experience").first().clone();
    //     $clone.find("input").val("");
    //     $clone.find(".remove_exp").show();
    //     $("#experience_container").append($clone);
    // });
    
    $(".btn_addexp").click(function(e) {
    e.preventDefault();
        var $clone = $(".item_experience").first().clone();
        $clone.css("display", "block").attr("style", "display: block !important");
        $clone.find("input").val("");
        $clone.find(".remove_exp").show();
        $("#experience_container").append($clone);
    });



    $(document).on("click", ".remove_exp", function(e) {
        e.preventDefault();
        $(this).closest(".item_experience").remove();
    });

});

document.addEventListener("DOMContentLoaded", function () {
    
    const yesRadio = document.getElementById("exampleRadios1");
    const noRadio = document.getElementById("exampleRadios2");
    const caseBox = document.querySelector(".opencase_01desc");

    yesRadio.addEventListener("change", function () {
        if (this.checked) {
            caseBox.style.display = "block";
        }
    });

    noRadio.addEventListener("change", function () {
        if (this.checked) {
            caseBox.style.display = "none";
        }
    });
});

// 

// 
$('#experience01_btn').on('shown.bs.modal', function () {
  $(this).find('.select2').select2({
    dropdownParent: $('#experience01_btn'),
    width: '100%'
  });
});
// 



