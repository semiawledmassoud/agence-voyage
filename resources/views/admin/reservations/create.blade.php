@extends('layouts.app')
@section('title', 'Réserver')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('offres.show', $offre) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Réserver : {{ $offre->titre }}</h4>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-4">📝 Informations de réservation</h5>

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('reservations.store') }}">
                @csrf
                <input type="hidden" name="offre_id" value="{{ $offre->id }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre de personnes *</label>
                    <select name="nombre_personnes" class="form-select" id="nb_personnes"
                            onchange="calculerPrix()">
                        @for($i = 1; $i <= min($offre->places_disponibles, 10); $i++)
                        <option value="{{ $i }}">{{ $i }} personne(s)</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom complet *</label>
                    <input type="text" name="nom_contact" class="form-control"
                           value="{{ old('nom_contact', auth()->user()->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email_contact" class="form-control"
                           value="{{ old('email_contact', auth()->user()->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Téléphone *</label>
                    <input type="text" name="telephone_contact" class="form-control"
                           value="{{ old('telephone_contact', auth()->user()->telephone) }}"
                           placeholder="+216 XX XXX XXX" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Notes (optionnel)</label>
                    <textarea name="notes" rows="3" class="form-control"
                              placeholder="Demandes spéciales...">{{ old('notes') }}</textarea>
                </div>

                <div class="p-3 rounded-3 mb-4" style="background:#EFF6FF">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">Prix par personne :</span>
                        <span>{{ number_format($offre->prix_affichage, 0) }} DT</span>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span class="fw-bold fs-5">Total :</span>
                        <span class="fw-bold fs-5 text-primary" id="prix-total">
                            {{ number_format($offre->prix_affichage, 0) }} DT
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-calendar-check me-2"></i>Confirmer la réservation
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">📋 Résumé de l'offre</h5>
            @if($offre->image_principale)
                <img src="{{ asset('storage/'.$offre->image_principale) }}"
                     class="w-100 rounded mb-3" style="height:150px;object-fit:cover">
            @endif
            <h6 class="fw-bold">{{ $offre->titre }}</h6>
            <p class="text-muted small">
                <i class="bi bi-geo-alt me-1"></i>{{ $offre->destination }}, {{ $offre->pays }}
            </p>
            <hr>
            <div class="small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Départ</span>
                    <span>{{ $offre->date_depart->format('d/m/Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Retour</span>
                    <span>{{ $offre->date_retour->format('d/m/Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Durée</span>
                    <span>{{ $offre->duree_jours }} jours</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Places dispo</span>
                    <span class="text-success fw-semibold">{{ $offre->places_disponibles }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const prixParPersonne = {{ $offre->prix_affichage }};
function calculerPrix() {
    const nb = document.getElementById('nb_personnes').value;
    const total = (prixParPersonne * nb).toLocaleString('fr-FR');
    document.getElementById('prix-total').textContent = total + ' DT';
}
</script>
@endpush