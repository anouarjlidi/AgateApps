#!/bin/sh

echo " > Suppression du cache"
php app/console cache:clear --env=dev
php app/console cache:clear --env=prod

echo " > Mise à jour des dépendances"
php composer.phar update
bower update

echo " > Installation des assets "
php app/console assets:install
php app/console assetic:dump --env=prod