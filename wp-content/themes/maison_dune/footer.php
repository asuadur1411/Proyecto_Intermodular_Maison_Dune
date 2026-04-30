<footer class="site-footer">
    <div class="footer-newsletter">
        <div class="newsletter-wrapper">
            <span class="newsletter-supratitle">Maison Dune Journal</span>
            <h3>Discover Our Secrets</h3>
            <p>Subscribe to receive exclusive invitations, stories from Marrakech and reserved privileges.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>
    
    <div class="footer-separator"><div class="diamond"></div></div>
    
    <div class="footer-main">
        <div class="footer-column brand-col">
            <div class="footer-logo">MAISON <span>DUNE</span></div>
            <p class="brand-desc">A sanctuary of peace in the vibrant heart of Marrakech. Where Arab heritage and the utmost contemporary comfort converge in sublime harmony.</p>
            <div class="brand-address">
                <strong>Location</strong>
                <span>Hivernage, Avenue Echouhada<br>40000 Marrakech, Morocco</span>
            </div>
        </div>
        
        <div class="footer-column links-col">
            <h4>Explore</h4>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/rooms')); ?>">Rooms & Suites</a></li>
                <li><a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>">Private Riads</a></li>
                <li><a href="<?php echo esc_url(home_url('/restaurant')); ?>">Gastronomy</a></li>
                <li><a href="<?php echo esc_url(home_url('/room-service')); ?>">Spa & Wellness</a></li>
                <li><a href="<?php echo esc_url(home_url('/events')); ?>">Experiences</a></li>
            </ul>
        </div>
        
        <div class="footer-column contact-col">
            <h4>Contact</h4>
            <ul>
                <li><a href="tel:+212524459000">+212 (0) 5 24 45 90 00</a></li>
                <li><a href="mailto:contact@maisondune.com">contact@maisondune.com</a></li>
                <li><a href="mailto:reservations@maisondune.com">reservations@maisondune.com</a></li>
                <br>
                <li><a href="#map" class="map-link">View on map</a></li>
            </ul>
        </div>
        
        <div class="footer-column social-col">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <a href="#" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
                <a href="#" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                </a>
                <a href="#" aria-label="Pinterest">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.25 2.64 7.9 6.38 9.38-.08-.79-.15-2 .03-2.87.16-.76 1.05-4.46 1.05-4.46s-.26-.53-.26-1.3c0-1.22.7-2.14 1.58-2.14.74 0 1.1.56 1.1 1.25 0 .74-.47 1.86-.72 2.89-.2.86.43 1.56 1.28 1.56 1.53 0 2.72-1.62 2.72-3.96 0-2.07-1.48-3.52-3.62-3.52-2.48 0-3.95 1.86-3.95 3.8 0 .75.29 1.55.65 1.99.07.08.08.16.06.24-.06.26-.2.8-.23.94-.03.13-.1.16-.24.09C6.67 14.7 6.1 13 6.1 11.4c0-2.52 1.83-4.83 5.28-4.83 2.77 0 4.93 1.98 4.93 4.63 0 2.76-1.74 4.97-4.16 4.97-.81 0-1.58-.42-1.84-.92l-.5 1.9c-.18.7-.68 1.58-1 2.12.87.26 1.78.4 2.74.4 5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>
                </a>
            </div>
            
            <div class="awards">
                <div class="award-badge">Condé Nast<br><strong>Gold List 2026</strong></div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> Maison Dune Marrakech. All rights reserved.
        </div>
        <div class="legal-links">
            <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
            <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Terms & Conditions</a>
            <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Cookie Policy</a>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>