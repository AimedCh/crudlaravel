@extends('layouts.app')

@section('content')
<div class="container">
    <div class="unified-card">
        <div class="unified-header">
            <i class="fas fa-edit"></i> Editar Proveedor
        </div>

        <div class="unified-body">
            <form action="{{ route('admin.proveedores.update', $proveedores) }}" 
                  method="post" 
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                @include('proveedores.form', [
                    'submit' => 'Actualizar Proveedor',
                    'cancel' => 'Cancelar'
                ])
            </form>
        </div>
    </div>
</div>
@endsection
