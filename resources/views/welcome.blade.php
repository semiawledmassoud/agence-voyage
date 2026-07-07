<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelDream — Agence de Voyage</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0EA5E9;
            --secondary: #8B5CF6;
            --accent: #F59E0B;
            --font: 'DM Sans', sans-serif;
            --font-display: 'Playfair Display', serif;
        }
        * { font-family: var(--font); margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0F172A; color: white; overflow-x: hidden; }

        /* NAVBAR */
        .navbar-wrap {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 18px 5%;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(0,0,0,0.3); backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            transition: all 0.3s;
        }
        .navbar-wrap.scrolled { background: rgba(15,23,42,0.95); }
        .nav-logo { font-family: var(--font-display); font-size: 24px; font-weight: 800; color: white; text-decoration: none; }
        .nav-logo span { color: var(--primary); }
        .nav-btns { display: flex; gap: 10px; align-items: center; }
        .btn-login { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1.5px solid rgba(255,255,255,0.25); color: white; padding: 9px 22px; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; }
        .btn-login:hover { background: rgba(255,255,255,0.18); color: white; border-color: rgba(255,255,255,0.5); }
        .btn-register { background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; color: white; padding: 9px 22px; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(14,165,233,0.4); color: white; }

        /* HERO */
        .hero {
            min-height: 100vh;
            position: relative; overflow: hidden;
            display: flex; align-items: center;
        }

        /* VIDEO BACKGROUND */
        .hero-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            opacity: 0;
            transition: opacity 1.5s ease;
        }
        .hero-video.loaded { opacity: 1; }

        /* IMAGE FALLBACK pendant chargement vidéo */
        .hero-bg {
            position: absolute; inset: 0;
            background-image: url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920&q=90');
            background-size: cover; background-position: center;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute; inset: 0; z-index: 1;
            background: linear-gradient(
                to right,
                rgba(0,0,0,0.82) 0%,
                rgba(0,0,0,0.5) 50%,
                rgba(0,0,0,0.15) 100%
            );
        }
        .hero-overlay-bottom {
            position: absolute; bottom: 0; left: 0; right: 0; height: 200px; z-index: 1;
            background: linear-gradient(to top, #0F172A, transparent);
        }
        .hero-content { position: relative; z-index: 2; max-width: 620px; padding: 120px 5% 80px; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(14,165,233,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(14,165,233,0.4); color: #38BDF8; padding: 7px 18px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-bottom: 24px; }
        .hero-title { font-family: var(--font-display); font-size: clamp(3rem, 6vw, 5.5rem); font-weight: 900; line-height: 1.05; margin-bottom: 20px; text-shadow: 0 2px 20px rgba(0,0,0,0.5); }
        .hero-title .highlight { background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-sub { font-size: 17px; color: rgba(255,255,255,0.78); line-height: 1.75; margin-bottom: 36px; max-width: 500px; }
        .hero-buttons { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 50px; }
        .btn-hero-p { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 15px; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-hero-p:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(14,165,233,0.4); color: white; }
        .btn-hero-o { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1.5px solid rgba(255,255,255,0.3); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 600; font-size: 15px; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-hero-o:hover { background: rgba(255,255,255,0.18); color: white; border-color: rgba(255,255,255,0.6); }
        .hero-stats { display: flex; gap: 30px; flex-wrap: wrap; }
        .stat-item { text-align: center; }
        .stat-num { font-family: var(--font-display); font-size: 30px; font-weight: 800; line-height: 1; }
        .stat-lbl { font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 4px; }
        .stat-div { width: 1px; background: rgba(255,255,255,0.15); align-self: stretch; margin: 0 5px; }

        /* Bouton muet vidéo */
        .video-mute-btn {
            position: absolute; bottom: 30px; right: 30px; z-index: 3;
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);
            border: 1.5px solid rgba(255,255,255,0.25);
            color: white; font-size: 16px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s;
        }
        .video-mute-btn:hover { background: rgba(255,255,255,0.25); }

        /* CARDS FLOTTANTES */
        .floating-cards { position: absolute; right: 5%; top: 50%; transform: translateY(-50%); z-index: 2; display: none; }
        @media(min-width: 1200px) { .floating-cards { display: block; } }
        .f-card { background: rgba(255,255,255,0.08); backdrop-filter: blur(25px); border: 1px solid rgba(255,255,255,0.12); border-radius: 18px; padding: 22px; width: 270px; margin-bottom: 14px; }
        .f-card-icon { width: 42px; height: 42px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .f-card-title { font-weight: 700; font-size: 13.5px; }
        .f-card-sub { color: rgba(255,255,255,0.5); font-size: 11.5px; }
        .f-card-price { font-family: var(--font-display); font-size: 20px; font-weight: 800; }

        /* DESTINATIONS */
        .section-dest { padding: 80px 5%; background: #0F172A; }
        .s-label { font-size: 12px; font-weight: 700; color: var(--primary); letter-spacing: 2.5px; text-transform: uppercase; margin-bottom: 10px; }
        .s-title { font-family: var(--font-display); font-size: clamp(1.8rem, 3.5vw, 2.8rem); font-weight: 800; margin-bottom: 8px; }
        .s-sub { color: #64748B; font-size: 14.5px; margin-bottom: 40px; }
        .dest-card { border-radius: 16px; overflow: hidden; position: relative; cursor: pointer; transition: transform 0.3s, box-shadow 0.3s; aspect-ratio: 3/4; }
        @media(min-width: 768px) { .dest-card { aspect-ratio: 2/3; } }
        .dest-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .dest-img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s; }
        .dest-card:hover .dest-img { transform: scale(1.08); }
        .dest-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.88) 0%, rgba(0,0,0,0.1) 55%, transparent 100%); }
        .dest-info { position: absolute; bottom: 0; left: 0; right: 0; padding: 20px; }
        .dest-name { font-family: var(--font-display); font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .dest-price { font-size: 12.5px; color: rgba(255,255,255,0.7); }
        .dest-price strong { color: var(--accent); font-size: 15px; }
        .dest-badge { position: absolute; top: 12px; right: 12px; background: rgba(245,158,11,0.9); color: white; font-size: 10.5px; padding: 3px 9px; border-radius: 7px; font-weight: 700; }

        /* FEATURES */
        .section-feat { padding: 80px 5%; background: #080D14; }
        .feat-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 28px 22px; text-align: center; transition: all 0.3s; height: 100%; }
        .feat-card:hover { background: rgba(14,165,233,0.06); border-color: rgba(14,165,233,0.2); transform: translateY(-4px); }
        .feat-icon { width: 58px; height: 58px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px; }
        .feat-title { font-weight: 700; font-size: 15px; margin-bottom: 8px; }
        .feat-text { color: #64748B; font-size: 13px; line-height: 1.65; }

        /* TESTIMONIALS */
        .section-test { padding: 80px 5%; background: #0F172A; }
        .test-card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 28px; height: 100%; }
        .test-stars { color: var(--accent); font-size: 14px; margin-bottom: 14px; }
        .test-text { color: #94A3B8; font-size: 14px; line-height: 1.7; margin-bottom: 18px; font-style: italic; }
        .test-author { display: flex; align-items: center; gap: 12px; }
        .test-avatar { width: 42px; height: 42px; border-radius: 11px; object-fit: cover; }
        .test-name { font-weight: 700; font-size: 14px; }
        .test-dest { color: #64748B; font-size: 12px; }

        /* CTA */
        .section-cta {
            padding: 0; position: relative; overflow: hidden; min-height: 450px;
            display: flex; align-items: center;
        }
        .cta-bg { position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1920&q=85'); background-size: cover; background-position: center; }
        .cta-bg-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.65); }
        .cta-content { position: relative; z-index: 2; padding: 80px 5%; text-align: center; width: 100%; }
        .cta-title { font-family: var(--font-display); font-size: clamp(2rem,4vw,3.5rem); font-weight: 900; margin-bottom: 16px; }
        .cta-sub { color: rgba(255,255,255,0.75); font-size: 16px; margin-bottom: 36px; }

        /* FOOTER */
        footer { background: #080D14; padding: 55px 5% 25px; border-top: 1px solid rgba(255,255,255,0.05); }
        .f-logo { font-family: var(--font-display); font-size: 22px; font-weight: 800; margin-bottom: 12px; }
        .f-logo span { color: var(--primary); }
        footer a { color: #64748B; text-decoration: none; transition: color 0.2s; font-size: 13.5px; }
        footer a:hover { color: var(--primary); }
        .f-social { display: flex; gap: 10px; margin-top: 16px; }
        .f-social a { width: 36px; height: 36px; border-radius: 9px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-size: 15px; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<div class="navbar-wrap" id="navbar">
    <a href="/" class="nav-logo">✈ Travel<span>Dream</span></a>
    <div class="nav-btns">
        <a href="{{ route('login') }}" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
        </a>
        <a href="{{ route('register') }}" class="btn-register">
            <i class="bi bi-rocket-takeoff-fill me-1"></i>Commencer
        </a>
    </div>
</div>

{{-- HERO --}}
<section class="hero">

    {{-- Fallback image (visible pendant le chargement de la vidéo) --}}
    <div class="hero-bg" id="heroBg"></div>

    {{-- VIDEO BACKGROUND PRO --}}
    <video
        class="hero-video"
        id="heroVideo"
        autoplay
        muted
        loop
        playsinline
        poster="https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920&q=90"
    >
        {{-- Vidéo principale : plage tropicale aérienne --}}
        <source src="https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-the-sea-and-a-tropical-beach-4024-large.mp4" type="video/mp4">
        {{-- Fallback 2 : survol de ville --}}
        <source src="https://assets.mixkit.co/videos/preview/mixkit-flying-above-white-clouds-in-the-sky-4016-large.mp4" type="video/mp4">
    </video>

    <div class="hero-overlay"></div>
    <div class="hero-overlay-bottom"></div>

    <div class="hero-content">
        <div class="hero-badge">
            <i class="bi bi-stars"></i>
            Agence de voyage #1 en Tunisie
        </div>
        <h1 class="hero-title">
            Voyagez vers<br>
            l'<span class="highlight">extraordinaire</span>
        </h1>
        <p class="hero-sub">
            Découvrez des destinations de rêve avec notre agence de confiance.
            Réservez en ligne, payez en sécurité, et partez l'esprit serein.
        </p>
        <div class="hero-buttons">
            <a href="{{ route('register') }}" class="btn-hero-p">
                <i class="bi bi-rocket-takeoff-fill"></i>
                Commencer l'aventure
            </a>
            <a href="{{ route('login') }}" class="btn-hero-o">
                <i class="bi bi-play-circle-fill"></i>
                Voir nos offres
            </a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-num">50+</div>
                <div class="stat-lbl">Destinations</div>
            </div>
            <div class="stat-div"></div>
            <div class="stat-item">
                <div class="stat-num">1200+</div>
                <div class="stat-lbl">Voyageurs</div>
            </div>
            <div class="stat-div"></div>
            <div class="stat-item">
                <div class="stat-num">4.9★</div>
                <div class="stat-lbl">Satisfaction</div>
            </div>
            <div class="stat-div"></div>
            <div class="stat-item">
                <div class="stat-num">10ans</div>
                <div class="stat-lbl">Expérience</div>
            </div>
        </div>
    </div>

    {{-- Bouton muet/son vidéo --}}
    <button class="video-mute-btn" id="muteBtn" onclick="toggleMute()" title="Son on/off">
        <i class="bi bi-volume-mute-fill" id="muteIcon"></i>
    </button>

    {{-- Floating Cards --}}
    <div class="floating-cards">
        <div class="f-card">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="f-card-icon" style="background:linear-gradient(135deg,#0EA5E9,#8B5CF6)">🗼</div>
                <div>
                    <div class="f-card-title">Voyage à Paris</div>
                    <div class="f-card-sub">7 jours • France</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="f-card-price" style="color:#0EA5E9">1 200 DT</div>
                <span style="background:rgba(16,185,129,0.15);color:#10B981;font-size:11px;padding:4px 10px;border-radius:7px;font-weight:600">✅ Dispo</span>
            </div>
        </div>
        <div class="f-card">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="f-card-icon" style="background:linear-gradient(135deg,#F59E0B,#EF4444)">🏝️</div>
                <div>
                    <div class="f-card-title">Maldives Paradis</div>
                    <div class="f-card-sub">8 jours • Maldives</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div style="color:#64748B;font-size:11px;text-decoration:line-through">4 200 DT</div>
                    <div class="f-card-price" style="color:#10B981">3 800 DT</div>
                </div>
                <span style="background:rgba(239,68,68,0.15);color:#EF4444;font-size:11px;padding:4px 10px;border-radius:7px;font-weight:600">🔥 PROMO</span>
            </div>
        </div>
        <div class="f-card" style="background:rgba(14,165,233,0.1);border-color:rgba(14,165,233,0.2)">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-shield-check text-success"></i>
                <span style="font-size:13px;font-weight:600">Paiement sécurisé</span>
            </div>
            <div style="color:#64748B;font-size:12px">Stripe • Visa • Mastercard</div>
        </div>
    </div>
</section>

{{-- DESTINATIONS --}}
<section class="section-dest">
    <div class="s-label">✈ DESTINATIONS POPULAIRES</div>
    <h2 class="s-title">Voyages coup de cœur</h2>
    <p class="s-sub">Les destinations que nos voyageurs adorent</p>

    <div class="row g-3">
        @php
        $dests = [
            ['Paris','France','1 200','https://images.unsplash.com/photo-1502602898536-47ad22581b52?w=600&q=80',''],
            ['Istanbul','Turquie','950','https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=600&q=80',''],
            ['Maldives','Océan Indien','3 800','https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80','🔥 PROMO'],
            ['Rome','Italie','880','https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=600&q=80',''],
            ['Bali','Indonésie','1 600','https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80',''],
            ['Dubai','Émirats','2 100','https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80',''],
        ];
        @endphp
        @foreach($dests as $d)
        <div class="col-6 col-md-4 col-lg-2">
            <div class="dest-card">
                <img src="{{ $d[3] }}" class="dest-img" alt="{{ $d[0] }}" loading="lazy">
                <div class="dest-overlay"></div>
                @if($d[4])<div class="dest-badge">{{ $d[4] }}</div>@endif
                <div class="dest-info">
                    <div class="dest-name">{{ $d[0] }}</div>
                    <div class="dest-price">{{ $d[1] }} • <strong>{{ $d[2] }} DT</strong></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- FEATURES --}}
<section class="section-feat">
    <div class="text-center mb-5">
        <div class="s-label">💡 NOS AVANTAGES</div>
        <h2 class="s-title">Pourquoi TravelDream ?</h2>
    </div>
    <div class="row g-4">
        @php
        $feats = [
            ['🌍','50+ Destinations','De l\'Europe à l\'Asie en passant par l\'Afrique.',['#0EA5E9','#0284C7']],
            ['💳','Paiement Sécurisé','Stripe & PayPal. Vos données sont protégées.',['#8B5CF6','#6D28D9']],
            ['🤖','Chatbot 24/7','Assistant IA disponible à toute heure.',['#10B981','#059669']],
            ['📧','Emails Auto','Confirmations et rappels instantanés.',['#F59E0B','#D97706']],
            ['📱','Suivi En Ligne','Gérez vos réservations depuis votre espace.',['#EF4444','#DC2626']],
            ['🏆','10 ans d\'XP','Une équipe passionnée et expérimentée.',['#6366F1','#4F46E5']],
        ];
        @endphp
        @foreach($feats as $f)
        <div class="col-md-4 col-lg-2">
            <div class="feat-card">
                <div class="feat-icon" style="background:linear-gradient(135deg,{{ $f[3][0] }},{{ $f[3][1] }})">{{ $f[0] }}</div>
                <div class="feat-title">{{ $f[1] }}</div>
                <div class="feat-text">{{ $f[2] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="section-test">
    <div class="text-center mb-5">
        <div class="s-label">⭐ TÉMOIGNAGES</div>
        <h2 class="s-title">Ce que disent nos clients</h2>
    </div>
    <div class="row g-4">
        @php
        $tests = [
            ['"Un voyage à Paris absolument parfait ! L\'organisation était impeccable, le guide exceptionnel. Je recommande TravelDream à 100%."','Mohamed A.','Paris, France','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80'],
            ['"Les Maldives, un rêve devenu réalité grâce à TravelDream. Tout était inclus, aucun souci. On repart l\'année prochaine !"','Fatma B.','Maldives','https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80'],
            ['"Istanbul est magnifique ! Le séjour était bien organisé et le prix très correct. Service client au top. Merci !"','Karim M.','Istanbul, Turquie','https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&q=80'],
        ];
        @endphp
        @foreach($tests as $t)
        <div class="col-md-4">
            <div class="test-card">
                <div class="test-stars">★★★★★</div>
                <p class="test-text">{{ $t[0] }}</p>
                <div class="test-author">
                    <img src="{{ $t[3] }}" class="test-avatar" alt="">
                    <div>
                        <div class="test-name">{{ $t[1] }}</div>
                        <div class="test-dest"><i class="bi bi-geo-alt me-1" style="color:var(--primary)"></i>{{ $t[2] }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section class="section-cta">
    <div class="cta-bg"></div>
    <div class="cta-bg-overlay"></div>
    <div class="cta-content">
        <div class="s-label" style="color:#38BDF8">🚀 REJOIGNEZ-NOUS</div>
        <h2 class="cta-title">Votre aventure commence maintenant</h2>
        <p class="cta-sub">Créez votre compte gratuitement et accédez à des centaines d'offres exclusives</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('register') }}" class="btn-hero-p" style="font-size:16px;padding:15px 36px">
                <i class="bi bi-rocket-takeoff-fill"></i>Créer mon compte
            </a>
            <a href="{{ route('login') }}" class="btn-hero-o" style="font-size:16px;padding:15px 36px">
                <i class="bi bi-box-arrow-in-right"></i>Se connecter
            </a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="f-logo">✈ Travel<span>Dream</span></div>
            <p style="color:#64748B;font-size:13.5px;line-height:1.7">Votre partenaire voyage de confiance depuis 10 ans. Des destinations exceptionnelles à des prix imbattables.</p>
            <div class="f-social">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-youtube"></i></a>
            </div>
        </div>
        <div class="col-md-2">
            <div style="font-weight:700;margin-bottom:14px;font-size:14px">Liens</div>
            <ul class="list-unstyled">
                <li class="mb-2"><a href="{{ route('login') }}">Connexion</a></li>
                <li class="mb-2"><a href="{{ route('register') }}">S'inscrire</a></li>
            </ul>
        </div>
        <div class="col-md-3">
            <div style="font-weight:700;margin-bottom:14px;font-size:14px">Destinations</div>
            <ul class="list-unstyled" style="color:#64748B;font-size:13.5px">
                <li class="mb-1">🇫🇷 Paris, France</li>
                <li class="mb-1">🇹🇷 Istanbul, Turquie</li>
                <li class="mb-1">🇮🇹 Rome, Italie</li>
                <li class="mb-1">🌴 Maldives</li>
                <li class="mb-1">🇦🇪 Dubai, Émirats</li>
            </ul>
        </div>
        <div class="col-md-3">
            <div style="font-weight:700;margin-bottom:14px;font-size:14px">Contact</div>
            <p style="color:#64748B;font-size:13.5px;line-height:1.9">
                <i class="bi bi-envelope me-2" style="color:var(--primary)"></i>contact@traveldream.tn<br>
                <i class="bi bi-telephone me-2" style="color:var(--primary)"></i>+216 71 XXX XXX<br>
                <i class="bi bi-geo-alt me-2" style="color:var(--primary)"></i>Tunis, Tunisie<br>
                <i class="bi bi-clock me-2" style="color:var(--primary)"></i>Lun–Ven 8h–18h
            </p>
        </div>
    </div>
    <hr style="border-color:rgba(255,255,255,0.05)">
    <p class="text-center mb-0" style="color:#334155;font-size:13px">
        © {{ date('Y') }} TravelDream. Tous droits réservés.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
    });

    // VIDEO HERO — affichage fluide au chargement
    const video = document.getElementById('heroVideo');

    video.addEventListener('canplaythrough', () => {
        video.classList.add('loaded');
    });

    // Si la vidéo est déjà prête (cache)
    if (video.readyState >= 3) {
        video.classList.add('loaded');
    }

    // Bouton muet / son
    function toggleMute() {
        const v = document.getElementById('heroVideo');
        const icon = document.getElementById('muteIcon');
        v.muted = !v.muted;
        icon.className = v.muted ? 'bi bi-volume-mute-fill' : 'bi bi-volume-up-fill';
    }

    // Autoplay policy fallback : certains navigateurs bloquent autoplay
    video.play().catch(() => {
        // Si autoplay bloqué, afficher juste le poster/image
        video.style.display = 'none';
    });
</script>
</body>
</html>