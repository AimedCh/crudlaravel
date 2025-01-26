Formulario para editar una factura.
<br> <br>
<form action="{{ url('/facturas/' . $factura->id) }}" method="POST">
@csrf
{{ method_field('PATCH') }}
@include('facturas.form', ['submit' => 'Modificar factura', 'cancel' => 'Cancelar la modificación'])
</form>