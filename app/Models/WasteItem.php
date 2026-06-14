<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'waste_donation_id',
        'item_description',
        'weight_kg',
        'condition',
        'notes',
    ];

    protected $casts = [
        'weight_kg' => 'decimal:2',
    ];

    public function wasteDonation(): BelongsTo
    {
        return $this->belongsTo(WasteDonation::class);
    }
}
