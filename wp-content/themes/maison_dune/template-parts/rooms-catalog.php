<?php
/**
 * Rooms Catalog template part.
 * Lists all rooms from the `room` CPT with filtering (search, type tabs, sort,
 * capacity, price range, amenities) and a booking modal that links to /checkout/.
 *
 * Usage:
 *   set_query_var('current_room_type', 'suites');           // taxonomy slug
 *   set_query_var('catalog_heading',  'Browse our Suites'); // optional override
 *   get_template_part('template-parts/rooms-catalog');
 */

$current_type    = get_query_var('current_room_type', '');
$catalog_heading = get_query_var('catalog_heading', '');

$type_terms = get_terms([
    'taxonomy'   => 'room_type',
    'hide_empty' => false,
    'orderby'    => 'term_order',
]);
if (is_wp_error($type_terms)) $type_terms = [];

// Flatpickr (only loaded once even if template-part included multiple times)
if (!defined('MAISON_FLATPICKR_LOADED')) {
    define('MAISON_FLATPICKR_LOADED', true);
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">' . "\n";
    echo '<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js" defer></script>' . "\n";
}

$rooms_query = new WP_Query([
    'post_type'      => 'room',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]);
?>

<section class="rooms-catalog-section">
    <div class="rooms-catalog-header">
        <span class="catalog-eyebrow">Direct Booking</span>
        <h2><?php echo wp_kses_post($catalog_heading ? $catalog_heading : 'Book your stay <em>now</em>'); ?></h2>
        <div class="catalog-separator"></div>
        <p>Select the dates of your stay and reserve directly. Real-time availability across our entire collection.</p>
    </div>

    <?php if (!empty($type_terms)) : ?>
    <div class="rooms-type-tabs" role="tablist">
        <button type="button" class="type-tab<?php echo $current_type === '' ? ' is-active' : ''; ?>" data-type="">All</button>
        <?php foreach ($type_terms as $term) : ?>
            <button type="button" class="type-tab<?php echo $current_type === $term->slug ? ' is-active' : ''; ?>" data-type="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="rooms-catalog-filters">
        <form id="rooms-filter-form" class="rooms-filters" onsubmit="return false;">
            <div class="filter-group filter-search">
                <input type="text" id="search-input" name="search" placeholder="Search by name…" autocomplete="off">
            </div>
            <div class="filter-group">
                <select id="sort-by" name="sort">
                    <option value="">Sort by…</option>
                    <option value="price-asc">Price: low to high</option>
                    <option value="price-desc">Price: high to low</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="capacity-filter" name="capacity">
                    <option value="">Guests</option>
                    <option value="1">1 guest</option>
                    <option value="2">2 guests</option>
                    <option value="3">3 guests</option>
                    <option value="4">4+ guests</option>
                </select>
            </div>
            <div class="filter-group filter-price">
                <input type="number" id="min-price" name="min_price" placeholder="Min €" min="0">
                <span>—</span>
                <input type="number" id="max-price" name="max_price" placeholder="Max €" min="0">
            </div>
            <button type="button" id="clear-filters" class="catalog-clear-btn">Clear</button>
        </form>

        <div id="amenities-filters" class="rooms-amenities-tags">
            <label class="tag-checkbox"><input type="checkbox" value="wifi"><span>Wi-Fi</span></label>
            <label class="tag-checkbox"><input type="checkbox" value="terrace"><span>Terrace</span></label>
            <label class="tag-checkbox"><input type="checkbox" value="views"><span>Views</span></label>
            <label class="tag-checkbox"><input type="checkbox" value="breakfast"><span>Breakfast</span></label>
            <label class="tag-checkbox"><input type="checkbox" value="spa"><span>Spa</span></label>
            <label class="tag-checkbox"><input type="checkbox" value="bathtub"><span>Bathtub</span></label>
        </div>
    </div>

    <div id="rooms-grid" class="rooms-catalog-grid" data-default-type="<?php echo esc_attr($current_type); ?>">
        <?php if ($rooms_query->have_posts()) :
            while ($rooms_query->have_posts()) : $rooms_query->the_post();
                $rid       = get_the_ID();
                $price     = floatval(get_post_meta($rid, '_room_price', true));
                $capacity  = intval(get_post_meta($rid, '_room_capacity', true));
                $bed       = get_post_meta($rid, '_room_bed', true) ?: '—';
                $area      = get_post_meta($rid, '_room_area', true);
                $rating    = max(1, min(5, intval(get_post_meta($rid, '_room_rating', true)) ?: 5));
                $status    = get_post_meta($rid, '_room_status', true) ?: 'available';
                $amenities = (array) get_post_meta($rid, '_room_amenities', true);
                $img       = has_post_thumbnail() ? get_the_post_thumbnail_url($rid, 'large') : (get_post_meta($rid, '_room_external_image', true) ?: get_template_directory_uri() . '/assets/img/habitaciones-1.jpg');
                $excerpt   = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 22, '…');
                $status_text = ['available' => 'Available', 'limited' => 'Few left', 'sold-out' => 'Sold out'][$status] ?? 'Available';
                $amen_data = implode(',', array_map('sanitize_html_class', $amenities));

                $room_terms = get_the_terms($rid, 'room_type');
                $type_slugs = [];
                $type_names = [];
                if ($room_terms && !is_wp_error($room_terms)) {
                    foreach ($room_terms as $rt) { $type_slugs[] = $rt->slug; $type_names[] = $rt->name; }
                }
                $type_data  = implode(',', $type_slugs);
                $type_label = $type_names ? $type_names[0] : '';
        ?>
            <article class="catalog-card"
                     data-id="<?php echo esc_attr($rid); ?>"
                     data-name="<?php echo esc_attr(strtolower(get_the_title())); ?>"
                     data-price="<?php echo esc_attr($price); ?>"
                     data-rating="<?php echo esc_attr($rating); ?>"
                     data-capacity="<?php echo esc_attr($capacity); ?>"
                     data-status="<?php echo esc_attr($status); ?>"
                     data-types="<?php echo esc_attr($type_data); ?>"
                     data-amenities="<?php echo esc_attr($amen_data); ?>">
                <div class="catalog-card-img">
                    <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    <span class="catalog-badge catalog-badge-<?php echo esc_attr($status); ?>"><?php echo esc_html($status_text); ?></span>
                    <?php if ($type_label) : ?>
                        <span class="catalog-type-chip"><?php echo esc_html($type_label); ?></span>
                    <?php endif; ?>
                </div>
                <div class="catalog-card-body">
                    <div class="catalog-card-meta">
                        <span class="catalog-price">€<?php echo number_format($price, 0, ',', '.'); ?> <span>/ night</span></span>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo esc_html($excerpt); ?></p>
                    <div class="catalog-card-features">
                        <span><?php echo esc_html($capacity); ?> guests</span>
                        <span><?php echo esc_html($bed); ?></span>
                        <?php if ($area) : ?><span><?php echo esc_html($area); ?> m²</span><?php endif; ?>
                    </div>
                    <button type="button" class="catalog-view-btn" data-id="<?php echo esc_attr($rid); ?>">View details</button>
                </div>
                <script type="application/json" class="catalog-card-data"><?php echo wp_json_encode([
                    'id'         => $rid,
                    'slug'       => get_post_field('post_name', $rid),
                    'title'      => get_the_title(),
                    'price'      => $price,
                    'capacity'   => $capacity,
                    'bed'        => $bed,
                    'area'       => $area,
                    'rating'     => $rating,
                    'status'     => $status,
                    'status_text'=> $status_text,
                    'image'      => $img,
                    'amenities'  => array_values($amenities),
                    'desc'       => wp_strip_all_tags(get_the_content()) ?: $excerpt,
                ]); ?></script>
            </article>
        <?php endwhile; wp_reset_postdata(); else : ?>
            <p class="catalog-empty">No rooms have been published yet.</p>
        <?php endif; ?>
    </div>

    <p class="catalog-no-results" hidden>No rooms match your filters. Try clearing them.</p>
