<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challenge extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'rules', 'prizes', 
        'start_date', 'end_date', 'banner_image', 'curator_id', 'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Status dinamis
    public function getComputedStatusAttribute()
    {
        if ($this->status === 'draft') return 'draft';
        $now = now();
        if ($now < $this->start_date) return 'upcoming';
        if ($now > $this->end_date) return 'ended';
        return 'active';
    }

    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function submissions()
    {
        return $this->hasMany(ChallengeSubmission::class);
    }

    public function winners()
    {
        return $this->hasMany(ChallengeWinner::class)->orderBy('position');
    }
}