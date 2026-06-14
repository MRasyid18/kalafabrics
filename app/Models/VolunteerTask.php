<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VolunteerTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'task_type',
        'scheduled_datetime',
        'location',
        'required_volunteers',
        'assigned_volunteers',
        'task_leader_name',
        'task_leader_contact',
        'hours_commitment',
        'points_reward',
        'status',
    ];

    protected $casts = [
        'scheduled_datetime' => 'datetime',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(VolunteerTaskAssignment::class);
    }
}