</section>

<div id="room-detail-modal" class="room-modal" aria-hidden="true">
    <div class="room-modal-overlay" data-close></div>
    <div class="room-modal-content" role="dialog" aria-modal="true">
        <button class="room-modal-close" data-close aria-label="Close">✕</button>
        <div class="room-modal-gallery">
            <img src="" alt="" id="modal-main-img">
        </div>
        <div class="room-modal-info">
            <span class="modal-kicker">Maison Dune</span>
            <h2 id="modal-title">—</h2>
            <div class="modal-price-box">
                <h3 id="modal-price">—</h3>
                <span id="modal-status" class="modal-availability">—</span>
            </div>
            <div class="modal-booking-setup">
                <div class="modal-date-group">
                    <label for="modal-checkin">Check-in</label>
                    <input type="text" id="modal-checkin" placeholder="Select date" readonly>
                </div>
                <div class="modal-date-group">
                    <label for="modal-checkout">Check-out</label>
                    <input type="text" id="modal-checkout" placeholder="Select date" readonly>
                </div>
            </div>
            <p id="modal-availability-hint" class="modal-availability-hint">Loading availability…</p>
            <p id="modal-desc" class="modal-desc">—</p>
            <div class="modal-details-grid">
                <div>
                    <h4>Included services</h4>
                    <ul id="modal-amenities" class="modal-list"></ul>
                </div>
                <div>
                    <h4>Policies</h4>
                    <ul class="modal-list">
                        <li><strong>Cancellation:</strong> Free up to 48h before check-in.</li>
                        <li><strong>Check-in:</strong> from 3:00 pm.</li>
                        <li><strong>Check-out:</strong> until 12:00 pm.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-actions">
                <a id="modal-checkout-btn" href="javascript:void(0)" class="catalog-disabled-btn full-width">Select valid dates</a>
            </div>

            <section class="modal-reviews">
                <div class="modal-reviews-header">
                    <span class="reviews-meta" id="reviews-meta"></span>
                </div>
                <div id="reviews-list" class="reviews-list"></div>
                <div id="reviews-form-wrap" class="reviews-form-wrap" hidden>
                    <h5>Share your experience</h5>
                    <div class="reviews-rating-input" id="reviews-rating-input" role="radiogroup" aria-label="Your rating">
                        <button type="button" class="rating-star" data-value="1" aria-label="1 star">★</button>
                        <button type="button" class="rating-star" data-value="2" aria-label="2 stars">★</button>
                        <button type="button" class="rating-star" data-value="3" aria-label="3 stars">★</button>
                        <button type="button" class="rating-star" data-value="4" aria-label="4 stars">★</button>
                        <button type="button" class="rating-star" data-value="5" aria-label="5 stars">★</button>
                    </div>
                    <textarea id="reviews-comment" rows="3" maxlength="1000" placeholder="Tell other travelers what you loved (or what we can improve)…"></textarea>
                    <div class="reviews-form-actions">
                        <button type="button" id="reviews-submit-btn" class="catalog-cta-btn">Submit review</button>
                        <span id="reviews-form-msg" class="reviews-form-msg"></span>
                    </div>
                </div>
                <p id="reviews-login-hint" class="reviews-login-hint" hidden><a href="/login">Log in</a> to leave a review.</p>
                <p id="reviews-gate-hint" class="reviews-login-hint" hidden>Only guests who have booked this room can leave a review.</p>
            </section>
        </div>
    </div>
