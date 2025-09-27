<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirpodsPurchase;
// Airpods model eliminado
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AirpodsPurchaseController extends Controller
{
    /**
     * Constructor - aplicar middleware de administrador
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = AirpodsPurchase::with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.airpods-purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::activos()->get();
        
        return view('admin.airpods-purchases.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'airpods_id' => 'nullable|integer',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string|max:1000',
            'product_category' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:paypal,credit_card,bank_transfer,contra_reembolso',
            'payment_status' => 'required|string|in:pending,completed,failed,refunded',
            'order_status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'shipping_address' => 'nullable|string|max:500',
            'billing_address' => 'nullable|string|max:500',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Airpods model eliminado - usar datos directos
        $totalAmount = $request->quantity * $request->unit_price;

        $purchase = AirpodsPurchase::create([
            'user_id' => $request->user_id,
            'airpods_id' => $request->airpods_id,
            'purchase_number' => (new AirpodsPurchase())->generatePurchaseNumber(),
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'order_status' => $request->order_status,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'tracking_number' => $request->tracking_number,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.airpods-purchases.index')
            ->with('success', 'Compra de AirPods creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AirpodsPurchase $airpodsPurchase)
    {
        $airpodsPurchase->load(['user']);
        return view('admin.airpods-purchases.show', compact('airpodsPurchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AirpodsPurchase $airpodsPurchase)
    {
        return view('admin.airpods-purchases.edit', compact('airpodsPurchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AirpodsPurchase $airpodsPurchase)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'airpods_id' => 'nullable|integer',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string|max:1000',
            'product_category' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:paypal,credit_card,bank_transfer,contra_reembolso',
            'payment_status' => 'required|string|in:pending,completed,failed,refunded',
            'order_status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'shipping_address' => 'nullable|string|max:500',
            'billing_address' => 'nullable|string|max:500',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $totalAmount = $request->quantity * $request->unit_price;

        $airpodsPurchase->update([
            'user_id' => $request->user_id,
            'airpods_id' => $request->airpods_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'order_status' => $request->order_status,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'tracking_number' => $request->tracking_number,
            'notes' => $request->notes,
        ]);

        // Actualizar fechas según el estado
        if ($request->order_status === 'shipped' && !$airpodsPurchase->shipped_at) {
            $airpodsPurchase->update(['shipped_at' => Carbon::now()]);
        }

        if ($request->order_status === 'delivered' && !$airpodsPurchase->delivered_at) {
            $airpodsPurchase->update(['delivered_at' => Carbon::now()]);
        }

        return redirect()->route('admin.airpods-purchases.index')
            ->with('success', 'Compra de AirPods actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AirpodsPurchase $airpodsPurchase)
    {
        $airpodsPurchase->delete();

        return redirect()->route('admin.airpods-purchases.index')
            ->with('success', 'Compra de AirPods eliminada exitosamente.');
    }

    /**
     * Generar PDF de la compra
     */
    public function generatePDF(AirpodsPurchase $airpodsPurchase)
    {
        try {
            $airpodsPurchase->load(['user']);
            
            $data = [
                'purchase' => $airpodsPurchase,
                'fecha_generacion' => Carbon::now()->format('d/m/Y H:i:s'),
                'empresa' => [
                    'nombre' => 'Location familiale Mostaganem',
                    'direccion' => 'Mostaganem Chaibia ben abdelmalek ramdane, Algeria',
                    'telefono' => '+34 604114581',
                    'email' => 'chebiliaimed9@gmail.com'
                ]
            ];

            $pdf = Pdf::loadView('admin.airpods-purchases.pdf', $data);
            
            $filename = "Compra_AirPods_{$airpodsPurchase->purchase_number}_{$airpodsPurchase->user->name}_" . Carbon::now()->format('Y-m-d') . ".pdf";
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('Error generando PDF de compra: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
