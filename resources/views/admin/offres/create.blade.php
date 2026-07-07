@extends('layouts.admin')
@section('title', 'Nouvelle Offre')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Nouvelle Offre</h4>
</div>

<form method="POST" action="{{ route('admin.offres.store') }}" enctype="multipart/form-data">
@csrf
<div class="row g-4">
    <div class="col-md-8">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">Informations générales</h5>
            <div class="mb-3">
                <label class="form-label fw-semibold">Titre *</label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description *</label>
                <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Destination *</label>
                    <input type="text" name="destination" class="form-control" value="{{ old('destination') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pays *</label>
                    <input type="text" name="pays" class="form-control" value="{{ old('pays') }}" required>
                </div>
            </div>
        </div>
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">Dates & Prix</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date départ *</label>
                    <input type="date" name="date_depart" class="form-control" value="{{ old('date_depart') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date retour *</label>
                    <input type="date" name="date_retour" class="form-control" value="{{ old('date_retour') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Durée (jours) *</label>
                    <input type="number" name="duree_jours" class="form-control" value="{{ old('duree_jours') }}" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Prix (DT) *</label>
                    <input type="number" name="prix" class="form-control" value="{{ old('prix') }}" min="0" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Prix promo (DT)</label>
                    <input type="number" name="prix_promo" class="form-control" value="{{ old('prix_promo') }}" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Places *</label>
                    <input type="number" name="places_totales" class="form-control" value="{{ old('places_totales') }}" min="1" required>
                </div>
            </div>
        </div>
        <div class="card p-4">
            <h5 class="fw-bold mb-4">Image</h5>
            <input type="file" name="image_principale" class="form-control" accept="image/*">
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">Paramètres</h5>
            <div class="mb-3">
                <label class="form-label fw-semibold">Type *</label>
                <select name="type" class="form-select" required>
                    <option value="voyage">Voyage</option>
                    <option value="circuit">Circuit</option>
                    <option value="sejour">Séjour</option>
                    <option value="aventure">Aventure</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Statut</label>
                <select name="statut" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="featured" id="featured">
                <label class="form-check-label" for="featured">Mettre en avant</label>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle me-2"></i>Créer l'offre
            </button>
            <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </div>
</div>
</form>
@endsection@extends('layouts.admin')
@section('title', 'Nouvelle Offre')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:9px">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">➕ Nouvelle Offre</h4>
        <p class="text-muted mb-0" style="font-size:12.5px">Remplissez tous les champs requis</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.offres.store') }}" enctype="multipart/form-data">
