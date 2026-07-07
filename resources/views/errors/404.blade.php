<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page introuvable — TravelDream</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Playfair+Display:wght@800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg,#0EA5E9,#8B5CF6); min-height:100vh; display:flex; align-items:center; font-family:'DM Sans',sans-serif; }
    </style>
</head>
<body>
<div class="container text-center text-white">
    <div style="font-size:90px">🌍</div>
    <h1 style="font-family:'Playfair Display',serif;font-size:5rem;font-weight:800">404</h1>
    <h3 class="mb-3">Page introuvable</h3>
    <p class="opacity-75 mb-4">Cette destination n'existe pas sur notre carte.</p>
    <a href="{{ url('/') }}" class="btn btn-light btn-lg fw-bold px-5" style="border-radius:12px">
        Retour à l'accueil
    </a>
</div>
</body>
</html>