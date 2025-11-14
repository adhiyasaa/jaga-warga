<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',

        // Kolom dari Form Langkah 1
        'first_name',
        'last_name',
        'place_of_birth',
        'date_of_birth',
        'home_address',
        'email',
        'phone_number',

        // Kolom dari Form Langkah 2
        'incident_type',
        'incident_date',
        'incident_time',
        'incident_location',
        'description',
        'evidence_file_path',
        'is_anonymous',
        
    ];

    /**
     * Relasi ke User model
     * Sebuah Report dimiliki oleh satu User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}