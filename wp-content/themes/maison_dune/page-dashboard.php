<?php
/* Template Name: Admin Dashboard */
get_header();
?>

<section class="dash-hero">
  <div class="dash-hero-overlay"></div>
  <div class="dash-hero-content">
    <span class="dash-eyebrow">Administration</span>
    <h1>Maison Dune <em>Analytics</em></h1>
    <p>Real-time insights into your hotel's performance</p>
  </div>
</section>

<div class="dash-loading" id="dash-loader">
  <div class="dash-loading-dots">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <span class="dash-loading-text">Loading analytics</span>
</div>

<!-- Skeleton placeholder while data loads -->
<main class="dash-skeleton" id="dashboard-skeleton" style="display:none;">
  <div class="sk-kpi-row">
    <div class="sk-kpi"></div><div class="sk-kpi"></div><div class="sk-kpi"></div><div class="sk-kpi"></div><div class="sk-kpi"></div>
  </div>
  <div class="sk-charts-row">
    <div class="sk-chart"></div><div class="sk-chart"></div>
  </div>
  <div class="sk-charts-row sk-charts-triple">
    <div class="sk-chart"></div><div class="sk-chart"></div><div class="sk-chart"></div>
  </div>
</main>

<main class="dash-main" id="dashboard-app" style="display:none;">

  <section class="dash-kpi-row dash-hidden">
    <a href="<?php echo admin_url('admin.php?page=maison-reservations'); ?>" class="dash-kpi" style="text-decoration:none;color:inherit;">
      <span class="kpi-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      </span>
      <div class="kpi-body">
        <span class="kpi-value" id="kpi-active">—</span>
        <span class="kpi-label">Active Reservations</span>
      </div>
    </a>
    <div class="dash-kpi">
      <span class="kpi-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </span>
      <div class="kpi-body">
        <span class="kpi-value" id="kpi-today">—</span>
        <span class="kpi-label">Today's Reservations</span>
      </div>
    </div>
    <div class="dash-kpi">
      <span class="kpi-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </span>
      <div class="kpi-body">
        <span class="kpi-value" id="kpi-guests">—</span>
        <span class="kpi-label">Expected Guests</span>
      </div>
    </div>
    <div class="dash-kpi">
      <span class="kpi-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </span>
      <div class="kpi-body">
        <span class="kpi-value" id="kpi-users">—</span>
        <span class="kpi-label">Registered Users</span>
      </div>
    </div>
    <a href="<?php echo admin_url('admin.php?page=maison-contact'); ?>" class="dash-kpi" style="text-decoration:none;color:inherit;">
      <span class="kpi-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      </span>
      <div class="kpi-body">
        <span class="kpi-value" id="kpi-messages">—</span>
        <span class="kpi-label">Contact Messages</span>
      </div>
    </a>
  </section>

  <section class="dash-section-label dash-hidden">
    <span class="dash-section-eyebrow">Performance</span>
    <h2>Reservation <em>Trends</em></h2>
    <div class="dash-separator"></div>
  </section>

  <section class="dash-charts-grid dash-hidden">
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Reservations by Day</h3>
        <span class="chart-badge">14 days</span>
      </div>
      <div class="chart-canvas-wrap">
        <canvas id="chart-reservations"></canvas>
      </div>
    </div>
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Guests by Day</h3>
        <span class="chart-badge">14 days</span>
      </div>
      <div class="chart-canvas-wrap">
        <canvas id="chart-guests"></canvas>
      </div>
    </div>
  </section>

  <section class="dash-charts-grid dash-charts-triple dash-hidden">
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Peak Hours</h3>
        <span class="chart-badge">Upcoming</span>
      </div>
      <div class="chart-canvas-wrap">
        <canvas id="chart-hours"></canvas>
      </div>
    </div>
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Section Distribution</h3>
        <span class="chart-badge">Active</span>
      </div>
      <div class="chart-canvas-wrap chart-canvas-doughnut">
        <canvas id="chart-sections"></canvas>
      </div>
    </div>
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Table Occupancy</h3>
        <span class="chart-badge">7 days</span>
      </div>
      <div class="chart-canvas-wrap">
        <canvas id="chart-tables"></canvas>
      </div>
    </div>
  </section>

  <section class="dash-section-label dash-hidden">
    <span class="dash-section-eyebrow">Growth</span>
    <h2>User <em>Registration</em></h2>
    <div class="dash-separator"></div>
  </section>

  <section class="dash-charts-grid dash-charts-full dash-hidden">
    <div class="dash-chart-card dash-chart-wide">
      <div class="chart-card-header">
        <h3>Cumulative User Growth</h3>
        <span class="chart-badge">30 days</span>
      </div>
      <div class="chart-canvas-wrap">
        <canvas id="chart-users"></canvas>
      </div>
    </div>
  </section>

  <section class="dash-section-label dash-hidden">
    <span class="dash-section-eyebrow">Management</span>
    <h2>Restaurant <em>Closure</em></h2>
    <div class="dash-separator"></div>
  </section>

  <section class="dash-closure dash-hidden">
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Disable Reservations</h3>
        <span class="chart-badge">Schedule</span>
      </div>
      <div class="closure-form">
        <div class="closure-fields">
          <div class="closure-field">
            <label for="closure-from">From</label>
            <input type="date" id="closure-from">
          </div>
          <div class="closure-field">
            <label for="closure-to">To</label>
            <input type="date" id="closure-to">
          </div>
          <div class="closure-field closure-field-reason">
            <label for="closure-reason">Reason (optional)</label>
            <input type="text" id="closure-reason" placeholder="e.g. Maintenance, Private Event...">
          </div>
          <button id="btn-add-closure" class="closure-btn">Disable Reservations</button>
        </div>
      </div>
      <div id="closure-list" class="closure-list"></div>
    </div>
  </section>

  <!-- Check-in QR -->
  <section class="dash-section-label dash-hidden">
    <span class="dash-section-eyebrow">Arrivals</span>
    <h2>Guest <em>Check-In</em></h2>
    <div class="dash-separator"></div>
  </section>

  <section class="dash-checkin-section dash-hidden">
    <div class="dash-chart-card dash-checkin-card">
      <div class="chart-card-header">
        <h3>Scan Guest QR</h3>
        <span class="chart-badge">Camera / manual code</span>
      </div>
      <div class="checkin-grid">
        <div class="checkin-scanner">
          <div id="checkin-reader"></div>
          <div class="checkin-scanner-hint" id="checkin-hint">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14" y2="14.01"/><line x1="18" y1="14" x2="18" y2="14.01"/><line x1="14" y1="18" x2="14" y2="18.01"/><line x1="18" y1="18" x2="18" y2="18.01"/></svg>
            <span>Click "Start scanner" to activate the camera</span>
          </div>
          <div class="checkin-scanner-actions">
            <button type="button" class="checkin-btn checkin-btn-primary" id="checkin-start">Start scanner</button>
            <button type="button" class="checkin-btn checkin-btn-secondary" id="checkin-stop" style="display:none;">Stop</button>
          </div>
        </div>
        <div class="checkin-manual">
          <label class="checkin-label" for="checkin-code">Or enter confirmation code</label>
          <div class="checkin-input-row">
            <input type="text" id="checkin-code" placeholder="MD-00123" autocomplete="off">
            <button type="button" class="checkin-btn checkin-btn-primary" id="checkin-lookup">Find</button>
          </div>
          <div class="checkin-result" id="checkin-result">
            <div class="checkin-empty">No reservation loaded. Scan a QR code or enter a confirmation code.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Live Floor Plan -->
  <section class="dash-section-label dash-hidden">
    <span class="dash-section-eyebrow">Real Time</span>
    <h2>Live <em>Floor Plan</em></h2>
    <div class="dash-separator"></div>
  </section>

  <section class="dash-live-floor dash-hidden">
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Restaurant Occupancy</h3>
        <span class="chart-badge live-badge"><span class="live-dot"></span>LIVE</span>
      </div>
      <div class="live-floor-tabs">
        <button class="live-floor-tab active" data-section="interior">Indoor</button>
        <button class="live-floor-tab" data-section="terrace">Terrace</button>
      </div>
      <div class="live-floor-legend">
        <span class="legend-item"><span class="legend-dot free"></span>Free</span>
        <span class="legend-item"><span class="legend-dot upcoming"></span>Reserved (next hour)</span>
        <span class="legend-item"><span class="legend-dot occupied"></span>Occupied now</span>
      </div>
      <div class="live-floor-wrapper">
        <div class="live-floor-tooltip" id="live-floor-tooltip"></div>
        <div class="live-floor-grid" id="live-floor-interior" data-section="interior"></div>
        <div class="live-floor-grid" id="live-floor-terrace" data-section="terrace" style="display:none;"></div>
      </div>
      <div class="live-floor-stats">
        <div class="live-stat"><span class="live-stat-value" id="live-stat-free">—</span><span class="live-stat-label">Free</span></div>
        <div class="live-stat"><span class="live-stat-value" id="live-stat-upcoming">—</span><span class="live-stat-label">Upcoming</span></div>
        <div class="live-stat"><span class="live-stat-value" id="live-stat-occupied">—</span><span class="live-stat-label">Occupied</span></div>
        <div class="live-stat"><span class="live-stat-value" id="live-stat-updated">—</span><span class="live-stat-label">Last update</span></div>
      </div>
    </div>
  </section>

  <!-- Reservations Calendar -->
  <section class="dash-section-label dash-hidden">
    <span class="dash-section-eyebrow">Schedule</span>
    <h2>Reservations <em>Calendar</em></h2>
    <div class="dash-separator"></div>
  </section>

  <section class="dash-calendar-section dash-hidden">
    <div class="dash-chart-card">
      <div class="chart-card-header">
        <h3>Upcoming Bookings</h3>
        <span class="chart-badge">Drag to reschedule visually</span>
      </div>
      <div class="dash-calendar-legend" style="display:flex;flex-wrap:wrap;gap:14px;align-items:center;padding:10px 4px 14px;font-size:12px;color:#555;">
        <span style="font-weight:600;letter-spacing:.5px;text-transform:uppercase;color:#888;">Legend:</span>
        <span style="display:inline-flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;background:#ffcf7b;border-radius:2px;display:inline-block;"></span>Restaurant · Interior</span>
        <span style="display:inline-flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;background:#7dd87d;border-radius:2px;display:inline-block;"></span>Restaurant · Terrace</span>
        <span style="display:inline-flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;background:#c76f6f;border-radius:2px;display:inline-block;"></span>Restaurant · Private</span>
        <span style="display:inline-flex;align-items:center;gap:6px;"><span style="width:14px;height:14px;background:#1a1a1a;border:2px solid #c9a84c;border-radius:2px;display:inline-block;"></span><strong style="color:#c9a84c;">★ Event</strong></span>
      </div>
      <div id="dash-calendar"></div>
    </div>
  </section>

  <!-- Closure confirmation modal -->
  <div id="closure-modal" class="closure-modal" style="display:none;">
    <div class="closure-modal-content">
      <h3>Confirm Closure</h3>
      <p id="closure-modal-msg"></p>
      <div class="closure-modal-actions">
        <button id="closure-modal-cancel" class="closure-modal-btn cancel">Cancel</button>
        <button id="closure-modal-confirm" class="closure-modal-btn confirm">Disable Reservations</button>
      </div>
    </div>
  </div>

  <!-- Generic info modal (replaces alert) -->
  <div id="dash-info-modal" class="closure-modal" style="display:none;">
    <div class="closure-modal-content">
      <h3 id="dash-info-title">Notice</h3>
      <p id="dash-info-msg"></p>
      <div class="closure-modal-actions">
        <button id="dash-info-ok" class="closure-modal-btn confirm">OK</button>
      </div>
    </div>
  </div>

  <!-- Reservation details modal (from calendar) -->
  <div id="dash-details-modal" class="closure-modal" style="display:none;">
    <div class="closure-modal-content dash-details-content">
      <h3>Reservation Details</h3>
      <div id="dash-details-body" class="dash-details-body"></div>
      <div class="closure-modal-actions">
        <button id="dash-details-close" class="closure-modal-btn confirm">Close</button>
      </div>
    </div>
  </div>

  <!-- Toast notifications container -->
  <div id="maison-toast-container" class="maison-toast-container"></div>

</main>

<div class="dash-denied" id="dashboard-denied" style="display:none;">
  <div class="denied-content">
    <span class="denied-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    </span>
    <h2>Access Restricted</h2>
    <p>This page is reserved for hotel administration.</p>
    <a href="<?php echo home_url('/'); ?>" class="denied-btn">Return to Hotel</a>
  </div>
</div>

<?php get_footer(); ?>
