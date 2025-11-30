<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModerationReport extends Model
{
    protected $fillable = ['reporter_id', 'reportable_id', 'reportable_type', 'reason', 'status'];

    public function reportable()
    {
        return $this->morphTo();
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
