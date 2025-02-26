<div class="form-group">
    <label for="numero">Número</label>
    <input type="text" 
           name="numero" 
           id="numero" 
           maxlength="10" 
           class="form-control @error('numero') is-invalid @enderror" 
           value="{{ isset($factura->numero) ? $factura->numero : old('numero') }}" 
           @if (isset($readonly)) {{ $readonly }} @endif>
    @error('numero')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="fecha">Fecha</label>
    <input type="date" 
           name="fecha" 
           id="fecha" 
           class="form-control @error('fecha') is-invalid @enderror" 
           value="{{ isset($factura->fecha) ? $factura->fecha : old('fecha') }}" 
           @if (isset($readonly)) {{ $readonly }} @endif>
    @error('fecha')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


<div class="form-group">
    <label for="cliente">Cliente</label>
    <select name="cliente_id" 
            id="cliente_id" 
            class="form-control @error('cliente_id') is-invalid @enderror">
        <option value="">Seleccione un cliente</option>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}"
                @if (isset($factura->cliente_id) && ($cliente->id == $factura->cliente_id))
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

<div class="form-group">
    <label for="base">Base</label>
    <input type="number" 
           name="base" 
           id="base" 
           class="form-control @error('base') is-invalid @enderror" 
           value="{{ isset($factura->base) ? $factura->base : old('base') }}" 
           @if (isset($readonly)) {{ $readonly }} @endif>
    @error('base')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="importeiva">Importe I.V.A</label>
    <input type="number" 
           name="importeiva" 
           id="importeiva" 
           class="form-control @error('importeiva') is-invalid @enderror" 
           value="{{ isset($factura->importeiva) ? $factura->importeiva : old('importeiva') }}" 
           @if (isset($readonly)) {{ $readonly }} @endif>
    @error('importeiva')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="importe">Importe</label>
    <input type="number" 
           name="importe" 
           id="importe" 
           class="form-control @error('importe') is-invalid @enderror" 
           value="{{ isset($factura->importe) ? $factura->importe : old('importe') }}" 
           @if (isset($readonly)) {{ $readonly }} @endif>
    @error('importe')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-4">
    @if (isset($submit))
        <button type="submit" class="btn btn-primary">{{ $submit }}</button>
    @endif

    <a href="{{ url('/facturas/') }}" class="btn btn-secondary">{{ $cancel }}</a>
</div>
