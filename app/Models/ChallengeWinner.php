<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeWinner extends Model
{
    protected $fillable = ['challenge_id', 'submission_id', 'position'];

    public function submission()
    {
        return $this->belongsTo(ChallengeSubmission::class);
    }
}