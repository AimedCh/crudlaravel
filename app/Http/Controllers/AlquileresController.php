<?php

namespace App\Http\Controllers;

use App\Models\Alquileres;
use App\Models\AlquileresReserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AlquileresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alquileres = Alquileres::orderBy('created_at', 'desc')->paginate(10);
        return view('alquileres.index', compact('alquileres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alquileres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'price_per_night' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'amenities' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'distance_to_beach' => 'nullable|numeric|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean',
            'available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('alquileres', 'public');
            $data['image'] = $imagePath;
        }

        // Convert amenities array to JSON
        if ($request->has('amenities')) {
            $data['amenities'] = json_encode($request->amenities);
        }

        $data['is_active'] = $request->has('is_active');
        $data['available'] = $request->has('available');

        Alquileres::create($data);

        return redirect()->route('alquileres.index')
            ->with('success', 'Alquiler created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alquileres $alquileres)
    {
        return view('alquileres.show', compact('alquileres'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alquileres $alquileres)
    {
        return view('alquileres.edit', compact('alquileres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alquileres $alquileres)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'price_per_night' => 'required|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'amenities' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'distance_to_beach' => 'nullable|numeric|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean',
            'available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($alquileres->image && Storage::disk('public')->exists($alquileres->image)) {
                Storage::disk('public')->delete($alquileres->image);
            }
            
            $imagePath = $request->file('image')->store('alquileres', 'public');
            $data['image'] = $imagePath;
        }

        // Convert amenities array to JSON
        if ($request->has('amenities')) {
            $data['amenities'] = json_encode($request->amenities);
        }

        $data['is_active'] = $request->has('is_active');
        $data['available'] = $request->has('available');

        $alquileres->update($data);

        return redirect()->route('alquileres.index')
            ->with('success', 'Alquiler updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alquileres $alquileres)
    {
        // Delete image if exists
        if ($alquileres->image && Storage::disk('public')->exists($alquileres->image)) {
            Storage::disk('public')->delete($alquileres->image);
        }

        $alquileres->delete();

        return redirect()->route('alquileres.index')
            ->with('success', 'Alquiler deleted successfully.');
    }

    /**
     * Crear una reserva de alquiler (desde formulario público)
     */
    public function reserve(Request $request)
    {
        // DEBUG: Log de datos recibidos
        \Log::alert('=== RESERVA DE ALQUILER RECIBIDA ===');
        \Log::alert('Datos de reserva recibidos: ' . json_encode($request->all()));
        \Log::alert('Headers: ' . json_encode($request->headers->all()));
        \Log::alert('Método: ' . $request->method());
        \Log::alert('URL: ' . $request->fullUrl());
        
        $validator = Validator::make($request->all(), [
            'nombre_cliente' => 'required|string|max:100',
            'email_cliente' => 'required|email|max:100',
            'telefono_cliente' => 'required|string|max:20',
            'tipo_equipo' => 'required|string|max:100',
            'descripcion_equipo' => 'required|string',
            'fecha_entrada' => 'required|date|after_or_equal:today',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'precio_dia' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            // DEBUG: Log de errores de validación
            \Log::alert('Errores de validación: ' . json_encode($validator->errors()));
            
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar disponibilidad antes de crear la reserva
        $hasConflict = AlquileresReserva::checkAvailability(
            $request->tipo_equipo,
            $request->fecha_entrada,
            $request->fecha_salida
        );

        if ($hasConflict) {
            // Obtener las reservas que causan conflicto para mostrar información detallada
            $conflictingReservations = AlquileresReserva::getConflictingReservations(
                $request->tipo_equipo,
                $request->fecha_entrada,
                $request->fecha_salida
            );

            $errorMessage = "Lo sentimos, {$request->tipo_equipo} no está disponible para las fechas seleccionadas. ";
            if ($conflictingReservations->count() > 0) {
                $conflictingDates = $conflictingReservations->map(function ($reserva) {
                    return "del {$reserva->fecha_entrada->format('d/m/Y')} al {$reserva->fecha_salida->format('d/m/Y')}";
                })->join(', ');
                $errorMessage .= "Ya hay reservas confirmadas {$conflictingDates}.";
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'availability_conflict',
                    'message' => $errorMessage,
                    'conflicting_dates' => $conflictingReservations->map(function ($reserva) {
                        return [
                            'fecha_entrada' => $reserva->fecha_entrada->format('Y-m-d'),
                            'fecha_salida' => $reserva->fecha_salida->format('Y-m-d'),
                            'estado' => $reserva->estado
                        ];
                    })
                ], 409); // 409 Conflict
            }

            return redirect()->back()
                ->withErrors(['fecha_entrada' => $errorMessage])
                ->withInput();
        }

        // Calcular días y total
        $fecha_entrada = Carbon::parse($request->fecha_entrada);
        $fecha_salida = Carbon::parse($request->fecha_salida);
        $dias = $fecha_entrada->diffInDays($fecha_salida) + 1; // +1 para incluir el día de entrada
        $total = $request->precio_dia * $dias;

        // Crear la reserva (SIN PAGO - Solo reserva pura)
        $reserva = AlquileresReserva::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'nombre_cliente' => $request->nombre_cliente,
            'email_cliente' => $request->email_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'tipo_equipo' => $request->tipo_equipo,
            'descripcion_equipo' => $request->descripcion_equipo,
            'fecha_inicio' => $request->fecha_entrada, // Usar fecha_inicio en lugar de fecha_entrada
            'fecha_fin' => $request->fecha_salida, // Usar fecha_fin en lugar de fecha_salida
            'precio_dia' => $request->precio_dia,
            'total' => $total,
            'estado' => 'pendiente', // Estado inicial: pendiente de confirmación
        ]);

        // DEBUG: Log de reserva creada
        \Log::alert('Reserva creada exitosamente: ' . json_encode($reserva->toArray()));
        \Log::alert('ID de reserva: ' . $reserva->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Reserva creada exitosamente. Te contactaremos para confirmar los detalles y coordinar el pago.',
                'reserva_id' => $reserva->id,
                'total' => $total,
                'estado' => 'pendiente'
            ]);
        }

        return redirect()->back()
            ->with('success', 'Reserva creada exitosamente. Te contactaremos para confirmar los detalles y coordinar el pago. Total: €' . number_format($total, 2));
    }

    /**
     * API: Obtener lista de apartamentos para el frontend
     */
    public function apiIndex()
    {
        // Como la tabla alquileres fue eliminada, devolvemos datos de ejemplo
        // para que el frontend funcione correctamente
        $apartamentos = [
            [
                'id' => 1,
                'title' => 'Apartamento Deluxe Vista al Mar',
                'description' => 'Hermoso apartamento con vista panorámica al mar, completamente equipado.',
                'price_per_night' => 150.00,
                'max_guests' => 4,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'image' => '/images/apartment1.jpg',
                'amenities' => ['WiFi', 'Aire Acondicionado', 'Cocina', 'Balcón'],
                'city' => 'Valencia',
                'address' => 'Calle del Mar 123'
            ],
            [
                'id' => 2,
                'title' => 'Estudio Moderno Centro Ciudad',
                'description' => 'Estudio moderno en el centro de la ciudad, ideal para parejas.',
                'price_per_night' => 80.00,
                'max_guests' => 2,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'image' => '/images/apartment2.jpg',
                'amenities' => ['WiFi', 'Calefacción', 'Cocina'],
                'city' => 'Madrid',
                'address' => 'Gran Vía 456'
            ],
            [
                'id' => 3,
                'title' => 'Casa Rural con Jardín',
                'description' => 'Casa rural tranquila con jardín privado, perfecta para familias.',
                'price_per_night' => 120.00,
                'max_guests' => 6,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'image' => '/images/apartment3.jpg',
                'amenities' => ['WiFi', 'Jardín', 'Barbacoa', 'Parking'],
                'city' => 'Sevilla',
                'address' => 'Camino Rural 789'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $apartamentos
        ]);
    }

    /**
     * API: Obtener reservas del usuario autenticado
     */
    public function userReservations()
    {
        $reservas = AlquileresReserva::where('user_id', Auth::id())
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return response()->json([
            'success' => true,
            'data' => $reservas
        ]);
    }
}