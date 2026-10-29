# Session 08 - Défi

La route posts.tag utilise {tag:slug} : oui
La page d'un tag n'affiche ni brouillon ni article d'un autre tag : oui
Les tags des cartes sont des liens : oui
L'accueil n'affiche que les tags qui ont au moins un article publié : oui
Les trois nouveaux tests passent et php artisan test est vert : oui

Pourquoi filtrer les tags vides après get() plutôt que d'afficher (0) ?

Parce que la liste des tags populaires décrit un état, pas un fait isolé : l'exigence est « rien n'est affiché, pas même le titre, quand la liste est vide ». Si on laissait les tags à 0 dans la liste, l'accueil afficherait des liens morts comme « Tests (0) » qui mènent vers une page sans aucun article : l'information est exacte mais une interface ne doit pas proposer un lien qui ne montre rien. Le filtre après get() (filter(fn ($tag) => $tag->posts_count > 0)) garde la requête simple et unique, et permet aussi le tri demandé (nombre décroissant puis nom). Le titre « Tags populaires » est lui-même caché quand la liste filtrée est vide, pour ne rien afficher du tout.

Combien de requêtes ajoute la liste des tags populaires, et pourquoi pas une par tag ?

Une seule requête : Tag::withCount(['posts' => fn ($query) => $query->published()]) ajoute à la requête des tags une sous-requête qui compte les articles publiés ; le tri (orderByDesc posts_count puis name) se fait dans SQL et le filtre des vides se fait dans la collection déjà chargée. C'est 1 requête au total, quelle que soit la liste. Une requête par tag serait le problème N+1 : pour 6 tags, 6 requêtes supplémentaires dont le seul but est de compter, sans jamais charger un seul article ; avec withCount, la base calcule tous les compteurs en une fois. Et si on oubliait tout cela et écrivait $tag->posts->count() dans la vue, Model::preventLazyLoading la ferait planter avec une LazyLoadingViolationException : c'est le garde-fou de la session 07.
