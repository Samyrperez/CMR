<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $estado = $_POST['estado'] ?? '';

    if ($nombre && $email && $rol !== '' && $estado !== '') {
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, rol, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $email, $rol, $estado);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => "Faltan datos"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}

$conexion->close();
?>
