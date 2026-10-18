# Session 05 - Défi : articles récents sur l'accueil

latestPosts contient au plus 3 articles : **oui** (grâce à `take(3)`)

Seuls les articles publiés sont transmis à la vue : **oui** (`where('is_published', true)`)

home.blade.php utilise x-post-card et @forelse : **oui**

Le nouveau test passe et php artisan test est vert : **oui**

Pourquoi get() et pas paginate(3) sur la page d'accueil ?

Parce qu'on ne veut pas de liens de pagination sur l'accueil : `get()` retourne simplement les (au plus) 3 articles sélectionnés en une seule liste, sans découpage en pages. `paginate(3)` créerait une URL page=2 alors qu'on n'affiche jamais plus de 3 articles de toute façon ; le filtre et la limite se font dans la requête Eloquent, sans pagination.
