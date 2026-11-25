# Session 11 - Défi

/mes-articles ne montre que mes articles, brouillons compris : oui
Un visiteur qui ouvre /mes-articles arrive sur /connexion : oui
Le cookie remember_web_ apparaît quand la case est cochée : oui
Les deux nouveaux tests passent et php artisan test est vert : oui

Pourquoi partir de $request->user()->posts() plutôt que de Post::where('user_id', $request->user()->id) ?
Parce que la requête part de l'utilisateur connecté : elle ne peut renvoyer que ses articles,
quoi que contienne la requête HTTP (aucun champ de formulaire ne peut détourner la liste).
La relation porte en plus les règles du modèle (scopes, relations) au lieu de recopier
la condition user_id à la main, et elle reste lisible en une ligne.

Pourquoi la case remember ne doit-elle pas être dans le tableau passé à Auth::attempt() ?
Parce que ce tableau est un couple d'identifiants (email + mot de passe) utilisé pour
chercher l'utilisateur et comparer l'empreinte : il ne contient que des colonnes.
`remember` n'est pas une donnée de l'utilisateur : c'est le second argument de la méthode,
Auth::attempt($credentials, $remember). S'il figurait dans le tableau, il deviendrait un
critère de recherche qui ne correspond à aucune colonne de la table users.
