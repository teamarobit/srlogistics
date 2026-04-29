/**
 * vehicle-details-tyre.js  v3.4
 * Tyre section interactions for Vehicle Details V2 page.
 *
 * SD-1  : All tyre JS lives here — no inline scripts in blade.
 * SD-7  : Toast mixin defined once at top.
 * SD-3  : No form submits in this file; interactions only.
 *
 * Responsibilities:
 *  - SVG tyre ↔ card hover highlight (bidirectional)
 *  - SVG tyre hover tooltip (serial, condition, km balance)
 *  - Click on eye icon in card header OR SVG tyre → open tyre history timeline modal
 *    Modal body: AJAX fetches vehicletyremappinglogs — timeline view with vehicle number,
 *    datetime, status, km info, notes, attachments per log entry.
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

/* ── In-flight AJAX request (abort on re-open) ────────────── */
var vtdLogsXhr = null;

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

/* ── CLICK — "View Details" / eye icon → open tyre detail modal ── */
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
   TYRE HISTORY TIMELINE MODAL — open (v3.0)
   Fetches vehicletyremappinglogs via AJAX.
   Renders a timeline with vehicle number, datetime, status,
   km info, notes, and attachments per log entry.
═══════════════════════════════════════════════════════════ */
function vtdOpenModalFromData(d) {
    /* Normalise boolean — blade outputs "1"/"0" strings */
    var hasTyre    = String(d['hasTyre'] || d['has-tyre'] || d.hasTyre) === '1';
    var label      = d.label       || d.pos || '—';
    var status     = d.status      || 'empty';
    var statusLbl  = vtdStatusLabels[status]  || status;
    var statusClr  = vtdStatusColors[status]  || '#dee2e6';
    var manageUrl  = d['manageUrl'] || d['manage-url'] || d.manageUrl || '#';
    var pos        = d.pos         || '';
    var condition  = d.condition   || '';
    var logsUrl    = d['logsUrl']   || d['logs-url']   || '';

    /* ── Header ─────────────────────────────────────────── */
    $('#vtdModalHeader').css('border-bottom', '3px solid ' + statusClr);
    $('#vtdModalPosDot').css('background', statusClr);
    $('#vtdTyreDetailModalLabel').text(label);
    $('#vtdModalSubtitle').html(
        condition
            ? '<span class="vtd-modal-status-chip vtd-chip-' + status + '">' + vtdEsc(condition) + '</span>'
            : ''
    );
    $('#vtdModalManageBtn').attr('href', manageUrl);

    /* Open modal immediately (spinner shows while AJAX loads) */
    var modalEl = document.getElementById('vtdTyreDetailModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    /* ── Body: no tyre assigned ─────────────────────────── */
    if (!hasTyre) {
        $('#vtdModalBody').html(
            '<div class="vtd-modal-empty">' +
            '<i class="uil uil-circle vtd-modal-empty-icon"></i>' +
            '<div>No tyre assigned to this position.</div>' +
            '<div class="vtd-modal-empty-sub">Use Manage Tyres to assign a tyre.</div>' +
            '</div>'
        );
        return;
    }

    /* ── No AJAX URL ────────────────────────────────────── */
    if (!logsUrl) {
        $('#vtdModalBody').html(
            '<div class="vtd-timeline-empty">' +
            '<i class="uil uil-history"></i>' +
            '<div>History not available for this tyre.</div>' +
            '</div>'
        );
        return;
    }

    /* ── Show loading spinner ────────────────────────────── */
    $('#vtdModalBody').html(
        '<div class="vtd-timeline-loading">' +
        '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>' +
        '<div>Loading tyre history…</div>' +
        '</div>'
    );

    /* Abort any in-flight request */
    if (vtdLogsXhr) {
        vtdLogsXhr.abort();
    }

    /* ── AJAX fetch logs ─────────────────────────────────── */
    vtdLogsXhr = $.ajax({
        url: logsUrl,
        method: 'GET',
        headers: { 'Accept': 'application/json' },
        success: function (res) {
            vtdLogsXhr = null;
            if (!res.success) {
                $('#vtdModalBody').html(vtdTimelineError('Server returned an error.'));
                return;
            }
            vtdRenderTimeline(res);
        },
        error: function (xhr) {
            vtdLogsXhr = null;
            if (xhr.statusText === 'abort') return;
            $('#vtdModalBody').html(vtdTimelineError('Failed to load tyre history. Please try again.'));
        }
    });
}

/* ─── Build timeline HTML from server response ─────────────
   res = { tyre_serial, tyre_brand, tyre_model,
           tyre_photos: [...], logs: [...] }
   Each log has: vehicle_no, created_at_formatted, fitment_date,
   km_at_fitment, removal_date, km_at_removal, status, notes,
   created_by_name, attachments[]
─────────────────────────────────────────────────────────── */
function vtdRenderTimeline(res) {
    var logs       = res.logs        || [];
    var tyrePhotos = res.tyre_photos || [];

    if (logs.length === 0 && tyrePhotos.length === 0) {
        $('#vtdModalBody').html(
            '<div class="vtd-timeline-empty">' +
            '<i class="uil uil-history"></i>' +
            '<div>No history logged for this tyre yet.</div>' +
            '<div style="font-size:11px;color:#adb5bd;margin-top:4px;">History is recorded when a tyre mapping is saved or updated.</div>' +
            '</div>'
        );
        return;
    }

    /* Merge tyre-level photos into the most recent log's attachments */
    if (tyrePhotos.length > 0 && logs.length > 0) {
        logs[0].attachments = (logs[0].attachments || []).concat(tyrePhotos);
    }

    var html = '';

    /* Optional tyre info strip */
    if (res.tyre_serial && res.tyre_serial !== '—') {
        html += '<div style="padding:10px 16px 4px;font-size:11px;color:#6c757d;border-bottom:1px solid #edf0f7;">' +
                '<i class="uil uil-circle me-1"></i>' +
                '<strong>' + vtdEsc(res.tyre_serial) + '</strong>' +
                (res.tyre_brand ? ' &nbsp;·&nbsp; ' + vtdEsc(res.tyre_brand) : '') +
                (res.tyre_model ? ' ' + vtdEsc(res.tyre_model) : '') +
                '</div>';
    }

    html += '<div class="vtd-timeline">';

    for (var i = 0; i < logs.length; i++) {
        var log       = logs[i];
        var attachId  = 'vtd-att-' + (log.id || i);   /* unique ID for toggle */
        var hasAtt    = log.attachments && log.attachments.length > 0;

        html += '<div class="vtd-tl-entry">';

        /* Dot (neutral — no status colouring) */
        html += '<div class="vtd-tl-dot dot-neutral">' +
                '<i class="uil uil-circle"></i>' +
                '</div>';

        /* Card */
        html += '<div class="vtd-tl-body">';

        /* Row 1: datetime · vehicle number · tyre position · attachment toggle */
        html += '<div class="vtd-tl-datetime">' +
                '<i class="uil uil-calendar-alt"></i>' +
                vtdEsc(log.created_at_formatted || '—');

        if (log.vehicle_no && log.vehicle_no !== '—') {
            html += ' &nbsp;<span class="vtd-tl-vehicle-no">' +
                    '<i class="uil uil-truck me-1"></i>' + vtdEsc(log.vehicle_no) +
                    '</span>';
        }

        if (log.tyre_position_code && log.tyre_position_code !== '—') {
            var posTitle = log.tyre_position_desc ? log.tyre_position_desc : log.tyre_position_code;
            html += ' &nbsp;<span class="vtd-tl-position-badge" title="' + vtdEsc(posTitle) + '">' +
                    vtdEsc(log.tyre_position_code) +
                    '</span>';
        }

        if (hasAtt) {
            html += ' &nbsp;<button type="button" class="vtd-tl-attach-toggle" ' +
                    'data-target="' + attachId + '" ' +
                    'title="' + log.attachments.length + ' attachment' + (log.attachments.length > 1 ? 's' : '') + '">' +
                    '<i class="uil uil-paperclip"></i>' +
                    '</button>';
        }

        html += '</div>'; /* .vtd-tl-datetime */

        /* Fields grid */
        var hasFields = log.fitment_date ||
                        (log.km_at_fitment !== null && log.km_at_fitment !== undefined && log.km_at_fitment !== '') ||
                        log.removal_date ||
                        (log.km_at_removal !== null && log.km_at_removal !== undefined && log.km_at_removal !== '');
        if (hasFields) {
            html += '<div class="vtd-tl-fields">';
            if (log.fitment_date) {
                html += '<div><div class="vtd-tl-field-label">Fitment Date</div>' +
                        '<div class="vtd-tl-field-val">' + vtdEsc(log.fitment_date) + '</div></div>';
            }
            if (log.km_at_fitment !== null && log.km_at_fitment !== undefined && log.km_at_fitment !== '') {
                html += '<div><div class="vtd-tl-field-label">KM at Fitment</div>' +
                        '<div class="vtd-tl-field-val">' + Number(log.km_at_fitment).toLocaleString() + ' KM</div></div>';
            }
            if (log.removal_date) {
                html += '<div><div class="vtd-tl-field-label">Removal Date</div>' +
                        '<div class="vtd-tl-field-val">' + vtdEsc(log.removal_date) + '</div></div>';
            }
            if (log.km_at_removal !== null && log.km_at_removal !== undefined && log.km_at_removal !== '') {
                html += '<div><div class="vtd-tl-field-label">KM at Removal</div>' +
                        '<div class="vtd-tl-field-val">' + Number(log.km_at_removal).toLocaleString() + ' KM</div></div>';
            }
            html += '</div>';
        }

        /* Notes */
        if (log.notes) {
            html += '<div class="vtd-tl-notes">' +
                    '<i class="uil uil-comment-alt-lines me-1"></i>' +
                    vtdEsc(log.notes) +
                    '</div>';
        }

        /* Attachments — hidden by default, toggled by the icon button */
        if (hasAtt) {
            html += '<div class="vtd-tl-attachments" id="' + attachId + '" style="display:none;">';
            html += '<div class="vtd-tl-attach-grid">';
            for (var j = 0; j < log.attachments.length; j++) {
                var att     = log.attachments[j];
                var isImage = att.type && att.type.toLowerCase() === 'image';
                html += '<div style="text-align:center;">';
                html += '<div class="vtd-tl-attach-item">';
                if (att.url && isImage) {
                    html += '<img src="' + vtdEsc(att.url) + '" ' +
                            'alt="' + vtdEsc(att.name || 'Attachment') + '" ' +
                            'class="vtd-tl-attach-img" ' +
                            'onerror="this.style.display=\'none\';this.parentNode.querySelector(\'.vtd-tl-attach-fallback\').style.display=\'flex\';" />';
                    html += '<div class="vtd-tl-attach-fallback" style="display:none;"><i class="uil uil-image-slash"></i></div>';
                } else {
                    html += '<div class="vtd-tl-attach-fallback"><i class="uil uil-file-alt"></i></div>';
                }
                html += '</div>';
                if (att.name) {
                    html += '<div class="vtd-tl-attach-name" title="' + vtdEsc(att.name) + '">' + vtdEsc(att.name) + '</div>';
                }
                html += '</div>';
            }
            html += '</div></div>';
        }

        html += '</div>'; /* .vtd-tl-body */
        html += '</div>'; /* .vtd-tl-entry */
    }

    html += '</div>'; /* .vtd-timeline */

    $('#vtdModalBody').html(html);
}

/* ─── Attachment toggle (delegated, works on dynamically rendered HTML) ── */
$(document).on('click', '.vtd-tl-attach-toggle', function () {
    var targetId = $(this).data('target');
    var $panel   = $('#' + targetId);
    $panel.slideToggle(180);
    $(this).toggleClass('active');
});

/* ─── Error state HTML ────────────────────────────────────── */
function vtdTimelineError(msg) {
    return '<div class="vtd-timeline-error">' +
           '<i class="uil uil-exclamation-triangle"></i>' +
           '<div>' + vtdEsc(msg) + '</div>' +
           '</div>';
}

/* ─── HTML escape helper (XSS safe) ──────────────────────── */
function vtdEsc(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

/* ═══════════════════════════════════════════════════════════
   TYRE IMAGE GALLERY — open and render
   (unchanged from v2.1 — still used by "View Images" footer link)
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
