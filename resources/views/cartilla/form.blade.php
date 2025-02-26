<h1> Formulario para insertar una cartilla</h1>
<div class="form-group">
    <label for="Titular">Titular</label>
    <input type="text" 
           name="Titular" 
           id="Titular" 
           maxlength="64" 
           class="form-control" 
           value="{{ isset($cartilla->titular) ? $cartilla->titular : old('titular') }}" 
           @if(isset($readonly)) {{ $readonly }} @endif>
    <br>
    
    <label for="iban">IBAN</label>
    <input type="text" 
           name="iban" 
           id="iban" 
           maxlength="100" 
           class="form-control" 
           value="{{ isset($cartilla->iban) ? $cartilla->iban : old('iban') }}"
           @if(isset($readonly)) {{ $readonly }} @endif>
    <br>

    <label for="direccion">Dirección</label>
    <input type="text" 
           name="direccion" 
           id="direccion" 
           maxlength="64" 
           class="form-control" 
           value="{{ isset($cartilla->direccion) ? $cartilla->direccion : old('direccion') }}"
           @if(isset($readonly)) {{ $readonly }} @endif>
    <br>
    
    <label for="fecha">Fecha</label>
    <input type="date" 
           name="fecha" 
           id="fecha" 
           maxlength="11" 
           class="form-control" 
           value="{{ isset($cartilla->fecha) ? $cartilla->fecha : old('fecha') }}"
           @if(isset($readonly)) {{ $readonly }} @endif>
    <br>
    
       <label for="saldo">Saldo</label>
       <input type="text" 
              name="saldo" 
              id="saldo" 
              maxlength="64" 
              class="form-control" 
              value="{{ isset($cartilla->saldo) ? $cartilla->saldo : old('saldo') }}"
              @if(isset($readonly)) {{ $readonly }} @endif>
       <br>
    
    <!-- Botones -->
    <div class="d-flex justify-content-start mt-3">
        @if (isset($submit))
        <button type="submit" class="btn btn-primary me-2">{{ $submit }}</button>
        @endif
        <a href="{{ url('cartilla/') }}" class="btn btn-secondary">{{ $cancel }}</a>
    </div>