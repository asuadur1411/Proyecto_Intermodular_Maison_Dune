<?php
/* Template Name: Checkout */
get_header();

$room_id   = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;
$checkin   = isset($_GET['in'])  ? sanitize_text_field($_GET['in'])  : '';
$checkout  = isset($_GET['out']) ? sanitize_text_field($_GET['out']) : '';

$error      = null;
$room       = null;
$nights     = 0;
$price      = 0;
$total      = 0;
$room_title = '';
$room_slug  = '';
$room_img   = '';

if (!$room_id) {
    $error = 'No room selected.';
} else {
    $room = get_post($room_id);
    if (!$room || $room->post_type !== 'room' || $room->post_status !== 'publish') {
        $error = 'The selected room is no longer available.';
    } else {
        $price        = floatval(get_post_meta($room_id, '_room_price', true));
        $room_status  = get_post_meta($room_id, '_room_status', true);
        $room_title   = get_the_title($room);
        $room_slug    = $room->post_name;
        $room_img     = has_post_thumbnail($room_id)
            ? get_the_post_thumbnail_url($room_id, 'large')
            : (get_post_meta($room_id, '_room_external_image', true) ?: get_template_directory_uri() . '/assets/img/habitaciones-1.jpg');

        if ($room_status === 'sold-out') {
            $error = 'This room is currently unavailable.';
        } elseif ($price <= 0) {
            $error = 'Pricing for this room has not been configured.';
        } else {
            $today = strtotime(date('Y-m-d'));
            $d1 = strtotime($checkin);
            $d2 = strtotime($checkout);
            if (!$d1 || !$d2) {
                $error = 'Invalid dates supplied.';
            } elseif ($d1 < $today) {
                $error = 'Check-in date cannot be in the past.';
            } elseif ($d2 <= $d1) {
                $error = 'Check-out must be after check-in.';
            } else {
                $nights = max(1, (int) round(($d2 - $d1) / 86400));
                if ($nights > 7) {
                    $error = 'The maximum stay is 7 nights. Please shorten your dates.';
                } else {
                    $total = round($price * $nights, 2);
                }
            }
        }
    }
}
?>

<div class="rooms-suites-hero checkout-hero">
    <div class="rooms-suites-hero-content" style="background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('<?php echo get_template_directory_uri(); ?>/assets/img/Estampado-hero-rooms.png');">
        <h1>Secure Checkout</h1>
        <h3>Confirm your stay</h3>
        <p>Review your reservation details and complete the payment to finalise your booking at Maison Dune.</p>
    </div>
</div>

