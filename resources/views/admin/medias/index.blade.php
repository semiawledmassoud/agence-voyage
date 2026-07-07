@extends('layouts.admin')
@section('title', 'Slides & Vidéos')
@section('content')

<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Ajouter un média</h5>
            <form method="POST" action="{{ route('admin.medias.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="2" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-select" id="mediaType" onchange="updateAccept()">
                        <option value="slide">🖼️ Slide (Image)</option>
                        <option value="video">🎬 Vidéo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" id="fileLabel">Fichier image *</label>
                    <div class="upload-zone" onclick="document.getElementById('fichier').click()">
                        <div style="font-size:32px">📁</div>
                        <div class="fw-semibold mt-1 small">Cliquez pour choisir</div>
                        <div class="text-muted" style="font-size:11px" id="fileHint">JPG, PNG, WEBP</div>
                        <div class="text-primary mt-1" style="font-size:11px" id="fileName">Aucun fichier</div>
                    </div>
                    <input type="file" id="fichier" name="fichier" accept="image/*" style="display:none" onchange="showFile(this)" required>
                </div>
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="actif" checked>
                    <label class="form-check-label fw-semibold small">Actif (visible)</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-cloud-upload me-2"></i>Ajouter
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-images me-2 text-primary"></i>Slides ({{ $slides->count() }})</h5>
            @if($slides->count() > 0)
            <div class="row g-3">
                @foreach($slides as $slide)
                <div class="col-md-6">
                    <div style="border:1px solid var(--border);border-radius:11px;overflow:hidden">
                        <div class="position-relative">
                            <img src="{{ asset('storage/'.$slide->fichier) }}" style="width:100%;height:130px;object-fit:cover" alt="">
                            @if(!$slide->actif)<div style="position:absolute;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px">DÉSACTIVÉ</div>@endif
                        </div>
                        <div class="p-3">
                            <div class="fw-semibold small">{{ $slide->titre }}</div>
                            <div class="d-flex gap-2 mt-2">
                                <form method="POST" action="{{ route('admin.medias.toggle', $slide) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-{{ $slide->actif ? 'warning' : 'success' }}" style="font-size:11px;border-radius:7px">
                                        <i class="bi bi-{{ $slide->actif ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.medias.destroy', $slide) }}" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="font-size:11px;border-radius:7px">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-4 text-muted"><div style="font-size:36px">🖼️</div><p class="mt-2 small">Aucun slide</p></div>
            @endif
        </div>

        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-play-circle me-2 text-danger"></i>Vidéos ({{ $videos->count() }})</h5>
            @if($videos->count() > 0)
            <div class="row g-3">
                @foreach($videos as $video)
                <div class="col-md-6">
                    <div style="border:1px solid var(--border);border-radius:11px;overflow:hidden">
                        <video controls style="width:100%;height:130px;object-fit:cover;display:block">
                            <source src="{{ asset('storage/'.$video->fichier) }}" type="video/mp4">
                        </video>
                        <div class="p-3">
                            <div class="fw-semibold small">{{ $video->titre }}</div>
                            <div class="d-flex gap-2 mt-2">
                                <form method="POST" action="{{ route('admin.medias.toggle', $video) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-{{ $video->actif ? 'warning' : 'success' }}" style="font-size:11px;border-radius:7px">
                                        <i class="bi bi-{{ $video->actif ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.medias.destroy', $video) }}" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="font-size:11px;border-radius:7px">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-4 text-muted"><div style="font-size:36px">🎬</div><p class="mt-2 small">Aucune vidéo</p></div>
            @endif
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
function updateAccept() {
    const t = document.getElementById('mediaType').value;
    const i = document.getElementById('fichier');
    const l = document.getElementById('fileLabel');
    const h = document.getElementById('fileHint');
    if (t === 'video') { i.accept = 'video/*'; l.textContent = 'Fichier vidéo *'; h.textContent = 'MP4, MOV, AVI — max 50MB'; }
    else { i.accept = 'image/*'; l.textContent = 'Fichier image *'; h.textContent = 'JPG, PNG, WEBP — max 10MB'; }
}
function showFile(input) {
    document.getElementById('fileName').textContent = input.files[0] ? input.files[0].name : 'Aucun fichier';
}
</script>
@endpush