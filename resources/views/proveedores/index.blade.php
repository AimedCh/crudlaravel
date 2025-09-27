@extends('layouts.app')

@section('content')
<div class="container">
    <div class="unified-card">
        <div class="unified-header">
            <i class="fas fa-list"></i> Gestión de Proveedores
        </div>
        
        <div class="unified-body">
            @if (Session::has('mensaje'))
            <div class="unified-alert unified-alert-success">
                {{ Session::get('mensaje') }}
            </div>
            @endif

            <div class="unified-form-group">
                <form action="{{ route('admin.proveedores.index') }}" method="GET" style="display: flex; gap: 10px; align-items: end;">
                    <div style="flex: 1;">
                        <input type="text" class="unified-form-control" name="buscar" value="{{ $buscar }}" placeholder="Buscar por nombre o email...">
                    </div>
                    <button type="submit" class="unified-btn unified-btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('admin.proveedores.create') }}" class="unified-btn unified-btn-success">
                        <i class="fas fa-plus"></i> Nuevo Proveedor
                    </a>
                </form>
            </div>

            <table class="unified-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
        <tbody>
            @if (isset($proveedores) && !empty($proveedores))
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->telefono ?? 'N/A' }}</td>
                        <td>{{ Str::limit($proveedor->direccion ?? 'N/A', 30) }}</td>
                        <td>
                            <a href="{{ route('admin.proveedores.show', $proveedor) }}" class="unified-btn unified-btn-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('admin.proveedores.edit', $proveedor) }}" class="unified-btn unified-btn-success">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <form action="{{ route('admin.proveedores.destroy', $proveedor) }}" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="unified-btn unified-btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #6c757d;">
                        <i class="fas fa-info-circle"></i> No hay proveedores registrados
                    </td>
                </tr>
            @endif
                </tbody>
            </table>

            @if(isset($proveedores) && $proveedores->hasPages())
                <div style="margin-top: 20px; text-align: center;">
                    {!! $proveedores->links() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
