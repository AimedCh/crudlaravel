@extends('layouts.app')

@section('content')
<div class="container">
    <div class="unified-card">
        <div class="unified-header">
            <i class="fas fa-plus"></i> Crear Nuevo Proveedor
        </div>

        <div class="unified-body">
            <form action="{{ route('admin.proveedores.store') }}" 
                  method="post" 
                  enctype="multipart/form-data">
                @csrf
                
                @include('proveedores.form', [
                    'submit' => 'Crear Proveedor',
                    'cancel' => 'Cancelar'
                ])
            </form>
        </div>
    </div>
</div>
@endsection