$(document).ready(function(){
    // image upload
    ImgUpload();
    // --
    
    $('.add-person').click(function(){
        $('.added-person').show();
    })
    
    $('.close-sec').click(function(){
        $('.added-person').hide();
    })
    
    $('.add-address').click(function(){
        $('.added-sec').show();
    })
    
    $('.close-address').click(function(){
        $('.added-sec').hide();
    })
    
    // dropzone
    Dropzone.autoDiscover = false;
    
    if (Dropzone.instances.length === 0) {
        let dropzone =  Dropzone('#demo-upload', {
        //   previewTemplate: document.querySelector('#preview-template').innerHTML,
          parallelUploads: 2,
          thumbnailHeight: 120,
          thumbnailWidth: 120,
          maxFilesize: 3,
          filesizeBase: 1000,
          thumbnail: function(file, dataUrl) {
            if (file.previewElement) {
              file.previewElement.classList.remove("dz-file-preview");
              var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
              for (var i = 0; i < images.length; i++) {
                var thumbnailElement = images[i];
                thumbnailElement.alt = file.name;
                thumbnailElement.src = dataUrl;
              }
              setTimeout(function() { file.previewElement.classList.add("dz-image-preview"); }, 1);
            }
          }
        
        });
    }
    
    
    // Now fake the file upload, since GitHub does not handle file uploads
    // and returns a 404
    
    // var minSteps = 6,
    //     maxSteps = 60,
    //     timeBetweenSteps = 100,
    //     bytesPerStep = 100000;
    
    // dropzone.uploadFiles = function(files) {
    //   var self = this;
    
    //   for (var i = 0; i < files.length; i++) {
    
    //     var file = files[i];
    //     totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));
    
    //     for (var step = 0; step < totalSteps; step++) {
    //       var duration = timeBetweenSteps * (step + 1);
    //       setTimeout(function(file, totalSteps, step) {
    //         return function() {
    //           file.upload = {
    //             progress: 100 * (step + 1) / totalSteps,
    //             total: file.size,
    //             bytesSent: (step + 1) * file.size / totalSteps
    //           };
    
    //           self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
    //           if (file.upload.progress == 100) {
    //             file.status = Dropzone.SUCCESS;
    //             self.emit("success", file, 'success', null);
    //             self.emit("complete", file);
    //             self.processQueue();
    //             //document.getElementsByClassName("dz-success-mark").style.opacity = "1";
    //           }
    //         };
    //       }(file, totalSteps, step), duration);
    //     }
    //   }
    // }
    // ---
})

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



