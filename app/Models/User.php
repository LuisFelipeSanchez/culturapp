<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        // Campos editables por el usuario
        'phone',
        'address',
        'avatar',
        // Campos protegidos (solo editables por admin)
        'document_type',
        'document_number',
        'birth_date',
        'role',
        'sede_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date'        => 'date',
            'password'          => 'hashed',
        ];
    }

    // ──── Relaciones ────────────────────────────────────────────────────────

    public function managedSede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    // ──── Helpers de rol ────────────────────────────────────────────────────

    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isCitizen(): bool    { return $this->role === 'citizen'; }

    /** Verifica si el usuario puede gestionar una sede específica */
    public function canManageSede($sedeId): bool
    {
        if ($this->isSuperAdmin()) return true;
        if ($this->isAdmin() && $this->sede_id == $sedeId) return true;
        return false;
    }

    // ──── Helpers de perfil ─────────────────────────────────────────────────

    /** Devuelve la URL del avatar (subido) o un placeholder con la inicial */
    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3650BB&color=fff&bold=true&size=200';
    }

    /** Etiqueta legible del tipo de documento */
    public function documentTypeLabel(): string
    {
        return match($this->document_type) {
            'cc'        => 'Cédula de Ciudadanía',
            'ti'        => 'Tarjeta de Identidad',
            'pasaporte' => 'Pasaporte',
            'ce'        => 'Cédula de Extranjería',
            default     => '—',
        };
    }
}
