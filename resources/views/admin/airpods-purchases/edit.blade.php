@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Compra de AirPods - {{ $airpodsPurchase->purchase_number }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.airpods-purchases.update', $airpodsPurchase) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cliente</label>
                                    <div class="form-control-plaintext">
                                        @if($airpodsPurchase->user_id)
                                            {{ $airpodsPurchase->user->name ?? 'Cliente eliminado' }} ({{ $airpodsPurchase->user->email ?? 'N/A' }})
                                        @else
                                            <span class="text-muted">Cliente no registrado</span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ $airpodsPurchase->user_id }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Nombre del Producto *</label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                           id="product_name" name="product_name" value="{{ old('product_name', $airpodsPurchase->product_name) }}" 
                                           required>
                                    @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_description" class="form-label">Descripción del Producto</label>
                                    <textarea class="form-control @error('product_description') is-invalid @enderror" 
                                              id="product_description" name="product_description" rows="2">{{ old('product_description', $airpodsPurchase->product_description) }}</textarea>
                                    @error('product_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_category" class="form-label">Categoría del Producto</label>
                                    <input type="text" class="form-control @error('product_category') is-invalid @enderror" 
                                           id="product_category" name="product_category" value="{{ old('product_category', $airpodsPurchase->product_category) }}">
                                    @error('product_category')
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
                                           id="quantity" name="quantity" value="{{ old('quantity', $airpodsPurchase->quantity) }}" 
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
                                           id="unit_price" name="unit_price" value="{{ old('unit_price', $airpodsPurchase->unit_price) }}" 
                                           step="0.01" min="0" required>
                                    @error('unit_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Total</label>
                                    <div class="form-control-plaintext" id="total_display">€{{ number_format($airpodsPurchase->total_amount, 2) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Método de Pago *</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                        <option value="paypal" {{ old('payment_method', $airpodsPurchase->payment_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="credit_card" {{ old('payment_method', $airpodsPurchase->payment_method) == 'credit_card' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                                        <option value="bank_transfer" {{ old('payment_method', $airpodsPurchase->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Transferencia Bancaria</option>
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
                                        <option value="pending" {{ old('payment_status', $airpodsPurchase->payment_status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completed" {{ old('payment_status', $airpodsPurchase->payment_status) == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="failed" {{ old('payment_status', $airpodsPurchase->payment_status) == 'failed' ? 'selected' : '' }}>Fallido</option>
                                        <option value="refunded" {{ old('payment_status', $airpodsPurchase->payment_status) == 'refunded' ? 'selected' : '' }}>Reembolsado</option>
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
                                        <option value="pending" {{ old('order_status', $airpodsPurchase->order_status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="processing" {{ old('order_status', $airpodsPurchase->order_status) == 'processing' ? 'selected' : '' }}>Procesando</option>
                                        <option value="shipped" {{ old('order_status', $airpodsPurchase->order_status) == 'shipped' ? 'selected' : '' }}>Enviado</option>
                                        <option value="delivered" {{ old('order_status', $airpodsPurchase->order_status) == 'delivered' ? 'selected' : '' }}>Entregado</option>
                                        <option value="cancelled" {{ old('order_status', $airpodsPurchase->order_status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
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
                                           id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $airpodsPurchase->tracking_number) }}">
                                    @error('tracking_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Dirección de Envío</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="3">{{ old('shipping_address', $airpodsPurchase->shipping_address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Dirección de Facturación</label>
                            <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                                      id="billing_address" name="billing_address" rows="3">{{ old('billing_address', $airpodsPurchase->billing_address) }}</textarea>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $airpodsPurchase->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.airpods-purchases.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Actualizar Compra
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
    const unitPriceInput = document.getElementById('unit_price');
    const quantityInput = document.getElementById('quantity');
    const totalDisplay = document.getElementById('total_display');

    function calculateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalDisplay.textContent = '€' + total.toFixed(2);
    }

    unitPriceInput.addEventListener('input', calculateTotal);
    quantityInput.addEventListener('input', calculateTotal);
    
    // Calcular total inicial
    calculateTotal();
});
</script>
@endsection


