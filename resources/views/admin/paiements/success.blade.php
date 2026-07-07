@extends('layouts.app')
@section('title', 'Paiement réussi')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <div class="card p-5">
            <div style="font-size:80px" class="mb-3">🎉</div>
            <h3 class="fw-bold text-success mb-2">Paiement réussi !</h3>
            <p class="text-muted mb-4">
                Votre réservation a été confirmée. Vous recevrez un email de confirmation.
            </p>

            <div class="p-4 rounded-3 mb-4 text-start" style="background:#F0FDF4;border:1px solid #86EFAC">
                <h6 class="fw-bold mb-3">Récapitulatif</h6>
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Référence</span>
                        <span class="font-monospace fw-semibold">{{ $reservation->reference }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Offre</span>
                        <span>{{ $reservation->offre->titre }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Départ</span>
                        <span>{{ $reservation->offre->date_depart->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Transaction</span>
                        <span class="font-monospace">{{ $reservation->paiement->transaction_id }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted fw-bold">Montant payé</span>
                        <span class="fw-bold text-success">
                            {{ number_format($reservation->paiement->montant, 0) }} DT
                        </span>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('reservations.index') }}" class="btn btn-primary">
                    <i class="bi bi-calendar-check me-2"></i>Mes réservations
                </a>
                <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary">
                    Voir d'autres offres
                </a>
            </div>
        </div>
    </div>
</div>

@endsection