<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['course_id', 'title', 'description', 'max_grade'];

    protected $casts = [
        'max_grade' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
