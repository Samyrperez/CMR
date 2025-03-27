document.addEventListener("DOMContentLoaded", function () {
    async function cargarUsuarios() {
        try {
            const response = await fetch("fetch_usuarios.php");
            const usuarios = await response.json();

            const tbody = document.getElementById("usuariosTabla");
            tbody.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos

            usuarios.forEach(usuario => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${usuario.id}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.email}</td>
                    <td>${usuario.rol}</td>
                    <td>${usuario.estado == 1 ? "Activo" : "Inactivo"}</td>
                    <td>
                        <button class="editar-btn" data-id="${usuario.id}">✏️ Editar</button>
                        <button class="eliminar-btn" data-id="${usuario.id}">🗑️ Eliminar</button>
                    </td>
                `;
                tbody.appendChild(fila);
            });

            document.querySelectorAll(".editar-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const id = this.getAttribute("data-id");
                    editarUsuario(id);
                });
            });

            document.querySelectorAll(".eliminar-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const id = this.getAttribute("data-id");
                    eliminarUsuario(id);
                });
            });
        } catch (error) {
            console.error("Error al cargar usuarios:", error);
        }
    }

    async function editarUsuario(id) {
        try {
            const response = await fetch(`editar_usuario.php?id=${id}`);
            const usuario = await response.json();
    
            if (!document.getElementById("formEditar")) {
                const formEditar = document.createElement("form");
                formEditar.id = "formEditar";
                formEditar.innerHTML = `
                    <h3>Editar Usuario</h3>
                    <input type="hidden" name="id" value="${usuario.id}">
    
                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="${usuario.nombre}" required>
    
                    <label>Email:</label>
                    <input type="email" name="email" value="${usuario.email}" required>
    
                    <label>Rol:</label>
                    <select name="rol">
                        <option value="admin" ${usuario.rol === "admin" ? "selected" : ""}>Admin</option>
                        <option value="usuario" ${usuario.rol === "usuario" ? "selected" : ""}>Usuario</option>
                    </select>
    
                    <label>Estado:</label>
                    <select name="estado">
                        <option value="1" ${usuario.estado == 1 ? "selected" : ""}>Activo</option>
                        <option value="0" ${usuario.estado == 0 ? "selected" : ""}>Inactivo</option>
                    </select>
    
                    <button type="submit">Actualizar</button>
                    <button type="button" id="cerrarFormEditar">Cancelar</button>
                `;
    
                document.body.appendChild(formEditar);
    
                // Evento para cerrar el formulario
                document.getElementById("cerrarFormEditar").addEventListener("click", () => {
                    formEditar.remove();
                });
    
                // Evento para actualizar usuario
                formEditar.addEventListener("submit", async function (event) {
                    event.preventDefault();
                    const formData = new FormData(formEditar);
    
                    try {
                        const updateResponse = await fetch("actualizar_usuario.php", {
                            method: "POST",
                            body: formData
                        });
                        const resultado = await updateResponse.json();
    
                        if (resultado.success) {
                            alert("Usuario actualizado correctamente");
                            formEditar.remove();
                            cargarUsuarios();
                        } else {
                            alert("Error al actualizar usuario");
                        }
                    } catch (error) {
                        console.error("Error al actualizar usuario:", error);
                    }
                });
            }
        } catch (error) {
            console.error("Error al obtener datos del usuario:", error);
        }
    }
    

    async function eliminarUsuario(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
            try {
                const response = await fetch("eliminar_usuario.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `id=${id}`
                });

                const resultado = await response.json();

                if (resultado.success) {
                    alert("Usuario eliminado correctamente");
                    cargarUsuarios(); // Recargar la lista de usuarios
                } else {
                    alert("Error al eliminar usuario");
                }
            } catch (error) {
                console.error("Error al eliminar usuario:", error);
            }
        }
    }

    async function agregarUsuario(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        
        try {
            const response = await fetch("agregar_usuario.php", {
                method: "POST",
                body: formData
            });
            const resultado = await response.json();
            
            if (resultado.success) {
                alert("Usuario agregado correctamente");
                cargarUsuarios();
                form.reset();
                formAgregar.style.display = "none"; // Ocultar el formulario después de agregar
            } else {
                alert("Error al agregar usuario");
            }
        } catch (error) {
            console.error("Error al agregar usuario:", error);
        }
    }

    // Botón para mostrar/ocultar el formulario de agregar usuario
    const botonAgregar = document.createElement("button");
    botonAgregar.id = "buttonAgregar";
    botonAgregar.textContent = "Agregar Usuario";
    botonAgregar.addEventListener("click", function () {
        formAgregar.style.display = formAgregar.style.display === "none" ? "block" : "none";
    });
    document.body.appendChild(botonAgregar);

    // Agregar formulario de usuario
    
    const formAgregar = document.createElement("form");
    formAgregar.id = "formAgregar";
    formAgregar.style.display = "none";
    
    formAgregar.innerHTML = `
        <h3>Agregar Usuario</h3>
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Rol:</label>
        <select name="rol">
            <option value="admin">Admin</option>
            <option value="usuario">Usuario</option>
        </select>
        
        <label>Estado:</label>
        <select name="estado">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
        
        <button type="submit">Agregar</button>
    `;
    document.body.appendChild(formAgregar);
    formAgregar.addEventListener("submit", agregarUsuario);
    
    cargarUsuarios();
});


