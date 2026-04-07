<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, \App\Models\Course $course)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($course->enrollments()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Ya estás inscrito en este curso.');
        }

        if ($course->availableSpots <= 0) {
            return back()->with('error', 'El curso ya no tiene cupos disponibles.');
        }

        $status = $user->is_flagged ? 'pending' : 'enrolled';
        
        $course->enrollments()->create([
            'user_id' => $user->id,
            'status' => $status
        ]);

        $message = $user->is_flagged 
            ? 'Tu inscripción está en espera de aprobación (' . $course->title . ').' 
            : 'Te has inscrito exitosamente al curso "' . $course->title . '".';

        return back()->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, \App\Models\Course $course)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        /** @var \App\Models\Enrollment|null $enrollment */
        $enrollment = $course->enrollments()->where('user_id', $user->id)->first();
        if ($enrollment) {
            $enrollment->delete();
            return back()->with('success', 'Has anulado tu inscripción al curso correctamente.');
        }

        return back()->with('error', 'No estabas inscrito en este curso.');
    }
}
