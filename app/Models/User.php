<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'date_of_birth',
        'phone_number',
        'is_available',
        'avatar_url',  
        'experience',  
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_available' => 'boolean', // Casting agar otomatis jadi true/false
        ];
    }

    // =================================================================
    // RELATIONS FOR COMMUNITY FEATURE
    // =================================================================

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    // ===============================================
    // RELATIONS FOR CHAT & CONSULTATION (UPDATED)
    // ===============================================

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Relasi Konsultasi sebagai PASIEN.
     * Mengambil daftar konsultasi milik user ini.
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'user_id');
    }

    /**
     * Relasi Konsultasi sebagai PSIKOLOG.
     * Mengambil daftar pasien yang ditangani psikolog ini.
     */
    public function doctorConsultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'psychologist_id');
    }

    // ===============================================
    // RELATION FOR REPORTS
    // ===============================================
    
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}