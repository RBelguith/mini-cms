# Session 03 - Routes, contrôleurs et layout

## Défi

URL produite par route('about') :

`http://localhost:8000/a-propos`

URL produite par route('posts.show', 'routes-et-controleurs') :

`http://localhost:8000/posts/routes-et-controleurs`

URL produite par route('posts.archive', 2025) :

`http://localhost:8000/posts/archive/2025`

Pourquoi /posts/archive/abc et /posts/article-inconnu répondent toutes deux 404, et quelle ligne de code en est responsable dans chaque cas ?

- `/posts/archive/abc` : la contrainte `whereNumber('year')` de `web.php` refuse le segment non numérique. La contrainte agit **avant** le contrôleur : `archive()` n'est jamais appelé et Laravel répond 404 par défaut.
- `/posts/article-inconnu` : l'URL passe la contrainte `where('slug', '[a-z0-9-]+')` (que des minuscules, chiffres et tirets), la route correspond donc et le contrôleur `show()` s'exécute. Le slug n'existe pas dans le tableau `posts()`, c'est la ligne `abort(404)` dans `PostController@show` qui répond 404.

Que se passe-t-il si une vue appelle route('posts.show') sans paramètre ?

Laravel lève l'erreur `Missing required parameter for [Route: posts.show] [URI: posts/{slug}] [Missing parameter: slug]` : la route `posts.show` attend le paramètre obligatoire `{slug}`, qui doit être passé comme deuxième argument de `route('posts.show', $slug)`.
