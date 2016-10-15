FROM php:7.1-fpm

RUN apt-get update

# Install needed packages
RUN apt-get install -y apt-utils

RUN apt-get install -y \
    zlib1g-dev \
    g++ \
    libcurl3 libcurl3-dev libjpeg-dev libpng-dev libicu-dev \
    build-essential

# Install needed php extensions
RUN docker-php-ext-configure gd
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure pdo_mysql
RUN docker-php-ext-configure zip
RUN docker-php-ext-install apcu

RUN docker-php-ext-install gd
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install apcu

# Now install nodejs and packages

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -
RUN apt-get install -y  nodejs
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn
RUN export PATH=$PATH:$PWD/node_modules/.bin
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -

# Composer is always used as root in our container
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install composer and prestissimo for faster dependency installation
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

WORKDIR /var/www/html

# Install composer dependencies first
COPY composer.* /var/www/html/
COPY app/App*.php /var/www/html/app/
RUN composer --working-dir=/var/www/html install --optimize-autoloader --apcu-loader --no-interaction --prefer-dist --no-scripts --no-progress

# Install node dependencies afterwards
COPY ./package.json /var/www/html/package.json
COPY ./yarn.lock /var/www/html/yarn.lock
COPY ./gulpfile.js /var/www/html/gulpfile.js
RUN yarn install

# Same directories used for nginx
COPY . /var/www/html
COPY ./docker/app/parameters.yml /var/www/html/app/parameters.yml

# Run gulp after resources are loaded
RUN ./node_modules/.bin/gulp4 dump --prod
