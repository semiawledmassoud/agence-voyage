<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Paiements — TravelDream</title>
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
        .table thead th { background:#0F172A; color:#9CA3AF; font-size:11px; text-transform:uppercase; letter-spacing:1px; padding:13px 16px; border:none; font-weight:600; }
        .table thead th:first-child { border-radius:10px 0 0 10px; }
        .table thead th:last-child { border-radius:0 10px 10px 0; }
        .table tbody td { padding:13px 16px; border-bottom:1px solid var(--border); vertical-align:middle; font-size:13.5px; }
        .table tbody tr:last-child td { border-bottom:none; }
        .badge-complete { background:#ECFDF5; color:#059669; font-size:11px; padding:4px 10px; border-radius:7px; font-weight:600; }
        .badge-pending  { background:#FFFBEB; color:#D97706; font-size:11px; padding:4px 10px; border-radius:7px; font-weight:600; }
        .badge-failed   { background:#FEF2F2; color:#DC2626; font-size:11px; padding:4px 10px; border-radius:7px; font-weight:600; }
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
                <li class="nav-item"><a class="nav-link" href="{{ route('reservations.index') }}">Réservations</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('paiement.historique') }}" style="color:var(--primary) !important">Paiements</a></li>
            </ul>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-secondary btn-sm">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="font-family:var(--font-display)">Historique des paiements</h3>
        <p class="text-muted mb-0 small">{{ $paiements->count() }} paiement(s)</p>
    </div>

    @if($paiements->isEmpty())
    <div class="card p-5 text-center">
        <div style="font-size:64px">💳</div>
        <h5 class="fw-bold mt-3 mb-2">Aucun paiement</h5>
        <p class="text-muted mb-4">Vous n'avez effectué aucun paiement.</p>
        <a href="{{ route('offres.index') }}" class="btn btn-primary px-5">
            Voir nos offres
        </a>
    </div>
    @else

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <div class="fw-bold" style="font-size:26px;color:var(--primary);font-family:var(--font-display)">
                    {{ $paiements->count() }}
                </div>
                <div class="text-muted small">Total paiements</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <div class="fw-bold" style="font-size:26px;color:#10B981;font-family:var(--font-display)">
                    {{ number_format($paiements->where('statut','complete')->sum('montant'), 0) }} DT
                </div>
                <div class="text-muted small">Montant total payé</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <div class="fw-bold" style="font-size:26px;color:#6366F1;font-family:var(--font-display)">
                    {{ $paiements->where('statut','complete')->count() }}
                </div>
                <div class="text-muted small">Paiements complétés</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Transaction</th>
                        <th>Offre</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $p)
                    <tr>
                        <td class="font-monospace" style="font-size:11.5px">
                            {{ $p->transaction_id ?? '—' }}
                        </td>
                        <td>
                            <div class="fw-semibold" style="font-size:13px">
                                {{ $p->reservation->offre->titre ?? 'N/A' }}
                            </div>
                            <div class="text-muted" style="font-size:11px">
                                {{ $p->reservation->offre->destination ?? '' }}
                            </div>
                        </td>
                        <td class="fw-bold" style="color:var(--primary)">
                            {{ number_format($p->montant, 0) }} DT
                        </td>
                        <td>
                            <span style="background:#F3F4F6;color:#6B7280;font-size:11px;padding:3px 8px;border-radius:6px;font-weight:600">
                                {{ strtoupper($p->methode) }}
                            </span>
                        </td>
                        <td>
                            @if($p->statut == 'complete')
                                <span class="badge-complete">✅ Complété</span>
                            @elseif($p->statut == 'en_attente')
                                <span class="badge-pending">⏳ En attente</span>
                            @else
                                <span class="badge-failed">❌ Échoué</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $p->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>