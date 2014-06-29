#!/bin/sh
php bin/console assets:install
php bin/console assetic:dump --env=dev_fast --watch --force