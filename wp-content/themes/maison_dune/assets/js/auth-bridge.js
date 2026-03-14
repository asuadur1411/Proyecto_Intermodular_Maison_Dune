document.addEventListener("DOMContentLoaded", function () {

  // Proteger páginas que requieren login
  const protectedForms = ['book-table-form'];

  // --- MENÚ DE USUARIO (se ejecuta en todas las páginas) ---
  const token    = localStorage.getItem("maison_token");
  const userName = localStorage.getItem("maison_user");

  const loginLink   = document.getElementById("login-link");
  const userMenu    = document.getElementById("user-menu-wrapper");
  const userWelcome = document.getElementById("user-welcome");
  const toggle      = document.getElementById("user-menu-toggle");
  const dropdown    = document.querySelector(".user-dropdown");
  const logoutBtn   = document.getElementById("logout-btn");

  // Redirigir a login si el formulario protegido se envía sin sesión
  protectedForms.forEach(function (formId) {
    const form = document.getElementById(formId);
    if (form && !token) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        window.location.href = "/login";
      });
    }
  });

  if (token && userName) {
    // Usuario logueado: ocultar enlace de login y mostrar menú
    if (loginLink)   loginLink.style.display = "none";
    if (userMenu)    userMenu.style.display   = "block";
    if (userWelcome) userWelcome.textContent  = "Welcome " + userName;

    // Abrir y cerrar el desplegable
    if (toggle && dropdown) {
      toggle.addEventListener("click", function () {
        dropdown.classList.toggle("open");
      });
    }

    // Cerrar sesión — revocar token en Laravel y limpiar localStorage
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
        window.location.href = "/";
      });
    }
  }

  // --- LOGIN ---
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const payload = {
        email:    document.getElementById("email").value,
        password: document.getElementById("password").value,
      };

      try {
        // Apuntamos a la subcarpeta y al index de Laravel
        const response = await fetch(
          "http://maison.test/maison_dune_api/public/index.php/api/login",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            body: JSON.stringify(payload),
          }
        );

        const data = await response.json();

        if (response.ok) {
          localStorage.setItem("maison_token", data.access_token);
          localStorage.setItem("maison_user", data.user.name);
          window.location.href = "/";
        } else if (data.status === "unverified") {
          alert("Please check your email and click the verification link to activate your account.");
        } else {
          alert("Error: " + (data.message || "Incorrect credentials"));
        }

      } catch (err) {
        console.error("Error:", err);
        alert("Could not connect to the server. Please try again later.");
      }
    });
  }

  // --- REGISTRO ---
  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const password = document.getElementById("password").value;
      const confirm  = document.getElementById("password_confirm").value;

      if (password !== confirm) {
        alert("Passwords do not match.");
        return;
      }

      const payload = {
        name:     document.getElementById("username").value,
        email:    document.getElementById("email").value,
        password: password,
      };

      try {
        // Apuntamos a la subcarpeta y al index de Laravel
        const response = await fetch(
          "http://maison.test/maison_dune_api/public/index.php/api/register",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            body: JSON.stringify(payload),
          }
        );

        const data = await response.json();

        if (response.status === 201) {
          alert("Account created! Please check your email to verify your account.");
          window.location.href = "/";
        } else {
          const errorMsg = data.errors
            ? Object.values(data.errors).flat().join("\n")
            : data.message;
          alert("Registration error:\n" + errorMsg);
        }

      } catch (err) {
        console.error("Error:", err);
        alert("Could not connect to the server. Please try again later.");
      }
    });
  }

});