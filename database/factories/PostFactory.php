<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Articles réalistes en français, cohérents avec le thème développement web.
     * Chaque entrée fournit un résumé et des phrases réelles pour composer le contenu.
     */
    private const ARTICLES = [
        [
            'title' => 'Introduction à Laravel',
            'resume' => 'Le framework PHP qui rend le développement web rapide, élégant et sécurisé.',
            'first' => 'Laravel structure une application autour de routes, de contrôleurs et de vues Blade.',
            'corps' => [
                'Avec Artisan, chaque ligne de commande crée les fichiers dont vous avez besoin en quelques secondes.',
                "L'ORM Eloquent traduit vos tables en objets : le code parle de votre métier au lieu d'empiler du SQL à rallonge.",
            ],
            'last' => "En suivant la documentation officielle pas à pas, votre première application tourne en moins d'une heure.",
        ],
        [
            'title' => 'Comprendre les composants Blade',
            'resume' => 'Découper une interface en composants réutilisables pour garder des vues lisibles.',
            'first' => 'Un composant Blade, comme x-layout ou x-alert, encapsule une partie d’interface avec ses props.',
            'corps' => [
                'Le modèle des slots permet d’injecter du contenu dans le gabarit, exactement comme un paramètre dans une fonction.',
                'Les attributs et classes se transmettent via $attributes, ce qui évite de dupliquer le même HTML dans dix fichiers.',
            ],
            'last' => 'Au final, une vue revient à assembler des briques, et chaque brique vit dans son propre fichier.',
        ],
        [
            'title' => 'Écrire des tests avec PHPUnit',
            'resume' => 'Les tests automatisés vérifient votre application à chaque commit, sans vous fatiguer.',
            'first' => 'Un test décrit une action de l’utilisateur puis affirme ce que la page doit montrer.',
            'corps' => [
                'Avec assertDatabaseHas, on vérifie que le formulaire a réellement écrit la bonne ligne dans la table.',
                'Si un collègue casse la suppression d’un article, l’échec du test le signale avant la mise en production.',
            ],
            'last' => 'PHPUnit, et son extension Pest pour la lisibilité, transforment toute relecture manuelle en un simple php artisan test.',
        ],
        [
            'title' => 'Créer un CRUD complet avec Eloquent',
            'resume' => 'Créer, lire, modifier et supprimer des enregistrements grâce à une ressource Laravel.',
            'first' => 'Route::resource génère les sept routes du CRUD autour d’un seul contrôleur.',
            'corps' => [
                'La validation côté serveur garantit qu’aucun doublon de slug ne passe entre les mailles.',
                'La confirmation de suppression évite les clics accidentels, et cascadeOnDelete nettoie la table pivot pour vous.',
            ],
            'last' => 'Un CRUD bien testé devient la base fiable sur laquelle monter le reste du projet.',
        ],
        [
            'title' => 'Les migrations expliquées simplement',
            'resume' => 'Versionner le schéma de la base de données comme on versionne le code source.',
            'first' => 'Une migration décrit une étape du schéma : on la rejoue, on la remonte, on la relit.',
            'corps' => [
                'Ajouter une colonne ne touche jamais à l’ancienne migration : une nouvelle migration s’en charge.',
                'Le couple migrate:rollback et migrate prouve que votre historique reste propre et réversible.',
            ],
            'last' => 'Sur un poste neuf, migrate:fresh --seed reconstruit toute la base en une commande.',
        ],
        [
            'title' => 'Nettoyer du code legacy en PHP',
            'resume' => 'Reprendre un vieux code PHP sans tout casser, étape par étape.',
            'first' => 'Le code legacy se lit avant de se réécrire : comprendre l’existant évite les régressions.',
            'corps' => [
                'On entoure d’abord chaque zone fragile de tests de caractérisation, qui figent le comportement actuel.',
                'Petites étapes et commits courts : chaque refactorisation reste réversible avec Git.',
            ],
            'last' => 'Le nettoyage progressif rend le code compréhensible par l’équipe, sans grande réécriture héroïque.',
        ],
        [
            'title' => 'Maîtriser les relations Eloquent',
            'resume' => 'BelongsTo, HasMany et BelongsToMany relient vos tables en quelques lignes de code.',
            'first' => 'Une relation s’écrit une fois dans le modèle, puis se lit partout dans l’application.',
            'corps' => [
                'La table pivot post_tag relie les articles et les tags grâce à un index unique sur le couple d’identifiants.',
                'sync() aligne la pivot sur ce que le formulaire a coché, tandis que attach() et detach() font le reste.',
            ],
            'last' => 'Bien modéliser les relations, c’est s’épargner des heures de requêtes écrites à la main.',
        ],
        [
            'title' => 'Déboguer efficacement une application PHP',
            'resume' => 'Trouver un bug en quelques minutes plutôt qu’en plusieurs heures, avec les bons outils.',
            'first' => 'La lecture du message d’exception suffit souvent à localiser le fichier et la ligne en cause.',
            'corps' => [
                'Laravel affiche la pile d’appels complète et les requêtes exécutées au moment de l’erreur.',
                'Le journal de requêtes en Tinker révèle les problèmes N+1 invisibles sur la page.',
            ],
            'last' => 'Un bon débogage commence par reproduire le problème dans un test qui échoue.',
        ],
        [
            'title' => 'Comprendre le routage dans un framework MVC',
            'resume' => 'Du chemin tapé dans le navigateur jusqu’à la méthode du contrôleur : le trajet expliqué.',
            'first' => 'Le routeur compare l’URI aux motifs enregistrés, comme {category:slug}.',
            'corps' => [
                'Une contrainte de route filtre les paramètres : le slug refuse ce qui n’est pas alphanumérique.',
                'La liaison modèle-route transforme un segment d’URL en instance Eloquent, 404 comprise.',
            ],
            'last' => 'Des noms de routes explicites rendent les liens stables même si les URI changent.',
        ],
        [
            'title' => 'Sécuriser ses formulaires web',
            'resume' => 'CSRF, XSS, validation côté serveur : les réflexes à avoir dès la première ligne.',
            'first' => 'Jamais une écriture sans jeton CSRF : @csrf protège chaque formulaire Blade.',
            'corps' => [
                'La validation rejette avant tout envoi ce qui ne respecte pas les règles déclarées.',
                'L’échappement automatique de Blade neutralise le HTML inséré par un visiteur malintentionné.',
            ],
            'last' => 'La sécurité, c’est d’abord de la discipline : vérifier côté serveur, sans jamais faire confiance au client.',
        ],
        [
            'title' => 'Optimiser vos requêtes avec le chargement anticipé',
            'resume' => 'Vaincre le problème N+1 avec with(), load() et withCount().',
            'first' => 'Une page d’articles ne devrait jamais exécuter une requête par ligne affichée.',
            'corps' => [
                'with() récupère toutes les relations listées en une seule requête complémentaire.',
                'withCount() compte sans charger un seul article, idéal pour des compteurs en page d’accueil.',
            ],
            'last' => 'Model::preventLazyLoading transforme chaque oubli en erreur visible pendant le développement.',
        ],
        [
            'title' => 'Concevoir une interface avant de coder',
            'resume' => 'Maquettes et wireframes économisent des heures de développement inutile.',
            'first' => 'Un wireframe définit le contenu et la hiérarchie, sans se soucier des couleurs.',
            'corps' => [
                'On valide d’abord le squelette avec l’équipe, puis on l’habille avec la charte graphique.',
                'Tailwind CSS permet de passer de la maquette aux classes utilitaires sans intermédiaire.',
            ],
            'last' => 'Cinq minutes de croquis épargnent une après-midi de réécriture de gabarit.',
        ],
        [
            'title' => 'Publier votre premier projet Laravel en ligne',
            'resume' => 'Du localhost à la production : les étapes d’après un premier déploiement.',
            'first' => 'Un déploiement commence par un dépôt Git, car le serveur clone le code source.',
            'corps' => [
                'Le fichier .env distingue les réglages locaux des variables de production, et ne se commite jamais.',
                'php artisan migrate construit la base de données exactement comme en développement.',
            ],
            'last' => 'Après la première mise en ligne, un tag Git marque la version livrée.',
        ],
        [
            'title' => 'Git au quotidien pour les développeurs web',
            'resume' => 'Commits utiles, branches nettes et tags de livraison : la routine qui fait gagner du temps.',
            'first' => 'Un commit raconte une petite histoire complète, avec un message qui la résume.',
            'corps' => [
                'Les branches cloisonnent les expérimentations et protègent la branche principale.',
                'Les tags figent chaque livrable : relire l’historique devient un vrai tableau de bord.',
            ],
            'last' => 'git push, une fois compris, met fin à cette impression de travailler sans filet.',
        ],
    ];

    /** Index cyclique : garantit des titres distincts sans épuiser le générateur. */
    private static int $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topic = self::ARTICLES[self::$index++ % count(self::ARTICLES)];
        $title = $topic['title'];

        // 2 à 3 paragraphes en français, cohérents avec le titre choisi.
        $sentences = [$topic['first'], ...$topic['corps'], $topic['last']];
        $paragraphs = fake()->numberBetween(2, 3) === 3
            ? [
                $sentences[0],
                $sentences[1].' '.$sentences[2],
                $sentences[3],
            ]
            : [
                $sentences[0].' '.$sentences[1],
                $sentences[2].' '.$sentences[3],
            ];

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->optional()->randomElement([$topic['resume']]),
            'body' => implode("\n\n", $paragraphs),
            'is_published' => false,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('2025-01-01', '2026-12-31'),
        ]);
    }
}
