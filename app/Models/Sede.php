<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sede extends Model
{
    protected $fillable = ['name', 'address', 'zone', 'description', 'latitude', 'longitude', 'image_url', 'contact_info'];

    protected $casts = [
        'contact_info' => 'array', // Automatically handle JSON
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function admins(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'admin');
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
