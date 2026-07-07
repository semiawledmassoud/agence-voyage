<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paiement;

class PaiementAdminController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with(['user', 'reservation.offre'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.paiements.index', compact('paiements'));
    }
}