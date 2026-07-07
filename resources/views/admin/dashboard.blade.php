@extends('layouts.admin')
@section('title','Dashboard')
@section('content')

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="kpi">
            <div class="kpi-i" style="background:#F0FDF4">👥</div>
            <div class="kpi-l">Clients</div>
            <div class="kpi-v">{{ $stats['total_clients'] }}</div>
            <div class="kpi-s" style="color:#15803D"><i class="bi bi-arrow-up-short"></i>Inscrits actifs</div>
            <div class="bars">@for($i=1;$i<=8;$i++)<div class="bar" style="height:{{ rand(25,100) }}%;background:{{ $i==8?'#22C55E':'#BBF7D0' }}"></div>@endfor</div>
            <div class="kpi-g"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi">
            <div class="kpi-i" style="background:#EFF6FF">🌍</div>
            <div class="kpi-l">Offres</div>
            <div class="kpi-v">{{ $stats['total_offres'] }}</div>
            <div class="kpi-s" style="color:#2563EB"><i class="bi bi-globe"></i>Destinations</div>
            <div class="bars">@for($i=1;$i<=8;$i++)<div class="bar" style="height:{{ rand(25,100) }}%;background:{{ $i==8?'#3B82F6':'#BFDBFE' }}"></div>@endfor</div>
            <div class="kpi-g"><i class="bi bi-map-fill"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi">
            <div class="kpi-i" style="background:#FFFBEB">📋</div>
            <div class="kpi-l">Réservations</div>
            <div class="kpi-v">{{ $stats['total_reservations'] }}</div>
            <div class="kpi-s" style="color:{{ $stats['reservations_attente']>0?'#B45309':'#15803D' }}">
                <i class="bi bi-clock"></i>{{ $stats['reservations_attente'] }} en attente
            </div>
            <div class="bars">@for($i=1;$i<=8;$i++)<div class="bar" style="height:{{ rand(25,100) }}%;background:{{ $i==8?'#F59E0B':'#FDE68A' }}"></div>@endfor</div>
            <div class="kpi-g"><i class="bi bi-calendar2-check-fill"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi">
            <div class="kpi-i" style="background:#DCFCE7">💰</div>
            <div class="kpi-l">Revenus</div>
            <div class="kpi-v" style="font-size:22px">{{ number_format($stats['revenus_total'],0) }}<small style="font-size:13px"> DT</small></div>
            <div class="kpi-s" style="color:#15803D"><i class="bi bi-arrow-up-short"></i>Mois: {{ number_format($stats['revenus_mois'],0) }} DT</div>
            <div class="bars">@for($i=1;$i<=8;$i++)<div class="bar" style="height:{{ rand(25,100) }}%;background:{{ $i==8?'#16A34A':'#A7F3D0' }}"></div>@endfor</div>
            <div class="kpi-g"><i class="bi bi-cash-stack"></i></div>
        </div>
    </div>
</div>

@if($stats['reservations_attente'] > 0)
<div class="alert alert-warning d-flex align-items-center gap-3 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-5" style="color:#D97706"></i>
    <div class="flex-grow-1"><strong>{{ $stats['reservations_attente'] }} réservation(s)</strong> en attente de validation.</div>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-g btn-sm">Gérer →</a>
</div>
@endif

