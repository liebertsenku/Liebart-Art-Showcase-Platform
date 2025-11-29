<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeSubmission extends Model
{
    protected $fillable = ['challenge_id', 'artwork_id', 'user_id', 'submitted_at'];

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Member yang submit
    }
    
    public function winner()
    {
        return $this->hasOne(ChallengeWinner::class, 'submission_id');
    }
}