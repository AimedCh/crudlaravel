<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
// Orden eliminado
use App\Models\Mensaje;
use App\Models\AlquileresReserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminDashboardController extends Controller
{
    /**
     * Constructor - aplicar middleware de administrador
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Mostrar el dashboard principal del administrador
     */
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'mensajes_nuevos' => Mensaje::nuevos()->count(),
            'reservas_pendientes' => AlquileresReserva::pendientes()->count(),
            'mensajes_no_respondidos' => Mensaje::noRespondidos()->count(),
        ];

        // Órdenes recientes (eliminado)

        // Mensajes recientes
        $mensajes_recientes = Mensaje::nuevos()
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();

        // Reservas recientes
        $reservas_recientes = AlquileresReserva::with('user')
                                              ->pendientes()
                                              ->orderBy('created_at', 'desc')
                                              ->limit(5)
                                              ->get();

        return view('admin.dashboard', compact(
            'stats',
            'mensajes_recientes',
            'reservas_recientes'
        ));
    }

    // Método de órdenes eliminado

    /**
     * Mostrar gestión de mensajes
     */
    public function mensajes()
    {
        $mensajes = Mensaje::orderBy('created_at', 'desc')
                          ->paginate(15);

        return view('admin.mensajes.index', compact('mensajes'));
    }

    /**
     * Mostrar gestión de reservas de alquiler
     */
    public function reservas()
    {
        $reservas = AlquileresReserva::with('user')
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(15);

        return view('admin.reservas.index', compact('reservas'));
    }

    /**
     * Actualizar una reserva
     */
    public function updateReserva(Request $request, AlquileresReserva $reserva)
    {
        $validator = Validator::make($request->all(), [
            'nombre_cliente' => 'required|string|max:100',
            'email_cliente' => 'required|email|max:100',
            'telefono_cliente' => 'required|string|max:20',
            'tipo_equipo' => 'required|string|max:100',
            'descripcion_equipo' => 'required|string',
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'precio_dia' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,confirmado,en_uso,devuelto,cancelado',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar disponibilidad al editar (excluyendo la reserva actual)
        $hasConflict = AlquileresReserva::checkAvailability(
            $request->tipo_equipo,
            $request->fecha_entrada,
            $request->fecha_salida,
            $reserva->id
        );

        if ($hasConflict) {
            $conflictingReservations = AlquileresReserva::getConflictingReservations(
                $request->tipo_equipo,
                $request->fecha_entrada,
                $request->fecha_salida,
                $reserva->id
            );

            $errorMessage = "Lo sentimos, {$request->tipo_equipo} no está disponible para las fechas seleccionadas. ";
            if ($conflictingReservations->count() > 0) {
                $conflictingDates = $conflictingReservations->map(function ($reserva) {
                    return "del {$reserva->fecha_inicio->format('d/m/Y')} al {$reserva->fecha_fin->format('d/m/Y')}";
                })->join(', ');
                $errorMessage .= "Ya hay reservas confirmadas {$conflictingDates}.";
            }

            return redirect()->back()
                ->withErrors(['fecha_entrada' => $errorMessage])
                ->withInput();
        }

        // Calcular nuevo total si las fechas o precio cambiaron
        $fecha_entrada = Carbon::parse($request->fecha_entrada);
        $fecha_salida = Carbon::parse($request->fecha_salida);
        $dias = $fecha_entrada->diffInDays($fecha_salida) + 1;
        $total = $request->precio_dia * $dias;

        $reserva->update([
            'nombre_cliente' => $request->nombre_cliente,
            'email_cliente' => $request->email_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'tipo_equipo' => $request->tipo_equipo,
            'descripcion_equipo' => $request->descripcion_equipo,
            'fecha_inicio' => $request->fecha_entrada,
            'fecha_fin' => $request->fecha_salida,
            'precio_dia' => $request->precio_dia,
            'total' => $total,
            'estado' => $request->estado,
            'notas' => $request->notas,
        ]);

        return redirect()->route('admin.reservas')
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Eliminar una reserva
     */
    public function destroyReserva(AlquileresReserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('admin.reservas')
            ->with('success', 'Reserva eliminada exitosamente.');
    }

    /**
     * Generar PDF de la reserva
     */
    public function generatePDF(AlquileresReserva $reserva)
    {
        try {
            $data = [
                'reserva' => $reserva,
                'fecha_generacion' => Carbon::now()->format('d/m/Y H:i:s'),
                'empresa' => [
                    'nombre' => 'Location familiale Mostaganem',
                    'direccion' => 'Mostaganem Chaibia ben abdelmalek ramdane, Algeria',
                    'telefono' => '+34 604114581',
                    'email' => 'chebiliaimed9@gmail.com'
                ]
            ];

            $pdf = Pdf::loadView('admin.reservas.pdf', $data);
            
            $filename = "Reserva_{$reserva->id}_{$reserva->nombre_cliente}_" . Carbon::now()->format('Y-m-d') . ".pdf";
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('Error generando PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
