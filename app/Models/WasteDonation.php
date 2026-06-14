<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WasteDonation extends Model
{
    use HasFactory;

    protected $fillable = [
        // Relasi & Identitas
        'user_id',
        'donation_number',
        'status',
        
        // Data dari Formulir Pengajuan Baru
        'waste_type',
        'weight',
        'condition',
        'delivery_method',
        'photo_path',
        'pickup_date',
        'address',
        'notes',
        
        // Data Pelacakan & Kalkulasi (Advanced Tracking)
        'total_weight_kg',
        'points_awarded',
        'donation_address',
        'city',
        'postal_code',
        'contact_person_name',
        'contact_person_phone',
        'scheduled_pickup_date',
        
        // Data Timestamp Proses Administrasi
        'picked_up_at',
        'received_at',
        'verified_at',
        'verification_notes',
        'admin_verified_by',
    ];

    protected $casts = [
        'total_weight_kg'       => 'decimal:2',
        'weight'                => 'decimal:2', // Tambahan cast untuk input form
        'pickup_date'           => 'date',      // Tambahan cast untuk input form
        'scheduled_pickup_date' => 'datetime',
        'picked_up_at'          => 'datetime',
        'received_at'           => 'datetime',
        'verified_at'           => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(WasteItem::class);
    }
}