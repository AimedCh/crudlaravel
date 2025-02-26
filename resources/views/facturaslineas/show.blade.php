@extends('layouts.app')
@section('content')
<div class="container">
Formulario para modificar un lineas factura
<br><br>
<form action="{{ url('/lineasfacturas/') }}" method="post">
@csrf
@include('lineasfacturas.form',
[
'cancel'=>'Cancelar la modificacion',
'readonly'=>'readonly'])
</form>

</div>
@endsection