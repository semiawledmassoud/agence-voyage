@extends('layouts.app')
@section('title', 'Nos Destinations')

@push('styles')
<style>
    .filter-card { position: sticky; top: 80px; }
    .offer-img { height: 210px; width: 100%; object-fit: cover; transition: transform 0.4s; }
    .card:hover .offer-img { transform: scale(1.05); }
    .img-wrap { overflow: hidden; border-radius: 13px 13px 0 0; position: relative; }
</style>
@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="font-family:var(--font-display)">🌍 Nos Destinations</h3>
        <p class="text-muted mb-0" style="font-size:13px">{{ $offres->total() }} offre(s) disponible(s)</p>
    </div>
</div>

<div class="row g-4">

    {{-- FILTRES --}}
    <div class="col-md-3">
        <div class="card p-4 filter-card">
            <h6 class="fw-bold mb-3"><i class="bi bi-funnel-fill me-2 text-primary"></i>Filtrer</h6>
            <form method="GET" action="{{ route('offres.index') }}">

                <div class="mb-3">
                    <label class="form-label" style="font-size:12px;font-weight:600">Destination</label>
                    <input type="text" name="destination" class="form-control form-control-sm"
                           value="{{ request('destination') }}" placeholder="Paris, Istanbul...">
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size:12px;font-weight:600">Type de voyage</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">Tous les types</option>
                        <option value="voyage"   {{ request('type')=='voyage'   ?'selected':'' }}>✈️ Voyage</option>
                        <option value="circuit"  {{ request('type')=='circuit'  ?'selected':'' }}>🗺️ Circuit</option>
                        <option value="sejour"   {{ request('type')=='sejour'   ?'selected':'' }}>🏨 Séjour</option>
                        <option value="aventure" {{ request('type')=='aventure' ?'selected':'' }}>🏔️ Aventure</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size:12px;font-weight:600">Budget (DT)</label>
                    <div class="row g-1">
                        <div class="col-6">
                            <input type="number" name="prix_min" class="form-control form-control-sm"
                                   value="{{ request('prix_min') }}" placeholder="Min">
                        </div>
                        <div class="col-6">
                            <input type="number" name="prix_max" class="form-control form-control-sm"
                                   value="{{ request('prix_max') }}" placeholder="Max">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size:12px;font-weight:600">Date de départ</label>
                    <input type="date" name="date_depart" class="form-control form-control-sm"
                           value="{{ request('date_depart') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label" style="font-size:12px;font-weight:600">Trier par</label>
                    <select name="tri" class="form-select form-select-sm">
                        <option value="date_depart" {{ request('tri')=='date_depart'?'selected':'' }}>Date départ</option>
                        <option value="prix"        {{ request('tri')=='prix'       ?'selected':'' }}>Prix croissant</option>
                        <option value="duree_jours" {{ request('tri')=='duree_jours'?'selected':'' }}>Durée</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search me-1"></i>Rechercher
                    </button>
                    <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x me-1"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- OFFRES --}}
    <div class="col-md-9">

        @if(request()->hasAny(['destination','type','prix_min','prix_max','date_depart']))
        <div class="alert mb-3" style="background:#EFF6FF;color:#1D4ED8;border-radius:10px;font-size:13px">
            <i class="bi bi-filter-circle-fill me-2"></i>
            Filtres actifs :
            @if(request('destination'))<span class="badge bg-primary ms-1">{{ request('destination') }}</span>@endif
            @if(request('type'))<span class="badge bg-primary ms-1">{{ request('type') }}</span>@endif
            @if(request('prix_max'))<span class="badge bg-primary ms-1">Max {{ request('prix_max') }} DT</span>@endif
            <a href="{{ route('offres.index') }}" class="ms-2 text-decoration-none" style="color:#1D4ED8">Effacer tout ×</a>
        </div>
        @endif

        @if($offres->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:64px">🔍</div>
            <h5 class="fw-bold mt-3">Aucune offre trouvée</h5>
            <p class="text-muted">Essayez d'autres critères de recherche.</p>
            <a href="{{ route('offres.index') }}" class="btn btn-primary mt-2">Voir toutes les offres</a>
        </div>
        @else
        <div class="row g-4">
            @foreach($offres as $offre)
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="img-wrap">
                        @if($offre->image_principale)
                            <img src="{{ asset('storage/'.$offre->image_principale) }}"
                                 class="offer-img" alt="{{ $offre->titre }}">
                        @else
                            <div style="height:210px;background:linear-gradient(135deg,#0EA5E9,#8B5CF6);display:flex;align-items:center;justify-content:center;font-size:55px">🌍</div>
                        @endif
                        <div style="position:absolute;top:10px;left:10px;display:flex;gap:5px">
                            <span style="background:rgba(0,0,0,0.6);color:white;font-size:10px;padding:3px 8px;border-radius:6px">{{ $offre->type }}</span>
                        </div>
                        @if($offre->prix_promo)
                        <span style="position:absolute;top:10px;right:10px;background:#EF4444;color:white;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:700">PROMO</span>
                        @endif
                        @if($offre->places_disponibles <= 3 && $offre->places_disponibles > 0)
                        <span style="position:absolute;bottom:10px;right:10px;background:#F59E0B;color:white;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:700">⚠️ {{ $offre->places_disponibles }} place(s)</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <h6 class="fw-bold mb-2" style="font-size:14.5px">{{ $offre->titre }}</h6>
                        <div class="text-muted small mb-1">
                            <i class="bi bi-geo-alt-fill text-primary me-1"></i>
                            {{ $offre->destination }}, {{ $offre->pays }}
                        </div>
                        <div class="d-flex gap-2 text-muted small mb-3">
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $offre->date_depart->format('d/m/Y') }}</span>
                            <span>•</span>
                            <span><i class="bi bi-clock me-1"></i>{{ $offre->duree_jours }}j</span>
                        </div>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <div>
                                @if($offre->prix_promo)
                                    <div class="text-muted text-decoration-line-through" style="font-size:12px">{{ number_format($offre->prix,0) }} DT</div>
                                    <div class="fw-bold" style="color:#10B981;font-size:18px;font-family:var(--font-display)">{{ number_format($offre->prix_promo,0) }} DT</div>
                                @else
                                    <div class="fw-bold" style="color:var(--primary);font-size:18px;font-family:var(--font-display)">{{ number_format($offre->prix,0) }} DT</div>
                                @endif
                                <div class="text-muted" style="font-size:11px">/personne</div>
                            </div>
                            <a href="{{ route('offres.show', $offre) }}" class="btn btn-primary btn-sm px-3">
                                Voir →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $offres->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

@endsection