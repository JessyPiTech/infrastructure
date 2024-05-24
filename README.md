# Rapport de Projet

## But du Projet
Le but de notre projet était de créer un site web permettant de communiquer avec une base de données MySQL/MariaDB, hebergé comme nous le souhaitons. Ce site web devait afficher les éléments que les personnes ajoutent sur le site, ces données sont stocké dans la base de données.

## Cadre de Développement
- **Établissement** : École d'informatique
- **Niveau d'études** : Première année (B1)
- **Contraintes** :
  - Nombre de cours alloués : 7 cours (28 heures)
  - Temps réellement disponible : 2 cours (8 heures) en raison de problèmes de réseau empêchant la communication entre deux machines virtuelles (VM).
  - Travail en binôme

## Stack Technique
- **Langage** : PHP
- **Base de données** : MariaDB (via phpMyAdmin, fourni par XAMPP)

## Installation du Projet
Pour installer notre projet, suivez les étapes ci-dessous :

1. **Pré-requis** : Assurez-vous d'avoir XAMPP installé sur votre machine.

2. **Création de l'utilisateur et de la base de données** :
   - Accédez à phpMyAdmin via l'interface XAMPP.
   - Créez un nouvel utilisateur et assignez les privilèges nécessaires.
   - Créez une nouvelle base de données pour le projet.

3. **Configuration des Crédentiels** :
   - Créez un fichier `credentials.php` dans le répertoire de votre projet avec le contenu suivant :
     ```php
     <?php
         $serveur = "localhost";
         $utilisateur = "Votre nom d'utilisateur";
         $mot_de_passe = "Son mdp";
         $base_de_donnees = "Le nom de votre base de données";
     ?>
     ```
   - Remplacez `"Votre nom d'utilisateur"`, `"Son mdp"`, et `"Le nom de votre base de données"` par les informations appropriées.

4. **Déploiement** :
   - Placez les fichiers de votre projet dans le répertoire `htdocs` de XAMPP.
   - Assurez-vous que le serveur Apache et MySQL sont démarrés dans le panneau de contrôle XAMPP.

5. **Accès à l'application** :
   - Ouvrez un navigateur web et accédez à `http://localhost/nom_de_votre_projet` pour voir votre application en action.

Cette configuration simple permet de connecter votre application PHP à une base de données MariaDB via XAMPP, facilitant ainsi le développement et le test local de votre projet.

## Conclusion
Malgré les contraintes de temps et les défis techniques rencontrés, notamment les problèmes de réseau entre les VM, nous avons réussi à établir une base de communication entre PHP et MariaDB, démontrant ainsi notre capacité à surmonter les obstacles et à travailler efficacement en équipe.

Pour toute question ou clarification, n'hésitez pas à nous contacter.
