document.addEventListener("DOMContentLoaded", function () {
  if (typeof Chart === "undefined") {
    console.error("Chart.js not loaded");
    return;
  }

  var API = window.location.origin + "/maison_dune_api/public/index.php/api";
  var token = localStorage.getItem("maison_token");
  var dashApp = document.getElementById("dashboard-app");
  var dashDenied = document.getElementById("dashboard-denied");
  var dashLoader = document.getElementById("dash-loader");
  var dashSkeleton = document.getElementById("dashboard-skeleton");

  if (!dashApp) return;

  if (!token) {
    if (dashLoader) dashLoader.style.display = "none";
    dashDenied.style.display = "flex";
    return;
  }

  fetch(API + "/user", {
    headers: { Authorization: "Bearer " + token, Accept: "application/json" },
  })
    .then(function (r) { return r.json(); })
    .then(function (user) {
      if (!user.is_admin) {
        if (dashLoader) dashLoader.style.display = "none";
        dashDenied.style.display = "flex";
        return;
      }
      if (dashLoader) dashLoader.style.display = "none";
      if (dashSkeleton) dashSkeleton.style.display = "block";
      loadDashboard();
    })
    .catch(function () {
      if (dashLoader) dashLoader.style.display = "none";
      dashDenied.style.display = "flex";
    });

  var gold = "rgb(255, 207, 123)";
  var goldFaded = "rgba(255, 207, 123, 0.15)";
  var red = "rgb(99, 0, 0)";
  var redFaded = "rgba(99, 0, 0, 0.15)";
  var light = "rgba(255,255,255,0.85)";
  var lightFaded = "rgba(255,255,255,0.05)";
  var gridColor = "rgba(255,255,255,0.06)";

  var chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: "rgb(32,32,32)",
        titleColor: gold,
        bodyColor: light,
        borderColor: "rgba(255,207,123,0.2)",
        borderWidth: 1,
        cornerRadius: 6,
        padding: 12,
        titleFont: { family: "Montserrat", size: 11, weight: 600 },
        bodyFont: { family: "Montserrat", size: 12 },
      },
    },
    scales: {
      x: {
        ticks: { color: "rgba(255,255,255,0.4)", font: { family: "Montserrat", size: 10 } },
        grid: { color: gridColor },
        border: { color: "rgba(255,255,255,0.08)" },
      },
      y: {
        ticks: { color: "rgba(255,255,255,0.4)", font: { family: "Montserrat", size: 10 } },
        grid: { color: gridColor },
        border: { color: "transparent" },
        beginAtZero: true,
      },
    },
  };

  function apiFetch(endpoint) {
    return fetch(API + endpoint, {
      headers: { Authorization: "Bearer " + token, Accept: "application/json" },
    }).then(function (r) { return r.json(); });
  }

  function animateKPI(el, target) {
    var start = 0;
    var duration = 1200;
    var startTime = null;
    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.floor(eased * target).toLocaleString();
      if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  function revealDashboard() {
    var loader = document.getElementById("dash-loader");
    if (loader) loader.style.display = "none";
    var skel = document.getElementById("dashboard-skeleton");
    if (skel) skel.style.display = "none";
    if (dashApp) dashApp.style.display = "block";
    document.querySelectorAll(".dash-hidden").forEach(function (el) {
      el.classList.remove("dash-hidden");
      if (el.classList.contains("dash-charts-grid")) {
        el.style.display = "grid";
      } else if (el.classList.contains("dash-kpi-row")) {
        el.style.display = "grid";
      }
    });
    initLiveFloor();
    initCalendar();
    initCheckin();
  }

  function loadDashboard() {
    Promise.all([
      apiFetch("/stats/overview").then(function (res) {
        var d = res.data;
        animateKPI(document.getElementById("kpi-active"), d.active_reservations);
        animateKPI(document.getElementById("kpi-today"), d.today_reservations);
        animateKPI(document.getElementById("kpi-guests"), d.upcoming_guests);
        animateKPI(document.getElementById("kpi-users"), d.total_users);
        animateKPI(document.getElementById("kpi-messages"), d.total_messages);
        renderSections(d.sections, d.event_reservations || 0);
      }),
      apiFetch("/stats/reservations-by-day").then(function (res) {
        renderBarChart("chart-reservations", res.data, gold, goldFaded);
      }),
      apiFetch("/stats/guests-by-day").then(function (res) {
        renderLineChart("chart-guests", res.data, gold, goldFaded);
      }),
      apiFetch("/stats/peak-hours").then(function (res) {
        renderBarChart("chart-hours", res.data, red, redFaded);
      }),
      apiFetch("/stats/table-saturation").then(function (res) {
        renderBarChart("chart-tables", res.data, gold, goldFaded, "%");
      }),
      apiFetch("/stats/user-growth").then(function (res) {
        renderAreaChart("chart-users", res.data, gold, goldFaded);
      }),
    ]).then(revealDashboard).catch(function () { revealDashboard(); });
  }

  function renderBarChart(id, data, color, bgColor, suffix) {
    var ctx = document.getElementById(id);
    if (!ctx) return;
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: data.labels,
        datasets: [{
          data: data.values,
          backgroundColor: bgColor,
          borderColor: color,
          borderWidth: 1.5,
          borderRadius: 4,
          hoverBackgroundColor: color,
        }],
      },
      options: Object.assign({}, chartDefaults, {
        scales: Object.assign({}, chartDefaults.scales, {
          y: Object.assign({}, chartDefaults.scales.y, {
            ticks: Object.assign({}, chartDefaults.scales.y.ticks, {
              callback: function (v) { return v + (suffix || ""); },
            }),
          }),
        }),
      }),
    });
  }

  function renderLineChart(id, data, color, bgColor) {
    var ctx = document.getElementById(id);
    if (!ctx) return;
    new Chart(ctx, {
      type: "line",
      data: {
        labels: data.labels,
        datasets: [{
          data: data.values,
          borderColor: color,
          backgroundColor: "transparent",
          borderWidth: 2,
          pointBackgroundColor: color,
          pointBorderColor: "rgb(32,32,32)",
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
          tension: 0.3,
        }],
      },
      options: chartDefaults,
    });
  }

  function renderAreaChart(id, data, color, bgColor) {
    var ctx = document.getElementById(id);
    if (!ctx) return;
    new Chart(ctx, {
      type: "line",
      data: {
        labels: data.labels,
        datasets: [{
          data: data.values,
          borderColor: color,
          backgroundColor: bgColor,
          fill: true,
          borderWidth: 2,
          pointRadius: 0,
          pointHoverRadius: 5,
          pointHoverBackgroundColor: color,
          tension: 0.4,
        }],
      },
      options: chartDefaults,
    });
  }

  function renderSections(sections, eventCount) {
    var ctx = document.getElementById("chart-sections");
    if (!ctx) return;
    var labels = [];
    var values = [];
    var colors = [gold, red, "rgb(119, 107, 85)", "rgb(201, 168, 76)"];

    var sectionMap = { interior: "Interior", terrace: "Terrace", private: "Private" };
    var keys = Object.keys(sections);
    if (keys.length === 0) {
      keys = ["interior", "terrace", "private"];
    }

    keys.forEach(function (key) {
      labels.push(sectionMap[key] || key);
      values.push(sections[key] || 0);
    });

    if (eventCount > 0) {
      labels.push("Events");
      values.push(eventCount);
    }

    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor: colors.slice(0, labels.length),
          borderColor: "rgb(32,32,32)",
          borderWidth: 3,
          hoverOffset: 8,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: "65%",
        plugins: {
          legend: {
            position: "bottom",
            labels: {
              color: "rgba(255,255,255,0.6)",
              font: { family: "Montserrat", size: 11 },
              padding: 16,
              usePointStyle: true,
              pointStyleWidth: 10,
            },
          },
          tooltip: chartDefaults.plugins.tooltip,
        },
      },
    });
  }

  function fmtDate(d) {
    var p = d.split("T")[0].split("-");
    return p[2] + "/" + p[1] + "/" + p[0];
  }

  function loadClosures() {
    var listEl = document.getElementById("closure-list");
    if (!listEl) return;

    apiFetch("/closures").then(function (res) {
      listEl.innerHTML = "";
      if (!res.data || res.data.length === 0) {
        listEl.innerHTML = '<p class="closure-empty">No closures scheduled. The restaurant is accepting reservations.</p>';
        return;
      }
      res.data.forEach(function (c) {
        var item = document.createElement("div");
        item.className = "closure-item";
        var today = new Date().toISOString().split("T")[0];
        var isActive = c.from_date <= today && c.to_date >= today;
        item.innerHTML =
          '<div class="closure-info">' +
            '<span class="closure-dates">' + fmtDate(c.from_date) + '  →  ' + fmtDate(c.to_date) + '</span>' +
            (c.reason ? '<span class="closure-reason">' + c.reason + '</span>' : '') +
            (isActive ? '<span class="closure-active-badge">Active Now</span>' : '') +
          '</div>' +
          '<button class="closure-delete" data-id="' + c.id + '" data-from="' + fmtDate(c.from_date) + '" data-to="' + fmtDate(c.to_date) + '" title="Remove closure">✕</button>';
        listEl.appendChild(item);
      });

      listEl.querySelectorAll(".closure-delete").forEach(function (btn) {
        btn.addEventListener("click", function () {
          var cId = this.getAttribute("data-id");
          var cFrom = this.getAttribute("data-from");
          var cTo = this.getAttribute("data-to");

          var modal = document.getElementById("closure-modal");
          var msg   = document.getElementById("closure-modal-msg");
          var confirmBtn = document.getElementById("closure-modal-confirm");
          var cancelBtn  = document.getElementById("closure-modal-cancel");

          msg.textContent = "Remove the closure from " + cFrom + " to " + cTo + "? Reservations will be accepted again for those dates.";
          confirmBtn.textContent = "Remove Closure";
          modal.style.display = "flex";

          function cleanup() {
            modal.style.display = "none";
            confirmBtn.textContent = "Disable Reservations";
            confirmBtn.removeEventListener("click", onConfirm);
            cancelBtn.removeEventListener("click", onCancel);
          }

          function onCancel() { cleanup(); }

          function onConfirm() {
            cleanup();
            fetch(API + "/closures/" + cId, {
              method: "DELETE",
              headers: { Authorization: "Bearer " + token, Accept: "application/json" },
            })
            .then(function (r) { return r.json(); })
            .then(function () {
              loadClosures();
              if (typeof window.maisonToast === "function") {
                window.maisonToast("Closure cancelled.", "success");
              }
            });
          }

          confirmBtn.addEventListener("click", onConfirm);
          cancelBtn.addEventListener("click", onCancel);
        });
      });
    });
  }

  function initClosureForm() {
    var btn = document.getElementById("btn-add-closure");
    if (!btn) return;

    var today = new Date().toISOString().split("T")[0];
    var fromInput = document.getElementById("closure-from");
    var toInput   = document.getElementById("closure-to");
    if (fromInput) fromInput.min = today;
    if (toInput)   toInput.min = today;

    fromInput.addEventListener("change", function () {
      toInput.min = fromInput.value || today;
    });

    btn.addEventListener("click", function () {
      var from   = fromInput.value;
      var to     = toInput.value;
      var reason = document.getElementById("closure-reason").value;

      if (!from || !to) { showDashInfo("Missing dates", "Please select both dates to schedule a closure."); return; }

      var modal = document.getElementById("closure-modal");
      var msg   = document.getElementById("closure-modal-msg");
      msg.textContent = "Reservations will be disabled from " + from + " to " + to +
        (reason ? " (" + reason + ")" : "") + ". Are you sure?";
      modal.style.display = "flex";

      var confirmBtn = document.getElementById("closure-modal-confirm");
      var cancelBtn  = document.getElementById("closure-modal-cancel");

      function cleanup() {
        modal.style.display = "none";
        confirmBtn.removeEventListener("click", onConfirm);
        cancelBtn.removeEventListener("click", onCancel);
      }

      function onCancel() { cleanup(); }

      function onConfirm() {
        cleanup();
        fetch(API + "/closures", {
          method: "POST",
          headers: {
            Authorization: "Bearer " + token,
            Accept: "application/json",
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ from_date: from, to_date: to, reason: reason }),
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) {
            fromInput.value = "";
            toInput.value = "";
            document.getElementById("closure-reason").value = "";
            loadClosures();
            if (typeof window.maisonToast === "function") {
              window.maisonToast("Closure scheduled from " + from + " to " + to + ".", "success");
            }
          } else {
            var errMsg = res.errors ? Object.values(res.errors).flat().join(", ") : (res.message || "Error");
            if (typeof window.maisonToast === "function") {
              window.maisonToast(errMsg, "error");
            } else {
              showDashInfo("Could not save closure", errMsg);
            }
          }
        });
      }

      confirmBtn.addEventListener("click", onConfirm);
      cancelBtn.addEventListener("click", onCancel);
    });

    loadClosures();
  }

  initClosureForm();

function showDashInfo(title, message) {
    var modal = document.getElementById("dash-info-modal");
    if (!modal) { return; }
    document.getElementById("dash-info-title").textContent = title || "Notice";
    document.getElementById("dash-info-msg").textContent  = message || "";
    modal.style.display = "flex";
    var okBtn = document.getElementById("dash-info-ok");
    var close = function () {
      modal.style.display = "none";
      okBtn.removeEventListener("click", close);
      modal.removeEventListener("click", onBackdrop);
    };
    var onBackdrop = function (e) { if (e.target === modal) close(); };
    okBtn.addEventListener("click", close);
    modal.addEventListener("click", onBackdrop);
  }

  function showDashDetails(html) {
    var modal = document.getElementById("dash-details-modal");
    if (!modal) { return; }
    document.getElementById("dash-details-body").innerHTML = html;
    modal.style.display = "flex";
    var closeBtn = document.getElementById("dash-details-close");
    var close = function () {
      modal.style.display = "none";
      closeBtn.removeEventListener("click", close);
      modal.removeEventListener("click", onBackdrop);
    };
    var onBackdrop = function (e) { if (e.target === modal) close(); };
    closeBtn.addEventListener("click", close);
    modal.addEventListener("click", onBackdrop);
  }

function initLiveFloor() {
    var tabs = document.querySelectorAll(".live-floor-tab");
    if (!tabs.length) return;

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        tabs.forEach(function (t) { t.classList.remove("active"); });
        tab.classList.add("active");
        var sec = tab.getAttribute("data-section");
        document.getElementById("live-floor-interior").style.display = (sec === "interior") ? "grid" : "none";
        document.getElementById("live-floor-terrace").style.display  = (sec === "terrace")  ? "grid" : "none";
      });
    });

    refreshLiveFloor();
    setInterval(refreshLiveFloor, 15000);
  }

  function refreshLiveFloor() {
    apiFetch("/tables/status-now").then(function (res) {
      if (!res.data) return;

      var counts = { free: 0, upcoming: 0, occupied: 0 };
      var byInterior = res.data.filter(function (t) { return t.section === "interior"; });
      var byTerrace  = res.data.filter(function (t) { return t.section === "terrace"; });

      renderLiveFloorSection("live-floor-interior", byInterior, counts);
      renderLiveFloorSection("live-floor-terrace",  byTerrace,  counts);

      var fe = document.getElementById("live-stat-free");
      var ue = document.getElementById("live-stat-upcoming");
      var oe = document.getElementById("live-stat-occupied");
      var te = document.getElementById("live-stat-updated");
      if (fe) fe.textContent = counts.free;
      if (ue) ue.textContent = counts.upcoming;
      if (oe) oe.textContent = counts.occupied;
      if (te) te.textContent = new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
    }).catch(function (err) { console.warn("Live floor failed", err); });
  }

  function renderLiveFloorSection(gridId, tables, counts) {
    var grid = document.getElementById(gridId);
    if (!grid) return;
    grid.innerHTML = "";
    var tooltip = document.getElementById("live-floor-tooltip");

    tables.forEach(function (t) {
      counts[t.status]++;
      var cell = document.createElement("div");
      cell.className = "live-table live-table-" + t.status;
      cell.setAttribute("data-table", t.table_number);
      cell.innerHTML =
        '<span class="live-table-num">' + t.table_number + '</span>' +
        '<span class="live-table-cap">' + t.capacity + ' pax</span>';

      cell.addEventListener("mouseenter", function (e) {
        if (!tooltip) return;
        var msg = "Table " + t.table_number + " · " + t.capacity + " pax<br>";
        if (t.status === "free")     msg += "<strong style='color:#7dd87d'>Free</strong>";
        if (t.status === "upcoming") msg += "<strong style='color:#f0b550'>Reserved at " + (t.info && t.info.time) + "</strong><br>" + (t.info && t.info.guest);
        if (t.status === "occupied") msg += "<strong style='color:#ff6b6b'>Occupied</strong><br>" + (t.info && t.info.guest) + " · " + (t.info && t.info.guests) + " pax";
        tooltip.innerHTML = msg;
        tooltip.style.display = "block";
      });
      cell.addEventListener("mousemove", function (e) {
        if (!tooltip) return;
        var r = grid.getBoundingClientRect();
        tooltip.style.left = (e.clientX - r.left + 15) + "px";
        tooltip.style.top  = (e.clientY - r.top  - 15) + "px";
      });
      cell.addEventListener("mouseleave", function () {
        if (tooltip) tooltip.style.display = "none";
      });

      grid.appendChild(cell);
    });
  }

