@extends('layouts.app')
@section('title', 'Accueil')

@push('styles')
<style>
    main > .container { max-width: 100%; padding: 0; }
    .hero { position: relative; height: 88vh; min-height: 520px; overflow: hidden; }
    .hero-slide { position: absolute; inset: 0; background-size: cover; background-position: center; opacity: 0; transition: opacity 0.8s ease; }
    .hero-slide.active { opacity: 1; }
    .hero-slide::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to right, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.2) 60%, transparent 100%); }
    .hero-content { position: absolute; top: 50%; left: 8%; transform: translateY(-50%); color: white; max-width: 560px; z-index: 2; }
    .hero-badge { display: inline-block; background: rgba(255,255,255,0.18); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); color: white; padding: 5px 15px; border-radius: 20px; font-size: 12.5px; font-weight: 600; margin-bottom: 18px; }
    .hero-title { font-family: var(--font-display); font-size: clamp(2.2rem,5vw,3.8rem); font-weight: 800; line-height: 1.1; margin-bottom: 14px; }
    .hero-sub { font-size: 15.5px; opacity: 0.85; margin-bottom: 28px; line-height: 1.65; }
    .btn-hero { background: var(--primary); color: white; border: none; padding: 13px 28px; border-radius: 11px; font-weight: 700; font-size: 14.5px; text-decoration: none; transition: all 0.3s; display: inline-block; }
    .btn-hero:hover { background: var(--primary-dark); color: white; transform: translateY(-2px); }
    .btn-hero-outline { background: rgba(255,255,255,0.14); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.45); color: white; padding: 13px 28px; border-radius: 11px; font-weight: 700; font-size: 14.5px; text-decoration: none; transition: all 0.3s; display: inline-block; }
    .btn-hero-outline:hover { background: rgba(255,255,255,0.22); color: white; }
    .slider-dots { position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%); display: flex; gap: 7px; z-index: 3; }
    .s-dot { width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.38); cursor: pointer; transition: all 0.3s; border: none; padding: 0; }
    .s-dot.active { width: 22px; border-radius: 4px; background: white; }
    .s-arrow { position: absolute; top: 50%; z-index: 3; transform: translateY(-50%); background: rgba(255,255,255,0.14); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.28); color: white; width: 46px; height: 46px; border-radius: 11px; font-size: 17px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
    .s-arrow:hover { background: rgba(255,255,255,0.24); }
    .s-prev { left: 18px; }
    .s-next { right: 18px; }
    .search-wrap { padding: 0 5%; margin-top: -38px; position: relative; z-index: 10; }
    .search-box { background: white; border-radius: 18px; padding: 18px 22px; box-shadow: 0 18px 55px rgba(0,0,0,0.13); }
    .section { padding: 65px 5%; }
    .section-title { font-family: var(--font-display); font-size: 2rem; font-weight: 800; }
    .offer-img-wrap { position: relative; overflow: hidden; border-radius: 13px 13px 0 0; }
    .offer-img-wrap img { height: 215px; width: 100%; object-fit: cover; transition: transform 0.4s; }
    .card:hover .offer-img-wrap img { transform: scale(1.06); }
    .video-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; }
    .video-card { border-radius: 14px; overflow: hidden; box-shadow: 0 3px 18px rgba(0,0,0,0.09); }
    .video-card video { width: 100%; height: 190px; object-fit: cover; display: block; }
    .video-info { padding: 13px 15px; background: white; }
    .stats-bg { background: linear-gradient(135deg, #0F172A, #1E293B); padding: 58px 5%; color: white; }
    .stat-num { font-family: var(--font-display); font-size: 2.8rem; font-weight: 800; color: var(--primary); }
</style>
@endpush

@section('content')

{{-- HERO SLIDER --}}
<div class="hero" id="heroSlider">
    @if(isset($slides) && $slides->count() > 0)
        @foreach($slides as $i => $slide)
        <div class="hero-slide {{ $i === 0 ? 'active' : '' }}"
             style="background-image:url('{{ asset('storage/'.$slide->fichier) }}')">
            <div class="hero-content">
                <div class="hero-badge">✈ TravelDream</div>
                <h1 class="hero-title">{{ $slide->titre }}</h1>
                @if($slide->description)
                    <p class="hero-sub">{{ $slide->description }}</p>
                @endif
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('offres.index') }}" class="btn-hero">Explorer les offres</a>
                    @auth
                    <a href="{{ route('reservations.index') }}" class="btn-hero-outline">Mes réservations</a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="hero-slide active" style="background:linear-gradient(135deg,#0F172A 0%,#1E3A5F 50%,#0EA5E9 100%)">
            <div class="hero-content">
                <div class="hero-badge">✈ Bienvenue sur TravelDream</div>
                <h1 class="hero-title">Explorez le monde avec style</h1>
                <p class="hero-sub">Des voyages inoubliables vers les plus belles destinations.<br>Réservez en toute sécurité et profitez de prix exceptionnels.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('offres.index') }}" class="btn-hero">Voir nos offres</a>
                    @guest
                    <a href="{{ route('register') }}" class="btn-hero-outline">S'inscrire gratuitement</a>
                    @endguest
                </div>
            </div>
        </div>
    @endif
    <button class="s-arrow s-prev" onclick="changeSlide(-1)"><i class="bi bi-chevron-left"></i></button>
    <button class="s-arrow s-next" onclick="changeSlide(1)"><i class="bi bi-chevron-right"></i></button>
    <div class="slider-dots" id="sliderDots"></div>
