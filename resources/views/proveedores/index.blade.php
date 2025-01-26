@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de los proveedores</h2>
    
    @if (Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <form action="{{ route('proveedores.index') }}" method="GET">
            <div class="form-row">
                <div class="col-sm-8 my-1">
                    <input type="text" class="form-control" name="buscar" value="{{ $buscar }}">
                </div>
                <div class="col-auto my-1">
                    <input type="submit" class="btn btn-primary" value="buscar">
                </div>
            </div>
        </form>
    </div>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if (isset($proveedores) && !empty($proveedores))
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>
                            <a href="{{ url('/proveedores/' . $proveedor->id) }}" class="btn btn-primary">Mostrar</a>
                            <a href="{{ url('/proveedores/' . $proveedor->id . '/edit') }}" class="btn btn-success">Editar</a>

                            <form action="{{ url('/proveedores/' . $proveedor->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Quiere borrar el proveedor?')">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">No hay proveedores.</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    <a href="{{ url('/proveedores/create') }}" class="btn btn-primary">Nuevo</a>
                </td>
            </tr>
        </tfoot>
    </table>

    {!! $proveedores->links() !!} <!-- Usar la variable correcta para la paginación -->
</div>
@endsection
