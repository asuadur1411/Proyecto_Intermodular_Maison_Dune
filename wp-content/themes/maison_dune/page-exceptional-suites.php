<?php
/* Template Name: Exceptional Suites */
get_header(); ?>

<div class="rooms-suites-hero">
    <div class="rooms-suites-hero-content"
        style="background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('<?php echo get_template_directory_uri(); ?>/assets/img/Estampado-hero-rooms.png');">
        <h1>Exceptional Suites</h1>
        <h3>The Pinnacle of Luxury</h3>
        <p>For those who seek the extraordinary. Our Exceptional Suites are true masterpieces, offering unparalleled
            grandeur, museum-quality antiques, and majestic architectural volumes that recount the noble history of
            Maison Dune.</p>
        <div class="hero-accommodations-nav">
            <hr class="separator">
            <ul class="accommodations-links">
                <li><a href="<?php echo esc_url(home_url('/rooms')); ?>">Rooms</a></li>
                <li><a href="<?php echo esc_url(home_url('/suites')); ?>">Suites</a></li>
                <li><a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>">Exceptional Suites</a></li>
            </ul>
        </div>
    </div>
</div>

<main id="main" class="site-main">

    <!-- The Royal Experience Hub -->
    <section class="royal-experience-intro">
        <div class="rx-container">
            
            <!-- Part 1: Editorial Prologue (Redesigned) -->
            <div class="rx-prologue rx-editorial">
                
                <div class="rx-ed-hero">
                    <div class="rx-ed-hero-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-11.png');">
                        <div class="rx-ed-title-box">
                            <span class="rx-eyebrow">A Class Apart</span>
                            <h2 class="rx-title">Beyond<br><em>Luxury</em></h2>
                            <div class="rx-separator"></div>
                        </div>
                    </div>
                </div>

                <div class="rx-ed-intro-block">
                    <div class="rx-ed-intro-text-card">
                        <p class="rx-dropcap-text">
                            <span class="rx-dropcap">I</span>n the heart of Maison Dune lies a collection of sanctuaries so profoundly exquisite they defy the standard vocabulary of hospitality. Originally designed as the private salons of nobility centuries ago, the Exceptional Suites have been meticulously restored to preserve an atmosphere of unfathomable grandeur and absolute silence.
                        </p>
                    </div>
                    <div class="rx-ed-intro-side-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/arc2.jpg');"></div>
                </div>

                <div class="rx-ed-story-grid">
                    <div class="rx-ed-story-content">
                        <p class="rx-ed-text-primary">
                            Every stone, every hand-carved cedarwood arch, and every intricately placed zellige tile tells a story of royal lineage. Entering an Exceptional Suite is stepping into an architectural masterpiece where museum-quality antiques coalesce with contemporary opulence.
                        </p>

                        <div class="rx-ed-quote-box">
                            <span class="quote-mark">&ldquo;</span>
                            <blockquote>
                                A sanctuary of silence where history and pure indulgence speak the same language.
                            </blockquote>
                            <cite>&mdash; The Art of Living.</cite>
                        </div>
                    </div>
                    
                    <div class="rx-ed-story-img-container">
                        <div class="rx-ed-story-img rx-ed-parallax" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-10.png');"></div>
                        <div class="rx-ed-story-text-overlay">
                            <p class="rx-ed-text-secondary">
                                Light dances generously across palatial volumes, filtering through original stained glass to illuminate spaces that feel entirely your own. Here, time slows down. <br><br>
                                Beyond the sweeping five-meter ceilings, your private terrace opens up to an endless vista. Whether it's the botanical courtyard blooming below or the snow-capped Atlas Mountains piercing the horizon, the outside world feels beautifully distant when experienced from these heights. 
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Part 2: Privilege Grid (Rich Feature Grid) -->
            <div class="rx-privileges">
                <div class="rx-section-title">
                    <h3>Signature Privileges</h3>
                    <p>Reserved explicitly for our most discerning guests.</p>
                </div>
                
                <div class="rx-grid">
                    <!-- Card 1 -->
                    <div class="rx-card">
                        <div class="rx-card-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-11.jpg');"></div>
                        <div class="rx-card-text">
                            <h4>Dedicated Butler</h4>
                            <p>Available 24/7, your personal Maître de Maison ensures every whim is anticipated. From unpacking trunks to orchestrating private rooftop dining beneath the stars, service is invisible yet omnipresent.</p>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="rx-card">
                        <div class="rx-card-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-12.png');"></div>
                        <div class="rx-card-text">
                            <h4>Private Bathhouses</h4>
                            <p>Tadelakt-lined sanctuaries featuring oversized soaking tubs, rain showers, and authentic hammam-style heating. Scented with indigenous jasmine and amber rituals crafted exclusively for Maison Dune.</p>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="rx-card">
                        <div class="rx-card-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/mosaico-arabe.jpg');"></div>
                        <div class="rx-card-text">
                            <h4>Curated Heritage</h4>
                            <p>Sleep amongst history. Each suite houses a unique collection of 19th-century Berber artifacts, hand-woven silk rugs, and hammered brass lanterns curated meticulously by local historians.</p>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="rx-card">
                        <div class="rx-card-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-14.png');"></div>
                        <div class="rx-card-text">
                            <h4>Acoustic Peace</h4>
                            <p>Thick earthen walls engineered centuries ago provide a natural acoustic barrier, ensuring absolute silence. The only sounds are the gentle murmur of courtyard fountains and the rustle of olive leaves.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Part 3: Analytics & Details -->
            <div class="rx-analytics">
                <div class="rx-stat-board">
                    <div class="rx-stat">
                        <span class="rx-stat-num">1890</span>
                        <span class="rx-stat-label">Year of Original Construction</span>
                    </div>
                    <div class="rx-stat-divider"></div>
                    <div class="rx-stat">
                        <span class="rx-stat-num">200<span class="rx-stat-sym">m²</span></span>
                        <span class="rx-stat-label">Average Private Space</span>
                    </div>
                    <div class="rx-stat-divider"></div>
                    <div class="rx-stat">
                        <span class="rx-stat-num">04</span>
                        <span class="rx-stat-label">Master Artisans per Suite</span>
                    </div>
                </div>
                
                <div class="rx-anatomy-dashboard">
                    <h3>Anatomy of the Suites</h3>
                    <div class="rx-specs-grid">
                        <div class="rx-spec-cell">
                            <span class="rx-watermark">01</span>
                            <strong>The Foyer</strong>
                            <p>A private, grand entrance ensuring complete separation from resort corridors.</p>
                        </div>
                        <div class="rx-spec-cell">
                            <span class="rx-watermark">02</span>
                            <strong>The Grand Salon</strong>
                            <p>Separate lounging areas featuring original wood-burning fireplaces and hosting tables.</p>
                        </div>
                        <div class="rx-spec-cell">
                            <span class="rx-watermark">03</span>
                            <strong>The Master Quarters</strong>
                            <p>Super-king monolithic beds layered with bespoke 800-thread Egyptian cotton.</p>
                        </div>
                        <div class="rx-spec-cell">
                            <span class="rx-watermark">04</span>
                            <strong>The Loggia</strong>
                            <p>Private, shaded outdoor terraces with panoramic views and lounge seating.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Part 4: The Sublime Elements (Sticky Stacking Cards) -->
    <section class="rx-epilogue">
        <div class="rx-epilogue-hero">
            <span class="rx-eyebrow">A Curated Journey</span>
            <h2 class="rx-title">The Rhythm of<br><em>Elegance</em></h2>
            <p class="rx-epilogue-desc">Immerse yourself in a sequence of timeless moments curated explicitly for the Exceptional Suites.</p>
        </div>

        <div class="rx-cards-stack">
            
            <!-- Complex Card 1: The Awakening -->
            <div class="rx-sticky-card">
                <div class="complex-card">
                    <div class="cc-bg-number">01</div>
                    
                    <div class="cc-info-col">
                        <div class="cc-header">
                            <h3>The Historic Volumes</h3>
                            <p>Our Exceptional Suites boast the most magnificent architectural proportions within Maison Dune. Five-meter-high ceilings adorned with original painted cedar wood frame a space where museum-quality antiques and contemporary luxury seamlessly merge.</p>
                        </div>
                        
                        <div class="cc-amenities">
                            <ul>
                                <li><span class="cc-spark">&bull;</span> Over 200m² of palatial private living space</li>
                                <li><span class="cc-spark">&bull;</span> Original 19th-century carved wood fireplaces</li>
                                <li><span class="cc-spark">&bull;</span> Museum-quality Berber textiles and antiques</li>
                            </ul>
                        </div>
                        
                        <div class="cc-artisan-note">
                            <span class="note-label">Curator's Note</span>
                            <p>&ldquo;Every piece of furniture was specifically commissioned to respect the original 1890 architectural blueprints of these particular suites.&rdquo;</p>
                        </div>
                    </div>

                    <div class="cc-visual-col">
                        <div class="cc-image-primary" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-15.png');"></div>
                    </div>
                </div>
            </div>

            <!-- Complex Card 2: The Evening Soiree (Reverse) -->
            <div class="rx-sticky-card">
                <div class="complex-card cc-reverse">
                    <div class="cc-bg-number">02</div>
                    
                    <div class="cc-info-col">
                        <div class="cc-header">
                            <h3>The Private Terraces</h3>
                            <p>Beyond the earthen walls, each Exceptional Suite opens up to an expansive, entirely secluded terrace. Unlike standard suites, these loggias provide an exclusive sanctuary elevated above the courtyard, offering undisturbed views towards the Atlas Mountains.</p>
                        </div>
                        
                        <div class="cc-amenities">
                            <ul>
                                <li><span class="cc-spark">&bull;</span> Sweeping, uncompromised panoramic views</li>
                                <li><span class="cc-spark">&bull;</span> Private outdoor dining orchestrated by your butler</li>
                                <li><span class="cc-spark">&bull;</span> Shaded lounging areas among centennial olive trees</li>
                            </ul>
                        </div>
                        
                        <div class="cc-artisan-note">
                            <span class="note-label">Architect's Note</span>
                            <p>&ldquo;We designed these grand terraces to catch the precise angle of the evening sunset, casting pure golden light across the tadelakt.&rdquo;</p>
                        </div>
                    </div>

                    <div class="cc-visual-col">
                        <div class="cc-image-primary" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/terraza.webp');"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>