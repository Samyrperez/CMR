<?php 
// Validación en el Servidor
















/*Explicación del Código

Inicio de Sesión: session_start(); permite usar sesiones en PHP.

Conexión a la Base de Datos: Se incluye connectDB.php para conectarse.

Sanitización de Entrada: filter_var() limpia el email para evitar inyecciones.

Consulta con prepare(): Evita SQL Injection al buscar el usuario.

Verificación de Contraseña: password_verify() compara la contraseña ingresada con la almacenada.

Inicio de Sesión: Si la autenticación es correcta, se guardan los datos del usuario en $_SESSION.

Respuesta en JSON: Se envía una respuesta al frontend indicando éxito o error.

*/