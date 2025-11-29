<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModerationReport extends Model
{
    protected $fillable = ['reporter_id', 'artwork_id', 'reason', 'status'];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**c
     * Relasi ke Artwork yang dilaporkan.
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class)->withTrashed(); 
        // withTrashed() penting agar laporan tetap bisa dilihat meski artwork sudah di-soft-delete admin
    }
}
