<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Activity;

class CourseActivityController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $course->id)->exists()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_grade' => 'required|numeric|min:1|max:100',
        ]);

        $course->activities()->create([
            'title' => $request->title,
            'description' => $request->description,
            'max_grade' => $request->max_grade,
        ]);

        return back()->with('success', 'Actividad académica creada exitosamente.');
    }

    public function destroy(Course $course, Activity $activity)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $course->id)->exists()) {
            abort(403);
        }

        if ($activity->course_id !== $course->id) {
            abort(404);
        }

        $activity->delete();

        return back()->with('success', 'Actividad eliminada.');
    }
}
