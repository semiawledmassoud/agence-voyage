<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'offre_id', 'reference', 'nombre_personnes',
        'prix_total', 'statut', 'notes', 'date_reservation',
        'nom_contact', 'email_contact', 'telephone_contact',
    ];

    protected $casts = [
        'date_reservation' => 'date',
        'prix_total'       => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public static function genererReference(): string
    {
        do {
            $ref = 'AV-' . strtoupper(uniqid());
        } while (self::where('reference', $ref)->exists());
        return $ref;
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'confirmee'  => 'Confirmee',
            'annulee'    => 'Annulee',
            'terminee'   => 'Terminee',
            default      => $this->statut,
        };
    }
}