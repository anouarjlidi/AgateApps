#!/bin/bash

# Copyright © 2015 Alex Rock Ancelet <alex@orbitale.io>
# Under MIT license. Feel free to re-use, but don't forget credits ;)
# Original file: https://gist.github.com/Pierstoval/88650af7942ab381c893

NL=$'\n'

SFENV=$1
if [[ -z "$SFENV" ]]
then
    SFENV="dev"
fi

if echo "$SFENV" | grep -E '^dev|prod|test$' > /dev/null
then
        echo "Check env $SFENV"
else
        echo "First argument must be a valid environment: dev, prod or test"
        echo "Given: $SFENV"
        exit 1
fi

CONSOLECMD="php app/console --env=$SFENV "

echo $NL
echo "Welcome to Symfony's application resetter!"

echo $NL
echo "================"
echo "Remove cache and assets"
rm -rf app/cache/* web/bundles/*

echo $NL
echo "================"
echo "> Delete and recreate the whole database"
${CONSOLECMD} doctrine:database:drop --force
${CONSOLECMD} doctrine:database:create
${CONSOLECMD} doctrine:schema:create

checkFixturesEnabled=`${CONSOLECMD} list doctrine -n --no-ansi | grep "doctrine:fixtures:load"`
if [ -n "checkFixturesEnabled" ]
then
    echo $NL
    echo "================"
    echo "> Load fixtures"
    ${CONSOLECMD} doctrine:fixtures:load --append
fi

checkFosUserEnabled=`${CONSOLECMD} list -n --no-ansi | grep "fos:user:create"`
if [ -n "checkFosUserEnabled" ]
then
    echo "> Create a basic superadmin user"
    ${CONSOLECMD} fos:user:create --super-admin admin admin@localhost admin
fi

echo $NL
echo "================"
echo "> Force recreation of the assets in relative mode"
${CONSOLECMD} assets:i --symlink --relative

echo $NL
echo "================"
echo "> Compile assetic files"
${CONSOLECMD} assetic:dump

echo $NL
echo "================"
echo "Finished !"
echo $NL

if [ -n "$checkFosUserEnabled" ]
then
    echo "INFO: If you used this function in production, please note that you must change the user password by executing this command:"
    echo "${CONSOLECMD} fos:user:change-password admin newPassword"
    echo $NL
fi
