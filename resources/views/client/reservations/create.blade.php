<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver — {{ $offre->titre }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0EA5E9;
            --secondary: #8B5CF6;
            --border: #E2E8F0;
            --font: 'DM Sans', sans-serif;
            --font-display: 'Playfair Display', serif;
        }
        * { font-family: var(--font); }
        body { background: #F0F9FF; }
        .card { border: 1px solid var(--border); border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
        .form-control, .form-select { border-radius: 9px; border: 2px solid var(--border); padding: 10px 14px; font-size: 14px; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,0.1); }
        .form-label { font-size: 13px; font-weight: 600; }
        .btn { font-family: var(--font); font-weight: 600; border-radius: 9px; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), #0284C7); border: none; color: white; }
        .btn-primary:hover { background: linear-gradient(135deg, #0284C7, #0369A1); color: white; }
        .navbar { background: rgba(255,255,255,0.97) !important; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 999; }
        .navbar-brand { font-family: var(--font-display); font-size: 20px; font-weight: 800; color: #0F172A !important; }
        .navbar-brand span { color: var(--primary); }
        .price-summary { background: linear-gradient(135deg, #F0F9FF, #EFF6FF); border: 2px solid #BAE6FD; border-radius: 14px; padding: 20px; }
        .price-total { font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; color: var(--primary); }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">✈ Travel<span>Dream</span></a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('offres.show', $offre) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
        </div>
    </div>
</nav>

<div class="container py-4">

    {{-- Titre --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="font-family: var(--font-display)">
            Réserver : {{ $offre->titre }}
        </h3>
        <p class="text-muted mb-0">
            <i class="bi bi-geo-alt-fill text-primary me-1"></i>
            {{ $offre->destination }}, {{ $offre->pays }}
        </p>
    </div>

    {{-- Alertes --}}
    @if(session('error'))
    <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#FEF2F2;color:#991B1B">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#FEF2F2;color:#991B1B">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
            <li style="font-size:13.5px">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row g-4">

        {{-- Formulaire --}}
        <div class="col-lg-7">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person-fill me-2 text-primary"></i>
                    Informations de contact
                </h5>

                <form method="POST" action="{{ route('reservations.store') }}" id="reservationForm">
                    @csrf
                    <input type="hidden" name="offre_id" value="{{ $offre->id }}">

                    {{-- Nombre de personnes --}}
                    <div class="mb-4">
                        <label class="form-label">Nombre de personnes *</label>
                        <select name="nombre_personnes" class="form-select" id="nbPersonnes" onchange="calculerPrix()">
                            @for($i = 1; $i <= min($offre->places_disponibles, 10); $i++)
                            <option value="{{ $i }}" {{ old('nombre_personnes') == $i ? 'selected' : '' }}>
                                {{ $i }} personne(s)
                            </option>
                            @endfor
                        </select>
                        <small class="text-muted">{{ $offre->places_disponibles }} place(s) disponible(s)</small>
                    </div>

                    {{-- Nom --}}
                    <div class="mb-3">
                        <label class="form-label">Nom complet *</label>
                        <input type="text" name="nom_contact" class="form-control"
                               value="{{ old('nom_contact', auth()->user()->name) }}"
                               placeholder="Votre nom complet" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email_contact" class="form-control"
                               value="{{ old('email_contact', auth()->user()->email) }}"
                               placeholder="votre@email.com" required>
                    </div>

                    {{-- Téléphone --}}
                    <div class="mb-3">
                        <label class="form-label">Téléphone *</label>
                        <input type="text" name="telephone_contact" class="form-control"
                               value="{{ old('telephone_contact', auth()->user()->telephone ?? '') }}"
                               placeholder="+216 XX XXX XXX" required>
                    </div>

                    {{-- Notes --}}
                    <div class="mb-4">
                        <label class="form-label">Notes / Demandes spéciales</label>
                        <textarea name="notes" class="form-control" rows="3"
                                  placeholder="Allergies alimentaires, besoins spéciaux...">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Récapitulatif prix --}}
                    <div class="price-summary mb-4">
                        <div class="d-flex justify-content-between mb-2" style="font-size:14px">
                            <span class="text-muted">Prix par personne</span>
                            <span class="fw-semibold">{{ number_format($offre->prix_affichage, 0) }} DT</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size:14px">
                            <span class="text-muted">Nombre de personnes</span>
                            <span class="fw-semibold" id="nbDisplay">1</span>
                        </div>
                        <hr style="border-color:#BAE6FD">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="font-size:16px">Total à payer</span>
                            <span class="price-total" id="prixTotal">
                                {{ number_format($offre->prix_affichage, 0) }} DT
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100"
                            style="padding:13px;font-size:15px">
                        <i class="bi bi-calendar-check-fill me-2"></i>
                        Confirmer la réservation
                    </button>
                </form>
            </div>
        </div>

        {{-- Récapitulatif offre --}}
        <div class="col-lg-5">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-map-fill me-2 text-primary"></i>
                    Récapitulatif
                </h5>

                @if($offre->image_principale)
                    <img src="{{ asset('storage/'.$offre->image_principale) }}"
                         class="w-100 rounded-3 mb-3"
                         style="height:160px;object-fit:cover">
                @else
                    <div class="w-100 rounded-3 mb-3 d-flex align-items-center justify-content-center"
                         style="height:120px;background:linear-gradient(135deg,#0EA5E9,#8B5CF6)">
                        <span style="font-size:50px">🌍</span>
                    </div>
                @endif

                <h6 class="fw-bold mb-1">{{ $offre->titre }}</h6>
                <p class="text-muted small mb-3">
                    <i class="bi bi-geo-alt me-1"></i>{{ $offre->destination }}, {{ $offre->pays }}
                </p>

                <div class="small">
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #F1F5F9">
                        <span class="text-muted">Type</span>
                        <span class="fw-semibold">{{ ucfirst($offre->type) }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #F1F5F9">
                        <span class="text-muted">Date départ</span>
                        <span class="fw-semibold">{{ $offre->date_depart->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #F1F5F9">
                        <span class="text-muted">Date retour</span>
                        <span class="fw-semibold">{{ $offre->date_retour->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #F1F5F9">
                        <span class="text-muted">Durée</span>
                        <span class="fw-semibold">{{ $offre->duree_jours }} jours</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Places restantes</span>
                        <span class="fw-bold text-success">{{ $offre->places_disponibles }}</span>
                    </div>
                </div>
            </div>

            <div class="card p-3" style="background:#ECFDF5;border:1px solid #A7F3D0">
                <p class="mb-1 small fw-semibold" style="color:#065F46">
                    <i class="bi bi-shield-check me-2"></i>Paiement sécurisé
                </p>
                <p class="mb-1 small" style="color:#065F46">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>Annulation possible
                </p>
                <p class="mb-0 small" style="color:#065F46">
                    <i class="bi bi-envelope-check me-2"></i>Confirmation par email
                </p>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const prixUnitaire = {{ $offre->prix_affichage }};

    function calculerPrix() {
        const nb = parseInt(document.getElementById('nbPersonnes').value) || 1;
        const total = prixUnitaire * nb;
        document.getElementById('nbDisplay').textContent = nb;
        document.getElementById('prixTotal').textContent = total.toLocaleString('fr-FR') + ' DT';
    }

    // Initialiser
    calculerPrix();
</script>

</body>
</html>