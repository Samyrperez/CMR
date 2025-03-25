<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crm_db";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}






