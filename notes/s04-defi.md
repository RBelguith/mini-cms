# Session 04 - Défi x-page-header

@props déclare title (obligatoire) et subtitle (par défaut null) : **oui**

Le paragraphe ne s'affiche que si subtitle est fourni : **oui** (grâce à `@if ($subtitle)`)

Le composant remplace le h1 de a-propos.blade.php et de posts/index.blade.php : **oui**

Aucune URL écrite à la main : **oui**

Sur /posts/archive/2025, quel titre affiche x-page-header, et d'où vient-il ?

Il affiche « Articles de 2025 ». Ce texte vient du contrôleur : la méthode `PostController@archive` construit la chaîne `'Articles de '.$year` et la passe à la vue comme variable `$heading`, que `posts/index.blade.php` transmet au composant avec la prop dynamique `:title="$heading"`.
