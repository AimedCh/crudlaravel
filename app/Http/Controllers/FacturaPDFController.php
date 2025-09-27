<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\AlquileresReserva;
use App\Models\facturas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaPDFController extends Controller
{
    /**
     * Constructor - aplicar middleware de administrador para algunas rutas
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['downloadClientOrder', 'downloadClientReservation']);
        $this->middleware('auth:web')->only(['downloadClientOrder', 'downloadClientReservation']);
    }

    /**
     * Generar factura PDF para una orden
     */
    public function generateOrderPDF($orden_id)
    {
        $orden = Orden::with('user')->findOrFail($orden_id);
        
        $data = [
            'orden' => $orden,
            'fecha_generacion' => now(),
            'tipo' => 'orden'
        ];

        $pdf = Pdf::loadView('pdf.factura-orden', $data);
        
        return $pdf->download('factura-orden-' . $orden->id . '.pdf');
    }

    /**
     * Generar factura PDF para una reserva de alquiler
     */
    public function generateReservationPDF($reserva_id)
    {
        $reserva = AlquileresReserva::with('user')->findOrFail($reserva_id);
        
        $data = [
            'reserva' => $reserva,
            'fecha_generacion' => now(),
            'tipo' => 'reserva'
        ];

        $pdf = Pdf::loadView('pdf.factura-reserva', $data);
        
        return $pdf->download('factura-reserva-' . $reserva->id . '.pdf');
    }

    /**
     * Generar factura PDF para factura existente
     */
    public function generateInvoicePDF($factura_id)
    {
        $factura = facturas::with('cliente')->findOrFail($factura_id);
        
        $data = [
            'factura' => $factura,
            'fecha_generacion' => now(),
            'tipo' => 'factura'
        ];

        $pdf = Pdf::loadView('pdf.factura-general', $data);
        
        return $pdf->download('factura-' . $factura->numero . '.pdf');
    }

    /**
     * Descargar factura de orden para cliente autenticado
     */
    public function downloadClientOrder($orden_id)
    {
        $orden = Orden::where('user_id', Auth::id())->findOrFail($orden_id);
        
        $data = [
            'orden' => $orden,
            'fecha_generacion' => now(),
            'tipo' => 'orden'
        ];

        $pdf = Pdf::loadView('pdf.factura-orden', $data);
        
        return $pdf->download('mi-factura-orden-' . $orden->id . '.pdf');
    }

    /**
     * Descargar factura de reserva para cliente autenticado
     */
    public function downloadClientReservation($reserva_id)
    {
        $reserva = AlquileresReserva::where('user_id', Auth::id())->findOrFail($reserva_id);
        
        $data = [
            'reserva' => $reserva,
            'fecha_generacion' => now(),
            'tipo' => 'reserva'
        ];

        $pdf = Pdf::loadView('pdf.factura-reserva', $data);
        
        return $pdf->download('mi-factura-reserva-' . $reserva->id . '.pdf');
    }

    /**
     * Vista previa de factura de orden
     */
    public function previewOrderPDF($orden_id)
    {
        $orden = Orden::with('user')->findOrFail($orden_id);
        
        $data = [
            'orden' => $orden,
            'fecha_generacion' => now(),
            'tipo' => 'orden'
        ];

        $pdf = Pdf::loadView('pdf.factura-orden', $data);
        
        return $pdf->stream('preview-factura-orden-' . $orden->id . '.pdf');
    }

    /**
     * Vista previa de factura de reserva
     */
    public function previewReservationPDF($reserva_id)
    {
        $reserva = AlquileresReserva::with('user')->findOrFail($reserva_id);
        
        $data = [
            'reserva' => $reserva,
            'fecha_generacion' => now(),
            'tipo' => 'reserva'
        ];

        $pdf = Pdf::loadView('pdf.factura-reserva', $data);
        
        return $pdf->stream('preview-factura-reserva-' . $reserva->id . '.pdf');
    }
}
