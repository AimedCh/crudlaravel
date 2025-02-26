<?php

namespace App\Http\Controllers;

use App\Models\facturas;
use App\Models\recibos;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Carbon\Carbon; 

class RecibosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $recibos = recibos::all();
        $recibos = recibos::with('factura.cliente')->paginate(10);
        return view('recibos.index', compact('recibos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('recibos.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $recibo = recibos::findOrFail($id);
        return view('recibos.show', compact('recibo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(recibos $recibos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, recibos $recibos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = recibos :: findOrFail($id);
        recibos:: destroy($id);
        return redirect('recibos')->with('mensaje','recibos borrado.');
        
    }
    
 
 
    public function generarRecibos($factura_id)
    {
        $factura = facturas::findOrFail($factura_id);
        $cliente = Clientes::findOrFail($factura->cliente_id);

        $recibos = [];

        switch ($cliente->formapago) {
            case 1: // Contado
                $recibos[] = [
                    'factura_id' => $factura->id,
                    'fecha' => $factura->fecha,
                    'importe' => $factura->importe
                ];
                break;

            case 2: // Recibo 30 días
                $recibos[] = [
                    'factura_id' => $factura->id,
                    'fecha' => Carbon::parse($factura->fecha)->addDays(30),
                    'importe' => $factura->importe
                ];
                break;

            case 3: // Recibo 30 y 60 días
                $recibos[] = [
                    'factura_id' => $factura->id,
                    'fecha' => Carbon::parse($factura->fecha)->addDays(30),
                    'importe' => $factura->importe / 2
                ];
                $recibos[] = [
                    'factura_id' => $factura->id,
                    'fecha' => Carbon::parse($factura->fecha)->addDays(60),
                    'importe' => $factura->importe / 2
                ];
                break;
        }

        foreach ($recibos as $recibo) {
            recibos::create($recibo);
        }

        return redirect()->route('verRecibos', ['factura_id' => $factura_id]);
    }

    

    public function verRecibos($factura_id)
    {
        $recibos = recibos::where('factura_id', $factura_id)->with('factura.cliente')->get();
        return view('recibos.index', compact('recibos'));

    }

    public function recibosfacturas($factura_id){

    }
}
