/* ═══════════════════════════════════════════════════════════════════════════
   SR Logistics — Tyre Tagging JS  |  vehicletyretagging.js  v2.0
   Handles: SVG load → RAG coloring → card sync (click / hover)
            Add Tyre modal binding, spare slot toggle
   ═══════════════════════════════════════════════════════════════════════════ */

const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

$(document).ready(function () {

    // ── 1. LOAD & COLOR SVG ──────────────────────────────────────────────────
    const svgMap = { 6: sixWheelTruckPath, 10: tenWheelTruckPath };
    const tyreCount = parseInt($('#type').val(), 10) || 6;
    const svgPath = svgMap[tyreCount] || svgMap[6];

    if (svgPath) {
        $.get(svgPath, function (svgData) {
            $('#container-img').html(svgData);
            applyRagColors();
            showMountedCards(tyreCount);
        }, 'text').fail(function () {
            $('#container-img').html('<p class="text-muted text-center small mt-3">SVG not available</p>');
        });
    }

    /**
     * Color each .tyre-group in the SVG according to tyreRagData{}
     * (injected inline by the blade template).
     */
    function applyRagColors() {
        if (typeof tyreRagData === 'undefined') return;

        $('#container-img .tyre-group').each(function () {
            const code = $(this).data('code');
            const rag  = tyreRagData[code] || 'grey';

            // Remove any existing RAG class then add the correct one
            $(this).removeClass('rag-green rag-amber rag-red rag-grey rag-untagged')
                   .addClass('rag-' + rag);
        });
    }

    /**
     * Show only the cards that belong to mounted tyre positions (≤ tyreCount).
     */
    function showMountedCards(count) {
        $('.mandtory_tyre_positions').hide();
        $('.mandtory_tyre_positions').each(function (index) {
            if (index < count) $(this).show();
        });
    }


    // ── 2. SVG CLICK → SCROLL TO CARD + HIGHLIGHT ───────────────────────────
    $(document).on('click', '.tyre-group', function () {
        const code    = $(this).data('code');
        const $card   = $('#card-' + code);

        // Active SVG state
        $('#container-img .tyre-group').removeClass('active-svg');
        $(this).addClass('active-svg');

        if ($card.length) {
            const headerOffset = 80;
            $('html, body').stop().animate(
                { scrollTop: $card.offset().top - headerOffset },
                500
            );

            // Highlight card
            $('.tyre-card').removeClass('card-highlight');
            $card.addClass('card-highlight');

            // Auto-remove highlight after 2.5 s
            clearTimeout($card.data('highlightTimer'));
            $card.data('highlightTimer', setTimeout(function () {
                $card.removeClass('card-highlight');
            }, 2500));
        }
    });


    // ── 3. SVG HOVER ↔ CARD HOVER SYNC ──────────────────────────────────────
    $(document).on('mouseenter', '.tyre-group', function () {
        const code = $(this).data('code');
        $('#card-' + code).addClass('card-highlight');
    });
    $(document).on('mouseleave', '.tyre-group', function () {
        const code = $(this).data('code');
        $('#card-' + code).removeClass('card-highlight');
    });

    // Card hover → highlight SVG tyre
    $(document).on('mouseenter', '.tyre-card', function () {
        const pos = $(this).data('position');
        $('.tyre-group[data-code="' + pos + '"]').addClass('hovered');
    });
    $(document).on('mouseleave', '.tyre-card', function () {
        const pos = $(this).data('position');
        $('.tyre-group[data-code="' + pos + '"]').removeClass('hovered');
    });


    // ── 4. ADD TYRE MODAL — PRE-FILL POSITION ────────────────────────────────
    $(document).on('click', '.btn-add-tyre', function () {
        const pos       = $(this).data('position') || '';
        const mappingId = $(this).data('mapping-id') || '';
        $('#modalPositionLabel').text(pos);
        $('#addTyrePositionCode').val(pos);
        $('#addTyreMappingId').val(mappingId);
    });


    // ── 5. SAVE ADD TYRE (STUB — wire to real endpoint when ready) ───────────
    $('#saveAddTyre').on('click', function () {
        const $btn  = $(this);
        const pos   = $('#addTyrePositionCode').val();
        const cond  = $('#tyreConditionSelect').val();
        const type  = $('#tyreTypeSelect').val();
        const date  = $('input[name="fitment_date"]').val();

        if (!cond || !type || !date) {
            Toast.fire({ icon: 'warning', title: 'Please fill all required fields.' });
            return;
        }

        $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>Saving…').prop('disabled', true);

        // TODO: Replace with real AJAX call to backend when endpoint is wired
        setTimeout(function () {
            $btn.html('<i class="uil uil-save me-1"></i>Save').prop('disabled', false);
            $('#addTyre').modal('hide');
            Toast.fire({
                icon: 'success',
                title: 'Tyre added to position ' + pos,
                didClose: function () { window.location.reload(); }
            });
        }, 800);
    });


    // ── 6. REPLACE BUTTON (STUB) ──────────────────────────────────────────────
    $(document).on('click', '.btn-replace', function () {
        const pos = $(this).data('position');
        Toast.fire({ icon: 'info', title: 'Replace workflow for ' + pos + ' coming soon.' });
    });


    // ── 7. ADD SPARE SLOT ────────────────────────────────────────────────────
    $('.btn-add-spare-slot').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Spare slot management coming soon.' });
    });

});
