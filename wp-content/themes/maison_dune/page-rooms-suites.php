<?php get_header(); ?>

<div class="rooms-suites-hero">
    <div class="rooms-suites-hero-content" style="background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('<?php echo get_template_directory_uri(); ?>/assets/img/Estampado-hero-rooms.png');">
        <h1>The Sanctuaries</h1>
        <h3>Rest and disconnect</h3>
        <p>A refuge of peace. Every room and suite is meticulously designed to provide you with an intimate retreat, where Arabian heritage and modern comfort merge seamlessly.</p>
        <div class="hero-accommodations-nav">
            <hr class="separator">
            <ul class="accommodations-links">
                <li><a href="<?php echo esc_url( home_url( '/rooms' ) ); ?>">Rooms</a></li>
                <li><a href="<?php echo esc_url(home_url('/suites')); ?>">Suites</a></li>
                <li><a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>">Exceptional Suites</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="rooms-intro-title">
    <h4>The Rooms, Suites and Riads of Maison Dune</h4>
</div>

<div class="rooms-split-section">
    <div class="split-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel-7.jpg" alt="">
    </div>
    
    <div class="split-right" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/estampado-arabico-dorado-blanco.png');">
        <div class="split-right-content">
            <div class="content-inner-frame">
                <svg class="decorative-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L14.4 9.6H22L15.8 14.4L18.2 22L12 17.2L5.8 22L8.2 14.4L2 9.6H9.6L12 2Z" fill="currentColor"/>
                </svg>
                
                <span class="subtitle-text">The Maison Dune Experience</span>
                <h2>5-star luxury hotel<br>in <em>Marrakech</em></h2>
                
                <div class="elegant-separator"></div>
                
                <p><span class="dropcap">A</span>ccording to a time-honored expression in the hospitality world, Maison Dune opens its doors with 209 keys, meaning 209 carved doors adorned with knockers that symbolize authentic Moroccan hospitality.</p>
                
                <p>All of them open to magnificent spaces that pay homage to the noblest techniques of Moroccan craftsmanship: carved wood, poetic mashrabiyas playing with light and shadows, sculpted plaster, and zelliges offering a visual delight.</p>
                
                <p>Maison Dune welcomes its guests with 135 light-filled rooms, 71 suites preserving intimacy, and 3 Riads allowing the experience of a private stay away from prying eyes. All these accommodations, ideal for savoring the harmony and tranquility of the hotel at your own pace, are characterized by their refined, understated luxury, and for some, relaxing terraces with views.</p>
                
                <p>Proportions and dimensions have been designed to achieve a perfect balance between space and intimacy.</p>
                
                <div class="split-links">
                    <a href="#booking">Book your stay</a>
                    <a href="#experience">Live Maison Dune</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rooms-fullwidth-quote" style="background-color: #830202ff;">
    <div class="quote-overlay">
        <h2>The exceptional experience<br>of an unforgettable stay</h2>
    </div>
</div>