function initCalendar() {
    var calEl = document.getElementById("dash-calendar");
    if (!calEl || typeof FullCalendar === "undefined") return;

    apiFetch("/reservations").then(function (res) {
      var events = (res.data || []).map(function (r) {
        var isEvent = !!r.event_slug;
        var isRoom  = !!r.room_slug;
        var colors = { interior: "#ffcf7b", terrace: "#7dd87d", private: "#c76f6f" };
        var color, border, textColor, title;

        if (isRoom) {
          color     = "#1f3a5f";
          border    = "#b8862e";
          textColor = "#f0e0b8";
          var roomName = r.room_title || r.room_slug;
          title = "⌂ " + roomName + " · " + (r.first_name || "") + " " + (r.last_name || "");
        } else if (isEvent) {
          color     = "#1a1a1a";
          border    = "#c9a84c";
          textColor = "#ffd98a";
          var eventName = r.event_title || r.event_slug;
          title = "★ " + eventName + " · " + (r.first_name || "") + " " + (r.last_name || "") + " · " + r.guests + "p";
        } else {
          color     = colors[r.section] || "#ffcf7b";
          border    = color;
          textColor = "#1a1a1a";
          title = (r.first_name + " " + (r.last_name || "")) + " · " + r.guests + "p" + (r.table_number ? " · T" + r.table_number : "");
        }

        return {
          id: r.id,
          title: title,
          start: r.date + "T" + (r.time.length === 5 ? r.time : r.time.substring(0,5)) + ":00",
          backgroundColor: color,
          borderColor: border,
          textColor: textColor,
          classNames: isRoom ? ["fc-event-maison-room"] : (isEvent ? ["fc-event-maison-event"] : ["fc-event-maison-restaurant"]),
          extendedProps: r,
        };
      });

      var cal = new FullCalendar.Calendar(calEl, {
        initialView: "dayGridMonth",
        height: 640,
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,listWeek",
        },
        events: events,
        eventClick: function (info) {
          var r = info.event.extendedProps;
          var isEvent = !!r.event_slug;
          var isRoom  = !!r.room_slug;
          var esc = function (s) { return String(s == null ? "" : s).replace(/[&<>"']/g, function(c){return ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"})[c];}); };
          var rows;
          if (isRoom) {
            rows = [
              ["Type",      '<span style="background:linear-gradient(135deg,#b8862e,#8a6420);color:#fff;font-size:10px;letter-spacing:1.2px;text-transform:uppercase;font-weight:700;padding:3px 8px;border-radius:2px;">⌂ Hotel</span>'],
              ["Room",      esc(r.room_title || r.room_slug)],
              ["Guest",     esc(r.first_name) + " " + esc(r.last_name || "")],
              ["Email",     esc(r.email || "—")],
              ["Phone",     esc(r.phone || "—")],
              ["Check-in",  esc(r.date)],
              ["Check-out", esc(r.checkout_date || "—")],
              ["Guests",    esc(r.guests)],
            ];
            if (r.total_price) rows.push(["Total", "€" + esc(r.total_price)]);
          } else if (isEvent) {
            rows = [
              ["Type",    '<span style="background:linear-gradient(135deg,#ffcf7b,#d9a35a);color:#1a1a1a;font-size:10px;letter-spacing:1.2px;text-transform:uppercase;font-weight:700;padding:3px 8px;border-radius:2px;">★ Event</span>'],
              ["Event",   esc(r.event_title || r.event_slug)],
              ["Guest",   esc(r.first_name) + " " + esc(r.last_name || "")],
              ["Email",   esc(r.email || "—")],
              ["Phone",   esc(r.phone || "—")],
              ["Date",    esc(r.date)],
              ["Time",    esc(String(r.time || "").substring(0, 5))],
              ["Guests",  esc(r.guests)],
            ];
            if (r.room_number) rows.push(["Location", esc(r.room_number)]);
          } else {
            rows = [
              ["Type",    '<span style="background:#f0ece0;color:#6b5e4a;font-size:10px;letter-spacing:1.2px;text-transform:uppercase;font-weight:700;padding:3px 8px;border-radius:2px;">Restaurant</span>'],
              ["Guest",   esc(r.first_name) + " " + esc(r.last_name || "")],
              ["Email",   esc(r.email || "—")],
              ["Phone",   esc(r.phone || "—")],
              ["Date",    esc(r.date)],
              ["Time",    esc(String(r.time || "").substring(0, 5))],
              ["Guests",  esc(r.guests)],
              ["Section", esc((r.section || "").charAt(0).toUpperCase() + (r.section || "").slice(1))],
            ];
            if (r.table_number) rows.push(["Table", "T" + esc(r.table_number)]);
            if (r.room_number)  rows.push(["Room",  esc(r.room_number)]);
          }
          if (r.notes) rows.push(["Notes", esc(r.notes)]);
          var code = "MD-" + String(r.id).padStart(5, "0");
          var html = '<div class="dash-details-code">' + code + '</div>';
          html += '<table class="dash-details-table">';
          rows.forEach(function (row) {
            html += '<tr><th>' + row[0] + '</th><td>' + row[1] + '</td></tr>';
          });
          html += '</table>';
          showDashDetails(html);
        },
        dayMaxEvents: 3,
        firstDay: 1,
      });

      cal.render();
    }).catch(function () {});
  }

