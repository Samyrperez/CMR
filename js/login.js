document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const mensaje = document.getElementById("mensaje"); 
    
    loginForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        const email = document.getElementById("email").value.trim(); // trim() elimina espacios en blanco al inicio y al final.
        const password = document.getElementById("password").value.trim();

        // Validación de los campos vaciós
        if (!email || !password) {
            mensaje.textContent = "❌ Todos los campos son obligatorios";
            mensaje.style.color = "red";
            return;
        }

        // Se agregan email y password a formData.
        const formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);


        console.log("Enviando datos a login.php..."); // 🔍 Verificar si fetch() se ejecuta

        try {
            const response = await fetch("login.php", {
                method: "POST",
                body: formData //  Envía formData al servidor.
            });

            console.log("Respuesta recibida:", response); // 🔍 Verificar respuesta

            const data = await response.json();

            if (data.success) {
                mensaje.textContent = "✅ Inicio de sesión exitoso. Redirigiendo...";
                mensaje.style.color = "green";
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500); // Usa setTimeout() para redirigir después de 1.5 segundos.
            } else {
                mensaje.textContent = "❌ " + data.message;
                mensaje.style.color = "red";
            }
        } catch (error) {
            console.error("Error en fetch:", error); // 🔍 Verificar errores en fetch
            mensaje.textContent = "❌ Error en la conexión con el servidor";
            mensaje.style.color = "red";
        }
    });
});

// ✅ Resumen
// El código gestiona el inicio de sesión verificando los datos ingresados.

// Se envían los datos con fetch() a login.php.

// Se maneja la respuesta del servidor y se muestran mensajes en la página.

// En caso de éxito, el usuario es redirigido.

// En caso de error, se muestra un mensaje.