# Session 14 - Défi

Connexion enregistre le jeton toute seule : oui
Créer un article répond 201 sans copier le jeton : oui
Le fichier exporté ne contient aucun jeton : oui

Le dépôt est public. Que risquez-vous si le fichier exporté contient un jeton, et comment l'annuler ?

N'importe qui ayant accès au dépôt pourrait utiliser le jeton pour agir en mon nom sur l'API : lire mes données privées, créer, modifier ou supprimer des articles. Par défaut, un jeton Sanctum n'expire pas, donc le risque dure jusqu'à sa révocation. Pour l'annuler, il faut appeler `POST /api/logout` avec ce jeton (ce qui supprime son enregistrement dans `personal_access_tokens`) ou supprimer directement la ligne correspondante dans la table `personal_access_tokens`. Il faut ensuite remplacer la valeur du jeton dans la collection exportée par une chaîne vide et la révoquer définitivement si elle a été publiée.

Pourquoi les écritures de l'API passent-elles par les Form Requests et PostPolicy plutôt que par des règles écrites dans `Api\PostController` ?

Parce que le site et l'API doivent partager une seule source de vérité. Les Form Requests (`StorePostRequest`, `UpdatePostRequest`) portent les règles de validation et leurs messages traduits ; la `PostPolicy` porte les règles d'autorisation (qui peut créer, modifier ou supprimer un article). Si le contrôleur API dupliquait ces règles, un correctif appliqué au site pourrait être oublié côté API, et les deux portes pourraient se contredire. Passer par les mêmes objets garantit qu'un changement s'applique partout en même temps, avec les mêmes codes 401, 403 et 422.
