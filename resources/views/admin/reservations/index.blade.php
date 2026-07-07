@extends('layouts.admin')
@section('title', 'Réservations')
@section('content')

<h4 class="fw-bold mb-4">📋 Réservations ({{ $reservations->total() }})</h4>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Référence</th><th>Client</th><th>Offre</th><th>Personnes</th><th>Total</th><th>Date</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr>
                    <td class="font-monospace" style="font-size:11.5px">{{ $res->reference }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:12.5px">{{ $res->user->name }}</div>
                        <div class="text-muted" style="font-size:11px">{{ $res->user->email }}</div>
                    </td>
                    <td style="font-size:12.5px">{{ Str::limit($res->offre->titre,25) }}</td>
                    <td class="text-center">{{ $res->nombre_personnes }}</td>
                    <td class="fw-bold" style="color:#6366F1">{{ number_format($res->prix_total,0) }} DT</td>
                    <td class="text-muted small">{{ $res->date_reservation->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $res->statut=='confirmee'?'confirmed':($res->statut=='annulee'?'cancelled':'pending') }}">
                            {{ $res->statut_label }}
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
                                    <a class="dropdown-item" href="{{ route('admin.reservations.show',$res) }}">
                                        <i class="bi bi-eye text-primary"></i>Voir détails
                                    </a>
                                </li>
                                @if($res->statut=='en_attente')
                                <li>
                                    <form method="POST" action="{{ route('admin.reservations.confirmer',$res) }}">
                                        @csrf @method('PATCH')
                                        <button class="dropdown-item w-100 text-start border-0 bg-transparent">
                                            <i class="bi bi-check-circle text-success"></i>Confirmer
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.reservations.annuler',$res) }}">
                                        @csrf @method('PATCH')
                                        <button class="dropdown-item text-danger w-100 text-start border-0 bg-transparent">
                                            <i class="bi bi-x-circle"></i>Annuler
                                        </button>
                                    </form>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <div style="font-size:44px">📭</div>
                        <p class="mt-2">Aucune réservation</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reservations->hasPages())
    <div class="p-3 d-flex justify-content-center border-top">
        {{ $reservations->links() }}
    </div>
    @endif
</div>

@endsection