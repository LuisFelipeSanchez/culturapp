<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Sede;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class CourseController extends Controller
{
    /**
     * Lista todos los cursos (con filtro opcional por sede).
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        if ($user->isSuperAdmin()) {
            $sedes = Sede::orderBy('name')->get();
            $selectedSede = $request->query('sede_id');
        } elseif ($user->isAdmin() && $user->sede_id) {
            $sedes = Sede::where('id', $user->sede_id)->get();
            $selectedSede = $user->sede_id;
        } else {
            abort(403, 'No tienes permiso para gestionar cursos.');
        }

        $courses = Course::with(['sede', 'category'])
            ->when($selectedSede, fn($q) => $q->where('sede_id', $selectedSede))
            ->latest()
            ->paginate(15);

        return view('admin.cursos.index', compact('courses', 'sedes', 'selectedSede'));
    }

    /**
     * Formulario de creación de un curso.
     */
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
            abort(403, 'No tienes permiso para crear cursos.');
        }

        $categories = Category::orderBy('name')->get();
        $users      = \App\Models\User::orderBy('name')->get();

        return view('admin.cursos.create', compact('sedes', 'categories', 'users', 'selectedSede'));
    }

    /**
     * Persiste el nuevo curso.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'sede_id'     => ['required', 'exists:sedes,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'capacity'    => ['required', 'integer', 'min:1', 'max:500'],
            'days'        => ['required', 'array', 'min:1'],
            'days.*'      => ['integer', 'between:1,7'],
            'start_time'  => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
            'end_time'    => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'status'      => ['required', 'in:open,in_progress,finished,cancelled'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'managers'    => ['nullable', 'array'],
            'managers.*'  => ['exists:users,id'],
        ]);

        // Autorización: un admin solo puede crear en su sede
        if (!$user->canManageSede($data['sede_id'])) {
            abort(403, 'No tienes permiso para crear cursos en esta sede.');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course = Course::create($data);

        if ($request->has('managers')) {
            $course->managers()->sync($request->input('managers'));
        }

        return redirect()
            ->route('admin.cursos.show', $course)
            ->with('success', 'Curso "' . $course->title . '" creado correctamente.');
    }

    /**
     * Detalle de un curso (con inscripciones).
     */
    public function show(Course $course): View
    {
        $user = auth()->user();
        if (!$user->canManageSede($course->sede_id)) {
            abort(403, 'No tienes permiso para ver este curso.');
        }

        $course->load(['sede', 'category', 'enrollments.student', 'enrollments.grades', 'managers', 'activities']);
        return view('admin.cursos.show', compact('course'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Course $course): View
    {
        $user = auth()->user();
        if (!$user->canManageSede($course->sede_id)) {
            abort(403, 'No tienes permiso para editar este curso.');
        }

        $sedes      = Sede::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $users      = \App\Models\User::orderBy('name')->get();

        return view('admin.cursos.edit', compact('course', 'sedes', 'categories', 'users'));
    }

    /**
     * Actualiza el curso.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'sede_id'     => ['required', 'exists:sedes,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'capacity'    => ['required', 'integer', 'min:1', 'max:500'],
            'days'        => ['required', 'array', 'min:1'],
            'days.*'      => ['integer', 'between:1,7'],
            'start_time'  => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
            'end_time'    => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'status'      => ['required', 'in:open,in_progress,finished,cancelled'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'managers'    => ['nullable', 'array'],
            'managers.*'  => ['exists:users,id'],
        ]);

        // Autorización
        if (!$user->canManageSede($course->sede_id) || !$user->canManageSede($data['sede_id'])) {
            abort(403, 'No tienes permiso para gestionar este curso.');
        }

        if ($request->hasFile('image')) {
            if ($course->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        if ($request->has('managers')) {
            $course->managers()->sync($request->input('managers'));
        } else {
            $course->managers()->detach();
        }

        return redirect()
            ->route('admin.cursos.show', $course)
            ->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Elimina el curso (solo si no tiene inscripciones).
     */
    public function destroy(Course $course): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->canManageSede($course->sede_id)) {
            abort(403, 'No tienes permiso para eliminar este curso.');
        }

        if ($course->enrollments()->exists()) {
            return back()->with('error', 'No se puede eliminar un curso con inscripciones activas.');
        }

        if ($course->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($course->image);
        }

        $title = $course->title;
        $course->delete();

        return redirect()
            ->route('admin.cursos.index')
            ->with('success', "Curso \"{$title}\" eliminado.");
    }

    /**
     * Exporta el certificado de un estudiante específico si aplica.
     */
    public function exportCertificate(Course $course, \App\Models\User $user)
    {
        $admin = auth()->user();
        if (!$admin->canManageSede($course->sede_id)) {
            abort(403, 'No tienes permiso para gestionar este curso.');
        }

        // Aumentamos el límite de memoria para DOMPDF
        ini_set('memory_limit', '512M');
        set_time_limit(120);

        $totalActivities = $course->activities()->count();

        if ($totalActivities === 0) {
            return back()->with('error', 'El curso no tiene actividades configuradas, por lo que no se pueden certificar estudiantes.');
        }

        $enrollment = $course->enrollments()
            ->with(['student', 'grades'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $gradesCount = $enrollment->grades->count();

        if ($gradesCount === 0 || $gradesCount < $totalActivities) {
            return back()->with('error', "El estudiante {$user->name} no ha completado todas las notas ({$gradesCount} de {$totalActivities}).");
        }

        $average = $enrollment->grades->avg('score');

        if ($average < 3.5) {
            return back()->with('error', "El promedio del estudiante {$user->name} es de " . number_format($average, 1) . ". Requiere al menos 3.5 para certificar.");
        }

        $enrollment->calculated_average = $average;

        $logoPath = public_path('images/sec-cultura-logo.jpg');
        $logoData = file_exists($logoPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath)) : '';

        // Necesario pasar una colección o array si la vista iteraba sobre foreach
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('pdf.certificate', [
                'course' => $course,
                'enrollments' => collect([$enrollment]),
                'logoData' => $logoData
            ])->setPaper('a4', 'landscape');

        return $pdf->download("certificado_{$user->name}_{$course->title}.pdf");
    }
}
