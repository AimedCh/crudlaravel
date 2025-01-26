@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de los clientes</h2>
    
    @if (Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
        </div>
    @endif
 
<div class="row">
    <form action="{{ route('clientes.index') }}" method="GET">
        <div class="form-row">
        <div class="col-sm-8 my-1"><input type="text" class="form-control" name="buscar" value={{ $buscar }}></div>
        <div class="col-auto my-1"><input type="submit" class="btn btn-primary" value="buscar"></div>
        </div>
    </form>
    </div>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Logo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($clientes) && $clientes->isNotEmpty())
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>
                            @if (!empty($cliente->logo))
                            <img src="{{ asset('storage/' . $cliente->logo) }}" height="80" width="120"
                            class="img-thumbnail img-fluid">
                        
                            @else
                                <span>Sin logo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/clientes/' . $cliente->id) }}" 
                               class="btn btn-primary">
                                Mostrar
                            </a>

                            <a href="{{ url('/facturas/cliente/' . $cliente->id) }}" class="btn btn-warning">Facturas</a>

                            <a href="{{ url('/clientes/' . $cliente->id . '/edit') }}" 
                               class="btn btn-success">
                                Editar
                            </a>

                            <form action="{{ url('/clientes/' . $cliente->id) }}" 
                                  method="post" 
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger" 
                                        onclick="return confirm('¿Quiere borrar el cliente?')">
                                    Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">No hay clientes.</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    <a href="{{ url('/clientes/create') }}" 
                       class="btn btn-primary">
                        Nuevo
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
    {!! $clientes->links() !!}
</div>
@endsection
