@extends('layouts.app')
@section('content')
<div class="container">
Formulario para modificar un proveedores
<br><br>
<form action="{{ url('/proveedores/') }}" method="post">
@csrf
@include('proveedores.form',
[
'cancel'=>'Cancelar la modificacion',
'readonly'=>'readonly'])
</form>

</div>
@endsection