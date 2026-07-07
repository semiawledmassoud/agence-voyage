@extends('layouts.app')
@section('title', $offre->titre)

@push('styles')
<style>
    main > .container { max-width:100%; padding:0; }
    .offer-hero { height:400px; position:relative; overflow:hidden; }
    .offer-hero img { width:100%; height:100%; object-fit:cover; }
    .offer-hero::before { content:''; position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,0.78) 0%,rgba(0,0,0,0.15) 60%,transparent 100%); z-index:1; }
    .offer-hero-content { position:absolute; bottom:0; left:0; right:0; padding:28px 5%; z-index:2; color:white; }
    .offer-body { padding:30px 5% 60px; }
    .info-pill { display:inline-flex; align-items:center; gap:6px; background:#F8FAFC; border:1px solid var(--border); border-radius:9px; padding:7px 13px; font-size:13px; font-weight:500; }
    .sticky-side { position:sticky; top:80px; }
    .price-box { background:linear-gradient(135deg,#F0F9FF,#EFF6FF); border:2px solid #BAE6FD; border-radius:14px; padding:22px; text-align:center; }
    .price-big { font-family:var(--font-display); font-size:2.6rem; font-weight:800; color:var(--primary); line-height:1; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div style="padding:11px 5%;background:white;border-bottom:1px solid var(--border)">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:12.5px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('offres.index') }}">Destinations</a></li>
            <li class="breadcrumb-item active">{{ $offre->titre }}</li>
        </ol>
    </nav>
</div>

{{-- Hero --}}
<div class="offer-hero">
    @if($offre->image_principale)
        <img src="{{ asset('storage/'.$offre->image_principale) }}" alt="{{ $offre->titre }}">
    @else
        <div style="height:100%;background:linear-gradient(135deg,#0EA5E9,#8B5CF6);display:flex;align-items:center;justify-content:center;font-size:90px">🌍</div>
    @endif
    <div class="offer-hero-content">
        <div class="d-flex gap-2 mb-2">
            <span style="background:rgba(255,255,255,0.22);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.28);color:white;font-size:11px;padding:3px 10px;border-radius:7px;font-weight:600">{{ $offre->type }}</span>
            @if($offre->prix_promo)
                <span style="background:#EF4444;color:white;font-size:11px;padding:3px 10px;border-radius:7px;font-weight:600">PROMO</span>
            @endif
            @if($offre->featured)
                <span style="background:rgba(245,158,11,0.88);color:white;font-size:11px;padding:3px 10px;border-radius:7px;font-weight:600">Featured</span>
            @endif
        </div>
        <h1 style="font-family:var(--font-display);font-size:clamp(1.7rem,4vw,2.8rem);font-weight:800;margin-bottom:7px">{{ $offre->titre }}</h1>
        <p style="font-size:14.5px;opacity:0.85;margin:0">
            <i class="bi bi-geo-alt-fill me-1"></i>{{ $offre->destination }}, {{ $offre->pays }}
        </p>
    </div>
</div>

{{-- Galerie --}}
@if($offre->images->count() > 0)
<div style="padding:14px 5%;background:white;border-bottom:1px solid var(--border);display:flex;gap:9px;overflow-x:auto">
    @foreach($offre->images as $img)
    <img src="{{ asset('storage/'.$img->image) }}"
         style="height:75px;width:115px;object-fit:cover;border-radius:9px;flex-shrink:0;cursor:pointer"
         alt="">
    @endforeach
</div>
@endif

<div class="offer-body">
    <div class="row g-4">

        {{-- Contenu principal --}}
        <div class="col-lg-8">

            {{-- Info pills --}}
            <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="info-pill"><i class="bi bi-calendar3 text-primary"></i>Départ: {{ $offre->date_depart->format('d/m/Y') }}</span>
                <span class="info-pill"><i class="bi bi-calendar-check text-success"></i>Retour: {{ $offre->date_retour->format('d/m/Y') }}</span>
                <span class="info-pill"><i class="bi bi-clock text-warning"></i>{{ $offre->duree_jours }} jours</span>
                <span class="info-pill"><i class="bi bi-people text-info"></i>{{ $offre->places_disponibles }} places</span>
                <span class="info-pill"><i class="bi bi-flag text-danger"></i>{{ $offre->pays }}</span>
            </div>

            {{-- Description --}}
            <div class="card p-4 mb-4">
                <h4 class="fw-bold mb-3" style="font-family:var(--font-display)">À propos de ce voyage</h4>
                <p style="font-size:14.5px;line-height:1.85;color:#374151">{{ $offre->description }}</p>
            </div>

            {{-- Ce qui est inclus - SANS @foreach --}}
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-3">Ce qui est inclus</h5>
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 text-success fw-semibold" style="font-size:13px">
                            <i class="bi bi-check-circle-fill"></i>Billet avion aller-retour
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 text-success fw-semibold" style="font-size:13px">
                            <i class="bi bi-check-circle-fill"></i>Hébergement inclus
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 text-success fw-semibold" style="font-size:13px">
                            <i class="bi bi-check-circle-fill"></i>Guide touristique
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 text-success fw-semibold" style="font-size:13px">
                            <i class="bi bi-check-circle-fill"></i>Transferts aéroport
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 text-muted" style="font-size:13px">
                            <i class="bi bi-x-circle-fill text-danger"></i>Dépenses personnelles
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 text-muted" style="font-size:13px">
                            <i class="bi bi-x-circle-fill text-danger"></i>Assurance voyage
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informations pratiques - SANS @foreach --}}
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Informations pratiques</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div style="background:#F8FAFC;border-radius:10px;padding:13px;text-align:center">
                            <div style="font-size:26px">🛂</div>
                            <div class="fw-semibold mt-1" style="font-size:12.5px">Visa</div>
                            <div class="text-muted" style="font-size:11px">Vérifier avant départ</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:#F8FAFC;border-radius:10px;padding:13px;text-align:center">
                            <div style="font-size:26px">💉</div>
                            <div class="fw-semibold mt-1" style="font-size:12.5px">Vaccins</div>
                            <div class="text-muted" style="font-size:11px">Consulter un médecin</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:#F8FAFC;border-radius:10px;padding:13px;text-align:center">
                            <div style="font-size:26px">🌤️</div>
                            <div class="fw-semibold mt-1" style="font-size:12.5px">Météo</div>
                            <div class="text-muted" style="font-size:11px">Vérifier la saison</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:#F8FAFC;border-radius:10px;padding:13px;text-align:center">
                            <div style="font-size:26px">🏨</div>
                            <div class="fw-semibold mt-1" style="font-size:12.5px">Hôtel</div>
                            <div class="text-muted" style="font-size:11px">Inclus dans le prix</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:#F8FAFC;border-radius:10px;padding:13px;text-align:center">
                            <div style="font-size:26px">🚌</div>
                            <div class="fw-semibold mt-1" style="font-size:12.5px">Transport</div>
                            <div class="text-muted" style="font-size:11px">Transferts inclus</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:#F8FAFC;border-radius:10px;padding:13px;text-align:center">
                            <div style="font-size:26px">📸</div>
                            <div class="fw-semibold mt-1" style="font-size:12.5px">Photos</div>
                            <div class="text-muted" style="font-size:11px">Pensez à votre appareil</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Sidebar réservation --}}
        <div class="col-lg-4">
            <div class="sticky-side">

                <div class="price-box mb-4">
                    @if($offre->prix_promo)
                        <div class="text-muted text-decoration-line-through mb-1" style="font-size:15px">
                            {{ number_format($offre->prix, 0) }} DT
                        </div>
                        <div class="price-big" style="color:#10B981">
                            {{ number_format($offre->prix_promo, 0) }} DT
                        </div>
                        <div class="mt-1 mb-2">
                            <span style="background:#FEF2F2;color:#DC2626;font-size:11px;padding:3px 10px;border-radius:7px;font-weight:700">
                                Économie: {{ number_format($offre->prix - $offre->prix_promo, 0) }} DT
                            </span>
                        </div>
                    @else
                        <div class="price-big">{{ number_format($offre->prix, 0) }} DT</div>
                    @endif
                    <div class="text-muted small mt-1">par personne</div>

                    <hr style="border-color:#BAE6FD;margin:15px 0">

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Départ</span>
                        <span class="fw-semibold">{{ $offre->date_depart->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Retour</span>
                        <span class="fw-semibold">{{ $offre->date_retour->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Durée</span>
                        <span class="fw-semibold">{{ $offre->duree_jours }} jours</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Places dispo</span>
                        <span class="fw-bold {{ $offre->places_disponibles <= 3 ? 'text-danger' : 'text-success' }}">
                            {{ $offre->places_disponibles }}
                        </span>
                    </div>
                </div>

                @if($offre->places_disponibles <= 3 && $offre->places_disponibles > 0)
                <div class="alert mb-3" style="background:#FFFBEB;color:#92400E;border-radius:10px;font-size:13px">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Dernières places !</strong>
                </div>
                @endif

                @if($offre->places_disponibles > 0)
                    <a href="{{ route('reservations.create', $offre) }}"
                       class="btn btn-primary btn-lg w-100 mb-3"
                       style="border-radius:12px;padding:13px;font-size:15px">
                        <i class="bi bi-calendar-check-fill me-2"></i>Réserver maintenant
                    </a>
                @else
                    <button class="btn btn-secondary btn-lg w-100 mb-3" disabled
                            style="border-radius:12px;padding:13px">
                        <i class="bi bi-x-circle me-2"></i>Complet
                    </button>
                @endif

                <div class="text-center text-muted small mb-4">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    Paiement sécurisé • Annulation flexible
                </div>

                <div class="card p-3" style="background:#F8FAFC">
                    <div class="fw-semibold small mb-2">
                        <i class="bi bi-headset text-primary me-2"></i>Besoin d'aide ?
                    </div>
                    <p class="text-muted small mb-0">
                        📞 +216 71 XXX XXX<br>
                        ✉️ contact@traveldream.tn
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- Offres similaires --}}
    @if($offres_similaires->count() > 0)
    <div class="mt-5">
        <h3 class="fw-bold mb-4" style="font-family:var(--font-display)">Vous pourriez aussi aimer</h3>
        <div class="row g-4">
            @foreach($offres_similaires as $sim)
            <div class="col-md-4">
                <div class="card h-100">
                    @if($sim->image_principale)
                        <img src="{{ asset('storage/'.$sim->image_principale) }}"
                             class="card-img-top" style="height:170px;object-fit:cover">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center"
                             style="height:170px;background:linear-gradient(135deg,#0EA5E9,#8B5CF6)">
                            <span style="font-size:45px">🌍</span>
                        </div>
                    @endif
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1" style="font-size:13.5px">{{ $sim->titre }}</h6>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-geo-alt me-1"></i>{{ $sim->destination }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="color:var(--primary);font-size:15px;font-family:var(--font-display)">
                                {{ number_format($sim->prix_affichage, 0) }} DT
                            </span>
                            <a href="{{ route('offres.show', $sim) }}"
                               class="btn btn-outline-primary btn-sm" style="border-radius:8px">
                                Voir →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection