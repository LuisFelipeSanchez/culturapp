<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = [
        'sede_id', 'category_id', 'title', 'description', 
        'capacity', 'hours', 'image', 'days', 'start_time', 'end_time', 
        'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'days' => 'array',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function booted()
    {
        static::saving(function ($course) {
            if ($course->start_date && $course->end_date && $course->days && $course->start_time && $course->end_time) {
                try {
                    $start = \Carbon\Carbon::parse($course->start_date);
                    $end = \Carbon\Carbon::parse($course->end_date);
                    $startTime = \Carbon\Carbon::parse($course->start_time);
                    $endTime = \Carbon\Carbon::parse($course->end_time);
                    $hoursPerDay = $startTime->diffInMinutes($endTime) / 60;

                    $totalOccurrences = 0;
                    $current = $start->copy();
                    while ($current->lte($end)) {
                        if (in_array($current->dayOfWeekIso, $course->days)) {
                            $totalOccurrences++;
                        }
                        $current->addDay();
                    }
                    $course->hours = max(1, round($totalOccurrences * $hoursPerDay));
                } catch (\Exception $e) {
                    if (!$course->hours) $course->hours = 0;
                }
            }
        });
    }

    public function getFormattedScheduleAttribute()
    {
        if (!$this->days || empty($this->days) || !$this->start_time || !$this->end_time) {
            return 'Horario no definido';
        }

        $names = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        $dayNames = array_map(function($day) use ($names) {
            return $names[$day] ?? '';
        }, $this->days);

        $daysStr = implode(', ', array_filter($dayNames));
        
        $startStr = \Carbon\Carbon::parse($this->start_time)->format('h:i A');
        $endStr = \Carbon\Carbon::parse($this->end_time)->format('h:i A');

        return "{$daysStr} ({$startStr} - {$endStr})";
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function getAvailableSpotsAttribute(): int
    {
        $enrolledCount = $this->enrollments()->whereIn('status', ['enrolled', 'pending', 'approved'])->count();
        return max(0, $this->capacity - $enrolledCount);
    }
}