<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['sede_id', 'category_id', 'title', 'description', 'capacity', 'hours', 'image', 'schedule', 'start_date', 'end_date', 'status'];

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
}