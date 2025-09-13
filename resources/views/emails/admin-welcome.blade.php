<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido Administrador</title>
</head>
<body>
    <h2>Bienvenido al sistema</h2>
    <p>Hola, se te ha creado una cuenta de administrador.</p>
    <p><strong>Usuario:</strong> {{ $email }}</p>
    <p><strong>Contraseña:</strong> {{ $password }}</p>
    <p>Puedes acceder aquí: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
    <br>
    <p>Por seguridad, cambia tu contraseña después de iniciar sesión.</p>
</body>
</html>
