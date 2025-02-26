@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header  bg-primary text-white">
                    <h2 class="mb-0  text-center">Modificar un cartilla</h2>
                </div>

                <div class="card-body">
                    <form action="{{ url('/cartilla/' . $cartilla->id) }}" 
                          method="post" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        @include('cartilla.form', [
                            'submit' => 'Modificar cartilla',
                            'cancel' => 'Cancelar la modificación'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