<div class="card mb-4">
    <div class="card-h"><div><div class="card-t">⚡ Actions rapides</div><div class="card-s">Accès direct aux fonctions principales</div></div></div>
    <div style="padding:16px 20px">
        <div class="row g-3">
            @foreach([
                [route('admin.offres.create'),'➕','#F0FDF4','Nouvelle offre','Ajouter'],
                [route('admin.medias.index'),'🖼️','#FFFBEB','Médias','Slides & Vidéos'],
                [route('admin.reservations.index'),'📅','#EFF6FF','Réservations','Toutes'],
                [route('admin.utilisateurs.index'),'👥','#F5F3FF','Clients','Gérer'],
                [route('admin.faqs.create'),'🤖','#DCFCE7','FAQ','Chatbot IA'],
                [route('admin.notifications.index'),'📢','#FEF2F2','Notifs','Envoyer'],
            ] as $qa)
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ $qa[0] }}" class="qa">
                    <div class="qa-i" style="background:{{ $qa[2] }}">{{ $qa[1] }}</div>
                    <div class="qa-t">{{ $qa[3] }}</div>
                    <div class="qa-s">{{ $qa[4] }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-h">
                <div><div class="card-t">Dernières réservations</div><div class="card-s">{{ $stats['total_reservations'] }} au total</div></div>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-g btn-sm">Voir tout →</a>
            </div>
            <div style="overflow-x:auto">
                <table class="tbl">
                    <thead><tr><th>Client</th><th>Offre</th><th>Montant</th><th>Date</th><th>Statut</th><th></th></tr></thead>
                    <tbody>
                        @forelse($dernieres_reservations as $r)
                        <tr>
                            <td>
                                <div class="uc">
                                    <div class="ua" style="background:linear-gradient(135deg,#22C55E,#16A34A)">{{ strtoupper(substr($r->user->name,0,1)) }}</div>
                                    <div><div class="un">{{ $r->user->name }}</div><div class="ue">{{ Str::limit($r->user->email,22) }}</div></div>
                                </div>
                            </td>
                            <td style="font-size:13px;font-weight:600">{{ Str::limit($r->offre->titre,22) }}</td>
                            <td><span style="font-weight:800;color:var(--c2)">{{ number_format($r->prix_total,0) }} DT</span></td>
                            <td style="color:var(--tx3);font-size:12px">{{ $r->date_reservation->format('d/m/Y') }}</td>
                            <td>
                                @if($r->statut=='confirmee')<span class="bx ok">Confirmée</span>
                                @elseif($r->statut=='annulee')<span class="bx er">Annulée</span>
                                @else<span class="bx wa">En attente</span>@endif
                            </td>
                            <td><a href="{{ route('admin.reservations.show',$r) }}" class="tb-b" style="width:30px;height:30px;font-size:12px">👁</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--tx3)">Aucune réservation</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-h"><div class="card-t">Nouveaux clients</div><a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-g btn-sm">Voir</a></div>
            <div style="padding:14px">
                @forelse($derniers_clients as $c)
                <div class="uc mb-3">
                    @if($c->photo)
                        <img src="{{ asset('storage/'.$c->photo) }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;flex-shrink:0">
                    @else
                        <div class="ua" style="background:linear-gradient(135deg,#22C55E,#3B82F6)">{{ strtoupper(substr($c->name,0,1)) }}</div>
                    @endif
                    <div style="flex:1;min-width:0">
                        <div class="un" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $c->name }}</div>
                        <div class="ue" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $c->email }}</div>
                    </div>
                    <span class="bx {{ $c->actif?'ok':'er' }}" style="flex-shrink:0;font-size:10px">{{ $c->actif?'Actif':'Bloqué' }}</span>
                </div>
                @empty
                <div style="text-align:center;padding:18px;color:var(--tx3)">Aucun client</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-h"><div class="card-t">🔥 Top offres</div></div>
            <div style="padding:14px">
                @forelse($offres_populaires as $i => $offre)
                <div class="uc mb-3">
                    <div style="font-size:14px;font-weight:800;color:var(--tx3);width:16px;flex-shrink:0">{{ $i+1 }}</div>
                    @if($offre->image_principale)
                        <img src="{{ asset('storage/'.$offre->image_principale) }}" style="width:34px;height:34px;border-radius:9px;object-fit:cover;flex-shrink:0">
                    @else
                        <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#22C55E,#3B82F6);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0">🌍</div>
                    @endif
                    <div style="flex:1;min-width:0">
                        <div class="un" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:13px">{{ $offre->titre }}</div>
                        <div class="pb mt-1"><div class="pf" style="width:{{ $offre->reservations_count>0?min(100,$offre->reservations_count*25):4 }}%;background:var(--c)"></div></div>
                    </div>
                    <div style="font-size:13px;font-weight:800;color:var(--c2);flex-shrink:0">{{ $offre->reservations_count }}</div>
                </div>
                @empty
                <div style="text-align:center;padding:18px;color:var(--tx3)">Aucune offre</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection