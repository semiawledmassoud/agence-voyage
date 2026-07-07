<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    }
    return view('welcome');
});

require __DIR__ . '/auth.php';

// CLIENT
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/offres', [\App\Http\Controllers\OffreController::class, 'index'])->name('offres.index');
    Route::get('/offres/{offre}', [\App\Http\Controllers\OffreController::class, 'show'])->name('offres.show');
    Route::get('/reservations', [\App\Http\Controllers\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{offre}', [\App\Http\Controllers\ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [\App\Http\Controllers\ReservationController::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}/annuler', [\App\Http\Controllers\ReservationController::class, 'annuler'])->name('reservations.annuler');
    Route::get('/paiement/{reservation}', [\App\Http\Controllers\PaiementController::class, 'show'])->name('paiement.show');
    Route::post('/paiement/{reservation}/process', [\App\Http\Controllers\PaiementController::class, 'process'])->name('paiement.process');
    Route::get('/paiement/success/{reservation}', [\App\Http\Controllers\PaiementController::class, 'success'])->name('paiement.success');
    Route::get('/paiement/historique', [\App\Http\Controllers\PaiementController::class, 'historique'])->name('paiement.historique');
    Route::get('/profil', [\App\Http\Controllers\ProfilController::class, 'edit'])->name('profil.edit');
    Route::patch('/profil', [\App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
    Route::post('/chatbot/message', [\App\Http\Controllers\ChatbotController::class, 'repondre'])->name('chatbot.repondre');
});

// ADMIN
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('offres', \App\Http\Controllers\Admin\OffreAdminController::class);
    Route::patch('/offres/{offre}/toggle', [\App\Http\Controllers\Admin\OffreAdminController::class, 'toggle'])->name('offres.toggle');
    Route::get('/medias', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('medias.index');
    Route::post('/medias', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('medias.store');
    Route::delete('/medias/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('medias.destroy');
    Route::patch('/medias/{media}/toggle', [\App\Http\Controllers\Admin\MediaController::class, 'toggle'])->name('medias.toggle');
    Route::get('/reservations', [\App\Http\Controllers\Admin\ReservationAdminController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [\App\Http\Controllers\Admin\ReservationAdminController::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}/confirmer', [\App\Http\Controllers\Admin\ReservationAdminController::class, 'confirmer'])->name('reservations.confirmer');
    Route::patch('/reservations/{reservation}/annuler', [\App\Http\Controllers\Admin\ReservationAdminController::class, 'annuler'])->name('reservations.annuler');
    Route::get('/utilisateurs', [\App\Http\Controllers\Admin\UtilisateurController::class, 'index'])->name('utilisateurs.index');
    Route::patch('/utilisateurs/{user}/toggle', [\App\Http\Controllers\Admin\UtilisateurController::class, 'toggle'])->name('utilisateurs.toggle');
    Route::delete('/utilisateurs/{user}', [\App\Http\Controllers\Admin\UtilisateurController::class, 'destroy'])->name('utilisateurs.destroy');
    Route::get('/paiements', [\App\Http\Controllers\Admin\PaiementAdminController::class, 'index'])->name('paiements.index');
    Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationAdminController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/envoyer', [\App\Http\Controllers\Admin\NotificationAdminController::class, 'envoyer'])->name('notifications.envoyer');
});