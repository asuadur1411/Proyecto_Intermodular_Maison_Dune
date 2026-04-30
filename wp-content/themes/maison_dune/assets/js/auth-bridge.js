document.addEventListener("DOMContentLoaded", function () {

  (function () {
    function ensureContainer() {
      var c = document.getElementById("maison-toast-container");
      if (!c) {
        c = document.createElement("div");
        c.id = "maison-toast-container";
        c.className = "maison-toast-container";
        document.body.appendChild(c);
      }
      return c;
    }
    var icons = {
      success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
      error:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
      info:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
    };
    window.maisonToast = function (message, type) {
      type = type || "info";
      var c = ensureContainer();
      var el = document.createElement("div");
      el.className = "maison-toast maison-toast-" + type;
      el.innerHTML =
        '<span class="maison-toast-icon">' + (icons[type] || icons.info) + '</span>' +
        '<span class="maison-toast-msg"></span>' +
        '<button class="maison-toast-close" aria-label="Close">&times;</button>';
      el.querySelector(".maison-toast-msg").textContent = message;
      c.appendChild(el);
      requestAnimationFrame(function () { el.classList.add("visible"); });
      var timer = setTimeout(dismiss, 4200);
      function dismiss() {
        clearTimeout(timer);
        el.classList.remove("visible");
        el.classList.add("leaving");
        setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 350);
      }
      el.querySelector(".maison-toast-close").addEventListener("click", dismiss);
    };
  })();

const API = window.location.origin + "/maison_dune_api/public/index.php/api";
  const CSRF_URL = window.location.origin + "/maison_dune_api/public/index.php/sanctum/csrf-cookie";
  const token    = localStorage.getItem("maison_token");
  const userName = localStorage.getItem("maison_user");

  var hamburger = document.getElementById("hamburger-btn");
  var navEl = document.querySelector("header nav");
  if (hamburger && navEl) {
    hamburger.addEventListener("click", function () {
      hamburger.classList.toggle("active");
      navEl.classList.toggle("nav-open");
      document.body.style.overflow = navEl.classList.contains("nav-open") ? "hidden" : "";
    });
    navEl.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        hamburger.classList.remove("active");
        navEl.classList.remove("nav-open");
        document.body.style.overflow = "";
      });
    });
  }

  function getCookie(name) {
    var match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
    return match ? decodeURIComponent(match[2]) : null;
  }

function showConfirmModal(message, onConfirm, options) {
    var opts = options || {};
    var cancelText = opts.cancelText || "No, Keep It";
    var confirmText = opts.confirmText || "Yes, Cancel";
    var existing = document.getElementById("maison-confirm-modal");
    if (existing) existing.remove();

    var modal = document.createElement("div");
    modal.id = "maison-confirm-modal";
    modal.className = "maison-modal visible";
    modal.innerHTML =
      '<div class="modal-box">' +
        '<span class="modal-icon">?</span>' +
        '<p class="modal-message">' + message + '</p>' +
        '<input type="password" class="modal-password" placeholder="Enter your password" autocomplete="current-password">' +
        '<div class="modal-confirm-actions">' +
          '<button class="modal-btn-cancel">' + cancelText + '</button>' +
          '<button class="modal-btn-confirm">' + confirmText + '</button>' +
        '</div>' +
      '</div>';

    document.body.appendChild(modal);

    var passwordInput = modal.querySelector(".modal-password");

    function closeConfirm() {
      modal.classList.remove("visible");
      setTimeout(function () { modal.remove(); }, 300);
    }

    modal.querySelector(".modal-btn-cancel").addEventListener("click", closeConfirm);
    modal.querySelector(".modal-btn-confirm").addEventListener("click", function () {
      var pwd = passwordInput.value.trim();
      if (!pwd) {
        passwordInput.style.borderColor = "var(--red)";
        passwordInput.setAttribute("placeholder", "Password is required");
        return;
      }
      closeConfirm();
      onConfirm(pwd);
    });
    modal.addEventListener("click", function (e) { if (e.target === modal) closeConfirm(); });
  }

  function showModal(message, type = "error", onClose = null) {
    const existing = document.getElementById("maison-modal");
    if (existing) existing.remove();

    const modal = document.createElement("div");
    modal.id = "maison-modal";
    modal.className = "maison-modal " + type;
    modal.innerHTML = `
      <div class="modal-box">
        <span class="modal-icon">${type === "success" ? "✓" : "✕"}</span>
        <p class="modal-message">${message}</p>
        <button class="modal-close">Close</button>
      </div>
    `;

    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add("visible"), 10);

    function handleClose() {
      modal.classList.remove("visible");
      setTimeout(() => modal.remove(), 300);
      if (onClose) onClose();
    }

    modal.querySelector(".modal-close").addEventListener("click", handleClose);
    modal.addEventListener("click", (e) => { if (e.target === modal) handleClose(); });
  }

  window.maisonShowModal        = showModal;
  window.maisonShowConfirmModal = showConfirmModal;

  // ------------------------------------------------------------------
  // Refund-aware cancellation modal for room bookings
  // ------------------------------------------------------------------
  function showRoomRefundModal(reservation, onConfirm) {
    var existing = document.getElementById("maison-refund-modal");
    if (existing) existing.remove();

    var total = parseFloat(reservation.total_price) || 0;

    // Replicate backend policy on the client for preview only.
    // Real refund amount is recalculated server-side at cancellation time.
    var checkIn = new Date(reservation.date + 'T15:00:00');
    var hours   = (checkIn.getTime() - Date.now()) / 36e5;
    var percent = 0, label = 'No refund', reason = '';
    if (hours >= 48)       { percent = 1.00; label = '100% refund'; reason = 'Cancelled more than 48h before check-in.'; }
    else if (hours >= 24)  { percent = 0.50; label = '50% refund';  reason = 'Cancelled within 48h of check-in.'; }
    else if (hours >= 0)   { percent = 0.00; label = 'No refund';   reason = 'Cancelled within 24h of check-in.'; }
    else                   { percent = 0.00; label = 'No refund';   reason = 'Stay has already started.'; }

    var refundAmount = (total * percent).toFixed(2);
    var fee          = (total - parseFloat(refundAmount)).toFixed(2);
    var refundColor  = percent === 1 ? '#5fd784' : (percent === 0.5 ? '#e8c878' : '#ff8a6a');

    var modal = document.createElement("div");
    modal.id = "maison-refund-modal";
    modal.className = "maison-modal visible";
    modal.innerHTML =
      '<div class="modal-box refund-modal-box">' +
        '<h3 class="refund-modal-title">Cancel booking &amp; refund</h3>' +
        '<p class="refund-modal-sub">' + (reservation.room_title || 'Suite reservation') + ' · MD-R' + String(reservation.id).padStart(5, '0') + '</p>' +

        '<div class="refund-summary" style="border-color:' + refundColor + ';">' +
          '<div class="refund-summary-label">Estimated refund</div>' +
          '<div class="refund-summary-amount" style="color:' + refundColor + ';">€' + refundAmount + '</div>' +
          '<div class="refund-summary-policy">' + label + ' · ' + reason + '</div>' +
        '</div>' +

        '<table class="refund-breakdown">' +
          '<tr><td>Original amount paid</td><td class="r">€' + total.toFixed(2) + '</td></tr>' +
          (parseFloat(fee) > 0 ? '<tr><td class="fee">Cancellation fee</td><td class="r fee">−€' + fee + '</td></tr>' : '') +
        '</table>' +

        '<label class="refund-method-label">Refund to</label>' +
        '<select class="refund-method-select">' +
          '<option value="original">Original payment method</option>' +
          '<option value="card">Card ending in 4242</option>' +
          '<option value="paypal">PayPal account</option>' +
          '<option value="applepay">Apple Pay</option>' +
        '</select>' +

        '<label class="refund-method-label">Confirm with your password</label>' +
        '<input type="password" class="modal-password refund-password" placeholder="Enter your password" autocomplete="current-password">' +

        '<p class="refund-modal-note">Refunds are processed within 5–10 business days. A confirmation email will be sent.</p>' +

        '<div class="modal-confirm-actions">' +
          '<button class="modal-btn-cancel">Keep booking</button>' +
          '<button class="modal-btn-confirm refund-btn-confirm">Cancel &amp; refund</button>' +
        '</div>' +
      '</div>';

    document.body.appendChild(modal);

    var pwdInput = modal.querySelector(".refund-password");
    var methodSel = modal.querySelector(".refund-method-select");

    function close() {
      modal.classList.remove("visible");
      setTimeout(function () { modal.remove(); }, 300);
    }
    modal.querySelector(".modal-btn-cancel").addEventListener("click", close);
    modal.addEventListener("click", function (e) { if (e.target === modal) close(); });
    modal.querySelector(".refund-btn-confirm").addEventListener("click", function () {
      var pwd = pwdInput.value.trim();
      if (!pwd) {
        pwdInput.style.borderColor = "var(--red)";
        pwdInput.setAttribute("placeholder", "Password is required");
        return;
      }
      close();
      onConfirm(pwd, methodSel.value);
    });
  }

  // ------------------------------------------------------------------
  // Shared cancellation request — used by both restaurant/event modal
  // and the room refund modal.
  // ------------------------------------------------------------------
  function cancelReservation(reservationId, thisCard, password, refundMethod, kind) {
    var token = localStorage.getItem("maison_token");
    fetch(CSRF_URL, { credentials: "include" }).then(function () {
      var xsrf = getCookie("XSRF-TOKEN");
      var body = { password: password };
      if (refundMethod) body.refund_method = refundMethod;

      fetch(API + "/reservations/" + reservationId, {
        method: "DELETE",
        credentials: "include",
        headers: {
          "Content-Type": "application/json",
          "Authorization": "Bearer " + token,
          "Accept": "application/json",
          "X-XSRF-TOKEN": xsrf,
        },
        body: JSON.stringify(body),
      })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data.success) {
          thisCard.remove();
          var msg;
          if (data.refund) {
            msg = data.refund.eligible
              ? 'Booking cancelled. ' + data.refund.percent_label +
                ' of €' + parseFloat(data.refund.amount).toFixed(2) +
                ' will be refunded to your ' +
                ({ card: 'card', paypal: 'PayPal account', applepay: 'Apple Pay', original: 'original payment method' }[data.refund.method] || 'original payment method') +
                ' within 5–10 business days. A confirmation email has been sent.'
              : 'Booking cancelled. ' + data.refund.reason + ' No refund will be issued.';
          } else {
            msg = kind === "event"
              ? "Event registration cancelled successfully."
              : "Reservation cancelled successfully.";
          }
          showModal(msg, "success");
        } else {
          showModal(data.message || "Could not cancel the reservation.", "error");
        }
      })
      .catch(function () {
        showModal("Could not connect to the server. Please try again later.", "error");
      });
    });
  }

