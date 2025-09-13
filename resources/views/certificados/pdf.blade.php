<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado - {{ $certificado->numero_certificado }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.3cm;
        }

        body {
            font-family: "Times New Roman", serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .certificado {
            text-align: center;
            padding:0px;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .encabezado img {
            width: 200px;
            height: auto;
        }

        .titulo {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .subtitulo {
            font-size: 18px;
            font-style: italic;
            margin-bottom: 30px;
        }

        .contenido {
            font-size: 16px;
            text-align: justify;
            line-height: 1.8;
            margin: 0 auto 30px auto;
        }

        .nombre {
            display: block;
            font-size: 20px;
            font-weight: bold;
            color: #0030ff;
            margin: 15px 0;
            text-align: center;
        }

        .firma {
            margin-top: 60px;
            text-align: center;
        }

        .firma img {
            width: 180px;
            height: auto;
            margin-bottom: 10px;
        }

        .linea-firma {
            width: 250px;
            border-top: 1px solid #000;
            margin: 0 auto 5px auto;
        }

        .cargo {
            font-size: 14px;
            color: #333;
        }

        .fecha {
            margin-top: 40px;
            font-size: 14px;
            text-align: center;
        }

        .footer {
            margin-top: 60px;
            font-size: 12px;
            color: #555;
            text-align: center;
            line-height: 1.6;
        }

        .footer strong {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="certificado">
        <!-- Encabezado -->
        <div class="encabezado">
            <img src="{{ public_path('logo/logo vertical agencia dn.png') }}" alt="Logo Institución">
            <div style="flex:1; text-align:center;">
                <p><em>AGENCIA DN-SOFTWARE & MARKETING S.A.C.S<br>RUC:20614216493</em></p>
            </div>
        </div>

        <!-- Título -->
        <div class="titulo">Certificado</div>
        <div class="subtitulo">Practicas Pre profesionales</div>

        <!-- Contenido -->
        <div class="contenido">
            Por medio del presente, se certifica que {{ $certificado->employee->nombre }}
            identificado con DNI <strong>{{ $certificado->employee->dni }}</strong>,
            ha realizado satisfactoriamente sus prácticas pre profesionales en nuestra empresa AGENCIA DN-SOFTWARE & MARKETING S.A.C.S 
            <strong>{{ $certificado->titulo }}</strong>, 
            en el departamento de <strong>{{ $certificado->employee->area?? 'Área Asignada' }} con el puesto de {{ $certificado->employee->puesto ?? 'Puesto' }}</strong>, 
            durante el periodo comprendido entre 
            <strong>{{ $certificado->employee->fecha_inicio}}</strong> y 
            <strong>{{ $certificado->employee->fecha_fin }}</strong>.  
            <br><br> {{ $certificado->contenido }}
          
        </div>

        <!-- Firma -->
        <div class="firma">
            <img src="{{ public_path('firma/firmadaniel.jpg') }}" alt="Firma Daniel">
            <div class="linea-firma"></div>
            <div class="cargo">DANIEL LORENZO S.0<br>GERENTE GENERAL & CEO FUNDADOR</div>
        </div>

        <!-- Fecha -->
        <div class="fecha">
            Emitido en Lima Perú, el {{ $certificado->fecha_emision }}.
        </div>

        <!-- Footer -->
                Verifica la valides de este certificado en <strong>www.agenciadn.com</strong> <br>
                ID de Certificado: <strong>{{ $certificado->id}}</strong>
            </p>
        </div>
    </div>
</body>
</html>
