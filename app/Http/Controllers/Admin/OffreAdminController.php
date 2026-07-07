<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OffreAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Offre::withCount('reservations');

        if ($request->search) {
            $query->where('titre', 'like', '%'.$request->search.'%')
                  ->orWhere('destination', 'like', '%'.$request->search.'%');
        }

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $offres = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.offres.index', compact('offres'));
    }

    public function create()
    {
        return view('admin.offres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'          => 'required|string|max:255',
            'description'    => 'required|string',
            'destination'    => 'required|string|max:255',
            'pays'           => 'required|string|max:255',
            'prix'           => 'required|numeric|min:0',
            'duree_jours'    => 'required|integer|min:1',
            'date_depart'    => 'required|date',
            'date_retour'    => 'required|date|after:date_depart',
            'places_totales' => 'required|integer|min:1',
            'type'           => 'required|in:voyage,circuit,sejour,aventure',
            'image_principale' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_principale')) {
            $imagePath = $request->file('image_principale')->store('offres', 'public');
        }

        $offre = Offre::create([
            'titre'              => $request->titre,
            'description'        => $request->description,
            'destination'        => $request->destination,
            'pays'               => $request->pays,
            'prix'               => $request->prix,
            'duree_jours'        => $request->duree_jours,
            'date_depart'        => $request->date_depart,
            'date_retour'        => $request->date_retour,
            'places_totales'     => $request->places_totales,
            'places_disponibles' => $request->places_totales,
            'type'               => $request->type,
            'statut'             => $request->statut ?? 'active',
            'featured'           => $request->has('featured'),
            'prix_promo'         => $request->prix_promo,
            'image_principale'   => $imagePath,
        ]);

        return redirect()->route('admin.offres.index')
            ->with('success', 'Offre creee avec succes !');
    }

    public function show(Offre $offre)
    {
        $offre->load('images', 'reservations.user');
        return view('admin.offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        $offre->load('images');
        return view('admin.offres.edit', compact('offre'));
    }

    public function update(Request $request, Offre $offre)
    {
        $request->validate([
            'titre'          => 'required|string|max:255',
            'description'    => 'required|string',
            'destination'    => 'required|string|max:255',
            'pays'           => 'required|string|max:255',
            'prix'           => 'required|numeric|min:0',
            'duree_jours'    => 'required|integer|min:1',
            'date_depart'    => 'required|date',
            'date_retour'    => 'required|date|after:date_depart',
            'places_totales' => 'required|integer|min:1',
            'type'           => 'required|in:voyage,circuit,sejour,aventure',
        ]);

        $imagePath = $offre->image_principale;
        if ($request->hasFile('image_principale')) {
            if ($offre->image_principale) {
                Storage::disk('public')->delete($offre->image_principale);
            }
            $imagePath = $request->file('image_principale')->store('offres', 'public');
        }

        $offre->update([
            'titre'            => $request->titre,
            'description'      => $request->description,
            'destination'      => $request->destination,
            'pays'             => $request->pays,
            'prix'             => $request->prix,
            'duree_jours'      => $request->duree_jours,
            'date_depart'      => $request->date_depart,
            'date_retour'      => $request->date_retour,
            'places_totales'   => $request->places_totales,
            'type'             => $request->type,
            'statut'           => $request->statut,
            'featured'         => $request->has('featured'),
            'prix_promo'       => $request->prix_promo,
            'image_principale' => $imagePath,
        ]);

        return redirect()->route('admin.offres.index')
            ->with('success', 'Offre mise a jour !');
    }

    public function destroy(Offre $offre)
    {
        if ($offre->image_principale) {
            Storage::disk('public')->delete($offre->image_principale);
        }
        $offre->delete();
        return redirect()->route('admin.offres.index')
            ->with('success', 'Offre supprimee !');
    }

    public function toggle(Offre $offre)
    {
        $offre->update([
            'statut' => $offre->statut === 'active' ? 'inactive' : 'active'
        ]);
        return back()->with('success', 'Statut modifie !');
    }
}