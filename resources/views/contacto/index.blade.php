@extends('layouts.app')

@section('content')
<div class="container">
    <div class="unified-card">
        <div class="unified-header">
            <i class="fas fa-envelope"></i> Gestión de Mensajes de Contacto
            <div style="float: right;">
                <a href="{{ route('admin.contacto.create') }}" class="unified-btn unified-btn-success">
                    <i class="fas fa-plus"></i> Nuevo Mensaje
                </a>
                <span class="unified-badge unified-badge-info" style="margin-left: 10px;">
                    {{ $contactos->total() }} mensajes
                </span>
            </div>
        </div>

        <div class="unified-body">
            @if(session('success'))
                <div class="unified-alert unified-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($contactos->count() > 0)
                <table class="unified-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Asunto</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                                <tbody>
                                    @foreach($contactos as $contacto)
                                        <tr class="{{ $contacto->status === 'new' ? 'table-warning' : '' }}">
                                            <td>{{ $contacto->id }}</td>
                                            <td>{{ $contacto->name }}</td>
                                            <td>
                                                <a href="mailto:{{ $contacto->email }}">{{ $contacto->email }}</a>
                                            </td>
                                            <td>{{ $contacto->phone ?? 'N/A' }}</td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                      title="{{ $contacto->subject }}">
                                                    {{ $contacto->subject }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="unified-badge unified-badge-info">{{ $contacto->service_label }}</span>
                                            </td>
                                            <td>
                                                @switch($contacto->status)
                                                    @case('new')
                                                        <span class="unified-badge unified-badge-warning">Nuevo</span>
                                                        @break
                                                    @case('read')
                                                        <span class="unified-badge unified-badge-primary">Leído</span>
                                                        @break
                                                    @case('replied')
                                                        <span class="unified-badge unified-badge-success">Respondido</span>
                                                        @break
                                                    @case('closed')
                                                        <span class="unified-badge" style="background: #6c757d; color: white;">Cerrado</span>
                                                        @break
                                                    @default
                                                        <span class="unified-badge" style="background: #e9ecef; color: #495057;">{{ ucfirst($contacto->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $contacto->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                                    <a href="{{ route('admin.contacto.show', $contacto) }}" 
                                                       class="unified-btn unified-btn-primary" title="Ver">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                    <a href="{{ route('admin.contacto.edit', $contacto) }}" 
                                                       class="unified-btn unified-btn-success" title="Editar">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    @if($contacto->status === 'new' || $contacto->status === 'read')
                                                        <form action="{{ route('admin.contacto.mark-replied', $contacto) }}" 
                                                              method="POST" style="display: inline;" title="Marcar como Respondido">
                                                            @csrf
                                                            <button type="submit" class="unified-btn unified-btn-warning">
                                                                <i class="fas fa-reply"></i> Responder
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if($contacto->status !== 'closed')
                                                        <form action="{{ route('admin.contacto.mark-closed', $contacto) }}" 
                                                              method="POST" style="display: inline;" title="Cerrar">
                                                            @csrf
                                                            <button type="submit" class="unified-btn" style="background: #6c757d; color: white;">
                                                                <i class="fas fa-times"></i> Cerrar
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.contacto.destroy', $contacto) }}" 
                                                          method="POST" 
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?')"
                                                          title="Delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="unified-btn unified-btn-danger">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $contactos->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No contact messages found</h5>
                            <p class="text-muted">Contact messages will appear here when customers reach out.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