function fireConfetti() {
    if (typeof confetti !== "function") return;
    var duration = 1800;
    var end = Date.now() + duration;
    var gold = ["#ffcf7b", "#f0b550", "#b8860b", "#ffffff"];
    (function frame() {
      confetti({
        particleCount: 3,
        angle: 60,
        spread: 70,
        origin: { x: 0, y: 0.7 },
        colors: gold,
      });
      confetti({
        particleCount: 3,
        angle: 120,
        spread: 70,
        origin: { x: 1, y: 0.7 },
        colors: gold,
      });
      if (Date.now() < end) requestAnimationFrame(frame);
    })();
    confetti({
      particleCount: 120,
      spread: 90,
      origin: { y: 0.5 },
      colors: gold,
    });
  }

  function formatTicketDate(dateStr) {
    try {
      var d = new Date(dateStr + "T00:00:00");
      var months = ["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];
      return {
        day: String(d.getDate()).padStart(2, "0"),
        month: months[d.getMonth()],
        year: d.getFullYear(),
        weekday: ["SUN","MON","TUE","WED","THU","FRI","SAT"][d.getDay()],
      };
    } catch (e) { return { day: "--", month: "---", year: "----", weekday: "---" }; }
  }

  function sectionLabelTicket(s) {
    if (s === "private") return "Private Dining";
    if (s === "terrace") return "Terrace";
    if (s === "interior" || s === "indoor") return "Indoor";
    return s || "—";
  }

  function showReservationTicket(payload, data) {
    var dateParts = formatTicketDate(payload.date);
    var ticketId = (data && data.data && data.data.id) ? data.data.id : (data && data.id) ? data.id : Math.floor(Math.random()*99999);
    var confirmCode = "MD-" + String(ticketId).padStart(5, "0");

    var overlay = document.createElement("div");
    overlay.className = "reservation-ticket-overlay";
    overlay.innerHTML =
      '<div class="reservation-ticket">' +
        '<div class="ticket-check">' +
          '<svg viewBox="0 0 52 52"><circle cx="26" cy="26" r="25" fill="none"/><path fill="none" d="M14 27 l8 8 l16 -16"/></svg>' +
        '</div>' +
        '<div class="ticket-header">' +
          '<span class="ticket-eyebrow">Reservation Confirmed</span>' +
          '<h2>Maison <em>Dune</em></h2>' +
          '<span class="ticket-subtitle">Ziryab Restaurant</span>' +
        '</div>' +
        '<div class="ticket-divider"></div>' +
        '<div class="ticket-body">' +
          '<div class="ticket-date">' +
            '<span class="ticket-weekday">' + dateParts.weekday + '</span>' +
            '<span class="ticket-day">' + dateParts.day + '</span>' +
            '<span class="ticket-month">' + dateParts.month + ' ' + dateParts.year + '</span>' +
          '</div>' +
          '<div class="ticket-info">' +
            '<div class="ticket-row"><span>Guest</span><strong>' + (payload.first_name + " " + payload.last_name) + '</strong></div>' +
            '<div class="ticket-row"><span>Time</span><strong>' + payload.time + '</strong></div>' +
            '<div class="ticket-row"><span>Party</span><strong>' + payload.guests + (payload.guests == 1 ? " guest" : " guests") + '</strong></div>' +
            '<div class="ticket-row"><span>Section</span><strong>' + sectionLabelTicket(payload.section) + '</strong></div>' +
            (payload.table_number ? '<div class="ticket-row"><span>Table</span><strong>#' + payload.table_number + '</strong></div>' : '') +
          '</div>' +
        '</div>' +
        '<div class="ticket-perforation"></div>' +
        '<div class="ticket-footer">' +
          '<div class="ticket-qr" id="ticket-qr"></div>' +
          '<div class="ticket-code">' +
            '<span>Confirmation</span>' +
            '<strong>' + confirmCode + '</strong>' +
            '<small>Present this code upon arrival</small>' +
          '</div>' +
        '</div>' +
        '<div class="ticket-email-notice">' +
          '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>' +
          '<span>A confirmation email with this QR code has been sent to your inbox.</span>' +
        '</div>' +
        '<div class="ticket-actions">' +
          '<button class="ticket-btn ticket-btn-primary" id="ticket-view-all">View My Reservations</button>' +
          '<button class="ticket-btn ticket-btn-secondary" id="ticket-close">Close</button>' +
        '</div>' +
      '</div>';

    document.body.appendChild(overlay);
    setTimeout(function () { overlay.classList.add("visible"); }, 10);

    try {
      if (typeof QRCode !== "undefined") {
        new QRCode(document.getElementById("ticket-qr"), {
          text: confirmCode + "|" + payload.date + "|" + payload.time,
          width: 90,
          height: 90,
          colorDark: "#1a1a1a",
          colorLight: "#ffffff",
          correctLevel: QRCode.CorrectLevel.M,
        });
      }
    } catch (e) { console.warn("QR generation failed", e); }

    fireConfetti();

    document.getElementById("ticket-view-all").addEventListener("click", function () {
      window.location.href = "/my-reservations";
    });
    document.getElementById("ticket-close").addEventListener("click", function () {
      overlay.classList.remove("visible");
      setTimeout(function () { overlay.remove(); }, 400);
    });
  }

var reservationForm = document.getElementById("reservation-form");
  if (reservationForm && !token) {
    reservationForm.addEventListener("submit", function (e) {
      e.preventDefault();

      var formData = {
        "first-name": document.getElementById("first-name").value,
        "last-name":  document.getElementById("last-name").value,
        phone:         document.getElementById("phone").value,
        date:          document.getElementById("date").value,
        time:          document.getElementById("time").value,
        guests:        document.getElementById("guests").value,
        section:       document.getElementById("section").value,
        notes:         document.getElementById("notes").value,
      };
      var roomInput = document.getElementById("room-number");
      if (roomInput) formData["room-number"] = roomInput.value;

      localStorage.setItem("maison_form_backup", JSON.stringify(formData));

      showModal("You must log in to make a reservation.", "info", function () {
        window.location.href = "/login?redirect=/table";
      });
    });
  }

  if (reservationForm) {
    var saved = localStorage.getItem("maison_form_backup");
    if (saved) {
      var fields = JSON.parse(saved);
      Object.keys(fields).forEach(function (id) {
        var el = document.getElementById(id);
        if (el && fields[id]) el.value = fields[id];
      });
      localStorage.removeItem("maison_form_backup");

      var sectionEl = document.getElementById("section");
      if (sectionEl) sectionEl.dispatchEvent(new Event("change"));
    }
  }

const loginLink = document.getElementById("login-link");
  const userMenu  = document.getElementById("user-menu-wrapper");
  const toggle    = document.getElementById("user-menu-toggle");
  const dropdown  = document.querySelector(".user-dropdown");

  if (token && userName) {
    if (loginLink) loginLink.style.display = "none";
    if (userMenu)  userMenu.style.display  = "block";

    const userWelcome = document.getElementById("user-welcome");
    if (userWelcome) userWelcome.textContent = "Welcome " + userName;

    fetch(API + "/user", {
      headers: { Authorization: "Bearer " + token, Accept: "application/json" },
    })
      .then(function (r) { return r.json(); })
      .then(function (user) {
        if (user.is_admin) {
          var adminLink = document.getElementById("admin-dash-link");
          if (adminLink) adminLink.style.display = "";
        } else {
          var deleteLink = document.getElementById("delete-account-link");
          if (deleteLink) deleteLink.style.display = "";
        }
      })
      .catch(function (err) { console.error("Admin check failed:", err); });

    var INACTIVITY_LIMIT = 90 * 60 * 1000;
    var sessionExpired = false;

    function expireSession() {
      sessionExpired = true;
      localStorage.removeItem("maison_token");
      localStorage.removeItem("maison_user");
      localStorage.removeItem("maison_last_activity");
      fetch(API + "/logout", {
        method: "POST",
        credentials: "include",
        headers: { "Authorization": "Bearer " + token, "Accept": "application/json" },
      }).catch(function () {});
      showModal("Your session has expired due to inactivity.", "error", function () {
        window.location.href = "/login";
      });
    }

    var lastActivity = localStorage.getItem("maison_last_activity");
    if (lastActivity && (Date.now() - parseInt(lastActivity, 10)) > INACTIVITY_LIMIT) {
      expireSession();
    } else {
      localStorage.setItem("maison_last_activity", Date.now().toString());

      var inactivityTimer;

      function resetInactivity() {
        if (sessionExpired) return;
        clearTimeout(inactivityTimer);
        localStorage.setItem("maison_last_activity", Date.now().toString());
        inactivityTimer = setTimeout(expireSession, INACTIVITY_LIMIT);
      }

      ["click", "keydown", "scroll", "mousemove"].forEach(function (evt) {
        document.addEventListener(evt, resetInactivity);
      });
      resetInactivity();
    }

    if (toggle && dropdown) {
      toggle.addEventListener("click", function () {
        dropdown.classList.toggle("open");
      });
    }

    document.querySelectorAll("#logout-btn, .btn-logout").forEach(function (btn) {
      btn.addEventListener("click", async function (e) {
        e.preventDefault();
        try {
          await fetch(API + "/logout", {
            method: "POST",
            credentials: "include",
            headers: { "Authorization": "Bearer " + token, "Accept": "application/json" },
          });
        } catch (err) {
          console.error("Logout error:", err);
        }
        localStorage.removeItem("maison_token");
        localStorage.removeItem("maison_user");
        localStorage.removeItem("maison_last_activity");
        showModal("You have been logged out successfully.", "success", function () {
          window.location.href = "/";
        });
      });
    });

    var deleteBtn = document.getElementById("delete-account-btn");
    if (deleteBtn) {
      deleteBtn.addEventListener("click", function (e) {
        e.preventDefault();
        dropdown.classList.remove("open");
        showConfirmModal(
          "Are you sure you want to delete your account? This action is irreversible.",
          function (pwd) {
            fetch(CSRF_URL, {
              credentials: "include",
            }).then(function () {
            var xsrf = getCookie("XSRF-TOKEN");
            fetch(API + "/user", {
              method: "DELETE",
              credentials: "include",
              headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json",
                "Content-Type": "application/json",
                "X-XSRF-TOKEN": xsrf,
              },
              body: JSON.stringify({ password: pwd }),
            })
              .then(function (r) { return r.json().then(function (data) { return { ok: r.ok, data: data }; }); })
              .then(function (res) {
                if (res.ok) {
                  localStorage.removeItem("maison_token");
                  localStorage.removeItem("maison_user");
                  localStorage.removeItem("maison_last_activity");
                  showModal("Your account has been deleted successfully.", "success", function () {
                    window.location.href = "/";
                  });
                } else {
                  showModal(res.data.message || "Could not delete account.", "error");
                }
              })
              .catch(function () {
                showModal("Could not connect to the server. Please try again.", "error");
              });
            });
          },
          { cancelText: "Cancel", confirmText: "Yes, Delete" }
        );
      });
    }
  }

