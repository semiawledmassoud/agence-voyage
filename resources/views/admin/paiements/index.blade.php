@extends('layouts.admin')
@section('title', 'Paiements')
@section('content')

<h4 class="fw-bold mb-4">💰 Paiements ({{ $paiements->total() }})</h4>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Transaction</th><th>Client</th><th>Offre</th><th>Montant</th><th>Méthode</th><th>Statut</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($paiements as $p)
                <tr>
                    <td class="font-monospace" style="font-size:11.5px">{{ $p->transaction_id }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:12.5px">{{ $p->user->name }}</div>
                        <div class="text-muted" style="font-size:11px">{{ $p->user->email }}</div>
                    </td>
                    <td style="font-size:12.5px">{{ Str::limit($p->reservation->offre->titre,25) }}</td>
                    <td class="fw-bold" style="color:#6366F1">{{ number_format($p->montant,0) }} DT</td>
                    <td><span class="badge badge-inactive">{{ $p->methode }}</span></td>
                    <td>
                        <span class="badge badge-{{ $p->statut=='complete'?'confirmed':($p->statut=='rembourse'?'pending':'cancelled') }}">
                            {{ $p->statut }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div style="font-size:44px">💳</div>
                        <p class="mt-2">Aucun paiement</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($paiements->hasPages())
    <div class="p-3 d-flex justify-content-center border-top">
        {{ $paiements->links() }}
    </div>
    @endif
</div>

@endsection