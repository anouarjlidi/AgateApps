#!/bin/bash

# Make sure we're in the right directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd ${DIR}

echo "Working directory:"
pwd

echo "Installing composer"
curl -sS https://getcomposer.org/installer | php

# Backup any existing parameters file.
if [ -f app/config/parameters.yml ]; then
    if ! grep -q "# Jenkins file" "app/config/parameters.yml"; then
        echo "Backing up parameters.yml file"
        mv app/config/parameters.yml app/config/parameters.yml.backup
    fi
fi

echo "Update parameters and phpunit file for jenkins"
cp tests/jenkins/parameters.yml app/config/parameters.yml
cp tests/jenkins/phpunit.xml tests/phpunit.xml

export SYMFONY_ENV='test'

echo "Install dependencies"
php composer.phar install -o --no-interaction

echo "Execute tests"
phpunit -c tests/phpunit.xml --coverage-text --coverage-clover build/logs/clover.xml

if [ -f app/config/parameters.yml.backup ]; then
    echo "Retrieve backed up parameters file"
    mv app/config/parameters.yml.backup app/config/parameters.yml
fi
