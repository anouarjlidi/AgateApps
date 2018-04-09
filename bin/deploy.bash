#!/bin/bash

#     _
#    / \    Disclaimer!
#   / ! \   Please read this before continuing.
#  /_____\  Thanks ☺ ♥
#
# This is the deploy script used in production.
# It runs scripts that are mandatory after a deploy.
# It also updates RELEASE_VERSION and RELEASE_DATE environment vars,
# and saves the values in env files for CLI and webserver.

# bin/ directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Project directory
cd ${DIR}/../

ENV_FILE="./.env"
CLI_FILE="../env"
NGINX_FILE="../env_nginx.conf"

LAST_VERSION=$(grep -o -E "RELEASE_VERSION.*[0-9]+.*" ${CLI_FILE} | sed -r 's/[^0-9]+//g')
NEW_VERSION=$(expr ${LAST_VERSION} + 1)
LAST_DATE=$(grep -o -E "RELEASE_DATE=\"?[^\"]+\"?" ${CLI_FILE} | sed -r 's/^.*="?([^"]+)"?$/\1/g')
NEW_DATE=$(date --iso-8601=seconds)

echo "[DEPLOY] > Current version: ${LAST_VERSION}"
echo "[DEPLOY] > Last build date: ${LAST_DATE}"

if [[ -f ${CLI_FILE} ]]
then
    echo "[DEPLOY] > Loading env file"
    source ${CLI_FILE}
fi

echo "[DEPLOY] > Executing scripts..."
echo "[DEPLOY] > "

#composer ins --no-dev --optimize-autoloader --classmap-authoritative --prefer-dist
#
#php bin/console cache:clear --no-warmup
#php bin/console cache:warmup
#
#php bin/console doctrine:schema:validate || exit 1
#
#npm install
#
#npm run-script deploy

echo "[DEPLOY] > Done!"
echo "[DEPLOY] > Now updating environment vars..."
echo "[DEPLOY] > New version: ${NEW_VERSION}"
echo "[DEPLOY] > New build date: ${NEW_DATE}"

sed -i -e "s/RELEASE_VERSION=.*/RELEASE_VERSION=\"v${NEW_VERSION}\"/g" ${ENV_FILE}
sed -i -e "s/RELEASE_VERSION=.*/RELEASE_VERSION=\"v${NEW_VERSION}\"/g" ${CLI_FILE}
sed -i -e "s/RELEASE_VERSION .*/RELEASE_VERSION \"v${NEW_VERSION}\";/g" ${NGINX_FILE}

sed -i -e "s/RELEASE_DATE=.*/RELEASE_DATE=\"${NEW_DATE}\"/g" ${ENV_FILE}
sed -i -e "s/RELEASE_DATE=.*/RELEASE_DATE=\"${NEW_DATE}\"/g" ${CLI_FILE}
sed -i -e "s/RELEASE_DATE .*/RELEASE_DATE \"${NEW_DATE}\";/g" ${NGINX_FILE}
