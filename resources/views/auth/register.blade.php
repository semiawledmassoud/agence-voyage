<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — TravelDream</title>
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
        .auth-image-overlay { position:absolute; inset:0; background:linear-gradient(135deg,rgba(139,92,246,0.65) 0%,rgba(14,165,233,0.5) 100%); }
        .auth-image-content { position:absolute; bottom:50px; left:40px; right:40px; color:white; }
        .auth-image-title { font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:800; margin-bottom:10px; }
        .auth-image-sub { font-size:15px; opacity:0.85; }
        .benefits { margin-top:24px; }
        .benefit { display:flex; align-items:center; gap:10px; margin-bottom:12px; font-size:14px; }
        .benefit-icon { width:32px; height:32px; border-radius:8px; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .auth-form-wrap { width:100%; max-width:480px; background:#0F172A; display:flex; flex-direction:column; justify-content:center; padding:40px 44px; overflow-y:auto; }
        @media(max-width:899px) { .auth-form-wrap { max-width:100%; } }
        .auth-logo { font-family:'Playfair Display',serif; font-size:22px; font-weight:800; color:white; margin-bottom:36px; display:block; text-decoration:none; }
        .auth-logo span { color:var(--primary); }
        .auth-title { font-family:'Playfair Display',serif; font-size:1.9rem; font-weight:800; color:white; margin-bottom:6px; }
        .auth-sub { color:#64748B; font-size:14px; margin-bottom:28px; }
        .form-label { color:#94A3B8; font-size:12.5px; font-weight:600; letter-spacing:0.5px; margin-bottom:7px; text-transform:uppercase; }
        .input-wrap { position:relative; }
        .input-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#475569; font-size:15px; z-index:1; }
        .form-control { background:rgba(255,255,255,0.05); border:1.5px solid rgba(255,255,255,0.08); border-radius:11px; padding:12px 16px 12px 42px; color:white; font-size:14.5px; transition:all 0.2s; width:100%; }
        .form-control::placeholder { color:#334155; }
        .form-control:focus { background:rgba(255,255,255,0.08); border-color:var(--primary); box-shadow:0 0 0 3px rgba(14,165,233,0.12); color:white; outline:none; }
        .btn-submit { background:linear-gradient(135deg,var(--primary),var(--secondary)); border:none; color:white; width:100%; padding:14px; border-radius:11px; font-weight:700; font-size:15px; transition:all 0.3s; cursor:pointer; margin-top:8px; }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(14,165,233,0.4); }
        .auth-link { color:var(--primary); text-decoration:none; font-weight:600; }
        .auth-link:hover { color:#38BDF8; }
        .divider { border-color:rgba(255,255,255,0.07); margin:22px 0; }
        .error-box { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:10px; padding:12px 16px; color:#FCA5A5; font-size:13.5px; margin-bottom:20px; }
        .role-box { background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.18); border-radius:10px; padding:12px 16px; margin-bottom:20px; }
    </style>
</head>
<body>

{{-- IMAGE GAUCHE --}}
<div class="auth-image">
    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1200&q=90" alt="Voyage">
    <div class="auth-image-overlay"></div>
    <div class="auth-image-content">
        <h2 class="auth-image-title">Rejoignez l'aventure</h2>
        <p class="auth-image-sub">Créez votre compte gratuit et accédez à des centaines d'offres de voyage exclusives.</p>
        <div class="benefits">
            <div class="benefit">
                <div class="benefit-icon">✈️</div>
                <span>Accès à 50+ destinations</span>
            </div>
            <div class="benefit">
                <div class="benefit-icon">💳</div>
                <span>Paiement sécurisé en ligne</span>
            </div>
            <div class="benefit">
                <div class="benefit-icon">📧</div>
                <span>Confirmations par email</span>
            </div>
            <div class="benefit">
                <div class="benefit-icon">🤖</div>
                <span>Chatbot assistant 24/7</span>
            </div>
        </div>
    </div>
</div>

{{-- FORMULAIRE --}}
<div class="auth-form-wrap">
    <a href="/" class="auth-logo">✈ Travel<span>Dream</span></a>

    <h1 class="auth-title">Créer un compte </h1>
    <p class="auth-sub">Rejoignez plus de 1200 voyageurs satisfaits</p>

    @if($errors->any())
    <div class="error-box">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $e)
            <li style="font-size:13px">{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom complet</label>
            <div class="input-wrap">
                <i class="bi bi-person input-icon"></i>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" placeholder="Mohamed Ali" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Adresse email</label>
            <div class="input-wrap">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" placeholder="votre@email.com" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <div class="input-wrap">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" class="form-control"
                       placeholder="Minimum 8 caractères" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmer le mot de passe</label>
            <div class="input-wrap">
                <i class="bi bi-lock-fill input-icon"></i>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Répétez le mot de passe" required>
            </div>
        </div>

       

        <button type="submit" class="btn-submit">
            <i class="bi bi-person-plus me-2"></i>Créer mon compte gratuitement
        </button>
    </form>

    <hr class="divider">

    <p class="text-center mb-0" style="color:#475569;font-size:14px">
        Déjà inscrit ?
        <a href="{{ route('login') }}" class="auth-link ms-1">Se connecter</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>