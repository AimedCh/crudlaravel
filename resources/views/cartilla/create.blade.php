@extends ('layouts.app')
@section('content')

<div class="container">

<h1>Insertar cartilla</h1>

<br><br>
<form action="{{ url('/cartilla')}}" method="post" enctype="multipart/form-data">
@csrf
@include('cartilla.form', ['submit' => 'Añadir cartilla', 'cancel' => 'Cancelar la inserción'])
</form>

</div>

@endsection