<main class="checkout-page">
    <?php if ($error) : ?>
        <section class="checkout-error">
            <h2>Booking unavailable</h2>
            <p><?php echo esc_html($error); ?></p>
            <a href="<?php echo esc_url(home_url('/rooms')); ?>" class="checkout-btn-secondary">Back to rooms</a>
        </section>
    <?php else : ?>
    <section class="checkout-grid">
        <aside class="checkout-summary">
            <div class="checkout-summary-img" style="background-image:url('<?php echo esc_url($room_img); ?>');"></div>
            <div class="checkout-summary-body">
                <span class="checkout-eyebrow">Reservation summary</span>
                <h2><?php echo esc_html($room_title); ?></h2>
                <ul class="checkout-summary-list">
                    <li>
                        <span>Check-in</span>
                        <strong><?php echo esc_html(date('D, d M Y', strtotime($checkin))); ?></strong>
                    </li>
                    <li>
                        <span>Check-out</span>
                        <strong><?php echo esc_html(date('D, d M Y', strtotime($checkout))); ?></strong>
                    </li>
                    <li>
                        <span>Nights</span>
                        <strong><?php echo intval($nights); ?></strong>
                    </li>
                    <li>
                        <span>Rate per night</span>
                        <strong>€<?php echo number_format($price, 2); ?></strong>
                    </li>
                </ul>
                <div class="checkout-total">
                    <span>Total to pay</span>
                    <strong>€<?php echo number_format($total, 2); ?></strong>
                </div>
                <p class="checkout-summary-note">Free cancellation up to 48h before check-in. Taxes included.</p>
            </div>
        </aside>

        <div class="checkout-payment">
            <h3>Payment details</h3>
            <p class="checkout-payment-sub">Choose your preferred payment method. All transactions are encrypted.</p>

            <div class="payment-methods" role="tablist">
                <button type="button" class="pay-method is-active" data-method="card" role="tab">
                    <span class="pay-method-icon">💳</span>
                    <span class="pay-method-label">Card</span>
                </button>
                <button type="button" class="pay-method" data-method="paypal" role="tab">
                    <span class="pay-method-icon paypal-icon">PayPal</span>
                </button>
                <button type="button" class="pay-method" data-method="applepay" role="tab">
                    <span class="pay-method-icon applepay-icon"> Pay</span>
                </button>
            </div>

            <form id="payment-form" class="checkout-form" novalidate
                  data-room-slug="<?php echo esc_attr($room_slug); ?>"
                  data-room-title="<?php echo esc_attr($room_title); ?>"
                  data-checkin="<?php echo esc_attr($checkin); ?>"
                  data-checkout="<?php echo esc_attr($checkout); ?>"
                  data-total="<?php echo esc_attr($total); ?>">
                <input type="hidden" name="room_id" value="<?php echo intval($room_id); ?>">
                <input type="hidden" name="checkin" value="<?php echo esc_attr($checkin); ?>">
                <input type="hidden" name="checkout" value="<?php echo esc_attr($checkout); ?>">
                <input type="hidden" id="payment-method" name="payment_method" value="card">

                <!-- Guest details (only for PayPal / Apple Pay; for card the cardholder name is used). -->
                <div class="guest-details" id="guest-details" hidden>
                    <h4 class="guest-details-title">Guest details</h4>
                    <p class="guest-details-sub">The reservation will be issued under this name.</p>
                    <div class="form-row form-row-split">
                        <div>
                            <label for="guest-first-name">First name</label>
                            <input type="text" id="guest-first-name" placeholder="e.g. María" autocomplete="given-name" required>
                        </div>
                        <div>
                            <label for="guest-last-name">Last name(s)</label>
                            <input type="text" id="guest-last-name" placeholder="e.g. García López" autocomplete="family-name" required>
                        </div>
                    </div>
                </div>

                <div id="card-fields" class="payment-pane is-active">
                    <div class="form-row form-row-split">
                        <div>
                            <label for="card-first-name">Cardholder first name</label>
                            <input type="text" id="card-first-name" placeholder="e.g. María" autocomplete="given-name">
                        </div>
                        <div>
                            <label for="card-last-name">Cardholder last name(s)</label>
                            <input type="text" id="card-last-name" placeholder="e.g. García López" autocomplete="family-name">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="card-number">Card number</label>
                        <div class="card-input-wrap">
                            <input type="text" id="card-number" placeholder="0000 0000 0000 0000" maxlength="19" autocomplete="cc-number" inputmode="numeric">
                            <span class="card-brand" id="card-brand">card</span>
                        </div>
                    </div>

                    <div class="form-row form-row-split">
                        <div>
                            <label for="card-expiry">Expiry (MM/YY)</label>
                            <input type="text" id="card-expiry" placeholder="MM/YY" maxlength="5" autocomplete="cc-exp" inputmode="numeric">
                        </div>
                        <div>
                            <label for="card-cvc">CVC</label>
                            <input type="password" id="card-cvc" placeholder="123" maxlength="4" autocomplete="cc-csc" inputmode="numeric">
                        </div>
                    </div>
                </div>

                <div id="paypal-fields" class="payment-pane payment-pane-alt">
                    <div class="alt-pay-card paypal-card">
                        <div class="alt-pay-logo">Pay<strong>Pal</strong></div>
                        <p>You will be redirected to your PayPal account to confirm the payment of <strong>€<?php echo number_format($total, 2); ?></strong>. Your reservation will be confirmed once PayPal authorises the charge.</p>
                        <span class="alt-pay-demo-tag">Sandbox / demo mode</span>
                    </div>
                </div>

                <div id="applepay-fields" class="payment-pane payment-pane-alt">
                    <div class="alt-pay-card applepay-card">
                        <div class="alt-pay-logo applepay-logo"> Pay</div>
                        <p>Confirm your booking using <strong>Touch ID</strong> or <strong>Face ID</strong>. Maison Dune never sees your card details.</p>
                        <span class="alt-pay-demo-tag">Demo mode — no real charge</span>
                    </div>
                </div>

                <p class="form-error" id="form-error" hidden></p>

                <button type="submit" id="submit-payment" class="checkout-pay-btn">
                    Pay €<?php echo number_format($total, 2); ?>
                </button>
                <p class="checkout-status" id="payment-status"></p>
            </form>
        </div>
    </section>
    <?php endif; ?>
