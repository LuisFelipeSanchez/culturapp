<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['activity_id', 'enrollment_id', 'score', 'feedback'];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
