document.addEventListener("DOMContentLoaded", function () {

  const API = "http://maison.test/maison_dune_api/public/index.php/api";
  const token    = localStorage.getItem("maison_token");
  const userName = localStorage.getItem("maison_user");

  // Lee una cookie por nombre (necesario para extraer el XSRF-TOKEN)
  function getCookie(name) {
    var match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
    return match ? decodeURIComponent(match[2]) : null;
  }


  // ── MODAL DE NOTIFICACIONES ───────────────────────────────────────────────
  // Crea un modal dinámico para mostrar mensajes al usuario (error, éxito, info)
  // Si se pasa onClose, se ejecuta al cerrar el modal

  function showConfirmModal(message, onConfirm) {
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
          '<button class="modal-btn-cancel">No, Keep It</button>' +
          '<button class="modal-btn-confirm">Yes, Cancel</button>' +
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


  // ── PROTECCIÓN DE FORMULARIOS ─────────────────────────────────────────────
  // Si el usuario no está logueado, guarda los datos y redirige al login

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

  // Restaurar datos del formulario si vuelve del login
  if (reservationForm) {
    var saved = localStorage.getItem("maison_form_backup");
    if (saved) {
      var fields = JSON.parse(saved);
      Object.keys(fields).forEach(function (id) {
        var el = document.getElementById(id);
        if (el && fields[id]) el.value = fields[id];
      });
      localStorage.removeItem("maison_form_backup");

      // Disparar cambio de sección para mostrar el campo de habitación si aplica
      var sectionEl = document.getElementById("section");
      if (sectionEl) sectionEl.dispatchEvent(new Event("change"));
    }
  }


  // ── MENÚ DE USUARIO (NAV) ────────────────────────────────────────────────
  // Cambia el icono de login por el menú con nombre y dropdown si hay sesión

  const loginLink = document.getElementById("login-link");
  const userMenu  = document.getElementById("user-menu-wrapper");
  const toggle    = document.getElementById("user-menu-toggle");
  const dropdown  = document.querySelector(".user-dropdown");

  if (token && userName) {
    if (loginLink) loginLink.style.display = "none";
    if (userMenu)  userMenu.style.display  = "block";

    const userWelcome = document.getElementById("user-welcome");
    if (userWelcome) userWelcome.textContent = "Welcome " + userName;

    // Cierre automático por inactividad (90 min) — funciona incluso si cierra la web
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

    // Comprobar si ya expiró mientras el usuario estaba fuera
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

    // Cerrar sesión — borra token del servidor y del localStorage
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
  }


  // ── LOGIN ─────────────────────────────────────────────────────────────────
  // Pide cookie CSRF antes de enviar credenciales (Sanctum SPA)
  // Si el email no está verificado, reenvía el enlace

  const loginForm = document.getElementById("login-form");
  if (loginForm) {

    // Auto-login si viene de verificar email (?token=xxx)
    var loginParams = new URLSearchParams(window.location.search);
    var verifyToken = loginParams.get("token");
    if (verifyToken) {
      localStorage.setItem("maison_token", verifyToken);
      localStorage.setItem("maison_last_activity", Date.now().toString());

      fetch(API + "/user", {
        headers: { "Authorization": "Bearer " + verifyToken, "Accept": "application/json" },
      })
      .then(function (res) { return res.json(); })
      .then(function (user) {
        localStorage.setItem("maison_user", user.name);
        showModal("Your email has been verified. Welcome!", "success", function () {
          window.location.href = "/";
        });
      })
      .catch(function () {
        window.location.href = "/";
      });
    }

    const usernameInput = document.getElementById("username");
    if (usernameInput) {
      usernameInput.addEventListener("input", function () {
        this.value = this.value.replace(/\s/g, "");
      });
    }

    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const payload = {
        name:     document.getElementById("username").value,
        email:    document.getElementById("email").value,
        password: document.getElementById("password").value,
      };

      try {
        // Cookie CSRF necesaria para Sanctum
        await fetch("http://maison.test/maison_dune_api/public/index.php/sanctum/csrf-cookie", {
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


  // ── REGISTRO ──────────────────────────────────────────────────────────────
  // Valida que las contraseñas coincidan antes de enviar

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
        await fetch("http://maison.test/maison_dune_api/public/index.php/sanctum/csrf-cookie", {
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


  // ── OLVIDÉ MI CONTRASEÑA ──────────────────────────────────────────────────
  // Envía un enlace de recuperación al email del usuario

  const forgotForm = document.getElementById("forgot-password-form");
  if (forgotForm) {
    forgotForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      try {
        await fetch("http://maison.test/maison_dune_api/public/index.php/sanctum/csrf-cookie", {
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


  // ── RESETEAR CONTRASEÑA ───────────────────────────────────────────────────
  // Coge token y email de la URL (vienen del enlace del correo)

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
        await fetch("http://maison.test/maison_dune_api/public/index.php/sanctum/csrf-cookie", {
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


  // ── RESERVAS ──────────────────────────────────────────────────────────────
  // Solo se activa si existe el formulario y el usuario tiene token

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


    // Muestra/oculta el campo de nº de habitación según la sección elegida
    function toggleRoomNumber() {
      var isPrivate = sectionSelect && sectionSelect.value === "private";
      if (roomNumberGroup) roomNumberGroup.style.display = isPrivate ? "flex" : "none";
      if (roomNumberInput && !isPrivate) roomNumberInput.value = "";
    }

    if (sectionSelect) sectionSelect.addEventListener("change", toggleRoomNumber);

    // Si viene ?section=private desde la página de room service, preseleccionar
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("section") && sectionSelect) {
      sectionSelect.value = urlParams.get("section");
      toggleRoomNumber();
    }


    // Consulta mesas disponibles según sección, fecha, hora y nº de personas
    async function fetchAvailability() {
      const section = sectionSelect ? sectionSelect.value : "";
      const guests  = guestsSelect  ? guestsSelect.value  : "";
      const date    = dateInput     ? dateInput.value      : "";
      const time    = timeInput     ? timeInput.value      : "";

      // No mostrar mesas si falta algún dato o es habitación privada
      if (!section || section === "private" || !guests || !date || !time) {
        if (tablePicker) tablePicker.style.display = "none";
        if (tableInput)  tableInput.value = "";
        return;
      }

      // Horario del restaurante: 09:00 a 00:00 — fuera de ese rango no hay mesas
      var hour = parseInt(time.split(":")[0], 10);
      if (hour >= 1 && hour < 9) {
        if (tablePicker) tablePicker.style.display = "none";
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
          tableInput.value = "";
          return;
        }

        // Renderizar tarjetas de mesas
        tableGrid.innerHTML = "";
        tableInput.value = "";

        json.data.forEach(function (t) {
          const card = document.createElement("div");
          card.className = "table-card" + (t.available ? "" : " unavailable");
          card.innerHTML =
            '<span class="table-card-number">Table ' + t.table_number + '</span>' +
            '<span class="table-card-cap">' + t.capacity + ' seats</span>';

          if (t.available) {
            card.addEventListener("click", function () {
              tableGrid.querySelectorAll(".table-card").forEach(function (c) {
                c.classList.remove("selected");
              });
              card.classList.add("selected");
              tableInput.value = t.table_number;
            });
          }
          tableGrid.appendChild(card);
        });

        tablePicker.style.display = "block";
      } catch (err) {
        console.error("Error cargando mesas:", err);
      }
    }

    // Recargar disponibilidad cada vez que cambie un campo del formulario
    if (sectionSelect) sectionSelect.addEventListener("change", fetchAvailability);
    if (guestsSelect)  guestsSelect.addEventListener("change", fetchAvailability);
    if (dateInput)     dateInput.addEventListener("change", fetchAvailability);
    if (timeInput)     timeInput.addEventListener("change", fetchAvailability);


    // Enviar reserva a la API
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
        await fetch("http://maison.test/maison_dune_api/public/index.php/sanctum/csrf-cookie", {
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
          showModal("Your reservation has been submitted. We look forward to welcoming you.", "success", () => {
            window.location.href = "/";
          });
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


  // ── MIS RESERVAS ──────────────────────────────────────────────────────────
  // Carga las reservas del usuario desde la API y las muestra en tarjetas

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

      if (!json.data || json.data.length === 0) {
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

      var categoryHeader = document.createElement("div");
      categoryHeader.className = "reservation-category";
      categoryHeader.innerHTML = '<h3>Restaurant</h3>';
      reservationsList.appendChild(categoryHeader);

      json.data.forEach(function (r) {
        var card = document.createElement("div");
        card.className = "reservation-card";

        var details = "";

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

        if (r.notes) {
          details += '<div class="card-row card-row-notes">' +
            '<span class="card-label">Notes</span>' +
            '<span class="card-value">' + r.notes.replace(/</g, "&lt;").replace(/>/g, "&gt;") + '</span>' +
          '</div>';
        }

        card.innerHTML =
          '<div class="card-header">' +
            '<span class="card-section-badge ' + r.section + '">' + sectionLabel(r.section) + '</span>' +
            '<span class="card-date-short">' + r.date + '</span>' +
          '</div>' +
          '<div class="card-name">' + r.first_name + ' ' + r.last_name + '</div>' +
          '<div class="card-details">' + details + '</div>' +
          '<div class="card-actions">' +
            '<button class="btn-cancel-reservation" data-id="' + r.id + '">Cancel Reservation</button>' +
          '</div>';

        card.querySelector(".btn-cancel-reservation").addEventListener("click", function () {
          var reservationId = this.getAttribute("data-id");
          var thisCard = card;
          showConfirmModal("Are you sure you want to cancel this reservation?", function (password) {
            fetch("http://maison.test/maison_dune_api/public/index.php/sanctum/csrf-cookie", {
              credentials: "include",
            }).then(function () {
            var xsrf = getCookie("XSRF-TOKEN");
            fetch(API + "/reservations/" + reservationId, {
              method: "DELETE",
              credentials: "include",
              headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token,
                "Accept": "application/json",
                "X-XSRF-TOKEN": xsrf,
              },
              body: JSON.stringify({ password: password }),
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
              if (data.success) {
                thisCard.remove();
                var remaining = reservationsList.querySelectorAll(".reservation-card");
                if (remaining.length === 0) {
                  var cat = reservationsList.querySelector(".reservation-category");
                  if (cat) cat.remove();
                  reservationsList.innerHTML =
                    '<div class="reservation-category"><h3>Restaurant</h3></div>' +
                    '<div class="reservation-board">' +
                      '<div class="board-content empty">' +
                        '<p>You have no reservations yet.</p>' +
                        '<a href="/table" class="btn-reservar">Make a Reservation</a>' +
                      '</div>' +
                    '</div>';
                }
                showModal("Reservation cancelled successfully.", "success");
              } else {
                showModal(data.message || "Could not cancel the reservation.", "error");
              }
            })
            .catch(function () {
              showModal("Could not connect to the server. Please try again later.", "error");
            });
            });
          });
        });

        reservationsList.appendChild(card);
      });
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
  }

});