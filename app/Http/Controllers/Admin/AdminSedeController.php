<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sede;
use Illuminate\Http\Request;

class AdminSedeController extends Controller
{
    // Carga la vista de gestión de una sede específica
    public function manage(Sede $sede = null)
    {
        $user = auth()->user();

        // Si es super_admin, ve todas. Si es admin, solo la suya.
        if ($user->isSuperAdmin()) {
            $allSedes = Sede::orderBy('name')->get();
            if (!$sede) {
                $sede = $allSedes->first();
            }
        } elseif ($user->isAdmin() && $user->sede_id) {
            // Un admin normal solo ve su propia sede
            $allSedes = Sede::where('id', $user->sede_id)->get();
            $sede = $user->managedSede;
        } else {
            abort(403, 'No tienes permiso para gestionar sedes.');
        }

        if (!$sede) {
            abort(403, 'No tienes una sede asignada o no se encontró la sede.');
        }

        // Cargamos las relaciones que gestionaremos
        $sede->load(['courses', 'news']);

        return view('admin.sedes.manage', compact('allSedes', 'sede'));
    }

    public function edit(Sede $sede)
    {
        // Solo super_admin o el admin asignado a esta sede pueden editarla
        if (!auth()->user()->canManageSede($sede->id)) {
            abort(403, 'No tienes permiso para editar esta sede.');
        }

        return view('admin.sedes.edit', compact('sede'));
    }

    public function update(Request $request, Sede $sede)
    {
        if (!auth()->user()->canManageSede($sede->id)) {
            abort(403, 'No tienes permiso para editar esta sede.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zone' => 'required|in:urbana,rural',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'telefono' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'instagram' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('sedes', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['contact_info'] = [
            'telefono' => $request->input('telefono'),
            'whatsapp' => $request->input('whatsapp'),
            'instagram' => $request->input('instagram'),
        ];

        // Remover campos sueltos de contact info del array $validated para evitar errores si no están en fillable
        unset($validated['telefono'], $validated['whatsapp'], $validated['instagram']);

        $sede->update($validated);

        return redirect()->route('admin.manage', $sede)->with('success', 'Sede actualizada correctamente.');
    }
}
