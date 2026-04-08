$(document).ready(function(){
    $('.add-stop-btn').click(function(){
        $('.add-stop').show();
    });
    
    $('.removeStop').click(function(){
        $('.add-stop').hide();
    });
    
    $('.sug-veh').click(function(){
        $('.if-suggested').show();
        $('.if-new').hide();
    });
    $('.new-veh').click(function(){
        $('.if-suggested').hide();
        $('.if-new').show();
    });
    
    $('.own-veh').click(function(){
        $('.if-own').show();
        $('.if-external').hide();
    });
    $('.external-veh').click(function(){
        $('.if-own').hide();
        $('.if-external').show();
    });
    
    $(document).ready(function() {
      if (window.File && window.FileList && window.FileReader) {
        $("#files").on("change", function(e) {
          var files = e.target.files,
            filesLength = files.length;
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
              var file = e.target;
              $("<span class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<div class=\"file-name-wrap\"><p>Test.pdf</p><small>15MB.</small></div>" +
                "<span class=\"remove\"><i class=\"uil uil-trash-alt\"></i></span>" +
                "</span>").insertAfter("#files");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
              
              // Old code here
              /*$("<img></img>", {
                class: "imageThumb",
                src: e.target.result,
                title: file.name + " | Click to remove"
              }).insertAfter("#files").click(function(){$(this).remove();});*/
              
            });
            fileReader.readAsDataURL(f);
          }
          console.log(files);
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });
    
    $('.attachment-click').click(function(){ 
        $('.right-overlay.attachment-popup').addClass('show');
    })
    $('.close-overlay').click(function(){
        $('.right-overlay.attachment-popup').removeClass('show');
    })
    
    $('.vehicle-allocation .form-check .vehicle-card').click(function(){
        $('.right-overlay.map-popup').addClass('show');
    })
    $('.close-overlay.close-map').click(function(){
        $('.right-overlay.map-popup').removeClass('show');
    })
    
    $('.bill-click').click(function(){ 
        $('.right-overlay.bill-popup').addClass('show');
    })
    $('.close-overlay').click(function(){
        $('.right-overlay.bill-popup').removeClass('show');
    })
    
    $('#Select2-modal').select2({
        dropdownParent: $('#assignModal') // Use the ID of the parent container
    });

})