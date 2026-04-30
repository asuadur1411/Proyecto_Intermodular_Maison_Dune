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
            <form id="reservation-form">
                <div id="closure-banner" class="closure-banner" style="display:none;"></div>
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
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="612345678" pattern="[0-9]{9}" maxlength="9" required>
                </div>

                <div class="form-divider"></div>

                <!-- Custom Date Picker -->
                <div class="form-group">
                    <label>Date</label>
                    <input type="hidden" id="date" name="date" required>
                    <div class="custom-date-trigger" id="date-trigger">
                        <span id="date-display">Select a date</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="3" width="14" height="12" rx="1" stroke="currentColor" stroke-width="1.2"/><line x1="1" y1="6" x2="15" y2="6" stroke="currentColor" stroke-width="1.2"/><line x1="5" y1="1" x2="5" y2="4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/><line x1="11" y1="1" x2="11" y2="4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    </div>
                    <div class="custom-calendar" id="custom-calendar">
                        <div class="cal-header">
                            <button type="button" class="cal-nav" id="cal-prev">&lsaquo;</button>
                            <span class="cal-month-year" id="cal-month-year"></span>
                            <button type="button" class="cal-nav" id="cal-next">&rsaquo;</button>
                        </div>
                        <div class="cal-weekdays">
                            <span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span><span>Su</span>
                        </div>
                        <div class="cal-days" id="cal-days"></div>
                    </div>
                </div>

                <!-- Custom Time Picker -->
                <div class="form-group">
                    <label>Time</label>
                    <input type="hidden" id="time" name="time" required>
                    <div class="time-picker" id="time-picker">
                        <div class="time-group">
                            <span class="time-group-label">Lunch</span>
                            <div class="time-slots" id="time-slots-lunch"></div>
                        </div>
                        <div class="time-group">
                            <span class="time-group-label">Dinner</span>
                            <div class="time-slots" id="time-slots-dinner"></div>
                        </div>
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

                <div id="room-number-group" class="form-group" style="display:none;">
                    <label for="room-number">Room Number</label>
                    <input type="text" id="room-number" name="room_number" placeholder="e.g. 204">
                </div>

                <div class="form-group">
                    <label for="notes">Special Requests</label>
                    <textarea id="notes" name="notes"
                        placeholder="Allergies, celebrations, accessibility needs..."></textarea>
                </div>

                <!-- Floor Plan Picker -->
                <div id="table-picker" class="table-picker" style="display:none;">
                    <label class="table-picker-label">Select a Table</label>
                    <div class="floor-plan-legend">
                        <span class="legend-item"><span class="legend-dot available"></span>Available</span>
                        <span class="legend-item"><span class="legend-dot selected"></span>Selected</span>
                        <span class="legend-item"><span class="legend-dot unavailable"></span>Occupied</span>
                    </div>
                    <div class="floor-plan-wrapper" id="floor-plan-wrapper">
                        <div class="floor-plan-tooltip" id="floor-plan-tooltip"></div>

                        <!-- INTERIOR SVG -->
                        <svg id="floor-interior" class="floor-plan-svg" viewBox="0 0 800 520" style="display:none;">
                            <!-- Background -->
                            <rect x="0" y="0" width="800" height="520" fill="#141414" rx="6"/>
                            <!-- Walls -->
                            <rect x="20" y="20" width="760" height="480" fill="none" stroke="rgba(201,185,154,0.25)" stroke-width="2" rx="4"/>
                            <!-- Windows (top wall) -->
                            <line x1="80" y1="20" x2="180" y2="20" stroke="rgba(201,185,154,0.5)" stroke-width="4"/>
                            <line x1="220" y1="20" x2="320" y2="20" stroke="rgba(201,185,154,0.5)" stroke-width="4"/>
                            <line x1="360" y1="20" x2="460" y2="20" stroke="rgba(201,185,154,0.5)" stroke-width="4"/>
                            <!-- Entrance -->
                            <rect x="620" y="480" width="100" height="20" fill="none" stroke="rgba(201,185,154,0.4)" stroke-width="1.5" stroke-dasharray="6,3" rx="2"/>
                            <text x="670" y="495" text-anchor="middle" fill="rgba(201,185,154,0.5)" font-family="Montserrat" font-size="8" letter-spacing="2">ENTRANCE</text>
                            <!-- Kitchen -->
                            <rect x="580" y="30" width="190" height="120" fill="rgba(30,30,30,0.8)" stroke="rgba(201,185,154,0.2)" stroke-width="1" rx="3"/>
                            <text x="675" y="95" text-anchor="middle" fill="rgba(201,185,154,0.35)" font-family="Montserrat" font-size="9" letter-spacing="3">KITCHEN</text>
                            <!-- Bar -->
                            <rect x="540" y="200" width="220" height="16" fill="rgba(56,50,39,0.5)" stroke="rgba(201,185,154,0.3)" stroke-width="1" rx="8"/>
                            <rect x="560" y="220" width="180" height="8" fill="rgba(56,50,39,0.3)" rx="4"/>
                            <text x="650" y="212" text-anchor="middle" fill="rgba(201,185,154,0.45)" font-family="Montserrat" font-size="7" letter-spacing="2">BAR</text>
                            <!-- WC -->
                            <rect x="30" y="400" width="80" height="80" fill="rgba(30,30,30,0.6)" stroke="rgba(201,185,154,0.15)" stroke-width="1" rx="3"/>
                            <text x="70" y="445" text-anchor="middle" fill="rgba(201,185,154,0.3)" font-family="Montserrat" font-size="8" letter-spacing="2">WC</text>

                            <!-- Table 1 — 2 seats — Window Side -->
                            <g class="floor-table" data-table="1" data-capacity="2" data-location="Window Side">
                                <rect x="70" y="55" width="50" height="50" rx="4" class="table-surface"/>
                                <circle cx="95" cy="45" r="8" class="table-chair"/>
                                <circle cx="95" cy="115" r="8" class="table-chair"/>
                                <text x="95" y="84" text-anchor="middle" class="table-label">1</text>
                            </g>
                            <!-- Table 2 — 2 seats — Window Side -->
                            <g class="floor-table" data-table="2" data-capacity="2" data-location="Window Side">
                                <rect x="200" y="55" width="50" height="50" rx="4" class="table-surface"/>
                                <circle cx="225" cy="45" r="8" class="table-chair"/>
                                <circle cx="225" cy="115" r="8" class="table-chair"/>
                                <text x="225" y="84" text-anchor="middle" class="table-label">2</text>
                            </g>
                            <!-- Table 3 — 2 seats — Window Side -->
                            <g class="floor-table" data-table="3" data-capacity="2" data-location="Window Side">
                                <rect x="330" y="55" width="50" height="50" rx="4" class="table-surface"/>
                                <circle cx="355" cy="45" r="8" class="table-chair"/>
                                <circle cx="355" cy="115" r="8" class="table-chair"/>
                                <text x="355" y="84" text-anchor="middle" class="table-label">3</text>
                            </g>

                            <!-- Table 4 — 4 seats — Main Hall -->
                            <g class="floor-table" data-table="4" data-capacity="4" data-location="Main Hall">
                                <rect x="140" y="210" width="70" height="60" rx="4" class="table-surface"/>
                                <circle cx="160" cy="200" r="8" class="table-chair"/>
                                <circle cx="190" cy="200" r="8" class="table-chair"/>
                                <circle cx="160" cy="280" r="8" class="table-chair"/>
                                <circle cx="190" cy="280" r="8" class="table-chair"/>
                                <text x="175" y="244" text-anchor="middle" class="table-label">4</text>
                            </g>
                            <!-- Table 5 — 4 seats — Main Hall -->
                            <g class="floor-table" data-table="5" data-capacity="4" data-location="Main Hall">
                                <rect x="310" y="210" width="70" height="60" rx="4" class="table-surface"/>
                                <circle cx="330" cy="200" r="8" class="table-chair"/>
                                <circle cx="360" cy="200" r="8" class="table-chair"/>
                                <circle cx="330" cy="280" r="8" class="table-chair"/>
                                <circle cx="360" cy="280" r="8" class="table-chair"/>
                                <text x="345" y="244" text-anchor="middle" class="table-label">5</text>
                            </g>

                            <!-- Table 6 — 4 seats — Near the Bar -->
                            <g class="floor-table" data-table="6" data-capacity="4" data-location="Near the Bar">
                                <rect x="525" y="270" width="70" height="60" rx="4" class="table-surface"/>
                                <circle cx="545" cy="260" r="8" class="table-chair"/>
                                <circle cx="575" cy="260" r="8" class="table-chair"/>
                                <circle cx="545" cy="340" r="8" class="table-chair"/>
                                <circle cx="575" cy="340" r="8" class="table-chair"/>
                                <text x="560" y="304" text-anchor="middle" class="table-label">6</text>
                            </g>
                            <!-- Table 7 — 4 seats — Near the Bar -->
                            <g class="floor-table" data-table="7" data-capacity="4" data-location="Near the Bar">
                                <rect x="670" y="270" width="70" height="60" rx="4" class="table-surface"/>
                                <circle cx="690" cy="260" r="8" class="table-chair"/>
                                <circle cx="720" cy="260" r="8" class="table-chair"/>
                                <circle cx="690" cy="340" r="8" class="table-chair"/>
                                <circle cx="720" cy="340" r="8" class="table-chair"/>
                                <text x="705" y="304" text-anchor="middle" class="table-label">7</text>
                            </g>

                            <!-- Table 8 — 6 seats — Private Corner -->
                            <g class="floor-table" data-table="8" data-capacity="6" data-location="Private Corner">
                                <rect x="40" y="320" width="80" height="60" rx="4" class="table-surface"/>
                                <circle cx="60" cy="310" r="8" class="table-chair"/>
                                <circle cx="100" cy="310" r="8" class="table-chair"/>
                                <circle cx="30" cy="350" r="8" class="table-chair"/>
                                <circle cx="130" cy="350" r="8" class="table-chair"/>
                                <circle cx="60" cy="390" r="8" class="table-chair"/>
                                <circle cx="100" cy="390" r="8" class="table-chair"/>
                                <text x="80" y="354" text-anchor="middle" class="table-label">8</text>
                            </g>

                            <!-- Table 9 — 6 seats — Garden View -->
                            <g class="floor-table" data-table="9" data-capacity="6" data-location="Garden View">
                                <rect x="230" y="390" width="80" height="60" rx="4" class="table-surface"/>
                                <circle cx="250" cy="380" r="8" class="table-chair"/>
                                <circle cx="290" cy="380" r="8" class="table-chair"/>
                                <circle cx="220" cy="420" r="8" class="table-chair"/>
                                <circle cx="320" cy="420" r="8" class="table-chair"/>
                                <circle cx="250" cy="460" r="8" class="table-chair"/>
                                <circle cx="290" cy="460" r="8" class="table-chair"/>
                                <text x="270" y="424" text-anchor="middle" class="table-label">9</text>
                            </g>
                            <!-- Table 10 — 6 seats — Garden View -->
                            <g class="floor-table" data-table="10" data-capacity="6" data-location="Garden View">
                                <rect x="420" y="380" width="80" height="60" rx="4" class="table-surface"/>
                                <circle cx="440" cy="370" r="8" class="table-chair"/>
                                <circle cx="480" cy="370" r="8" class="table-chair"/>
                                <circle cx="410" cy="410" r="8" class="table-chair"/>
                                <circle cx="510" cy="410" r="8" class="table-chair"/>
                                <circle cx="440" cy="450" r="8" class="table-chair"/>
                                <circle cx="480" cy="450" r="8" class="table-chair"/>
                                <text x="460" y="414" text-anchor="middle" class="table-label">10</text>
                            </g>

                            <!-- Decorative plants -->
                            <circle cx="480" cy="60" r="12" fill="none" stroke="rgba(100,140,80,0.3)" stroke-width="1"/>
                            <circle cx="480" cy="60" r="6" fill="rgba(100,140,80,0.15)"/>
                            <circle cx="30" y="160" r="12" fill="none" stroke="rgba(100,140,80,0.3)" stroke-width="1" cx="35" cy="160"/>
                            <circle cx="35" cy="160" r="6" fill="rgba(100,140,80,0.15)"/>
                        </svg>

                        <!-- TERRACE SVG -->
                        <svg id="floor-terrace" class="floor-plan-svg" viewBox="0 0 800 520" style="display:none;">
                            <!-- Background — open air -->
                            <rect x="0" y="0" width="800" height="520" fill="#0f1510" rx="6"/>
                            <!-- Railing perimeter -->
                            <rect x="20" y="20" width="760" height="480" fill="none" stroke="rgba(201,185,154,0.3)" stroke-width="2" rx="4" stroke-dasharray="12,4"/>
                            <!-- Building wall (top) -->
                            <rect x="20" y="20" width="760" height="6" fill="rgba(201,185,154,0.2)" rx="2"/>
                            <text x="400" y="15" text-anchor="middle" fill="rgba(201,185,154,0.35)" font-family="Montserrat" font-size="7" letter-spacing="3">BUILDING INTERIOR</text>
                            <!-- View label (bottom) -->
                            <text x="400" y="515" text-anchor="middle" fill="rgba(201,185,154,0.35)" font-family="Montserrat" font-size="7" letter-spacing="3" font-style="italic">&#x2014; Garden &amp; Sea View &#x2014;</text>

                            <!-- Pergola areas -->
                            <rect x="40" y="310" width="180" height="170" fill="none" stroke="rgba(201,185,154,0.15)" stroke-width="1" stroke-dasharray="8,4" rx="6"/>
                            <text x="130" y="335" text-anchor="middle" fill="rgba(201,185,154,0.25)" font-family="Montserrat" font-size="7" letter-spacing="2">PERGOLA</text>
                            <rect x="580" y="310" width="180" height="170" fill="none" stroke="rgba(201,185,154,0.15)" stroke-width="1" stroke-dasharray="8,4" rx="6"/>
                            <text x="670" y="335" text-anchor="middle" fill="rgba(201,185,154,0.25)" font-family="Montserrat" font-size="7" letter-spacing="2">PERGOLA</text>

                            <!-- Vegetation -->
                            <circle cx="50" cy="50" r="14" fill="rgba(60,100,50,0.15)" stroke="rgba(80,130,60,0.25)" stroke-width="1"/>
                            <circle cx="750" cy="50" r="14" fill="rgba(60,100,50,0.15)" stroke="rgba(80,130,60,0.25)" stroke-width="1"/>
                            <circle cx="50" cy="490" r="14" fill="rgba(60,100,50,0.15)" stroke="rgba(80,130,60,0.25)" stroke-width="1"/>
                            <circle cx="750" cy="490" r="14" fill="rgba(60,100,50,0.15)" stroke="rgba(80,130,60,0.25)" stroke-width="1"/>
                            <circle cx="400" cy="490" r="10" fill="rgba(60,100,50,0.12)" stroke="rgba(80,130,60,0.2)" stroke-width="1"/>

                            <!-- Table 11 — 2 seats — Railing View -->
                            <g class="floor-table" data-table="11" data-capacity="2" data-location="Railing View">
                                <rect x="120" y="60" width="50" height="50" rx="4" class="table-surface"/>
                                <circle cx="145" cy="50" r="8" class="table-chair"/>
                                <circle cx="145" cy="120" r="8" class="table-chair"/>
                                <text x="145" y="89" text-anchor="middle" class="table-label">11</text>
                            </g>
                            <!-- Table 12 — 2 seats — Railing View -->
                            <g class="floor-table" data-table="12" data-capacity="2" data-location="Railing View">
                                <rect x="310" y="60" width="50" height="50" rx="4" class="table-surface"/>
                                <circle cx="335" cy="50" r="8" class="table-chair"/>
                                <circle cx="335" cy="120" r="8" class="table-chair"/>
                                <text x="335" y="89" text-anchor="middle" class="table-label">12</text>
                            </g>
                            <!-- Table 13 — 2 seats — Railing View -->
                            <g class="floor-table" data-table="13" data-capacity="2" data-location="Railing View">
                                <rect x="500" y="60" width="50" height="50" rx="4" class="table-surface"/>
                                <circle cx="525" cy="50" r="8" class="table-chair"/>
                                <circle cx="525" cy="120" r="8" class="table-chair"/>
                                <text x="525" y="89" text-anchor="middle" class="table-label">13</text>
                            </g>

                            <!-- Table 14 — 4 seats — Open Air -->
                            <g class="floor-table" data-table="14" data-capacity="4" data-location="Open Air">
                                <rect x="120" y="185" width="70" height="60" rx="4" class="table-surface"/>
                                <circle cx="140" cy="175" r="8" class="table-chair"/>
                                <circle cx="170" cy="175" r="8" class="table-chair"/>
                                <circle cx="140" cy="255" r="8" class="table-chair"/>
                                <circle cx="170" cy="255" r="8" class="table-chair"/>
                                <text x="155" y="219" text-anchor="middle" class="table-label">14</text>
                            </g>
                            <!-- Table 15 — 4 seats — Open Air -->
                            <g class="floor-table" data-table="15" data-capacity="4" data-location="Open Air">
                                <rect x="360" y="185" width="70" height="60" rx="4" class="table-surface"/>
                                <circle cx="380" cy="175" r="8" class="table-chair"/>
                                <circle cx="410" cy="175" r="8" class="table-chair"/>
                                <circle cx="380" cy="255" r="8" class="table-chair"/>
                                <circle cx="410" cy="255" r="8" class="table-chair"/>
                                <text x="395" y="219" text-anchor="middle" class="table-label">15</text>
                            </g>
                            <!-- Table 16 — 4 seats — Open Air -->
                            <g class="floor-table" data-table="16" data-capacity="4" data-location="Open Air">
                                <rect x="580" y="185" width="70" height="60" rx="4" class="table-surface"/>
                                <circle cx="600" cy="175" r="8" class="table-chair"/>
                                <circle cx="630" cy="175" r="8" class="table-chair"/>
                                <circle cx="600" cy="255" r="8" class="table-chair"/>
                                <circle cx="630" cy="255" r="8" class="table-chair"/>
                                <text x="615" y="219" text-anchor="middle" class="table-label">16</text>
                            </g>

                            <!-- Table 17 — 6 seats — Pergola Shade -->
                            <g class="floor-table" data-table="17" data-capacity="6" data-location="Pergola Shade">
                                <rect x="70" y="380" width="80" height="60" rx="4" class="table-surface"/>
                                <circle cx="90" cy="370" r="8" class="table-chair"/>
                                <circle cx="130" cy="370" r="8" class="table-chair"/>
                                <circle cx="60" cy="410" r="8" class="table-chair"/>
                                <circle cx="160" cy="410" r="8" class="table-chair"/>
                                <circle cx="90" cy="450" r="8" class="table-chair"/>
                                <circle cx="130" cy="450" r="8" class="table-chair"/>
                                <text x="110" y="414" text-anchor="middle" class="table-label">17</text>
                            </g>
                            <!-- Table 18 — 6 seats — Pergola Shade -->
                            <g class="floor-table" data-table="18" data-capacity="6" data-location="Pergola Shade">
                                <rect x="610" y="380" width="80" height="60" rx="4" class="table-surface"/>
                                <circle cx="630" cy="370" r="8" class="table-chair"/>
                                <circle cx="670" cy="370" r="8" class="table-chair"/>
                                <circle cx="600" cy="410" r="8" class="table-chair"/>
                                <circle cx="700" cy="410" r="8" class="table-chair"/>
                                <circle cx="630" cy="450" r="8" class="table-chair"/>
                                <circle cx="670" cy="450" r="8" class="table-chair"/>
                                <text x="650" y="414" text-anchor="middle" class="table-label">18</text>
                            </g>

                            <!-- Umbrella symbols -->
                            <circle cx="155" cy="215" r="30" fill="none" stroke="rgba(201,185,154,0.1)" stroke-width="0.8" stroke-dasharray="4,3"/>
                            <circle cx="395" cy="215" r="30" fill="none" stroke="rgba(201,185,154,0.1)" stroke-width="0.8" stroke-dasharray="4,3"/>
                            <circle cx="615" cy="215" r="30" fill="none" stroke="rgba(201,185,154,0.1)" stroke-width="0.8" stroke-dasharray="4,3"/>
                        </svg>
                    </div>
                    <!-- Keep old grid as hidden fallback -->
                    <div id="table-grid" class="table-grid" style="display:none;"></div>
                    <div id="waitlist-box" class="waitlist-box" style="display:none;">
                        <p class="waitlist-msg">This table is currently occupied.</p>
                        <button type="button" id="btn-join-waitlist" class="btn-join-waitlist">Join Waitlist</button>
                        <p class="waitlist-hint">We will email you if this table becomes available.</p>
                    </div>
                </div>
                <input type="hidden" id="table_number" name="table_number" value="">

                <button type="submit" class="form-submit">Request Reservation</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer();?>