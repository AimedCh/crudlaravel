<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
        //
        public function index(Request $request)
{
    $buscar = trim($request->get('buscar'));
    $proveedores = DB::table('proveedores')
        ->select('*')
        ->where('nombre', 'LIKE', '%' . $buscar . '%')
        ->orWhere('email', 'LIKE', '%' . $buscar . '%')
        ->orderBy('nombre', 'asc')
        ->paginate(1);
        
    return view('proveedores.index', compact('proveedores', 'buscar'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('proveedores.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos=$request->except('_token');

        $campos = [
            'nombre' => 'required| string | max:64' ,
            'email' => 'required | email |max:100 '];
            
            //'logo' => 'required| max: 5000000| mimes : jpg, jpeg, png'];
            $mensajes = [
            'required' => 'El :attribute es requerido. ',
        ];

            $this->validate($request, $campos, $mensajes);

            //$datos = $request->all();

            Proveedores::insert($datos);

        return redirect('proveedores')->with('mensaje','Clientes insertado.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $proveedores=Proveedores::findOrFail($id);
        return view('proveedores.show', compact('proveedores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //
        $proveedores=Proveedores::findOrFail($id);
        return view('proveedores.edit',compact('proveedores'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        $datos = $request->except(['_token', '_method']); 
        Proveedores::where('id', '=', $id)->update($datos);
    
        return redirect('proveedores')->with('mensaje', 'Proveedores modificado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        $datos = Proveedores :: findOrFail($id);
        
        
        Proveedores:: destroy($id);

        
        return redirect('proveedores')->with('mensaje','Proveedores borrado.');
    }
}
