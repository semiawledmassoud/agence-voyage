@extends('layouts.app')
@section('title', 'Paiement')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-5 text-center">
            <div style="font-size:60px" class="mb-3">💳</div>
            <h4 class="fw-bold mb-2">Paiement de votre réservation</h4>
            <p class="text-muted mb-4">Réservation : <strong>{{ $reservation->reference }}</strong></p>

            <div class="p-4 rounded-3 mb-4" style="background:#EFF6FF">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Offre</span>
                    <span class="fw-semibold">{{ $reservation->offre->titre }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Personnes</span>
                    <span>{{ $reservation->nombre_personnes }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold fs-5">Total à payer</span>
                    <span class="fw-bold fs-4 text-primary">
                        {{ number_format($reservation->prix_total, 0) }} DT
                    </span>
                </div>
            </div>

            <div class="p-3 rounded-3 mb-4" style="background:#F8FAFC;border:1px dashed #CBD5E1">
                <p class="small text-muted mb-0">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    Paiement sécurisé via Stripe
                </p>
            </div>

            <form method="POST" action="{{ route('paiement.process', $reservation) }}">
                @csrf
                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                    <i class="bi bi-lock me-2"></i>
                    Payer {{ number_format($reservation->prix_total, 0) }} DT
                </button>
            </form>

            <a href="{{ route('reservations.show', $reservation) }}"
               class="btn btn-link text-muted mt-2">
                ← Retour à la réservation
            </a>
        </div>
    </div>
</div>

@endsection