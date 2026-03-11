<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $selectedSede = $request->query('sede_id');
            $sedes = Sede::orderBy('name')->get();
        } elseif ($user->isAdmin() && $user->sede_id) {
            $sedes = Sede::where('id', $user->sede_id)->get();
            $selectedSede = $user->sede_id;
        } else {
            abort(403, 'No tienes permiso para gestionar noticias.');
        }

        $news = News::with('sede')
            ->when($selectedSede, fn($q) => $q->where('sede_id', $selectedSede))
            ->latest()
            ->paginate(15);
            
        return view('admin.noticias.index', compact('news', 'sedes', 'selectedSede'));
    }

    public function create(Request $request): View
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $sedes = Sede::orderBy('name')->get();
            $selectedSede = $request->query('sede_id');
        } elseif ($user->isAdmin() && $user->sede_id) {
            $sedes = Sede::where('id', $user->sede_id)->get();
            $selectedSede = $user->sede_id;
        } else {
            abort(403, 'No tienes permiso para crear noticias.');
        }

        return view('admin.noticias.create', compact('sedes', 'selectedSede'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'sede_id' => 'nullable|exists:sedes,id',
            'is_published' => 'boolean',
            'image_url' => 'nullable|image|max:2048',
            'action_text' => 'nullable|string|max:255',
            'action_url' => 'nullable|url|max:255',
        ]);

        // Autorización
        if (!$user->canManageSede($data['sede_id'])) {
            abort(403, 'No tienes permiso para crear noticias en esta sede.');
        }

        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('news', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        News::create($data);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia creada correctamente.');
    }

    public function edit(News $news): View
    {
        $user = auth()->user();
        if (!$user->canManageSede($news->sede_id)) {
            abort(403, 'No tienes permiso para editar esta noticia.');
        }

        $sedes = Sede::orderBy('name')->get();
        return view('admin.noticias.edit', compact('news', 'sedes'));
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'sede_id' => 'nullable|exists:sedes,id',
            'is_published' => 'boolean',
            'image_url' => 'nullable|image|max:2048',
            'action_text' => 'nullable|string|max:255',
            'action_url' => 'nullable|url|max:255',
        ]);

        // Autorización
        if (!$user->canManageSede($news->sede_id) || !$user->canManageSede($data['sede_id'])) {
            abort(403, 'No tienes permiso para gestionar esta noticia.');
        }

        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('image_url')) {
            if ($news->image_url && str_starts_with($news->image_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $news->image_url));
            }
            $path = $request->file('image_url')->store('news', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $news->update($data);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->canManageSede($news->sede_id)) {
            abort(403, 'No tienes permiso para eliminar esta noticia.');
        }

        if ($news->image_url && str_starts_with($news->image_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $news->image_url));
        }
        $news->delete();
        return redirect()->route('admin.noticias.index')->with('success', 'Noticia eliminada correctamente.');
    }
}