const loginForm = document.getElementById("login-form");
  if (loginForm) {

    var loginParams = new URLSearchParams(window.location.search);
    var verifyToken = loginParams.get("token");
    var verifyName  = loginParams.get("name");
    if (verifyToken) {
      localStorage.setItem("maison_token", verifyToken);
      localStorage.setItem("maison_last_activity", Date.now().toString());
      if (verifyName) localStorage.setItem("maison_user", verifyName);

      fetch(API + "/user", {
        headers: { "Authorization": "Bearer " + verifyToken, "Accept": "application/json" },
      })
      .then(function (res) { return res.json(); })
      .then(function (user) {
        if (user.name) localStorage.setItem("maison_user", user.name);
        showModal("Your email has been verified. Welcome, " + (user.name || verifyName || "") + "!", "success", function () {
          window.location.href = "/";
        });
      })
      .catch(function () {
        showModal("Your email has been verified. Welcome!", "success", function () {
          window.location.href = "/";
        });
      });
    }

    const usernameInput = document.getElementById("username");
    if (usernameInput) {
      usernameInput.addEventListener("input", function () {
        this.value = this.value.replace(/\s/g, "");
      });
    }

    var savedUser  = localStorage.getItem("maison_remember_user");
    var savedEmail = localStorage.getItem("maison_remember_email");
    if (savedUser)  document.getElementById("username").value = savedUser;
    if (savedEmail) document.getElementById("email").value = savedEmail;
    var rememberCheck = document.getElementById("remember");
    if (savedUser && rememberCheck) rememberCheck.checked = true;

    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const payload = {
        name:     document.getElementById("username").value,
        email:    document.getElementById("email").value,
        password: document.getElementById("password").value,
      };

      try {
        await fetch(CSRF_URL, {
          credentials: "include",
        });

        const xsrf = getCookie("XSRF-TOKEN");

        const response = await fetch(API + "/login", {
          method: "POST",
          credentials: "include",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-XSRF-TOKEN": xsrf,
          },
          body: JSON.stringify(payload),
        });
        const data = await response.json();

        if (response.ok) {
          localStorage.setItem("maison_token", data.access_token);
          localStorage.setItem("maison_user", data.user.name);
          localStorage.setItem("maison_last_activity", Date.now().toString());

          var rememberMe = document.getElementById("remember");
          if (rememberMe && rememberMe.checked) {
            localStorage.setItem("maison_remember_user", payload.name);
            localStorage.setItem("maison_remember_email", payload.email);
          } else {
            localStorage.removeItem("maison_remember_user");
            localStorage.removeItem("maison_remember_email");
          }

          var redirectTo = new URLSearchParams(window.location.search).get("redirect") || "/";

          showModal("You are logged in.", "success", function () {
            window.location.href = redirectTo;
          });
        } else if (data.status === "unverified") {
          showModal("Please check your email and click the verification link to activate your account.", "error");
        } else {
          showModal(data.message || "Incorrect credentials.", "error");
        }
      } catch (err) {
        console.error("Error:", err);
        showModal("Could not connect to the server. Please try again later.", "error");
      }
    });
  }

