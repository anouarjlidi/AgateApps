#!/bin/bash

echo "Working directory:"
pwd

# Get composer
curl -sS https://getcomposer.org/installer | php

cp tests/jenkins/parameters.yml app/config/parameters.yml
cp tests/jenkins/phpunit.xml tests/phpunit.xml

export SYMFONY_ENV='test'

# Install dependencies
php composer.phar install -o

echo "Execute tests"

# Execute tests
vendor/bin/phpunit -c tests/phpunit.xml --coverage-text --coverage-clover build/logs/clover.xml

