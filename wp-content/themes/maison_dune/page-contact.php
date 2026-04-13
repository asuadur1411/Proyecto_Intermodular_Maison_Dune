<?php get_header();?>

<section class="intro-contact">
    <div class="contact-title">
        <h1>Contact Us</h1>
        <p>We're here to serve you. Reserve your table or tell us about your experience in an atmosphere where tradition
            and flavor meet.</p>
        <div class="line"></div>
    </div>

    <div class="contact-info">
        <div class="contact-info-title">
            <h3>Paradise</h3>
            <h1>Touching God's heaven</h1>
            <p>Maison Dune offers an experience that transcends time. Inspired by the rich Nasrid heritage, our services
                are a tribute to the roots that have defined our culture for centuries.</p>
        </div>
    </div>
</section>

<section class="contact-form">
    <div class="contact-form-content">

        <div class="contact-form-text">
            <?php if (isset($_GET['sent']) && $_GET['sent'] == 1) : ?>
            <p class="form-success">Your message has been sent. We'll get back to you soon.</p>
            <?php endif; ?>
            <form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
                <input type="hidden" name="action" value="maison_contact">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="johndoe@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject" required>
                        <option value="" disabled selected>Select a reason</option>
                        <option value="reservation">Reservation Inquiry</option>
                        <option value="info">General Information</option>
                        <option value="feedback">Feedback</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Write your message here..." rows="5"
                        required></textarea>
                </div>
                <div class="form-group form-checkbox">
                    <input type="checkbox" id="privacy" name="privacy" required>
                    <label for="privacy">I have read and accept the <a href="/privacy-policy">Privacy Policy</a></label>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="contact-form-image">
            <div class="image-up"></div>
            <div class="image-down">
                <div class="image-down-info">
                    <h3>Private Arrival</h3>
                    <p>For guests requiring maximum discretion, we offer a private entrance and direct valet parking
                        service to your suite. Please contact our security team in advance.</p>
                </div>
                <div class="image-down-info">
                    <h3>Private Events</h3>
                    <a href="">proyectomaison20@gmail.com</a>
                </div>
                <div class="image-down-info">
                    <h3>Address</h3>
                    <p>St. Guadix 18690, Almuñecar · Granada</p>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="faq">
    <div class="faq-header">
        <span class="faq-label">Guest Information</span>
        <h2>Frequently Asked Questions</h2>
        <div class="line"></div>
    </div>

    <ul class="faq-list">

        <li class="faq-item">
            <button class="faq-question">
                What time is check-in and check-out?
                <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Check-in is available from 3:00 PM onwards. Check-out is until 12:00 PM (noon). Early check-in and
                    late check-out may be arranged upon request, subject to availability. Please contact our front desk
                    team in advance.
                </div>
            </div>
        </li>

        <li class="faq-item">
            <button class="faq-question">
                Is breakfast included in the room rate?
                <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Breakfast is included in select room packages. Our restaurant serves a full à la carte breakfast
                    from 7:30 AM to 11:00 AM daily, featuring locally sourced seasonal produce. When booking, you can
                    choose to add our breakfast package for a curated morning experience.
                </div>
            </div>
        </li>

        <li class="faq-item">
            <button class="faq-question">
                Do you have parking facilities on site?
                <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Yes, we offer private parking for our guests. Spaces are available on a first-come, first-served
                    basis and must be reserved in advance. Please inform us of your vehicle details when making your
                    reservation.
                </div>
            </div>
        </li>

        <li class="faq-item">
            <button class="faq-question">
                Are pets allowed at the hotel?
                <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    We welcome well-behaved pets in selected rooms. A small additional fee applies per night. Pets
                    should not be left unattended and must be kept on a lead in communal areas. Please mention your pet
                    when booking.
                </div>
            </div>
        </li>

        <li class="faq-item">
            <button class="faq-question">
                What is your cancellation policy?
                <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Reservations may be cancelled free of charge up to 48 hours before arrival. Cancellations within 48
                    hours will incur a charge equivalent to one night's stay. Non-refundable rates are not eligible for
                    cancellation or modification.
                </div>
            </div>
        </li>

    </ul>
</section>

<?php get_footer();?>