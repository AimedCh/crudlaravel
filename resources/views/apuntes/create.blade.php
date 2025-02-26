@extends ('layouts.app')
@section('content')

<div class="container">

 
<br><br>
<form action="{{ url('/apuntes')}}" method="post" enctype="multipart/form-data">
@csrf
@include('apuntes.form', ['submit' => 'Añadir apuntes', 'cancel' => 'Cancelar la inserción'])
</form>

</div>

@endsection