<?php

namespace App\Http\Controllers;

use App\Models\apuntes;
use App\Models\Cartilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApuntesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    
        $buscar = trim($request->get('buscar'));
        $apuntes = apuntes::paginate(10);
        
        return view('apuntes.index', compact('apuntes', 'buscar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cartilla = Cartilla::all();

       /* if($cartilla->isEmpty()){
            return redirect()->route('cartilla.index')->with('error', 'No hay cartillas disponibles');
        }*/
        return view('apuntes.create', compact('cartilla'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $datos = $request->except('_token');

    Apuntes::insert($datos);

    return redirect()->route('apuntes.index')->with('mensaje', 'Apunte agregado correctamente.');
}


    /**
     * Display the specified resource.
     */
    public function show(apuntes $apuntes)
    {
        //
        $apuntes=apuntes::findOrFail($apuntes);
        return view('apuntes.show', compact('apuntes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $apunte = apuntes::findOrFail($id);
        $cartilla=cartilla::all();


        return view('apuntes.edit', compact('apunte', 'cartilla'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'concepto' => 'required|string|max:255',
            'importe' => 'required|numeric',
        ]);

        $apunte = apuntes::findOrFail($id);
        $cartilla = Cartilla::findOrFail($apunte->cartilla_id);


        // Ajustar el saldo antes de actualizar el apunte
        $cartilla->saldo -= $apunte->importe; // Resta el importe anterior
        $cartilla->saldo += $request->importe; // Suma el nuevo importe

        $apunte->update([
            'fecha' => $request->fecha,
            'concepto' => $request->concepto,
            'importe' => $request->importe,
            'cartilla_id'=>$request->cartilla_id,
        ]);

        $cartilla->save();

        return redirect()->route('apuntes.index' )->with('mensaje', 'Apunte actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $apuntes=apuntes::findOrFail($id);
        $apuntes->delete();
        return redirect()->route('apuntes.index')->with('mensaje', 'apuntes eliminada');

    }

    public function apuntescartilla($cartilla_id){
        $apuntes = DB::table('apuntes')
            ->join('cartillas', 'apuntes.cartilla_id', '=', 'cartillas.id')
            ->select('apuntes.*', 'cartilla_id')
            ->where('apuntes.cartilla_id', '=', $cartilla_id)
            ->orderBy('id')
            ->paginate(3);
        
        $apuntescartilla = true;
    
        return view('apuntes.index', compact('apuntes', 'apuntescartilla'));
    }
}




