<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModerationReport extends Model
{
    protected $fillable = ['reporter_id', 'artwork_id', 'reason', 'status'];
}
