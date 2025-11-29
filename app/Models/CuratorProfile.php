<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuratorProfile extends Model
{
    protected $fillable = [
        'user_id', 'organization_name', 'organization_website', 
        'portfolio_link', 'reason_for_applying', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}