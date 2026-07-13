<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — TravelDream</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary:#0EA5E9; --secondary:#8B5CF6; --font:'DM Sans',sans-serif; }
        * { font-family: var(--font); }
        body { margin:0; padding:0; min-height:100vh; display:flex; overflow:hidden; }

        .auth-image { flex:1; position:relative; display:none; }
        @media(min-width:900px) { .auth-image { display:block; } }
        .auth-image img { width:100%; height:100%; object-fit:cover; }
        .auth-image-overlay {
            position:absolute; inset:0;
            background:linear-gradient(135deg,rgba(14,165,233,0.6) 0%,rgba(139,92,246,0.5) 100%);
        }
        .auth-image-content {
            position:absolute; bottom:50px; left:40px; right:40px; color:white;
        }
        .auth-image-title { font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:800; margin-bottom:10px; }
        .auth-image-sub { font-size:15px; opacity:0.85; }
        .auth-image-stats { display:flex; gap:24px; margin-top:24px; }
        .auth-stat-num { font-family:'Playfair Display',serif; font-size:22px; font-weight:800; }
        .auth-stat-lbl { font-size:11px; opacity:0.7; }

        .auth-form-wrap {
            width:100%; max-width:480px;
            background:#0F172A;
            display:flex; flex-direction:column;
            justify-content:center;
            padding:48px 44px;
            overflow-y:auto;
        }
        @media(max-width:899px) { .auth-form-wrap { max-width:100%; } }

        .auth-logo {
            font-family:'Playfair Display',serif;
            font-size:22px; font-weight:800; color:white;
            margin-bottom:40px; display:block; text-decoration:none;
        }
        .auth-logo span { color:var(--primary); }
        .auth-title { font-family:'Playfair Display',serif; font-size:1.9rem; font-weight:800; color:white; margin-bottom:6px; }
        .auth-sub { color:#64748B; font-size:14px; margin-bottom:32px; }

        .form-label { color:#94A3B8; font-size:12.5px; font-weight:600; letter-spacing:0.5px; margin-bottom:7px; text-transform:uppercase; }
        .input-wrap { position:relative; }
        .input-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#475569; font-size:15px; z-index:1; }
        .form-control {
            background:rgba(255,255,255,0.05);
            border:1.5px solid rgba(255,255,255,0.08);
            border-radius:11px; padding:12px 16px 12px 42px;
            color:white; font-size:14.5px; transition:all 0.2s; width:100%;
        }
        .form-control::placeholder { color:#334155; }
        .form-control:focus {
            background:rgba(255,255,255,0.08);
            border-color:var(--primary);
            box-shadow:0 0 0 3px rgba(14,165,233,0.12);
            color:white; outline:none;
        }

        .btn-submit {
            background:linear-gradient(135deg,var(--primary),var(--secondary));
            border:none; color:white; width:100%;
            padding:14px; border-radius:11px;
            font-weight:700; font-size:15px;
            transition:all 0.3s; cursor:pointer; margin-top:8px;
        }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(14,165,233,0.4); }

        .form-check-input { background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.15); }
        .form-check-label { color:#64748B; font-size:13.5px; }
        .auth-link { color:var(--primary); text-decoration:none; font-weight:600; }
        .auth-link:hover { color:#38BDF8; }
        .divider { border-color:rgba(255,255,255,0.07); margin:26px 0; }

        .error-box {
            background:rgba(239,68,68,0.1);
            border:1px solid rgba(239,68,68,0.2);
            border-radius:10px; padding:12px 16px;
            color:#FCA5A5; font-size:13.5px; margin-bottom:22px;
        }
    </style>
</head>
<body>

{{-- IMAGE GAUCHE --}}
<div class="auth-image">
    <img src="https://images.unsplash.com/photo-1530521954074-e64f6810b32d?w=1200&q=90" alt="Voyage">
    <div class="auth-image-overlay"></div>
    <div class="auth-image-content">
        <h2 class="auth-image-title">Le monde vous attend</h2>
        <p class="auth-image-sub">Connectez-vous et découvrez nos offres exclusives vers les plus belles destinations.</p>
        <div class="auth-image-stats">
            <div>
                <div class="auth-stat-num">50+</div>
                <div class="auth-stat-lbl">Destinations</div>
            </div>
            <div>
                <div class="auth-stat-num">1200+</div>
                <div class="auth-stat-lbl">Voyageurs</div>
            </div>
            <div>
                <div class="auth-stat-num">4.9★</div>
                <div class="auth-stat-lbl">Satisfaction</div>
            </div>
        </div>
    </div>
</div>

{{-- FORMULAIRE --}}
<div class="auth-form-wrap">
    <a href="/" class="auth-logo">✈ Travel<span>Dream</span></a>

    <h1 class="auth-title">Bon retour ! 👋</h1>
    <p class="auth-sub">Connectez-vous pour accéder à vos voyages</p>

    @if($errors->any())
    <div class="error-box">
        <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
    </div>
    @endif

    @if(session('error'))
    <div class="error-box">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="form-label">Adresse email</label>
            <div class="input-wrap">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}"
                       placeholder="votre@email.com" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Mot de passe</label>
            <div class="input-wrap">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Se souvenir de moi</label>
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
        </button>
    </form>

    <hr class="divider">

    <p class="text-center mb-0" style="color:#475569;font-size:14px">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="auth-link ms-1">S'inscrire gratuitement</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>