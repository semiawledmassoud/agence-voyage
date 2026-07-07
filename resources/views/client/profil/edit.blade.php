<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil — TravelDream</title>
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
        .form-control, .form-select { border-radius:9px; border:2px solid var(--border); padding:10px 14px; font-size:14px; }
        .form-control:focus, .form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(14,165,233,0.1); }
        .form-label { font-size:13px; font-weight:600; }
        .btn { font-family:var(--font); font-weight:600; border-radius:9px; }
        .btn-primary { background:linear-gradient(135deg,var(--primary),#0284C7); border:none; color:white; }
        .btn-primary:hover { background:linear-gradient(135deg,#0284C7,#0369A1); color:white; }
        .avatar-wrap { width:110px; height:110px; border-radius:20px; margin:0 auto; position:relative; cursor:pointer; }
        .avatar-img { width:100%; height:100%; object-fit:cover; border-radius:20px; border:3px solid var(--border); }
        .avatar-ph { width:110px; height:110px; border-radius:20px; background:linear-gradient(135deg,var(--primary),var(--secondary)); display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:44px; color:white; font-weight:800; }
        .avatar-edit { position:absolute; bottom:-5px; right:-5px; width:28px; height:28px; border-radius:8px; background:var(--primary); display:flex; align-items:center; justify-content:center; color:white; font-size:13px; }
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
            </ul>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-secondary btn-sm">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-4">

    <h3 class="fw-bold mb-4" style="font-family:var(--font-display)">Mon Profil</h3>

    <div class="row g-4">

        {{-- Photo + stats --}}
        <div class="col-md-4">
            <div class="card p-4 text-center">

                {{-- Photo --}}
                <div class="mb-3">
                    @if($user->photo)
                        <div class="avatar-wrap" onclick="document.getElementById('photoInput').click()">
                            <img src="{{ asset('storage/'.$user->photo) }}" class="avatar-img" id="avatarImg" alt="">
                            <div class="avatar-edit"><i class="bi bi-camera-fill"></i></div>
                        </div>
                    @else
                        <div class="avatar-ph mx-auto" onclick="document.getElementById('photoInput').click()" style="position:relative;cursor:pointer">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                            <div class="avatar-edit"><i class="bi bi-camera-fill"></i></div>
                        </div>
                    @endif
                </div>

                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ $user->email }}</p>
                <span style="background:linear-gradient(135deg,var(--primary),var(--secondary));color:white;font-size:12px;padding:5px 14px;border-radius:8px;font-weight:600">
                    Client
                </span>

                {{-- Formulaire photo --}}
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" id="photoForm">
                    @csrf @method('PATCH')
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="file" id="photoInput" name="photo" style="display:none"
                           accept="image/*" onchange="previewPhoto(this)">
                </form>

                <p class="text-muted small mt-3">Cliquez sur la photo pour la changer</p>

                <hr>

                {{-- Stats --}}
                <div class="row g-2">
                    <div class="col-4">
                        <div class="fw-bold" style="font-size:20px;color:var(--primary)">
                            {{ $user->reservations->count() }}
                        </div>
                        <div class="text-muted" style="font-size:11px">Réservations</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold" style="font-size:20px;color:#10B981">
                            {{ $user->reservations->where('statut','confirmee')->count() }}
                        </div>
                        <div class="text-muted" style="font-size:11px">Confirmées</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold" style="font-size:20px;color:#F59E0B">
                            {{ $user->reservations->where('statut','en_attente')->count() }}
                        </div>
                        <div class="text-muted" style="font-size:11px">En attente</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="col-md-8">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>
                    Modifier mes informations
                </h5>

                @if(session('success'))
                <div class="alert mb-3" style="background:#ECFDF5;color:#065F46;border-radius:10px;border:none">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert mb-3" style="background:#FEF2F2;color:#991B1B;border-radius:10px;border:none">
                    @foreach($errors->all() as $error)
                    <div style="font-size:13px">• {{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet *</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control"
                                   value="{{ old('telephone', $user->telephone) }}"
                                   placeholder="+216 XX XXX XXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control"
                                   value="{{ old('adresse', $user->adresse) }}"
                                   placeholder="Votre adresse">
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="fw-bold mb-1">
                        <i class="bi bi-shield-lock me-2 text-warning"></i>Changer le mot de passe
                    </h6>
                    <p class="text-muted small mb-3">Laissez vide pour ne pas changer</p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Minimum 8 caractères">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirmer</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Répéter le mot de passe">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-5 py-2">
                            <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            {{-- Dernières réservations --}}
            @if($user->reservations->count() > 0)
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Dernières réservations</h5>
                    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" style="font-size:13px">
                        <thead style="background:#0F172A">
                            <tr>
                                <th style="color:#9CA3AF;font-size:11px;text-transform:uppercase;padding:10px 12px;border:none">Référence</th>
                                <th style="color:#9CA3AF;font-size:11px;text-transform:uppercase;padding:10px 12px;border:none">Destination</th>
                                <th style="color:#9CA3AF;font-size:11px;text-transform:uppercase;padding:10px 12px;border:none">Montant</th>
                                <th style="color:#9CA3AF;font-size:11px;text-transform:uppercase;padding:10px 12px;border:none">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->reservations->take(5) as $res)
                            <tr>
                                <td class="font-monospace" style="font-size:11px;padding:10px 12px">{{ $res->reference }}</td>
                                <td style="padding:10px 12px">{{ $res->offre->destination ?? 'N/A' }}</td>
                                <td class="fw-bold" style="color:var(--primary);padding:10px 12px">{{ number_format($res->prix_total, 0) }} DT</td>
                                <td style="padding:10px 12px">
                                    @if($res->statut == 'confirmee')
                                        <span style="background:#ECFDF5;color:#059669;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:600">Confirmée</span>
                                    @elseif($res->statut == 'annulee')
                                        <span style="background:#FEF2F2;color:#DC2626;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:600">Annulée</span>
                                    @else
                                        <span style="background:#FFFBEB;color:#D97706;font-size:10px;padding:3px 8px;border-radius:6px;font-weight:600">En attente</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('avatarImg');
            if (img) {
                img.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('photoForm').submit();
    }
}
</script>
</body>
</html>