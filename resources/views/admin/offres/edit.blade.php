@extends('layouts.admin')
@section('title', 'Modifier Offre')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:9px">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">✏️ Modifier : {{ $offre->titre }}</h4>
        <p class="text-muted mb-0" style="font-size:12.5px">ID #{{ $offre->id }}</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.offres.update', $offre) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row g-4">

    <div class="col-md-8">

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">📋 Informations générales</h5>
            <div class="mb-3">
                <label class="form-label">Titre *</label>
                <input type="text" name="titre" class="form-control"
                       value="{{ old('titre', $offre->titre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description *</label>
                <textarea name="description" rows="5" class="form-control" required>{{ old('description', $offre->description) }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Destination *</label>
                    <input type="text" name="destination" class="form-control"
                           value="{{ old('destination', $offre->destination) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pays *</label>
                    <input type="text" name="pays" class="form-control"
                           value="{{ old('pays', $offre->pays) }}" required>
                </div>
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">📅 Dates & Durée</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Date départ *</label>
                    <input type="date" name="date_depart" class="form-control"
                           value="{{ old('date_depart', $offre->date_depart->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date retour *</label>
                    <input type="date" name="date_retour" class="form-control"
                           value="{{ old('date_retour', $offre->date_retour->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Durée (jours) *</label>
                    <input type="number" name="duree_jours" class="form-control"
                           value="{{ old('duree_jours', $offre->duree_jours) }}" min="1" required>
                </div>
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">💰 Prix & Places</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Prix normal (DT) *</label>
                    <div class="input-group">
                        <input type="number" name="prix" class="form-control"
                               value="{{ old('prix', $offre->prix) }}" min="0" step="0.01" required>
                        <span class="input-group-text">DT</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix promo (DT)</label>
                    <div class="input-group">
                        <input type="number" name="prix_promo" class="form-control"
                               value="{{ old('prix_promo', $offre->prix_promo) }}" min="0" step="0.01">
                        <span class="input-group-text">DT</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Places totales *</label>
                    <input type="number" name="places_totales" class="form-control"
                           value="{{ old('places_totales', $offre->places_totales) }}" min="1" required>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h5 class="fw-bold mb-4">🖼️ Images</h5>

            @if($offre->image_principale)
            <div class="mb-3">
                <label class="form-label">Image principale actuelle</label><br>
                <img src="{{ asset('storage/'.$offre->image_principale) }}"
                     style="height:120px;border-radius:10px;object-fit:cover">
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Changer l'image principale</label>
                <input type="file" name="image_principale" class="form-control" accept="image/*">
                <small class="text-muted">Laissez vide pour garder l'image actuelle</small>
            </div>

            @if($offre->images->count() > 0)
            <div class="mb-3">
                <label class="form-label">Galerie actuelle ({{ $offre->images->count() }} images)</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($offre->images as $img)
                    <img src="{{ asset('storage/'.$img->image) }}"
                         style="height:70px;width:100px;object-fit:cover;border-radius:8px">
                    @endforeach
                </div>
            </div>
            @endif

            <div>
                <label class="form-label">Ajouter des images galerie</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
            </div>
        </div>

    </div>

    <div class="col-md-4">

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">⚙️ Paramètres</h5>
            <div class="mb-3">
                <label class="form-label">Type *</label>
                <select name="type" class="form-select" required>
                    <option value="voyage"   {{ old('type',$offre->type)=='voyage'   ?'selected':'' }}>✈️ Voyage</option>
                    <option value="circuit"  {{ old('type',$offre->type)=='circuit'  ?'selected':'' }}>🗺️ Circuit</option>
                    <option value="sejour"   {{ old('type',$offre->type)=='sejour'   ?'selected':'' }}>🏨 Séjour</option>
                    <option value="aventure" {{ old('type',$offre->type)=='aventure' ?'selected':'' }}>🏔️ Aventure</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Statut</label>
                <select name="statut" class="form-select">
                    <option value="active"   {{ old('statut',$offre->statut)=='active'   ?'selected':'' }}>✅ Active</option>
                    <option value="inactive" {{ old('statut',$offre->statut)=='inactive' ?'selected':'' }}>⏸ Inactive</option>
                    <option value="complete" {{ old('statut',$offre->statut)=='complete' ?'selected':'' }}>🔴 Complète</option>
                </select>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="featured" id="featured"
                       {{ old('featured',$offre->featured) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold small" for="featured">⭐ Mettre en avant</label>
            </div>
        </div>

        <div class="card p-4 mb-4" style="background:#FFFBEB;border:1px solid #FDE68A">
            <h6 class="fw-bold mb-3">📊 Statistiques</h6>
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Places dispo</span>
                <span class="fw-bold text-success">{{ $offre->places_disponibles }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Réservations</span>
                <span class="fw-bold">{{ $offre->reservations->count() }}</span>
            </div>
            <div class="d-flex justify-content-between small">
                <span class="text-muted">Créée le</span>
                <span>{{ $offre->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-warning btn-lg fw-bold">
                <i class="bi bi-check-circle me-2"></i>Enregistrer
            </button>
            <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-2"></i>Annuler
            </a>
        </div>
    </div>
</div>
</form>

@endsection