@extends('layouts.admin')
@section('title', 'Détail Offre')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:9px">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">{{ $offre->titre }}</h4>
        <p class="text-muted mb-0" style="font-size:12.5px">ID #{{ $offre->id }}</p>
    </div>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('admin.offres.edit', $offre) }}" class="btn btn-warning btn-sm" style="border-radius:9px">
            <i class="bi bi-pencil me-1"></i>Modifier
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card p-4 mb-4">
            @if($offre->image_principale)
                <img src="{{ asset('storage/'.$offre->image_principale) }}"
                     class="w-100 rounded-3 mb-4" style="max-height:300px;object-fit:cover">
            @endif

            @if($offre->images->count() > 0)
            <div class="d-flex gap-2 mb-4 overflow-auto">
                @foreach($offre->images as $img)
                <img src="{{ asset('storage/'.$img->image) }}"
                     style="height:65px;width:95px;object-fit:cover;border-radius:8px;flex-shrink:0">
                @endforeach
            </div>
            @endif

            <h5 class="fw-bold mb-3">Description</h5>
            <p style="font-size:14px;line-height:1.8;color:#374151">{{ $offre->description }}</p>

            <div class="row g-3 mt-2">
                @foreach([
                    ['📍','Destination',$offre->destination],
                    ['🌍','Pays',$offre->pays],
                    ['🏷️','Type',$offre->type],
                    ['💰','Prix',number_format($offre->prix,0).' DT'],
                    ['🗓️','Départ',$offre->date_depart->format('d/m/Y')],
                    ['🗓️','Retour',$offre->date_retour->format('d/m/Y')],
                    ['⏱️','Durée',$offre->duree_jours.' jours'],
                    ['👥','Places dispo',$offre->places_disponibles.'/'.$offre->places_totales],
                ] as $info)
                <div class="col-md-3">
                    <div style="background:#F8F9FF;border-radius:10px;padding:12px;text-align:center">
                        <div style="font-size:22px">{{ $info[0] }}</div>
                        <div class="text-muted" style="font-size:11px">{{ $info[1] }}</div>
                        <div class="fw-semibold" style="font-size:13px">{{ $info[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 mb-4">
            <h6 class="fw-bold mb-3">⚙️ Statut</h6>
            @if($offre->statut==='active')
                <span class="badge badge-active fs-6 d-block text-center py-2">✅ Active</span>
            @elseif($offre->statut==='inactive')
                <span class="badge badge-inactive fs-6 d-block text-center py-2">⏸ Inactive</span>
            @else
                <span class="badge badge-cancelled fs-6 d-block text-center py-2">🔴 Complète</span>
            @endif

            @if($offre->featured)
            <div class="mt-2 text-center">
                <span class="badge" style="background:#FFFBEB;color:#D97706">⭐ En avant</span>
            </div>
            @endif
            @if($offre->prix_promo)
            <div class="mt-2 text-center">
                <span class="badge badge-cancelled">🔥 Promo: {{ number_format($offre->prix_promo,0) }} DT</span>
            </div>
            @endif

            <hr>
            <form method="POST" action="{{ route('admin.offres.toggle', $offre) }}">
                @csrf @method('PATCH')
                <button class="btn btn-{{ $offre->statut==='active'?'warning':'success' }} w-100 btn-sm" style="border-radius:9px">
                    <i class="bi bi-{{ $offre->statut==='active'?'pause':'play' }}-circle me-1"></i>
                    {{ $offre->statut==='active'?'Désactiver':'Activer' }}
                </button>
            </form>
        </div>

        <div class="card p-4">
            <h6 class="fw-bold mb-3">📋 Réservations ({{ $offre->reservations->count() }})</h6>
            @forelse($offre->reservations->take(5) as $res)
            <div class="d-flex align-items-center gap-2 mb-2 pb-2" style="border-bottom:1px solid #F3F4F6">
                <div class="flex-grow-1">
                    <div class="fw-semibold" style="font-size:12.5px">{{ $res->user->name }}</div>
                    <div class="text-muted font-monospace" style="font-size:10.5px">{{ $res->reference }}</div>
                </div>
                <span class="badge badge-{{ $res->statut=='confirmee'?'confirmed':($res->statut=='annulee'?'cancelled':'pending') }}" style="font-size:10px">
                    {{ $res->statut }}
                </span>
            </div>
            @empty
            <p class="text-muted text-center small">Aucune réservation</p>
            @endforelse
        </div>
    </div>
</div>

@endsection