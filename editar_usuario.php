<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID de usuario no proporcionado"]);
    exit;
}

$id = intval($_GET['id']);

// Verificar que la conexión está definida
if (!$conexion) {
    echo json_encode(["error" => "Error en la conexión a la base de datos"]);
    exit;
}

$query = $conexion->prepare("SELECT id, nombre, email, rol, estado FROM usuarios WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$usuario = $result->fetch_assoc();

if ($usuario) {
    echo json_encode($usuario);
} else {
    echo json_encode(["error" => "Usuario no encontrado"]);
}

// Cerrar la conexión correctamente
$query->close();
$conexion->close();
?>
