/**
 * vehicle-details-tyre.js  v2.1
 * Tyre section interactions for Vehicle Details V2 page.
 *
 * SD-1  : All tyre JS lives here — no inline scripts in blade.
 * SD-7  : Toast mixin defined once at top.
 * SD-3  : No form submits in this file; interactions only.
 *
 * Responsibilities:
 *  - SVG tyre ↔ card hover highlight (bidirectional)
 *  - SVG tyre hover tooltip (serial, condition, km balance)
 *  - Click on eye icon in card header OR SVG tyre → open tyre photo modal
 *    Modal body: tyre images with date + time (from VTD_TYRE_IMAGES)
 *  - Click on "View Images" footer link → open image gallery modal
 *    (images sourced from VTD_TYRE_IMAGES — blade-injected JSON)
 */

/* ── Toast mixin (SD-7) ─────────────────────────────────── */
const VtdToast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: function (toast) {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

/* ── Status colour map ───────────────────────────────────── */
var vtdStatusColors = {
    good:     '#10863f',
    warn:     '#d97706',
    critical: '#ea0027',
    empty:    '#dee2e6'
};

var vtdStatusLabels = {
    good:     'Good',
    warn:     'Attention',
    critical: 'Critical',
    empty:    'Not Assigned'
};

/* ── Gallery state ───────────────────────────────────────── */
var vtdGalleryImages  = [];   // current tyre's image array
var vtdGalleryIndex   = 0;    // active slide index

/* ═══════════════════════════════════════════════════════════
   HOVER — SVG tyre → highlight corresponding card
═══════════════════════════════════════════════════════════ */
$(document).on('mouseenter', '.vtd-svg-tyre', function () {
    var pos = $(this).data('pos');
    $('.vtd-tyre-card[data-pos="' + pos + '"]').addClass('highlighted');
    vtdShowSvgTooltip($(this));
}).on('mouseleave', '.vtd-svg-tyre', function () {
    var pos = $(this).data('pos');
    $('.vtd-tyre-card[data-pos="' + pos + '"]').removeClass('highlighted');
    vtdHideSvgTooltip();
});

/* ── HOVER — Card → highlight corresponding SVG tyre ─────── */
$(document).on('mouseenter', '.vtd-tyre-card', function () {
    var pos = $(this).data('pos');
    $('#svg-' + pos).addClass('highlighted');
}).on('mouseleave', '.vtd-tyre-card', function () {
    var pos = $(this).data('pos');
    $('#svg-' + pos).removeClass('highlighted');
});

/* ═══════════════════════════════════════════════════════════
   CLICK — SVG tyre → open tyre detail modal
═══════════════════════════════════════════════════════════ */
$(document).on('click', '.vtd-svg-tyre', function () {
    vtdHideSvgTooltip();
    vtdOpenModalFromData($(this).data());
});

/* ── CLICK — "View Details" link → open tyre detail modal ── */
$(document).on('click', '.vtd-open-modal', function (e) {
    e.preventDefault();
    var pos   = $(this).data('pos');
    var $card = $('.vtd-tyre-card[data-pos="' + pos + '"]');
    if ($card.length) {
        vtdOpenModalFromData($card.data());
    }
});

/* ── CLICK — "View Images" link → open gallery modal ────── */
$(document).on('click', '.vtd-open-gallery', function (e) {
    e.preventDefault();
    var pos   = $(this).data('pos');
    var $card = $('.vtd-tyre-card[data-pos="' + pos + '"]');
    var lbl   = $card.data('label') || pos;
    vtdOpenGallery(pos, lbl);
});

/* ── GALLERY — Prev / Next buttons ──────────────────────── */
$(document).on('click', '#vtdGalleryPrev', function () {
    if (vtdGalleryIndex > 0) {
        vtdGalleryIndex--;
        vtdRenderGallerySlide();
    }
});

$(document).on('click', '#vtdGalleryNext', function () {
    if (vtdGalleryIndex < vtdGalleryImages.length - 1) {
        vtdGalleryIndex++;
        vtdRenderGallerySlide();
    }
});

/* ── GALLERY — Thumbnail click ───────────────────────────── */
$(document).on('click', '.vtd-gallery-thumb', function () {
    vtdGalleryIndex = parseInt($(this).data('idx'), 10);
    vtdRenderGallerySlide();
});

/* ═══════════════════════════════════════════════════════════
   SVG TOOLTIP — appears near cursor on tyre hover
═══════════════════════════════════════════════════════════ */
function vtdShowSvgTooltip($tyre) {
    var hasTyre = $tyre.data('has-tyre') === '1' || $tyre.data('hasTyre') === '1' || String($tyre.data('has-tyre')) === '1';
    var label   = $tyre.data('label') || $tyre.data('pos');
    var $tip    = $('#vtdSvgTooltip');

    var html = '<div class="vtd-tip-label">' + label + '</div>';
    if (hasTyre) {
        var serial    = $tyre.data('serial')    || '—';
        var brand     = $tyre.data('brand')     || '';
        var model     = $tyre.data('model')     || '';
        var condition = $tyre.data('condition') || '—';
        var fitted    = $tyre.data('fitted')    || '—';
        var status    = $tyre.data('status')    || 'empty';
        var statusLbl = vtdStatusLabels[status] || status;
        var statusClr = vtdStatusColors[status] || '#dee2e6';
        var kmBal     = $tyre.data('kmbal')     || '';

        html += '<div class="vtd-tip-serial">' + serial + '</div>';
        if (brand || model) {
            html += '<div class="vtd-tip-brand">' + [brand, model].filter(Boolean).join(' · ') + '</div>';
        }
        html += '<div class="vtd-tip-row"><span class="vtd-tip-dot" style="background:' + statusClr + ';"></span>' + statusLbl + '</div>';
        if (kmBal !== '' && kmBal !== undefined) {
            var kmBalStr = parseInt(kmBal) <= 0 ? 'Overdue' : Number(kmBal).toLocaleString() + ' KM';
            html += '<div class="vtd-tip-fitted">KM Balance: ' + kmBalStr + '</div>';
        }
        if (fitted && fitted !== '—') {
            html += '<div class="vtd-tip-fitted">Fitted: ' + fitted + '</div>';
        }
    } else {
        html += '<div class="vtd-tip-empty">No tyre assigned</div>';
    }

    $tip.html(html).show();

    /* Track mouse within the SVG wrapper */
    $('#vtdTruckSvg').off('mousemove.vtd').on('mousemove.vtd', function (e) {
        var offset = 12;
        var tipW   = $tip.outerWidth();
        var winW   = $(window).width();
        var left   = e.pageX + offset;
        if (left + tipW > winW - 10) { left = e.pageX - tipW - offset; }
        $tip.css({ top: e.pageY - 30, left: left });
    });
}

function vtdHideSvgTooltip() {
    $('#vtdSvgTooltip').hide();
    $('#vtdTruckSvg').off('mousemove.vtd');
}

/* ═══════════════════════════════════════════════════════════
   TYRE PHOTO MODAL — build and open (v2.1)
   Modal body shows tyre images with date + time.
   Buttons retained: Manage Tyres + Close.
═══════════════════════════════════════════════════════════ */
function vtdOpenModalFromData(d) {
    /* Normalise boolean — blade outputs "1"/"0" strings */
    var hasTyre   = String(d['hasTyre'] || d['has-tyre'] || d.hasTyre) === '1';
    var label     = d.label     || d.pos || '—';
    var status    = d.status    || 'empty';
    var statusLbl = vtdStatusLabels[status] || status;
    var statusClr = vtdStatusColors[status] || '#dee2e6';
    var manageUrl = d['manageUrl'] || d['manage-url'] || d.manageUrl || '#';
    var pos       = d.pos || '';
    var condition       = d.condition || '';

    /* ── Header ─────────────────────────────────────────── */
    $('#vtdModalHeader').css('border-bottom', '3px solid ' + statusClr);
    $('#vtdModalPosDot').css('background', statusClr);
    $('#vtdTyreDetailModalLabel').text(label);
    $('#vtdModalSubtitle').html(
        '<span class="vtd-modal-status-chip vtd-chip-' + status + '">' + condition + '</span>'
    );
    $('#vtdModalManageBtn').attr('href', manageUrl);

    /* ── Body: tyre images ───────────────────────────────── */
    var bodyHtml = '';

    if (!hasTyre) {
        bodyHtml = '<div class="vtd-modal-empty">' +
                   '<i class="uil uil-circle vtd-modal-empty-icon"></i>' +
                   '<div>No tyre assigned to this position.</div>' +
                   '<div class="vtd-modal-empty-sub">Use Manage Tyres to assign a tyre.</div>' +
                   '</div>';
    } else {
        /* Pull images from blade-injected VTD_TYRE_IMAGES map */
        var images = (typeof VTD_TYRE_IMAGES !== 'undefined' && VTD_TYRE_IMAGES[pos])
                     ? VTD_TYRE_IMAGES[pos] : [];

        if (images.length === 0) {
            /* No photos uploaded */
            bodyHtml = '<div class="vtd-modal-empty">' +
                       '<i class="uil uil-image-slash vtd-modal-empty-icon"></i>' +
                       '<div>No photos uploaded for this tyre.</div>' +
                       '<div class="vtd-modal-empty-sub">Upload images via Manage Tyres.</div>' +
                       '</div>';
        } else {
            /* Image grid with date + time beneath each photo */
            bodyHtml += '<div class="vtd-photo-grid">';
            for (var i = 0; i < images.length; i++) {
                var img = images[i];
                bodyHtml += '<div class="vtd-photo-item">';
                bodyHtml +=   '<img src="' + img.url + '" ' +
                                   'alt="' + (img.name || 'Tyre Photo') + '" ' +
                                   'class="vtd-photo-img" ' +
                                   'onerror="this.onerror=null;this.parentNode.querySelector(\'.vtd-photo-err\').style.display=\'flex\';" />';
                bodyHtml +=   '<div class="vtd-photo-err" style="display:none;">' +
                               '<i class="uil uil-image-slash"></i>' +
                               '</div>';
                bodyHtml +=   '<div class="vtd-photo-meta">';
                if (img.date) {
                    bodyHtml += '<span class="vtd-photo-date"><i class="uil uil-calendar-alt me-1"></i>' + img.date + '</span>';
                }
                if (img.time) {
                    bodyHtml += '<span class="vtd-photo-time"><i class="uil uil-clock me-1"></i>' + img.time + '</span>';
                }
                bodyHtml +=   '</div>';
                bodyHtml += '</div>';
            }
            bodyHtml += '</div>';
        }
    }

    $('#vtdModalBody').html(bodyHtml);

    /* Open modal */
    var modalEl = document.getElementById('vtdTyreDetailModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

/* ═══════════════════════════════════════════════════════════
   TYRE IMAGE GALLERY — open and render
═══════════════════════════════════════════════════════════ */
function vtdOpenGallery(pos, label) {
    /* Resolve images from blade-injected VTD_TYRE_IMAGES map */
    var images = (typeof VTD_TYRE_IMAGES !== 'undefined' && VTD_TYRE_IMAGES[pos]) ? VTD_TYRE_IMAGES[pos] : [];

    vtdGalleryImages = images;
    vtdGalleryIndex  = 0;

    /* Set header */
    $('#vtdGalleryModalLabel').text('Tyre Photos — ' + label);
    $('#vtdGallerySubtitle').text(images.length + ' photo' + (images.length !== 1 ? 's' : '') + ' available');

    if (images.length === 0) {
        /* Empty state */
        $('#vtdGalleryBody').html(
            '<div class="vtd-gallery-empty">' +
            '<i class="uil uil-image-slash"></i>' +
            '<div>No photos uploaded for this tyre.</div>' +
            '</div>'
        );
        $('#vtdGalleryPrev, #vtdGalleryNext').prop('disabled', true);
        $('#vtdGalleryCounter').text('—');
    } else {
        vtdRenderGallerySlide();
    }

    /* Open the gallery modal (close detail modal if open) */
    var detailEl = document.getElementById('vtdTyreDetailModal');
    if (detailEl) {
        var detailModal = bootstrap.Modal.getInstance(detailEl);
        if (detailModal) { detailModal.hide(); }
    }

    var galleryEl = document.getElementById('vtdGalleryModal');
    if (galleryEl) {
        bootstrap.Modal.getOrCreateInstance(galleryEl).show();
    }
}

function vtdRenderGallerySlide() {
    var images = vtdGalleryImages;
    var idx    = vtdGalleryIndex;
    var img    = images[idx];

    if (!img) return;

    /* Main image + metadata */
    var mainHtml =
        '<div class="vtd-gallery-img-wrap">' +
            '<img src="' + img.url + '" alt="' + (img.name || 'Tyre Photo') + '" class="vtd-gallery-img" ' +
                 'onerror="this.onerror=null;this.src=\'\';" />' +
            '<div class="vtd-gallery-img-meta">' +
                '<strong>' + (img.name || 'Tyre Image') + '</strong>' +
                (img.date ? ' &nbsp;·&nbsp; <i class="uil uil-calendar-alt"></i> ' + img.date : '') +
            '</div>' +
        '</div>';

    /* Thumbnail strip (show only if >1 image) */
    if (images.length > 1) {
        mainHtml += '<div class="vtd-gallery-thumbs">';
        for (var i = 0; i < images.length; i++) {
            var activeClass = (i === idx) ? ' active' : '';
            mainHtml +=
                '<img src="' + images[i].url + '" ' +
                     'class="vtd-gallery-thumb' + activeClass + '" ' +
                     'data-idx="' + i + '" ' +
                     'title="' + (images[i].date || '') + '" ' +
                     'onerror="this.style.display=\'none\';" />';
        }
        mainHtml += '</div>';
    }

    $('#vtdGalleryBody').html(mainHtml);

    /* Nav buttons */
    $('#vtdGalleryPrev').prop('disabled', idx === 0);
    $('#vtdGalleryNext').prop('disabled', idx === images.length - 1);
    $('#vtdGalleryCounter').text((idx + 1) + ' / ' + images.length);
}
