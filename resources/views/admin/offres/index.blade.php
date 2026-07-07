@extends('layouts.admin')
@section('title', 'Gestion des Offres')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">🏝️ Offres de Voyage</h4>
        <p class="text-muted mb-0" style="font-size:12.5px">{{ $offres->total() }} offre(s)</p>
    </div>
    <a href="{{ route('admin.offres.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nouvelle Offre
    </a>
</div>

<div class="card p-3 mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Titre, destination..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="statut" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="active"   {{ request('statut')=='active'   ?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('statut')=='inactive' ?'selected':'' }}>Inactive</option>
                <option value="complete" {{ request('statut')=='complete' ?'selected':'' }}>Complète</option>
            </select>
        </div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Filtrer</button></div>
        <div class="col-md-2"><a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-x me-1"></i>Reset</a></div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Offre</th><th>Destination</th><th>Prix</th><th>Départ</th><th>Places</th><th>Résas</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($offres as $offre)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($offre->image_principale)
                                <img src="{{ asset('storage/'.$offre->image_principale) }}" style="width:46px;height:38px;object-fit:cover;border-radius:7px;flex-shrink:0" alt="">
                            @else
                                <div style="width:46px;height:38px;border-radius:7px;flex-shrink:0;background:linear-gradient(135deg,#6366F1,#EC4899);display:flex;align-items:center;justify-content:center;font-size:16px">🌍</div>
                            @endif
                            <div>
                                <div class="fw-semibold" style="font-size:12.5px">{{ $offre->titre }}</div>
                                <div class="d-flex gap-1 mt-1">
                                    <span class="badge badge-inactive" style="font-size:9.5px">{{ $offre->type }}</span>
                                    @if($offre->featured)<span class="badge" style="background:#FFFBEB;color:#D97706;font-size:9.5px">⭐</span>@endif
                                    @if($offre->prix_promo)<span class="badge" style="background:#FEF2F2;color:#DC2626;font-size:9.5px">PROMO</span>@endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><div style="font-size:12.5px">{{ $offre->destination }}</div><div class="text-muted" style="font-size:11px">{{ $offre->pays }}</div></td>
                    <td>
                        <div class="fw-bold" style="font-size:12.5px;color:#6366F1">{{ number_format($offre->prix,0) }} DT</div>
                        @if($offre->prix_promo)<div class="text-muted text-decoration-line-through" style="font-size:10.5px">{{ number_format($offre->prix_promo,0) }} DT</div>@endif
                    </td>
                    <td><div style="font-size:12.5px">{{ $offre->date_depart->format('d/m/Y') }}</div><div class="text-muted" style="font-size:10.5px">{{ $offre->duree_jours }}j</div></td>
                    <td>
                        <span class="fw-bold {{ $offre->places_disponibles==0?'text-danger':'text-success' }}" style="font-size:12.5px">{{ $offre->places_disponibles }}</span>
                        <span class="text-muted" style="font-size:10.5px">/ {{ $offre->places_totales }}</span>
                    </td>
                    <td><span class="badge badge-active" style="font-size:10.5px">{{ $offre->reservations_count }}</span></td>
                    <td>
                        @if($offre->statut==='active')<span class="badge badge-active">Active</span>
                        @elseif($offre->statut==='inactive')<span class="badge badge-inactive">Inactive</span>
                        @else<span class="badge badge-cancelled">Complète</span>@endif
                    </td>
                    <td>
                        <div class="dropdown action-menu">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" style="border-radius:7px;width:30px;height:30px;padding:0">
                                <i class="bi bi-three-dots-vertical" style="font-size:13px"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.offres.show',$offre) }}"><i class="bi bi-eye text-primary"></i>Voir</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.offres.edit',$offre) }}"><i class="bi bi-pencil text-warning"></i>Modifier</a></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.offres.toggle',$offre) }}">
                                        @csrf @method('PATCH')
                                        <button class="dropdown-item w-100 border-0 bg-transparent text-start">
                                            <i class="bi bi-{{ $offre->statut==='active'?'pause-circle text-warning':'play-circle text-success' }}"></i>
                                            {{ $offre->statut==='active'?'Désactiver':'Activer' }}
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.offres.destroy',$offre) }}" onsubmit="return confirm('Supprimer définitivement ?')">
                                        @csrf @method('DELETE')
                                        <button class="dropdown-item text-danger w-100 text-start border-0 bg-transparent">
                                            <i class="bi bi-trash"></i>Supprimer
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-5 text-muted"><div style="font-size:44px">🏝️</div><p class="mt-2">Aucune offre</p><a href="{{ route('admin.offres.create') }}" class="btn btn-primary btn-sm">Créer une offre</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($offres->hasPages())
    <div class="p-3 d-flex justify-content-center border-top">{{ $offres->appends(request()->query())->links() }}</div>
    @endif
</div>

@endsection