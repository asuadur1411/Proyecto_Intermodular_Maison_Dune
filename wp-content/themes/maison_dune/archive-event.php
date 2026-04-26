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

<!-- Eventos destacados/premium -->
<?php
$premium_events = new WP_Query([
    'post_type'      => 'event',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'meta_query'     => [
        [
            'key'     => 'featured_event',
            'value'   => '1',
            'compare' => '='
        ]
    ],
    'meta_key'       => 'premium_order',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
]);

$premium_ids = wp_list_pluck($premium_events->posts, 'ID');
?>

<?php if ($premium_events->have_posts()) : ?>
<section class="events-premium">
    <div class="events-premium-header">
        <p class="section-kicker">Maison Dune Selection</p>
        <h2>Premium events & signature evenings</h2>
        <p>
            Discover a curated selection of Maison Dune experiences designed for guests
            seeking intimate encounters, refined atmospheres and unforgettable nights.
        </p>
    </div>

    <div class="events-premium-grid">
        <?php
        $count = 0;
        while ($premium_events->have_posts()) : $premium_events->the_post();
            $count++;
            $card_class = ($count === 1) ? 'premium-card premium-card-main' : 'premium-card';
            $terms = get_the_terms(get_the_ID(), 'event_category');
        ?>
            <article class="<?php echo esc_attr($card_class); ?>">
                <a href="<?php the_permalink(); ?>" class="premium-card-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php endif; ?>
                </a>

                <div class="premium-card-content">
                    <?php if ($terms && !is_wp_error($terms)) : ?>
                        <p class="premium-card-tag"><?php echo esc_html($terms[0]->name); ?></p>
                    <?php endif; ?>

                    <h3>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <?php if (has_excerpt()) : ?>
                        <p class="premium-card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <?php endif; ?>

                    <a href="<?php the_permalink(); ?>" class="premium-card-link">Discover more</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>
<?php endif; ?>

<?php wp_reset_postdata(); ?>

<!-- Eventos normales -->
<?php
$regular_events_args = [
    'post_type'      => 'event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
];

if (!empty($premium_ids)) {
    $regular_events_args['post__not_in'] = $premium_ids;
}

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

    <div class="events-grid">
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
</section>

<?php get_footer(); ?>