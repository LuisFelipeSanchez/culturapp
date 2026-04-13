<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\News;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            // Dashboard Global (Super Admin)
            $totalSedes       = Sede::count();
            $totalCourses     = Course::count();
            $totalEnrollments = Enrollment::count();
            $totalUsers       = User::count();

            $fullCourses = Course::withCount('enrollments')
                ->get()
                ->filter(fn($c) => $c->capacity > 0 && $c->enrollments_count >= $c->capacity)
                ->count();

            $pendingGrades = Enrollment::whereNull('final_grade')->count();

            $sedes = Sede::withCount(['courses', 'news'])
                ->with(['courses.enrollments'])
                ->orderBy('name')
                ->get()
                ->map(function ($sede) {
                    $sede->total_enrollments = $sede->courses->sum(fn($c) => $c->enrollments->count());
                    return $sede;
                });

            $recentEnrollments = Enrollment::with(['student', 'course.sede'])
                ->latest()
                ->limit(5)
                ->get();
        } elseif ($user->isAdmin() && $user->sede_id) {
            // Dashboard Scoped (Sede Admin)
            $sedeId = $user->sede_id;
            
            $totalSedes       = 1;
            $totalCourses     = Course::where('sede_id', $sedeId)->count();
            $totalEnrollments = Enrollment::whereHas('course', fn($q) => $q->where('sede_id', $sedeId))->count();
            $totalUsers       = User::where('sede_id', $sedeId)->count();

            $fullCourses = Course::where('sede_id', $sedeId)
                ->withCount('enrollments')
                ->get()
                ->filter(fn($c) => $c->capacity > 0 && $c->enrollments_count >= $c->capacity)
                ->count();

            $pendingGrades = Enrollment::whereHas('course', fn($q) => $q->where('sede_id', $sedeId))
                ->whereNull('final_grade')
                ->count();

            $sedes = Sede::where('id', $sedeId)
                ->withCount(['courses', 'news'])
                ->with(['courses.enrollments'])
                ->get()
                ->map(function ($sede) {
                    $sede->total_enrollments = $sede->courses->sum(fn($c) => $c->enrollments->count());
                    return $sede;
                });

            $recentEnrollments = Enrollment::whereHas('course', fn($q) => $q->where('sede_id', $sedeId))
                ->with(['student', 'course.sede'])
                ->latest()
                ->limit(5)
                ->get();
        } else {
            // Dashboard para ciudadanos (User linked to Sede or not)
            $totalSedes       = 0;
            $totalCourses     = 0;
            $totalEnrollments = $user->enrollments()->count();
            $totalUsers       = 0;
            $fullCourses      = 0;
            $pendingGrades    = 0;
            
            // Para el carousel, todos los ciudadanos ven todas las sedes
            $sedes = Sede::withCount(['courses', 'news'])
                         ->orderBy('name')
                         ->get();

            $recentEnrollments = $user->enrollments()
                ->with(['course.sede'])
                ->latest()
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact(
            'totalSedes',
            'totalCourses',
            'totalEnrollments',
            'totalUsers',
            'fullCourses',
            'pendingGrades',
            'sedes',
            'recentEnrollments'
        ));
    }
}
