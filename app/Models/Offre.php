<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'destination', 'pays',
        'prix', 'duree_jours', 'date_depart', 'date_retour',
        'places_totales', 'places_disponibles', 'image_principale',
        'type', 'statut', 'featured', 'prix_promo',
    ];

    protected $casts = [
        'date_depart' => 'date',
        'date_retour' => 'date',
        'featured'    => 'boolean',
        'prix'        => 'decimal:2',
        'prix_promo'  => 'decimal:2',
    ];

    public function images()
    {
        return $this->hasMany(ImageOffre::class, 'offre_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function getPrixAffichageAttribute()
    {
        return $this->prix_promo ?? $this->prix;
    }

    public function hasPlaces(): bool
    {
        return $this->places_disponibles > 0;
    }
}