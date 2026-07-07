@extends('layouts.admin')
@section('title', 'FAQ Chatbot')
@section('content')

<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-bold">🤖 FAQ Chatbot</h4>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nouvelle FAQ
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Question</th><th>Catégorie</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr>
                    <td>{{ Str::limit($faq->question, 60) }}</td>
                    <td><span class="badge bg-secondary">{{ $faq->categorie }}</span></td>
                    <td>
                        <span class="badge bg-{{ $faq->actif ? 'success' : 'secondary' }}">
                            {{ $faq->actif ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}"
                              class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Aucune FAQ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection