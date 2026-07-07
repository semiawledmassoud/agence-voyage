@extends('layouts.admin')
@section('title', 'Notifications')
@section('content')

<h4 class="fw-bold mb-4">📢 Notifications</h4>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-send-fill me-2 text-primary"></i>Envoyer une notification</h5>
            <form method="POST" action="{{ route('admin.notifications.envoyer') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="titre" class="form-control" required placeholder="Ex: Nouvelle promotion !">
                </div>
                <div class="mb-3">
                    <label class="form-label">Message *</label>
                    <textarea name="message" rows="4" class="form-control" required
                              placeholder="Votre message à tous les clients..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="info">ℹ️ Info</option>
                        <option value="promotion">🎉 Promotion</option>
                        <option value="reservation">📋 Réservation</option>
                        <option value="annulation">❌ Annulation</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-send me-2"></i>Envoyer à tous les clients
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-4">📜 Historique récent</h5>
            @forelse($notifications->take(12) as $notif)
            <div class="d-flex align-items-start gap-3 mb-3 pb-3" style="border-bottom:1px solid #F3F4F6">
                <div style="width:36px;height:36px;border-radius:9px;flex-shrink:0;background:#EFF6FF;display:flex;align-items:center;justify-content:center;font-size:16px">
                    {{ $notif->type=='promotion'?'🎉':($notif->type=='reservation'?'📋':($notif->type=='annulation'?'❌':'ℹ️')) }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold" style="font-size:13px">{{ $notif->titre }}</div>
                    <div class="text-muted" style="font-size:11.5px">{{ Str::limit($notif->message,55) }}</div>
                    <div class="text-muted" style="font-size:11px">
                        {{ $notif->user->name }} • {{ $notif->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <span class="badge badge-{{ $notif->lue?'inactive':'active' }}" style="flex-shrink:0;font-size:10px">
                    {{ $notif->lue?'Lu':'Non lu' }}
                </span>
            </div>
            @empty
            <div class="text-center py-4 text-muted">
                <div style="font-size:40px">🔔</div>
                <p class="mt-2 small">Aucune notification envoyée</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection