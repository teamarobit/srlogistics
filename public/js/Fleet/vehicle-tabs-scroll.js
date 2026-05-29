/*
 * Vehicle Details — Tabs horizontal scroll navigation
 * Shows thin prev/next buttons on the .nav-tabs.item-box bar
 * Visibility rules:
 *   - At start: only NEXT button visible
 *   - At end:   only PREV button visible
 *   - Middle:   both buttons visible
 *   - Not scrollable: neither button visible
 */
$(function () {
    var $wrap = $('.item-box-scroll-wrap');
    if (!$wrap.length) return;

    var $tabs = $wrap.find('.nav-tabs.item-box').first();
    var $prev = $wrap.find('.item-box-scroll-prev');
    var $next = $wrap.find('.item-box-scroll-next');
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

    // Ensure active tab is in view on first render — also primes button state
    var $active = $tabs.find('.nav-link.active').first();
    if ($active.length && $active.get(0).scrollIntoView) {
        try {
            $active.get(0).scrollIntoView({ inline: 'nearest', block: 'nearest' });
        } catch (e) { /* older browsers */ }
    }

    // Initial state — delay slightly so layout settles
    updateButtons();
    setTimeout(updateButtons, 150);
});
