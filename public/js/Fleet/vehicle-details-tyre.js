/**
 * vehicle-details-tyre.js  v2.0
 * Tyre section interactions for Vehicle Details V2 page.
 *
 * SD-1  : All tyre JS lives here — no inline scripts in blade.
 * SD-7  : Toast mixin defined once at top.
 * SD-3  : No form submits in this file; interactions only.
 *
 * Responsibilities:
 *  - SVG tyre ↔ card hover highlight (bidirectional)
 *  - SVG tyre hover tooltip (serial, condition, km balance)
 *  - Click on SVG tyre OR "View Details" → open tyre detail modal
 *  - Click on "View Images" → open image gallery modal
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
   TYRE DETAIL MODAL — build and open (updated v2.0)
═══════════════════════════════════════════════════════════ */
function vtdOpenModalFromData(d) {
    /* Normalise boolean — blade outputs "1"/"0" strings */
    var hasTyre    = String(d['hasTyre'] || d['has-tyre'] || d.hasTyre) === '1';
    var label      = d.label      || d.pos || '—';
    var status     = d.status     || 'empty';
    var statusLbl  = vtdStatusLabels[status] || status;
    var statusClr  = vtdStatusColors[status] || '#dee2e6';
    var manageUrl  = d['manageUrl'] || d['manage-url'] || d.manageUrl || '#';

    /* Header */
    $('#vtdModalHeader').css('border-bottom', '3px solid ' + statusClr);
    $('#vtdModalPosDot').css('background', statusClr);
    $('#vtdTyreDetailModalLabel').text(label);
    $('#vtdModalSubtitle').html(
        '<span class="vtd-modal-status-chip vtd-chip-' + status + '">' + statusLbl + '</span>'
    );
    $('#vtdModalManageBtn').attr('href', manageUrl);

    /* Body */
    var bodyHtml = '';
    if (hasTyre) {
        var serial         = d.serial         || '—';
        var brand          = d.brand          || '—';
        var model          = d.model          || '—';
        var condition      = d.condition      || '—';
        var type           = d.type           || '—';
        var fitted         = d.fitted         || '—';
        var kmLife         = parseInt(d.kmlife  || d['km-life']  || 0);
        var kmRun          = parseInt(d.kmrun   || d['km-run']   || 0);
        var kmBal          = parseInt(d.kmbal   || d['km-bal']   || 0);
        var remLifePct     = d.remlifepct     !== '' && d.remlifepct !== undefined ? parseInt(d.remlifepct) : null;
        var warrantyRem    = d.warrantyremaining !== '' && d.warrantyremaining !== undefined ? parseInt(d.warrantyremaining) : null;
        var hasKm          = kmLife > 0;
        var kmBalStr       = hasKm ? (kmBal <= 0 ? 'Overdue' : Number(kmBal).toLocaleString() + ' KM') : '—';
        var kmBarClr       = kmBal <= 0 ? '#ea0027' : (kmBal <= 10000 ? '#d97706' : '#10863f');
        var pos            = d.pos || '';
        var imgCount       = parseInt(d.imgcount || 0);

        bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Position</span><span class="vtd-modal-val">' + label + '</span></div>';
        bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Serial No.</span><span class="vtd-modal-val vtd-modal-mono">' + serial + '</span></div>';
        bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Condition</span><span class="vtd-modal-val">' + condition + '</span></div>';
        bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Type</span><span class="vtd-modal-val">' + (type !== '—' ? '<span style="background:#e8f0ff;color:#032671;font-size:10px;font-weight:700;border-radius:3px;padding:1px 6px;">' + type + '</span>' : '—') + '</span></div>';
        bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Brand</span><span class="vtd-modal-val">' + brand + '</span></div>';
        bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Model</span><span class="vtd-modal-val">' + model + '</span></div>';
        bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Fitted On</span><span class="vtd-modal-val">' + fitted + '</span></div>';

        if (hasKm) {
            bodyHtml += '<div class="vtd-modal-divider"></div>';
            /* Remaining Life progress bar */
            if (remLifePct !== null) {
                var lifeFill = Math.min(100, Math.max(0, remLifePct));
                bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Rem. Life</span><span class="vtd-modal-val" style="color:' + kmBarClr + ';font-weight:700;">' + remLifePct + '%</span></div>';
                bodyHtml += '<div class="vtd-modal-progress-wrap">';
                bodyHtml +=   '<div class="vtd-modal-progress-track">';
                bodyHtml +=     '<div class="vtd-modal-progress-fill" style="width:' + lifeFill + '%;background:' + kmBarClr + ';"></div>';
                bodyHtml +=   '</div>';
                bodyHtml +=   '<div class="vtd-modal-progress-lbl">' + (100 - lifeFill) + '% used</div>';
                bodyHtml += '</div>';
            }
            bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">KM Life</span><span class="vtd-modal-val">' + Number(kmLife).toLocaleString() + ' KM</span></div>';
            bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Actual KM Run</span><span class="vtd-modal-val">' + Number(kmRun).toLocaleString() + ' KM</span></div>';
            bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Rem. Run</span><span class="vtd-modal-val" style="color:' + kmBarClr + ';font-weight:700;">' + kmBalStr + '</span></div>';
            bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">KM Balance</span><span class="vtd-modal-val" style="color:' + kmBarClr + ';font-weight:700;">' + kmBalStr + '</span></div>';
        }

        /* Warranty */
        if (warrantyRem !== null) {
            var wClr = warrantyRem === 0 ? '#ea0027' : (warrantyRem <= 3 ? '#d97706' : '#10863f');
            var wStr = warrantyRem === 0 ? 'Expired' : warrantyRem + ' month(s) remaining';
            bodyHtml += '<div class="vtd-modal-divider"></div>';
            bodyHtml += '<div class="vtd-modal-row"><span class="vtd-modal-lbl">Warranty</span><span class="vtd-modal-val" style="color:' + wClr + ';font-weight:700;">' + wStr + '</span></div>';
        }

        /* Photo count shortcut */
        if (imgCount > 0) {
            bodyHtml += '<div class="vtd-modal-divider"></div>';
            bodyHtml += '<div style="text-align:center;padding:6px 0;">';
            bodyHtml += '<a href="#" class="vtd-open-gallery" data-pos="' + pos + '" style="font-size:12px;font-weight:700;color:#032671;text-decoration:none;">';
            bodyHtml += '<i class="uil uil-image me-1"></i>View ' + imgCount + ' Photo' + (imgCount > 1 ? 's' : '') + '</a>';
            bodyHtml += '</div>';
        }

    } else {
        bodyHtml = '<div class="vtd-modal-empty"><i class="uil uil-circle vtd-modal-empty-icon"></i><div>No tyre assigned to this position.</div><div class="vtd-modal-empty-sub">Use Manage Tyres to assign a tyre.</div></div>';
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
