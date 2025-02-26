@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de los apuntes</h2>
    
    @if (Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <form action="{{ route('apuntes.index') }}" method="GET">
            <div class="form-row">
                 
               
                
            </div>
        </form>
    </div>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                 <th>Fecha</th>
                <th>Concepto</th>
                <th>Importe</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ($apuntes->count() > 0)
            @foreach ($apuntes as $apunte)
                    <tr>
                        <td>{{ $apunte->fecha }}</td>
                        <td>{{ $apunte->concepto }}</td>
                        <td>{{ $apunte->importe }}</td>
                        <td>
                            
                            <a href="{{ url('/apuntes/' . $apunte->id . '/edit') }}" class="btn btn-success">Editar</a>
                            <form action="{{ url('/apuntes/' . $apunte->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Quiere borrar el apuntes?')">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">No hay apuntes.</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    <a href="{{ url('/apuntes/create') }}" class="btn btn-primary">Nuevo</a>
                </td>
            </tr>
        </tfoot>
    </table>

    {!! $apuntes->links() !!} <!-- Usar la variable correcta para la paginación -->
</div>
@endsection
