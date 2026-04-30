<?php get_header(); ?>

<div class="rooms-suites-hero">
    <div class="rooms-suites-hero-content" style="background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('<?php echo get_template_directory_uri(); ?>/assets/img/Estampado-hero-rooms.png');">
        <h1>The Suites</h1>
        <h3>Expansive luxury</h3>
        <p>Step into a world of sophistication. Our suites offer generous living areas separate from the bedroom, providing a perfect residential feel.<br>Many feature private terraces overlooking the lush gardens or the Atlas Mountains.</p>
        <div class="hero-accommodations-nav">
            <hr class="separator">
            <ul class="accommodations-links">
                <li><a href="<?php echo esc_url(home_url('/rooms')); ?>">Rooms</a></li>
                <li><a href="<?php echo esc_url(home_url('/suites')); ?>" class="active">Suites</a></li>
                <li><a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>">Exceptional Suites</a></li>
            </ul>
        </div>
    </div>
</div>

<main id="main" class="site-main">
    
    <section class="suites-grand-intro">
        <div class="grand-intro-container">
            <div class="grand-text-block">
                <span class="grand-eyebrow">The Art of Living</span>
                <h2>Refined elegance<br>beyond the <em>ordinary</em></h2>
                <div class="grand-separator"></div>
                
                <p class="grand-lead">
                    <span class="dropcap">T</span>he essence of Maison Dune culminates in our collection of Suites. Formerly the private chambers of nobility, these grandiose spaces have been painstakingly restored to offer an unprecedented level of hospitality. With museum-quality antiques, breathtaking volumes, and bespoke services, each suite offers not just a stay, but a masterclass in Moroccan art de vivre.
                </p>
                
                <p class="grand-secondary-text">
                    Experience an oasis of calm where traditional craftsmanship meets contemporary comfort. Every architectural detail, from the hand-carved zellige to the intricate tadelakt walls, tells a story of centuries-old artisanal heritage.
                </p>
                
                <div class="grand-privileges-grid">
                    <div class="privilege">
                        <span class="privilege-icon">&#x2727;</span>
                        <div>
                            <h4>Absolute Privacy</h4>
                            <p>Secluded sanctuaries</p>
                        </div>
                    </div>
                    <div class="privilege">
                        <span class="privilege-icon">&#x2727;</span>
                        <div>
                            <h4>Bespoke Services</h4>
                            <p>Dedicated butler 24/7</p>
                        </div>
                    </div>
                    <div class="privilege">
                        <span class="privilege-icon">&#x2727;</span>
                        <div>
                            <h4>Panoramic Views</h4>
                            <p>Atlas & lush gardens</p>
                        </div>
                    </div>
                    <div class="privilege">
                        <span class="privilege-icon">&#x2727;</span>
                        <div>
                            <h4>Artisan Details</h4>
                            <p>Curated local heritage</p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>" class="grand-cta-btn">Discover Our Collection</a>
            </div>
            
            <div class="grand-image-block">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-8.jpg" alt="Maison Dune Suite Grand Interior" class="grand-primary-img">
                
                <div class="grand-floating-quote">
                    "A timeless retreat where every detail whispers of forgotten royal legacies and pure luxury."
                    <span class="quote-author">Travel & Leisure</span>
                </div>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-7.jpg" alt="Suite Details" class="grand-secondary-img">
            </div>
        </div>
    </section>
    <section class="suites-split-feature">
        <div class="split-feature-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/luxury_suite_half_screen.png" alt="Luxurious Suite Detail">
        </div>
        <div class="split-feature-content elegant-style-v2">
            <div class="e-wrapper">
                <div class="e-header">
                    <div class="e-meta">
                        <span class="e-number">No. 02</span>
                        <span class="e-category">Heritage</span>
                    </div>
                    <h2 class="e-title">An ode to<br><em>Craftsmanship</em></h2>
                </div>
                
                <div class="e-content-columns">
                    <div class="e-col-left">
                        <p class="e-paragraph"><span class="e-dropcap">T</span>he essence of a true sanctuary lies in its details. Every suite tells an intricate story of Moroccan artisanal heritage, where hand-carved cedarwood meets the cooling touch of authentic Zellige tiles.</p>
                        
                        <div class="e-details-box">
                            <h4>Signature Elements</h4>
                            <ul>
                                <li>Private panoramic terraces</li>
                                <li>Curated antiques</li>
                                <li>Hammered brass</li>
                                <li>Tadelakt bathhouses</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="e-col-right">
                        <div class="e-stat-block">
                            <span class="e-stat-num">120<span class="e-stat-sym">m²</span></span>
                            <span class="e-stat-desc">Of pure elegance and generous volumes</span>
                        </div>
                        
                        <p class="e-paragraph-secondary">We believe luxury is the space to breathe beautifully. The soaring ceilings and private courtyards create an atmosphere of unparalleled tranquility.</p>
                        
                        <a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>" class="discover-link">
                            Discover Suites
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="suites-interactive-canvas">
        <div class="sic-wrapper">
            <div class="sic-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/suites-exception.jpeg');"></div>
            <div class="sic-overlay"></div>
            
            <div class="sic-intro">
                <span class="sic-eyebrow">Interactive Journey</span>
                <h2>Anatomy of <em>Luxury</em></h2>
                <p>Click on the pulsing indicators to explore the meticulously crafted details of our Royal Suites.</p>
            </div>
            <button class="sic-hotspot hp-architecture" data-target="panel-architecture" aria-label="Architecture">
                <span class="sic-pulse"></span>
                <span class="sic-core"></span>
            </button>
            <button class="sic-hotspot hp-rest" data-target="panel-rest" aria-label="Master Bed">
                <span class="sic-pulse"></span>
                <span class="sic-core"></span>
            </button>
            <button class="sic-hotspot hp-craft" data-target="panel-craft" aria-label="Craftsmanship">
                <span class="sic-pulse"></span>
                <span class="sic-core"></span>
            </button>
            <div class="sic-panels-container">
                <div class="sic-panel" id="panel-architecture">
                    <button class="sic-close-btn">&times;</button>
                    <div class="sic-panel-content">
                        <span class="sic-category">01 — The Structure</span>
                        <h3 class="sic-title">Moorish <em>Architecture</em></h3>
                        <p class="sic-dropcap">Every archway and corridor in the Royal Suite has been meticulously restored to preserve its original 19th-century grandeur. The soaring five-meter ceilings construct a palace-like atmosphere, allowing air to circulate freely while creating magnificent acoustics.</p>
                        
                        <div class="sic-gallery">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-3.1.jpg" alt="Archways">
                        </div>

                        <ul class="sic-features">
                            <li><strong>Historic Layout:</strong> Original riad floor plan preserving cross-ventilation.</li>
                            <li><strong>Plaster Carvings:</strong> Hand-chiselled Geometrical motifs by Fes artisans.</li>
                            <li><strong>Natural Light:</strong> Strategically placed skylights to track the desert sun.</li>
                        </ul>
                    </div>
                </div>
                <div class="sic-panel" id="panel-rest">
                    <button class="sic-close-btn">&times;</button>
                    <div class="sic-panel-content">
                        <span class="sic-category">02 — The Sanctuary</span>
                        <h3 class="sic-title">The Master <em>Chambers</em></h3>
                        <p class="sic-dropcap">Rest is an art form. The master quarters are situated in the quietest wing, overlooking the interior botanical garden. The bed, a monolithic centerpiece, faces the main fireplace, offering unparalleled warmth during cool Atlas nights.</p>
                        
                        <div class="sic-gallery">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-9.png" alt="Bed details">
                        </div>

                        <ul class="sic-features">
                            <li><strong>Custom Mattress:</strong> Hand-tufted, organic wool and silk blends.</li>
                            <li><strong>Linens:</strong> 800-thread count Egyptian cotton woven locally.</li>
                            <li><strong>Acoustics:</strong> Tadelakt walls that naturally dampen external sound.</li>
                        </ul>
                    </div>
                </div>
                <div class="sic-panel" id="panel-craft">
                    <button class="sic-close-btn">&times;</button>
                    <div class="sic-panel-content">
                        <span class="sic-category">03 — Heritage</span>
                        <h3 class="sic-title">Master <em>Craftsmanship</em></h3>
                        <p class="sic-dropcap">Centuries of artisan tradition converge in the decorative arts of the suite. Over forty master 'maâlems' collaborated on restoring the intricate woodwork and mosaic tiling, dedicating thousands of hours to perfection.</p>
                        
                        <div class="sic-gallery">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mosaico-intro.jpg" alt="Tile details">
                        </div>

                        <ul class="sic-features">
                            <li><strong>Cedar Doors:</strong> Original hand-painted cedar from the Middle Atlas.</li>
                            <li><strong>Brass Lanterns:</strong> Custom-pierced lamps casting geometric shadows.</li>
                            <li><strong>Zellige:</strong> Authentic Fez ceramics creating mesmerizing floor patterns.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/interactive-canvas.js"></script>

    <?php
    set_query_var('current_room_type', 'suites');
    set_query_var('catalog_heading', 'Book your suite <em>now</em>');
    get_template_part('template-parts/rooms-catalog');
    ?>
</main>

<?php get_footer(); ?>
