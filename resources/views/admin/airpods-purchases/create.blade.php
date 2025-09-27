@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Nueva Compra de AirPods</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.airpods-purchases.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Cliente *</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                        <option value="">Seleccionar cliente</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="airpods_id" class="form-label">Producto AirPods *</label>
                                    <select class="form-select @error('airpods_id') is-invalid @enderror" id="airpods_id" name="airpods_id" required>
                                        <option value="">Seleccionar producto</option>
                                        @foreach($airpods as $airpod)
                                            <option value="{{ $airpod->id }}" 
                                                    data-price="{{ $airpod->price }}"
                                                    {{ old('airpods_id') == $airpod->id ? 'selected' : '' }}>
                                                {{ $airpod->name }} - €{{ number_format($airpod->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('airpods_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Cantidad *</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" name="quantity" value="{{ old('quantity', 1) }}" 
                                           min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="unit_price" class="form-label">Precio Unitario (€) *</label>
                                    <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                           id="unit_price" name="unit_price" value="{{ old('unit_price') }}" 
                                           step="0.01" min="0" required>
                                    @error('unit_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Total</label>
                                    <div class="form-control-plaintext" id="total_display">€0.00</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Método de Pago *</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                        <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transferencia Bancaria</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_status" class="form-label">Estado del Pago *</label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completed" {{ old('payment_status') == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Fallido</option>
                                        <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_status" class="form-label">Estado del Pedido *</label>
                                    <select class="form-select @error('order_status') is-invalid @enderror" id="order_status" name="order_status" required>
                                        <option value="pending" {{ old('order_status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="processing" {{ old('order_status') == 'processing' ? 'selected' : '' }}>Procesando</option>
                                        <option value="shipped" {{ old('order_status') == 'shipped' ? 'selected' : '' }}>Enviado</option>
                                        <option value="delivered" {{ old('order_status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                                        <option value="cancelled" {{ old('order_status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('order_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tracking_number" class="form-label">Número de Seguimiento</label>
                                    <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                                           id="tracking_number" name="tracking_number" value="{{ old('tracking_number') }}">
                                    @error('tracking_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Dirección de Envío</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="3">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Dirección de Facturación</label>
                            <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                                      id="billing_address" name="billing_address" rows="3">{{ old('billing_address') }}</textarea>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.airpods-purchases.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Crear Compra
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const airpodsSelect = document.getElementById('airpods_id');
    const unitPriceInput = document.getElementById('unit_price');
    const quantityInput = document.getElementById('quantity');
    const totalDisplay = document.getElementById('total_display');

    function calculateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalDisplay.textContent = '€' + total.toFixed(2);
    }

    airpodsSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        if (price) {
            unitPriceInput.value = price;
            calculateTotal();
        }
    });

    unitPriceInput.addEventListener('input', calculateTotal);
    quantityInput.addEventListener('input', calculateTotal);
});
</script>
@endsection


