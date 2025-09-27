@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-primary">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Mis Órdenes
                </h1>
                <a href="{{ route('airpods.shop') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Nueva Compra
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historial de Órdenes</h6>
                </div>
                <div class="card-body">
                    @if($ordenes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Número de Orden</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Pago</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ordenes as $orden)
                                        <tr>
                                            <td>
                                                <strong>{{ $orden->order_number }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $orden->airpods->name ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">{{ $orden->airpods->category ?? '' }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $orden->quantity ?? 1 }}</td>
                                            <td>
                                                <strong>${{ number_format($orden->total_amount, 2) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $orden->status === 'completed' ? 'success' : ($orden->status === 'pending' ? 'warning' : ($orden->status === 'cancelled' ? 'danger' : 'info')) }}">
                                                    {{ ucfirst($orden->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $orden->payment_status === 'paid' ? 'success' : ($orden->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($orden->payment_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $orden->created_at->format('d/m/Y') }}<br>
                                                    <small class="text-muted">{{ $orden->created_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('client.ordenes.show', $orden) }}" 
                                                       class="btn btn-sm btn-outline-info" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($orden->status === 'completed')
                                                        <a href="{{ route('client.orden.factura', $orden) }}" 
                                                           class="btn btn-sm btn-outline-success" title="Descargar factura">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes órdenes registradas</h5>
                            <p class="text-muted">¡Comienza comprando tus AirPods favoritos!</p>
                            <a href="{{ route('airpods.shop') }}" class="btn btn-primary">
                                <i class="fas fa-headphones me-2"></i>
                                Ir a la Tienda
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

