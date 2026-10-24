# Session 06 - Défi : publier et dépublier

La route posts.publication apparaît dans route:list avec le verbe PATCH : **oui**

Le bouton affiche « Publier » sur un brouillon et « Dépublier » sur un article publié : **oui**

published_at est rempli à la publication et vidé à la dépublication : **oui**

Le nouveau test passe et php artisan test est vert : **oui**

Pourquoi PATCH et pas PUT ni GET pour ce bouton ?

PATCH parce qu'on ne modifie qu'une seule information de l'article (`is_published`), sans remplacer la ressource entière comme le ferait PUT. GET serait dangereux : un GET ne doit jamais modifier les données (un robot, un préchargement ou un double clic sur un lien suffirait à (dé)publier l'article sans le vouloir). C'est exactement la même logique que la suppression en session 06 : les actions d'écriture ne passent jamais par un simple lien.
