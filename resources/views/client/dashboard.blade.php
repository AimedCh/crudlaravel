@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-primary">
                    <i class="fas fa-user me-2"></i>
                    Panel del Cliente
                </h1>
                <div class="text-muted">
                    <i class="fas fa-calendar me-2"></i>
                    {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Estadísticas del Cliente -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_ordenes'] ?? 0 }}</h4>
                            <p class="card-text">Órdenes Totales</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['ordenes_pendientes'] ?? 0 }}</h4>
                            <p class="card-text">Órdenes Pendientes</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['ordenes_completadas'] ?? 0 }}</h4>
                            <p class="card-text">Órdenes Completadas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">${{ number_format($stats['total_gastado'] ?? 0, 2) }}</h4>
                            <p class="card-text">Total Gastado</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Acciones Rápidas -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('airpods.shop') }}" class="btn btn-primary">
                            <i class="fas fa-headphones me-2"></i>
                            Comprar AirPods
                        </a>
                        <a href="{{ route('client.ordenes.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>
                            Ver Mis Órdenes
                        </a>
                        <a href="{{ route('contacto.public') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-envelope me-2"></i>
                            Contactar Soporte
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Mi Información
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Nombre:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Teléfono:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->phone ?? 'No especificado' }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Estado:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-success">Activo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Órdenes Recientes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>
                        Órdenes Recientes
                    </h5>
                    <a href="{{ route('client.ordenes.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($ordenes_recientes) && $ordenes_recientes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Producto</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ordenes_recientes as $orden)
                                        <tr>
                                            <td>{{ $orden->order_number }}</td>
                                            <td>{{ $orden->airpods->name ?? 'N/A' }}</td>
                                            <td>${{ number_format($orden->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $orden->status === 'completed' ? 'success' : ($orden->status === 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($orden->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $orden->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('client.ordenes.show', $orden) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes órdenes aún</h5>
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