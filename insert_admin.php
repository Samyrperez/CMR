<?php
include 'conexion.php';

// 3️⃣ Variables de usuario administrador
$nombre = "Admin";
$email = "samyr.perezpabon@gmail.com";
$password = "admin123";
$rol = "admin";
$estado = 1;

// 4️⃣ Encriptar la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT); // Se encripta la contraseña con password_hash()
// PASSWORD_DEFAULT: Usa el algoritmo de encriptación más reciente.

// 5️⃣ Consulta SQL con `?` como marcadores de posición
$sql = "INSERT INTO usuarios (nombre, email, password, rol, estado) VALUES (?, ?, ?, ?, ?)";

// 6️⃣ Preparar la sentencia
$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("❌ Error en la preparación de la consulta: " . $conexion->error);
}

// 7️⃣ Vincular parámetros y ejecutar la consulta
$stmt->bind_param("ssssi", $nombre, $email, $password_hash, $rol, $estado);
$stmt->execute();

echo "✅ Usuario administrador creado correctamente.";

// 8️⃣ Cerrar conexión
$stmt->close();
$conexion->close();

// ✅ Resumen
// Se conecta a la base de datos (conexion.php).

// Se definen los datos del usuario administrador.

// Se encripta la contraseña.

// Se crea una consulta SQL segura con ? para evitar inyecciones SQL.

// Se prepara la consulta con prepare().

// Se vinculan los parámetros con bind_param().

// Se ejecuta la consulta y se muestra un mensaje de éxito.

// Se cierran la consulta y la conexión.

