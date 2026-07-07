<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UtilisateurController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'client')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.utilisateurs.index', compact('users'));
    }

    public function toggle(User $user)
    {
        $user->update(['actif' => !$user->actif]);
        $msg = $user->actif ? 'Compte active !' : 'Compte bloque !';
        return back()->with('success', $msg);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprime !');
    }
}