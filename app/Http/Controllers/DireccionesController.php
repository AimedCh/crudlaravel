<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\direcciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DireccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $direcciones=direcciones::all();
        $direcciones = direcciones::paginate(10);
        return view('direcciones.index', compact('direcciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Clientes::all(); 

        return view('direcciones.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos=$request->except('_token');

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:15',
        ]);

        direcciones::create($request->all());
        direcciones::insert($datos);


        return redirect()->route('direcciones.index')->with('mensaje', 'Dirección creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(direcciones $direccion)
    {
        return view('direcciones.show', compact('direccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $direccion=direcciones::findorfail($id);
        $clientes=clientes::all();

        dd($clientes);

        return view('direcciones.edit', compact('direccion','clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'direccion' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'required|string|max:11',
        ]);
    
        // Buscar la dirección y actualizar
        $direccion = direcciones::findOrFail($id);
        $direccion->update($request->all());
    
        // Redirigir con mensaje
        return redirect()->route('direcciones.index')->with('mensaje', 'Dirección actualizada correctamente.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(direcciones $direccion)

    {
 
        $direccion->delete();
        return redirect()->route('direcciones.index')->with('mensaje', 'Direccion eliminada');
    }

    public function direccionescliente($cliente_id){
             $direcciones = DB::table('direcciones')
                ->join('clientes', 'direcciones.cartilla_id', '=', 'clientes.id')
                ->select('direcciones.*', 'cliente_id')
                ->where('direcciones.cliente_id', '=', $cliente_id)
                ->orderBy('id')
                ->paginate(3);
            
            $direccionescliente = true;
        
            return view('apuntes.index', compact('direcciones', 'direccionescliente'));
         
    }
}
