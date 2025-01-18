@if (count($errors) > 0)
<div class="alert alert-danger" role="alert">
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}
@endforeach
</ul>
</div>
@endif

<div class="form-group">
<!-- Nombre -->
<label for="nombre">Nombre</label>
<input type="text" 
       name="nombre" 
       id="nombre" 
       maxlength="64" 
       class="form-control" 
       value="{{ isset($cliente->nombre) ? $cliente->nombre : old('nombre') }}" 
       @if(isset($readonly)) {{ $readonly }} @endif>
<br>

<!-- Dirección -->
<label for="direccion">Dirección</label>
<input type="text" 
       name="direccion" 
       id="direccion" 
       maxlength="64" 
       class="form-control" 
       value="{{ isset($cliente->direccion) ? $cliente->direccion : old('direccion') }}">
<br>

<!-- Email -->
<label for="email">Email</label>
<input type="email" 
       name="email" 
       id="email" 
       maxlength="100" 
       class="form-control" 
       value="{{ isset($cliente->email) ? $cliente->email : old('email') }}">
<br>

<!-- Teléfono -->
<label for="telefono">Teléfono</label>
<input type="text" 
       name="telefono" 
       id="telefono" 
       maxlength="11" 
       class="form-control" 
       value="{{ isset($cliente->telefono) ? $cliente->telefono : old('telefono') }}">
<br>

<!-- Logo -->
<label for="logo">Logo</label>
@if (isset($cliente->logo) && $cliente->logo)
    <div class="mb-2">
        <img src="{{ asset('storage/' . $cliente->logo) }}" height="30" class="img-thumbnail">
    </div>
@endif
<input type="file" 
       name="logo" 
       id="logo" 
       accept="image/*">
<br>

<!-- Botones -->
<div class="d-flex justify-content-start mt-3">
    @if (isset($submit))
    <button type="submit" class="btn btn-primary me-2">{{ $submit }}</button>
    @endif
    <a href="{{ url('clientes/') }}" class="btn btn-secondary">{{ $cancel }}</a>
</div>
