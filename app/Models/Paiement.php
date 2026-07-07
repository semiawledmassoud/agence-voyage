<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 'user_id', 'transaction_id',
        'montant', 'devise', 'methode', 'statut', 'details', 'paid_at',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'paid_at' => 'datetime',
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