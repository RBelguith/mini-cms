<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Mini-CMS</title>
</head>
<body>
    <h1>Accueil de Mini-CMS</h1>
    <p>Bienvenue sur le mini-CMS.</p>
    <p>
        <a href="{{ route('about') }}">À propos</a> |
        <a href="{{ url('/heure') }}">Heure</a>
    </p>
</body>
</html>
