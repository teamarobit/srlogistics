
// start-js-form-field

$(document).ready(function () {

    // Image upload
    ImgUpload();

    // Initial visibility
    $(".motor_vehicle").show();
    $(".electronics").hide();

    // Radio change handler
    $(".status-radio").on("change", function () {
        if ($(this).val() === "motor") {
            $(".motor_vehicle").show();
            $(".electronics").hide();
        } else {
            $(".electronics").show();
            $(".motor_vehicle").hide();
        }
    });

});

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
            imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = $(this).attr('data-max_length');

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);

            filesArr.forEach(function (f) {

                if (!f.type.match('image.*')) return;

                if (imgArray.length >= maxLength) return;

                imgArray.push(f);

                var reader = new FileReader();
                reader.onload = function (e) {
                    var html = `
                        <div class="upload__img-box">
                            <div class="img-bg" 
                                 style="background-image:url(${e.target.result})"
                                 data-file="${f.name}">
                                <div class="upload__img-close"></div>
                            </div>
                        </div>`;
                    imgWrap.append(html);
                };
                reader.readAsDataURL(f);
            });
        });
    });

    $('body').on('click', '.upload__img-close', function () {
        var file = $(this).parent().data('file');

        imgArray = imgArray.filter(function (img) {
            return img.name !== file;
        });

        $(this).closest('.upload__img-box').remove();
    });
}


// 



