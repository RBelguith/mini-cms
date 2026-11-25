# Session 10 - Robustesse

TagAdminTest contient 5 tests verts : oui
/posts/categorie/inconnue affiche Catégorie introuvable avec le statut 404 : oui
php artisan test est vert : oui

1. Pourquoi le message de messages() l'emporte-t-il sur celui de lang/fr/validation.php ?
Parce que Laravel cherche le message dans cet ordre : d'abord messages() de la Form Request,
puis lang/fr/validation.php, puis le message anglais du framework. La première source qui
contient la clé gagne, donc une règle écrite dans messages() (ex. slug.unique) masque le
message général du fichier de langue.

2. Pourquoi phpunit.xml fixe-t-il APP_LOCALE ?
Parce que phpunit.xml l'emporte sur .env (comme SITE_READ_ONLY en session 09) : un test qui
compare un texte français (« Le champ nom est obligatoire. ») donne le même résultat sur
chaque poste et sur un clone propre, quelle que soit la locale du .env local.

3. Pourquoi CategoryController n'a-t-il besoin d'aucun try/catch ?
Parce que la validation est faite avant lui par la Form Request (qui redirige vers le
formulaire), et que les erreurs sont transformées en pages par le gestionnaire d'exceptions :
abort(404) ou abort(503) devient une vue du dossier errors. Le contrôleur ne fait que lire ou
écrire puis répondre ; aucune action de Mini-CMS n'a à attraper une exception.
