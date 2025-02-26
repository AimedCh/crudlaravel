@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Líneas de la Factura: {{ $factura->numero }}</h1>
    <a href="{{ route('FacturasLineas.create', $factura->id) }}" class="btn btn-primary mb-3">Agregar Línea</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($FacturasLineas as $linea)
                <tr>
                    <td>{{ $linea->descripcion }}</td>
                    <td>{{ $linea->cantidad }}</td>
                    <td>{{ number_format($linea->precio, 2) }}</td>
                    <td>{{ number_format($linea->cantidad * $linea->precio, 2) }}</td>
                    <td>
                        <a href="{{ route('facturaslineas.edit', ['factura_id' => $factura->id, 'linea_id' => $linea->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('FacturasLineas.destroy', ['factura_id' => $factura->id, 'linea_id' => $linea->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
