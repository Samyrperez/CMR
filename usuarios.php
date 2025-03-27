<?php
include 'conexion.php';

// Consulta para obtener todos los usuarios
$sql = "SELECT id, nombre, email, rol, estado FROM usuarios";
$result = $conexion->query($sql);

$usuarios = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

echo json_encode($usuarios);

$conexion->close();
?>
