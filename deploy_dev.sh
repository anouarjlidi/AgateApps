#!/bin/sh

echo " > Suppression du cache"
php bin/console cache:clear --env=dev
php bin/console cache:clear --env=dev_fast

echo " > Mise à jour des dépendances"
php composer.phar selfupdate
php composer.phar update -v
bower update

echo " > Installation des assets "
php bin/console assets:install
php bin/console assetic:dump --env=dev_fast