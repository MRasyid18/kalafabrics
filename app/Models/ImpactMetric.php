<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpactMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_waste_collected_kg',
        'total_carbon_saved_kg',
        'water_saved_liters',
        'total_products_sold',
        'total_users',
        'total_b2b_partners',
        'active_volunteers',
        'total_workshops_completed',
        'total_workshop_participants',
        'total_donation_value',
        'last_updated_at',
    ];

    protected $casts = [
        'total_waste_collected_kg' => 'decimal:2',
        'total_carbon_saved_kg' => 'decimal:2',
        'water_saved_liters' => 'decimal:2',
        'total_donation_value' => 'decimal:2',
        'last_updated_at' => 'datetime',
    ];
}
