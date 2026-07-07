<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Media;

class HomeController extends Controller
{
    public function index()
    {
        $offres_featured = Offre::active()->featured()->take(6)->get();
        $offres          = Offre::active()->orderBy('date_depart')->paginate(9);
        $slides          = Media::where('type', 'slide')->where('actif', true)->orderBy('ordre')->get();
        $videos          = Media::where('type', 'video')->where('actif', true)->orderBy('ordre')->get();

        return view('client.home', compact('offres_featured', 'offres', 'slides', 'videos'));
    }
}