<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form id="loginForm">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Ingresar</button>
    </form>
    
    <p id="mensaje"></p>

    <script src="js/login.js"></script>
</body>
</html>