</div>

<div id="review-confirm-modal" class="review-confirm-modal" aria-hidden="true" role="dialog" aria-labelledby="review-confirm-title" aria-modal="true">
    <div class="review-confirm-backdrop" data-confirm-close></div>
    <div class="review-confirm-dialog" role="document">
        <h4 id="review-confirm-title">Delete your review?</h4>
        <p>This action cannot be undone. Your rating and comment will be permanently removed.</p>
        <div class="review-confirm-actions">
            <button type="button" id="review-confirm-cancel" class="review-confirm-btn-cancel" data-confirm-close>Cancel</button>
            <button type="button" id="review-confirm-ok" class="review-confirm-btn-delete">Delete</button>
        </div>
    </div>
</div>

<script>
(function () {
    var grid = document.getElementById('rooms-grid');
    if (!grid) return;
    var cards    = Array.prototype.slice.call(grid.querySelectorAll('.catalog-card'));
    var noRes    = document.querySelector('.catalog-no-results');
    var search   = document.getElementById('search-input');
    var sort     = document.getElementById('sort-by');
    var capSel   = document.getElementById('capacity-filter');
    var minP     = document.getElementById('min-price');
    var maxP     = document.getElementById('max-price');
    var clear    = document.getElementById('clear-filters');
    var amBoxes  = document.querySelectorAll('#amenities-filters input[type=checkbox]');
    var typeTabs = document.querySelectorAll('.rooms-type-tabs .type-tab');
    var currentType = grid.dataset.defaultType || '';

    function activeAmenities() {
        return Array.prototype.filter.call(amBoxes, function (c) { return c.checked; })
            .map(function (c) { return c.value; });
    }

    function applyFilters() {
        var q   = (search.value || '').toLowerCase().trim();
        var cap = capSel.value;
        var lo  = parseFloat(minP.value) || 0;
        var hi  = parseFloat(maxP.value) || Infinity;
        var ams = activeAmenities();
        var visible = 0;

        cards.forEach(function (c) {
            var name      = c.dataset.name;
            var price     = parseFloat(c.dataset.price);
            var capacity  = parseInt(c.dataset.capacity, 10);
            var amenities = (c.dataset.amenities || '').split(',').filter(Boolean);
            var types     = (c.dataset.types || '').split(',').filter(Boolean);

            var matchType   = !currentType || types.indexOf(currentType) !== -1;
            var matchSearch = !q || name.indexOf(q) !== -1;
            var matchCap    = !cap || (cap === '4' ? capacity >= 4 : capacity === parseInt(cap, 10));
            var matchPrice  = price >= lo && price <= hi;
            var matchAmen   = ams.every(function (a) { return amenities.indexOf(a) !== -1; });

            var ok = matchType && matchSearch && matchCap && matchPrice && matchAmen;
            c.style.display = ok ? '' : 'none';
            if (ok) visible++;
        });

        if (noRes) noRes.hidden = visible !== 0;
    }

    function applySort() {
        var mode = sort.value;
        if (!mode) return;
        var sorted = cards.slice().sort(function (a, b) {
            if (mode === 'price-asc')  return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            if (mode === 'price-desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            if (mode === 'rating')     return parseInt(b.dataset.rating, 10) - parseInt(a.dataset.rating, 10);
            return 0;
        });
        sorted.forEach(function (c) { grid.appendChild(c); });
    }

    typeTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            typeTabs.forEach(function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');
            currentType = tab.dataset.type || '';
            applyFilters();
        });
    });

    [search, minP, maxP].forEach(function (el) { el && el.addEventListener('input', applyFilters); });
    capSel && capSel.addEventListener('change', applyFilters);
    sort   && sort.addEventListener('change', applySort);
    amBoxes.forEach(function (b) { b.addEventListener('change', applyFilters); });
    clear && clear.addEventListener('click', function () {
        document.getElementById('rooms-filter-form').reset();
        amBoxes.forEach(function (b) { b.checked = false; });
        applyFilters();
    });

    applyFilters();

    var modal      = document.getElementById('room-detail-modal');
    var modalImg   = document.getElementById('modal-main-img');
    var modalTitle = document.getElementById('modal-title');
    var modalPrice = document.getElementById('modal-price');
    var modalDesc  = document.getElementById('modal-desc');
    var modalStat  = document.getElementById('modal-status');
    var modalAmen  = document.getElementById('modal-amenities');
    var checkin    = document.getElementById('modal-checkin');
    var checkout   = document.getElementById('modal-checkout');
    var hint       = document.getElementById('modal-availability-hint');
    var btn        = document.getElementById('modal-checkout-btn');
    var current    = null;
    var fpIn       = null;
    var fpOut      = null;
    var bookedRanges = []; // [{from:'YYYY-MM-DD', to:'YYYY-MM-DD'}]
    var API_BASE   = window.location.origin + '/maison_dune_api/public/index.php/api';

    var amenityLabels = {
        wifi: 'Wi-Fi', terrace: 'Terrace', views: 'Sea / Garden views',
        breakfast: 'Breakfast included', spa: 'Spa & Hammam access',
        bathtub: 'Freestanding bathtub', minibar: 'Complimentary minibar', butler: 'Butler service'
    };

    function addDays(dateStr, days) {
        // Use UTC to avoid timezone shifts when serializing back to YYYY-MM-DD.
        var parts = dateStr.split('-');
        var d = new Date(Date.UTC(parseInt(parts[0],10), parseInt(parts[1],10) - 1, parseInt(parts[2],10)));
        d.setUTCDate(d.getUTCDate() + days);
        var y = d.getUTCFullYear();
        var m = String(d.getUTCMonth() + 1).padStart(2, '0');
        var dd = String(d.getUTCDate()).padStart(2, '0');
        return y + '-' + m + '-' + dd;
    }

    function rangeOverlapsBooked(ci, co) {
        // ci inclusive, co exclusive (checkout day is free for next guest)
        for (var i = 0; i < bookedRanges.length; i++) {
            var r = bookedRanges[i];
            // overlap iff ci < r.to && co > r.from
            if (ci < r.to && co > r.from) return r;
        }
        return null;
    }

    function updateBooking() {
        if (!current) return;
        var ci = checkin.value, co = checkout.value;
        if (ci && co) {
            var d1 = new Date(ci), d2 = new Date(co);
            var nights = Math.ceil((d2 - d1) / 86400000);
            var conflict = rangeOverlapsBooked(ci, co);
            if (conflict) {
                modalPrice.innerHTML = '€' + current.price.toLocaleString('en-US') + ' <span>/ night</span>';
                btn.textContent = 'Dates not available';
                btn.className = 'catalog-disabled-btn full-width';
                btn.href = 'javascript:void(0)';
                return;
            }
            if (nights > 0 && current.status !== 'sold-out') {
                var total = current.price * nights;
                modalPrice.innerHTML = '€' + total.toLocaleString('en-US') + ' <span>/ ' + nights + ' night' + (nights > 1 ? 's' : '') + '</span>';
                btn.textContent = 'Reserve now';
                btn.className = 'catalog-cta-btn full-width';
                btn.href = '/checkout/?room_id=' + current.id + '&in=' + encodeURIComponent(ci) + '&out=' + encodeURIComponent(co);
                return;
            }
        }
        modalPrice.innerHTML = '€' + current.price.toLocaleString('en-US') + ' <span>/ night</span>';
        if (current.status === 'sold-out') {
            btn.textContent = 'Currently unavailable';
        } else {
            btn.textContent = 'Select valid dates';
        }
        btn.className = 'catalog-disabled-btn full-width';
        btn.href = 'javascript:void(0)';
    }

    function destroyPickers() {
        if (fpIn)  { fpIn.destroy();  fpIn  = null; }
        if (fpOut) { fpOut.destroy(); fpOut = null; }
    }

    function buildDisableForCheckin() {
        // Disable nights already booked (cannot start a stay on those dates).
        // For each range [from, to), disable [from, to-1] inclusive.
        return bookedRanges.map(function (r) {
            return { from: r.from, to: addDays(r.to, -1) };
        });
    }

    function buildDisableForCheckout(ciStr) {
        // Checkout cannot fall *strictly inside* a booked range, but can equal r.from
        // (we leave that morning, next guest arrives that afternoon).
        // So disable [from + 1day, to] inclusive.
        // Additionally, once a check-in is picked, cap checkout at the start of the
        // first booked range that begins after check-in.
        var disabled = bookedRanges.map(function (r) {
            return { from: addDays(r.from, 1), to: r.to };
        });
        if (ciStr) {
            // Disable everything before/on check-in.
            disabled.push({ from: '2000-01-01', to: ciStr });
        }
        return disabled;
    }

    function maxDateForCheckout(ciStr) {
        if (!ciStr) return null;
        var capped = null;
        bookedRanges.forEach(function (r) {
            if (r.from > ciStr) {
                if (!capped || r.from < capped) capped = r.from;
            }
        });
        return capped; // checkout can equal r.from
    }

    function initPickers() {
        if (typeof flatpickr === 'undefined') {
            // Library not loaded yet — retry shortly.
            setTimeout(initPickers, 100);
            return;
        }
        destroyPickers();
        var today = new Date().toISOString().split('T')[0];
        fpIn = flatpickr(checkin, {
            dateFormat: 'Y-m-d',
            minDate: today,
            disable: buildDisableForCheckin(),
            onChange: function (selectedDates, dateStr) {
                if (!dateStr) return;
                if (fpOut) {
                    fpOut.set('minDate', addDays(dateStr, 1));
                    fpOut.set('disable', buildDisableForCheckout(dateStr));
                    var maxD = maxDateForCheckout(dateStr);
                    fpOut.set('maxDate', maxD || null);
                    if (checkout.value && (checkout.value <= dateStr || (maxD && checkout.value > maxD))) {
                        fpOut.clear();
                    }
                }
                updateBooking();
            }
        });
        fpOut = flatpickr(checkout, {
            dateFormat: 'Y-m-d',
            minDate: addDays(today, 1),
            disable: buildDisableForCheckout(''),
            onChange: function () { updateBooking(); }
        });
    }

    function loadAvailability(slug) {
        bookedRanges = [];
        hint.textContent = 'Loading availability…';
        hint.className = 'modal-availability-hint';
        fetch(API_BASE + '/rooms/' + encodeURIComponent(slug) + '/availability', {
            headers: { 'Accept': 'application/json' }
        }).then(function (r) { return r.json(); })
        .then(function (json) {
            bookedRanges = (json && json.booked) ? json.booked : [];
            if (bookedRanges.length === 0) {
                hint.textContent = '✓ All future dates are currently available.';
                hint.className = 'modal-availability-hint is-free';
            } else {
                hint.innerHTML = '<strong>' + bookedRanges.length + ' booked period' + (bookedRanges.length > 1 ? 's' : '') + '</strong> — unavailable nights are greyed out in the calendar.';
                hint.className = 'modal-availability-hint is-partial';
            }
            initPickers();
        }).catch(function () {
            hint.textContent = 'Could not load availability — dates will be checked at checkout.';
            hint.className = 'modal-availability-hint is-error';
            initPickers();
        });
    }

    // ---------- Reviews ----------
    var reviewsList    = document.getElementById('reviews-list');
    var reviewsMeta    = document.getElementById('reviews-meta');
    var reviewsFormWrap= document.getElementById('reviews-form-wrap');
    var reviewsLoginHint = document.getElementById('reviews-login-hint');
    var reviewsGateHint  = document.getElementById('reviews-gate-hint');
    var reviewsCommentEl = document.getElementById('reviews-comment');
    var reviewsSubmitBtn = document.getElementById('reviews-submit-btn');
    var reviewsFormMsg   = document.getElementById('reviews-form-msg');
    var ratingInput      = document.getElementById('reviews-rating-input');
    var selectedRating   = 0;

    function escHtml(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function(c){return ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"})[c];}); }

    function renderStars(value, total) {
        total = total || 5;
        var full = Math.round(value);
        var out = '';
        for (var i = 1; i <= total; i++) out += (i <= full ? '★' : '☆');
        return out;
    }

    function formatDate(s) {
        if (!s) return '';
        var d = new Date(s);
        if (isNaN(d)) return s;
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    }

    function setSelectedRating(v) {
        selectedRating = v;
        Array.prototype.forEach.call(ratingInput.querySelectorAll('.rating-star'), function (b) {
            var bv = parseInt(b.dataset.value, 10);
            b.classList.toggle('is-active', bv <= v);
        });
    }

    if (ratingInput) {
        ratingInput.addEventListener('click', function (e) {
            var b = e.target.closest('.rating-star');
            if (!b) return;
            setSelectedRating(parseInt(b.dataset.value, 10));
        });
    }

    function loadReviews(slug) {
        reviewsList.innerHTML = '<p class="reviews-loading">Loading reviews…</p>';
        reviewsMeta.textContent = '';
        reviewsFormWrap.hidden = true;
        reviewsLoginHint.hidden = true;
        reviewsGateHint.hidden = true;

        var token = localStorage.getItem('maison_token');
        var headers = { 'Accept': 'application/json' };
        if (token) headers['Authorization'] = 'Bearer ' + token;

        fetch(API_BASE + '/rooms/' + encodeURIComponent(slug) + '/reviews', { headers: headers })
        .then(function (r) { return r.json(); })
        .then(function (json) {
            var d = (json && json.data) ? json.data : { count: 0, average: 0, items: [], can_review: false };
            if (d.count > 0) {
                reviewsMeta.textContent = d.average.toFixed(1) + ' / 5  ·  ' + d.count + ' review' + (d.count > 1 ? 's' : '');
                reviewsList.innerHTML = d.items.map(function (it) {
                    var del = it.is_mine
                        ? '<button type="button" class="review-delete-btn" data-id="' + it.id + '" aria-label="Delete my review">Delete</button>'
                        : '';
                    return '<article class="review-item" data-id="' + it.id + '">' +
                        '<div class="review-head"><span class="review-author">' + escHtml(it.user_name) + '</span>' +
                        '<span class="review-stars">' + renderStars(it.rating) + '</span></div>' +
                        '<time>' + escHtml(formatDate(it.created_at)) + '</time>' +
                        '<p>' + escHtml(it.comment) + '</p>' +
                        del +
                    '</article>';
                }).join('');

                // Wire delete handlers (one per owned review)
                Array.prototype.forEach.call(reviewsList.querySelectorAll('.review-delete-btn'), function (btn) {
                    btn.addEventListener('click', function () {
                        if (!current || !token) return;
                        var id = btn.getAttribute('data-id');
                        openDeleteConfirm(btn, id);
                    });
                });
            } else {
                reviewsMeta.textContent = '';
                reviewsList.innerHTML = '<p class="reviews-empty">No reviews yet for this room.</p>';
            }

            if (!token) {
                reviewsLoginHint.hidden = false;
            } else if (d.can_review) {
                reviewsFormWrap.hidden = false;
                setSelectedRating(0);
                reviewsCommentEl.value = '';
                reviewsFormMsg.textContent = '';
                reviewsFormMsg.className = 'reviews-form-msg';
            } else {
                reviewsGateHint.hidden = false;
            }
        }).catch(function () {
            reviewsList.innerHTML = '<p class="reviews-empty">Could not load reviews.</p>';
        });
    }

    // ---------- Delete confirmation modal ----------
    var confirmModal      = document.getElementById('review-confirm-modal');
    var confirmOkBtn      = document.getElementById('review-confirm-ok');
    var confirmCancelBtn  = document.getElementById('review-confirm-cancel');
    var confirmTargetBtn  = null;
    var confirmTargetId   = null;

    function openDeleteConfirm(triggerBtn, reviewId) {
        confirmTargetBtn = triggerBtn;
        confirmTargetId  = reviewId;
        if (!confirmModal) return;
        confirmModal.classList.add('is-open');
        confirmModal.setAttribute('aria-hidden', 'false');
        if (confirmOkBtn) {
            confirmOkBtn.disabled = false;
            confirmOkBtn.textContent = 'Delete';
            setTimeout(function () { confirmOkBtn.focus(); }, 30);
        }
    }

    function closeDeleteConfirm() {
        if (!confirmModal) return;
        confirmModal.classList.remove('is-open');
        confirmModal.setAttribute('aria-hidden', 'true');
        confirmTargetBtn = null;
        confirmTargetId  = null;
    }

    if (confirmModal) {
        Array.prototype.forEach.call(confirmModal.querySelectorAll('[data-confirm-close]'), function (el) {
            el.addEventListener('click', closeDeleteConfirm);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && confirmModal.classList.contains('is-open')) {
                closeDeleteConfirm();
            }
        });
    }

    if (confirmOkBtn) {
        confirmOkBtn.addEventListener('click', function () {
            if (!current || !confirmTargetId) return;
            var t = localStorage.getItem('maison_token');
            if (!t) { closeDeleteConfirm(); return; }
            var btn = confirmTargetBtn;
            confirmOkBtn.disabled = true;
            confirmOkBtn.textContent = 'Deleting…';
            if (btn) { btn.disabled = true; btn.textContent = 'Deleting…'; }
            fetch(API_BASE + '/rooms/' + encodeURIComponent(current.slug) + '/reviews/' + encodeURIComponent(confirmTargetId), {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + t
                }
            })
            .then(function (r) { return r.json().then(function (j) { return { status: r.status, body: j }; }); })
            .then(function (res) {
                if (res.status === 200 && res.body && res.body.success) {
                    closeDeleteConfirm();
                    loadReviews(current.slug);
                } else {
                    confirmOkBtn.disabled = false;
                    confirmOkBtn.textContent = 'Delete';
                    if (btn) { btn.disabled = false; btn.textContent = 'Delete'; }
                    alert((res.body && res.body.message) || 'Could not delete review.');
                }
            })
            .catch(function () {
                confirmOkBtn.disabled = false;
                confirmOkBtn.textContent = 'Delete';
                if (btn) { btn.disabled = false; btn.textContent = 'Delete'; }
                alert('Network error — could not delete review.');
            });
        });
    }

    if (reviewsSubmitBtn) {
        reviewsSubmitBtn.addEventListener('click', function () {
            if (!current) return;
            var token = localStorage.getItem('maison_token');
            if (!token) return;
            var comment = (reviewsCommentEl.value || '').trim();
            if (selectedRating < 1) {
                reviewsFormMsg.textContent = 'Please pick a rating.';
                reviewsFormMsg.className = 'reviews-form-msg is-error';
                return;
            }
            if (comment.length < 5) {
                reviewsFormMsg.textContent = 'Please write a few words.';
                reviewsFormMsg.className = 'reviews-form-msg is-error';
                return;
            }
            reviewsSubmitBtn.disabled = true;
            reviewsFormMsg.textContent = 'Submitting…';
            reviewsFormMsg.className = 'reviews-form-msg';
            fetch(API_BASE + '/rooms/' + encodeURIComponent(current.slug) + '/reviews', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({ rating: selectedRating, comment: comment })
            }).then(function (r) { return r.json().then(function (j) { return { ok: r.ok, body: j }; }); })
            .then(function (res) {
                if (res.ok && res.body.success) {
                    reviewsFormMsg.textContent = 'Thanks for your review!';
                    reviewsFormMsg.className = 'reviews-form-msg is-success';
                    loadReviews(current.slug);
                } else {
                    reviewsFormMsg.textContent = (res.body && res.body.message) || 'Could not submit review.';
                    reviewsFormMsg.className = 'reviews-form-msg is-error';
                }
            }).catch(function () {
                reviewsFormMsg.textContent = 'Network error. Please try again.';
                reviewsFormMsg.className = 'reviews-form-msg is-error';
            }).finally(function () {
                reviewsSubmitBtn.disabled = false;
            });
        });
    }

    function openModal(card) {
        var dataEl = card.querySelector('.catalog-card-data');
        if (!dataEl) return;
        try { current = JSON.parse(dataEl.textContent); } catch (e) { return; }

        modalImg.src = current.image;
        modalImg.alt = current.title;
        modalTitle.textContent = current.title;
        modalDesc.textContent = current.desc;
        modalStat.textContent = current.status_text;
        modalStat.className = 'modal-availability modal-availability-' + current.status;
        modalAmen.innerHTML = (current.amenities && current.amenities.length)
            ? current.amenities.map(function (a) { return '<li>' + (amenityLabels[a] || a) + '</li>'; }).join('')
            : '<li>Standard amenities</li>';

        checkin.value = ''; checkout.value = '';
        loadAvailability(current.slug);
        loadReviews(current.slug);
        updateBooking();

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        document.body.classList.add('room-modal-open');
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        document.body.classList.remove('room-modal-open');
        destroyPickers();
        current = null;
    }

    grid.addEventListener('click', function (e) {
        var t = e.target.closest('.catalog-view-btn');
        if (!t) return;
        var card = t.closest('.catalog-card');
        if (card) openModal(card);
    });

    modal.addEventListener('click', function (e) {
        if (e.target.dataset && 'close' in e.target.dataset) closeModal();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
})();
</script>
