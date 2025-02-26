@extends('layouts.app')
@section('content')

<div class="form-group">
       <label for="descripcion">Descripción</label>
       <input type="text" 
              name="descripcion" 
              id="descripcion" 
              class="form-control @error('descripcion') is-invalid @enderror" 
              value="{{ isset($linea->descripcion) ? $linea->descripcion : old('descripcion') }}" 
              @if (isset($readonly)) {{ $readonly }} @endif>
       @error('descripcion')
           <div class="invalid-feedback">{{ $message }}</div>
       @enderror
   </div>
   
   <div class="form-group">
       <label for="cantidad">Cantidad</label>
       <input type="number" 
              name="cantidad" 
              id="cantidad" 
              min="1" 
              class="form-control @error('cantidad') is-invalid @enderror" 
              value="{{ isset($linea->cantidad) ? $linea->cantidad : old('cantidad') }}" 
              @if (isset($readonly)) {{ $readonly }} @endif>
       @error('cantidad')
           <div class="invalid-feedback">{{ $message }}</div>
       @enderror
   </div>
   
   <div class="form-group">
       <label for="precio">Precio Unitario</label>
       <input type="number" 
              name="precio" 
              id="precio" 
              min="0.01" step="0.01"
              class="form-control @error('precio') is-invalid @enderror" 
              value="{{ isset($linea->precio) ? $linea->precio : old('precio') }}" 
              @if (isset($readonly)) {{ $readonly }} @endif>
       @error('precio')
           <div class="invalid-feedback">{{ $message }}</div>
       @enderror
   </div>
   
   <div class="form-group">
       <label for="importe">Importe</label>
       <input type="number" 
              name="importe" 
              id="importe" 
              min="0.01" step="0.01"
              class="form-control @error('importe') is-invalid @enderror" 
              value="{{ isset($linea->importe) ? $linea->importe : old('importe') }}" 
              @if (isset($readonly)) {{ $readonly }} @endif>
       @error('importe')
           <div class="invalid-feedback">{{ $message }}</div>
       @enderror
   </div>
   
   <div class="form-group mt-4">
       @if (isset($submit))
           <button type="submit" class="btn btn-primary">{{ $submit }}</button>
       @endif
   
       <a href="{{ url('/factura/'.$factura->id.'/lineasfacturas') }}" class="btn btn-secondary">{{ $cancel }}</a>
   </div>
   