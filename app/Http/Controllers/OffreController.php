<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $query = Offre::active();

        if ($request->destination) {
            $query->where('destination', 'like', '%'.$request->destination.'%');
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->prix_min) {
            $query->where('prix', '>=', $request->prix_min);
        }
        if ($request->prix_max) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $offres = $query->orderBy('date_depart')->paginate(9);
        $destinations = Offre::active()->distinct()->pluck('destination');

        return view('client.offres.index', compact('offres', 'destinations'));
    }

    public function show(Offre $offre)
    {
        if ($offre->statut !== 'active') abort(404);
        $offre->load('images');
        $offres_similaires = Offre::active()
            ->where('id', '!=', $offre->id)
            ->where('type', $offre->type)
            ->take(3)->get();
        return view('client.offres.show', compact('offre', 'offres_similaires'));
    }
}