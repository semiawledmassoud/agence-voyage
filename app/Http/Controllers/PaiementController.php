<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) abort(403);
        return view('client.paiements.show', compact('reservation'));
    }

    public function process(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) abort(403);

        $paiement = Paiement::create([
            'reservation_id' => $reservation->id,
            'user_id'        => Auth::id(),
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'montant'        => $reservation->prix_total,
            'methode'        => 'stripe',
            'statut'         => 'complete',
            'paid_at'        => now(),
        ]);

        $reservation->update(['statut' => 'confirmee']);

        return redirect()->route('paiement.success', $reservation)
            ->with('success', 'Paiement effectue avec succes !');
    }

    public function success(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) abort(403);
        $reservation->load(['offre', 'paiement']);
        return view('client.paiements.success', compact('reservation'));
    }

    public function historique()
    {
        $paiements = Paiement::with('reservation.offre')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('client.paiements.historique', compact('paiements'));
    }
}