<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactos = Contacto::orderBy('created_at', 'desc')->paginate(10);
        return view('contacto.index', compact('contactos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacto.create');
    }

    /**
     * Store a newly created resource in storage.
     * Método para formularios públicos (desde frontend)
     */
    public function store(Request $request)
    {
        // Accept both Spanish and English field names from the frontend
        $data = $request->all();

        // Normalize fields to Contacto model attributes
        $normalized = [
            'name' => $data['name'] ?? $data['nombre'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? $data['telefono'] ?? null,
            'subject' => $data['subject'] ?? $data['asunto'] ?? null,
            'message' => $data['message'] ?? $data['mensaje'] ?? null,
            'service' => $data['service'] ?? 'general',
        ];

        $validator = Validator::make($normalized, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
            'service' => 'nullable|in:airpods,alquileres,taller,general',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create Contacto record (used by admin listing)
        $contacto = Contacto::create([
            'name' => $normalized['name'],
            'email' => $normalized['email'],
            'phone' => $normalized['phone'],
            'subject' => $normalized['subject'],
            'message' => $normalized['message'],
            'service' => $normalized['service'] ?? 'general',
            'status' => 'new',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado exitosamente. Te contactaremos pronto.',
                'data' => [ 'id' => $contacto->id ]
            ]);
        }

        return redirect()->back()
            ->with('success', 'Mensaje enviado exitosamente. Te contactaremos pronto.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacto $contacto)
    {
        // Mark as read if it's new
        if ($contacto->status === 'new') {
            $contacto->update(['status' => 'read']);
        }
        
        return view('contacto.show', compact('contacto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contacto $contacto)
    {
        return view('contacto.edit', compact('contacto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contacto $contacto)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
            'service' => 'required|in:airpods,alquileres,taller,general',
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Set replied_at if status is changed to replied
        if ($request->status === 'replied' && $contacto->status !== 'replied') {
            $data['replied_at'] = now();
        }

        $contacto->update($data);

        return redirect()->route('admin.contacto.index')
            ->with('success', 'Contact message updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();

        return redirect()->route('admin.contacto.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Mark contact as replied
     */
    public function markAsReplied(Contacto $contacto)
    {
        $contacto->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Contact marked as replied.');
    }

    /**
     * Mark contact as closed
     */
    public function markAsClosed(Contacto $contacto)
    {
        $contacto->update(['status' => 'closed']);

        return redirect()->back()
            ->with('success', 'Contact marked as closed.');
    }
}