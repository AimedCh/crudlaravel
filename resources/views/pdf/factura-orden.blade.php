<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Orden #{{ $orden->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 18px;
            color: #666;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details, .client-details {
            width: 48%;
        }
        .invoice-details h3, .client-details h3 {
            color: #007bff;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #007bff;
        }
        .table .text-right {
            text-align: right;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-row {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pendiente { background-color: #fff3cd; color: #856404; }
        .status-procesando { background-color: #d1ecf1; color: #0c5460; }
        .status-completado { background-color: #d4edda; color: #155724; }
        .status-cancelado { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">TechStore - AirPods</div>
        <div class="invoice-title">Factura de Compra</div>
    </div>

    <div class="invoice-info">
        <div class="invoice-details">
            <h3>Detalles de la Factura</h3>
            <p><strong>Número de Orden:</strong> #{{ $orden->id }}</p>
            <p><strong>Fecha de Orden:</strong> {{ $orden->fecha_orden->format('d/m/Y H:i') }}</p>
            <p><strong>Fecha de Factura:</strong> {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
            <p><strong>Estado:</strong> 
                <span class="status-badge status-{{ $orden->estado }}">{{ ucfirst($orden->estado) }}</span>
            </p>
            <p><strong>Método de Pago:</strong> {{ ucfirst($orden->metodo_pago) }}</p>
        </div>

        <div class="client-details">
            <h3>Datos del Cliente</h3>
            <p><strong>Nombre:</strong> {{ $orden->user->name ?? 'Usuario no encontrado' }}</p>
            <p><strong>Email:</strong> {{ $orden->user->email ?? 'N/A' }}</p>
            @if($orden->user && $orden->user->phone)
                <p><strong>Teléfono:</strong> {{ $orden->user->phone }}</p>
            @endif
            <p><strong>Cliente ID:</strong> #{{ $orden->user->id ?? 'N/A' }}</p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Descripción</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Precio Unitario</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $orden->detalles_producto['nombre'] ?? 'AirPods' }}</strong>
                    <br>
                    <small>Categoría: {{ $orden->detalles_producto['categoria'] ?? 'N/A' }}</small>
                </td>
                <td>{{ $orden->detalles_producto['descripcion'] ?? 'Producto AirPods' }}</td>
                <td class="text-right">{{ $orden->cantidad }}</td>
                <td class="text-right">${{ number_format($orden->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($orden->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <table style="width: 300px; margin-left: auto;">
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td class="text-right">${{ number_format($orden->total, 2) }}</td>
            </tr>
            <tr>
                <td><strong>IVA (0%):</strong></td>
                <td class="text-right">$0.00</td>
            </tr>
            <tr class="total-row">
                <td><strong>TOTAL:</strong></td>
                <td class="text-right">${{ number_format($orden->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p><strong>¡Gracias por tu compra!</strong></p>
        <p>Esta factura fue generada automáticamente el {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
        <p>Para cualquier consulta, contacta con nuestro servicio al cliente.</p>
        <p>TechStore - Especialistas en tecnología Apple</p>
    </div>
</body>
</html>
