<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);

        $query = User::query()
            ->withCount('enrollments')
            ->with('managedSede');

        // Filtro búsqueda libre (nombre, email, documento)
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%");
            });
        }

        // Filtro por rol
        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        // Filtro por tipo de documento
        if ($docType = $request->get('document_type')) {
            $query->where('document_type', $docType);
        }

        // Filtro por estado de sanción
        if ($request->get('flagged') === '1') {
            $query->where('is_flagged', true);
        } elseif ($request->get('flagged') === '0') {
            $query->where('is_flagged', false);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        // Calcular promedio general por usuario (sobre escala de 5.0)
        $userAverages = DB::table('grades')
            ->join('enrollments', 'grades.enrollment_id', '=', 'enrollments.id')
            ->join('activities', 'grades.activity_id', '=', 'activities.id')
            ->select('enrollments.user_id', DB::raw('AVG((grades.score / activities.max_grade) * 5) as avg_score'))
            ->groupBy('enrollments.user_id')
            ->pluck('avg_score', 'user_id');

        return view('admin.users.index', compact('users', 'userAverages'));
    }
}
