@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Gestión de Direcciones</h2>
    
    @if (Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                 <th>Cliente ID</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if (isset($direcciones) && !empty($direcciones))
                @foreach ($direcciones as $direccion)
                    <tr>
                         <td>{{ $direccion->cliente_id }}</td>
                        <td>{{ $direccion->direccion }}</td>
                        <td>{{ $direccion->email }}</td>
                        <td>{{ $direccion->telefono }}</td>
                        <td>
                            <a href="{{ url('/direcciones/' . $direccion->id) }}" class="btn btn-primary">Mostrar</a>
                            <a href="{{ url('/direcciones/' . $direccion->id . '/edit') }}" class="btn btn-success">Editar</a>

                            <form action="{{ url('/direcciones/' . $direccion->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Quiere borrar la dirección?')">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No hay direcciones registradas.</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
                    <a href="{{ url('/direcciones/create') }}" class="btn btn-primary">Nueva Dirección</a>
                </td>
            </tr>
        </tfoot>
    </table>

    {!! $direcciones->links() !!} <!-- Usar la variable correcta para la paginación -->
</div>
@endsection
