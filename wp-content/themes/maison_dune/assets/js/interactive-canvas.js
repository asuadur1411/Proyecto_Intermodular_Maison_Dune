document.addEventListener('DOMContentLoaded', () => {
    const hotspots = document.querySelectorAll('.sic-hotspot');
    const panels = document.querySelectorAll('.sic-panel');
    const overlay = document.querySelector('.sic-overlay');
    const closeBtns = document.querySelectorAll('.sic-close-btn');
    const intro = document.querySelector('.sic-intro');

    function closeAll() {
        panels.forEach(p => p.classList.remove('active'));
        if(overlay) overlay.classList.remove('active');
        if(intro) intro.classList.remove('hidden');
    }

    hotspots.forEach(hotspot => {
        hotspot.addEventListener('click', (e) => {
            e.stopPropagation();
            const targetId = hotspot.getAttribute('data-target');
            if(!targetId) return;
            const target = document.getElementById(targetId);
            
            if (target && target.classList.contains('active')) {
                closeAll();
            } else {
                closeAll();
                if(target) target.classList.add('active');
                if(overlay) overlay.classList.add('active');
                if(intro) intro.classList.add('hidden');
            }
        });
    });

    closeBtns.forEach(btn => btn.addEventListener('click', closeAll));
    if(overlay) overlay.addEventListener('click', closeAll);
});
