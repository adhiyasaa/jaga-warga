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
        'role',          // Pastikan role ada
        'gender',        // <-- TAMBAHAN BARU
        'date_of_birth', // <-- TAMBAHAN BARU
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
        ];
    }

    // =================================================================
    // RELASI UNTUK FITUR COMMUNITY (JANGAN DIHAPUS)
    // =================================================================

    /**
     * User ini punya banyak Post.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * User ini punya banyak Comment.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * User ini punya banyak Like.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    // ===============================================
    // !! FUNGSI YANG SUDAH ADA (Untuk Chat) !!
    // ===============================================

    // Relasi pesan yang dikirim
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Relasi pesan yang diterima
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // ===============================================
    // !! WAJIB ADA (Agar History Laporan Tidak Error) !!
    // ===============================================
    
    public function reports(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}