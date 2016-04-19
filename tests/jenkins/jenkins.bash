#!/bin/bash

echo "Working directory:"
pwd

# Get composer
curl -sS https://getcomposer.org/installer | php

cp tests/jenkins/parameters.yml app/config/parameters.yml

export SYMFONY_ENV='test'

# Install dependencies
php composer.phar install -o

# Execute tests
vendor/bin/phpunit -c tests --coverage-text --coverage-clover build/logs/clover.xml

