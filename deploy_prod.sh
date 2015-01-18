#!/bin/sh

echo " > Mise à jour de Composer "
php composer.phar selfupdate

echo " > Mise à jour des dépendances"
php composer.phar install
bower install

echo " > Suppression du cache"
php app/console cache:clear --env=dev
php app/console cache:clear --env=prod

echo " > Installation des assets "
php app/console assets:install
php app/console assetic:dump --env=prod

echo " > Insertion des fixtures "
php app/console doctrine:fixtures:load --append

echo " > Intégration des snapshots de Sonata dans l'application."
php app/console sonata:page:update-core-routes --site=1
php app/console sonata:page:create-snapshots --site=1
