// $(document).ready(function(){
//     $('.add-person').click(function(){
//         $('.added-person').show();
//     })
    
//     document.getElementById('filebtn').addEventListener('click', () => {
//       document.getElementById('fileInput').click()
//     })
    
//     $('.close-sec').click(function(){
//         $('.added-person').hide();
//     })
    
//     $('.add-address').click(function(){
//         $('.added-sec').show();
//     })
    
//     $('.close-address').click(function(){
//         $('.added-sec').hide();
//     })
// });

// 

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

    // GST form autofill
    // $('#gstForm').submit(function(e){
    //     e.preventDefault();

    //     const gstNumber = $('#gstNumber').val().trim();

    //     if (gstNumber === "") {
    //         alert("Please enter GST number");
    //         return;
    //     }

    //     // Mock GST Data (replace with API response later)
    //     const gstData = {
    //         "27AAACT2727Q1ZW": {
    //             name: "Suman Das",
    //             addr1: "13th Floor, Arch Square X2,",
    //             addr2: "EP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091",
    //             city: "Kolkata",
    //             state: "West Bengal",
    //             pin: "700091"
    //         }
    //     };

    //     if (gstData[gstNumber]) {
    //         const data = gstData[gstNumber];
    //         $('#gstName').val(data.name);
    //         $('#gstAddr1').val(data.addr1);
    //         $('#gstAddr2').val(data.addr2);
    //         $('#gstCity').val(data.city);
    //         $('#gstState').val(data.state);
    //         $('#gstPin').val(data.pin);
    //     } else {
    //         alert("GST number not found. Please fill details manually.");
    //     }
    // });

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




