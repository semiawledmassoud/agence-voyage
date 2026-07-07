<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TravelDream')</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0EA5E9;
            --primary-dark: #0284C7;
            --secondary: #8B5CF6;
            --accent: #F59E0B;
            --success: #10B981;
            --dark: #0F172A;
            --border: #E2E8F0;
            --font: 'DM Sans', sans-serif;
            --font-display: 'Playfair Display', serif;
        }
        * { font-family: var(--font); }
        body { background: #F0F9FF; }

        /* NAVBAR */
        .navbar {
            background: rgba(255,255,255,0.97) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 10px 0;
            position: sticky; top: 0; z-index: 999;
        }
        .navbar-brand {
            font-family: var(--font-display);
            font-size: 22px; font-weight: 800; color: var(--dark) !important;
        }
        .navbar-brand span { color: var(--primary); }
        .nav-link {
            font-weight: 500; font-size: 14px;
            color: #64748B !important; padding: 7px 13px !important;
            border-radius: 8px; transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; background: #EFF6FF; }
        .btn-nav { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border: none; border-radius: 9px; padding: 7px 18px; font-weight: 600; font-size: 13.5px; text-decoration: none; }
        .btn-nav:hover { color: white; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(14,165,233,0.35); }

        /* CARDS */
        .card { border: 1px solid var(--border); border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: transform 0.3s, box-shadow 0.3s; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,0.09); }

        /* BUTTONS */
        .btn { font-family: var(--font); font-weight: 600; border-radius: 9px; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: none; color: white; }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary-dark), #0369A1); color: white; transform: translateY(-1px); }

        /* FORMS */
        .form-control, .form-select { border-radius: 9px; border: 2px solid var(--border); padding: 9px 13px; font-size: 13.5px; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,0.1); }
        .form-label { font-size: 13px; font-weight: 600; }

        /* ALERTS */
        .alert { border-radius: 11px; border: none; font-size: 13.5px; }

        /* USER AVATAR */
        .user-av {
            width: 34px; height: 34px; border-radius: 9px;
            object-fit: cover;
        }
        .user-av-ph {
            width: 34px; height: 34px; border-radius: 9px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 13px;
        }

        /* CHATBOT */
        #chatbot-btn {
            position: fixed; bottom: 26px; right: 26px; z-index: 1000;
            width: 56px; height: 56px; border-radius: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none; font-size: 22px; color: white;
            box-shadow: 0 6px 22px rgba(14,165,233,0.4);
            cursor: pointer; transition: all 0.3s;
        }
        #chatbot-btn:hover { transform: scale(1.1) rotate(-5deg); }
        #chatbot-window {
            position: fixed; bottom: 96px; right: 26px;
            width: 355px; height: 470px;
            background: white; border-radius: 18px;
            box-shadow: 0 18px 55px rgba(0,0,0,0.18);
            z-index: 999; display: none; flex-direction: column;
            border: 1px solid var(--border); overflow: hidden;
        }
        .chat-header { background: linear-gradient(135deg, var(--primary), var(--secondary)); padding: 15px 18px; }
        .chat-msgs { flex: 1; overflow-y: auto; padding: 14px; background: #F8FAFC; }
        .chat-msgs::-webkit-scrollbar { width: 3px; }
        .chat-msgs::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
        .msg-bot { background: white; border: 1px solid var(--border); padding: 9px 13px; border-radius: 13px 13px 13px 3px; margin-bottom: 9px; max-width: 82%; font-size: 13px; }
        .msg-user { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 9px 13px; border-radius: 13px 13px 3px 13px; margin-bottom: 9px; max-width: 82%; margin-left: auto; font-size: 13px; }
        .chat-input-area { padding: 10px; border-top: 1px solid var(--border); display: flex; gap: 7px; }

        /* FOOTER */
        footer { background: var(--dark); color: #94A3B8; padding: 45px 0 22px; margin-top: 60px; }
        footer h5, footer h6 { color: white; }
        footer a { color: #94A3B8 !important; text-decoration: none; }
        footer a:hover { color: var(--primary) !important; }
        .price-tag { font-family: var(--font-display); font-size: 22px; color: var(--primary); font-weight: 700; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">✈ Travel<span>Dream</span></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="bi bi-house me-1"></i>Accueil</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('offres*') ? 'active' : '' }}" href="{{ route('offres.index') }}"><i class="bi bi-map me-1"></i>Destinations</a></li>
                @auth
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('reservations*') ? 'active' : '' }}" href="{{ route('reservations.index') }}"><i class="bi bi-calendar-check me-1"></i>Réservations</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('paiement.historique') ? 'active' : '' }}" href="{{ route('paiement.historique') }}"><i class="bi bi-receipt me-1"></i>Paiements</a></li>
                @endauth
            </ul>
            <ul class="navbar-nav align-items-center gap-2">
                @auth
                <li class="nav-item dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/'.auth()->user()->photo) }}" class="user-av" alt="">
                        @else
                            <div class="user-av-ph">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        @endif
                        <span class="fw-semibold small d-none d-lg-block" style="color:#0F172A">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down small text-muted"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" style="border-radius:13px;min-width:195px;padding:5px;border:1px solid var(--border)">
                        <li class="px-3 py-2">
                            <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                            <div class="text-muted" style="font-size:11px">{{ auth()->user()->email }}</div>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item rounded-2" href="{{ route('profil.edit') }}"><i class="bi bi-person-circle me-2 text-primary"></i>Mon Profil</a></li>
                        <li><a class="dropdown-item rounded-2" href="{{ route('reservations.index') }}"><i class="bi bi-calendar2-check me-2 text-success"></i>Réservations</a></li>
                        <li><a class="dropdown-item rounded-2" href="{{ route('paiement.historique') }}"><i class="bi bi-receipt me-2 text-warning"></i>Paiements</a></li>
                        @if(auth()->user()->isAdmin())
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item rounded-2 text-danger" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                        @endif
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item rounded-2 text-danger w-100 text-start border-0 bg-transparent">
                                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Connexion</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="btn-nav btn btn-sm">S'inscrire</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main>
    <div class="container py-4">
        @if(session('success'))
        <div class="alert mb-4" style="background:#ECFDF5;color:#065F46">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert mb-4" style="background:#FEF2F2;color:#991B1B">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @yield('content')
    </div>
</main>

@auth
@if(auth()->user()->isClient())
<button id="chatbot-btn" onclick="toggleChat()">💬</button>
<div id="chatbot-window">
    <div class="chat-header d-flex justify-content-between align-items-center">
        <div>
            <div class="text-white fw-bold small">🤖 Assistant TravelDream</div>
            <div class="text-white opacity-70" style="font-size:11px">En ligne</div>
        </div>
        <button onclick="toggleChat()" style="background:none;border:none;color:white;font-size:16px">✕</button>
    </div>
    <div class="chat-msgs" id="chat-msgs">
        <div class="msg-bot">👋 Bonjour <strong>{{ auth()->user()->name }}</strong> ! Comment puis-je vous aider ?</div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="chat-input" class="form-control form-control-sm"
               placeholder="Votre question..."
               onkeypress="if(event.key==='Enter')sendChat()">
        <button class="btn btn-primary btn-sm px-3" onclick="sendChat()">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>
</div>
@endif
@endauth

<footer>
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <h5 class="mb-3" style="font-family:var(--font-display)">✈ TravelDream</h5>
                <p class="small">Votre partenaire de voyage de confiance depuis 10 ans.</p>
            </div>
            <div class="col-lg-4">
                <h6 class="mb-3">Navigation</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="mb-2"><a href="{{ route('offres.index') }}">Nos Offres</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="mb-3">Contact</h6>
                <p class="small mb-1"><i class="bi bi-envelope me-2" style="color:var(--primary)"></i>contact@traveldream.tn</p>
                <p class="small mb-1"><i class="bi bi-telephone me-2" style="color:var(--primary)"></i>+216 71 XXX XXX</p>
                <p class="small"><i class="bi bi-geo-alt me-2" style="color:var(--primary)"></i>Tunis, Tunisie</p>
            </div>
        </div>
        <hr style="border-color:#1E293B">
        <p class="text-center small mb-0">© {{ date('Y') }} TravelDream. Tous droits réservés.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleChat() {
    const w = document.getElementById('chatbot-window');
    w.style.display = w.style.display === 'flex' ? 'none' : 'flex';
}
function sendChat() {
    const input = document.getElementById('chat-input');
    const msgs  = document.getElementById('chat-msgs');
    const msg   = input.value.trim();
    if (!msg) return;
    msgs.innerHTML += `<div class="msg-user">${msg}</div>`;
    input.value = '';
    const tid = 'typing' + Date.now();
    msgs.innerHTML += `<div class="msg-bot" id="${tid}">⏳ ...</div>`;
    msgs.scrollTop = msgs.scrollHeight;
    fetch('{{ route("chatbot.repondre") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify({ message: msg })
    })
    .then(r => r.json())
    .then(data => { document.getElementById(tid).innerHTML = data.reponse; msgs.scrollTop = msgs.scrollHeight; })
    .catch(() => { document.getElementById(tid).textContent = 'Erreur de connexion.'; });
}
</script>
@stack('scripts')
</body>
</html>