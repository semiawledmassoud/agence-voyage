<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Offre;
use App\Models\Reservation;
use App\Models\Paiement;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients'           => User::where('role', 'client')->count(),
            'total_offres'            => Offre::count(),
            'total_reservations'      => Reservation::count(),
            'reservations_attente'    => Reservation::where('statut', 'en_attente')->count(),
            'reservations_confirmees' => Reservation::where('statut', 'confirmee')->count(),
            'revenus_total'           => Paiement::where('statut', 'complete')->sum('montant'),
            'revenus_mois'            => Paiement::where('statut', 'complete')
                                            ->whereMonth('created_at', now()->month)
                                            ->sum('montant'),
        ];

        $dernieres_reservations = Reservation::with(['user', 'offre'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $offres_populaires = Offre::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get();

        $derniers_clients = User::where('role', 'client')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'dernieres_reservations',
            'offres_populaires',
            'derniers_clients'
        ));
    }
}