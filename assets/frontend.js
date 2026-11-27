/**
 * Picha Changelog — Frontend enhancements
 */
(function () {
    'use strict';

    // ============================================================
    // Timeline reveal-on-scroll
    // ============================================================
    function initTimelineAnimation() {
        if (!('IntersectionObserver' in window)) {
            return;
        }

        var items = document.querySelectorAll('.dwpTimelineItem');
        if (!items.length) {
            return;
        }

        // Respect reduced motion
        var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) {
            return;
        }

        items.forEach(function (item) {
            item.classList.add('dwpTimelineHidden');
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('dwpTimelineHidden');
                    entry.target.classList.add('dwpTimelineVisible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        });

        items.forEach(function (item) {
            observer.observe(item);
        });
    }

    // ============================================================
    // Accordion: expand all <details> on print
    // ============================================================
    function initAccordionPrint() {
        var accordions = document.querySelectorAll('.dwpTempAccordion details');
        if (!accordions.length) {
            return;
        }

        var previouslyOpen = [];

        window.addEventListener('beforeprint', function () {
            previouslyOpen = [];
            accordions.forEach(function (details, index) {
                if (!details.open) {
                    previouslyOpen.push(index);
                    details.open = true;
                }
            });
        });

        window.addEventListener('afterprint', function () {
            // Restore original state
            previouslyOpen.forEach(function (index) {
                if (accordions[index]) {
                    accordions[index].open = false;
                }
            });
            previouslyOpen = [];
        });

        // Also handle older browsers via matchMedia
        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function (mql) {
                if (mql.matches) {
                    accordions.forEach(function (details) {
                        if (!details.open) {
                            details.open = true;
                            details.dataset.dwpAutoOpened = '1';
                        }
                    });
                } else {
                    accordions.forEach(function (details) {
                        if (details.dataset.dwpAutoOpened === '1') {
                            details.open = false;
                            delete details.dataset.dwpAutoOpened;
                        }
                    });
                }
            });
        }
    }

    // ============================================================
    // Init
    // ============================================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initTimelineAnimation();
            initAccordionPrint();
        });
    } else {
        initTimelineAnimation();
        initAccordionPrint();
    }
})();