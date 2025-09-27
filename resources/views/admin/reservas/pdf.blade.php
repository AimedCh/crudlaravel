<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva #{{ $reserva->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .reserva-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .reserva-info h2 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 18px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 8px 15px 8px 0;
            width: 30%;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            padding: 8px 0;
            width: 70%;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-confirmado {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-en_uso {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-devuelto {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .status-cancelado {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .total-box {
            background-color: #e8f5e8;
            border: 2px solid #28a745;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin: 20px 0;
        }
        
        .total-box h3 {
            margin: 0 0 10px 0;
            color: #155724;
            font-size: 16px;
        }
        
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $empresa['nombre'] }}</h1>
        <p>{{ $empresa['direccion'] }}</p>
        <p>Teléfono: {{ $empresa['telefono'] }} | Email: {{ $empresa['email'] }}</p>
    </div>

    <div class="reserva-info">
        <h2>Detalles de la Reserva #{{ $reserva->id }}</h2>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Cliente:</div>
                <div class="info-value">{{ $reserva->nombre_cliente }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $reserva->email_cliente }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Teléfono:</div>
                <div class="info-value">{{ $reserva->telefono_cliente }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Número de Huéspedes:</div>
                <div class="info-value">{{ $reserva->numero_huespedes }} persona(s)</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Tipo de Equipo:</div>
                <div class="info-value">{{ $reserva->tipo_equipo }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Descripción:</div>
                <div class="info-value">{{ $reserva->descripcion_equipo }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Fecha de Entrada:</div>
                <div class="info-value">{{ $reserva->fecha_entrada->format('d/m/Y') }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Fecha de Salida:</div>
                <div class="info-value">{{ $reserva->fecha_salida->format('d/m/Y') }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Duración:</div>
                <div class="info-value">{{ $reserva->fecha_entrada->diffInDays($reserva->fecha_salida) + 1 }} día(s)</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Precio por Día:</div>
                <div class="info-value">€{{ number_format($reserva->precio_dia, 2) }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $reserva->estado }}">
                        {{ ucfirst($reserva->estado) }}
                    </span>
                </div>
            </div>
            
            @if($reserva->notas)
            <div class="info-row">
                <div class="info-label">Notas:</div>
                <div class="info-value">{{ $reserva->notas }}</div>
            </div>
            @endif
            
            <div class="info-row">
                <div class="info-label">Fecha de Reserva:</div>
                <div class="info-value">{{ $reserva->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="total-box">
        <h3>Total de la Reserva</h3>
        <div class="total-amount">€{{ number_format($reserva->total, 2) }}</div>
    </div>

    <div class="footer">
        <p>Documento generado el {{ $fecha_generacion }}</p>
        <p>Este documento es una confirmación de reserva. Para cualquier consulta, contacte con nosotros.</p>
    </div>
</body>
</html>
