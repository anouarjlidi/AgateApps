#!/bin/sh

echo " > Mise à jour de Composer "
php composer.phar selfupdate

echo " > Mise à jour des dépendances"
php composer.phar install
bower install

echo " > Suppression du cache"
php bin/console cache:clear --env=dev
php bin/console cache:clear --env=prod

echo " > Installation des assets "
php bin/console assets:install
php bin/console assetic:dump --env=prod

echo " > Insertion des fixtures "
php bin/console doctrine:fixtures:load --append

echo " > Intégration des snapshots de Sonata dans l'application."
php bin/console sonata:page:update-core-routes --site=1
php bin/console sonata:page:create-snapshots --site=1
