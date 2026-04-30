document.addEventListener("DOMContentLoaded", function() {
    const wrapper = document.getElementById('sticky-carousel-wrapper');
    const stickyContainer = document.querySelector('.sticky-carousel-sticky');
    const track = document.getElementById('sticky-carousel-track');
    
    if(!wrapper || !stickyContainer || !track) return;

    // Mobile / tablet: do not enable horizontal sticky scroll, the slides
    // stack vertically via CSS. Reset any previously applied inline styles.
    const mql = window.matchMedia('(max-width: 1024px)');
    function resetMobileStyles() {
        stickyContainer.style.position = '';
        stickyContainer.style.top = '';
        track.style.transform = '';
    }
    if (mql.matches) resetMobileStyles();
    mql.addEventListener('change', function (e) {
        if (e.matches) resetMobileStyles();
    });

    window.addEventListener('scroll', () => {
        if (mql.matches) return;
        const rect = wrapper.getBoundingClientRect();
        const wrapperTop = rect.top;
        const wrapperHeight = rect.height;
        const windowHeight = window.innerHeight;
        
        if (wrapperTop <= 0 && rect.bottom >= windowHeight) {
            stickyContainer.style.position = 'fixed';
            stickyContainer.style.top = '0';
        } else if (rect.bottom < windowHeight) {
            stickyContainer.style.position = 'absolute';
            stickyContainer.style.top = (wrapperHeight - windowHeight) + 'px';
        } else {
            stickyContainer.style.position = 'absolute';
            stickyContainer.style.top = '0';
        }
        
        let scrollProgress = 0;
        if (wrapperTop <= 0) {
            const scrollableDistance = wrapperHeight - windowHeight;
            const scrolled = Math.abs(wrapperTop);
            scrollProgress = Math.max(0, Math.min(1, scrolled / scrollableDistance));
        }
        
        const moveX = scrollProgress * -2 * stickyContainer.clientWidth;
        track.style.transform = `translateX(${moveX}px)`;
    });
    
    window.dispatchEvent(new Event('scroll'));
});

