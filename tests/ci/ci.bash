#!/bin/bash

# Get ci.bash directory name
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Get root project directory name
DIR=`readlink -m "${DIR}/../../"`

# Change directory to root directory so all commands are executed from there
cd ${DIR} || exit 100

echoPrefix="[CI SCRIPT] -"

echo "$echoPrefix====================================================="
echo "$echoPrefix Working directory:"
pwd

echo "$echoPrefix====================================================="
echo "$echoPrefix Installing composer"
curl -sS https://getcomposer.org/installer | php || exit 110

echo "$echoPrefix====================================================="
echo "$echoPrefix Backup any existing parameters file."
if [ -f app/config/parameters.yml ]; then
    if ! grep -q "# CI file" "app/config/parameters.yml"; then
        echo $echoPrefix"====================================================="
echo "$echoPrefix Backing up parameters.yml file"
        mv app/config/parameters.yml app/config/parameters.yml.backup
    fi
fi

echo "$echoPrefix====================================================="
echo "$echoPrefix Update parameters and phpunit file for CI"
cp tests/ci/parameters.yml app/config/parameters.yml || exit 120

echo "$echoPrefix====================================================="
echo "$echoPrefix Setup environment variables"
export SYMFONY_ENV='test'
export SYMFONY_DEBUG=1
export RECREATE_DB=1

echo "$echoPrefix====================================================="
echo "$echoPrefix Install Composer dependencies"
php composer.phar install --classmap-authoritative --no-interaction --no-scripts || exit 130

echo "$echoPrefix====================================================="
echo "$echoPrefix Testing environment capabilities and Symfony requirements"
php bin/symfony_requirements

echo "$echoPrefix====================================================="
echo "$echoPrefix Execute tests"

if [[ -z "$PHPUNIT_PARAMETERS" ]]; then
    export PHPUNIT_PARAMETERS=" --coverage-text --coverage-clover build/logs/clover.xml "
fi

if [ -f ./vendor/bin/phpunit ]; then
    phpunit_script="./vendor/bin/phpunit"
else
    phpunit_script="./vendor/bin/simple-phpunit"
fi

echo "$echoPrefix====================================================="
echo "[TESTS] PHPUnit"
${phpunit_script} ${PHPUNIT_PARAMETERS}

echo "$echoPrefix====================================================="
echo "[TESTS] Behat"
./vendor/bin/behat

echo "$echoPrefix====================================================="
echo "[TESTS] Symfony linters & security"
php bin/console security:check
php bin/console lint:twig app/Resources src
php bin/console lint:yaml app/config
php bin/console lint:yaml src
php bin/console debug:translation --only-missing --all fr
php bin/console debug:translation --only-missing --all en

if [ -f app/config/parameters.yml.backup ]; then
    echo "$echoPrefix====================================================="
    echo "$echoPrefix Retrieve backed up parameters file"
    cp app/config/parameters.yml.backup app/config/parameters.yml
fi
