#!/bin/bash

#     _
#    / \    Disclaimer!
#   / ! \   Please read this before continuing.
#  /_____\  Thanks ☺ ♥
#
# This is the deploy script used in production.
# It does plenty tasks:
#  * Run scripts that are mandatory after a deploy.
#  * Update RELEASE_VERSION and RELEASE_DATE environment vars,
#  * Save the values in env files for CLI and webserver.
#  * Send by email the analyzed changelog (which might not be 100% correct, but it's at least a changelog).

# bin/ directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Project directory
cd ${DIR}/../

ENV_FILE="./.env"
CLI_FILE="../env"
NGINX_FILE="../env_nginx.conf"

echo "[DEPLOY] > Update repository branch"

git fetch origin

CHANGELOG=$(git changelog HEAD...origin/master | sed 1d)
CHANGELOG_SIZE=$(echo "${CHANGELOG}" | wc -l)
CHANGELOG_SIZE_CHARS=$(echo "${CHANGELOG}" | wc -m)
if [ "${CHANGELOG_SIZE_CHARS}" -lt "1" ]; then
    echo "[DEPLOY] > ${CHANGELOG}"
    echo "[DEPLOY] > No new commit! Terminating..."
    exit 1
else
    echo "[DEPLOY] > Retrieved $((CHANGELOG_SIZE)) commits(s) in changelog:"
    echo "[DEPLOY] > ${CHANGELOG}"
fi

echo "[DEPLOY] > Applying these commits..."
git merge origin/master

echo "[DEPLOY] > Done!"

LAST_VERSION=$(grep -o -E "RELEASE_VERSION.*[0-9]+.*" ${CLI_FILE} | sed -r 's/[^0-9]+//g')
NEW_VERSION=$(expr ${LAST_VERSION} + 1)
LAST_DATE=$(grep -o -E "RELEASE_DATE=\"?[^\"]+\"?" ${CLI_FILE} | sed -r 's/^.*="?([^"]+)"?$/\1/g')
NEW_DATE=$(date --rfc-3339=seconds)

echo "[DEPLOY] > Current version: ${LAST_VERSION}"
echo "[DEPLOY] > Last build date: ${LAST_DATE}"

if [[ -f ${CLI_FILE} ]]
then
    echo "[DEPLOY] > Loading env file"
    source ${CLI_FILE}
fi

echo "[DEPLOY] > Executing scripts..."
echo "[DEPLOY] > "

#
# These scripts are "wrapped" because they might have been updated between deploys.
# Only this "deploy.bash" script can't be updated, because it's executed on deploy.
# But having the scripts executed like this is a nice opportunity to update the scripts between deploys.
#
bash ./bin/deploy_scripts.bash

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

echo "[DEPLOY] > Restart web server..."
sudo service nginx reload
echo "[DEPLOY] > Done!"

read -d '' FULL_CHANGELOG << CHGLOG
New version: v${NEW_VERSION}
Released on: ${NEW_DATE}

Reminder of all portals:

* https://portal.esteren.org
* https://www.studio-agate.com
* https://maps.esteren.org
* https://corahnrin.esteren.org
* https://www.vermine2047.com

List of all changes/commits:
${CHANGELOG}
CHGLOG

echo "[DEPLOY] > FULL CHANGELOG"
echo ${FULL_CHANGELOG}

echo "[DEPLOY] > Sending email reminders..."

for TO in "pierstoval+esterenProd@gmail.com" "nelyhann+portal@gmail.com"
do
    php bin/console swiftmailer:email:send \
        --from=pierstoval@gmail.com \
        --to=${TO} \
        --subject="Deploy successful!" \
        --body="${FULL_CHANGELOG}" \
        --content-type=text/plain
done

echo "[DEPLOY] > Done!"
echo "[DEPLOY] > Deploy finished!"
