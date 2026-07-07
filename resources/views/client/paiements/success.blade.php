<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement réussi — TravelDream</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary:#0EA5E9; --secondary:#8B5CF6; --border:#E2E8F0; --font:'DM Sans',sans-serif; --font-display:'Playfair Display',serif; }
        * { font-family:var(--font); }
        body { background:#F0F9FF; min-height:100vh; display:flex; align-items:center; }
        .card { border:1px solid var(--border); border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.08); }
        .btn { font-family:var(--font); font-weight:600; border-radius:9px; }
        .btn-primary { background:linear-gradient(135deg,var(--primary),#0284C7); border:none; color:white; }
        .success-icon { width:90px; height:90px; border-radius:22px; background:linear-gradient(135deg,#10B981,#059669); display:flex; align-items:center; justify-content:center; font-size:42px; margin:0 auto 20px; }
        .amount { font-family:var(--font-display); font-size:3rem; font-weight:800; color:#10B981; }
        .info-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F1F5F9; font-size:13.5px; }
        .info-row:last-child { border-bottom:none; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-5 text-center">

                <div class="success-icon">🎉</div>

                <h2 class="fw-bold mb-2" style="font-family:var(--font-display);color:#059669">
                    Paiement réussi !
                </h2>
                <p class="text-muted mb-4">
                    Votre réservation a été confirmée avec succès.<br>
                    Un email de confirmation vous a été envoyé.
                </p>

                <div class="amount mb-1">
                    {{ number_format($reservation->paiement->montant, 0) }} DT
                </div>
                <p class="text-muted small mb-4">Montant payé</p>

                {{-- Récapitulatif --}}
                <div class="p-4 rounded-3 mb-4 text-start" style="background:#ECFDF5;border:1px solid #A7F3D0">
                    <h6 class="fw-bold mb-3" style="color:#065F46">Récapitulatif</h6>
                    <div class="info-row" style="border-color:#A7F3D0">
                        <span style="color:#065F46">Référence</span>
                        <span class="fw-bold font-monospace" style="font-size:12px">{{ $reservation->reference }}</span>
                    </div>
                    <div class="info-row" style="border-color:#A7F3D0">
                        <span style="color:#065F46">Offre</span>
                        <span class="fw-semibold">{{ $reservation->offre->titre }}</span>
                    </div>
                    <div class="info-row" style="border-color:#A7F3D0">
                        <span style="color:#065F46">Destination</span>
                        <span>{{ $reservation->offre->destination }}</span>
                    </div>
                    <div class="info-row" style="border-color:#A7F3D0">
                        <span style="color:#065F46">Départ</span>
                        <span>{{ $reservation->offre->date_depart->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row" style="border-color:transparent">
                        <span style="color:#065F46">Transaction</span>
                        <span class="font-monospace" style="font-size:11px">{{ $reservation->paiement->transaction_id }}</span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('reservations.index') }}" class="btn btn-primary btn-lg"
                       style="padding:12px">
                        <i class="bi bi-calendar-check me-2"></i>Mes réservations
                    </a>
                    <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-map me-2"></i>Voir d'autres offres
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-link text-muted small">
                        Retour à l'accueil
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>