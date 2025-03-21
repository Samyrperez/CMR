<?php

function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "crm_db";

    $conexion = new mysqli($servername, $username, $password, $dbname);

    if ($conexion->connect_error) {
        die ("Error en la conexión: " . $connect->error);
    }

    return $conexion;
}
// Probar la conexión
$conexion = connectDB();

if ($conexion) {
    echo "Conexión Exitosa";
}