<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Mini-CMS

## Description

Mini-CMS est un petit site de gestion d'articles réalisé au fil des sessions 01 à 15 du codelab Laravel. Il combine une interface web en Blade et une API JSON protégée par des jetons Sanctum. Les articles appartiennent à des auteurs, sont classés par catégories et portent des tags ; un administrateur gère les catégories, les tags et les rôles.

Le dépôt est livré avec le tag `lab-08b`. Les étapes intermédiaires sont conservées par les tags `lab-07`, `lab-07b` et `lab-08`.

## Fonctionnalités

- Pages publiques : accueil, à propos, heure courante, liste des articles, archive annuelle, pages par catégorie et par tag.
- Articles : création, modification, suppression, publication/dépublication, brouillons visibles seulement par leur auteur et les administrateurs.
- Catégories et tags associés aux articles, avec formulaires d'administration.
- Authentification manuelle (inscription, connexion, déconnexion), rôles `admin` / `author`, Gates et `PostPolicy`.
- API JSON en lecture pour les articles, catégories et tags ; API en écriture protégée par Sanctum.
- Filtres `?category=<slug>` et `?tag=<slug>`, pagination `?per_page=` de 1 à 50.
- Validation et messages d'erreur en français, pages 404/503 dans le layout.
- Suite de tests Pest complète : 107 tests au tag `lab-08b`.

## Installation

Le projet utilise SQLite : aucune configuration de base de données n'est à faire.

### Bash

```bash
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan test
composer run dev
```

### PowerShell

```powershell
composer install
npm install
npm run build
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan test
composer run dev
```

Si Artisan propose de créer `database/database.sqlite`, répondez `yes`. Le serveur de développement écoute ensuite sur `http://localhost:8000` (ou `http://127.0.0.1:8000`).

## Comptes de test

Le seeder crée ces comptes, tous avec le mot de passe `password` :

| Nom | E-mail | Rôle |
|---|---|---|
| Claire Fontaine | `test@example.com` | `admin` |
| Deux auteurs générés par la fabrique | visibles dans `/admin/utilisateurs` après connexion | `author` |

Un compte auteur peut modifier ses propres articles ; il reçoit un 403 sur ceux d'un autre auteur. Le compte admin peut tout gérer.

## API

Les réponses sont toujours JSON. Toutes les requêtes doivent envoyer l'en-tête `Accept: application/json`.

### Endpoints

| Méthode | URI | Nom | Description |
|---|---|---|---|
| GET | `/api/posts` | `api.posts.index` | Articles publiés, paginés et filtrables |
| GET | `/api/posts/{post}` | `api.posts.show` | Un article visible |
| POST | `/api/login` | `api.login` | Obtient un jeton Sanctum |
| POST | `/api/logout` | `api.logout` | Révoque le jeton courant |
| GET | `/api/user` | — | Utilisateur associé au jeton |
| GET | `/api/categories` | `api.categories.index` | Catégories avec `posts_count` |
| GET | `/api/categories/{category}` | `api.categories.show` | Une catégorie avec `posts_count` |
| GET | `/api/tags` | `api.tags.index` | Tags avec `posts_count` |
| GET | `/api/tags/{tag}` | `api.tags.show` | Un tag avec `posts_count` |
| POST | `/api/posts` | `api.posts.store` | Crée un article |
| PUT/PATCH | `/api/posts/{post}` | `api.posts.update` | Modifie un article |
| DELETE | `/api/posts/{post}` | `api.posts.destroy` | Supprime un article |

Exemple de lecture filtrée : `GET /api/posts?category=php&tag=api&per_page=2`.

### Authentification par jeton

`POST /api/login` accepte `email` et `password` et renvoie :

```json
{
  "token": "...",
  "token_type": "Bearer"
}
```

Envoyez ensuite `Authorization: Bearer <jeton>` sur les écritures et sur `/api/user` ou `/api/logout`. `POST /api/logout` supprime uniquement le jeton utilisé pour la requête ; les autres appareils restent connectés.

Une collection Postman exportable se trouve dans `docs/postman/mini-cms.postman_collection.json` : la requête « Connexion » mémorise le jeton dans une variable de collection, et l'export ne contient aucun jeton.

### Codes d'erreur

| Code | Situation |
|---|---|
| 401 | Jeton absent, invalide ou révoqué sur une route protégée |
| 403 | L'utilisateur n'a pas le droit de voir ou modifier la ressource |
| 404 | Article, catégorie ou tag introuvable |
| 422 | Validation échouée, y compris un slug de filtre inconnu |

Les messages de validation sont traduits en français, par exemple « La valeur sélectionnée pour le champ catégorie est invalide. »

### Exemple curl.exe

```powershell
curl.exe -X POST -H "Accept: application/json" -H "Authorization: Bearer VOTRE_JETON" http://localhost:8000/api/logout
```

Remplacez `VOTRE_JETON` par le jeton renvoyé par la requête de connexion. La réponse 204 n'a pas de corps.

## Captures d'écran

### Session 03

![Accueil avec le layout](screenshots/s03-accueil.png)

![Liste des articles](screenshots/s03-articles.png)

