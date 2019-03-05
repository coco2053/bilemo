Bilemo
====

Projet 7 - Parcours développeur d'application PHP/Symfony - OpenClassrooms
--------------------------------------------------------------------------

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/e20098bfc5804d9ba7be57e60c3be91e)](https://www.codacy.com/app/coco2053/bilemo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=coco2053/bilemo&amp;utm_campaign=Badge_Grade)
Bonjour, ceci est le projet qui m'a permit d'apprendre à developper une API REST avec le framework Symfony 4.
Les documents preparatoires (diagrammes) se trouvent dans le repertoire "diagrams".

### Installation

1. Clonez ou telechargez le repository.
1. Modifiez le fichier .env avec vos parametres de BDD et d'email.
1. Ouvrez la console dans le repertoire racine.
1. composer install -> pour installer toutes les dependances.

1. Importez le fichier "bilemo.sql" dans votre BDD
ou
1. php bin/console doctrine:database:create -> pour créer la BDD.
1. php bin/console doctrine:migrations:migrate -> pour commencer la migration.
1. php bin/console doctrine:fixtures:load -> pour charger les fixtures.
puis
1. php bin/console server:run -> pour lancer le serveur local.
1. Vous pouvez entrer l'adresse "localhost:8000" dans votre navigateur et admirer le resultat.

Pour utiliser l'Api :
1. Se connecter avec un compte google et authoriser l'application.
1. Copier le token ainsi obtenu. Il n'est valable qu'une heure.
1. Lancez une requete avec dans le header la clé Authorisation et la valeur "Bearer votre_token"
1. Retouvez toute la documentation de l'api à la racine du site, lien "documentation".

### Built with :

- symfony 4.2.3
- csa/guzzle-bundle 3.0
- friendsofsymfony/rest-bundle 2.2
- hautelook/alice-bundle 2.1
- jms/serializer-bundle 3.0
- nelmio/api-doc-bundle 3.0
- pagerfanta 2.0.1
- Hateoas 2.0

 À bientôt ...


