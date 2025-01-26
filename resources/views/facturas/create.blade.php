@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Formulario para crear una factura</h2>

    <form action="{{ url('/facturas') }}" method="post">
        @csrf
        @include('facturas.form', [
            'submit' => 'Crear factura', 
            'cancel' => 'Cancelar la creación'
        ])
    </form>
</div>
@endsection
