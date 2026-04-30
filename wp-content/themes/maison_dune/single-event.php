<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
$event_id       = get_the_ID();
$terms          = get_the_terms($event_id, 'event_category');
$archive_link   = home_url('/events/');
$event_date     = get_post_meta($event_id, 'event_date', true);
$event_time     = get_post_meta($event_id, 'event_time', true);
$event_location = get_post_meta($event_id, 'event_location', true);
$event_capacity = (int) get_post_meta($event_id, 'event_capacity', true);

$display_date = $event_date ? date_i18n('D, j M Y', strtotime($event_date)) : '';
$display_time = $event_time ? date_i18n('H:i', strtotime($event_time)) : '';
?>

<section class="single-event-hero light">
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

        <div class="single-event-meta-strip">
            <?php if ($display_date) : ?>
                <span class="meta-chip">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <?php echo esc_html($display_date); ?>
                </span>
            <?php endif; ?>
            <?php if ($display_time) : ?>
                <span class="meta-chip">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo esc_html($display_time); ?>
                </span>
            <?php endif; ?>
            <?php if ($event_location) : ?>
                <span class="meta-chip">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <?php echo esc_html($event_location); ?>
                </span>
            <?php endif; ?>
        </div>

        <a href="#event-register" class="single-event-cta-anchor">
            Reserve your spot
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
        </a>
    </div>
</section>

<section class="single-event-main light">
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
                    <h3>Date &amp; Time</h3>
                    <p><?php echo $display_date ? esc_html($display_date) : 'TBA'; ?></p>
                    <?php if ($display_time) : ?>
                        <span class="event-side-sub"><?php echo esc_html($display_time); ?>h</span>
                    <?php endif; ?>
                </div>

                <div class="event-side-card">
                    <h3>Location</h3>
                    <p><?php echo $event_location ? esc_html($event_location) : 'Maison Dune'; ?></p>
                </div>

                <div class="event-side-card">
                    <h3>Category</h3>
                    <p><?php echo ($terms && !is_wp_error($terms)) ? esc_html($terms[0]->name) : 'Signature Experience'; ?></p>
                </div>

                <?php if ($event_capacity) : ?>
                    <div class="event-side-card capacity-card">
                        <h3>Capacity</h3>
                        <p>
                            <span class="capacity-num"><?php echo esc_html($event_capacity); ?></span>
                            <span class="event-side-sub">total seats</span>
                        </p>
                        <div class="capacity-status" data-event-slug="<?php echo esc_attr(get_post_field('post_name', $event_id)); ?>">
                            <span class="dot"></span><span class="txt">Checking availability…</span>
                        </div>
                    </div>
                <?php endif; ?>

                <a href="<?php echo esc_url($archive_link); ?>" class="back-events-link">
                    ← Back to events
                </a>
            </aside>
        </div>

        <div id="event-register" class="event-register-block"
             data-event-slug="<?php echo esc_attr(get_post_field('post_name', $event_id)); ?>"
             data-event-title="<?php echo esc_attr(get_the_title()); ?>"
             data-event-date="<?php echo esc_attr($event_date); ?>"
             data-event-time="<?php echo esc_attr($event_time); ?>"
             data-event-location="<?php echo esc_attr($event_location); ?>"
             data-event-capacity="<?php echo esc_attr($event_capacity); ?>"
             data-login-url="<?php echo esc_url(wp_login_url(get_permalink() . '#event-register')); ?>">

            <div class="event-register-header">
                <p class="er-kicker">Reserve your spot</p>
                <h2>Confirm your <em>attendance</em></h2>
                <p class="er-intro">
                    Reservations are confirmed instantly. You will receive a QR ticket
                    in your dashboard and by email.
                </p>
            </div>

            <?php if (!$event_date || !$event_time) : ?>
                <div class="er-locked">
                    <strong>Date and time not yet announced.</strong>
                    <span>Registration will open as soon as the schedule is confirmed.</span>
                </div>
            <?php else : ?>
                <form id="event-register-form" class="event-register-form" novalidate>
                    <div class="er-row two">
                        <label class="er-field">
                            <span>First name</span>
                            <input type="text" name="first_name" required maxlength="100" autocomplete="given-name">
                        </label>
                        <label class="er-field">
                            <span>Last name</span>
                            <input type="text" name="last_name" required maxlength="100" autocomplete="family-name">
                        </label>
                    </div>

                    <div class="er-row two">
                        <label class="er-field">
                            <span>Phone</span>
                            <input type="tel" name="phone" required pattern="\d{9}" maxlength="9" placeholder="9 digits" autocomplete="tel">
                        </label>
                        <label class="er-field">
                            <span>Number of guests</span>
                            <select name="guests" required>
                                <?php for ($i = 1; $i <= 10; $i++) : ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </label>
                    </div>

                    <label class="er-field full">
                        <span>Notes (optional)</span>
                        <textarea name="notes" maxlength="500" rows="3"
                                  placeholder="Dietary requirements, accessibility, special requests…"></textarea>
                    </label>

                    <div class="er-actions">
                        <button type="submit" class="er-submit">
                            <span>Confirm registration</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                        <p class="er-foot">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Login required. We will redirect you if needed.
                        </p>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
