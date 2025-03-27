<?php
include 'conexion.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el usuario"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID no proporcionado"]);
}

$conexion->close();
?>
