@extends('layouts.app')
@section('content')
<div class="container">
Formulario para modificar un direcciones
<br><br>
<form action="{{ url('/direcciones/') }}" method="post">
@csrf
@include('direcciones.form',
[
'cancel'=>'Cancelar la modificacion',
'readonly'=>'readonly'])
</form>

</div>
@endsection