const registerForm = document.getElementById("register-form");
  if (registerForm) {

    const usernameInput = document.getElementById("username");
    if (usernameInput) {
      usernameInput.addEventListener("input", function () {
        if (/\s/.test(this.value)) {
          this.value = this.value.replace(/\s/g, "");
          showModal("Username cannot contain spaces.", "error");
        }
      });
    }

    registerForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const password = document.getElementById("password").value;
      const confirm  = document.getElementById("password_confirm").value;

      if (password !== confirm) {
        showModal("Passwords do not match.", "error");
        return;
      }

      const payload = {
        name:     document.getElementById("username").value,
        email:    document.getElementById("email").value,
        password: password,
      };

      try {
        await fetch(CSRF_URL, {
          credentials: "include",
        });

        const xsrf = getCookie("XSRF-TOKEN");

        const response = await fetch(API + "/register", {
          method: "POST",
          credentials: "include",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-XSRF-TOKEN": xsrf,
          },
          body: JSON.stringify(payload),
        });
        const data = await response.json();

        if (response.status === 201) {
          showModal("Account created! Please check your email to verify your account.", "success");
          setTimeout(() => { window.location.href = "/"; }, 2500);
        } else {
          const errorMsg = data.errors
            ? Object.values(data.errors).flat().join("<br>")
            : data.message;
          showModal(errorMsg, "error");
        }
      } catch (err) {
        console.error("Error:", err);
        showModal("Could not connect to the server. Please try again later.", "error");
      }
    });
  }

const forgotForm = document.getElementById("forgot-password-form");
  if (forgotForm) {
    forgotForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      try {
        await fetch(CSRF_URL, {
          credentials: "include",
        });

        const xsrf = getCookie("XSRF-TOKEN");

        const response = await fetch(API + "/forgot-password", {
          method: "POST",
          credentials: "include",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-XSRF-TOKEN": xsrf,
          },
          body: JSON.stringify({ email: document.getElementById("email").value }),
        });
        const data = await response.json();

        if (response.ok) {
          showModal("We have sent a password reset link to your email.", "success");
        } else {
          showModal(data.message || "We could not find an account with that email.", "error");
        }
      } catch (err) {
        console.error("Error:", err);
        showModal("Could not connect to the server. Please try again later.", "error");
      }
    });
  }

const resetForm = document.getElementById("reset-password-form");
  if (resetForm) {

    const params     = new URLSearchParams(window.location.search);
    const resetToken = params.get("token");
    const resetEmail = params.get("email");

    if (!resetToken || !resetEmail) {
      showModal("This reset link is invalid or has expired.", "error", () => {
        window.location.href = "/forgot-password";
      });
      return;
    }

    resetForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const password = document.getElementById("password").value;
      const confirm  = document.getElementById("password_confirm").value;

      if (password !== confirm) {
        showModal("Passwords do not match.", "error");
        return;
      }

      try {
        await fetch(CSRF_URL, {
          credentials: "include",
        });

        const xsrf = getCookie("XSRF-TOKEN");

        const response = await fetch(API + "/reset-password", {
          method: "POST",
          credentials: "include",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-XSRF-TOKEN": xsrf,
          },
          body: JSON.stringify({
            token:                 resetToken,
            email:                 resetEmail,
            password:              password,
            password_confirmation: confirm,
          }),
        });
        const data = await response.json();

        if (response.ok) {
          showModal("Password reset successfully. You can now sign in.", "success", () => {
            window.location.href = "/login";
          });
        } else {
          showModal(data.message || "This reset link is invalid or has expired.", "error");
        }
      } catch (err) {
        console.error("Error:", err);
        showModal("Could not connect to the server. Please try again later.", "error");
      }
    });
  }

if (reservationForm && token) {

    const sectionSelect   = document.getElementById("section");
    const guestsSelect    = document.getElementById("guests");
    const dateInput       = document.getElementById("date");
    const timeInput       = document.getElementById("time");
    const tablePicker     = document.getElementById("table-picker");
    const tableGrid       = document.getElementById("table-grid");
    const tableInput      = document.getElementById("table_number");
    const roomNumberGroup = document.getElementById("room-number-group");
    const roomNumberInput = document.getElementById("room-number");
    const floorInterior   = document.getElementById("floor-interior");
    const floorTerrace    = document.getElementById("floor-terrace");
    const floorTooltip    = document.getElementById("floor-plan-tooltip");

    var closureBanner = document.getElementById("closure-banner");
    fetch(API + "/closures/active", { headers: { Accept: "application/json" } })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (res.closed && res.data) {
          var reason = res.data.reason ? " — " + res.data.reason : "";
          var rawDate = res.data.to_date.split("T")[0].split("-");
          var toDate = rawDate[2] + "/" + rawDate[1] + "/" + rawDate[0];
          if (closureBanner) {
            closureBanner.innerHTML = "Reservations are currently disabled until " + toDate + reason;
            closureBanner.style.display = "block";
          }
          reservationForm.querySelectorAll("input, select, textarea, button[type=submit]").forEach(function (el) {
            el.disabled = true;
          });
        }
      })
      .catch(function () {});

