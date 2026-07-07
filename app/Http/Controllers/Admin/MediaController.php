<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $slides = Media::where('type', 'slide')->orderBy('ordre')->get();
        $videos = Media::where('type', 'video')->orderBy('ordre')->get();
        return view('admin.medias.index', compact('slides', 'videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:slide,video',
            'fichier'     => 'required|file|max:51200',
            'lien'        => 'nullable|string',
        ]);

        $path = $request->file('fichier')->store('medias', 'public');

        Media::create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'type'        => $request->type,
            'fichier'     => $path,
            'lien'        => $request->lien,
            'actif'       => $request->has('actif'),
            'ordre'       => Media::where('type', $request->type)->count(),
        ]);

        return back()->with('success', 'Media ajouté avec succès !');
    }

    public function destroy(Media $media)
    {
        Storage::disk('public')->delete($media->fichier);
        $media->delete();
        return back()->with('success', 'Media supprimé !');
    }

    public function toggle(Media $media)
    {
        $media->update(['actif' => !$media->actif]);
        return back()->with('success', 'Statut modifié !');
    }
}