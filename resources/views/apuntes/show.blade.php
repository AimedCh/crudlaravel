@extends('layouts.app')
@section('content')
<div class="container">
Formulario para modificar un apuntes
<br><br>
<form action="{{ url('/apuntes/') }}" method="post">
@csrf
@include('apuntes.form',
[
'cancel'=>'Cancelar la modificacion',
'readonly'=>'readonly'])
</form>

</div>
@endsection