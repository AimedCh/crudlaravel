@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de los cartillas</h2>
    
    @if (Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <form action="{{ route('cartilla.index') }}" method="GET">
             
        </form>
    </div>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Titular</th>
                <th>Iban</th>
                <th>Direccion</th>
                <th>Fecha</th>
                <th>Saldo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if (isset($cartilla) && !empty($cartilla))
                @foreach ($cartilla as $cartilla)
                    <tr>
                        <td>{{ $cartilla->id }}</td>
                        <td>{{ $cartilla->titular }}</td>
                        <td>{{ $cartilla->iban }}</td>
                        <td>{{ $cartilla->direccion }}</td>
                        <td>{{ $cartilla->fecha }}</td>
                        <td>{{ $cartilla->saldo }}</td>
                        <td>

                            <a href="{{ url('/cartilla/' . $cartilla->id) }}" 
                                class="btn btn-primary me-2">
                                 Mostrar
                             </a>

                             <a href="{{ url('/cartilla/' . $cartilla->id . '/edit') }}" class="btn btn-success">Editar</a>

                             <a href="{{ route('cartillas.apuntes', $cartilla->id) }}" class="btn btn-warning">Apuntes</a>


                            <form action="{{ url('/cartilla/' . $cartilla->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Quiere borrar el cartilla?')">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">No hay cartillas.</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    <a href="{{ url('/cartilla/create') }}" class="btn btn-primary">Nuevo</a>
                </td>
            </tr>
        </tfoot>
    </table>

 </div>
@endsection
