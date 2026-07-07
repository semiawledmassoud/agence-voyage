<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageOffre extends Model
{
    protected $table = 'images_offres';

    protected $fillable = [
        'offre_id', 'image', 'legende', 'ordre',
    ];

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
}