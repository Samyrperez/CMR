<?php
include "conexion.php"; // Asegúrate de incluir la conexión

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $rol = $_POST["rol"];
    $estado = $_POST["estado"];

    if (!$conexion) {
        echo json_encode(["success" => false, "error" => "Error de conexión"]);
        exit;
    }

    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ?, estado = ? WHERE id = ?");
    $stmt->bind_param("sssii", $nombre, $email, $rol, $estado, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
}
?>