</main>

<!-- PayPal sandbox simulation modal -->
<div id="paypal-sandbox" class="sandbox-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="paypal-sandbox-title">
    <div class="sandbox-backdrop" data-sandbox-cancel></div>
    <div class="sandbox-dialog paypal-sandbox-dialog">
        <div class="sandbox-header paypal-header">
            <span class="sandbox-pp-logo">Pay<strong>Pal</strong></span>
            <span class="sandbox-pp-secure">🔒 Secure checkout</span>
        </div>
        <div class="sandbox-body">
            <h4 id="paypal-sandbox-title">Log in to PayPal</h4>
            <p class="sandbox-merchant">Merchant: <strong>Maison Dune</strong> · Amount: <strong id="pp-amount">€0.00</strong></p>
            <label>Email or mobile number</label>
            <input type="email" id="pp-email" value="sandbox-buyer@example.com" autocomplete="off">
            <label>Password</label>
            <input type="password" id="pp-password" value="••••••••••" autocomplete="off">
            <p class="sandbox-demo-note">⚠ Sandbox mode — no real money will be transferred.</p>
            <div class="sandbox-actions">
                <button type="button" class="sandbox-btn-cancel" data-sandbox-cancel>Cancel</button>
                <button type="button" id="pp-authorize" class="sandbox-btn-paypal">Log in &amp; Authorize</button>
            </div>
        </div>
    </div>
</div>