<!-- Detailed Accommodations Showcase -->
<section class="rooms-detailed-showcase" style="background-image: linear-gradient(rgba(255, 255, 255, 0.93), rgba(255, 255, 255, 0.93)), url('<?php echo get_template_directory_uri(); ?>/assets/img/poner-foto-estampado-arabe-aqui.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="rooms-detailed-header">
        <span class="subtitle">The Art of Living</span>
        <h2>A symphony of <em>elegance</em> and comfort</h2>
        <div class="separator"></div>
        <p>Discover our meticulously designed spaces where traditional Moroccan craftsmanship meets contemporary luxury. Each room and suite tells a unique story, offering an intimate sanctuary away from the vibrant energy of Marrakech.</p>
    </div>

    <!-- Habitaciones (Rooms) -->
    <div class="rooms-detailed-row">
        <div class="row-image">
            <div class="image-frame"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-2.jpg" alt="Las Habitaciones">
            <div class="floating-badge">
                <h4>The Rooms</h4>
                <p>Authentic Charm</p>
            </div>
        </div>
        <div class="row-content">
            <span class="room-category-label">Classic and Superior</span>
            <h3>Intimate refinement in every detail</h3>
            <p>Our rooms are conceived as private havens of peace. Bathed in natural light, they showcase the finest local materials: hand-carved cedar wood, traditional tadelakt walls, and bespoke zellige tiles.</p>
            <p>Every element has been carefully selected to provide an atmosphere of absolute serenity, perfect for relaxing after a day exploring the Medina.</p>>
            
            <div class="room-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M12 2A6 6 0 006 8v14h12V8a6 6 0 00-6-6zM6 14h12M12 2v20"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Medina Views</h4>
                        <p>Historic Soul</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="1"/><path d="M3 9h18M9 21V9"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>From 35 to 45 m²</h4>
                        <p>Generous Space</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M12 22a7 7 0 007-7c0-2-1-3.9-3-5.5s-3.5-4-4-7.5c-.5 3.5-2 5.9-4 7.5c-2 1.6-3 3.5-3 5.5a7 7 0 007 7z"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Tadelakt Bathrooms</h4>
                        <p>Organic Textures</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Up to 2 Guests</h4>
                        <p>Intimate Refuge</p>
                    </div>
                </div>
            </div>
            
            <a href="<?php echo esc_url(home_url('/rooms')); ?>" class="discover-link">Discover The Rooms</a>
        </div>
    </div>

    <!-- Suites -->
    <div class="rooms-detailed-row reversed">
        <div class="row-image">
            <div class="image-frame"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-3.1.jpg" alt="Las Suites">
            <div class="floating-badge">
                <h4>The Suites</h4>
                <p>Spacious Luxury</p>
            </div>
        </div>
        <div class="row-content">
            <span class="room-category-label">Deluxe and Executive</span>
            <h3>The majesty of Moroccan hospitality</h3>
            <p>Enter an expansive world of sophistication. Our suites offer generous living areas separate from the bedroom, providing a perfect residential feel. Many feature private terraces or balconies overlooking the lush gardens or the majestic Atlas Mountains.</p>
            <p>Intricate plasterwork and sumptuous fabrics create an authentically Moroccan and absolutely luxurious environment, complemented by state-of-the-art amenities.</p>
            
            <div class="room-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><circle cx="12" cy="12" r="5"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Private Terraces</h4>
                        <p>Sun and Shade</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M9.59 4.59A2 2 0 1111 8H2m10.59 11.41A2 2 0 1014 16H2m15.73-8.27A2.5 2.5 0 1119.5 13H2"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Natural Breeze</h4>
                        <p>Cross Ventilation</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>From 55 to 80 m²</h4>
                        <p>Superior Spaciousness</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M2 20h20M12 4v4M10 4h4M5 20a7 7 0 0114 0H5z"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Butler Service</h4>
                        <p>Personal Attention</p>
                    </div>
                </div>
            </div>
            
            <a href="<?php echo esc_url(home_url('/suites')); ?>" class="discover-link">Discover The Suites</a>
        </div>
    </div>

    <!-- Suites de Exception -->
    <div class="rooms-detailed-row">
        <div class="row-image">
            <div class="image-frame"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/habitaciones-4.1.jpg" alt="Las Suites de Exception">
            <div class="floating-badge">
                <h4>Exceptional Suites</h4>
                <p>The Pinnacle of Luxury</p>
            </div>
        </div>
        <div class="row-content">
            <span class="room-category-label">Signature and Royal</span>
            <h3>Incomparable majesty and prestige</h3>
            <p>For those seeking the pinnacle of luxury, our Exceptional Suites are true masterpieces. Formerly the private chambers of nobility, these grandiose spaces feature museum-quality antiques, coffered ceilings, and impressive architectural volumes.</p>
            <p>Experience Maison Dune in its maximum splendor, with access to exclusive areas, panoramic views, and a dedicated 24-hour butler to fulfill all your desires.</p>
            
            <div class="room-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><rect x="2" y="4" width="20" height="16" rx="1"/><path d="M2 16l5-5 4 4 6-6 5 5"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Premium Views</h4>
                        <p>Total Panorama</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M2.5 9L12 2l9.5 7L12 22 2.5 9z"/><path d="M2.5 9h19M12 2v20M7 6.5l5 15.5M17 6.5L12 22"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Over 100 m²</h4>
                        <p>Palatial Design</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><path d="M2 20h20M12 4v4M10 4h4M5 20a7 7 0 0114 0H5z"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>24/7 Butler</h4>
                        <p>Absolute Exclusivity</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor"><circle cx="7.5" cy="15.5" r="5.5"/><path d="M11.5 11.5L21 2v4l-3 3v3l-3 3"/></svg>
                    </div>
                    <div class="feature-text">
                        <h4>Royal Privacy</h4>
                        <p>Reserved Access</p>
                    </div>
                </div>
            </div>
            
            <a href="<?php echo esc_url(home_url('/exceptional-suites')); ?>" class="discover-link">Discover Exceptional Suites</a>
        </div>
    </div>
