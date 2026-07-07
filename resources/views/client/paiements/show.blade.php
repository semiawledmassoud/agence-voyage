<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement — TravelDream</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary:#0EA5E9; --secondary:#8B5CF6; --border:#E2E8F0; --font:'DM Sans',sans-serif; --font-display:'Playfair Display',serif; }
        * { font-family:var(--font); }
        body { background:#F0F9FF; min-height:100vh; display:flex; flex-direction:column; }
        .navbar { background:rgba(255,255,255,0.97) !important; border-bottom:1px solid var(--border); }
        .navbar-brand { font-family:var(--font-display); font-size:20px; font-weight:800; color:#0F172A !important; }
        .navbar-brand span { color:var(--primary); }
        .card { border:1px solid var(--border); border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.05); }
        .btn { font-family:var(--font); font-weight:600; border-radius:10px; }
        .btn-pay { background:linear-gradient(135deg,#10B981,#059669); border:none; color:white; width:100%; padding:15px; border-radius:12px; font-weight:700; font-size:16px; transition:all 0.3s; }
        .btn-pay:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(16,185,129,0.4); color:white; }
        .total-price { font-family:var(--font-display); font-size:3rem; font-weight:800; color:var(--primary); line-height:1; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">✈ Travel<span>Dream</span></a>
        <div class="ms-auto">
            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
        </div>
    </div>
</nav>

<div class="container py-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-5">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <div style="width:70px;height:70px;border-radius:18px;background:linear-gradient(135deg,#10B981,#059669);display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 16px">
                        💳
                    </div>
                    <h3 class="fw-bold mb-1" style="font-family:var(--font-display)">Paiement sécurisé</h3>
                    <p class="text-muted small">Référence : <strong class="font-monospace">{{ $reservation->reference }}</strong></p>
                </div>

                {{-- Récapitulatif --}}
                <div class="p-4 rounded-3 mb-4" style="background:#EFF6FF;border:2px solid #BAE6FD">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Offre</span>
                        <span class="fw-semibold">{{ $reservation->offre->titre }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Destination</span>
                        <span>{{ $reservation->offre->destination }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Départ</span>
                        <span>{{ $reservation->offre->date_depart->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Personnes</span>
                        <span>{{ $reservation->nombre_personnes }}</span>
                    </div>
                    <hr style="border-color:#BAE6FD">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold" style="font-size:15px">Total à payer</span>
                        <span class="total-price">{{ number_format($reservation->prix_total, 0) }} DT</span>
                    </div>
                </div>

                {{-- Sécurité --}}
                <div class="p-3 rounded-3 mb-4" style="background:#F8FAFC;border:1px dashed var(--border)">
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <span class="small text-muted"><i class="bi bi-shield-check text-success me-1"></i>100% Sécurisé</span>
                        <span class="small text-muted"><i class="bi bi-lock-fill text-primary me-1"></i>Chiffré SSL</span>
                        <span class="small text-muted"><i class="bi bi-credit-card text-warning me-1"></i>Stripe</span>
                    </div>
                </div>

                {{-- Bouton payer --}}
                <form method="POST" action="{{ route('paiement.process', $reservation) }}">
                    @csrf
                    <button type="submit" class="btn-pay mb-3">
                        <i class="bi bi-lock-fill me-2"></i>
                        Payer {{ number_format($reservation->prix_total, 0) }} DT maintenant
                    </button>
                </form>

                <a href="{{ route('reservations.show', $reservation) }}"
                   class="btn btn-link text-muted w-100 text-center small">
                    ← Annuler et retourner à la réservation
                </a>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>