<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerTaskAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'volunteer_task_id',
        'status',
        'completed_at',
        'completion_notes',
        'actual_hours',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(VolunteerTask::class, 'volunteer_task_id');
    }
}
