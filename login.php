<?php
header("Content-Type: application/json"); // 🔹 Esto soluciona errores de JSON
// Asegura que la respuesta del servidor sea interpretada como JSON por el navegador
session_start(); // Inicia o reanuda una sesión para poder almacenar datos del usuario
include 'conexion.php';

// 🔹 Verificación del método HTTP
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
    exit;
}

// 🔹 Obtener desde $_POST y limpiar datos
$email = trim($_POST["email"]); // trim() elimina espacios en blanco al inicio y al final.
$password = trim($_POST["password"]);

// 🔹 Validación de campos vacíos
if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
    exit;
}

// Verificar si el usuario existe
$sql = "SELECT id, nombre, email, password, rol, estado FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql); //  vincula $email a la consulta como tipo string (s).
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();


// 🔹 Verifica si el usuario existe
if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // 🔹 Verifica si la cuenta está activa
    if ($usuario["estado"] == 0) {
        echo json_encode(["success" => false, "message" => "Tu cuenta está inactiva."]);
        exit;
    }

    // 🔹 Verificación de contraseña
    if (password_verify($password, $usuario["password"])) { // password_verify() compara la contraseña ingresada con la almacenada en la base de datos (que está encriptada con password_hash()).
        // 🔹 Almacenar datos en sesión
        $_SESSION["usuario_id"] = $usuario["id"]; 
        $_SESSION["usuario_nombre"] = $usuario["nombre"];
        $_SESSION["usuario_rol"] = $usuario["rol"];
        // Guarda en $_SESSION el id, nombre y rol del usuario para usarlos en otras páginas.

        // 🔹 Redirigir según el rol
        $redirect = ($usuario["rol"] == "admin") ? "admin_dashboard.php" : "dashboard.php"; // Si el usuario es admin, se redirige a admin_dashboard.php,  Si no, se redirige a dashboard.php.
        echo json_encode(["success" => true, "redirect" => $redirect]);
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "El usuario no existe."]);
}

$stmt->close();
$conexion->close();




// ✅ Resumen
// Valida que la solicitud sea POST.

// Obtiene y verifica los datos ingresados (email y password).

// Consulta la base de datos para verificar si el usuario existe.

// Si el usuario existe y la cuenta está activa, verifica la contraseña.

// Si la contraseña es correcta, inicia sesión y redirige al usuario.

// Si hay errores, responde con mensajes en JSON.

// Cierra la conexión con la base de datos.



