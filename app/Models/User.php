<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Exceptions\InvalidRoleException;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected const VALID_ROLES = ['admin', 'b2c', 'b2b', 'ranger', 'pengguna'];

    protected static function boot()
    {
        parent::boot();

        // Validate role before saving
        static::creating(function ($model) {
            if (!in_array($model->role, self::VALID_ROLES)) {
                throw new InvalidRoleException(
                    "Role '{$model->role}' tidak valid. Role yang diizinkan: " . implode(', ', self::VALID_ROLES)
                );
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('role') && !in_array($model->role, self::VALID_ROLES)) {
                throw new InvalidRoleException(
                    "Role '{$model->role}' tidak valid. Role yang diizinkan: " . implode(', ', self::VALID_ROLES)
                );
            }
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /* ─── Relationships ─── */
    public function b2bProfile(): HasOne
    {
        return $this->hasOne(B2bProfile::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function wasteDonations(): HasMany
    {
        return $this->hasMany(WasteDonation::class);
    }

    public function b2bOrders(): HasMany
    {
        return $this->hasMany(B2bOrder::class);
    }

    public function userPoints(): HasOne
    {
        return $this->hasOne(UserPoint::class);
    }

    public function workshopRegistrations(): HasMany
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    public function volunteerTasks(): HasMany
    {
        return $this->hasMany(VolunteerTaskAssignment::class);
    }

    /* ─── Helper methods ─── */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isB2c(): bool
    {
        return $this->role === 'b2c';
    }

    public function isB2b(): bool
    {
        return $this->role === 'b2b';
    }

    public function isRanger(): bool
    {
        return $this->role === 'ranger';
    }

    public function roleBadge(): string
    {
        return match($this->role) {
            'admin'    => 'Admin',
            'b2b'      => 'Partner B2B',
            'b2c'      => 'Member',
            'ranger'   => 'Ranger',
            default    => 'Member',
        };
    }
}
