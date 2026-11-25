# Session 13 - Défi

/api/posts/3 affiche tags avec des noms : oui
/api/posts ne contient aucun body, /api/posts/3 en contient un : oui
Aucune LazyLoadingViolationException : oui

Pourquoi ne pas envoyer `body` dans la liste, et qui en profite ?
La liste est un survol : le client n'a besoin que de l'identifiant, du titre, de l'extrait, de la date et de l'URL pour afficher des cartes ou des résultats de recherche. Envoyer le contenu complet de cinq articles à chaque page alourdirait la réponse (bande passante, décodage JSON) et exposerait le texte intégral alors que personne ne le lit. Le corps est demandé seulement sur `/api/posts/{post}`, quand l'utilisateur ouvre réellement l'article. Ce sont les clients qui consomment la liste — application mobile, script, moteur de recherche — qui profitent d'une réponse légère, tout comme le serveur qui sérialise moins de données.

Un brouillon renvoie 403. Quel avantage aurait un 404 pour un brouillon ?
Un 403 révèle que l'adresse existe et que l'article est simplement refusé au visiteur : il confirme l'existence du brouillon et son identifiant. Un 404 dirait « cet article n'existe pas » et empêcherait un client de deviner qu'un brouillon est là, donc d'énumérer les brouillons par numéro. Le 404 protège mieux la confidentialité du contenu non publié, mais il ment sur la réalité de la ressource ; le 403 est le code exact puisque `PostPolicy::view` refuse une ressource existante. En API, le choix dépend donc de ce qu'on veut laisser fuiter : l'existence (403) ou seulement le contenu publié (404).
