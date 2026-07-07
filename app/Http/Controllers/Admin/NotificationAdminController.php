<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NotificationVoyage;
use Illuminate\Http\Request;

class NotificationAdminController extends Controller
{
    public function index()
    {
        $notifications = NotificationVoyage::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function envoyer(Request $request)
    {
        $request->validate([
            'titre'   => 'required|string',
            'message' => 'required|string',
            'type'    => 'required|string',
        ]);

        $users = User::where('role', 'client')->where('actif', true)->get();

        foreach ($users as $user) {
            NotificationVoyage::create([
                'user_id' => $user->id,
                'titre'   => $request->titre,
                'message' => $request->message,
                'type'    => $request->type,
            ]);
        }

        return back()->with('success', count($users).' notification(s) envoyee(s) !');
    }
}