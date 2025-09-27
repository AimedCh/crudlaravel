<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra AirPods #{{ $purchase->purchase_number }}</title>
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
        
        .purchase-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .purchase-info h2 {
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
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-shipped {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .status-delivered {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-failed {
            background-color: #f5c6cb;
            color: #721c24;
        }
        
        .status-refunded {
            background-color: #e2e3e5;
            color: #383d41;
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
        
        .product-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .product-details h4 {
            margin-top: 0;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $empresa['nombre'] }}</h1>
        <p>{{ $empresa['direccion'] }}</p>
        <p>Teléfono: {{ $empresa['telefono'] }} | Email: {{ $empresa['email'] }}</p>
    </div>

    <div class="purchase-info">
        <h2>Detalles de la Compra #{{ $purchase->purchase_number }}</h2>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Cliente:</div>
                <div class="info-value">{{ $purchase->user->name ?? 'Usuario no encontrado' }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $purchase->user->email ?? 'N/A' }}</div>
            </div>
            
            @if($purchase->user && $purchase->user->phone)
            <div class="info-row">
                <div class="info-label">Teléfono:</div>
                <div class="info-value">{{ $purchase->user->phone }}</div>
            </div>
            @endif
            
            <div class="info-row">
                <div class="info-label">Fecha de Compra:</div>
                <div class="info-value">{{ $purchase->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="product-details">
        <h4>Detalles del Producto</h4>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Producto:</div>
                <div class="info-value">{{ $purchase->airpods->name ?? 'Producto no encontrado' }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Categoría:</div>
                <div class="info-value">{{ $purchase->airpods->category ?? 'N/A' }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Cantidad:</div>
                <div class="info-value">{{ $purchase->quantity }} unidad(es)</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Precio Unitario:</div>
                <div class="info-value">€{{ number_format($purchase->unit_price, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="purchase-info">
        <h2>Información de Pago y Envío</h2>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Método de Pago:</div>
                <div class="info-value">{{ ucfirst($purchase->payment_method) }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Estado del Pago:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $purchase->payment_status }}">
                        {{ ucfirst($purchase->payment_status) }}
                    </span>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Estado del Pedido:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $purchase->order_status }}">
                        {{ ucfirst($purchase->order_status) }}
                    </span>
                </div>
            </div>
            
            @if($purchase->tracking_number)
            <div class="info-row">
                <div class="info-label">Número de Seguimiento:</div>
                <div class="info-value">{{ $purchase->tracking_number }}</div>
            </div>
            @endif
            
            @if($purchase->shipped_at)
            <div class="info-row">
                <div class="info-label">Fecha de Envío:</div>
                <div class="info-value">{{ $purchase->shipped_at->format('d/m/Y H:i') }}</div>
            </div>
            @endif
            
            @if($purchase->delivered_at)
            <div class="info-row">
                <div class="info-label">Fecha de Entrega:</div>
                <div class="info-value">{{ $purchase->delivered_at->format('d/m/Y H:i') }}</div>
            </div>
            @endif
        </div>
    </div>

    @if($purchase->shipping_address || $purchase->billing_address)
    <div class="purchase-info">
        <h2>Direcciones</h2>
        
        <div class="info-grid">
            @if($purchase->shipping_address)
            <div class="info-row">
                <div class="info-label">Dirección de Envío:</div>
                <div class="info-value">{{ $purchase->shipping_address }}</div>
            </div>
            @endif
            
            @if($purchase->billing_address)
            <div class="info-row">
                <div class="info-label">Dirección de Facturación:</div>
                <div class="info-value">{{ $purchase->billing_address }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="total-box">
        <h3>Total de la Compra</h3>
        <div class="total-amount">€{{ number_format($purchase->total_amount, 2) }}</div>
    </div>

    @if($purchase->notes)
    <div class="purchase-info">
        <h2>Notas</h2>
        <p>{{ $purchase->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Documento generado el {{ $fecha_generacion }}</p>
        <p>Este documento es una confirmación de compra. Para cualquier consulta, contacte con nosotros.</p>
    </div>
</body>
</html>


