#!/bin/sh
php app/console assets:install
php app/console assetic:dump --env=dev_fast --watch --force