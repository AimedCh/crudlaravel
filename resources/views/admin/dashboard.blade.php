@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Panel de Administración
                </h1>
                <div>
                    <span class="badge bg-success">
                        <i class="fas fa-user-shield me-1"></i>
                        Administrador: {{ Auth::guard('admin')->user()?->name ?? 'Administrador' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <!-- Clientes eliminado -->
        </div>

        <!-- Órdenes Pendientes eliminado -->

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Mensajes Nuevos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['mensajes_nuevos'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Reservas Pendientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['reservas_pendientes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>
                        Accesos Rápidos
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Botón Gestionar Órdenes eliminado -->
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.mensajes') }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-envelope me-2"></i>
                                Ver Mensajes
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.reservas') }}" class="btn btn-outline-success btn-block">
                                <i class="fas fa-calendar-check me-2"></i>
                                Gestionar Reservas
                            </a>
                        </div>
                        <!-- Botón Ver Clientes eliminado -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="row">
        <!-- Órdenes Recientes eliminado -->

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mensajes Recientes</h6>
                </div>
                <div class="card-body">
                    @if($mensajes_recientes->count() > 0)
                        @foreach($mensajes_recientes as $mensaje)
                            <div class="d-flex align-items-center mb-3">
                                <div class="mr-3">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $mensaje->created_at->format('d/m/Y H:i') }}</div>
                                    <div class="font-weight-bold">{{ $mensaje->nombre }}</div>
                                    <div class="text-gray-800">{{ Str::limit($mensaje->asunto, 50) }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No hay mensajes nuevos</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
