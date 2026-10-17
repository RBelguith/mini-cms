<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heure - Mini-CMS</title>
</head>
<body>
    <h1>Heure actuelle</h1>
    <p>{{ $heure }} - {{ $date }}</p>
    <p>
        <a href="{{ route('home') }}">Accueil</a> |
        <a href="{{ route('about') }}">À propos</a>
    </p>
</body>
</html>
