<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo empleado registrado</title>
</head>
<body>
    <h2>Se ha registrado un nuevo empleado</h2>
    <p><strong>Nombre:</strong> {{ $empleado->nombre }}</p>
    <p><strong>DNI:</strong> {{ $empleado->dni }}</p>
    <p><strong>Email:</strong> {{ $empleado->email }}</p>
    <p><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
</body>
</html>
