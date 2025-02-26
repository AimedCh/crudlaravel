@if (count($errors) > 0)
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
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
           @if(isset($readonly)) readonly @endif>
    <br>

    <!-- Dirección -->
    <label for="direccion">Dirección</label>
    <input type="text" 
           name="direccion" 
           id="direccion" 
           maxlength="64" 
           class="form-control" 
           value="{{ isset($cliente->direccion) ? $cliente->direccion : old('direccion') }}"
           @if(isset($readonly)) readonly @endif>
    <br>

    <!-- Email -->
    <label for="email">Email</label>
    <input type="email" 
           name="email" 
           id="email" 
           maxlength="100" 
           class="form-control" 
           value="{{ isset($cliente->email) ? $cliente->email : old('email') }}"
           @if(isset($readonly)) readonly @endif>
    <br>

    <!-- Teléfono -->
    <label for="telefono">Teléfono</label>
    <input type="text" 
           name="telefono" 
           id="telefono" 
           maxlength="11" 
           class="form-control" 
           value="{{ isset($cliente->telefono) ? $cliente->telefono : old('telefono') }}"
           @if(isset($readonly)) readonly @endif>
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
           accept="image/*"
           @if(isset($readonly)) disabled @endif>
    <br>

    <br>
    <br>
    <div class="form-group">
        <label for="formapago">Forma de Pago</label>
        <select name="formapago" id="formapago" class="form-control" @if(isset($readonly)) disabled @endif>
            <option value="1" {{ isset($cliente) && $cliente->formapago == 1 ? 'selected' : '' }}>Contado</option>
            <option value="2" {{ isset($cliente) && $cliente->formapago == 2 ? 'selected' : '' }}>Recibo 30 días</option>
            <option value="3" {{ isset($cliente) && $cliente->formapago == 3 ? 'selected' : '' }}>Recibo 30 y 60 días</option>
        </select>
    </div>
    <br>   

    <!-- Botones -->
    <div class="d-flex justify-content-start mt-3">
        @if (isset($submit))
        <button type="submit" class="btn btn-primary me-2" @if(isset($readonly)) disabled @endif>{{ $submit }}</button>
        @endif
        <a href="{{ url('clientes/') }}" class="btn btn-secondary">{{ $cancel }}</a>
    </div>
</div>
