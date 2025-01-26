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
value="{{ isset($proveedores->nombre) ? $proveedores->nombre : old('nombre') }}"
@if(isset($readonly)) {{ $readonly }} @endif>
<br>
 

<!-- Email -->
<label for="email">Email</label>
<input type="email" 
       name="email" 
       id="email" 
       maxlength="100" 
       class="form-control" 
       value="{{ isset($proveedores->email) ? $proveedores->email : old('email') }}"
       @if(isset($readonly)) {{ $readonly }} @endif>
       
<br>
 

 
<br>

<!-- Botones -->
<div class="d-flex justify-content-start mt-3">
    @if (isset($submit))
    <button type="submit" class="btn btn-primary me-2">{{ $submit }}</button>
    @endif
    <a href="{{ url('proveedores/') }}" class="btn btn-secondary">{{ $cancel }}</a>
</div>
