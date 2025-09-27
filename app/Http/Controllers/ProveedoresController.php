<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProveedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));
        $proveedores = Proveedores::when($buscar, function($query, $buscar) {
            return $query->where('nombre', 'LIKE', '%' . $buscar . '%')
                        ->orWhere('email', 'LIKE', '%' . $buscar . '%');
        })->orderBy('nombre', 'asc')->paginate(10);
        
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
        $request->validate([
            'nombre' => 'required|string|max:64',
            'email' => 'required|email|max:100|unique:proveedores,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
        ]);

        Proveedores::create($request->all());

        return redirect()->route('admin.proveedores.index')
                        ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedores $proveedore)
    {
        return view('proveedores.show', compact('proveedore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedores $proveedore)
    {
        return view('proveedores.edit', compact('proveedore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedores $proveedore)
    {
        $request->validate([
            'nombre' => 'required|string|max:64',
            'email' => 'required|email|max:100|unique:proveedores,email,' . $proveedore->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
        ]);

        $proveedore->update($request->all());

        return redirect()->route('admin.proveedores.index')
                        ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedores $proveedore)
    {
        $proveedore->delete();
        return redirect()->route('admin.proveedores.index')
                        ->with('success', 'Proveedor eliminado exitosamente.');
    }
}
