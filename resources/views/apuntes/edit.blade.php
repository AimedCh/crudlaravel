@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header  bg-primary text-white">
                    <h2 class="mb-0  text-center">Modificar un apuntes</h2>
                </div>

                <div class="card-body">
                    <form action="{{ url('/apuntes/' . $apunte->id) }}" 
                          method="post" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        @include('apuntes.form', [
                            'submit' => 'Modificar apuntes',
                            'cancel' => 'Cancelar la modificación'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
