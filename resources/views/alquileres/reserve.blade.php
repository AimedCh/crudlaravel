@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-calendar-plus me-2"></i>Reservar Equipo de Alquiler</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('alquileres.reserve.public') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre_cliente" class="form-label">Nombre Completo *</label>
                                    <input type="text" class="form-control @error('nombre_cliente') is-invalid @enderror" 
                                           id="nombre_cliente" name="nombre_cliente" value="{{ old('nombre_cliente') }}" required>
                                    @error('nombre_cliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email_cliente" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email_cliente') is-invalid @enderror" 
                                           id="email_cliente" name="email_cliente" value="{{ old('email_cliente') }}" required>
                                    @error('email_cliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono_cliente" class="form-label">Teléfono *</label>
                                    <input type="tel" class="form-control @error('telefono_cliente') is-invalid @enderror" 
                                           id="telefono_cliente" name="telefono_cliente" value="{{ old('telefono_cliente') }}" required>
                                    @error('telefono_cliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_equipo" class="form-label">Tipo de Equipo *</label>
                                    <select class="form-select @error('tipo_equipo') is-invalid @enderror" 
                                            id="tipo_equipo" name="tipo_equipo" required>
                                        <option value="">Seleccionar tipo de equipo...</option>
                                        <option value="AirPods Pro" {{ old('tipo_equipo') == 'AirPods Pro' ? 'selected' : '' }}>AirPods Pro</option>
                                        <option value="AirPods (3ra Gen)" {{ old('tipo_equipo') == 'AirPods (3ra Gen)' ? 'selected' : '' }}>AirPods (3ra Gen)</option>
                                        <option value="AirPods Max" {{ old('tipo_equipo') == 'AirPods Max' ? 'selected' : '' }}>AirPods Max</option>
                                        <option value="Equipo de Audio" {{ old('tipo_equipo') == 'Equipo de Audio' ? 'selected' : '' }}>Equipo de Audio</option>
                                        <option value="Equipo de Video" {{ old('tipo_equipo') == 'Equipo de Video' ? 'selected' : '' }}>Equipo de Video</option>
                                        <option value="Otro" {{ old('tipo_equipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('tipo_equipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_equipo" class="form-label">Descripción del Equipo *</label>
                            <textarea class="form-control @error('descripcion_equipo') is-invalid @enderror" 
                                      id="descripcion_equipo" name="descripcion_equipo" rows="3" required>{{ old('descripcion_equipo') }}</textarea>
                            @error('descripcion_equipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                                    <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                           id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_fin" class="form-label">Fecha de Fin *</label>
                                    <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" 
                                           id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                                    @error('fecha_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="precio_dia" class="form-label">Precio por Día (€) *</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('precio_dia') is-invalid @enderror" 
                                       id="precio_dia" name="precio_dia" value="{{ old('precio_dia') }}" required>
                            </div>
                            @error('precio_dia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas Adicionales</label>
                            <textarea class="form-control @error('notas') is-invalid @enderror" 
                                      id="notas" name="notas" rows="2">{{ old('notas') }}</textarea>
                            @error('notas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-check me-2"></i>Reservar Equipo
                            </button>
                            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-calcular total cuando cambien las fechas o el precio
document.addEventListener('DOMContentLoaded', function() {
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');
    const precioDia = document.getElementById('precio_dia');
    
    function calcularTotal() {
        if (fechaInicio.value && fechaFin.value && precioDia.value) {
            const inicio = new Date(fechaInicio.value);
            const fin = new Date(fechaFin.value);
            const dias = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24)) + 1;
            const total = dias * parseFloat(precioDia.value);
            
            // Mostrar el total calculado
            let totalDiv = document.getElementById('total-calculado');
            if (!totalDiv) {
                totalDiv = document.createElement('div');
                totalDiv.id = 'total-calculado';
                totalDiv.className = 'alert alert-info mt-3';
                precioDia.parentNode.parentNode.appendChild(totalDiv);
            }
            totalDiv.innerHTML = `<strong>Total estimado: €${total.toFixed(2)} (${dias} días)</strong>`;
        }
    }
    
    fechaInicio.addEventListener('change', calcularTotal);
    fechaFin.addEventListener('change', calcularTotal);
    precioDia.addEventListener('input', calcularTotal);
});
</script>
@endsection

