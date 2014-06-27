Projet Corahn-Rin & Esteren Maps
========================

1) Pré-requis
----------------------------------

 - Avoir des droits pour exécuter des scripts dans la racine de l'application, et faire en sorte que ces droits soient les mêmes que ceux du serveur qui exécutera Symfony2.
 - PHP5.3 minimum, idéalement PHP5. Il doit être disponible dans l'environnement (exécuter `php -v` dans une ligne de commande pour vérifier sa présence)
 - [Composer](https://getcomposer.org/download/) :

     `curl -sS https://getcomposer.org/installer | php`

     `php composer.phar install`

 - [NodeJS](http://nodejs.org/download/) :
     - NPM (par défaut dans NodeJS normalement)
     - Bower : `npm install -g bower`
     - Less : `npm install -g less`


2) Installation
----------------------------------

Un script de déploiement existe à la racine et nécessite **sh** pour s'exécuter.

`sh deploy_dev.sh`

Il exécutera toutes les commandes nécessaires pour déployer la configuration, les dépendances et les assets.

Le même script existe pour l'environnement de **prod**.
