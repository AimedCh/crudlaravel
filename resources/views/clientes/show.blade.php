@extends('layouts.app')
@section('content')
<div class="container">
Formulario para modificar un cliente
<br><br>
<form action="{{ url('/clientes/') }}" method="post">
@csrf
@include('clientes.form',
[
'cancel'=>'Cancelar la modificacion',
'readonly'=>'readonly'])
</form>

</div>
@endsection