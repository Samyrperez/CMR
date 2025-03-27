<?php
include 'conexion.php';

$sql = "SELECT id, nombre, email, rol, estado FROM usuarios";
$result = $conexion->query($sql);

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);

$conexion->close();
?>
