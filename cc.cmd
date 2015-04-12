@echo off
php app/console cache:clear --no-warmup --env=prod
php app/console cache:clear --no-warmup --env=dev