function toggleRoomNumber() {
      var isPrivate = sectionSelect && sectionSelect.value === "private";
      if (roomNumberGroup) roomNumberGroup.style.display = isPrivate ? "flex" : "none";
      if (roomNumberInput && !isPrivate) roomNumberInput.value = "";
    }

    if (sectionSelect) sectionSelect.addEventListener("change", toggleRoomNumber);

    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("section") && sectionSelect) {
      sectionSelect.value = urlParams.get("section");
      toggleRoomNumber();
    }

function showFloorPlan(section) {
      if (floorInterior) floorInterior.style.display = section === "interior" ? "block" : "none";
      if (floorTerrace)  floorTerrace.style.display  = section === "terrace"  ? "block" : "none";
    }

    function hideFloorPlan() {
      if (floorInterior) floorInterior.style.display = "none";
      if (floorTerrace)  floorTerrace.style.display  = "none";
    }

    function resetFloorTables() {
      document.querySelectorAll(".floor-table").forEach(function (g) {
        g.classList.remove("selected", "unavailable", "too-small");
      });
      if (tableInput) tableInput.value = "";
    }

    function initFloorTooltip() {
      var wrapper = document.getElementById("floor-plan-wrapper");
      if (!wrapper || !floorTooltip) return;

      document.querySelectorAll(".floor-table").forEach(function (g) {
        g.addEventListener("mouseenter", function (e) {
          var num = g.getAttribute("data-table");
          var cap = parseInt(g.getAttribute("data-capacity"), 10);
          var loc = g.getAttribute("data-location");
          var guestNum = guestsSelect ? parseInt(guestsSelect.value.replace("+", ""), 10) : 0;

          if (g.classList.contains("too-small")) {
            floorTooltip.innerHTML = "Table " + num + " &middot; " + cap + " seats &middot; Not enough for " + guestNum + " guests";
          } else {
            var status = g.classList.contains("unavailable") ? " &middot; Occupied" : "";
            var adapted = (guestNum > 0 && cap >= guestNum && cap - guestNum <= 1)
              ? " &middot; Can be adapted for " + guestNum + " only"
              : "";
            floorTooltip.innerHTML = "Table " + num + " &middot; " + cap + " seats &middot; " + loc + status + adapted;
          }
          floorTooltip.classList.add("visible");
        });

        g.addEventListener("mousemove", function (e) {
          var rect = wrapper.getBoundingClientRect();
          var x = e.clientX - rect.left + 12;
          var y = e.clientY - rect.top - 30;
          floorTooltip.style.left = x + "px";
          floorTooltip.style.top  = y + "px";
        });

        g.addEventListener("mouseleave", function () {
          floorTooltip.classList.remove("visible");
        });

        g.addEventListener("click", function () {
          if (g.classList.contains("too-small")) return;
          var waitlistBox = document.getElementById("waitlist-box");
          document.querySelectorAll(".floor-table").forEach(function (t) {
            t.classList.remove("selected");
          });
          g.classList.add("selected");
          if (tableInput) tableInput.value = g.getAttribute("data-table");

          if (g.classList.contains("unavailable")) {
            if (waitlistBox) {
              waitlistBox.querySelector(".waitlist-msg").textContent =
                "Table " + g.getAttribute("data-table") + " is currently occupied.";
              waitlistBox.style.display = "block";
            }
          } else {
            if (waitlistBox) waitlistBox.style.display = "none";
          }
        });
      });
    }
    initFloorTooltip();

async function fetchAvailability() {
      const section = sectionSelect ? sectionSelect.value : "";
      const guests  = guestsSelect  ? guestsSelect.value  : "";
      const date    = dateInput     ? dateInput.value      : "";
      const time    = timeInput     ? timeInput.value      : "";

      if (!section || section === "private" || !guests || !date || !time) {
        if (tablePicker) tablePicker.style.display = "none";
        hideFloorPlan();
        if (tableInput)  tableInput.value = "";
        return;
      }

      var hour = parseInt(time.split(":")[0], 10);
      if (hour >= 1 && hour < 9) {
        if (tablePicker) tablePicker.style.display = "none";
        hideFloorPlan();
        if (tableInput)  tableInput.value = "";
        showModal("The restaurant is closed at this hour. We are open from 9:00 to 00:00.", "error");
        return;
      }

      try {
        const params = new URLSearchParams({ section, guests, date, time });
        const res  = await fetch(API + "/tables/availability?" + params, {
          headers: { "Accept": "application/json" },
        });
        const json = await res.json();

        if (!json.success || !json.data.length) {
          tablePicker.style.display = "none";
          hideFloorPlan();
          tableInput.value = "";
          return;
        }

        var availMap = {};
        json.data.forEach(function (t) {
          availMap[t.table_number] = t.available;
        });

        showFloorPlan(section);

        var activeSvg = section === "interior" ? floorInterior : floorTerrace;
        var guestNum = parseInt(guests.replace("+", ""), 10) || 1;

        if (activeSvg) {
          activeSvg.querySelectorAll(".floor-table").forEach(function (g) {
            var num = parseInt(g.getAttribute("data-table"), 10);
            var cap = parseInt(g.getAttribute("data-capacity"), 10);
            g.classList.remove("selected", "unavailable", "too-small");

            if (cap < guestNum) {
              g.classList.add("too-small");
            } else if (availMap[num] === false) {
              g.classList.add("unavailable");
            } else if (availMap[num] === undefined && cap < guestNum) {
              g.classList.add("too-small");
            }
          });

          var waitlistBox = document.getElementById("waitlist-box");
          if (waitlistBox) {
            waitlistBox.style.display = "none";
            var wlBtn = document.getElementById("btn-join-waitlist");
            if (wlBtn) { wlBtn.disabled = false; wlBtn.textContent = "Join Waitlist"; }
          }
        }

        tableInput.value = "";
        tablePicker.style.display = "block";
      } catch (err) {
        console.error("Error cargando mesas:", err);
      }
    }

    if (sectionSelect) sectionSelect.addEventListener("change", fetchAvailability);
    if (guestsSelect)  guestsSelect.addEventListener("change", fetchAvailability);
    if (dateInput)     dateInput.addEventListener("change", fetchAvailability);
    if (timeInput)     timeInput.addEventListener("change", fetchAvailability);

    var btnJoinWaitlist = document.getElementById("btn-join-waitlist");
    if (btnJoinWaitlist) {
      btnJoinWaitlist.addEventListener("click", async function () {
        if (!token) {
          showModal("Please log in to join the waitlist.", "error");
          return;
        }

        var payload = {
          first_name:   document.getElementById("first-name").value,
          last_name:    document.getElementById("last-name").value,
          phone:        document.getElementById("phone").value,
          date:         document.getElementById("date").value,
          time:         document.getElementById("time").value,
          guests:       document.getElementById("guests").value,
          section:      document.getElementById("section").value,
          table_number: document.getElementById("table_number").value || null,
        };

        if (!payload.first_name || !payload.last_name || !payload.phone || !payload.date || !payload.time || !payload.guests || !payload.section) {
          showModal("Please fill in all fields before joining the waitlist.", "error");
          return;
        }

        try {
          await fetch(CSRF_URL, { credentials: "include" });
          var xsrf = getCookie("XSRF-TOKEN");

          var res = await fetch(API + "/waitlist", {
            method: "POST",
            credentials: "include",
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
              "Authorization": "Bearer " + token,
              "X-XSRF-TOKEN": xsrf,
            },
            body: JSON.stringify(payload),
          });
          var data = await res.json();

          if (res.ok) {
            showModal(data.message || "You have been added to the waitlist.", "success");
            btnJoinWaitlist.disabled = true;
            btnJoinWaitlist.textContent = "On Waitlist";
          } else {
            showModal(data.message || "Could not join the waitlist.", "error");
          }
        } catch (err) {
          console.error("Waitlist error:", err);
          showModal("Could not connect to the server. Please try again later.", "error");
        }
      });
    }

reservationForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      var phoneValue = document.getElementById("phone").value.replace(/\D/g, "");
      if (phoneValue.length !== 9) {
        showModal("Please enter a valid 9-digit phone number.", "error");
        return;
      }

      const payload = {
        first_name:   document.getElementById("first-name").value,
        last_name:    document.getElementById("last-name").value,
        phone:        document.getElementById("phone").value,
        date:         document.getElementById("date").value,
        time:         document.getElementById("time").value,
        guests:       document.getElementById("guests").value,
        section:      document.getElementById("section").value,
        table_number: document.getElementById("table_number").value || null,
        room_number:  document.getElementById("room-number").value || null,
        notes:        document.getElementById("notes").value,
      };

      try {
        await fetch(CSRF_URL, {
          credentials: "include",
        });

        const xsrf = getCookie("XSRF-TOKEN");

        const response = await fetch(API + "/reservations", {
          method: "POST",
          credentials: "include",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Bearer " + token,
            "X-XSRF-TOKEN": xsrf,
          },
          body: JSON.stringify(payload),
        });
        const data = await response.json();

        if (response.ok) {
          showReservationTicket(payload, data);
          reservationForm.reset();
          if (tablePicker) tablePicker.style.display = "none";
          if (tableInput)  tableInput.value = "";
        } else {
          const errorMsg = data.errors
            ? Object.values(data.errors).flat().join("<br>")
            : data.message;
          showModal(errorMsg || "Something went wrong. Please try again.", "error");
        }
      } catch (err) {
        console.error("Error:", err);
        showModal("Could not connect to the server. Please try again later.", "error");
      }
    });
  }

