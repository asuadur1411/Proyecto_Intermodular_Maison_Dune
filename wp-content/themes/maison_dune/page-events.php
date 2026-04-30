<?php
/* Template Name: Events */
get_header(); ?>

<main class="events-main">
    <section class="events-editorial-hero">
        <div class="events-hero-grid">
            
            <div class="events-hero-typography">
                <div class="typog-layer back-layer">CELEBRATE</div>
                <div class="typog-layer mid-layer">THE</div>
                <div class="typog-layer front-layer">MOMENTS</div>
                
                <div class="events-hero-desc">
                    <p>Where time stands still. Host your most cherished milestones in an environment defined by architectural majesty and uncompromising luxury.</p>
                    <div class="hero-meta">
                        <span>EST. 1992</span>
                        <div class="line"></div>
                        <span>MAISON DUNE EXCLUSIVE</span>
                    </div>
                    <a href="#upcoming-events" class="events-hero-cta">
                        <span class="cta-label">Browse Upcoming Events</span>
                        <span class="cta-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                        </span>
                    </a>
                </div>
            </div>

            <div class="events-hero-images">
                <div class="image-wrapper main-img">
                    <div class="img-inner" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/wedding.jpg');"></div>
                </div>
                
                <div class="image-wrapper secondary-img">
                    <div class="img-inner" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/terrace.jpeg');"></div>
                </div>
                
                <div class="glass-info-card">
                    <div class="glass-content">
                        <svg class="star-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>
                        <h4>Bespoke Celebrations</h4>
                        <p>Curated culinary journeys <br>and unparalleled settings.</p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="discover-link light">Inquire Now</a>
                    </div>
                </div>

                <div class="curved-badge">
                   <svg viewBox="0 0 100 100" class="rotating-text">
                        <path id="textPath" d="M 50, 50 m -35, 0 a 35,35 0 1,1 70,0 a 35,35 0 1,1 -70,0" fill="transparent"/>
                        <text>
                            <textPath href="#textPath" startOffset="0%">MAISON DUNE • EXCLUSIVE EVENTS • </textPath>
                        </text>
                   </svg>
                </div>
            </div>
            
        </div>
    </section>

    <section class="events-bento-intro">
        <div class="bento-container">

            <div class="bento-cell bento-img-wide has-hover">
                <div class="img-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/wedding.jpg');"></div>
                <div class="cell-overlay">
                    <span class="tag">Grand Events</span>
                    <h4>The Obsidian Ballroom</h4>
                </div>
            </div>

            <div class="bento-cell bento-data">
                <div class="data-top">
                    <div class="data-number">250<span>+</span></div>
                    <div class="data-label">Maximum Guest Capacity</div>
                </div>
                
                <div class="data-middle-stats">
                    <div class="stat-item">
                        <span class="stat-fig">04</span>
                        <span class="stat-txt">Distinct<br/>Venues</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-fig">A+</span>
                        <span class="stat-txt">Acoustic<br/>Rating</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-fig">24h</span>
                        <span class="stat-txt">Exclusive<br/>Buyout</span>
                    </div>
                </div>

                <div class="data-bottom">
                    <p>From intimate gatherings of 10 to grand galas of unparalleled scale, our architectural spaces adapt dynamically to your narrative.</p>
                    <div class="capacity-bar-wrapper">
                         <div class="bar-labels"><span>Intimate (12)</span> <span>Grand (250+)</span></div>
                         <div class="capacity-bar"><div class="fill"></div></div>
                    </div>
                </div>
            </div>

            <div class="bento-cell bento-list">
                <div class="list-header-complex">
                    <h4>Curated Environments</h4>
                    <div class="list-tags">
                        <span class="b-tag">Indoor</span>
                        <span class="b-tag">Al Fresco</span>
                        <span class="b-tag">Panoramic</span>
                    </div>
                </div>
                
                <div class="environment-highlights">
                    <div class="highlight-item">
                        <svg class="h-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <p>Modular layouts tailored to your exact event specifications and aesthetic vision.</p>
                    </div>
                </div>

                <ul class="luxury-list">
                    <li>
                        <div class="li-left"><span class="num">01</span> <span class="text">Ziryab Private Dining</span></div>
                        <div class="li-right"><span class="cap">12 Guests</span></div>
                    </li>
                    <li>
                        <div class="li-left"><span class="num">02</span> <span class="text">The Obsidian Ballroom</span></div>
                        <div class="li-right"><span class="cap">250 Guests</span></div>
                    </li>
                    <li>
                        <div class="li-left"><span class="num">03</span> <span class="text">Dune Open-Air Terraces</span></div>
                        <div class="li-right"><span class="cap">150 Guests</span></div>
                    </li>
                    <li>
                        <div class="li-left"><span class="num">04</span> <span class="text">The Secret Courtyard</span></div>
                        <div class="li-right"><span class="cap">50 Guests</span></div>
                    </li>
                </ul>
            </div>

            <div class="bento-cell bento-img-tall has-hover">
                 <div class="img-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/wines.avif');"></div>
                 <div class="cell-overlay">
                    <span class="tag">Gastronomy</span>
                    <h4>Cellar & Cuisine</h4>
                </div>
            </div>

            <div class="bento-cell bento-quote">
                <div class="quote-mark">"</div>
                <p>Elegance is not about being noticed,<br/>it's about being remembered.</p>
                <div class="signature">Maison Dune Curators</div>
            </div>
            
            <div class="bento-cell bento-specs">
                <div class="spec-row">
                    <span class="label">Acoustics</span>
                    <span class="val">State-of-the-Art Meyer Sound</span>
                </div>
                <div class="spec-row">
                    <span class="label">Lighting</span>
                    <span class="val">Customizable Ambient & Spotlight</span>
                </div>
                <div class="spec-row">
                    <span class="label">Floral & Decor</span>
                    <span class="val">In-House Master Florist</span>
                </div>
                 <div class="spec-row">
                    <span class="label">Privacy</span>
                    <span class="val">Exclusive Full-Buyout Available</span>
                </div>
            </div>

            <div class="bento-cell bento-abstract">
                <div class="marquee-wrapper">
                    <div class="marquee-text">
                        DESIGNED FOR EXPERIENCES • CRAFTED WITH PASSION • DESIGNED FOR EXPERIENCES • CRAFTED WITH PASSION • DESIGNED FOR EXPERIENCES • CRAFTED WITH PASSION • DESIGNED FOR EXPERIENCES • CRAFTED WITH PASSION • 
                    </div>
                </div>
                <div class="abstract-content">
                    <p>Every detail, from the thread count of the linens to the sourcing of rare spices, is orchestrated by our dedicated master of ceremonies.</p>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="bento-btn">Discover Venues</a>
                </div>
            </div>

        </div>
    </section>
    <section class="events-ateliers-section">
        <div class="ateliers-intro">
            <h4 class="micro-title">The Maison Dune Pillars</h4>
            <h2 class="macro-title">Architects of<br/>the Ephemeral</h2>
            <p class="intro-desc">To deliver the extraordinary, we rely on our specialized in-house ateliers. Each operates with a singular focus, bringing unmatched expertise to every dimension of your event.</p>
        </div>
        <div class="atelier-module module-left">
            <div class="atelier-visual">
                <div class="img-wrap" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/mesa-restaurante.webp');"></div>
                <div class="visual-deco-line"></div>
            </div>
            <div class="atelier-content glass-elevated">
                <div class="atelier-number">01</div>
                <h3>Gastronomy & Oenology</h3>
                <p class="big-text">Culinary excellence is not an option; it is our foundation. Partnered with regional Michelin luminaries, our kitchens transcend traditional event catering.</p>
                <p class="small-text">From private tastings in our subterranean cellars to 250-guest banquets featuring avant-garde plating, our master sommeliers and executive chefs curate tailored sensory journeys. Every ingredient is sourced with extreme prejudice for quality.</p>
                <ul class="atelier-stats">
                    <li><span>12K</span> Bottles Cellar</li>
                    <li><span>03</span> Master Chefs</li>
                    <li><span>A+</span> Sourcing</li>
                </ul>
            </div>
        </div>
        <div class="atelier-module module-right">
            <div class="atelier-content solid-beige">
                <div class="atelier-number">02</div>
                <h3>Scenography & Florals</h3>
                <p class="big-text">The environment must reflect your narrative. Our in-house botanical artists and spatial designers craft immersive worlds.</p>
                <p class="small-text">Whether you desire a cascading ceiling of rare orchids imported from the tropics, or a minimalist interplay of shadows and Mediterranean flora, the Scenography Atelier physically manifests your vision, manipulating space, color, and texture.</p>
                <ul class="atelier-stats">
                    <li><span>04</span> Floral Architects</li>
                    <li><span>24h</span> Turnaround</li>
                    <li><span>100%</span> Bespoke</li>
                </ul>
            </div>
            <div class="atelier-visual">
                <div class="img-wrap" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/terrace.jpeg'); filter: brightness(0.85);"></div>
                <div class="visual-deco-box"></div>
            </div>
        </div>
        <div class="atelier-module module-center-split">
            <div class="split-top">
                <div class="split-left">
                   <div class="atelier-number outline-num">03</div>
                   <h3>Sensory<br/>Engineering</h3>
                </div>
                <div class="split-right">
                   <div class="tech-grid">
                       <div class="tech-item">
                           <h4>Acoustic Mastery</h4>
                           <p>Calibrated Meyer Sound systems integrated invisibly into our columns.</p>
                       </div>
                       <div class="tech-item">
                           <h4>Kinetic Lighting</h4>
                           <p>Algorithmic spotlighting that shifts subtly with the evening's cadence.</p>
                       </div>
                       <div class="tech-item">
                           <h4>Climate Control</h4>
                           <p>Whisper-quiet environmental regulation regardless of scale.</p>
                       </div>
                   </div>
                </div>
            </div>
            <div class="center-banner-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/wedding.jpg'); background-position: top;"></div>
        </div>

    </section>

    <?php
    $event_categories = get_terms([
        'taxonomy'   => 'event_category',
        'hide_empty' => true,
    ]);
    $upcoming_events = new WP_Query([
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    if ($upcoming_events->have_posts()) :
    ?>
    <section class="events-listing-section" id="upcoming-events">
        <div class="events-listing-header">
            <p class="events-listing-kicker">Maison Dune Calendar</p>
            <h2>Upcoming &amp; Signature Events</h2>
            <p class="events-listing-intro">
                Explore our curated programme of immersive evenings, gastronomy showcases
                and signature gatherings — each one designed to leave a lasting trace.
            </p>
        </div>

        <div class="events-listing-toolbar">
            <div class="events-listing-filters">
                <button type="button" class="events-filter-pill active" data-filter="all">All Events</button>
                <?php if ($event_categories && !is_wp_error($event_categories)) :
                    foreach ($event_categories as $cat) : ?>
                        <button type="button" class="events-filter-pill" data-filter="cat-<?php echo esc_attr($cat->slug); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </button>
                <?php endforeach; endif; ?>
            </div>
            <div class="events-listing-sort">
                <label for="events-sort-select">Sort</label>
                <select id="events-sort-select" class="events-sort-select">
                    <option value="newest">Newest first</option>
                    <option value="oldest">Oldest first</option>
                    <option value="az">Title A → Z</option>
                    <option value="za">Title Z → A</option>
                </select>
            </div>
        </div>

        <div class="events-listing-grid" id="events-listing-grid" data-events-per-page="9">
            <?php while ($upcoming_events->have_posts()) : $upcoming_events->the_post();
                $terms = get_the_terms(get_the_ID(), 'event_category');
                $cat_slugs = [];
                $cat_label = '';
                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $t) { $cat_slugs[] = 'cat-' . $t->slug; }
                    $cat_label = $terms[0]->name;
                }
                $thumb = has_post_thumbnail()
                    ? get_the_post_thumbnail_url(get_the_ID(), 'large')
                    : get_template_directory_uri() . '/assets/img/wedding.jpg';
                $excerpt = has_excerpt()
                    ? get_the_excerpt()
                    : wp_trim_words(get_the_content(), 20, '…');
                $date_label = get_the_date('d M Y');
                $title_lower = strtolower(get_the_title());
            ?>
                <article class="event-listing-card <?php echo esc_attr(implode(' ', $cat_slugs)); ?>"
                         data-title="<?php echo esc_attr($title_lower); ?>"
                         data-date="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">

                    <a href="<?php the_permalink(); ?>" class="event-listing-media" aria-label="<?php the_title_attribute(); ?>">
                        <div class="event-listing-img" style="background-image: url('<?php echo esc_url($thumb); ?>');"></div>
                        <span class="event-listing-date"><?php echo esc_html($date_label); ?></span>
                    </a>

                    <div class="event-listing-body">
                        <?php if ($cat_label) : ?>
                            <span class="event-listing-tag"><?php echo esc_html($cat_label); ?></span>
                        <?php endif; ?>
                        <h3 class="event-listing-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="event-listing-excerpt"><?php echo esc_html($excerpt); ?></p>
                        <div class="event-listing-foot">
                            <span class="event-listing-loc">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Maison Dune
                            </span>
                            <a href="<?php the_permalink(); ?>" class="event-listing-cta">
                                Discover
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <p class="events-listing-empty" id="events-listing-empty" hidden>
            No events match your selection. Try another category.
        </p>

        <nav class="events-pagination" id="events-listing-pagination" aria-label="Events pagination" hidden>
            <button type="button" class="events-pagination-btn" data-page-action="prev" aria-label="Previous page">‹</button>
            <ul class="events-pagination-list" role="list"></ul>
            <button type="button" class="events-pagination-btn" data-page-action="next" aria-label="Next page">›</button>
        </nav>
    </section>
    <?php endif; ?>
</main>

<script>
(function () {
    var grid = document.getElementById('events-listing-grid');
    if (!grid) return;
    var perPage = parseInt(grid.getAttribute('data-events-per-page'), 10) || 9;
    var cards = Array.prototype.slice.call(grid.querySelectorAll('.event-listing-card'));
    var pills = document.querySelectorAll('.events-filter-pill');
    var sortSel = document.getElementById('events-sort-select');
    var emptyMsg = document.getElementById('events-listing-empty');
    var nav  = document.getElementById('events-listing-pagination');
    var list = nav ? nav.querySelector('.events-pagination-list') : null;
    var prevBtn = nav ? nav.querySelector('[data-page-action="prev"]') : null;
    var nextBtn = nav ? nav.querySelector('[data-page-action="next"]') : null;

    var activeFilter = 'all';
    var current = 1;

    function getFiltered() {
        return cards.filter(function (c) {
            return (activeFilter === 'all') || c.classList.contains(activeFilter);
        });
    }

    function renderPagination(filtered) {
        if (!nav) return;
        var pageCount = Math.ceil(filtered.length / perPage);
        if (filtered.length <= perPage) {
            nav.hidden = true;
            list.innerHTML = '';
            return;
        }
        nav.hidden = false;
        list.innerHTML = '';
        for (var i = 1; i <= pageCount; i++) {
            var li = document.createElement('li');
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'events-pagination-num';
            b.textContent = i;
            b.setAttribute('data-page', String(i));
            if (i === current) b.classList.add('active');
            li.appendChild(b);
            list.appendChild(li);
        }
        prevBtn.disabled = (current === 1);
        nextBtn.disabled = (current === pageCount);
    }

    function applyAll() {
        var filtered = getFiltered();
        var pageCount = Math.max(1, Math.ceil(filtered.length / perPage));
        if (current > pageCount) current = pageCount;

        var start = (current - 1) * perPage;
        var end = start + perPage;

        cards.forEach(function (c) { c.style.display = 'none'; });
        filtered.forEach(function (c, idx) {
            if (idx >= start && idx < end) c.style.display = '';
        });

        if (emptyMsg) emptyMsg.hidden = filtered.length !== 0;
        renderPagination(filtered);
    }

    function applySort(mode) {
        var sorted = cards.slice().sort(function (a, b) {
            if (mode === 'az') return a.dataset.title.localeCompare(b.dataset.title);
            if (mode === 'za') return b.dataset.title.localeCompare(a.dataset.title);
            if (mode === 'oldest') return a.dataset.date.localeCompare(b.dataset.date);
            return b.dataset.date.localeCompare(a.dataset.date);
        });
        sorted.forEach(function (c) { grid.appendChild(c); });
        cards = sorted;
        current = 1;
        applyAll();
    }

    pills.forEach(function (p) {
        p.addEventListener('click', function () {
            pills.forEach(function (x) { x.classList.remove('active'); });
            p.classList.add('active');
            activeFilter = p.dataset.filter;
            current = 1;
            applyAll();
        });
    });
    if (sortSel) sortSel.addEventListener('change', function () { applySort(sortSel.value); });

    if (nav) {
        list.addEventListener('click', function (e) {
            var t = e.target.closest('.events-pagination-num');
            if (!t) return;
            current = parseInt(t.getAttribute('data-page'), 10);
            applyAll();
            var top = grid.getBoundingClientRect().top + window.scrollY - 80;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
        prevBtn.addEventListener('click', function () {
            if (current > 1) { current--; applyAll(); }
        });
        nextBtn.addEventListener('click', function () {
            var filtered = getFiltered();
            var pageCount = Math.ceil(filtered.length / perPage);
            if (current < pageCount) { current++; applyAll(); }
        });
    }

    applyAll();
})();
</script>

<?php get_footer(); ?>
