@extends('layouts.admin')
@section('title', 'Détail Réservation')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:9px">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Réservation</h4>
        <p class="text-muted mb-0 font-monospace" style="font-size:12.5px">{{ $reservation->reference }}</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">📋 Informations</h5>
            <div class="row g-3 small">
                <div class="col-md-6"><span class="text-muted">Client</span><div class="fw-semibold">{{ $reservation->user->name }}</div></div>
                <div class="col-md-6"><span class="text-muted">Email</span><div class="fw-semibold">{{ $reservation->user->email }}</div></div>
                <div class="col-md-6"><span class="text-muted">Offre</span><div class="fw-semibold">{{ $reservation->offre->titre }}</div></div>
                <div class="col-md-6"><span class="text-muted">Destination</span><div class="fw-semibold">{{ $reservation->offre->destination }}</div></div>
                <div class="col-md-6"><span class="text-muted">Personnes</span><div class="fw-semibold">{{ $reservation->nombre_personnes }}</div></div>
                <div class="col-md-6"><span class="text-muted">Prix total</span><div class="fw-bold" style="color:#6366F1;font-size:16px">{{ number_format($reservation->prix_total,0) }} DT</div></div>
                <div class="col-md-6"><span class="text-muted">Contact</span><div class="fw-semibold">{{ $reservation->nom_contact }}</div></div>
                <div class="col-md-6"><span class="text-muted">Téléphone</span><div class="fw-semibold">{{ $reservation->telephone_contact }}</div></div>
                <div class="col-md-6"><span class="text-muted">Statut</span>
                    <div><span class="badge badge-{{ $reservation->statut=='confirmee'?'confirmed':($reservation->statut=='annulee'?'cancelled':'pending') }}">{{ $reservation->statut_label }}</span></div>
                </div>
                <div class="col-md-6"><span class="text-muted">Date réservation</span><div class="fw-semibold">{{ $reservation->date_reservation->format('d/m/Y') }}</div></div>
                @if($reservation->notes)
                <div class="col-12"><span class="text-muted">Notes</span><div class="fw-semibold">{{ $reservation->notes }}</div></div>
                @endif
            </div>
        </div>

        @if($reservation->paiement)
        <div class="card p-4" style="background:#ECFDF5;border:1px solid #A7F3D0">
            <h6 class="fw-bold mb-3 text-success"><i class="bi bi-check-circle-fill me-2"></i>Paiement effectué</h6>
            <div class="row g-2 small">
                <div class="col-md-6"><span class="text-muted">Transaction</span><div class="fw-semibold font-monospace">{{ $reservation->paiement->transaction_id }}</div></div>
                <div class="col-md-6"><span class="text-muted">Montant</span><div class="fw-bold">{{ number_format($reservation->paiement->montant,0) }} DT</div></div>
                <div class="col-md-6"><span class="text-muted">Méthode</span><div class="fw-semibold">{{ $reservation->paiement->methode }}</div></div>
                <div class="col-md-6"><span class="text-muted">Date</span><div class="fw-semibold">{{ $reservation->paiement->paid_at->format('d/m/Y H:i') }}</div></div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">⚡ Actions</h5>
            @if($reservation->statut=='en_attente')
                <form method="POST" action="{{ route('admin.reservations.confirmer',$reservation) }}" class="mb-2">
                    @csrf @method('PATCH')
                    <button class="btn btn-success w-100" style="border-radius:10px">
                        <i class="bi bi-check-circle me-2"></i>Confirmer la réservation
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.reservations.annuler',$reservation) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-outline-danger w-100" style="border-radius:10px">
                        <i class="bi bi-x-circle me-2"></i>Annuler la réservation
                    </button>
                </form>
            @elseif($reservation->statut=='confirmee')
                <div class="alert" style="background:#ECFDF5;color:#065F46;border-radius:10px;text-align:center">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i><br>
                    <strong>Réservation confirmée</strong>
                </div>
            @else
                <div class="alert" style="background:#FEF2F2;color:#991B1B;border-radius:10px;text-align:center">
                    Réservation {{ $reservation->statut }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection