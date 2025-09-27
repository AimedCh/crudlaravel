@extends('layouts.app')

@section('content')
<div class="container">
    <div class="unified-card">
        <div class="unified-header">
            <i class="fas fa-shopping-cart"></i> Gestión de Compras AirPods
            <div style="float: right;">
                <a href="{{ route('admin.airpods-purchases.create') }}" class="unified-btn unified-btn-success">
                    <i class="fas fa-plus"></i> Nueva Compra
                </a>
                <span class="unified-badge unified-badge-info" style="margin-left: 10px;">
                    {{ $purchases->total() }} compras
                </span>
            </div>
        </div>

        <div class="unified-body">
            @if(session('success'))
                <div class="unified-alert unified-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($purchases->count() > 0)
                <table class="unified-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Número de Compra</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Estado Pago</th>
                            <th>Estado Pedido</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                                <tbody>
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->id }}</td>
                                            <td>
                                                <strong class="text-primary">{{ $purchase->purchase_number }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $purchase->user->name ?? 'Usuario no encontrado' }}</strong><br>
                                                    <small class="text-muted">{{ $purchase->user->email ?? 'N/A' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $purchase->airpods->name ?? 'Producto no encontrado' }}</strong><br>
                                                    <small class="text-muted">{{ $purchase->airpods->category ?? 'N/A' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="unified-badge unified-badge-info">{{ $purchase->quantity }}</span>
                                            </td>
                                            <td>
                                                <strong style="color: var(--success-color);">€{{ number_format($purchase->total_amount, 2) }}</strong>
                                            </td>
                                            <td>
                                                @switch($purchase->payment_status)
                                                    @case('completed')
                                                        <span class="unified-badge unified-badge-success">Completado</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="unified-badge unified-badge-warning">Pendiente</span>
                                                        @break
                                                    @case('failed')
                                                        <span class="unified-badge unified-badge-danger">Fallido</span>
                                                        @break
                                                    @case('refunded')
                                                        <span class="unified-badge" style="background: #6c757d; color: white;">Reembolsado</span>
                                                        @break
                                                    @default
                                                        <span class="unified-badge" style="background: #e9ecef; color: #495057;">{{ ucfirst($purchase->payment_status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($purchase->order_status)
                                                    @case('pending')
                                                        <span class="unified-badge unified-badge-warning">Pendiente</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="unified-badge unified-badge-info">Procesando</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="unified-badge unified-badge-primary">Enviado</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="unified-badge unified-badge-success">Entregado</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="unified-badge unified-badge-danger">Cancelado</span>
                                                        @break
                                                    @default
                                                        <span class="unified-badge" style="background: #e9ecef; color: #495057;">{{ ucfirst($purchase->order_status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                                    <button type="button" class="unified-btn unified-btn-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#purchaseModal{{ $purchase->id }}"
                                                            title="Ver detalles">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </button>
                                                    <a href="{{ route('admin.airpods-purchases.edit', $purchase) }}" 
                                                       class="unified-btn unified-btn-success" title="Editar compra">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <form action="{{ route('admin.airpods-purchases.destroy', $purchase) }}" 
                                                          method="POST" 
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta compra?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="unified-btn unified-btn-danger" title="Eliminar compra">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.airpods-purchases.pdf', $purchase) }}" 
                                                       class="unified-btn unified-btn-warning" target="_blank" title="Generar PDF">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal para ver detalles de la compra -->
                                        <div class="modal fade" id="purchaseModal{{ $purchase->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detalles de la Compra #{{ $purchase->purchase_number }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Información del Cliente</h6>
                                                                <p><strong>Nombre:</strong> {{ $purchase->user->name ?? 'Usuario no encontrado' }}</p>
                                                                <p><strong>Email:</strong> {{ $purchase->user->email ?? 'N/A' }}</p>
                                                                @if($purchase->user && $purchase->user->phone)
                                                                    <p><strong>Teléfono:</strong> {{ $purchase->user->phone }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Detalles del Producto</h6>
                                                                <p><strong>Producto:</strong> {{ $purchase->airpods->name ?? 'Producto no encontrado' }}</p>
                                                                <p><strong>Categoría:</strong> {{ $purchase->airpods->category ?? 'N/A' }}</p>
                                                                <p><strong>Cantidad:</strong> {{ $purchase->quantity }}</p>
                                                                <p><strong>Precio unitario:</strong> €{{ number_format($purchase->unit_price, 2) }}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Información de Pago</h6>
                                                                <p><strong>Método de pago:</strong> {{ ucfirst($purchase->payment_method) }}</p>
                                                                <p><strong>Estado del pago:</strong> 
                                                                    <span class="badge bg-{{ $purchase->payment_status === 'completed' ? 'success' : ($purchase->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($purchase->payment_status) }}
                                                                    </span>
                                                                </p>
                                                                <p><strong>Total:</strong> <span class="text-success fw-bold">€{{ number_format($purchase->total_amount, 2) }}</span></p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Estado del Pedido</h6>
                                                                <p><strong>Estado:</strong> 
                                                                    <span class="badge bg-{{ $purchase->order_status === 'delivered' ? 'success' : ($purchase->order_status === 'shipped' ? 'primary' : ($purchase->order_status === 'processing' ? 'info' : 'warning')) }}">
                                                                        {{ ucfirst($purchase->order_status) }}
                                                                    </span>
                                                                </p>
                                                                @if($purchase->tracking_number)
                                                                    <p><strong>Número de seguimiento:</strong> {{ $purchase->tracking_number }}</p>
                                                                @endif
                                                                @if($purchase->shipped_at)
                                                                    <p><strong>Enviado el:</strong> {{ $purchase->shipped_at->format('d/m/Y H:i') }}</p>
                                                                @endif
                                                                @if($purchase->delivered_at)
                                                                    <p><strong>Entregado el:</strong> {{ $purchase->delivered_at->format('d/m/Y H:i') }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if($purchase->shipping_address || $purchase->billing_address)
                                                            <hr>
                                                            <div class="row">
                                                                @if($purchase->shipping_address)
                                                                    <div class="col-md-6">
                                                                        <h6>Dirección de Envío</h6>
                                                                        <p>{{ $purchase->shipping_address }}</p>
                                                                    </div>
                                                                @endif
                                                                @if($purchase->billing_address)
                                                                    <div class="col-md-6">
                                                                        <h6>Dirección de Facturación</h6>
                                                                        <p>{{ $purchase->billing_address }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if($purchase->notes)
                                                            <hr>
                                                            <div>
                                                                <h6>Notas</h6>
                                                                <p>{{ $purchase->notes }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <a href="{{ route('admin.airpods-purchases.edit', $purchase) }}" class="btn btn-primary">Editar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            {{ $purchases->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay compras de AirPods registradas</h5>
                            <p class="text-muted">Las compras realizadas desde el frontend aparecerán aquí.</p>
                            <a href="{{ route('admin.airpods-purchases.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Crear Primera Compra
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


