@extends('layouts.app')

@section('content')
<div class="container">
    <div class="unified-card">
        <div class="unified-header">
            <i class="fas fa-eye"></i> Ver Proveedor
        </div>

        <div class="unified-body">
            <form action="{{ route('admin.proveedores.index') }}" method="get">
                @include('proveedores.form', [
                    'cancel' => 'Volver a la Lista',
                    'readonly' => 'readonly'
                ])
            </form>
        </div>
    </div>
</div>
@endsection