var reservationsList = document.getElementById("reservations-list");
  if (reservationsList) {

    var avatarImg   = document.getElementById("user-avatar");
    var displayName = document.getElementById("user-display-name");

    if (!token) {
      window.location.href = "/login?redirect=/my-reservations";
      return;
    }

    if (userName) {
      if (displayName) displayName.textContent = userName;
      if (avatarImg)   avatarImg.src = "https://ui-avatars.com/api/?name=" + encodeURIComponent(userName) + "&background=383227&color=ffcf7b";
    }

    function formatDate(dateStr) {
      var d = new Date(dateStr + "T00:00:00");
      var days   = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
      var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
      return days[d.getDay()] + ", " + months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
    }

    function formatTime(timeStr) {
      var parts = timeStr.split(":");
      var h = parseInt(parts[0], 10);
      var m = parts[1];
      var ampm = h >= 12 ? "PM" : "AM";
      h = h % 12 || 12;
      return h + ":" + m + " " + ampm;
    }

    function sectionLabel(section) {
      if (section === "private") return "Private Dining";
      if (section === "terrace") return "Terrace";
      if (section === "indoor")  return "Indoor";
      return section;
    }

    fetch(API + "/my-reservations", {
      headers: {
        "Authorization": "Bearer " + token,
        "Accept": "application/json",
      },
    })
    .then(function (res) {
      if (res.status === 401) {
        localStorage.removeItem("maison_token");
        localStorage.removeItem("maison_user");
        window.location.href = "/login?redirect=/my-reservations";
        return;
      }
      return res.json();
    })
    .then(function (json) {
      if (!json) return;
      reservationsList.innerHTML = "";

      var data = json.data || [];
      var restaurantItems = data.filter(function (r) { return !r.event_slug && !r.room_slug; });
      var eventItems      = data.filter(function (r) { return !!r.event_slug; });
      var roomItems       = data.filter(function (r) { return !!r.room_slug; });

      if (data.length === 0) {
        reservationsList.innerHTML =
          '<div class="reservation-category"><h3>Restaurant</h3></div>' +
          '<div class="reservation-board">' +
            '<div class="board-content empty">' +
              '<p>You have no reservations yet.</p>' +
              '<a href="/table" class="btn-reservar">Make a Reservation</a>' +
            '</div>' +
          '</div>';
        return;
      }

      var restHeader = document.createElement("div");
      restHeader.className = "reservation-category";
      restHeader.innerHTML = '<h3>Restaurant</h3>';
      reservationsList.appendChild(restHeader);

      if (restaurantItems.length === 0) {
        var emptyRest = document.createElement("div");
        emptyRest.className = "reservation-board";
        emptyRest.innerHTML =
          '<div class="board-content empty">' +
            '<p>No restaurant reservations.</p>' +
            '<a href="/table" class="btn-reservar">Make a Reservation</a>' +
          '</div>';
        reservationsList.appendChild(emptyRest);
      }

      restaurantItems.forEach(function (r) { renderReservationCard(r, "restaurant"); });

      var eventsHeader = document.createElement("div");
      eventsHeader.className = "reservation-category events-category";
      eventsHeader.innerHTML = '<h3>Events</h3>';
      reservationsList.appendChild(eventsHeader);

      if (eventItems.length === 0) {
        var emptyEv = document.createElement("div");
        emptyEv.className = "reservation-board";
        emptyEv.innerHTML =
          '<div class="board-content empty">' +
            '<p>You are not registered for any event yet.</p>' +
            '<a href="/events" class="btn-reservar">Browse Events</a>' +
          '</div>';
        reservationsList.appendChild(emptyEv);
      }

      eventItems.forEach(function (r) { renderReservationCard(r, "event"); });

      var roomsHeader = document.createElement("div");
      roomsHeader.className = "reservation-category rooms-category";
      roomsHeader.innerHTML = '<h3>Rooms</h3>';
      reservationsList.appendChild(roomsHeader);

      if (roomItems.length === 0) {
        var emptyRoom = document.createElement("div");
        emptyRoom.className = "reservation-board";
        emptyRoom.innerHTML =
          '<div class="board-content empty">' +
            '<p>You have not booked any room yet.</p>' +
            '<a href="/rooms" class="btn-reservar">Browse Rooms</a>' +
          '</div>';
        reservationsList.appendChild(emptyRoom);
      }

      roomItems.forEach(function (r) { renderReservationCard(r, "room"); });

      function renderReservationCard(r, kind) {
        var card = document.createElement("div");
        card.className = "reservation-card" +
          (kind === "event" ? " reservation-card-event" : "") +
          (kind === "room" ? " reservation-card-room" : "");

        var details = "";

        if (kind === "event" && r.event_title) {
          details += '<div class="card-row card-row-event-title">' +
            '<span class="card-label">Event</span>' +
            '<span class="card-value">' + r.event_title.replace(/</g, "&lt;").replace(/>/g, "&gt;") + '</span>' +
          '</div>';
        }

        if (kind === "room" && r.room_title) {
          details += '<div class="card-row card-row-event-title">' +
            '<span class="card-label">Room</span>' +
            '<span class="card-value">' + r.room_title.replace(/</g, "&lt;").replace(/>/g, "&gt;") + '</span>' +
          '</div>';
        }

        details += '<div class="card-row">' +
          '<span class="card-label">Date</span>' +
          '<span class="card-value">' + formatDate(r.date) + '</span>' +
        '</div>';

        details += '<div class="card-row">' +
          '<span class="card-label">Time</span>' +
          '<span class="card-value">' + formatTime(r.time) + '</span>' +
        '</div>';

        details += '<div class="card-row">' +
          '<span class="card-label">Guests</span>' +
          '<span class="card-value">' + r.guests + (r.guests === 1 ? ' guest' : ' guests') + '</span>' +
        '</div>';

        if (kind === "room") {
          if (r.checkout_date) {
            details += '<div class="card-row">' +
              '<span class="card-label">Check-out</span>' +
              '<span class="card-value">' + formatDate(r.checkout_date) + '</span>' +
            '</div>';
          }
          if (r.total_price) {
            details += '<div class="card-row">' +
              '<span class="card-label">Total paid</span>' +
              '<span class="card-value">€' + parseFloat(r.total_price).toFixed(2) + '</span>' +
            '</div>';
          }
        }

        if (kind === "restaurant") {
          details += '<div class="card-row">' +
            '<span class="card-label">Section</span>' +
            '<span class="card-value">' + sectionLabel(r.section) + '</span>' +
          '</div>';

          if (r.table_number) {
            details += '<div class="card-row">' +
              '<span class="card-label">Table</span>' +
              '<span class="card-value">Table ' + r.table_number + '</span>' +
            '</div>';
          }

          if (r.room_number) {
            details += '<div class="card-row">' +
              '<span class="card-label">Room</span>' +
              '<span class="card-value">Room ' + r.room_number + '</span>' +
            '</div>';
          }
        } else if (r.room_number) {
          details += '<div class="card-row">' +
            '<span class="card-label">Location</span>' +
            '<span class="card-value">' + r.room_number.replace(/</g, "&lt;").replace(/>/g, "&gt;") + '</span>' +
          '</div>';
        }

        if (r.notes) {
          details += '<div class="card-row card-row-notes">' +
            '<span class="card-label">Notes</span>' +
            '<span class="card-value">' + r.notes.replace(/</g, "&lt;").replace(/>/g, "&gt;") + '</span>' +
          '</div>';
        }

        var headerBadge = kind === "event"
          ? '<span class="card-section-badge event-badge">★ Event</span>'
          : kind === "room"
            ? '<span class="card-section-badge room-badge">⌂ Room</span>'
            : '<span class="card-section-badge ' + r.section + '">' + sectionLabel(r.section) + '</span>';

        var titleLine = kind === "event"
          ? (r.first_name + ' ' + r.last_name)
          : (r.first_name + ' ' + r.last_name);

        card.innerHTML =
          '<div class="card-header">' +
            headerBadge +
            '<span class="card-date-short">' + r.date + '</span>' +
          '</div>' +
          '<div class="card-name">' + titleLine + '</div>' +
          '<div class="card-details">' + details + '</div>' +
          '<div class="card-qr-section">' +
            '<div class="card-qr" id="qr-' + r.id + '"></div>' +
            '<div class="card-qr-code">' +
              '<span>Confirmation</span>' +
              '<strong>MD-' + String(r.id).padStart(5, "0") + '</strong>' +
            '</div>' +
          '</div>' +
          '<div class="card-actions">' +
            '<button class="btn-cancel-reservation" data-id="' + r.id + '">' +
              (kind === "event" ? 'Cancel Registration' : kind === "room" ? 'Cancel Booking' : 'Cancel Reservation') +
            '</button>' +
          '</div>';

        reservationsList.appendChild(card);

        try {
          if (typeof QRCode !== "undefined") {
            new QRCode(document.getElementById("qr-" + r.id), {
              text: "MD-" + String(r.id).padStart(5, "0") + "|" + r.date + "|" + r.time,
              width: 80,
              height: 80,
              colorDark: "#1a1a1a",
              colorLight: "#ffffff",
              correctLevel: QRCode.CorrectLevel.M,
            });
          }
        } catch (e) { /* silent */ }

        card.querySelector(".btn-cancel-reservation").addEventListener("click", function () {
          var reservationId = this.getAttribute("data-id");
          var thisCard = card;

          // Room bookings get a richer modal showing the refund summary
          // (amount, policy and method) before asking for the password.
          if (kind === "room" && r.total_price) {
            showRoomRefundModal(r, function (password, refundMethod) {
              cancelReservation(reservationId, thisCard, password, refundMethod, kind);
            });
            return;
          }

          var confirmMsg = kind === "event"
            ? "Are you sure you want to cancel this event registration?"
            : "Are you sure you want to cancel this reservation?";
          showConfirmModal(confirmMsg, function (password) {
            cancelReservation(reservationId, thisCard, password, null, kind);
          });
        });
      }
    })
    .catch(function (err) {
      console.error("Error loading reservations:", err);
      reservationsList.innerHTML =
        '<div class="reservation-board">' +
          '<div class="board-content empty">' +
            '<p>Could not load your reservations.</p>' +
            '<a href="/my-reservations" class="btn-reservar">Try Again</a>' +
          '</div>' +
        '</div>';
    });

    fetch(API + "/my-waitlist", {
      headers: {
        "Authorization": "Bearer " + token,
        "Accept": "application/json",
      },
    })
    .then(function (res) { return res.json(); })
    .then(function (json) {
      if (!json.data || json.data.length === 0) return;

      var waitlistHeader = document.createElement("div");
      waitlistHeader.className = "reservation-category";
      waitlistHeader.innerHTML = '<h3>Waitlist</h3>';
      reservationsList.appendChild(waitlistHeader);

      json.data.forEach(function (w) {
        var card = document.createElement("div");
        card.className = "reservation-card waitlist-card";

        var details = '';
        details += '<div class="card-row"><span class="card-label">Date</span><span class="card-value">' + formatDate(w.date) + '</span></div>';
        details += '<div class="card-row"><span class="card-label">Time</span><span class="card-value">' + formatTime(w.time) + '</span></div>';
        details += '<div class="card-row"><span class="card-label">Guests</span><span class="card-value">' + w.guests + '</span></div>';
        details += '<div class="card-row"><span class="card-label">Section</span><span class="card-value">' + sectionLabel(w.section) + '</span></div>';

        card.innerHTML =
          '<div class="card-header">' +
            '<span class="card-section-badge waitlist">Waitlist</span>' +
            '<span class="card-date-short">' + w.date + '</span>' +
          '</div>' +
          '<div class="card-name">' + w.first_name + ' ' + w.last_name + '</div>' +
          '<div class="card-details">' + details + '</div>' +
          '<div class="card-actions">' +
            '<button class="btn-cancel-reservation btn-remove-waitlist" data-id="' + w.id + '">Remove from Waitlist</button>' +
          '</div>';

        card.querySelector(".btn-remove-waitlist").addEventListener("click", function () {
          var wId = this.getAttribute("data-id");
          var thisCard = card;
          fetch(CSRF_URL, { credentials: "include" }).then(function () {
            var xsrf = getCookie("XSRF-TOKEN");
            fetch(API + "/waitlist/" + wId, {
              method: "DELETE",
              credentials: "include",
              headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json",
                "X-XSRF-TOKEN": xsrf,
              },
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
              if (data.success) {
                thisCard.remove();
                var remaining = reservationsList.querySelectorAll(".waitlist-card");
                if (remaining.length === 0) {
                  var wh = reservationsList.querySelectorAll(".reservation-category");
                  wh.forEach(function (h) {
                    if (h.textContent.trim() === "Waitlist") h.remove();
                  });
                }
                showModal("Removed from waitlist.", "success");
              } else {
                showModal(data.message || "Could not remove from waitlist.", "error");
              }
            });
          });
        });

        reservationsList.appendChild(card);
      });
    })
    .catch(function (err) {
      console.error("Error loading waitlist:", err);
    });
  }