</div>

{{-- BARRE RECHERCHE --}}
<div class="search-wrap">
    <div class="search-box">
        <form method="GET" action="{{ route('offres.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:12px"><i class="bi bi-geo-alt text-primary me-1"></i>Destination</label>
                <input type="text" name="destination" class="form-control" placeholder="Paris, Istanbul...">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:12px"><i class="bi bi-tag text-primary me-1"></i>Type</label>
                <select name="type" class="form-select">
                    <option value="">Tous</option>
                    <option value="voyage">Voyage</option>
                    <option value="circuit">Circuit</option>
                    <option value="sejour">Séjour</option>
                    <option value="aventure">Aventure</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:12px"><i class="bi bi-calendar text-primary me-1"></i>Date départ</label>
                <input type="date" name="date_depart" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:12px"><i class="bi bi-cash text-primary me-1"></i>Budget max (DT)</label>
                <input type="number" name="prix_max" class="form-control" placeholder="5000">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-search me-2"></i>Rechercher
                </button>
            </div>
        </form>
    </div>
</div>

{{-- OFFRES FEATURED --}}
@if(isset($offres_featured) && $offres_featured->count() > 0)
<div class="section">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <p class="text-primary fw-bold mb-1" style="font-size:12.5px">⭐ SÉLECTION PREMIUM</p>
            <h2 class="section-title mb-0">Nos meilleures offres</h2>
        </div>
        <a href="{{ route('offres.index') }}" class="btn btn-outline-primary">Voir tout <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    <div class="row g-4">
        @foreach($offres_featured as $offre)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="offer-img-wrap">
                    @if($offre->image_principale)
                        <img src="{{ asset('storage/'.$offre->image_principale) }}" alt="{{ $offre->titre }}">
                    @else
                        <div style="height:215px;background:linear-gradient(135deg,#0EA5E9,#8B5CF6);display:flex;align-items:center;justify-content:center;font-size:55px">🌍</div>
                    @endif
                    <div style="position:absolute;top:10px;left:10px;display:flex;gap:5px">
                        <span style="background:rgba(0,0,0,0.65);color:white;font-size:10.5px;padding:3px 9px;border-radius:7px">{{ $offre->type }}</span>
                        @if($offre->featured)<span style="background:rgba(245,158,11,0.9);color:white;font-size:10.5px;padding:3px 9px;border-radius:7px">⭐</span>@endif
                    </div>
                    @if($offre->prix_promo)<span style="position:absolute;top:10px;right:10px;background:#EF4444;color:white;font-size:10.5px;padding:3px 9px;border-radius:7px">PROMO</span>@endif
                </div>
                <div class="card-body d-flex flex-column p-4">
                    <h5 class="fw-bold mb-2" style="font-size:15px">{{ $offre->titre }}</h5>
                    <div class="text-muted small mb-1"><i class="bi bi-geo-alt-fill text-primary me-1"></i>{{ $offre->destination }}, {{ $offre->pays }}</div>
                    <div class="d-flex gap-3 text-muted small mb-3">
                        <span><i class="bi bi-calendar3 me-1"></i>{{ $offre->date_depart->format('d/m/Y') }}</span>
                        <span><i class="bi bi-clock me-1"></i>{{ $offre->duree_jours }}j</span>
                        <span><i class="bi bi-people me-1"></i>{{ $offre->places_disponibles }}</span>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div>
                            @if($offre->prix_promo)
                                <div class="text-muted text-decoration-line-through small">{{ number_format($offre->prix, 0) }} DT</div>
                                <div class="price-tag" style="color:#10B981">{{ number_format($offre->prix_promo, 0) }} DT</div>
                            @else
                                <div class="price-tag">{{ number_format($offre->prix, 0) }} DT</div>
                            @endif
                            <div class="text-muted" style="font-size:11px">/personne</div>
                        </div>
                        <a href="{{ route('offres.show', $offre) }}" class="btn btn-primary px-4">Voir →</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- VIDEOS --}}
