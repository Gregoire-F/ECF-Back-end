# Explication Projet ECF 2

## Les prérequis 

### Mise en place

- Lancer VSCode
- Cloner le projet sur GitHub avec ce lien https://github.com/Gregoire-F/ECF-Back-end.git
- Lancer Mamp/Xampp sur le port 8889 (voir .env pour plus de detail)
- Modifier le .env pour la ligne DATABASE afin d'ajouter les bons credentials de connexion à la base de données

### Dans le terminal 
- Mettre la commande ```symfony serve```
- Créer la base de données avec la commande ```php bin/console doctrine:database:create```
- Charger mes fixtures avec la commande ```php bin/console doctrine:fixtures:load``` pour peupler la base de données avec des données fictives.
Voici la base de données prête avec des informations visibles

### Dans le navigateur

- Taper /home dans la barre d'URL 
- Se connecter avec les credentials donnés ci-dessous

### Les identifiants de connexion ###

- Admin : admin@biblio.com + password123
- Bibliothecaire : bibliothecaire@biblio.com + password123

### Base de données ### 

En cas de besoin le dumpSQL mediatheque.sql est disponible à la racine du projet.

### L'API 

Les appels API ne sont possibles qu'une fois connecté avec un compte admin ou bibliothecaire. Ensuite les appels possibles sont les suivants : 

**GET** : pour voir les livres ou un livre en particulier
-/api/livres
-/api/livres/{id du livre}

**POST** : pour ajouter un livre
-/api/livres

**PUT** : pour modifier un livre
-/api/livres/{id du livre}

**DELETE** : pour supprimer un livre
-/api/livres/{id du livre}