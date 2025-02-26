@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de Recibos</h2>
    
    @if (Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
        </div>
    @endif
 
<div class="row">
    <form action="{{ route('recibos.index') }}" method="GET">
        <div class="form-row">
         
    </form>
</div>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Nombre del Cliente</th>
            <th>Número de Factura</th>
            <th>Fecha de Factura</th>
            <th>Fecha de Recibo</th>
            <th>Importe</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($recibos) && $recibos->isNotEmpty())
            @foreach ($recibos as $recibo)
                <tr>
                    <td>{{ $recibo->factura->cliente->nombre }}</td>
                    <td>{{ $recibo->factura->id }}</td>
                    <td>{{ $recibo->factura->fecha }}</td>
                    <td>{{ $recibo->fecha }}</td>
                    <td>{{ number_format($recibo->importe, 2) }} €</td>
                    <td>
                         <form action="{{ url('/recibos/' . $recibo->recibo_id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2" onclick="return confirm('¿Quiere borrar el recibo?')">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">No hay recibos.</td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <a href="{{ url('/generarRecibos') }}" class="btn btn-primary">Generar Recibos</a>
            </td>
        </tr>
    </tfoot>
</table>
</div>
@endsection