(function () {
    var block = document.getElementById('event-register');
    if (!block) return;

    var API = window.location.origin + "/maison_dune_api/public/index.php/api";
    var slug = block.dataset.eventSlug;
    var capacity = parseInt(block.dataset.eventCapacity || '0', 10);

    var statusEl = document.querySelector('.capacity-status[data-event-slug]');
    if (statusEl && capacity > 0) {
        fetch(API + '/events/' + encodeURIComponent(slug) + '/availability', {
            headers: { Accept: 'application/json' }
        })
        .then(function (r) { return r.json(); })
        .then(function (j) {
            var booked = (j && j.booked_seats) || 0;
            var left = capacity - booked;
            var txt = statusEl.querySelector('.txt');
            if (left <= 0) {
                statusEl.classList.add('sold-out');
                txt.textContent = 'Sold out';
            } else if (left <= Math.max(3, Math.round(capacity * 0.15))) {
                statusEl.classList.add('low');
                txt.textContent = left + ' seats left — book now';
            } else {
                statusEl.classList.add('open');
                txt.textContent = left + ' seats available';
            }
        })
        .catch(function () {
            statusEl.querySelector('.txt').textContent = 'Availability unavailable';
        });
    }

    var form = document.getElementById('event-register-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var token = localStorage.getItem('maison_token');
        if (!token) {
            if (window.maisonShowModal) {
                window.maisonShowModal('Please log in to register for this event.', 'error', function () {
                    window.location.href = block.dataset.loginUrl;
                });
            } else {
                if (window.maisonToast) window.maisonToast('Please log in to register.', 'info');
                setTimeout(function () { window.location.href = block.dataset.loginUrl; }, 800);
            }
            return;
        }

        var btn = form.querySelector('.er-submit');
        var labelEl = btn.querySelector('span');
        var originalLabel = labelEl.textContent;
        btn.disabled = true;
        labelEl.textContent = 'Sending…';

        var fd = new FormData(form);
        var payload = {
            event_slug:     block.dataset.eventSlug,
            event_title:    block.dataset.eventTitle,
            event_date:     block.dataset.eventDate,
            event_time:     block.dataset.eventTime,
            event_location: block.dataset.eventLocation || null,
            event_capacity: parseInt(block.dataset.eventCapacity || '0', 10) || null,
            first_name:     fd.get('first_name'),
            last_name:      fd.get('last_name'),
            phone:          fd.get('phone'),
            guests:         parseInt(fd.get('guests'), 10),
            notes:          fd.get('notes') || null
        };

        fetch(API + '/event-reservations', {
            method: 'POST',
            headers: {
                'Content-Type':  'application/json',
                'Accept':        'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(payload)
        })
        .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, data: j }; }); })
        .then(function (res) {
            if (res.ok) {
                if (window.maisonShowModal) {
                    window.maisonShowModal(res.data.message || 'You are registered. Check your dashboard.', 'success', function () {
                        window.location.href = '<?php echo esc_url(home_url('/')); ?>';
                    });
                } else if (window.maisonToast) {
                    window.maisonToast(res.data.message || 'Registered successfully.', 'success');
                    setTimeout(function () { window.location.href = '<?php echo esc_url(home_url('/')); ?>'; }, 1400);
                }
                form.reset();
                form.classList.add('er-success');
                labelEl.textContent = '✓ Registered';
            } else {
                var msg = (res.data && res.data.message) || 'Something went wrong.';
                if (res.data && res.data.errors) {
                    var firstKey = Object.keys(res.data.errors)[0];
                    msg = res.data.errors[firstKey][0] || msg;
                }
                if (window.maisonShowModal) {
                    window.maisonShowModal(msg, 'error');
                } else if (window.maisonToast) {
                    window.maisonToast(msg, 'error');
                }
                btn.disabled = false;
                labelEl.textContent = originalLabel;
            }
        })
        .catch(function () {
            if (window.maisonShowModal) {
                window.maisonShowModal('Network error. Please try again.', 'error');
            } else if (window.maisonToast) {
                window.maisonToast('Network error. Try again.', 'error');
            }
            btn.disabled = false;
            labelEl.textContent = originalLabel;
        });
    });
})();
</script>

<?php endwhile; else : ?>

<section class="single-event-main light">
    <div class="single-event-wrapper">
        <div class="no-events">
            <h2>Event not found</h2>
            <p>The event you are looking for is not available.</p>
            <a href="<?php echo esc_url(home_url('/events/')); ?>" class="back-events-link">
                Back to events
            </a>
        </div>
    </div>
</section>

<?php endif; ?>

<?php get_footer(); ?>
