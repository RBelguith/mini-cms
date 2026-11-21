# Session 09 - Défi

Le bandeau s'affiche sur toutes les pages quand SITE_READ_ONLY=true : oui
Le bandeau disparaît quand SITE_READ_ONLY=false : oui
La page Article introuvable propose au plus trois articles publiés, sans brouillon : oui
Aucune LazyLoadingViolationException sur /posts/999 : oui
Les deux nouveaux tests passent et php artisan test est vert : oui

Pourquoi le bandeau est-il dans le layout et pas dans chaque vue ?
Parce que le layout est le seul fichier commun à toutes les pages : une information
qui concerne tout le site (message flash, bandeau d'état) y est écrite une seule fois
et s'affiche partout, au lieu d'être copiée dans chaque vue.

Pourquoi le test du bandeau n'a-t-il pas besoin de modifier .env ?
Parce que le middleware et le layout lisent config('site.read_only'), pas env() directement.
Le test peut donc faire config(['site.read_only' => true]) en mémoire : la configuration
est modifiée pour la durée du test, sans toucher au fichier .env, et phpunit.xml remet
ensuite SITE_READ_ONLY=false pour les autres tests.