</section>

<!-- Banner de Reserva Final -->
<div class="rooms-booking-wrapper">
    <!-- Parte 1: Rectángulo full-width con fondo de foto -->
    <section class="rooms-booking-banner" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/patron-beige.jpg');">
        <h2>Book your stay</h2>
        <a href="#booking" class="book-btn">BOOK NOW</a>
    </section>
    
</div>

<!-- Sticky Horizontal Scroll Carousel -->
<div class="sticky-carousel-wrapper" id="sticky-carousel-wrapper">
    <div class="sticky-carousel-sticky">
        <div class="sticky-carousel-track" id="sticky-carousel-track">
            
            <!-- Slide 1 -->
            <div class="carousel-slide">
                <div class="text-col">
                    <div class="text-inner">
                        <div class="luxury-title-group">
                            <span class="chapter-number">01</span>
                            <div>
                                <span class="supratitle">Breathe the Soul of the City</span>
                                <h3>The Essence of <br><em>Maison Dune</em></h3>
                            </div>
                        </div>
                        
                        <p class="drop-cap">Stepping through the doors of Maison Dune is entering a parallel universe where time pays homage to beauty. Every corner has been designed to envelop our guests in a warm embrace of serene and impassive sophistication.</p>
                        
                        <p class="carousel-desc">Designed to maximize your comfort, our rooms integrate smart climate control and comprehensive acoustic insulation, ensuring that the only protagonist of your rest is absolute tranquility.</p>
                        
                        <div class="luxury-separator"><div class="diamond"></div></div>
                        
                        <ul class="luxury-highlights">
                            <li>
                                <div class="highlight-content">
                                    <strong>Deep Rest</strong>
                                    <span>King-size beds, 600-thread Egyptian cotton, and a pillow menu.</span>
                                </div>
                            </li>
                            <li>
                                <div class="highlight-content">
                                    <strong>Integrated Technology</strong>
                                    <span>High-speed Wi-Fi, discreet Smart TV, and international ports.</span>
                                </div>
                            </li>
                            <li>
                                <div class="highlight-content">
                                    <strong>Genuine Amenities</strong>
                                    <span>Organic amenities and complimentary artisanal coffee and tea service.</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="image-col">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel-1.jpg" alt="Exterior room view">
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-slide">
                <div class="text-col">
                    <div class="text-inner">
                        <div class="luxury-title-group">
                            <span class="chapter-number" style="color: rgba(152, 0, 0, 0.1);">02</span>
                            <div>
                                <span class="supratitle" style="color: var(--red);">Intimate and Majestic Spaces</span>
                                <h3 class="red-text">True <br><em>Absolute Privacy</em></h3>
                            </div>
                        </div>
                        
                        <p class="drop-cap red-letter">From our cozy rooms to our colossal suites and private riads, each stay pays homage to architectural grandeur elevated to maximum contemporary comfort.</p>

                        <p class="carousel-desc">The layouts naturally separate the living areas and the bedroom. Discover large independent dressing rooms and dimmable lighting to adapt the interior atmosphere to any moment of the day or evening.</p>
                        
                        <div class="luxury-quote">
                            "A sovereign refuge, where rich local craftsmanship intertwines with constant functional innovation."
                        </div>
                        
                        <div class="luxury-stats">
                            <div class="stat-item">
                                <span class="stat-number">24/7</span>
                                <span class="stat-text">In-Room<br>Service</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">100%</span>
                                <span class="stat-text">Acoustic<br>Insulation</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">TOP</span>
                                <span class="stat-text">Premium<br>Equipment</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-col">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel-3.jpg" alt="Sunset window view">
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-slide">
                <div class="text-col">
                    <div class="text-inner">
                        <div class="luxury-title-group">
                            <span class="chapter-number">03</span>
                            <div>
                                <span class="supratitle">The Zenith of Oriental Wellness</span>
                                <h3>The Art of <br><em>Contemplation</em></h3>
                            </div>
                        </div>
                        
                        <p class="drop-cap">A genuine experience is not fully assimilated without the cathartic experience of inhabiting luminous thresholds. Each room has been forged to blur the faint boundary between our imposing interiors and the superb surrounding landscape.</p>
                        
                        <p class="carousel-desc" style="margin-bottom: 2rem;">Contemplate the immensity of the surroundings in an intimate way, enjoying modern infrastructures meticulously selected to envelop you in a maximum sensation of peace and thermal restoration.</p>

                        <div class="luxury-features-grid">
                            <div class="feature-box">
                                <h4>Equipped Terraces</h4>
                                <p>Outdoor areas with exotic ergonomic furniture for enjoying in-room breakfasts.</p>
                            </div>
                            <div class="feature-box">
                                <h4>Hammam Bathrooms</h4>
                                <p>Immersive rain showers and exclusive freestanding bathtubs over tadelakt textures.</p>
                            </div>
                            <div class="feature-box">
                                <h4>Climate Control</h4>
                                <p>Integrated air purifiers and 100% silent automated thermostats.</p>
                            </div>
                            <div class="feature-box">
                                <h4>Adaptive Zones</h4>
                                <p>Private reading areas with localized dim lighting and ample support.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-col">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hotel-4.webp" alt="Interior and decorations">
                </div>
            </div>

        </div>
    </div>
