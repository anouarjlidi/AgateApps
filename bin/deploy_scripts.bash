#!/bin/bash

set -e

# bin/ directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Project directory
cd ${DIR}/../

composer ins --no-dev --optimize-autoloader --classmap-authoritative --prefer-dist

php bin/console cache:clear --no-warmup
php bin/console cache:warmup

php bin/console doctrine:schema:validate || exit 1

npm install

npm run-script deploy