var qrScanner = null;

  function initCheckin() {
    var startBtn  = document.getElementById("checkin-start");
    var stopBtn   = document.getElementById("checkin-stop");
    var lookupBtn = document.getElementById("checkin-lookup");
    var codeInput = document.getElementById("checkin-code");
    if (!startBtn || !lookupBtn) return;

    startBtn.addEventListener("click", startScanner);
    stopBtn.addEventListener("click", stopScanner);
    lookupBtn.addEventListener("click", function () { lookupCode(codeInput.value); });
    codeInput.addEventListener("keydown", function (e) {
      if (e.key === "Enter") { e.preventDefault(); lookupCode(codeInput.value); }
    });
  }

  function startScanner() {
    var hint  = document.getElementById("checkin-hint");
    var start = document.getElementById("checkin-start");
    var stop  = document.getElementById("checkin-stop");
    if (typeof Html5Qrcode === "undefined") {
      toast("QR library failed to load.", "error");
      return;
    }
    if (hint) hint.style.display = "none";
    start.style.display = "none";
    stop.style.display  = "inline-block";

    qrScanner = new Html5Qrcode("checkin-reader");
    qrScanner.start(
      { facingMode: "environment" },
      { fps: 10, qrbox: { width: 220, height: 220 } },
      function onSuccess(decodedText) {
        if (qrScanner._lastCode === decodedText) return;
        qrScanner._lastCode = decodedText;
        setTimeout(function () { qrScanner._lastCode = null; }, 3000);
        lookupCode(decodedText);
      },
      function onError() { /* silent per-frame errors */ }
    ).catch(function (err) {
      toast("Could not start camera: " + err, "error");
      start.style.display = "inline-block";
      stop.style.display  = "none";
      if (hint) hint.style.display = "flex";
    });
  }

  function stopScanner() {
    var hint  = document.getElementById("checkin-hint");
    var start = document.getElementById("checkin-start");
    var stop  = document.getElementById("checkin-stop");
    if (qrScanner) {
      qrScanner.stop().then(function () { qrScanner.clear(); qrScanner = null; }).catch(function () {});
    }
    start.style.display = "inline-block";
    stop.style.display  = "none";
    if (hint) hint.style.display = "flex";
  }

  function lookupCode(raw) {
    if (!raw || !raw.trim()) { toast("Enter a confirmation code.", "error"); return; }
    fetch(API + "/reservations/lookup", {
      method: "POST",
      headers: {
        Authorization: "Bearer " + token,
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ code: raw.trim() }),
    })
      .then(function (r) { return r.json().then(function (j) { return { status: r.status, body: j }; }); })
      .then(function (res) {
        if (res.status !== 200 || !res.body.success) {
          renderCheckinResult(null, res.body.message || "Not found.");
          toast(res.body.message || "Reservation not found.", "error");
          return;
        }
        renderCheckinResult(res.body.data, null);
        toast("Reservation #" + res.body.data.id + " loaded.", "info");
      })
      .catch(function () { toast("Network error.", "error"); });
  }

  function renderCheckinResult(r, errorMsg) {
    var box = document.getElementById("checkin-result");
    if (!box) return;
    if (!r) {
      box.innerHTML = '<div class="checkin-empty">' + (errorMsg || "No reservation.") + '</div>';
      return;
    }
    var code = "MD-" + String(r.id).padStart(5, "0");
    var esc  = function (s) { return String(s == null ? "" : s).replace(/[&<>"']/g, function(c){return ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"})[c];}); };
    var alreadyCheckedIn = !!r.checked_in_at;
    var timeCI = "";
    if (alreadyCheckedIn) {
      var d = new Date(r.checked_in_at.replace(" ", "T"));
      timeCI = isNaN(d) ? r.checked_in_at : d.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
    }
    box.innerHTML =
      '<div class="checkin-card">' +
        '<div class="checkin-card-top">' +
          '<span class="checkin-card-code">' + code + '</span>' +
          (alreadyCheckedIn
            ? '<span class="checkin-badge checkin-badge-done">Checked-in at ' + timeCI + '</span>'
            : '<span class="checkin-badge checkin-badge-pending">Awaiting arrival</span>') +
        '</div>' +
        '<div class="checkin-card-name">' + esc(r.first_name) + " " + esc(r.last_name || "") + '</div>' +
        '<div class="checkin-card-meta">' +
          '<span>' + esc(r.date) + ' · ' + esc(String(r.time).substring(0,5)) + '</span>' +
          '<span>' + esc(r.guests) + ' guests · ' + esc((r.section || "").charAt(0).toUpperCase() + (r.section || "").slice(1)) +
            (r.table_number ? ' · T' + esc(r.table_number) : "") +
          '</span>' +
        '</div>' +
        (alreadyCheckedIn
          ? ''
          : '<button class="checkin-btn checkin-btn-primary checkin-btn-confirm" data-id="' + r.id + '">Confirm check-in</button>') +
      '</div>';

    var confirmBtn = box.querySelector(".checkin-btn-confirm");
    if (confirmBtn) {
      confirmBtn.addEventListener("click", function () {
        doCheckIn(r.id);
      });
    }
  }

  function doCheckIn(id) {
    fetch(API + "/reservations/" + id + "/checkin", {
      method: "POST",
      headers: {
        Authorization: "Bearer " + token,
        Accept: "application/json",
        "Content-Type": "application/json",
      },
    })
      .then(function (r) { return r.json().then(function (j) { return { status: r.status, body: j }; }); })
      .then(function (res) {
        if (res.body.success) {
          toast("✓ Guest checked in (MD-" + String(id).padStart(5, "0") + ")", "success");
          renderCheckinResult(res.body.data, null);
          if (typeof confetti === "function") {
            confetti({
              particleCount: 60,
              spread: 50,
              origin: { y: 0.8 },
              colors: ["#ffcf7b", "#ffdb97", "#c9a84c", "#ffffff"],
            });
          }
          if (typeof refreshLiveFloor === "function") refreshLiveFloor();
        } else {
          toast(res.body.message || "Check-in failed.", "error");
          if (res.body.data) renderCheckinResult(res.body.data, null);
        }
      })
      .catch(function () { toast("Network error.", "error"); });
  }

  function toast(msg, type) {
    if (typeof window.maisonToast === "function") {
      window.maisonToast(msg, type);
    } else {
      showDashInfo(type === "error" ? "Error" : "Notice", msg);
    }
  }
});
