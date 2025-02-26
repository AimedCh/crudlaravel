@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Modificar linea</h1>
                    <form action="{{ url('/lineasfacturas/' . $lineasfactura->id) }}" 
                          method="post" 
                          enctype="multipart/form-data">
                        @csrf
                        @php
                        $factura_id=$lineasfacturas->factura-id;
                        @endphp

                        {{@method_field('PATCH')}}
                        
                        @include('lineasfacturas.form', [
                            'submit' => 'Modificar linea',
                            'cancel' => 'Cancelar la modificación'
                        ])
                    </form>
</div>
@endsection
