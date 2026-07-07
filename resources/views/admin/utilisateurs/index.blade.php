@extends('layouts.admin')
@section('title', 'Utilisateurs')
@section('content')

<h4 class="fw-bold mb-4">👥 Clients ({{ $users->total() }})</h4>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Client</th><th>Email</th><th>Téléphone</th><th>Réservations</th><th>Inscrit le</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($user->photo)
                                <img src="{{ asset('storage/'.$user->photo) }}"
                                     style="width:34px;height:34px;border-radius:9px;object-fit:cover">
                            @else
                                <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#6366F1,#EC4899);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                            @endif
                            <span class="fw-semibold" style="font-size:13px">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:12.5px">{{ $user->email }}</td>
                    <td style="font-size:12.5px">{{ $user->telephone ?? '—' }}</td>
                    <td>
                        <span class="badge badge-active">{{ $user->reservations->count() }}</span>
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $user->actif?'active':'cancelled' }}">
                            {{ $user->actif?'Actif':'Bloqué' }}
                        </span>
                    </td>
                    <td>
                        <div class="dropdown action-menu">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    style="border-radius:7px;width:30px;height:30px;padding:0">
                                <i class="bi bi-three-dots-vertical" style="font-size:13px"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('admin.utilisateurs.toggle',$user) }}">
                                        @csrf @method('PATCH')
                                        <button class="dropdown-item w-100 text-start border-0 bg-transparent">
                                            <i class="bi bi-{{ $user->actif?'lock text-warning':'unlock text-success' }}"></i>
                                            {{ $user->actif?'Bloquer':'Activer' }}
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.utilisateurs.destroy',$user) }}"
                                          onsubmit="return confirm('Supprimer définitivement ?')">
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
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div style="font-size:44px">👥</div>
                        <p class="mt-2">Aucun client inscrit</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-3 d-flex justify-content-center border-top">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection