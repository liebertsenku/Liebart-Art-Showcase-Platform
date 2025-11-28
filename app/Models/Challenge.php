<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challenge extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'cover_image', 
        'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Helper untuk status dinamis (Opsional, jika tidak ingin rely di DB column saja)
    public function getComputedStatusAttribute()
    {
        $now = Carbon::now();
        if ($now < $this->start_date) return 'upcoming';
        if ($now > $this->end_date) return 'ended';
        return 'ongoing';
    }

    public function submissions()
    {
        return $this->hasMany(ChallengeSubmission::class);
    }
}