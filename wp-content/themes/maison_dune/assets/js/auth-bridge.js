document.addEventListener("DOMContentLoaded", function () {
  // --- LOGIN ---
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const payload = {
        email: document.getElementById("email").value,
        password: document.getElementById("password").value,
      };

      try {
        // CAMBIO AQUÍ: Apuntamos a la subcarpeta y al index de Laravel
        const response = await fetch(
          "http://maison.test/maison_dune_api/public/index.php/api/login",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            body: JSON.stringify(payload),
          },
        );

        const data = await response.json();

        if (response.ok) {
          alert("¡Bienvenido de nuevo!");
          localStorage.setItem("maison_token", data.access_token);
        } else {
          alert("Error: " + (data.message || "Credenciales incorrectas"));
        }
      } catch (err) {
        console.error("Error:", err);
        alert(
          "No se pudo conectar con el servidor de Laravel. Verifica la URL.",
        );
      }
    });
  }

  // --- REGISTRO ---
  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const password = document.getElementById("password").value;
      const confirm = document.getElementById("password_confirm").value;

      if (password !== confirm) {
        alert("Las contraseñas no coinciden.");
        return;
      }

      const payload = {
        name: document.getElementById("username").value,
        email: document.getElementById("email").value,
        password: password,
      };

      try {
        // CAMBIO AQUÍ: Apuntamos a la subcarpeta y al index de Laravel
        const response = await fetch(
          "http://maison.test/maison_dune_api/public/index.php/api/register",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            body: JSON.stringify(payload),
          },
        );

        const data = await response.json();

        if (response.status === 201) {
          alert("Cuenta creada con éxito.");
          localStorage.setItem("maison_token", data.access_token);
        } else {
          let errorMsg = data.errors
            ? Object.values(data.errors).flat().join("\n")
            : data.message;
          alert("Error en el registro:\n" + errorMsg);
        }
      } catch (err) {
        console.error("Error:", err);
        alert("No se pudo conectar con el servidor de Laravel.");
      }
    });
  }
});