@if(isset($videos) && $videos->count() > 0)
<div class="section" style="background:#F8F9FF">
    <p class="text-primary fw-bold mb-1" style="font-size:12.5px">🎬 DÉCOUVRIR</p>
    <h2 class="section-title mb-4">Nos destinations en vidéo</h2>
    <div class="video-grid">
        @foreach($videos as $video)
        <div class="video-card">
            <video controls preload="metadata">
                <source src="{{ asset('storage/'.$video->fichier) }}" type="video/mp4">
            </video>
            <div class="video-info">
                <h6 class="fw-bold mb-1" style="font-size:14px">{{ $video->titre }}</h6>
                @if($video->description)<p class="text-muted small mb-0">{{ $video->description }}</p>@endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- STATS --}}
<div class="stats-bg">
    <div class="row g-4 text-center">
        <div class="col-6 col-md-3"><div class="stat-num">50+</div><div class="mt-1 opacity-70">Destinations</div></div>
        <div class="col-6 col-md-3"><div class="stat-num">1000+</div><div class="mt-1 opacity-70">Clients satisfaits</div></div>
        <div class="col-6 col-md-3"><div class="stat-num">4.9★</div><div class="mt-1 opacity-70">Satisfaction</div></div>
        <div class="col-6 col-md-3"><div class="stat-num">10ans</div><div class="mt-1 opacity-70">Expérience</div></div>
    </div>
</div>

{{-- CTA --}}
<div style="background:linear-gradient(135deg,var(--primary),var(--secondary));padding:75px 5%;text-align:center">
    <p class="text-white opacity-75 fw-semibold mb-2" style="font-size:12.5px">PRÊT À PARTIR ?</p>
    <h2 class="section-title text-white mb-4">Votre prochain voyage commence ici</h2>
    <a href="{{ route('offres.index') }}" class="btn btn-light btn-lg fw-bold px-5 py-3" style="border-radius:12px">
        Découvrir nos offres <i class="bi bi-arrow-right ms-2"></i>
    </a>
</div>

@endsection

@push('scripts')
<script>
let cur = 0;
const slides = document.querySelectorAll('.hero-slide');
const dotsEl = document.getElementById('sliderDots');
slides.forEach((_, i) => {
    const d = document.createElement('button');
    d.className = 's-dot' + (i === 0 ? ' active' : '');
    d.onclick = () => goTo(i);
    dotsEl.appendChild(d);
});
function goTo(n) {
    slides[cur].classList.remove('active');
    dotsEl.children[cur].classList.remove('active');
    cur = (n + slides.length) % slides.length;
    slides[cur].classList.add('active');
    dotsEl.children[cur].classList.add('active');
}
function changeSlide(d) { goTo(cur + d); }
if (slides.length > 1) setInterval(() => changeSlide(1), 5000);
</script>
@endpush