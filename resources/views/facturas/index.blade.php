@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de las facturas</h2>
    
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
                <th>Id</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Base</th>
                <th>Importe I.V.A</th>
                <th>Importe</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($facturas) && count($facturas) > 0)
                @foreach ($facturas as $factura)
                    <tr>
                        <td>{{ $factura->id }}</td>
                        <td>{{ $factura->fecha }}</td>
                        <td>{{ $factura->cliente->nombre ?? 'Sin cliente' }}</td>
                        <td>{{ $factura->base }}</td>
                        <td>{{ $factura->importeiva }}</td>
                        <td>{{ $factura->importe }}</td>
                        <td>
                            <a href="{{ url('/facturas/' . $factura->id . '/edit') }}" class="btn btn-success me-2">
                                Editar
                            </a>

                            <!-- Botón para generar recibos -->
                            <a href="{{ route('recibos.generar', $factura->id) }}" class="btn btn-primary me-2">
                                Generar Recibo
                            </a>

                            <a href="{{ route('verRecibos', ['factura_id' => $factura->id]) }}" class="btn btn-warning me-2">
                                Ver Recibos
                            </a>
                            

                            <!-- Formulario para borrar -->
                            <form action="{{ url('/facturas/' . $factura->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Quiere borrar la factura seleccionada?')">
                                    Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Sin facturas</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    <a href="{{ url('/facturas/create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nueva Factura
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>

    {!! $facturas->links() !!}
</div>
@endsection
