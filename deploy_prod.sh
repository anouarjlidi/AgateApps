#!/bin/sh

echo " > Suppression du cache"
php bin/console cache:clear --env=dev
php bin/console cache:clear --env=prod

echo " > Mise à jour des dépendances"
php composer.phar update
bower update

echo " > Installation des assets "
php bin/console assets:install
php bin/console assetic:dump --env=prod