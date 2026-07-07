<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['offre', 'paiement'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.reservations.index', compact('reservations'));
    }

    public function create(Offre $offre)
    {
        if ($offre->statut !== 'active') {
            return redirect()->route('offres.index')
                ->with('error', 'Cette offre n\'est plus disponible.');
        }

        if (!$offre->hasPlaces()) {
            return redirect()->route('offres.show', $offre)
                ->with('error', 'Plus de places disponibles pour cette offre.');
        }

        return view('client.reservations.create', compact('offre'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'offre_id'          => 'required|exists:offres,id',
            'nombre_personnes'  => 'required|integer|min:1|max:20',
            'nom_contact'       => 'required|string|max:255',
            'email_contact'     => 'required|email|max:255',
            'telephone_contact' => 'required|string|max:20',
            'notes'             => 'nullable|string|max:500',
        ]);

        $offre = Offre::findOrFail($request->offre_id);

        if ($offre->places_disponibles < $request->nombre_personnes) {
            return back()->with('error', 'Pas assez de places disponibles. Seulement ' . $offre->places_disponibles . ' place(s) restante(s).');
        }

        $prixTotal = $offre->prix_affichage * $request->nombre_personnes;

        $reservation = Reservation::create([
            'user_id'           => Auth::id(),
            'offre_id'          => $offre->id,
            'reference'         => Reservation::genererReference(),
            'nombre_personnes'  => $request->nombre_personnes,
            'prix_total'        => $prixTotal,
            'statut'            => 'en_attente',
            'date_reservation'  => now()->toDateString(),
            'nom_contact'       => $request->nom_contact,
            'email_contact'     => $request->email_contact,
            'telephone_contact' => $request->telephone_contact,
            'notes'             => $request->notes,
        ]);

        $offre->decrement('places_disponibles', $request->nombre_personnes);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', '✅ Réservation effectuée ! Référence : ' . $reservation->reference);
    }

    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $reservation->load(['offre', 'paiement']);

        return view('client.reservations.show', compact('reservation'));
    }

    public function annuler(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        if ($reservation->statut === 'confirmee') {
            return back()->with('error', 'Impossible d\'annuler une réservation déjà confirmée. Contactez-nous.');
        }

        if ($reservation->statut === 'annulee') {
            return back()->with('error', 'Cette réservation est déjà annulée.');
        }

        $reservation->update(['statut' => 'annulee']);
        $reservation->offre->increment('places_disponibles', $reservation->nombre_personnes);

        return back()->with('success', 'Réservation annulée avec succès.');
    }
}