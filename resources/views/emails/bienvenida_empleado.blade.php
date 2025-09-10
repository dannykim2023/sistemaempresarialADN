<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
</head>
<body>
    <h2>¡Hola {{ $empleado->nombre }}!</h2>
    <p>Bienvenido a nuestra empresa. Estamos muy contentos de contar contigo en el equipo 🚀.</p>
    <p>Tu correo de contacto es: <strong>{{ $empleado->email }}</strong></p>
    <p>Si tienes alguna duda, no dudes en comunicarte con RRHH.</p>
    <p>Saludos,<br>Equipo de RRHH</p>
</body>
</html>
