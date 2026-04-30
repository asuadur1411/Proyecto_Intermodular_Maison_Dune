<?php
get_header();
?>

<div class="rooms-suites-hero">
    <div class="rooms-suites-hero-content" style="background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('<?php echo get_template_directory_uri(); ?>/assets/img/Estampado-hero-rooms.png');">
        <h1>The Rooms</h1>
        <h3>A refuge of peace</h3>
        <p>Our rooms are designed as intimate havens of serenity. Bathed in natural light, they showcase the finest local materials: cedar wood, tadelakt, and bespoke zellige.</p>
        <div class="hero-accommodations-nav">
            <hr class="separator">
            <ul class="accommodations-links">
                <li><a href="<?php echo esc_url(home_url('/rooms')); ?>" class="active">Rooms</a></li>
                <li><a href="<?php echo esc_url(home_url('/suites')); ?>">Suites</a></li>
                <li><a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>">Exceptional Suites</a></li>

            </ul>
        </div>
    </div>
</div>

<main id="main" class="site-main">
    <section class="rooms-editorial-intro">
        <div class="editorial-container">
            <div class="editorial-image-wrapper">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel-6.jpg" alt="Maison Dune Rooms Experience">
            </div>
            <div class="editorial-text-wrapper">
                <span class="intro-eyebrow">A new standard</span>
                <h2>Authentic luxury<br>in every <em>detail</em></h2>
                <div class="vertical-line"></div>
                <p>Our rooms are an extension of the soul of Marrakech: spaces where ancestral local craftsmanship meets contemporary refinement to forge an incomparable stay.</p>
                <p>Discover an environment carefully orchestrated to slow down time, where authentic cedar wood, intricate zellige, and warm tadelakt walls wrap you in an atmosphere of absolute peace. The proportions and dimensions have been designed to achieve a perfect balance between space and intimacy.</p>
                <span class="intro-signature">Maison Dune</span>
            </div>
        </div>
    </section>

    <section class="rooms-dark-intro" style="background-image: linear-gradient(rgba(11, 11, 11, 0.95), rgba(11, 11, 11, 0.95)), url('<?php echo get_template_directory_uri(); ?>/assets/img/estampado-negro-dorado.png');">
        <div class="dark-intro-container">
            <div class="dark-intro-text">
                <span class="dark-eyebrow">Luxury Accommodation</span>
                <h2>Classic, SupÃ©rior &<br>Deluxe Rooms</h2>
                <div class="dark-separator-line"></div>
                <p class="intro-lead"><span class="dropcap">L</span>ocated on different floors of the hotel, our rooms are meticulously designed down to the smallest detail to make your stay pleasant and unforgettable.</p>
                <p class="dark-details-text">Thanks to their views, either of the Hivernage area or the Koutoubia mosque, some with terraces to read or relax, their comfort and sweetness, the rooms at Maison Dune are sumptuous invitations to stop time in the most delicious way possible.</p>
                
                <div class="dark-features-grid">
                    <div class="dark-feature">
                        <span class="feature-title">Panoramic Views</span>
                        <span class="feature-value">Gardens and Koutoubia</span>
                    </div>
                    <div class="dark-feature">
                        <span class="feature-title">Your Refuge</span>
                        <span class="feature-value">Private Terraces</span>
                    </div>
                </div>
            </div>
            <div class="dark-intro-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-6.webp" alt="Views from the rooms">
            </div>
        </div>
    </section>
    <section class="rooms-bento-section">
        <div class="bento-header">
            <span class="bento-eyebrow">Exclusive Collection</span>
            <h2>Design, Comfort and <em>Legacy</em></h2>
            <div class="bento-separator"></div>
        </div>
        <div class="luxury-bento-container">
            <div class="bento-box bento-image-main">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-1.jpg" alt="Classic Room">
                <div class="bento-badge">Classic Rooms</div>
            </div>
            <div class="bento-box bento-text-main">
                <h3>Refuge of Serenity</h3>
                <p>Designed for those who appreciate discreet elegance. Neutral tones, genuine Fez zellige, and carved woodwork envelop these spaces in an atmosphere of immediate peace after the bustle of the vibrant Marrakech medina. Experience authentic Moroccan hospitality.</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="discover-link">
                    Secure your reservation
                </a>
            </div>
            <div class="bento-box bento-info-dark">
                <h4>Details</h4>
                <ul class="bento-specs">
                    <li><span class="spec-label">Area</span> <span class="spec-value">28 - 35 mÂ²</span></li>
                    <li><span class="spec-label">Bed</span> <span class="spec-value">Premium King</span></li>
                    <li><span class="spec-label">Views</span> <span class="spec-value">Andalusian Patio</span></li>
                    <li><span class="spec-label">Occupancy</span> <span class="spec-value">2 Adults</span></li>
                </ul>
            </div>
            <div class="bento-box bento-services">
                <h4>Privileges</h4>
                <ul class="services-list">
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> In-Room Breakfast</li>
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Spa & Hammam Access</li>
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Complimentary Minibar</li>
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Nespresso Vertuo Machine</li>
                </ul>
            </div>
            <div class="bento-box bento-bathroom">
                <h4>En-Suite Wellness</h4>
                <p>Private oasis entirely clad in traditional tadelakt. Features an immersive rain shower, anti-fog heated mirror, and sumptuous artisanal botanical bath products.</p>
            </div>
            <div class="bento-box bento-quote">
                <p>"True luxury lies in the harmony of space, the unblemished silence, and the exquisite treatment of details."</p>
                <span class="quote-author">â€” Maison Dune Design</span>
            </div>
            <div class="bento-box bento-image-small">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-5.jpg" alt="Classic Room Detail">
            </div>
        </div>
        <div class="luxury-bento-container reverse">
            <div class="bento-box bento-text-main">
                <h3>Luminosity and Spaciousness</h3>
                <p>Our SupÃ©rior Rooms open their impeccable large windows to the lush botanical gardens or the iconic views of Hivernage. The polished marble floor and opulent noble fabrics create a true atmosphere of palatial luxury.</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="discover-link">
                    Secure your reservation
                </a>
            </div>
            <div class="bento-box bento-image-main">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-3.webp" alt="SupÃ©rior Room">
                <div class="bento-badge">SupÃ©rior Rooms</div>
            </div>
            <div class="bento-box bento-services">
                <h4>Privileges</h4>
                <ul class="services-list">
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Private Check-In</li>
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Butler Available</li>
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> International Press</li>
                    <li><svg class="service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Packing/Unpacking</li>
                </ul>
            </div>
            <div class="bento-box bento-info-dark">
                <h4>Details</h4>
                <ul class="bento-specs">
                    <li><span class="spec-label">Area</span> <span class="spec-value">40 - 45 mÂ²</span></li>
                    <li><span class="spec-label">Bed</span> <span class="spec-value">King Size or Twin</span></li>
                    <li><span class="spec-label">Views</span> <span class="spec-value">Hivernage Gardens</span></li>
                    <li><span class="spec-label">Occupancy</span> <span class="spec-value">Up to 3 People</span></li>
                </ul>
            </div>
            <div class="bento-box bento-image-small">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/luxury_suite_half_screen.png" alt="SupÃ©rior Bathroom Detail">
            </div>
            <div class="bento-box bento-quote">
                <p>"More than a room, an elevated sanctuary where light dances, caressing sumptuous textures and impeccable finishes."</p>
                <span class="quote-author">â€” Exclusive Traveler Guide</span>
            </div>
            <div class="bento-box bento-bathroom">
                <h4>En-Suite Wellness</h4>
                <p>Majestic bathroom bathed in natural light. Enjoy its imposing freestanding carved marble bathtub, pre-heated floor, and extremely dense pure cotton bathrobes.</p>
            </div>
        </div>
    </section>
    <?php
    set_query_var('current_room_type', 'classic-rooms');
    set_query_var('catalog_heading', 'Book your room <em>now</em>');
    get_template_part('template-parts/rooms-catalog');
    ?>

    <section class="rooms-booking-cta" style="background-color: #830202;">
        <div class="booking-cta-content">
            <h2>Book your stay</h2>
            <a href="<?php echo esc_url(home_url('/contact')); ?>">BOOK NOW</a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
