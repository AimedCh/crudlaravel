<h1> Formulario para insertar una apuntes</h1>
<div class="form-group">
    <div class="form-group">
       <label for="cartilla">Cartilla</label>
       <select name="cartilla_id" 
               id="cartilla_id" 
               class="form-control @error('cartilla_id') is-invalid @enderror">

           <option value="">Seleccione una cartilla</option>
           @foreach($cartilla as $item)
           @if($item && isset($item->id))
               <option value="{{ $item->id }}"
                   @if (isset($apuntes->cartilla_id) && ($item->id == $apuntes->cartilla_id))
                       selected="selected"
                   @endif>
                   {{ $item->titular }}
               </option>
               @endif
           @endforeach
       </select>
       @error('cartilla_id')
           <div class="invalid-feedback">{{ $message }}</div>
       @enderror
   </div>


    <label for="fecha">Fecha</label>
    <input type="date" 
           name="fecha" 
           id="fecha" 
           maxlength="64" 
           class="form-control" 
           value="{{ isset($apuntes->fecha) ? $apuntes->fecha : old('fecha') }}" 
           @if(isset($readonly)) {{ $readonly }} @endif>
    <br>
    
    
    <label for="concepto">Concepto</label>
    <input type="text" 
           name="concepto" 
           id="concepto" 
           maxlength="100" 
           class="form-control" 
           value="{{ isset($apuntes->concepto) ? $apuntes->concepto : old('concepto') }}">
    <br>

    <label for="importe">Importe</label>
    <input type="text" 
           name="importe" 
           id="importe" 
           maxlength="64" 
           class="form-control" 
           value="{{ isset($apuntes->importe) ? $apuntes->importe : old('importe') }}">
    <br>
    

    <!-- Botones -->
    <div class="d-flex justify-content-start mt-3">
        @if (isset($submit))
        <button type="submit" class="btn btn-primary me-2">{{ $submit }}</button>
        @endif
        <a href="{{ url('apuntes/') }}" class="btn btn-secondary">{{ $cancel }}</a>
    </div>