# Session 07 - Défi : articles de la même catégorie

La section « Dans la même catégorie » apparaît sous un article publié qui a une catégorie : oui
L'article affiché n'apparaît pas dans sa propre section : oui
Un brouillon de la même catégorie n'apparaît pas : oui
La page s'ouvre sans LazyLoadingViolationException : oui
Le nouveau test passe et php artisan test est vert : oui

Combien de requêtes SQL charge la section, et pourquoi pas une par carte ?

La section est chargée par UNE seule requête principale (les articles publiés de la même catégorie, hors l'article affiché, triés du plus récemment publié au plus ancien, limités à 3), plus exactement UNE requête supplémentaire par relation préchargée avec with('user', 'category', 'tags') pour récupérer tous les utilisateur, catégories et tags des 3 cartes en une fois. Pourquoi pas une par carte ? Parce que ce serait le problème N+1 : avec une requête par carte, chaque carte demanderait sa propre catégorie, son propre auteur et ses propres tags au serveur, soit jusqu'à 12 requêtes de plus pour 3 cartes. Le chargement anticipé (eager loading) remplace ces requêtes répétées par 3 requêtes uniques avec where in, et Model::preventLazyLoading ferait même planter la page si on oubliait with().
