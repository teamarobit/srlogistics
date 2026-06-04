// Tagged Assets — Photos viewer (static design demo)
$(function () {

    // Sample photo sets per asset (placeholder demo images)
    function samplePhotos(seed) {
        var base = 'https://picsum.photos/seed/';
        return [
            base + seed + 'a/600/400',
            base + seed + 'b/600/400',
            base + seed + 'c/600/400'
        ];
    }

    $(document).on('click', '#pills-tagged .ta-photos-btn', function () {
        var $row    = $(this).closest('tr');
        var asset   = $.trim($row.find('td:first .fw-semibold').text()) || 'Asset';
        var code    = $.trim($row.find('td:first small').text()) || '';
        var photos  = samplePhotos(asset.replace(/\s+/g, '').toLowerCase() || 'asset');

        var thumbs = photos.map(function (src, i) {
            return '<img src="' + src + '" class="ta-thumb' + (i === 0 ? ' active' : '') +
                   '" data-src="' + src + '" alt="photo ' + (i + 1) + '">';
        }).join('');

        Swal.fire({
            title: asset + (code ? ' (' + code + ')' : ''),
            html:
                '<div class="ta-gallery">' +
                    '<img src="' + photos[0] + '" class="ta-main" id="taMainPhoto" alt="' + asset + '">' +
                    '<div class="ta-thumbs">' + thumbs + '</div>' +
                '</div>',
            width: 560,
            showConfirmButton: false,
            showCloseButton: true,
            didOpen: function () {
                $('.ta-gallery').on('click', '.ta-thumb', function () {
                    $('.ta-gallery .ta-thumb').removeClass('active');
                    $(this).addClass('active');
                    $('#taMainPhoto').attr('src', $(this).data('src'));
                });
            }
        });
    });

});
