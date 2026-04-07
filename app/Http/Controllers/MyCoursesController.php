<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class MyCoursesController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $myEnrollments = $user->enrollments()->with(['course.sede', 'course.category'])->latest()->get();

        $managedCourses = collect();
        $pendingEnrollments = collect();

        if ($user->managedCourses()->exists()) {
            $managedCourses = $user->managedCourses()->with(['sede', 'category'])->latest()->get();
            
            $managedCourseIds = $managedCourses->pluck('id')->toArray();
            $pendingEnrollments = Enrollment::whereIn('course_id', $managedCourseIds)
                ->where('status', 'pending')
                ->with(['student', 'course'])
                ->latest()
                ->get();
        }

        return view('my-courses.index', compact('myEnrollments', 'managedCourses', 'pendingEnrollments'));
    }

    public function manage(Course $course)
    {
        $user = auth()->user();

        if (!$user->managedCourses()->where('course_id', $course->id)->exists()) {
            abort(403, 'No estás asignado como encargado de este curso.');
        }

        $enrollments = $course->enrollments()->with('student')->latest()->get();

        return view('my-courses.manage', compact('course', 'enrollments'));
    }

    public function disableStudent(Request $request, Enrollment $enrollment)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $enrollment->course_id)->exists()) {
            abort(403);
        }

        $request->validate([
            'comment' => 'required|string|max:500'
        ]);

        $enrollment->update(['status' => 'dropped']);
        
        $enrollment->student->update([
            'is_flagged' => true,
            'flagged_reason' => $request->comment
        ]);

        return back()->with('success', 'Estudiante inhabilitado, cupo liberado y cuenta marcada preventivamente.');
    }

    public function approveStudent(Enrollment $enrollment)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $enrollment->course_id)->exists()) {
            abort(403);
        }

        $enrollment->update(['status' => 'enrolled']);

        // Le quitamos la sanción ya que un profesor le ha dado una nueva oportunidad
        $enrollment->student->update([
            'is_flagged' => false,
            'flagged_reason' => null
        ]);

        return back()->with('success', 'Inscripción aprobada exitosamente. El usuario ya no está sancionado.');
    }

    public function rejectStudent(Enrollment $enrollment)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $enrollment->course_id)->exists()) {
            abort(403);
        }

        $enrollment->update(['status' => 'dropped']);
        
        return back()->with('success', 'Inscripción rechazada y cupo liberado.');
    }

    public function restoreStudent(Enrollment $enrollment)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $enrollment->course_id)->exists()) {
            abort(403);
        }

        if ($enrollment->course->availableSpots <= 0) {
            return back()->with('error', 'No hay cupos disponibles. El restablecimiento ha fallado. Debes aumentar la capacidad del curso o liberar otro cupo antes de reintegrar a este estudiante.');
        }

        $enrollment->update(['status' => 'enrolled']);
        
        $enrollment->student->update([
            'is_flagged' => false,
            'flagged_reason' => null
        ]);

        return back()->with('success', 'Alumno reintegrado al curso. Con esto también se le ha retirado la sanción del sistema.');
    }
}
