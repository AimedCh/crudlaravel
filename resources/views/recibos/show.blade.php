@extends('layouts.app')
@section('content')
<div class="container">
Mostrar un recibos
<br><br>
<form action="{{ url('/recibos/') }}" method="post">
@csrf
@include('recibos.form',
[
'cancel'=>'Cancelar ',
'readonly'=>'readonly'])
</form>

</div>
@endsection