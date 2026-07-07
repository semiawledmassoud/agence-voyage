<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') · Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{
  --c:#22C55E;--c2:#16A34A;--cl:#DCFCE7;
  --bg:#F0FDF4;--w:250px;--h:62px;
  --tx:#111827;--tx2:#6B7280;--tx3:#9CA3AF;
  --bd:#E5E7EB;--wh:#fff;
  --sh:0 1px 3px rgba(0,0,0,.06),0 2px 10px rgba(0,0,0,.04);
}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
body{background:var(--bg);color:var(--tx)}
a{text-decoration:none;color:inherit}

.sb{
  position:fixed;top:0;left:0;width:var(--w);height:100vh;
  background:var(--wh);border-right:1px solid var(--bd);
  display:flex;flex-direction:column;z-index:300;
}
.sb-hd{padding:20px 18px;border-bottom:1px solid var(--bd)}
.sb-logo{display:flex;align-items:center;gap:12px;margin-bottom:18px}
.sb-logo-i{
  width:40px;height:40px;border-radius:12px;
  background:linear-gradient(135deg,var(--c),#4ADE80);
  display:flex;align-items:center;justify-content:center;
  font-size:18px;color:#fff;box-shadow:0 4px 14px rgba(34,197,94,.35);
}
.sb-logo-n{font-size:16px;font-weight:800;color:var(--tx)}
.sb-logo-s{font-size:10px;color:var(--tx3);font-weight:600;letter-spacing:1px;text-transform:uppercase}
.sb-me{
  display:flex;align-items:center;gap:10px;
  padding:10px 12px;border-radius:12px;background:var(--bg);
}
.sb-me-av{
  width:34px;height:34px;border-radius:50%;
  background:linear-gradient(135deg,var(--c),#4ADE80);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-weight:700;font-size:13px;flex-shrink:0;
}
.sb-me-n{font-size:13px;font-weight:700}
.sb-me-r{font-size:10.5px;color:var(--tx3)}

.sb-nav{flex:1;overflow-y:auto;padding:10px 14px 0;scrollbar-width:none}
.sb-nav::-webkit-scrollbar{width:0}
.sb-sec{font-size:10px;font-weight:700;color:var(--tx3);letter-spacing:1.2px;text-transform:uppercase;padding:14px 8px 6px}

.sb-lnk{
  display:flex;align-items:center;gap:11px;
  padding:9px 12px;border-radius:11px;margin-bottom:2px;
  color:var(--tx2);font-size:13.5px;font-weight:600;transition:all .15s;
}
.sb-lnk:hover{background:var(--bg);color:var(--c2)}
.sb-lnk.on{background:var(--c);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,.3)}
.sb-lnk i{font-size:16px;width:20px;text-align:center;flex-shrink:0}
.sb-n{margin-left:auto;background:#EF4444;color:#fff;font-size:10px;font-weight:700;padding:1px 7px;border-radius:20px}
.sb-lnk.on .sb-n{background:rgba(255,255,255,.25)}

.sb-ft{padding:14px;border-top:1px solid var(--bd)}
.sb-ft a,.sb-ft button{
  display:flex;align-items:center;gap:10px;width:100%;
  padding:9px 12px;border-radius:10px;border:none;background:transparent;
  color:var(--tx2);font-size:13px;font-weight:600;text-align:left;cursor:pointer;transition:all .15s;
}
.sb-ft a:hover,.sb-ft button:hover{background:var(--bg)}
.sb-ft .out:hover{background:#FEF2F2;color:#DC2626}

.mn{margin-left:var(--w);min-height:100vh;display:flex;flex-direction:column}

.tb{
  height:var(--h);background:var(--wh);border-bottom:1px solid var(--bd);
  padding:0 28px;display:flex;align-items:center;justify-content:space-between;
  position:sticky;top:0;z-index:200;box-shadow:var(--sh);
}
.tb-tt{font-size:19px;font-weight:800;color:var(--tx)}
.tb-bc{font-size:11.5px;color:var(--tx3);display:flex;gap:5px;align-items:center;margin-top:2px}
.tb-bc a{color:var(--c2);font-weight:600}
.tb-r{display:flex;align-items:center;gap:8px}
.tb-b{
  width:40px;height:40px;border-radius:50%;
  background:var(--wh);border:1px solid var(--bd);
  display:flex;align-items:center;justify-content:center;
  color:var(--tx2);font-size:15px;cursor:pointer;transition:all .15s;position:relative;
}
.tb-b:hover{border-color:var(--c);color:var(--c);background:var(--cl)}
.tb-dot{position:absolute;top:8px;right:8px;width:7px;height:7px;border-radius:50%;background:#EF4444;border:2px solid #fff}
.tb-p{
  display:flex;align-items:center;gap:9px;padding:5px 14px 5px 5px;
  border-radius:50px;background:var(--wh);border:1px solid var(--bd);cursor:pointer;transition:all .15s;
}
.tb-p:hover{border-color:var(--c);background:var(--cl)}
.tb-pav{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--c),#4ADE80);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px}

.pg{padding:22px 28px;flex:1}

.card{background:var(--wh);border:1px solid var(--bd);border-radius:16px;box-shadow:var(--sh)}
.card-h{padding:18px 20px;border-bottom:1px solid var(--bd);display:flex;align-items:center;justify-content:space-between}
.card-t{font-size:15px;font-weight:800}
.card-s{font-size:12px;color:var(--tx3);margin-top:2px}

.kpi{background:var(--wh);border:1px solid var(--bd);border-radius:16px;padding:20px;box-shadow:var(--sh);position:relative;overflow:hidden;transition:transform .2s}
.kpi:hover{transform:translateY(-3px)}
.kpi-i{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:14px}
.kpi-v{font-size:28px;font-weight:800;margin-bottom:4px}
.kpi-l{font-size:11.5px;font-weight:600;color:var(--tx3);text-transform:uppercase;letter-spacing:.4px;margin-bottom:8px}
.kpi-s{font-size:12px;font-weight:600;display:flex;align-items:center;gap:4px}
.kpi-g{position:absolute;bottom:-15px;right:-10px;font-size:72px;opacity:.04}
.bars{display:flex;align-items:flex-end;gap:3px;height:30px;margin-top:10px}
.bar{flex:1;border-radius:2px;min-height:3px}

.tbl{width:100%;border-collapse:separate;border-spacing:0}
.tbl th{padding:11px 15px;font-size:11px;font-weight:700;color:var(--tx3);text-transform:uppercase;letter-spacing:.5px;background:#F9FAFB;border-bottom:1px solid var(--bd)}
.tbl td{padding:13px 15px;font-size:13.5px;border-bottom:1px solid #F3F4F6;vertical-align:middle}
.tbl tr:last-child td{border-bottom:none}
.tbl tr:hover td{background:#F9FAF9}

.bx{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:600;padding:4px 10px;border-radius:20px}
.bx::before{content:'';width:5px;height:5px;border-radius:50%}
.ok{background:#F0FDF4;color:#15803D}.ok::before{background:#15803D}
.er{background:#FEF2F2;color:#B91C1C}.er::before{background:#B91C1C}
.wa{background:#FFFBEB;color:#B45309}.wa::before{background:#B45309}
.gr{background:#F4F4F5;color:#52525B}.gr::before{background:#52525B}

.form-control,.form-select{border-radius:10px;border:1.5px solid var(--bd);padding:10px 14px;font-size:13.5px;font-family:'Inter',sans-serif;background:#fff;transition:all .2s}
.form-control:focus,.form-select:focus{border-color:var(--c);box-shadow:0 0 0 3px rgba(34,197,94,.1);outline:none}
.form-label{font-size:12.5px;font-weight:700;margin-bottom:6px}

.btn{font-family:'Inter',sans-serif;font-weight:700;border-radius:10px;font-size:13.5px;transition:all .18s}
.btn-primary,.btn-p{background:var(--c);border:none;color:#fff}
.btn-primary:hover,.btn-p:hover{background:var(--c2);color:#fff;transform:translateY(-1px)}
.btn-g{background:var(--wh);border:1.5px solid var(--bd);color:var(--tx2)}
.btn-g:hover{border-color:var(--c);color:var(--c2);background:var(--cl)}
.btn-success{background:#16A34A;border:none;color:#fff}
.btn-success:hover{background:#15803D;color:#fff}
.btn-danger{background:#DC2626;border:none;color:#fff}
.btn-danger:hover{background:#B91C1C;color:#fff}
.btn-warning{background:#D97706;border:none;color:#fff}
.btn-warning:hover{background:#B45309;color:#fff}
.btn-outline-primary{border:1.5px solid var(--c);color:var(--c2)}
.btn-outline-primary:hover{background:var(--c);color:#fff}

.alert{border-radius:12px;border:none;font-size:13.5px}
.alert-success{background:#F0FDF4;color:#15803D}
.alert-danger{background:#FEF2F2;color:#B91C1C}
.alert-warning{background:#FFFBEB;color:#B45309}

.qa{display:flex;flex-direction:column;align-items:center;gap:8px;padding:16px 10px;border-radius:14px;border:1.5px solid var(--bd);background:#fff;transition:all .2s;cursor:pointer;text-align:center;color:var(--tx)}
.qa:hover{border-color:var(--c);background:var(--cl);transform:translateY(-3px)}
.qa-i{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:19px}
.qa-t{font-size:12.5px;font-weight:700}
.qa-s{font-size:10.5px;color:var(--tx3)}

.uc{display:flex;align-items:center;gap:10px}
.ua{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px;flex-shrink:0}
.un{font-size:13.5px;font-weight:700}
.ue{font-size:11.5px;color:var(--tx3)}

.am .dropdown-toggle::after{display:none}
.am .dropdown-menu{border-radius:12px;padding:6px;min-width:165px;border:1px solid var(--bd);box-shadow:0 8px 24px rgba(0,0,0,.09)}
.am .dropdown-item{border-radius:8px;padding:8px 12px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:9px}
.am .dropdown-item:hover{background:var(--bg)}
.am .dropdown-item.text-danger:hover{background:#FEF2F2}

.dm{border-radius:14px;border:1px solid var(--bd);box-shadow:0 8px 24px rgba(0,0,0,.08);padding:6px}
.di{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:9px;font-size:13px;font-weight:600;color:var(--tx);transition:background .15s;cursor:pointer}
.di:hover{background:var(--bg)}
.di.rd{color:#DC2626}.di.rd:hover{background:#FEF2F2}

.pb{height:6px;border-radius:3px;background:var(--bd);overflow:hidden}
.pf{height:100%;border-radius:3px;transition:width .6s}

.upz{border:2px dashed var(--bd);border-radius:12px;padding:28px;text-align:center;cursor:pointer;transition:all .2s;background:#F9FAFB}
.upz:hover{border-color:var(--c);background:var(--cl)}

::-webkit-scrollbar{width:4px}
::-webkit-scrollbar-thumb{background:var(--bd);border-radius:4px}
</style>
@stack('styles')
</head>
<body>

<aside class="sb">
    <div class="sb-hd">
        <div class="sb-logo">
            <div class="sb-logo-i">✈</div>
            <div>
                <div class="sb-logo-n">TravelDream</div>
                <div class="sb-logo-s">Admin Panel</div>
            </div>
        </div>
        <div class="sb-me">
            <div class="sb-me-av">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div>
                <div class="sb-me-n">{{ Str::limit(auth()->user()->name,15) }}</div>
                <div class="sb-me-r">Super Admin</div>
            </div>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-sec">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="sb-lnk {{ request()->routeIs('admin.dashboard')?'on':'' }}">
            <i class="bi bi-grid-1x2-fill"></i>Dashboard
        </a>

        <div class="sb-sec">Contenu</div>
        <a href="{{ route('admin.offres.index') }}" class="sb-lnk {{ request()->routeIs('admin.offres*')?'on':'' }}">
            <i class="bi bi-map-fill"></i>Offres voyages
        </a>
        <a href="{{ route('admin.medias.index') }}" class="sb-lnk {{ request()->routeIs('admin.medias*')?'on':'' }}">
            <i class="bi bi-film"></i>Slides & Vidéos
        </a>

        <div class="sb-sec">Ventes</div>
        <a href="{{ route('admin.reservations.index') }}" class="sb-lnk {{ request()->routeIs('admin.reservations*')?'on':'' }}">
            <i class="bi bi-calendar2-check-fill"></i>Réservations
            @php $nb=\App\Models\Reservation::where('statut','en_attente')->count(); @endphp
            @if($nb>0)<span class="sb-n">{{ $nb }}</span>@endif
        </a>
        <a href="{{ route('admin.paiements.index') }}" class="sb-lnk {{ request()->routeIs('admin.paiements*')?'on':'' }}">
            <i class="bi bi-credit-card-2-front-fill"></i>Paiements
        </a>

        <div class="sb-sec">CRM</div>
        <a href="{{ route('admin.utilisateurs.index') }}" class="sb-lnk {{ request()->routeIs('admin.utilisateurs*')?'on':'' }}">
            <i class="bi bi-people-fill"></i>Clients
        </a>
        <a href="{{ route('admin.notifications.index') }}" class="sb-lnk {{ request()->routeIs('admin.notifications*')?'on':'' }}">
            <i class="bi bi-megaphone-fill"></i>Notifications
        </a>
        <a href="{{ route('admin.faqs.index') }}" class="sb-lnk {{ request()->routeIs('admin.faqs*')?'on':'' }}">
            <i class="bi bi-robot"></i>FAQ Chatbot
        </a>
    </nav>

    <div class="sb-ft">
        <a href="{{ route('home') }}"><i class="bi bi-box-arrow-up-right"></i>Voir le site</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="out"><i class="bi bi-box-arrow-right"></i>Déconnexion</button>
        </form>
    </div>
</aside>

<div class="mn">
    <header class="tb">
        <div>
            <div class="tb-tt">@yield('title','Dashboard')</div>
            <div class="tb-bc">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
                <i class="bi bi-dot"></i>
                <span>@yield('title','Dashboard')</span>
            </div>
        </div>
        <div class="tb-r">
            <div style="display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:50px;background:#fff;border:1px solid var(--bd);font-size:12px;font-weight:600;color:var(--tx2)" class="d-none d-md-flex">
                <i class="bi bi-calendar3" style="color:var(--c)"></i>{{ now()->format('d M Y') }}
            </div>

            <div class="dropdown">
                <div class="tb-b" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    @if(isset($nb)&&$nb>0)<div class="tb-dot"></div>@endif
                </div>
                <div class="dropdown-menu dropdown-menu-end dm" style="width:290px">
                    <div style="padding:14px 16px;border-bottom:1px solid var(--bd);display:flex;justify-content:space-between">
                        <strong>Notifications</strong>
                        @if(isset($nb)&&$nb>0)<span class="bx wa">{{ $nb }}</span>@endif
                    </div>
                    @if(isset($nb)&&$nb>0)
                    <div style="padding:14px">
                        <div style="display:flex;gap:11px">
                            <div style="width:36px;height:36px;border-radius:50%;background:#FFFBEB;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0">⏳</div>
                            <div>
                                <div style="font-weight:700;font-size:13.5px">{{ $nb }} réservation(s) en attente</div>
                                <a href="{{ route('admin.reservations.index') }}" style="color:var(--c2);font-size:12px;font-weight:700">Traiter →</a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div style="text-align:center;padding:22px;color:var(--tx3)">
                        <i class="bi bi-check-circle" style="font-size:24px;color:var(--c);display:block;margin-bottom:6px"></i>
                        Tout est à jour
                    </div>
                    @endif
                </div>
            </div>

            <div class="dropdown">
                <div class="tb-b" data-bs-toggle="dropdown"><i class="bi bi-grid-3x3-gap-fill"></i></div>
                <div class="dropdown-menu dropdown-menu-end dm" style="width:200px">
                    <a href="{{ route('admin.offres.create') }}" class="di"><i class="bi bi-plus-circle-fill" style="color:#16A34A"></i>Nouvelle offre</a>
                    <a href="{{ route('admin.medias.index') }}" class="di"><i class="bi bi-images" style="color:#D97706"></i>Médias</a>
                    <a href="{{ route('admin.reservations.index') }}" class="di"><i class="bi bi-calendar-check-fill" style="color:#2563EB"></i>Réservations</a>
                    <div style="height:1px;background:var(--bd);margin:5px 0"></div>
                    <a href="{{ route('home') }}" class="di"><i class="bi bi-globe2"></i>Voir le site</a>
                </div>
            </div>

            <div class="dropdown">
                <div class="tb-p" data-bs-toggle="dropdown">
                    <div class="tb-pav">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                    <div>
                        <div style="font-size:13px;font-weight:700">{{ Str::limit(auth()->user()->name,12) }}</div>
                        <div style="font-size:10.5px;color:var(--tx3)">Admin</div>
                    </div>
                    <i class="bi bi-chevron-down ms-1" style="font-size:10px;color:var(--tx3)"></i>
                </div>
                <div class="dropdown-menu dropdown-menu-end dm" style="width:190px">
                    <div style="padding:10px 12px;border-bottom:1px solid var(--bd)">
                        <div style="font-weight:700;font-size:13.5px">{{ auth()->user()->name }}</div>
                        <div style="font-size:11px;color:var(--tx3)">{{ auth()->user()->email }}</div>
                    </div>
                    <div style="padding:6px">
                        <a href="{{ route('home') }}" class="di"><i class="bi bi-globe2"></i>Voir le site</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="di rd w-100 text-start bg-transparent border-0"><i class="bi bi-box-arrow-right"></i>Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="pg">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>