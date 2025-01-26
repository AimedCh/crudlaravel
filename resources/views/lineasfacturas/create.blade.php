@extends ('layouts.app')
@section('content')

<div class="container">

<h1>Insertar cliente</h1>

<br><br>
<form action="{{ url('/clientes')}}" method="post" enctype="multipart/form-data">
@csrf
@include('clientes.form', ['submit' => 'Añadir cliente', 'cancel' => 'Cancelar la inserción'])
</form>

</div>

@endsection