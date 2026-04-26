<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
$terms = get_the_terms(get_the_ID(), 'event_category');
$archive_link = get_post_type_archive_link('event');
?>

<section class="single-event-hero">
    <?php if (has_post_thumbnail()) : ?>
        <div class="single-event-hero-bg">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php endif; ?>

    <div class="single-event-hero-overlay"></div>

    <div class="single-event-hero-content">
        <?php if ($terms && !is_wp_error($terms)) : ?>
            <p class="single-event-label"><?php echo esc_html($terms[0]->name); ?></p>
        <?php else : ?>
            <p class="single-event-label">Maison Dune Event</p>
        <?php endif; ?>

        <h1><?php the_title(); ?></h1>

        <?php if (has_excerpt()) : ?>
            <p class="single-event-subtitle"><?php echo esc_html(get_the_excerpt()); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="single-event-main">
    <div class="single-event-wrapper">
        <div class="single-event-intro">
            <div class="single-event-heading">
                <h3>Event details</h3>
                <h2>An immersive Maison Dune experience</h2>
            </div>

            <div class="single-event-summary">
                <?php if (has_excerpt()) : ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php else : ?>
                    <p>
                        Discover a signature Maison Dune gathering where atmosphere,
                        sophistication and carefully curated moments shape an unforgettable evening.
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="single-event-content">
            <div class="single-event-text">
                <?php
                if (trim(get_the_content())) {
                    the_content();
                } else {
                    echo '<p>Details for this Maison Dune event will be available soon.</p>';
                }
                ?>
            </div>

            <aside class="single-event-sidebar">
                <div class="event-side-card">
                    <h3>Event category</h3>
                    <?php if ($terms && !is_wp_error($terms)) : ?>
                        <p><?php echo esc_html($terms[0]->name); ?></p>
                    <?php else : ?>
                        <p>Signature Experience</p>
                    <?php endif; ?>
                </div>

                <div class="event-side-card">
                    <h3>Location</h3>
                    <p>Maison Dune</p>
                </div>

                <div class="event-side-card">
                    <h3>Reservations</h3>
                    <p>Available upon request</p>
                </div>

                <?php if ($archive_link) : ?>
                    <a href="<?php echo esc_url($archive_link); ?>" class="back-events-link">
                        Back to events
                    </a>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<?php endwhile; else : ?>

<section class="single-event-main">
    <div class="single-event-wrapper">
        <div class="no-events">
            <h2>Event not found</h2>
            <p>The event you are looking for is not available.</p>
            <?php $archive_link = get_post_type_archive_link('event'); ?>
            <?php if ($archive_link) : ?>
                <a href="<?php echo esc_url($archive_link); ?>" class="back-events-link">
                    Back to events
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php endif; ?>

<?php get_footer(); ?>