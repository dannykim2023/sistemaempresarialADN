<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
</head>
<body>
    <p>Hola {{ $certificado->employee->nombre ?? 'Empleado' }},</p>
    <p>Se ha generado tu certificado de tipo <strong>{{ $certificado->tipo_certificado }}</strong>.</p>
    <p>Lo encontrarás adjunto en este correo.</p>
    <p>Saludos,<br>Equipo de RRHH</p>
</body>
</html>
