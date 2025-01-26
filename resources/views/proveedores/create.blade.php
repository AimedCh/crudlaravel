@extends ('layouts.app')
@section('content')

<div class="container">

<h1>Insertar proveedor</h1>

<br><br>
<form action="{{ url('/proveedores')}}" method="post" enctype="multipart/form-data">
@csrf
@include('proveedores.form', ['submit' => 'Añadir Proveedor', 'cancel' => 'Cancelar la inserción'])
</form>

</div>

@endsection