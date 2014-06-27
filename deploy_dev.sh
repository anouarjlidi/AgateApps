#!/bin/sh

echo " > Suppression du cache"
php app/console cache:clear --env=dev
php app/console cache:clear --env=dev_fast

echo " > Mise à jour des dépendances"
php composer.phar selfupdate
php composer.phar update -v
bower update

echo " > Installation des assets "
php app/console assets:install
php app/console assetic:dump --env=dev_fast