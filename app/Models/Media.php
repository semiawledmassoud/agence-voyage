<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'fichier',
        'type',
        'lien',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}