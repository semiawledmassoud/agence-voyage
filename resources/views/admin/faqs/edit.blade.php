@extends('layouts.admin')
@section('title', 'Modifier FAQ')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Modifier FAQ</h4>
</div>
<div class="card p-4" style="max-width:700px">
    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-semibold">Question *</label>
            <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Réponse *</label>
            <textarea name="reponse" rows="4" class="form-control" required>{{ old('reponse', $faq->reponse) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Catégorie</label>
            <select name="categorie" class="form-select">
                <option value="general" {{ $faq->categorie=='general' ? 'selected' : '' }}>Général</option>
                <option value="reservation" {{ $faq->categorie=='reservation' ? 'selected' : '' }}>Réservation</option>
                <option value="paiement" {{ $faq->categorie=='paiement' ? 'selected' : '' }}>Paiement</option>
                <option value="offres" {{ $faq->categorie=='offres' ? 'selected' : '' }}>Offres</option>
                <option value="compte" {{ $faq->categorie=='compte' ? 'selected' : '' }}>Compte</option>
            </select>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="actif" id="actif" {{ $faq->actif ? 'checked' : '' }}>
            <label class="form-check-label" for="actif">Active</label>
        </div>
        <button type="submit" class="btn btn-warning fw-bold">Enregistrer</button>
    </form>
</div>
@endsection