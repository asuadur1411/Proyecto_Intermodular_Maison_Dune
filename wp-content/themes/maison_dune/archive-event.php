<?php get_header(); ?>

<section class="events-hero">
    <div class="events-hero-content">
        <h3>Maison Dune</h3>
        <h1>Events</h1>
        <p>
            Immersive nights, refined encounters and signature moments designed
            for guests seeking culture, flavour and unforgettable luxury.
        </p>
    </div>
</section>

<!-- Eventos -->
<?php
$regular_events_args = [
    'post_type'      => 'event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
];

$regular_events = new WP_Query($regular_events_args);
?>

<section class="events-archive">
    <div class="events-archive-intro">
        <h3>Curated calendar</h3>
        <h1>Discover our experiences</h1>
        <p>
            Explore a collection of exclusive gatherings where gastronomy,
            music and Arabian-inspired elegance come together.
        </p>
    </div>

    <?php
    $event_categories = get_terms([
        'taxonomy'   => 'event_category',
        'hide_empty' => true,
    ]);
    ?>

    <?php if ($event_categories && !is_wp_error($event_categories)) : ?>
        <div class="events-filters">
            <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="filter-pill active">All</a>

            <?php foreach ($event_categories as $category) : ?>
                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="filter-pill">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="events-grid" data-events-per-page="9">
        <?php if ($regular_events->have_posts()) : ?>
            <?php while ($regular_events->have_posts()) : $regular_events->the_post(); ?>
                <article class="event-card">
                    <a href="<?php the_permalink(); ?>" class="event-card-image-link">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="event-card-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php else : ?>
                            <div class="event-card-image event-card-image-placeholder"></div>
                        <?php endif; ?>
                    </a>

                    <div class="event-card-content">
                        <div class="event-card-meta">
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'event_category');
                            if ($terms && !is_wp_error($terms)) :
                            ?>
                                <span class="event-card-category">
                                    <?php echo esc_html($terms[0]->name); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <h2>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <p>
                            <?php
                            if (has_excerpt()) {
                                echo esc_html(get_the_excerpt());
                            } else {
                                echo esc_html(wp_trim_words(get_the_content(), 22, '...'));
                            }
                            ?>
                        </p>

                        <a href="<?php the_permalink(); ?>" class="event-card-link">Discover event</a>
                    </div>
                </article>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="no-events">
                <h2>No events available at the moment</h2>
                <p>Please check back soon for upcoming Maison Dune experiences.</p>
            </div>
        <?php endif; ?>
    </div>

    <nav class="events-pagination" id="events-pagination" aria-label="Events pagination" hidden>
        <button type="button" class="events-pagination-btn" data-page-action="prev" aria-label="Previous page">‹</button>
        <ul class="events-pagination-list" role="list"></ul>
        <button type="button" class="events-pagination-btn" data-page-action="next" aria-label="Next page">›</button>
    </nav>
</section>

<script>
(function () {
    var grid = document.querySelector('.events-archive .events-grid');
    var nav  = document.getElementById('events-pagination');
    if (!grid || !nav) return;

    var perPage = parseInt(grid.getAttribute('data-events-per-page'), 10) || 9;
    var cards = Array.prototype.slice.call(grid.querySelectorAll('.event-card'));
    if (cards.length <= perPage) return;

    var pageCount = Math.ceil(cards.length / perPage);
    var current = 1;

    var list = nav.querySelector('.events-pagination-list');
    var prevBtn = nav.querySelector('[data-page-action="prev"]');
    var nextBtn = nav.querySelector('[data-page-action="next"]');

    for (var i = 1; i <= pageCount; i++) {
        var li = document.createElement('li');
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'events-pagination-num';
        b.textContent = i;
        b.setAttribute('data-page', String(i));
        li.appendChild(b);
        list.appendChild(li);
    }

    function render() {
        var start = (current - 1) * perPage;
        var end = start + perPage;
        cards.forEach(function (card, idx) {
            card.style.display = (idx >= start && idx < end) ? '' : 'none';
        });
        list.querySelectorAll('.events-pagination-num').forEach(function (b) {
            b.classList.toggle('active', parseInt(b.getAttribute('data-page'), 10) === current);
        });
        prevBtn.disabled = (current === 1);
        nextBtn.disabled = (current === pageCount);
        var top = document.querySelector('.events-archive');
        if (top && window.scrollY > top.offsetTop) {
            window.scrollTo({ top: top.offsetTop - 60, behavior: 'smooth' });
        }
    }

    list.addEventListener('click', function (e) {
        var t = e.target.closest('.events-pagination-num');
        if (!t) return;
        current = parseInt(t.getAttribute('data-page'), 10);
        render();
    });
    prevBtn.addEventListener('click', function () { if (current > 1) { current--; render(); } });
    nextBtn.addEventListener('click', function () { if (current < pageCount) { current++; render(); } });

    nav.hidden = false;
    render();
})();
</script>

<?php get_footer(); ?>
