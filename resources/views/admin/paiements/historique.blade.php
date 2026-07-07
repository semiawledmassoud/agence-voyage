@extends('layouts.app')
@section('title', 'Historique Paiements')
@section('content')

<h4 class="fw-bold mb-4">💳 Historique des paiements</h4>

@if($paiements->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:60px">💳</div>
        <h5 class="text-muted">Aucun paiement effectué</h5>
    </div>
@else
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Transaction</th><th>Offre</th>
                    <th>Montant</th><th>Statut</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                <tr>
                    <td class="font-monospace small">{{ $paiement->transaction_id }}</td>
                    <td>{{ $paiement->reservation->offre->titre }}</td>
                    <td><strong>{{ number_format($paiement->montant, 0) }} DT</strong></td>
                    <td>
                        <span class="badge bg-{{ $paiement->statut == 'complete' ? 'success' : 'danger' }}">
                            {{ $paiement->statut }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection