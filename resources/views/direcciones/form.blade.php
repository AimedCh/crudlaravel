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
       <label for="cliente_id">Cliente</label>
       <select name="cliente_id" 
               id="cliente_id" 
               class="form-control @error('cliente_id') is-invalid @enderror"
               @if(isset($readonly)) {{ $readonly }} @endif>
           <option value="">Seleccione un cliente</option>
           @foreach($clientes as $cliente)
               <option value="{{ $cliente->id }}"
                   @if (isset($direccion->cliente_id) && ($cliente->id == $direccion->cliente_id))
                       selected="selected"
                   @endif>
                   {{ $cliente->nombre }}
               </option>
           @endforeach
       </select>
       @error('cliente_id')
           <div class="invalid-feedback">{{ $message }}</div>
       @enderror
   </div>
   
   
 
       
<label for="direccion">direccion</label>
<input type="text" 
       name="direccion" 
       id="direccion" 
       maxlength="100" 
       class="form-control" 
       value="{{ isset($direcciones->direccion) ? $direcciones->direccion : old('direccion') }}"
       @if(isset($readonly)) {{ $readonly }} @endif>
       <br>

       

<!-- Email -->
<label for="email">Email</label>
<input type="email" 
       name="email" 
       id="email" 
       maxlength="100" 
       class="form-control" 
       value="{{ isset($direcciones->email) ? $direcciones->email : old('email') }}"
       @if(isset($readonly)) {{ $readonly }} @endif>
       
<br>
 
 
<label for="telefono">telefono</label>
<input type="number" 
       name="telefono" 
       id="telefono" 
       maxlength="100" 
       class="form-control" 
       value="{{ isset($direcciones->telefono) ? $direcciones->telefono : old('telefono') }}"
       @if(isset($readonly)) {{ $readonly }} @endif>
       <br>

<br>
 
<br>

<!-- Botones -->
<div class="d-flex justify-content-start mt-3">
    @if (isset($submit))
    <button type="submit" class="btn btn-primary me-2">{{ $submit }}</button>
    @endif
    <a href="{{ url('direcciones/') }}" class="btn btn-secondary">{{ $cancel }}</a>
</div>
