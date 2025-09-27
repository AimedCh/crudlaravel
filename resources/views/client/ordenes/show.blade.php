@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-primary">
                    <i class="fas fa-receipt me-2"></i>
                    Detalle de Orden #{{ $orden->order_number }}
                </h1>
                <a href="{{ route('client.ordenes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver a Mis Órdenes
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información de la Orden -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información de la Orden</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Detalles del Producto</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-3">
                                @if($orden->airpods && $orden->airpods->images && count($orden->airpods->images) > 0)
                                    <img src="{{ $orden->airpods->images[0] }}" 
                                         alt="{{ $orden->airpods->name }}" 
                                         class="img-thumbnail me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-headphones fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $orden->airpods->name ?? 'Producto no disponible' }}</h6>
                                    <small class="text-muted">{{ $orden->airpods->category ?? '' }}</small>
                                </div>
                            </div>
                            
                            @if($orden->airpods && $orden->airpods->description)
                                <p class="text-muted">{{ $orden->airpods->description }}</p>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="text-primary">Información de Compra</h6>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Cantidad:</strong></div>
                                <div class="col-6">{{ $orden->quantity ?? 1 }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Precio Unitario:</strong></div>
                                <div class="col-6">${{ number_format($orden->airpods->price ?? 0, 2) }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Subtotal:</strong></div>
                                <div class="col-6">${{ number_format(($orden->airpods->price ?? 0) * ($orden->quantity ?? 1), 2) }}</div>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Total:</strong></div>
                                <div class="col-6"><h5 class="text-primary mb-0">${{ number_format($orden->total_amount, 2) }}</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado y Acciones -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Estado de la Orden</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <span class="badge bg-{{ $orden->status === 'completed' ? 'success' : ($orden->status === 'pending' ? 'warning' : ($orden->status === 'cancelled' ? 'danger' : 'info')) }} fs-6">
                                {{ ucfirst($orden->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="badge bg-{{ $orden->payment_status === 'paid' ? 'success' : ($orden->payment_status === 'pending' ? 'warning' : 'danger') }} fs-6">
                                Pago: {{ ucfirst($orden->payment_status) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-primary">Información de Fechas</h6>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Fecha de Orden:</strong></div>
                        <div class="col-6">{{ $orden->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    @if($orden->updated_at != $orden->created_at)
                        <div class="row mb-2">
                            <div class="col-6"><strong>Última Actualización:</strong></div>
                            <div class="col-6">{{ $orden->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    @endif

                    <hr>

                    <h6 class="text-primary">Acciones</h6>
                    <div class="d-grid gap-2">
                        @if($orden->status === 'completed')
                            <a href="{{ route('client.orden.factura', $orden) }}" class="btn btn-success">
                                <i class="fas fa-download me-2"></i>
                                Descargar Factura
                            </a>
                        @endif
                        
                        @if($orden->status === 'pending')
                            <button class="btn btn-warning" disabled>
                                <i class="fas fa-clock me-2"></i>
                                Procesando...
                            </button>
                        @endif
                        
                        <a href="{{ route('airpods.shop') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Comprar Más
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Características del Producto -->
    @if($orden->airpods && $orden->airpods->features && count($orden->airpods->features) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Características del Producto</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($orden->airpods->features as $feature)
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ $feature }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

