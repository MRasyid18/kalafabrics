<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'b2b_profile_id',
        'leaderboard_type',
        'rank',
        'total_contribution',
        'points_earned',
        'transaction_count',
        'last_updated_at',
    ];

    protected $casts = [
        'total_contribution' => 'decimal:2',
        'last_updated_at' => 'datetime',
    ];

    public function b2bProfile(): BelongsTo
    {
        return $this->belongsTo(B2bProfile::class);
    }
}
