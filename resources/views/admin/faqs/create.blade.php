@extends('layouts.admin')
@section('title', 'Nouvelle FAQ')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Nouvelle FAQ</h4>
</div>
<div class="card p-4" style="max-width:700px">
    <form method="POST" action="{{ route('admin.faqs.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Question *</label>
            <input type="text" name="question" class="form-control" value="{{ old('question') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Réponse *</label>
            <textarea name="reponse" rows="4" class="form-control" required>{{ old('reponse') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Catégorie</label>
            <select name="categorie" class="form-select">
                <option value="general">Général</option>
                <option value="reservation">Réservation</option>
                <option value="paiement">Paiement</option>
                <option value="offres">Offres</option>
                <option value="compte">Compte</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Mots clés (séparés par virgule)</label>
            <input type="text" name="mots_cles" class="form-control" placeholder="reserver, voyage, booking">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="actif" id="actif" checked>
            <label class="form-check-label" for="actif">Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Créer la FAQ</button>
    </form>
</div>
@endsection