(function () {
    var trigger   = document.getElementById("date-trigger");
    var calendar  = document.getElementById("custom-calendar");
    var dateInput = document.getElementById("date");
    var display   = document.getElementById("date-display");
    var daysEl    = document.getElementById("cal-days");
    var monthYear = document.getElementById("cal-month-year");
    var prevBtn   = document.getElementById("cal-prev");
    var nextBtn   = document.getElementById("cal-next");

    if (!trigger || !calendar || !dateInput) return;

    var today = new Date();
    var viewYear  = today.getFullYear();
    var viewMonth = today.getMonth();
    var selectedDate = null;

    var monthNames = ["January","February","March","April","May","June",
                      "July","August","September","October","November","December"];

    function pad(n) { return n < 10 ? "0" + n : "" + n; }

    function renderCalendar() {
      monthYear.textContent = monthNames[viewMonth] + " " + viewYear;
      daysEl.innerHTML = "";

      var firstDay = new Date(viewYear, viewMonth, 1).getDay();
      var offset = (firstDay + 6) % 7; // Monday = 0
      var daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
      var todayStr = today.getFullYear() + "-" + pad(today.getMonth() + 1) + "-" + pad(today.getDate());

      for (var i = 0; i < offset; i++) {
        var empty = document.createElement("span");
        empty.className = "cal-day empty";
        daysEl.appendChild(empty);
      }

      for (var d = 1; d <= daysInMonth; d++) {
        var dayEl = document.createElement("span");
        dayEl.className = "cal-day";
        dayEl.textContent = d;

        var dateStr = viewYear + "-" + pad(viewMonth + 1) + "-" + pad(d);
        dayEl.setAttribute("data-date", dateStr);

        var cellDate = new Date(viewYear, viewMonth, d);
        if (cellDate < new Date(today.getFullYear(), today.getMonth(), today.getDate())) {
          dayEl.classList.add("disabled");
        }

        if (dateStr === todayStr) dayEl.classList.add("today");
        if (selectedDate === dateStr) dayEl.classList.add("selected");

        dayEl.addEventListener("click", function () {
          if (this.classList.contains("disabled")) return;
          selectedDate = this.getAttribute("data-date");
          dateInput.value = selectedDate;

          var parts = selectedDate.split("-");
          var dt = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
          var dayNames = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
          var shortMonths = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
          display.textContent = dayNames[dt.getDay()] + ", " + shortMonths[dt.getMonth()] + " " + dt.getDate() + ", " + dt.getFullYear();
          trigger.classList.add("has-value");

          calendar.classList.remove("open");
          dateInput.dispatchEvent(new Event("change"));
          renderCalendar();
        });

        daysEl.appendChild(dayEl);
      }
    }

    trigger.addEventListener("click", function (e) {
      e.stopPropagation();
      calendar.classList.toggle("open");
    });

    prevBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      viewMonth--;
      if (viewMonth < 0) { viewMonth = 11; viewYear--; }
      renderCalendar();
    });

    nextBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      viewMonth++;
      if (viewMonth > 11) { viewMonth = 0; viewYear++; }
      renderCalendar();
    });

    document.addEventListener("click", function (e) {
      if (!calendar.contains(e.target) && e.target !== trigger && !trigger.contains(e.target)) {
        calendar.classList.remove("open");
      }
    });

    if (dateInput.value) {
      selectedDate = dateInput.value;
      var parts = selectedDate.split("-");
      var dt = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
      var dayNames = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
      var shortMonths = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
      display.textContent = dayNames[dt.getDay()] + ", " + shortMonths[dt.getMonth()] + " " + dt.getDate() + ", " + dt.getFullYear();
      trigger.classList.add("has-value");
      viewYear = dt.getFullYear();
      viewMonth = dt.getMonth();
    }

    renderCalendar();
  })();

(function () {
    var timeInput = document.getElementById("time");
    var lunchEl   = document.getElementById("time-slots-lunch");
    var dinnerEl  = document.getElementById("time-slots-dinner");

    if (!timeInput || !lunchEl || !dinnerEl) return;

    var lunchSlots  = ["09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00"];
    var dinnerSlots = ["19:00","20:00","21:00","22:00","23:00","00:00"];

    function createSlot(time, container) {
      var btn = document.createElement("span");
      btn.className = "time-slot";
      btn.textContent = time;
      btn.setAttribute("data-time", time);
      btn.addEventListener("click", function () {
        if (btn.classList.contains("fully-booked")) return;
        document.querySelectorAll(".time-slot").forEach(function (s) {
          s.classList.remove("selected");
        });
        btn.classList.add("selected");
        timeInput.value = time;
        timeInput.dispatchEvent(new Event("change"));
      });
      container.appendChild(btn);
    }

    lunchSlots.forEach(function (t) { createSlot(t, lunchEl); });
    dinnerSlots.forEach(function (t) { createSlot(t, dinnerEl); });

    if (timeInput.value) {
      var existing = document.querySelector('.time-slot[data-time="' + timeInput.value + '"]');
      if (existing) existing.classList.add("selected");
    }

    var sectionSelect = document.getElementById("section");
    var guestsSelect  = document.getElementById("guests");
    var dateInput     = document.getElementById("date");

    function updateBookedHours() {
      var section = sectionSelect ? sectionSelect.value : "";
      var guests  = guestsSelect  ? guestsSelect.value  : "";
      var date    = dateInput     ? dateInput.value      : "";

      document.querySelectorAll(".time-slot").forEach(function (s) {
        s.classList.remove("fully-booked");
        s.title = "";
      });

      if (!section || section === "private" || !guests || !date) return;

      var params = new URLSearchParams({ section: section, guests: guests, date: date });
      fetch(API + "/tables/booked-hours?" + params, {
        headers: { Accept: "application/json" },
      })
      .then(function (r) { return r.json(); })
      .then(function (json) {
        if (!json.success || !json.data) return;
        json.data.forEach(function (hour) {
          var slot = document.querySelector('.time-slot[data-time="' + hour + '"]');
          if (slot) {
            slot.classList.add("fully-booked");
            slot.title = "Fully booked at this hour";
            if (slot.classList.contains("selected")) {
              slot.classList.remove("selected");
              timeInput.value = "";
              timeInput.dispatchEvent(new Event("change"));
            }
          }
        });
      })
      .catch(function (err) { console.error("Error checking booked hours:", err); });
    }

    if (sectionSelect) sectionSelect.addEventListener("change", updateBookedHours);
    if (guestsSelect)  guestsSelect.addEventListener("change", updateBookedHours);
    if (dateInput)     dateInput.addEventListener("change", updateBookedHours);
  })();

});