<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'sede_id',
        'title',
        'content',
        'image_url',
        'is_published',
        'action_text',
        'action_url',
    ];

    public function sede(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }
}
