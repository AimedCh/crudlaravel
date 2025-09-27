<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $factura->numero }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-info, .client-info {
            width: 45%;
        }
        .invoice-info h3, .client-info h3 {
            background-color: #007bff;
            color: white;
            padding: 10px;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        .invoice-info p, .client-info p {
            margin: 5px 0;
            font-size: 12px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .totals {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .total-row.final {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #007bff;
            border-bottom: 2px solid #007bff;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURA</h1>
        <h2>{{ $factura->numero }}</h2>
    </div>

    <div class="company-info">
        <h3>Empresa</h3>
        <p><strong>TechStore</strong></p>
        <p>Dirección: Calle Principal 123</p>
        <p>Ciudad: Madrid, España</p>
        <p>Teléfono: +34 123 456 789</p>
        <p>Email: info@techstore.com</p>
    </div>

    <div class="invoice-details">
        <div class="invoice-info">
            <h3>Datos de la Factura</h3>
            <p><strong>Número:</strong> {{ $factura->numero }}</p>
            <p><strong>Fecha:</strong> {{ $factura->fecha->format('d/m/Y') }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($factura->estado ?? 'Pendiente') }}</p>
            <p><strong>Generado:</strong> {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
        </div>

        <div class="client-info">
            <h3>Datos del Cliente</h3>
            @if($factura->cliente)
                <p><strong>Nombre:</strong> {{ $factura->cliente->name ?? 'Cliente no encontrado' }}</p>
                <p><strong>Email:</strong> {{ $factura->cliente->email }}</p>
                @if($factura->cliente->phone)
                    <p><strong>Teléfono:</strong> {{ $factura->cliente->phone }}</p>
                @endif
            @else
                <p>Cliente no disponible</p>
            @endif
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Base Imponible</th>
                <th>IVA</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Servicios prestados</td>
                <td>{{ number_format($factura->base, 2) }} €</td>
                <td>{{ number_format($factura->importeiva, 2) }} €</td>
                <td>{{ number_format($factura->importe, 2) }} €</td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span>Base Imponible:</span>
            <span>{{ number_format($factura->base, 2) }} €</span>
        </div>
        <div class="total-row">
            <span>IVA (21%):</span>
            <span>{{ number_format($factura->importeiva, 2) }} €</span>
        </div>
        <div class="total-row final">
            <span>TOTAL:</span>
            <span>{{ number_format($factura->importe, 2) }} €</span>
        </div>
    </div>

    <div class="clear"></div>

    @if($factura->notas)
        <div style="margin-top: 30px;">
            <h3>Notas:</h3>
            <p>{{ $factura->notas }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Esta factura ha sido generada electrónicamente el {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
        <p>TechStore - Todos los derechos reservados</p>
    </div>
</body>
</html>
