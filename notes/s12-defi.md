# Session 12 - Défi

1. Pourquoi `role` n'est-il pas dans `#[Fillable]`, et comment votre contrôleur le modifie-t-il quand même ?
Le champs `role` n'est pas dans `#[Fillable]` exprès (toujours pas, depuis la session 11 : un formulaire ou `$request->all()` ne peut pas ajouter de rôle à la main). Le contrôleur du niveau 1 ne passe que `name`, `email` et `password` à `create()`, car les seules valeurs reçues sont `name`, `email` et `password`. Pour le niveau 1 du défi, le contrôleur `UserController::role()` affecte l'attribut lui-même (`$user->role = $request->validated('role')`) puis appelle `save()`. L'écriture passe par `UserPolicy::updateRole` et `UpdateUserRoleRequest::authorize()`.

2. Pourquoi le callback de `Gate::before` doit-il renvoyer `null`, et non `false`, pour un auteur ?
`false` est une réponse définitive : Laravel le comprend comme « refus : ne passe pas, même pour `updateRole` ». `null` veut dire « pas d'avis » : Laravel continue et demande au Gate (`manage-categories`, `manage-tags`) ou à la méthode de la Policy concernés (`updateRole` sur les autres utilisateurs). C'est aussi pour autoriser les admins à ne pas être bloqués par le `before` sur la capacité `updateRole` : le Gate doit laisser passer ce cas pour que `UserPolicy::updateRole` repère le "moi" via `! $actor->is($target)`.
