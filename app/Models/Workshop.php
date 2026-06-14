<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'learning_objectives',
        'category',
        'start_datetime',
        'end_datetime',
        'location',
        'max_participants',
        'current_participants',
        'is_online',
        'online_link',
        'facilitator_name',
        'facilitator_email',
        'points_reward',
        'active',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_online' => 'boolean',
        'active' => 'boolean',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(WorkshopRegistration::class);
    }
}
