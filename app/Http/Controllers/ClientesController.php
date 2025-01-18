<?php
namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $buscar = trim($request->get('buscar'));
        $clientes = DB::table('clientes')
        ->select('*')
        ->where('nombre', 'LIKE', '%' . $buscar . '%')
        ->orWhere('email', 'LIKE', '%' . $buscar . '%')
        ->orderBy('nombre', 'asc')
        ->paginate(2);
        
        return view('clientes.index', compact('clientes', 'buscar'));

        //$datos['clientes']=Clientes::paginate(1);
       // return view('clientes.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
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
            'direccion' => 'required| string |max:64',
            'email' => 'required | email |max:100',
            'telefono' => 'required | max :11',
            'logo' => 'required| max: 50000| mimes : jpg, jpeg, png'];
            $mensajes = [
            'required' => 'El :attribute es requerido. ',
            'direccion.required' => 'La :attribute es requerida. '
        ];

            $this->validate($request, $campos, $mensajes);

            //$datos = $request->all();

            Clientes::insert($datos);

        return redirect('clientes')->with('mensaje','Clientes insertado.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $cliente=Clientes::findOrFail($id);
        return view('clientes.show', compact('cliente'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $cliente=Clientes::findOrFail($id);
        return view('clientes.edit',compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        
        $campos = [
            'nombre' => 'required| string | max:64',
            'direccion' => 'required| string|max:64',
            'email' => 'required|email | max :100',
            'telefono' => 'required |max: 11',
        ];
            $mensajes = [
            'required' => 'El :attribute es requerido.',
            'direccion.required' => 'La :attribute es requerida.'
        ];
            
            if ($request->hasFile('logo'))
            {
                $campos = ['logo' => 'required|max: 50000|mimes: jpg,jpeg,png'];
                $mensaje = ['logo.required' => 'El logo es requerido.'];
            }
            
            $this->validate($request, $campos, $mensajes);

        $datos = $request->except(['_token', '_method']);
        $logo = Clientes::findOrFail($id);
    
        if ($logo->logo) {
            Storage::delete('public/' . $logo->logo);
        }
    
        if ($request->hasFile('logo')) {
            $datos['logo'] = $request->file('logo')->store('uploads', 'public');
        }
    
        Clientes::where('id', '=', $id)->update($datos);
    
        return redirect('clientes')->with('mensaje', 'Cliente modificado.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $datos = Clientes :: findOrFail($id);
        if ($datos->logo != '')
            Storage::delete('public/' . $datos->logo);
        
        Clientes:: destroy($id);

        return redirect('clientes')->with('mensaje','Clientes borrado.');
    }
}