# Projet Web : Shopping Bag

## Description

Ce projet a été réalisé dans le cadre du cours de développement web. Il s'agit d'un site de type "shopping bag" qui permet aux utilisateurs de naviguer, sélectionner et acheter des produits en ligne. Le site utilise une base de données SQL, créée et gérée via PHPMyAdmin.

## Technologies Utilisées

- PHP
- MySQL
- HTML/CSS
- XAMPP (pour le serveur local)

## Fonctionnalités

- **Inscription et Connexion** : Les utilisateurs peuvent s'inscrire et se connecter à leur compte.
- **Affichage des Produits** : Les produits disponibles à la vente sont affichés et organisés par catégorie.
- **Gestion du Panier** : Les utilisateurs peuvent ajouter des produits à leur panier, modifier les quantités, supprimer des articles ou réinitialiser le panier.
- **Options de Paiement** : Les utilisateurs peuvent choisir de payer par PayPal (lien vers paypal.com) ou par chèque en fournissant leurs informations de commande.
- **Gestion des Commandes** : Un administrateur peut se connecter pour valider les commandes et gérer les paiements.

## Pages Principales

1. **index.php** : Page d’accueil présentant les options d’inscription et de connexion, ainsi que la liste des catégories de produits.
2. **commandes.php** : Page réservée à l'administrateur pour afficher et valider les commandes des utilisateurs.
3. **liste.php** : Page d'affichage des produits d'une catégorie spécifique.
4. **panier.php** : Page affichant les produits sélectionnés, avec options pour modifier ou supprimer des articles.
5. **paiement1.php** : Page où le client entre ses informations personnelles avant le choix du mode de paiement.
6. **paiement2.php** : Page où le client choisit son moyen de paiement, avec redirection vers PayPal ou instructions pour un paiement par chèque.

## Installation

Pour exécuter ce projet sur votre machine locale, suivez ces étapes :

1. **Téléchargez et installez XAMPP** depuis [Apache Friends](https://www.apachefriends.org/index.html).
2. **Copiez le dossier SQL** fourni dans le répertoire de votre projet dans le dossier `htdocs` de XAMPP.
3. **Lancez XAMPP** et démarrez les modules Apache et MySQL.
4. **Accédez à PHPMyAdmin** (http://localhost/phpmyadmin) et créez une nouvelle base de données.
5. **Importez le fichier SQL** pour créer les tables nécessaires.
6. **Configurez les identifiants de l'utilisateur root** avec le mot de passe `password`.

## Auteur

Ce projet a été réalisé par :
- Fabien Mélinda 


## Remarques

- Notez que les transactions PayPal sur le site ne sont pas réelles, elles redirigent simplement vers paypal.com.
- Pour toute question ou suggestion, n'hésitez pas à ouvrir un "issue" sur ce dépôt.


