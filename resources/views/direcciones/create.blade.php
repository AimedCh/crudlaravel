@extends ('layouts.app')
@section('content')

<div class="container">

<h1>Insertar direccion</h1>

<br><br>
<form action="{{ url('/direcciones')}}" method="post" enctype="multipart/form-data">
@csrf
@include('direcciones.form', ['submit' => 'Añadir direccion', 'cancel' => 'Cancelar la inserción'])
</form>

</div>

@endsection