</div>

<script>
/* Vincula el scroll vertical natural para crear un timeline de scroll horizontal fluido */
document.addEventListener("DOMContentLoaded", function() {
    const wrapper = document.getElementById('sticky-carousel-wrapper');
    const track = document.getElementById('sticky-carousel-track');
    const stickyContainer = document.querySelector('.sticky-carousel-sticky');
    
    if(!wrapper || !track || !stickyContainer) return;
    
    window.addEventListener('scroll', () => {
        const rect = wrapper.getBoundingClientRect();
        const wrapperTop = rect.top;
        const wrapperHeight = rect.height;
        const windowHeight = window.innerHeight;
        
        // --- 1. SOLUCIÓN AL "POSITION: STICKY" MEDIANTE JS ---
        // Esto bloquea la pantalla en el viewport ignorando el overflow de la página
        if (wrapperTop <= 0 && rect.bottom >= windowHeight) {
            // BLoqueado anclado en la ventana
            stickyContainer.style.position = 'fixed';
            stickyContainer.style.top = '0';
            stickyContainer.style.bottom = 'auto';
            stickyContainer.style.left = '0';
            stickyContainer.style.width = '100%';
            stickyContainer.style.zIndex = '50';
        } else if (rect.bottom < windowHeight) {
            // Ya pasó la sección (se engancha al fondo)
            stickyContainer.style.position = 'absolute';
            stickyContainer.style.top = 'auto';
            stickyContainer.style.bottom = '0';
            stickyContainer.style.left = '0';
            stickyContainer.style.width = '100%';
            stickyContainer.style.zIndex = '5';
        } else {
            // Aún no llega a la sección (se engancha arriba)
            stickyContainer.style.position = 'absolute';
            stickyContainer.style.top = '0';
            stickyContainer.style.bottom = 'auto';
            stickyContainer.style.left = '0';
            stickyContainer.style.width = '100%';
            stickyContainer.style.zIndex = '5';
        }
        
        // --- 2. ANIMACIÓN HORIZONTAL ---
        let scrollProgress = 0;
        
        if (wrapperTop <= 0) {
            const scrollableDistance = wrapperHeight - windowHeight;
            const scrolled = Math.abs(wrapperTop);
            scrollProgress = scrolled / scrollableDistance;
            
            // Límite entre 0 y 1
            scrollProgress = Math.max(0, Math.min(1, scrollProgress));
        }
        
        // Existen 3 pantallas. Desplazamiento máximo -200vw
        const moveX = scrollProgress * -200; 
        
        if (wrapperTop <= windowHeight && rect.bottom >= 0) {
             track.style.transform = `translateX(${moveX}vw)`;
        }
    });
    
    // Aplicar los cálculos nada más cargar para colocarlo en su sitio original
    window.dispatchEvent(new Event('scroll'));
});
</script>

<?php get_footer(); ?>