/*
 * Maintenance Book — Sub-tab pills horizontal scroll navigation
 * Mirrors vehicle-tabs-scroll.js but targets the inner pills nav inside
 * .maint-pills-scroll-wrap (Maintenance Book tab on Vehicle Details page).
 *
 * Visibility rules:
 *   - At start: only NEXT button visible
 *   - At end:   only PREV button visible
 *   - Middle:   both buttons visible
 *   - Not scrollable: neither button visible
 */
$(function () {
    var $wrap = $('.maint-pills-scroll-wrap');
    if (!$wrap.length) return;

    var $tabs = $wrap.find('#pills-tab').first();
    var $prev = $wrap.find('.maint-pills-scroll-prev');
    var $next = $wrap.find('.maint-pills-scroll-next');
    var el = $tabs.get(0);
    if (!el) return;

    var SCROLL_STEP = 220;
    var TOLERANCE = 2;

    function updateButtons() {
        var maxScroll = el.scrollWidth - el.clientWidth;
        if (maxScroll <= TOLERANCE) {
            $prev.removeClass('is-visible');
            $next.removeClass('is-visible');
            $wrap.removeClass('has-prev has-next');
            return;
        }
        var showPrev = el.scrollLeft > TOLERANCE;
        var showNext = el.scrollLeft < (maxScroll - TOLERANCE);
        $prev.toggleClass('is-visible', showPrev);
        $next.toggleClass('is-visible', showNext);
        $wrap.toggleClass('has-prev', showPrev);
        $wrap.toggleClass('has-next', showNext);
    }

    $prev.on('click', function () {
        el.scrollBy({ left: -SCROLL_STEP, behavior: 'smooth' });
    });

    $next.on('click', function () {
        el.scrollBy({ left: SCROLL_STEP, behavior: 'smooth' });
    });

    $tabs.on('scroll', updateButtons);
    $(window).on('resize', updateButtons);

    // Recalculate when the parent Maintenance Book tab becomes visible
    $(document).on('shown.bs.tab', 'button[data-bs-target="#maintenance"]', function () {
        setTimeout(updateButtons, 50);
    });

    // Keep the active pill in view on first render
    var $active = $tabs.find('.nav-link.active').first();
    if ($active.length && $active.get(0).scrollIntoView) {
        try {
            $active.get(0).scrollIntoView({ inline: 'nearest', block: 'nearest' });
        } catch (e) { /* older browsers */ }
    }

    // Initial state — delay slightly so layout settles
    updateButtons();
    setTimeout(updateButtons, 200);
});
