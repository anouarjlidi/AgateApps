#!/bin/bash

echo "Working directory:"
pwd

# Get composer
curl -sS https://getcomposer.org/installer | php

# WARNING:
# Do not execute this script outside Jenkins, it could break your app.
cp tests/jenkins/parameters.yml app/config/parameters.yml
cp tests/jenkins/phpunit.xml tests/phpunit.xml

export SYMFONY_ENV='test'

# Install dependencies
php composer.phar install -o

echo "Execute tests"

# Execute tests
phpunit -c tests/phpunit.xml --coverage-text --coverage-clover build/logs/clover.xml

