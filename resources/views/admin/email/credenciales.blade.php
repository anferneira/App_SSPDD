<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Acceso</title>
</head>
<body>
    <strong>Hola, {{ $nombre }}</strong>
    <p>Estas son tus credenciales de acceso al aplicativo SSPDD 
        Sistema de Seguimiento al Plan de Desarrollo Departamental de Boyacá 
        2024 - 2027:</p>
    <ul>
        <li><strong>Usuario:</strong> {{ $email }}</li>
        <li><strong>Contraseña:</strong> {{ $password }}</li>
    </ul>
    <p>Por favor, inicia sesión y cambia tu contraseña lo antes posible por razones de seguridad.</p>
    <p>Gracias,</p>
    <p>El equipo de soporte, {{ config('app.name') }}</p>
</body>
</html>
