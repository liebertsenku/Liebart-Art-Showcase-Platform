<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeSubmission extends Model
{
    protected $fillable = ['challenge_id', 'artwork_id', 'user_id', 'submitted_at'];
}