<!-- Apple Pay sandbox simulation modal -->
<div id="applepay-sandbox" class="sandbox-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="ap-sandbox-title">
    <div class="sandbox-backdrop" data-sandbox-cancel></div>
    <div class="sandbox-dialog applepay-sandbox-dialog">
        <div class="sandbox-header applepay-header">
            <span class="applepay-logo-big"> Pay</span>
        </div>
        <div class="sandbox-body sandbox-body-applepay">
            <h4 id="ap-sandbox-title">Confirm with Touch ID</h4>
            <div class="ap-merchant-row">
                <div>
                    <div class="ap-merchant-label">Pay Maison Dune</div>
                    <div class="ap-merchant-amount" id="ap-amount">€0.00</div>
                </div>
            </div>
            <div class="ap-card-row">
                <span class="ap-card-icon">💳</span>
                <span>Visa •••• 4242</span>
            </div>
            <div class="ap-touchid">
                <div class="ap-touchid-ring" id="ap-touchid-ring">
                    <span class="ap-touchid-icon">👆</span>
                </div>
                <p class="ap-touchid-hint" id="ap-touchid-hint">Touch the sensor to pay</p>
            </div>
            <p class="sandbox-demo-note">Demo mode — no real charge</p>
            <div class="sandbox-actions">
                <button type="button" class="sandbox-btn-cancel" data-sandbox-cancel>Cancel</button>
                <button type="button" id="ap-confirm" class="sandbox-btn-applepay">Confirm Payment</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var form = document.getElementById('payment-form');
    if (!form) return;

    var num    = document.getElementById('card-number');
    var brand  = document.getElementById('card-brand');
    var exp    = document.getElementById('card-expiry');
    var cvc    = document.getElementById('card-cvc');
    var cFirst = document.getElementById('card-first-name');
    var cLast  = document.getElementById('card-last-name');
    var gFirst = document.getElementById('guest-first-name');
    var gLast  = document.getElementById('guest-last-name');
    var err    = document.getElementById('form-error');
    var status = document.getElementById('payment-status');
    var btn    = document.getElementById('submit-payment');

    // Prefill guest name from stored user
    try {
        var storedUser = JSON.parse(localStorage.getItem('maison_user') || '{}');
        var fullStored = (storedUser.name || ((storedUser.first_name || '') + ' ' + (storedUser.last_name || ''))).trim();
        if (fullStored) {
            var parts = fullStored.split(/\s+/);
            var firstPart = parts.shift() || '';
            var lastPart  = parts.join(' ') || '';
            if (!gFirst.value) gFirst.value = firstPart;
            if (!gLast.value)  gLast.value  = lastPart;
            if (!cFirst.value) cFirst.value = firstPart;
            if (!cLast.value)  cLast.value  = lastPart;
        }
    } catch (e) {}

    function detectBrand(v) {
        if (/^4/.test(v)) return 'Visa';
        if (/^(5[1-5]|2[2-7])/.test(v)) return 'Mastercard';
        if (/^3[47]/.test(v)) return 'Amex';
        return 'card';
    }

    num.addEventListener('input', function (e) {
        var raw = e.target.value.replace(/\D/g, '').slice(0, 16);
        e.target.value = raw.replace(/(.{4})/g, '$1 ').trim();
        brand.textContent = detectBrand(raw);
    });

    exp.addEventListener('input', function (e) {
        var v = e.target.value.replace(/\D/g, '').slice(0, 4);
        if (v.length >= 3) v = v.slice(0, 2) + '/' + v.slice(2);
        e.target.value = v;
    });

    cvc.addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
    });

    function showErr(msg) {
        err.textContent = msg;
        err.hidden = false;
    }

    var methodInput = document.getElementById('payment-method');
    var methodTabs  = document.querySelectorAll('.pay-method');
    var panes       = document.querySelectorAll('.payment-pane');
    var methodLabel = { card: 'Pay', paypal: 'Continue with PayPal', applepay: 'Pay with  Pay' };

    var guestDetailsBox = document.getElementById('guest-details');

    function setMethod(m) {
        methodInput.value = m;
        methodTabs.forEach(function (t) { t.classList.toggle('is-active', t.dataset.method === m); });
        panes.forEach(function (p) { p.classList.remove('is-active'); });
        var active = document.getElementById(m + '-fields');
        if (active) active.classList.add('is-active');
        if (m === 'card') {
            btn.textContent = 'Pay €' + form.dataset.total;
        } else {
            btn.textContent = methodLabel[m] + ' — €' + form.dataset.total;
        }
        // Guest first/last name fields are only needed for PayPal / Apple Pay.
        // For card payments the cardholder name is used as the booking name.
        if (guestDetailsBox) guestDetailsBox.hidden = (m === 'card');
        err.hidden = true;
    }
    methodTabs.forEach(function (t) {
        t.addEventListener('click', function () { setMethod(t.dataset.method); });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        err.hidden = true;
        status.textContent = '';

        var method = methodInput.value;

        // First/last name only required for PayPal / Apple Pay.
        // For card we'll derive them from the cardholder name below.
        if (method !== 'card') {
            if (!gFirst.value.trim()) return showErr('Please enter your first name.');
            if (!gLast.value.trim())  return showErr('Please enter your last name(s).');
        }

        if (method === 'card') {
            if (!cFirst.value.trim()) return showErr('Please enter the cardholder first name.');
            if (!cLast.value.trim())  return showErr('Please enter the cardholder last name(s).');
            var rawNum = num.value.replace(/\s/g, '');
            if (rawNum.length < 13) return showErr('Card number is too short.');
            if (cvc.value.length < 3) return showErr('CVC must be 3 or 4 digits.');

            var parts = exp.value.split('/');
            if (parts.length !== 2) return showErr('Invalid expiry date.');
            var mm = parseInt(parts[0], 10), yy = parseInt('20' + parts[1], 10);
            var now = new Date();
            if (mm < 1 || mm > 12) return showErr('Invalid expiry month.');
            if (yy < now.getFullYear() || (yy === now.getFullYear() && mm < now.getMonth() + 1)) {
                return showErr('Card has expired.');
            }
            processReservation(method);
            return;
        }

        if (method === 'paypal') {
            openPaypalSandbox();
            return;
        }

        if (method === 'applepay') {
            openApplepaySandbox();
            return;
        }

        processReservation(method);
    });

    // ---------- Sandbox simulation modals ----------
    var ppModal      = document.getElementById('paypal-sandbox');
    var ppAmount     = document.getElementById('pp-amount');
    var ppAuthorize  = document.getElementById('pp-authorize');
    var apModal      = document.getElementById('applepay-sandbox');
    var apAmount     = document.getElementById('ap-amount');
    var apConfirm    = document.getElementById('ap-confirm');
    var apTouchRing  = document.getElementById('ap-touchid-ring');
    var apTouchHint  = document.getElementById('ap-touchid-hint');

    function openSandbox(modal) {
        if (!modal) return;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function closeSandbox(modal) {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
    function wireSandboxClose(modal) {
        if (!modal) return;
        Array.prototype.forEach.call(modal.querySelectorAll('[data-sandbox-cancel]'), function (el) {
            el.addEventListener('click', function () { closeSandbox(modal); });
        });
    }
    wireSandboxClose(ppModal);
    wireSandboxClose(apModal);

    function openPaypalSandbox() {
        if (ppAmount) ppAmount.textContent = '€' + parseFloat(form.dataset.total).toFixed(2);
        openSandbox(ppModal);
    }
    function openApplepaySandbox() {
        if (apAmount) apAmount.textContent = '€' + parseFloat(form.dataset.total).toFixed(2);
        if (apTouchRing) apTouchRing.classList.remove('is-scanning');
        if (apTouchHint) apTouchHint.textContent = 'Touch the sensor to pay';
        if (apConfirm) { apConfirm.disabled = false; apConfirm.textContent = 'Confirm Payment'; }
        openSandbox(apModal);
    }

    if (ppAuthorize) {
        ppAuthorize.addEventListener('click', function () {
            ppAuthorize.disabled = true;
            ppAuthorize.textContent = 'Authorizing…';
            setTimeout(function () {
                closeSandbox(ppModal);
                ppAuthorize.disabled = false;
                ppAuthorize.textContent = 'Log in & Authorize';
                processReservation('paypal');
            }, 900);
        });
    }

    if (apConfirm) {
        apConfirm.addEventListener('click', function () {
            apConfirm.disabled = true;
            apConfirm.textContent = 'Authenticating…';
            if (apTouchRing) apTouchRing.classList.add('is-scanning');
            if (apTouchHint) apTouchHint.textContent = 'Hold still…';
            setTimeout(function () {
                if (apTouchHint) apTouchHint.textContent = '✓ Authorized';
                setTimeout(function () {
                    closeSandbox(apModal);
                    processReservation('applepay');
                }, 350);
            }, 1100);
        });
    }

    function processReservation(method) {
        var processingLabel = ({
            card:     'Processing payment…',
            paypal:   'Redirecting to PayPal…',
            applepay: 'Confirm with Touch ID…'
        })[method] || 'Processing…';

        btn.disabled = true;
        btn.textContent = processingLabel;
        status.textContent = '';

        var resetBtn = function () {
            btn.disabled = false;
            btn.textContent = method === 'card' ? 'Pay €' + form.dataset.total : methodLabel[method] + ' — €' + form.dataset.total;
        };

        var token = localStorage.getItem('maison_token');
        if (!token) {
            resetBtn();
            showErr('Please sign in to complete your booking.');
            setTimeout(function () {
                window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname + window.location.search);
            }, 1500);
            return;
        }

        var user = {};
        try { user = JSON.parse(localStorage.getItem('maison_user') || '{}'); } catch (e) {}

        var firstName = gFirst.value.trim();
        var lastName  = gLast.value.trim();

        // For card payments, take first/last name from the card-specific fields.
        if (method === 'card') {
            firstName = cFirst.value.trim();
            lastName  = cLast.value.trim();
        }

        // Only forward a phone number if it actually matches the API rule (digits:9).
        var rawPhone = (user.phone || '').toString().replace(/\D/g, '');
        var safePhone = /^\d{9}$/.test(rawPhone) ? rawPhone : null;

        var API = window.location.origin + '/maison_dune_api/public/index.php/api';
        var payload = {
            room_slug:     form.dataset.roomSlug,
            room_title:    form.dataset.roomTitle,
            checkin_date:  form.dataset.checkin,
            checkout_date: form.dataset.checkout,
            guests:        1,
            total_price:   parseFloat(form.dataset.total),
            first_name:    firstName,
            last_name:     lastName,
            phone:         safePhone
        };

        fetch(API + '/room-reservations', {
            method: 'POST',
            headers: {
                'Content-Type':  'application/json',
                'Accept':        'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(payload)
        })
        .then(function (res) {
            return res.json().then(function (json) { return { status: res.status, body: json }; });
        })
        .then(function (r) {
            if (r.status === 401) {
                localStorage.removeItem('maison_token');
                localStorage.removeItem('maison_user');
                throw new Error('Session expired. Please sign in again.');
            }
            if (!r.body || r.body.success !== true) {
                throw new Error((r.body && r.body.message) || 'Reservation could not be saved.');
            }
            btn.style.background = '#2c8a4a';
            btn.style.borderColor = '#2c8a4a';
            btn.textContent = 'Payment confirmed';
            status.textContent = 'Reservation confirmed. Redirecting to your account…';
            status.style.color = '#2c8a4a';
            setTimeout(function () {
                window.location.href = '<?php echo esc_url(home_url('/my-reservations')); ?>';
            }, 1500);
        })
        .catch(function (err) {
            resetBtn();
            showErr(err.message || 'Something went wrong. Please try again.');
        });
    }
})();
</script>

<?php get_footer(); ?>
