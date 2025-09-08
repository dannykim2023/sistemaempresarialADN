<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificado - {{ $certificado->numero_certificado }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'DejaVu Sans', 'Helvetica', sans-serif; 
            font-size: 12px;
            line-height: 1.4;
            color: #2d3748;
            margin: 0;
            padding: 0;
            background: #f8fafc;
            position: relative;
            min-height: 297mm;
        }
        
        /* Encabezado */
        .header {
            background: #1e40af;
            color: white;
            padding: 30px 40px;
            text-align: center;
            border-bottom: 5px solid #f59e0b;
        }
        
        .logo {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            padding: 15px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #3b82f6;
        }
        
        .title {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0 5px 0;
            text-transform: uppercase;
        }
        
        .subtitle {
            font-size: 16px;
            opacity: 0.9;
        }
        
        /* Contenido principal */
        .content {
            padding: 40px;
        }
        
        .certificate-border {
            border: 3px solid #3b82f6;
            border-radius: 15px;
            padding: 40px;
            background: white;
            position: relative;
        }
        
        .employee-info {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #3b82f6;
            margin: 20px 0;
        }
        
        .employee-info h3 {
            color: #1e40af;
            margin-top: 0;
            font-size: 16px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-weight: bold;
            color: #4b5563;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 13px;
            font-weight: 600;
        }
        
        .certificate-content {
            margin: 25px 0;
            line-height: 1.8;
            font-size: 13px;
            text-align: justify;
        }
        
        .signature-section {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-image {
            width: 150px;
            height: 60px;
            margin-bottom: 10px;
            border: 1px solid #e5e7eb;
            padding: 5px;
            background: white;
        }
        
        .signature-line {
            border-top: 2px solid #3b82f6;
            width: 250px;
            margin-left: auto;
            padding-top: 5px;
            font-weight: bold;
            color: #1e40af;
        }
        
        /* Footer */
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 20px;
            background: #1e293b;
            color: white;
            border-top: 3px solid #f59e0b;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .ceo-signature {
            text-align: center;
        }
        
        .ceo-name {
            font-weight: bold;
            font-size: 14px;
            color: #fbbf24;
            margin-top: 5px;
        }
        
        .ceo-title {
            font-size: 11px;
            opacity: 0.8;
        }
        
        .company-info {
            text-align: center;
        }
        
        .company-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .contact-info {
            font-size: 11px;
            opacity: 0.9;
        }
        
        .qr-code {
            text-align: center;
        }
        
        .qr-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid #f59e0b;
            border-radius: 8px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #fbbf24;
        }
        
        /* Estados */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .status-active {
            background: #10b981;
            color: white;
        }
        
        .status-vencido {
            background: #ef4444;
            color: white;
        }
        
        .status-anulado {
            background: #6b7280;
            color: white;
        }
        
        /* Marca de agua simplificada */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            font-weight: bold;
            color: rgba(59, 130, 246, 0.1);
            z-index: -1;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <div class="logo">📄</div>
        <h1 class="title">Certificado Oficial</h1>
        <p class="subtitle">N° {{ $certificado->numero_certificado }}</p>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <div class="certificate-border">
            <!-- Marca de agua -->
            <div class="watermark">CERTIFICADO</div>
            
            <!-- Información del certificado -->
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Tipo de Certificado</span>
                    <span class="info-value">{{ $certificado->tipo_certificado }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha de Emisión</span>
                    <span class="info-value">{{ $certificado->fecha_emision->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Título</span>
                    <span class="info-value">{{ $certificado->titulo }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Estado</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ strtolower($certificado->estado) }}">
                            {{ $certificado->estado }}
                        </span>
                    </span>
                </div>
                @if($certificado->fecha_vencimiento)
                <div class="info-item">
                    <span class="info-label">Fecha de Vencimiento</span>
                    <span class="info-value">{{ $certificado->fecha_vencimiento->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>

            <!-- Información del empleado -->
            <div class="employee-info">
                <h3>📋 DATOS DEL TITULAR</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nombre Completo</span>
                        <span class="info-value">{{ $certificado->employee->nombre }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">DNI</span>
                        <span class="info-value">{{ $certificado->employee->dni }}</span>
                    </div>
                    @if($certificado->employee->email)
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $certificado->employee->email }}</span>
                    </div>
                    @endif
                    @if($certificado->employee->telefono)
                    <div class="info-item">
                        <span class="info-label">Teléfono</span>
                        <span class="info-value">{{ $certificado->employee->telefono }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contenido del certificado -->
            <div class="certificate-content">
                <div style="text-align: center; margin-bottom: 15px;">
                    <strong>CONTENIDO DEL CERTIFICADO</strong>
                </div>
                {!! $certificado->contenido !!}
            </div>

            <!-- Sección de firma -->
            <div class="signature-section">
                @if($certificado->firma_digital_path)
                <img src="{{ storage_path('app/public/' . $certificado->firma_digital_path) }}" 
                     class="signature-image" 
                     alt="Firma Digital">
                @else
                <div style="height: 60px; margin-bottom: 10px;"></div>
                @endif
                
                <div class="signature-line">
                    FIRMA AUTORIZADA
                </div>
                <div style="font-size: 11px; color: #6b7280; margin-top: 5px;">
                    Fecha de expedición: {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="ceo-signature">
                <div>_________________________</div>
                <div class="ceo-name">DANIEL NÚÑEZ</div>
                <div class="ceo-title">CEO & FUNDADOR</div>
            </div>
            
            <div class="company-info">
                <div class="company-name">AGENCIA DN</div>
                <div class="contact-info">
                    📧 info@agenciadn.com | 📞 +1 (234) 567-8900
                </div>
            </div>
            
            <div class="qr-code">
                <div class="qr-placeholder">
                    QR<br>CODE
                </div>
            </div>
        </div>
    </div>
</body>
</html>