![Détail d'un article](screenshots/s03-article.png)

### Session 04

![Liste des articles](screenshots/s04-articles.png)

### Session 05

![Liste paginée des articles](screenshots/s05-articles.png)

![Formulaire avec erreurs de validation](screenshots/s05-formulaire.png)

### Session 06

![Formulaire de modification prérempli](screenshots/s06-modification.png)

![Confirmation de suppression](screenshots/s06-suppression.png)

### Session 07

![Liste des articles avec leur catégorie, leur auteur et leurs tags](screenshots/s07-liste-relations.png)

![Page d'un article avec ses tags et les articles de la même catégorie](screenshots/s07-detail-tags.png)

### Session 08

![Formulaire de modification avec la catégorie et les tags](screenshots/s08-formulaire-relations.png)

![Page des articles d'une catégorie](screenshots/s08-page-categorie.png)

### Session 09

![Page d'un article avec le message flash « Article créé. »](screenshots/s09-message-flash.png)

![Page Article introuvable pour un identifiant inexistant](screenshots/s09-article-introuvable.png)

### Session 10

Back-office des catégories et des tags, messages de validation en français, pages 404 et 503 dans le layout du site.

![Formulaire de catégorie envoyé vide, avec les messages de validation en français](screenshots/s10-validation.png)

![Page 404 du site pour une adresse inconnue](screenshots/s10-404.png)

### Session 11

Authentification manuelle, Gates et policies : la barre de navigation d'un utilisateur connecté et la page 403 reçue par un auteur sur l'article d'un autre auteur.

![Barre de navigation d'un utilisateur connecté, avec le message « Vous êtes connecté. »](screenshots/s11-connexion.png)

![Page 403 quand un auteur ouvre la modification de l'article d'un autre auteur](screenshots/s11-interdit.png)

### Session 12

Sprint : middleware `admin` sur tout `/admin`, Gate `manage-tags`, `PostPolicy::view` et scope `visibleTo` sur les brouillons, et défi : page de gestion des rôles + `Gate::before`.

![Page 403 « Réservé aux administrateurs. » pour un compte auteur sur /admin/tags](screenshots/s12-admin-interdit.png)

![Barre de navigation d'un compte auteur, sans les liens Catégories et Tags](screenshots/s12-menu-auteur.png)

### Session 13

Réponses de l'API appelées avec l'en-tête `Accept: application/json`.

![Réponse JSON de GET /api/posts?per_page=2, avec data, links et meta](screenshots/s13-postman-liste.png)

![Réponse 422 de GET /api/posts?per_page=500, avec le message en français](screenshots/s13-postman-422.png)

### Session 14

![Création d'un article avec un jeton Bearer, onglet Body, réponse 201 Created](screenshots/s14-postman-201.png)

![PUT sur l'article d'un autre auteur, réponse 403](screenshots/s14-postman-403.png)

## Choix d'architecture

### Pourquoi les écritures de l'API passent par PostPolicy

Le site et l'API utilisent les mêmes Form Requests et la même `PostPolicy`. Ainsi, une seule règle décide qui peut créer, modifier ou supprimer un article : si elle change, les deux portes changent ensemble. L'API ne peut donc pas devenir un raccourci qui contourne les droits définis pour l'interface web, et les deux côtés renvoient les mêmes 401, 403 et 422.

### Pourquoi preventLazyLoading est activé

Sans chargement anticipé, lire une relation dans une boucle déclenche une requête SQL par élément : c'est le problème N+1. En développement, `preventLazyLoading()` transforme ce défaut silencieux en erreur explicite, ce qui oblige à écrire `with()` ou `load()` dès qu'une relation est utilisée. La protection reste désactivée en production pour ne pas casser le site si une relation oubliée apparaissait.

### Pourquoi l'API utilise des jetons et non la session

Le groupe `api` n'a ni session ni cookie : un client qui n'est pas un navigateur (script, application mobile, Postman) n'a pas de cookies à présenter. Avec Sanctum, chaque requête porte un jeton Bearer que l'on peut révoquer individuellement avec `/api/logout`, sans déconnecter les autres appareils. Cela garde aussi l'API sans état côté serveur.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Comparaison avec le starter kit Livewire

| Critère | Mini-CMS (authentification manuelle) | Starter kit Livewire |
|---|---|---|
| Routes d'authentification | `routes/web.php` : `/inscription`, `/connexion`, `/deconnexion` | enregistrées par Fortify depuis son paquet ; absentes de `routes/web.php` |
| Inscription | `app/Http/Controllers/Auth/RegisterController.php` + `app/Http/Requests/RegisterRequest.php` | `app/Actions/Fortify/CreateNewUser.php` (`Validator::make` puis `User::create`) |
| Connexion | `app/Http/Controllers/Auth/LoginController.php::store` (`Auth::attempt`, `regenerate`) | contrôleur de Fortify + `resources/views/pages/auth/login.blade.php` |
| Déconnexion | `LoginController::destroy` (`logout`, `invalidate`, `regenerateToken`) | route `logout` de Fortify ; mêmes opérations dans `app/Livewire/Actions/Logout.php` |
| Limitation des tentatives | aucune | 5 tentatives par minute par e-mail et adresse IP (`app/Providers/FortifyServiceProvider.php`) |
| Mot de passe oublié | absent | `Features::resetPasswords()` dans `config/fortify.php` |
| Vérification de l'e-mail | absente | `Features::emailVerification()`, `MustVerifyEmail`, middleware `verified` |
| Double authentification | absente | `Features::twoFactorAuthentication()` et `Features::passkeys()` |
| Rôles et autorisations | colonne `role` (`app/Models/User.php`), Gates (`app/Providers/AppServiceProvider.php`), `app/Policies/PostPolicy.php`, middleware `app/Http/Middleware/EnsureUserIsAdmin.php` | aucun : à écrire soi-même |
| Tests | `tests/Feature/AuthTest.php`, `AuthorizationTest.php`, `AdminAccessTest.php`, `PostVisibilityTest.php` | 10 fichiers dans `tests/Feature` (écrits avec PHPUnit dans le dépôt) |

Ce que je garderais du kit dans un vrai projet : la limitation des tentatives, la réinitialisation du mot de passe et la vérification de l'e-mail, déjà écrites et testées par Fortify ; je garderais mon code d'autorisation (rôle, Gates, Policy, middleware), car aucun starter kit ne connaît les règles de mon domaine.
