<?php

namespace App\Http\Controllers;

use App\Models\cartilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CartillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $buscar = trim($request->get('buscar'));

        $cartilla = cartilla::paginate(10);
        return view('cartilla.index', compact('cartilla','buscar'));

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cartilla.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos=$request->except('_token');
         
        cartilla::insert($datos);

 
        return redirect('cartilla')->with('mensaje', 'Cartilla creada.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $cartilla = Cartilla::findOrFail($id);
        return view('cartilla.show', compact('cartilla'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $cartilla=cartilla::findOrFail($id);
        return view('cartilla.edit',compact('cartilla'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
   /*$cartilla = cartilla::findOrFail($id);
    $cartilla->update($request->all());

    return redirect()->route('cartilla.index')->with('success', 'cartilla modificado con éxito');
  */

    $datos = $request->except(['_token', '_method']); 
    cartilla::where('id', '=', $id)->update($datos);
    return redirect('cartilla')->with('mensaje', 'cartilla modificada.');
        
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cartilla $cartilla)
    {
        //
        $cartilla->delete();
        return redirect()->route('cartilla.index')->with('mensaje', 'cartilla eliminada');
    }
}


 