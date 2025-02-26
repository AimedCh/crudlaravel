<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\facturas;
 use App\Models\FacturasLineas;
use Illuminate\Http\Request;

class LineasFacturasController extends Controller
{
    // Método para mostrar las líneas de una factura
    public function index($factura_id)
    {
        $factura = FacturasLineas::findOrFail($factura_id); // Encuentra la factura por ID
        $lineasfacturas = $factura->lineas; // Obtén las líneas de la factura asociada

        return view('lineasfacturas.index', compact('factura', 'lineasfacturas'));
    }

    // Método para mostrar el formulario para agregar una nueva línea
    public function create($factura_id)
    {
        $factura = facturas::findOrFail($factura_id); // Encuentra la factura por ID
        return view('lineasfacturas.create', compact('factura'));
    }

    // Método para almacenar una nueva línea de factura
    public function store(Request $request, $factura_id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0.01',
        ]);

        // Crea una nueva línea de factura
        $linea = new FacturasLineas([
            'factura_id' => $factura_id,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
        ]);
        $linea->save();

        // Redirige con un mensaje de éxito
        return redirect()->route('lineasfacturas.index', ['factura_id' => $factura_id])
                         ->with('success', 'Línea de factura creada con éxito.');
    }

    // Método para mostrar el formulario para editar una línea de factura
    public function edit($factura_id, $linea_id)
    {
        $factura = facturas::findOrFail($factura_id); // Encuentra la factura por ID
        $linea = FacturasLineas::findOrFail($linea_id); // Encuentra la línea de factura por ID

        return view('lineasfacturas.edit', compact('factura', 'linea'));
    }

    // Método para actualizar una línea de factura
    public function update(Request $request, $factura_id, $linea_id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0.01',
        ]);

        $linea = FacturasLineas::findOrFail($linea_id); // Encuentra la línea de factura por ID

        // Actualiza la línea con los nuevos valores
        $linea->descripcion = $request->descripcion;
        $linea->cantidad = $request->cantidad;
        $linea->precio = $request->precio;
        $linea->save();

        // Redirige con un mensaje de éxito
        return redirect()->route('lineasfacturas.index', ['factura_id' => $factura_id])
                         ->with('success', 'Línea de factura actualizada con éxito.');
    }

    // Método para eliminar una línea de factura
    public function destroy($factura_id, $linea_id)
    {
        $linea = FacturasLineas::findOrFail($linea_id); // Encuentra la línea de factura por ID
        $linea->delete(); // Elimina la línea de factura

        // Redirige con un mensaje de éxito
        return redirect()->route('lineasfacturas.index', ['factura_id' => $factura_id])
                         ->with('success', 'Línea de factura eliminada con éxito.');
    }
}