@csrf
<div class="row g-4">

    <div class="col-md-8">

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">📋 Informations générales</h5>

            <div class="mb-3">
                <label class="form-label">Titre de l'offre *</label>
                <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                       value="{{ old('titre') }}" placeholder="Ex: Découverte de Paris — 7 jours" required>
                @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description complète *</label>
                <textarea name="description" rows="5"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Décrivez l'offre en détail : activités, hébergement, repas inclus..." required>{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Destination *</label>
                    <input type="text" name="destination"
                           class="form-control @error('destination') is-invalid @enderror"
                           value="{{ old('destination') }}" placeholder="Ex: Paris" required>
                    @error('destination')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pays *</label>
                    <input type="text" name="pays"
                           class="form-control @error('pays') is-invalid @enderror"
                           value="{{ old('pays') }}" placeholder="Ex: France" required>
                    @error('pays')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">📅 Dates & Durée</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Date de départ *</label>
                    <input type="date" name="date_depart"
                           class="form-control @error('date_depart') is-invalid @enderror"
                           value="{{ old('date_depart') }}" required>
                    @error('date_depart')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date de retour *</label>
                    <input type="date" name="date_retour"
                           class="form-control @error('date_retour') is-invalid @enderror"
                           value="{{ old('date_retour') }}" required>
                    @error('date_retour')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Durée (jours) *</label>
                    <input type="number" name="duree_jours"
                           class="form-control @error('duree_jours') is-invalid @enderror"
                           value="{{ old('duree_jours') }}" min="1" placeholder="7" required>
                    @error('duree_jours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">💰 Prix & Places</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Prix normal (DT) *</label>
                    <div class="input-group">
                        <input type="number" name="prix"
                               class="form-control @error('prix') is-invalid @enderror"
                               value="{{ old('prix') }}" min="0" step="0.01"
                               placeholder="1200.00" id="prixNormal" required>
                        <span class="input-group-text">DT</span>
                    </div>
                    @error('prix')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix promo (DT)</label>
                    <div class="input-group">
                        <input type="number" name="prix_promo"
                               class="form-control @error('prix_promo') is-invalid @enderror"
                               value="{{ old('prix_promo') }}" min="0" step="0.01"
                               placeholder="Optionnel" id="prixPromo">
                        <span class="input-group-text">DT</span>
                    </div>
                    @error('prix_promo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nombre de places *</label>
                    <input type="number" name="places_totales"
                           class="form-control @error('places_totales') is-invalid @enderror"
                           value="{{ old('places_totales') }}" min="1"
                           placeholder="20" id="placesInput" required>
                    @error('places_totales')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h5 class="fw-bold mb-4">🖼️ Images</h5>

            <div class="mb-4">
                <label class="form-label">Image principale</label>
                <div class="upload-zone" id="mainImgZone" onclick="document.getElementById('img_principale').click()">
                    <div style="font-size:36px" id="mainImgIcon">🖼️</div>
                    <div class="fw-semibold mt-2 small">Cliquez pour choisir l'image principale</div>
                    <div class="text-muted" style="font-size:11px">JPG, PNG, WEBP — max 2MB</div>
                    <div class="text-primary mt-1 small" id="mainImgName">Aucun fichier</div>
                </div>
                <input type="file" id="img_principale" name="image_principale"
                       accept="image/*" style="display:none"
                       onchange="previewMain(this)">
                @error('image_principale')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                <div id="mainPreview" class="mt-2" style="display:none">
                    <img id="mainPreviewImg" src="" alt=""
                         style="height:120px;border-radius:10px;object-fit:cover">
                </div>
            </div>

            <div>
                <label class="form-label">Images galerie (optionnel)</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                <small class="text-muted">Plusieurs images possibles pour la galerie</small>
            </div>
        </div>

    </div>

    <div class="col-md-4">

        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4">⚙️ Paramètres</h5>

            <div class="mb-3">
                <label class="form-label">Type d'offre *</label>
                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="">Choisir...</option>
                    <option value="voyage"   {{ old('type')=='voyage'   ?'selected':'' }}>✈️ Voyage</option>
                    <option value="circuit"  {{ old('type')=='circuit'  ?'selected':'' }}>🗺️ Circuit</option>
                    <option value="sejour"   {{ old('type')=='sejour'   ?'selected':'' }}>🏨 Séjour</option>
                    <option value="aventure" {{ old('type')=='aventure' ?'selected':'' }}>🏔️ Aventure</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Statut initial</label>
                <select name="statut" class="form-select">
                    <option value="active"   {{ old('statut','active')=='active'   ?'selected':'' }}>✅ Active</option>
                    <option value="inactive" {{ old('statut')=='inactive' ?'selected':'' }}>⏸ Inactive</option>
                </select>
            </div>

            <div class="form-check form-switch mb-1">
                <input class="form-check-input" type="checkbox" name="featured" id="featured"
                       {{ old('featured') ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold small" for="featured">
                    ⭐ Mettre en avant
                </label>
            </div>
            <p class="text-muted" style="font-size:11px">Affiché sur la page d'accueil</p>
        </div>

        <div class="card p-4 mb-4" style="background:#F8F9FF">
            <h6 class="fw-bold mb-3">📊 Aperçu</h6>
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Prix affiché</span>
                <span class="fw-bold" style="color:#6366F1" id="sum-prix">—</span>
            </div>
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Places</span>
                <span class="fw-bold" id="sum-places">—</span>
            </div>
            <div class="d-flex justify-content-between small">
                <span class="text-muted">Économie promo</span>
                <span class="fw-bold text-success" id="sum-promo">—</span>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle me-2"></i>Créer l'offre
            </button>
            <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-2"></i>Annuler
            </a>
        </div>

    </div>
</div>
</form>

@endsection

@push('scripts')
<script>
function previewMain(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('mainPreviewImg').src = e.target.result;
            document.getElementById('mainPreview').style.display = 'block';
            document.getElementById('mainImgIcon').textContent = '✅';
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('mainImgName').textContent = input.files[0].name;
    }
}

document.getElementById('prixNormal').addEventListener('input', updateSummary);
document.getElementById('prixPromo').addEventListener('input', updateSummary);
document.getElementById('placesInput').addEventListener('input', function() {
    document.getElementById('sum-places').textContent = this.value ? this.value + ' places' : '—';
});

function updateSummary() {
    const p = parseFloat(document.getElementById('prixNormal').value) || 0;
    const promo = parseFloat(document.getElementById('prixPromo').value) || 0;
    document.getElementById('sum-prix').textContent = p ? p.toLocaleString() + ' DT' : '—';
    if (promo && p && promo < p) {
        document.getElementById('sum-promo').textContent = (p - promo).toLocaleString() + ' DT';
    } else {
        document.getElementById('sum-promo').textContent = '—';
    }
}

// Calculer durée auto
document.querySelector('[name=date_depart]').addEventListener('change', calcDuree);
document.querySelector('[name=date_retour]').addEventListener('change', calcDuree);
function calcDuree() {
    const d = new Date(document.querySelector('[name=date_depart]').value);
    const r = new Date(document.querySelector('[name=date_retour]').value);
    if (d && r && r > d) {
        const diff = Math.round((r - d) / (1000 * 60 * 60 * 24));
        document.querySelector('[name=duree_jours]').value = diff;
    }
}
</script>
@endpush