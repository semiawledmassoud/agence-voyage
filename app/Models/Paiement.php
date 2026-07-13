<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'reservation_id',
        'user_id',
        'montant',
        'methode',
        'statut',
        'transaction_id',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'montant' => 'decimal:2',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}