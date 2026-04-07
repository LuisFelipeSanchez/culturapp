<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Activity;
use App\Models\Grade;

class SpeedGraderController extends Controller
{
    public function show(Course $course, Activity $activity)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $course->id)->exists() || $activity->course_id !== $course->id) {
            abort(403);
        }

        $enrollments = $course->enrollments()
            ->with(['student', 'grades' => function ($q) use ($activity) {
                $q->where('activity_id', $activity->id);
            }])
            ->whereIn('status', ['enrolled', 'approved'])
            ->get();
            
        $studentsData = $enrollments
            ->unique('user_id')
            ->values()
            ->map(function ($enrollment) {
                $grade = $enrollment->grades->first();
                return [
                    'enrollment_id' => $enrollment->id,
                    'user_id'       => $enrollment->user_id,
                    'student_name'  => $enrollment->student->name,
                    'student_email' => $enrollment->student->email,
                    'student_avatar'=> $enrollment->student->avatarUrl(),
                    'score'         => $grade ? floatval($grade->score) : null,
                    'feedback'      => $grade ? $grade->feedback : '',
                    'is_graded'     => (bool) $grade,
                ];
            })
            ->values()  // ensure 0-indexed after unique()
            ->toArray(); // force plain PHP array so @js() emits [...] not {...}

        return view('my-courses.speedgrader', compact('course', 'activity', 'studentsData'));
    }

    public function saveGrade(Request $request, Course $course, Activity $activity)
    {
        $user = auth()->user();
        if (!$user->managedCourses()->where('course_id', $course->id)->exists() || $activity->course_id !== $course->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'score' => 'required|numeric|min:0|max:' . $activity->max_grade,
            'feedback' => 'nullable|string'
        ]);

        $enrollment = $course->enrollments()->where('id', $validated['enrollment_id'])->firstOrFail();

        Grade::updateOrCreate(
            ['activity_id' => $activity->id, 'enrollment_id' => $enrollment->id],
            ['score' => $validated['score'], 'feedback' => $validated['feedback']]
        );

        return response()->json(['success' => true]);
    }
}
