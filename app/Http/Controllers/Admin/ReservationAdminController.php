<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class ReservationAdminController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'offre'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'offre', 'paiement']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function confirmer(Reservation $reservation)
    {
        $reservation->update(['statut' => 'confirmee']);
        return back()->with('success', 'Reservation confirmee !');
    }

    public function annuler(Reservation $reservation)
    {
        $reservation->update(['statut' => 'annulee']);
        $reservation->offre->increment('places_disponibles', $reservation->nombre_personnes);
        return back()->with('success', 'Reservation annulee !');
    }
}