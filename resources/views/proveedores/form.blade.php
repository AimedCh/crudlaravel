@if (count($errors) > 0)
<div class="unified-alert unified-alert-danger">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="unified-form-group">
    <label for="nombre" class="unified-form-label">
        <i class="fas fa-user"></i> Nombre *
    </label>
    <input type="text" 
           name="nombre" 
           id="nombre" 
           maxlength="64" 
           class="unified-form-control" 
           value="{{ isset($proveedores->nombre) ? $proveedores->nombre : old('nombre') }}"
           placeholder="Nombre del proveedor"
           @if(isset($readonly)) {{ $readonly }} @endif
           required>
</div>

<div class="unified-form-group">
    <label for="email" class="unified-form-label">
        <i class="fas fa-envelope"></i> Email *
    </label>
    <input type="email" 
           name="email" 
           id="email" 
           maxlength="100" 
           class="unified-form-control" 
           value="{{ isset($proveedores->email) ? $proveedores->email : old('email') }}"
           placeholder="proveedor@ejemplo.com"
           @if(isset($readonly)) {{ $readonly }} @endif
           required>
</div>

<div class="unified-form-group">
    <label for="telefono" class="unified-form-label">
        <i class="fas fa-phone"></i> Teléfono
    </label>
    <input type="text" 
           name="telefono" 
           id="telefono" 
           maxlength="20" 
           class="unified-form-control" 
           value="{{ isset($proveedores->telefono) ? $proveedores->telefono : old('telefono') }}"
           placeholder="+34 XXX XXX XXX"
           @if(isset($readonly)) {{ $readonly }} @endif>
</div>

<div class="unified-form-group">
    <label for="direccion" class="unified-form-label">
        <i class="fas fa-map-marker-alt"></i> Dirección
    </label>
    <textarea name="direccion" 
              id="direccion" 
              class="unified-form-control" 
              rows="3"
              placeholder="Calle, número, ciudad, código postal"
              @if(isset($readonly)) {{ $readonly }} @endif>{{ isset($proveedores->direccion) ? $proveedores->direccion : old('direccion') }}</textarea>
</div>

<!-- Botones -->
<div style="display: flex; gap: 10px; margin-top: 20px;">
    @if (isset($submit))
    <button type="submit" class="unified-btn unified-btn-success">
        <i class="fas fa-save"></i> {{ $submit }}
    </button>
    @endif
    <a href="{{ route('admin.proveedores.index') }}" class="unified-btn unified-btn-warning">
        <i class="fas fa-times"></i> {{ $cancel }}
    </a>
</div>
