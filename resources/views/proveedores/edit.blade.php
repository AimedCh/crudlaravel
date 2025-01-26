@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header  bg-primary text-white">
                    <h2 class="mb-0  text-center">Modificar un proveedor</h2>
                </div>

                <div class="card-body">
                    <form action="{{ url('/proveedores/' . $proveedores->id) }}" 
                          method="post" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        @include('proveedores.form', [
                            'submit' => 'Modificar proveedor',
                            'cancel' => 'Cancelar la modificación'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
