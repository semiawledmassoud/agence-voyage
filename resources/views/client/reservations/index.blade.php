<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations — TravelDream</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary:#0EA5E9; --secondary:#8B5CF6; --border:#E2E8F0; --font:'DM Sans',sans-serif; --font-display:'Playfair Display',serif; }
        * { font-family:var(--font); }
        body { background:#F0F9FF; }
        .navbar { background:rgba(255,255,255,0.97) !important; border-bottom:1px solid var(--border); position:sticky; top:0; z-index:999; }
        .navbar-brand { font-family:var(--font-display); font-size:20px; font-weight:800; color:#0F172A !important; }
        .navbar-brand span { color:var(--primary); }
        .nav-link { font-weight:500; font-size:14px; color:#64748B !important; padding:7px 13px !important; border-radius:8px; }
        .nav-link:hover { color:var(--primary) !important; background:#EFF6FF; }
        .card { border:1px solid var(--border); border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,0.05); }
        .btn { font-family:var(--font); font-weight:600; border-radius:9px; }
        .btn-primary { background:linear-gradient(135deg,var(--primary),#0284C7); border:none; color:white; }
        .btn-primary:hover { background:linear-gradient(135deg,#0284C7,#0369A1); color:white; }
        .badge-pending   { background:#FFFBEB; color:#D97706; font-size:11px; padding:5px 10px; border-radius:7px; font-weight:600; }
        .badge-confirmed { background:#ECFDF5; color:#059669; font-size:11px; padding:5px 10px; border-radius:7px; font-weight:600; }
        .badge-cancelled { background:#FEF2F2; color:#DC2626; font-size:11px; padding:5px 10px; border-radius:7px; font-weight:600; }
        .badge-finished  { background:#F3F4F6; color:#6B7280; font-size:11px; padding:5px 10px; border-radius:7px; font-weight:600; }
        .res-card { transition:transform 0.2s; }
        .res-card:hover { transform:translateY(-3px); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">✈ Travel<span>Dream</span></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('offres.index') }}">Destinations</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('reservations.index') }}" style="color:var(--primary) !important">Mes Réservations</a></li>
            </ul>
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted small">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-secondary btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="font-family:var(--font-display)">Mes Réservations</h3>
            <p class="text-muted mb-0 small">{{ $reservations->count() }} réservation(s)</p>
        </div>
        <a href="{{ route('offres.index') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle réservation
        </a>
    </div>

    @if(session('success'))
    <div class="alert mb-4" style="background:#ECFDF5;color:#065F46;border-radius:10px;border:none">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
    @endif

    @if($reservations->isEmpty())
    <div class="card p-5 text-center">
        <div style="font-size:64px">📭</div>
        <h5 class="fw-bold mt-3 mb-2">Aucune réservation</h5>
        <p class="text-muted mb-4">Vous n'avez pas encore réservé de voyage.</p>
        <a href="{{ route('offres.index') }}" class="btn btn-primary px-5">
            <i class="bi bi-map me-2"></i>Voir nos offres
        </a>
    </div>
    @else

    <div class="row g-4">
        @foreach($reservations as $res)
        <div class="col-md-6">
            <div class="card p-4 res-card h-100">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="fw-bold mb-1" style="font-size:15px">{{ $res->offre->titre }}</h6>
                        <p class="text-muted mb-0" style="font-size:12px">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $res->offre->destination }}, {{ $res->offre->pays }}
                        </p>
                    </div>
                    <span class="badge-{{ $res->statut == 'confirmee' ? 'confirmed' : ($res->statut == 'annulee' ? 'cancelled' : ($res->statut == 'terminee' ? 'finished' : 'pending')) }}">
                        @if($res->statut == 'confirmee') ✅ Confirmée
                        @elseif($res->statut == 'annulee') ❌ Annulée
                        @elseif($res->statut == 'terminee') 🏁 Terminée
                        @else ⏳ En attente
                        @endif
                    </span>
                </div>

                <hr style="border-color:#F1F5F9">

                {{-- Détails --}}
                <div class="row g-2 mb-3 small">
                    <div class="col-6">
                        <span class="text-muted">Référence</span>
                        <div class="fw-semibold font-monospace" style="font-size:11px">{{ $res->reference }}</div>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Personnes</span>
                        <div class="fw-semibold">{{ $res->nombre_personnes }}</div>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Départ</span>
                        <div class="fw-semibold">{{ $res->offre->date_depart->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Total payé</span>
                        <div class="fw-bold" style="color:var(--primary);font-size:15px">
                            {{ number_format($res->prix_total, 0) }} DT
                        </div>
                    </div>
                </div>

                {{-- Paiement status --}}
                @if($res->paiement)
                <div class="mb-3 p-2 rounded-2 small" style="background:#ECFDF5;color:#065F46">
                    <i class="bi bi-credit-card-fill me-1"></i>
                    Paiement effectué — {{ $res->paiement->transaction_id }}
                </div>
                @endif

                {{-- Actions --}}
                <div class="d-flex gap-2 mt-auto">
                    <a href="{{ route('reservations.show', $res) }}"
                       class="btn btn-sm btn-outline-primary" style="border-radius:8px">
                        <i class="bi bi-eye me-1"></i>Détails
                    </a>

                    @if($res->statut == 'en_attente')
                        @if(!$res->paiement)
                        <a href="{{ route('paiement.show', $res) }}"
                           class="btn btn-sm btn-success" style="border-radius:8px">
                            <i class="bi bi-credit-card me-1"></i>Payer
                        </a>
                        @endif
                        <form method="POST" action="{{ route('reservations.annuler', $res) }}"
                              onsubmit="return confirm('Annuler cette réservation ?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-danger" style="border-radius:8px">
                                Annuler
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    </div>

    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>