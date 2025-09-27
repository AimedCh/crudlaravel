@extends('layouts.app')

@section('content')
<div class="container">
    <div class="unified-card">
        <div class="unified-header">
            <i class="fas fa-calendar-alt"></i> Gestión de Reservas
            <span class="unified-badge unified-badge-info" style="float: right; margin-top: 2px;">
                {{ $reservas->total() }} reservas
            </span>
        </div>

        <div class="unified-body">
            @if(session('success'))
                <div class="unified-alert unified-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($reservas->count() > 0)
                <table class="unified-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Equipo</th>
                            <th>Fechas</th>
                            <th>Precio/Día</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha Reserva</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                                <tbody>
                                    @foreach($reservas as $reserva)
                                        <tr>
                                            <td>{{ $reserva->id }}</td>
                                            <td>
                                                <strong>{{ $reserva->nombre_cliente }}</strong>
                                                @if($reserva->user)
                                                    <br><small class="text-muted">Usuario: {{ $reserva->user->name ?? 'N/A' }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $reserva->email_cliente }}</td>
                                            <td>{{ $reserva->telefono_cliente }}</td>
                                            <td>
                                                <div class="text-center">
                                                    <span class="badge bg-primary fs-6">N/A</span>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-users"></i> personas
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <strong class="text-primary">{{ $reserva->tipo_equipo }}</strong>
                                                    @if($reserva->descripcion_equipo)
                                                        <small class="text-muted">{{ Str::limit($reserva->descripcion_equipo, 40) }}</small>
                                                    @endif
                                                    <small class="text-success">
                                                        <i class="fas fa-bed"></i> Habitación
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>Entrada:</strong> {{ $reserva->fecha_inicio ? $reserva->fecha_inicio->format('d/m/Y') : 'N/A' }}<br>
                                                <strong>Salida:</strong> {{ $reserva->fecha_fin ? $reserva->fecha_fin->format('d/m/Y') : 'N/A' }}
                                            </td>
                                            <td>€{{ number_format($reserva->precio_dia, 2) }}</td>
                                            <td><strong>€{{ number_format($reserva->total, 2) }}</strong></td>
                                            <td>
                                                @switch($reserva->estado)
                                                    @case('pendiente')
                                                        <span class="unified-badge unified-badge-warning">Pendiente</span>
                                                        @break
                                                    @case('confirmado')
                                                        <span class="unified-badge unified-badge-success">Confirmado</span>
                                                        @break
                                                    @case('en_uso')
                                                        <span class="unified-badge unified-badge-info">En Uso</span>
                                                        @break
                                                    @case('devuelto')
                                                        <span class="unified-badge" style="background: #6c757d; color: white;">Devuelto</span>
                                                        @break
                                                    @case('cancelado')
                                                        <span class="unified-badge unified-badge-danger">Cancelado</span>
                                                        @break
                                                    @default
                                                        <span class="unified-badge" style="background: #e9ecef; color: #495057;">{{ $reserva->estado }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                                    <button type="button" class="unified-btn unified-btn-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#reservaModal{{ $reserva->id }}"
                                                            title="Ver detalles">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </button>
                                                    <button type="button" class="unified-btn unified-btn-success" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editModal{{ $reserva->id }}"
                                                            title="Editar reserva">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </button>
                                                    <form action="{{ route('admin.reservas.destroy', $reserva) }}" 
                                                          method="POST" 
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reserva?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="unified-btn unified-btn-danger" title="Eliminar reserva">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.reservas.pdf', $reserva) }}" 
                                                       class="unified-btn unified-btn-warning" target="_blank" title="Generar PDF">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal para ver detalles de la reserva -->
                                        <div class="modal fade" id="reservaModal{{ $reserva->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detalles de la Reserva #{{ $reserva->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Información del Cliente</h6>
                                                                <p><strong>Nombre:</strong> {{ $reserva->nombre_cliente }}</p>
                                                                <p><strong>Email:</strong> {{ $reserva->email_cliente }}</p>
                                                                <p><strong>Teléfono:</strong> {{ $reserva->telefono_cliente }}</p>
                                                                @if($reserva->user)
                                                                    <p><strong>Usuario registrado:</strong> {{ $reserva->user->name ?? 'N/A' }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Detalles de la Reserva</h6>
                                                                <p><strong>Número de huéspedes:</strong> N/A</p>
                                                                <p><strong>Equipo:</strong> {{ $reserva->tipo_equipo }}</p>
                                                                <p><strong>Descripción:</strong> {{ $reserva->descripcion_equipo }}</p>
                                                                <p><strong>Fecha entrada:</strong> {{ $reserva->fecha_inicio ? $reserva->fecha_inicio->format('d/m/Y') : 'N/A' }}</p>
                                                                <p><strong>Fecha salida:</strong> {{ $reserva->fecha_fin ? $reserva->fecha_fin->format('d/m/Y') : 'N/A' }}</p>
                                                                <p><strong>Precio por día:</strong> €{{ number_format($reserva->precio_dia, 2) }}</p>
                                                                <p><strong>Total:</strong> €{{ number_format($reserva->total, 2) }}</p>
                                                                <p><strong>Estado:</strong> 
                                                                    @switch($reserva->estado)
                                                                        @case('pendiente')
                                                                            <span class="badge bg-warning">Pendiente</span>
                                                                            @break
                                                                        @case('confirmado')
                                                                            <span class="badge bg-success">Confirmado</span>
                                                                            @break
                                                                        @case('en_uso')
                                                                            <span class="badge bg-info">En Uso</span>
                                                                            @break
                                                                        @case('devuelto')
                                                                            <span class="badge bg-secondary">Devuelto</span>
                                                                            @break
                                                                        @case('cancelado')
                                                                            <span class="badge bg-danger">Cancelado</span>
                                                                            @break
                                                                        @default
                                                                            <span class="badge bg-light text-dark">{{ $reserva->estado }}</span>
                                                                    @endswitch
                                                                </p>
                                                            </div>
                                                        </div>
                                                        @if($reserva->notas)
                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <h6>Notas</h6>
                                                                    <p>{{ $reserva->notas }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal para editar la reserva -->
                                        <div class="modal fade" id="editModal{{ $reserva->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar Reserva #{{ $reserva->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.reservas.update', $reserva) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nombre del Cliente</label>
                                                                        <input type="text" class="form-control" name="nombre_cliente" value="{{ $reserva->nombre_cliente }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Email</label>
                                                                        <input type="email" class="form-control" name="email_cliente" value="{{ $reserva->email_cliente }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Teléfono</label>
                                                                        <input type="text" class="form-control" name="telefono_cliente" value="{{ $reserva->telefono_cliente }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Número de Huéspedes</label>
                                                                        <input type="number" class="form-control" name="numero_huespedes" value="1" min="1" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Tipo de Equipo/Habitación</label>
                                                                        <input type="text" class="form-control" name="tipo_equipo" value="{{ $reserva->tipo_equipo }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Descripción</label>
                                                                        <textarea class="form-control" name="descripcion_equipo" rows="3">{{ $reserva->descripcion_equipo }}</textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Fecha de Entrada</label>
                                                                        <input type="date" class="form-control" name="fecha_entrada" value="{{ $reserva->fecha_inicio ? $reserva->fecha_inicio->format('Y-m-d') : '' }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Fecha de Salida</label>
                                                                        <input type="date" class="form-control" name="fecha_salida" value="{{ $reserva->fecha_fin ? $reserva->fecha_fin->format('Y-m-d') : '' }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Precio por Día (€)</label>
                                                                        <input type="number" class="form-control" name="precio_dia" value="{{ $reserva->precio_dia }}" step="0.01" min="0" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Estado</label>
                                                                        <select class="form-control" name="estado" required>
                                                                            <option value="pendiente" {{ $reserva->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                                            <option value="confirmado" {{ $reserva->estado == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                                                            <option value="en_uso" {{ $reserva->estado == 'en_uso' ? 'selected' : '' }}>En Uso</option>
                                                                            <option value="devuelto" {{ $reserva->estado == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                                                                            <option value="cancelado" {{ $reserva->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Notas</label>
                                                                <textarea class="form-control" name="notas" rows="2">{{ $reserva->notas }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $reservas->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-calendar-times fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No hay reservas</h5>
                            <p class="text-muted">No se han encontrado reservas de alquiler.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
