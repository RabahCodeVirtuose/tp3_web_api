# Framework Web 2 — 2025-2026

Pour utiliser ces fichiers Docker : 

1) Modifier le fichier docker-compose.yml aux endroits indiqués 

2) Exécuter : 

docker compose up --build -d 

3) Pour tester si l'étape 1 a été réalisée correctement, utiliser la commande 

id 

puis la commande 

docker exec -ti fw2-symfony id 

La première valeur uid=N(X) où N est un nombre et X un identifiant alphanumérique doit être identique pour les deux commandes.

4) Pour commencer à travailler dans le container : 

docker exec -ti fw2-symfony bash 