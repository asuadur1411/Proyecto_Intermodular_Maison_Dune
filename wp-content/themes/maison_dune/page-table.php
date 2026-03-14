<?php get_header();?>

<section class="book-table">
    <div class="book-table-content">
        <div class="book-table-text">
            <h3>Let yourself go</h3>
            <div class="book-title">
                <h1>Unforgettable</h1>
                <h1 class="highlight">Flavour</h1>
            </div>
            <p>Experience the perfect fusion between haute Arabic cuisine and culinary tradition in an environment
                designed for the senses.</p>
            <div class="book-icons">

                <p></p>

                <p></p>
            </div>
        </div>
        <div class="book-table-form" id = "book-table-form">
            <?php if (isset($_GET['sent']) && $_GET['sent'] == 1) : ?>
            <p class="form-success">Thank you for book. Flavours are now awaiting.</p>
            <?php endif; ?>
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                <input type="hidden" name="action" value="maison_reservation">
                <p class="form-title">Reserve a Table</p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first_name" placeholder="John" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last_name" placeholder="Doe" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="john@example.com" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="+34 600 000 000">
                </div>

                <div class="form-divider"></div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" id="time" name="time" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="guests">Guests</label>
                        <select id="guests" name="guests" required>
                            <option value="" disabled selected>Select</option>
                            <option value="1">1 person</option>
                            <option value="2">2 people</option>
                            <option value="3">3 people</option>
                            <option value="4">4 people</option>
                            <option value="5">5 people</option>
                            <option value="6">6 people</option>
                            <option value="7+">7+ people</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="section">Section</label>
                        <select id="section" name="section">
                            <option value="" disabled selected>Any</option>
                            <option value="interior">Interior</option>
                            <option value="terrace">Terrace</option>
                            <option value="private">Private Room</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Special Requests</label>
                    <textarea id="notes" name="notes"
                        placeholder="Allergies, celebrations, accessibility needs..."></textarea>
                </div>

                <button type="submit" class="form-submit">Request Reservation</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer();?>