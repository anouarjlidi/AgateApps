#!/bin/bash

# Get ci.bash directory name
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Get root project directory name
DIR=`readlink -m "${DIR}/../../"`

# Change directory to root directory so all commands are executed from there
cd ${DIR} || exit 100

echoPrefix="[CI SCRIPT] -"

echo ""
echo "$echoPrefix Working directory:"
pwd

echo ""
echo "$echoPrefix Installing composer"
curl -sS https://getcomposer.org/installer | php || exit 110

echo ""
echo "$echoPrefix Backup any existing parameters file."
if [ -f app/config/parameters.yml ]; then
    if ! grep -q "# CI file" "app/config/parameters.yml"; then
        echo ""
echo "$echoPrefix Backing up parameters.yml file"
        mv app/config/parameters.yml app/config/parameters.yml.backup
    fi
fi

echo ""
echo "$echoPrefix Update parameters and phpunit file for CI"
cp tests/ci/parameters.yml app/config/parameters.yml || exit 120

echo ""
echo "$echoPrefix Setup environment variables"
export SYMFONY_ENV='test'
export SYMFONY_DEBUG=1
export RECREATE_DB=1

echo ""
echo "$echoPrefix Install Composer dependencies"
php composer.phar install -o --no-interaction --no-scripts || exit 130

echo ""
echo "$echoPrefix Testing environment capabilities and Symfony requirements"
php bin/symfony_requirements || exit 140

if [[ -z "$PHPUNIT_PARAMETERS" ]]; then
    export PHPUNIT_PARAMETERS=" --coverage-text --coverage-clover build/logs/clover.xml "
fi

if [ -f ./vendor/bin/phpunit ]; then
    phpunit_script="./vendor/bin/phpunit"
else
    phpunit_script="./vendor/bin/simple-phpunit"
fi

echo ""
echo "$echoPrefix Execute tests"
${phpunit_script} ${PHPUNIT_PARAMETERS}

if [ -f app/config/parameters.yml.backup ]; then
    echo ""
    echo "$echoPrefix Retrieve backed up parameters file"
    cp app/config/parameters.yml.backup app/config/parameters.yml
fi
