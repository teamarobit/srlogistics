
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

    
    

    
    
});



document.addEventListener("DOMContentLoaded", function () {
    
    const yesRadio = document.getElementById("legalcase_yes");
    const noRadio = document.getElementById("legalcase_no");
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
    
    // new Choices('#multiSelect', {
    //     removeItemButton: true,
    // });
        
        
        
        

    /* =========================
     Provident Fund Toggle
     ========================= */
    document.querySelectorAll('input[name="providentFund"]').forEach((radio) => {
        radio.addEventListener("change", function () {
            const pfField = document.getElementById("pf_number_field");
            pfField.style.display = (this.value === "yes") ? "flex" : "none";
        });
    });

    
});




/* =========================
   Image Upload (jQuery)
   ========================= */
ImgUpload();

function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var filesArr = Array.prototype.slice.call(e.target.files);

      filesArr.forEach(function (f) {
        if (!f.type.match('image.*')) return;
        if (imgArray.length >= maxLength) return;

        imgArray.push(f);

        var reader = new FileReader();
        reader.onload = function (e) {
          var html =
            "<div class='upload__img-box'>" +
              "<div style='background-image: url(" + e.target.result + ")' " +
              "data-file='" + f.name + "' class='img-bg'>" +
                "<div class='upload__img-close'></div>" +
              "</div>" +
            "</div>";
          imgWrap.append(html);
        };
        reader.readAsDataURL(f);
      });
    });
  });

  $('body').on('click', '.upload__img-close', function () {
    var file = $(this).parent().data('file');
    imgArray = imgArray.filter(img => img.name !== file);
    $(this).closest('.upload__img-box').remove();
  });
}

$('#assettypeModal').on('shown.bs.modal', function () {
    $(this).find('.select2').select2({
        dropdownParent: $('#assettypeModal'),
        width: '100%'
    });
});









