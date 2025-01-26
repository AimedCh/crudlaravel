@extends('layouts.app')
@section('content')
<div class="container">
Formulario para modificar un factura
<br><br>
<form action="{{ url('/facturas/') }}" method="post">
@csrf
@include('facturas.form',
[
'cancel'=>'Cancelar la modificacion',
'readonly'=>'readonly'])
</form>

</div>
@endsection