document.addEventListener("DOMContentLoaded", function () {

  // ── MODAL ─────────────────────────────────────────────────────────────────
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
      closeModal(modal);
      if (onClose) onClose();
    }

    modal.querySelector(".modal-close").addEventListener("click", handleClose);
    modal.addEventListener("click", (e) => { if (e.target === modal) handleClose(); });
  }


  function closeModal(modal) {
    modal.classList.remove("visible");
    setTimeout(() => modal.remove(), 300);
  }

  // ── PROTEGER FORMULARIOS ──────────────────────────────────────────────────
  const protectedForms = ["book-table-form"];
  const token    = localStorage.getItem("maison_token");
  const userName = localStorage.getItem("maison_user");

protectedForms.forEach(function (formId) {
  const form = document.getElementById(formId);
  if (form && !token) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      showModal("Please, log in or register for any request.", "success", function () {
        window.location.href = "/login";
      });
    });
  }
});

  // ── MENÚ DE USUARIO ───────────────────────────────────────────────────────
  const loginLink   = document.getElementById("login-link");
  const userMenu    = document.getElementById("user-menu-wrapper");
  const userWelcome = document.getElementById("user-welcome");
  const toggle      = document.getElementById("user-menu-toggle");
  const dropdown    = document.querySelector(".user-dropdown");
  const logoutBtn   = document.getElementById("logout-btn");

  if (token && userName) {
    if (loginLink)   loginLink.style.display = "none";
    if (userMenu)    userMenu.style.display   = "block";
    if (userWelcome) userWelcome.textContent  = "Welcome " + userName;

    if (toggle && dropdown) {
      toggle.addEventListener("click", function () {
        dropdown.classList.toggle("open");
      });
    }

    if (logoutBtn) {
      logoutBtn.addEventListener("click", async function (e) {
        e.preventDefault();

        try {
          await fetch("http://maison.test/maison_dune_api/public/index.php/api/logout", {
            method: "POST",
            headers: {
              "Authorization": "Bearer " + token,
              "Accept": "application/json",
            },
          });
        } catch (err) {
          console.error("Logout error:", err);
        }

        localStorage.removeItem("maison_token");
        localStorage.removeItem("maison_user");
        showModal("You have been logged out successfully.", "success", () => {
          window.location.href = "/" 
        });
      });
    }
  }

  // ── LOGIN ─────────────────────────────────────────────────────────────────
  const loginForm = document.getElementById("login-form");
  if (loginForm) {

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
        const response = await fetch(
          "http://maison.test/maison_dune_api/public/index.php/api/login",
          {
            method: "POST",
            headers: { "Content-Type": "application/json", Accept: "application/json" },
            body: JSON.stringify(payload),
          }
        );

        const data = await response.json();

        if (response.ok) {
          localStorage.setItem("maison_token", data.access_token);
          localStorage.setItem("maison_user", data.user.name);
          showModal("You are logged in.", "success", () => {
          window.location.href = "/" 
        })
        
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
        const response = await fetch(
          "http://maison.test/maison_dune_api/public/index.php/api/register",
          {
            method: "POST",
            headers: { "Content-Type": "application/json", Accept: "application/json" },
            body: JSON.stringify(payload),
          }
        );

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

});