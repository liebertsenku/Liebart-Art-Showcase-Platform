<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artwork extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category_id',
        'image',
        'tags',
    ];
    
    protected $casts = [
        'tags' => 'array',
    ];

    // Relasi ke User (Pembuat)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi Likes (Many to Many via tabel pivot 'likes')
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    // === TAMBAHKAN INI (YANG HILANG) ===
    // Relasi Favorites (Many to Many via tabel pivot 'favorites')
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
    // ===================================
    
    // Relasi Reports
    public function reports()
    {
        return $this->morphMany(ModerationReport::class, 'reportable');
    }
}