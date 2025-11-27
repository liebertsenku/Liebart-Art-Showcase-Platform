<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Artwork;

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
        'status',
        'profile_photo_path',
        'bio',
        'external_links',
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
            'external_links' => 'array', // Otomatis cast JSON ke array
        ];
    }
    
    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }

    // === HELPER UNTUK ROLE ===
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCurator(): bool
    {
        return $this->role === 'curator';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function isApproved(): bool
    {
        return $this->status === 'active';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function likes() { return $this->belongsToMany(Artwork::class, 'likes'); }
    public function favorites() { return $this->belongsToMany(Artwork::class, 'favorites'); }
    // Helper untuk cek status
    public function hasLiked(Artwork $artwork) { return $this->likes()->where('artwork_id', $artwork->id)->exists(); }
    public function hasFavorited(Artwork $artwork) { return $this->favorites()->where('artwork_id', $artwork->id)->exists(); }
}
