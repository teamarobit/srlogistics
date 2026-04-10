$(document).ready(function() {
      $(".changedriver_bd").hide();
      $(".open_01driver").on("click", function() {
        $(".changedriver_bd").slideToggle(300); 
        $(this).toggleClass("active");   
      });
      
      
      
      $(function() {
      $('input[name="datetime"]').daterangepicker({
        singleDatePicker: true,   
        timePicker: true,         
        startDate: moment(),      
        locale: {
          format: 'MM/DD/YYYY hh:mm A' 
        }
      });
    });
    
    
    
    $(function() {
      $('input[name="datet01"]').daterangepicker({
        singleDatePicker: true,   
        timePicker: false,        
        locale: {
          format: 'MM/DD/YYYY',   
        }
      });
    });
      
      
    $(function() {
      $('input[name="maintenance-date"]').daterangepicker({
        singleDatePicker: true,   
        timePicker: false,        
        locale: {
          format: 'MM/DD/YYYY',   
        }
      });
    });
    
    
    
    const noteInput = document.getElementById('noteInput');
      noteInput.addEventListener('input', function () {
        this.style.height = 'auto'; // reset height
        this.style.height = (this.scrollHeight) + 'px'; // set new height
      });
    
    
    $('.modal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });
        
        
        
    $('.add-stop-btn').click(function(){
            $('.add-stop').show();
        });
        
        $('.removeStop').click(function(){
            $('.add-stop').hide();
        });
        
        
        
     document.querySelectorAll('input[name="providentFund"]').forEach((radio) => {
    radio.addEventListener("change", function () {
      const pfField = document.getElementById("pf_number_field");
      if (this.value === "yes") {
        pfField.style.display = "flex"; // show
      } else {
        pfField.style.display = "none"; // hide
      }
    });
  });
  
   // image upload
    ImgUpload();
    // --
  
  function ImgUpload() {
      var imgWrap = "";
      var imgArray = [];
    
      $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
          imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
          var maxLength = $(this).attr('data-max_length');
    
          var files = e.target.files;
          var filesArr = Array.prototype.slice.call(files);
          var iterator = 0;
          filesArr.forEach(function (f, index) {
    
            if (!f.type.match('image.*')) {
              return;
            }
    
            if (imgArray.length > maxLength) {
              return false
            } else {
              var len = 0;
              for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i] !== undefined) {
                  len++;
                }
              }
              if (len > maxLength) {
                return false;
              } else {
                imgArray.push(f);
    
                var reader = new FileReader();
                reader.onload = function (e) {
                  var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                  imgWrap.append(html);
                  iterator++;
                }
                reader.readAsDataURL(f);
              }
            }
          });
        });
      });
    
      $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
          if (imgArray[i].name === file) {
            imgArray.splice(i, 1);
            break;
          }
        }
        $(this).parent().parent().remove();
      });
    }
    
    
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });
    
    $('.if-main').click(function(){
        $('.maintanance-wrap').show();
        $('.repair-wrap').hide();
    })
    $('.if-rep').click(function(){
        $('.maintanance-wrap').hide();
        $('.repair-wrap').show();
    })
    
    
    
    
    
    
      
      
});