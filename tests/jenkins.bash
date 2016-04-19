#!/bin/bash

# Get composer
curl -sS https://getcomposer.org/installer | php

# Install dependencies
php composer.phar install

# Execute tests
vendor/bin/phpunit -c tests
