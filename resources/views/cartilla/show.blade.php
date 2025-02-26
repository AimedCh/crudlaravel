@extends('layouts.app')
@section('content')
<div class="container">
Formulario para modificar un cartilla
<br><br>
<form action="{{ url('/cartilla/') }}" method="post">
@csrf
@include('cartilla.form',
[
'cancel'=>'Cancelar la modificacion',
'readonly'=>'readonly'])
</form>

</div>
@endsection