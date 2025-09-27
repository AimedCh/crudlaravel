<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirpodsPurchase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AirpodsOrderController extends Controller
{
    /**
     * Procesar orden de AirPods desde el frontend
     */
    public function order(Request $request)
    {
        // Log de debugging
        \Log::info('AirPods Order Request:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'data' => $request->all()
        ]);

        try {
            // Validar los datos recibidos (soporta ambos formatos: frontend y API)
            $validator = Validator::make($request->all(), [
                'airpods_id' => 'nullable|integer',
                'product_name' => 'nullable|string|max:255',
                'product_description' => 'nullable|string|max:1000',
                'product_category' => 'nullable|string|max:100',
                'quantity' => 'required|integer|min:1',
                'unit_price' => 'nullable|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:paypal,cod,contra_reembolso',
                'shipping_address' => 'required|string|max:500',
                'notes' => 'nullable|string|max:1000',
                // Campos del frontend
                'customer_name' => 'nullable|string|max:255',
                'customer_email' => 'nullable|email|max:255',
                'customer_phone' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de orden inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generar número de compra único
            $purchaseNumber = 'AP-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Determinar el nombre del producto (del frontend o API)
            $productName = $request->product_name;
            if (!$productName && $request->airpods_id) {
                // Si no hay nombre pero hay ID, usar un nombre genérico
                $productName = 'AirPods Pro';
            }
            if (!$productName) {
                $productName = 'AirPods';
            }

            // Determinar precio unitario
            $unitPrice = $request->unit_price;
            if (!$unitPrice) {
                $unitPrice = $request->total_amount / $request->quantity;
            }

            // Crear la compra en la tabla airpods_purchases
            $purchase = AirpodsPurchase::create([
                'user_id' => null, // Frontend no maneja autenticación Laravel
                'airpods_id' => $request->airpods_id,
                'purchase_number' => $purchaseNumber,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'total_amount' => $request->total_amount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->shipping_address, // Same as shipping for COD
                'notes' => $request->notes . ($request->customer_name ? "\nCliente: " . $request->customer_name : '') . ($request->customer_email ? "\nEmail: " . $request->customer_email : '') . ($request->customer_phone ? "\nTeléfono: " . $request->customer_phone : ''),
                'product_name' => $productName,
                'product_description' => $request->product_description ?: 'AirPods de alta calidad',
                'product_category' => $request->product_category ?: 'Standard',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Orden procesada exitosamente',
                'order_number' => $purchaseNumber,
                'purchase_id' => $purchase->id,
                'data' => [
                    'id' => $purchase->id,
                    'purchase_number' => $purchase->purchase_number,
                    'total_amount' => $purchase->total_amount,
                    'order_status' => $purchase->order_status,
                    'payment_status' => $purchase->payment_status,
                ]
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Error procesando orden de AirPods:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la orden. Por favor, inténtalo de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener catálogo de AirPods (para el frontend)
     */
    public function catalog()
    {
        // Datos estáticos de AirPods para el frontend
        $airpods = [
            [
                'id' => 1,
                'name' => 'AirPods Pro (2ª generación)',
                'description' => 'AirPods Pro con cancelación activa de ruido y audio espacial personalizado',
                'category' => 'Pro',
                'price' => 249.00,
                'image' => '/img/imgAirPods/airpods-pro-2.jpg',
                'features' => ['Cancelación activa de ruido', 'Audio espacial', 'Resistencia al agua IPX4'],
                'stock' => 10
            ],
            [
                'id' => 2,
                'name' => 'AirPods (3ª generación)',
                'description' => 'AirPods con audio espacial y diseño contorneado',
                'category' => 'Standard',
                'price' => 179.00,
                'image' => '/img/imgAirPods/airpods-3.jpg',
                'features' => ['Audio espacial', 'Diseño contorneado', 'Resistencia al agua IPX4'],
                'stock' => 15
            ],
            [
                'id' => 3,
                'name' => 'AirPods Max',
                'description' => 'Auriculares over-ear con cancelación activa de ruido',
                'category' => 'Max',
                'price' => 549.00,
                'image' => '/img/imgAirPods/airpods-max.jpg',
                'features' => ['Cancelación activa de ruido', 'Audio de alta fidelidad', 'Hasta 20 horas de batería'],
                'stock' => 5
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $airpods
        ]);
    }
}