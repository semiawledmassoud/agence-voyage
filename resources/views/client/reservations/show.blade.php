@extends('layouts.app')
@section('title', 'Réservation')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:9px">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0" style="font-family:var(--font-display)">{{ $reservation->reference }}</h4>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">📋 Détails de la réservation</h5>
            <div class="row g-3 small">
                <div class="col-md-6"><span class="text-muted">Offre</span><div class="fw-semibold">{{ $reservation->offre->titre }}</div></div>
                <div class="col-md-6"><span class="text-muted">Statut</span><div><span class="badge badge-{{ $reservation->statut=='confirmee'?'confirmed':($reservation->statut=='annulee'?'cancelled':'pending') }}">{{ $reservation->statut_label }}</span></div></div>
                <div class="col-md-6"><span class="text-muted">Personnes</span><div class="fw-semibold">{{ $reservation->nombre_personnes }}</div></div>
                <div class="col-md-6"><span class="text-muted">Prix total</span><div class="fw-bold" style="color:var(--primary);font-size:17px;font-family:var(--font-display)">{{ number_format($reservation->prix_total,0) }} DT</div></div>
                <div class="col-md-6"><span class="text-muted">Date réservation</span><div class="fw-semibold">{{ $reservation->date_reservation->format('d/m/Y') }}</div></div>
                <div class="col-md-6"><span class="text-muted">Date départ</span><div class="fw-semibold">{{ $reservation->offre->date_depart->format('d/m/Y') }}</div></div>
                <div class="col-md-6"><span class="text-muted">Contact</span><div class="fw-semibold">{{ $reservation->nom_contact }}</div></div>
                <div class="col-md-6"><span class="text-muted">Téléphone</span><div class="fw-semibold">{{ $reservation->telephone_contact }}</div></div>
                @if($reservation->notes)
                <div class="col-12"><span class="text-muted">Notes</span><div class="fw-semibold">{{ $reservation->notes }}</div></div>
                @endif
            </div>
        </div>

        @if($reservation->paiement)
        <div class="card p-4" style="background:#ECFDF5;border:1px solid #A7F3D0">
            <h6 class="fw-bold mb-3 text-success"><i class="bi bi-check-circle-fill me-2"></i>Paiement effectué</h6>
            <div class="small">
                <div class="d-flex justify-content-between mb-1"><span class="text-muted">Transaction</span><span class="font-monospace">{{ $reservation->paiement->transaction_id }}</span></div>
                <div class="d-flex justify-content-between mb-1"><span class="text-muted">Montant</span><span class="fw-bold">{{ number_format($reservation->paiement->montant,0) }} DT</span></div>
                <div class="d-flex justify-content-between"><span class="text-muted">Date</span><span>{{ $reservation->paiement->paid_at->format('d/m/Y H:i') }}</span></div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">⚡ Actions</h5>
            @if($reservation->statut=='en_attente')
                @if(!$reservation->paiement)
                <a href="{{ route('paiement.show',$reservation) }}" class="btn btn-success w-100 mb-2" style="border-radius:10px">
                    <i class="bi bi-credit-card me-2"></i>Procéder au paiement
                </a>
                @endif
                <form method="POST" action="{{ route('reservations.annuler',$reservation) }}"
                      onsubmit="return confirm('Annuler cette réservation ?')">
                    @csrf @method('PATCH')
                    <button class="btn btn-outline-danger w-100" style="border-radius:10px">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </button>
                </form>
            @elseif($reservation->statut=='confirmee')
                <div class="alert" style="background:#ECFDF5;color:#065F46;border-radius:10px;text-align:center">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i><br>
                    <strong>Réservation confirmée !</strong><br>
                    <small>Bon voyage 🌍</small>
                </div>
            @else
                <div class="alert" style="background:#F3F4F6;color:#6B7280;border-radius:10px;text-align:center">
                    Statut : {{ $reservation->statut_label }}
                </div>
            @endif

            <hr>
            <a href="{{ route('offres.index') }}" class="btn btn-outline-primary w-100" style="border-radius:10px">
                <i class="bi bi-map me-2"></i>Voir d'autres offres
            </a>
        </div>
    </div>
</div>

@endsection