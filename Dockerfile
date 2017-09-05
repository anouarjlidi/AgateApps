# See: https://github.com/StudioAgate/DockerPortalApp
FROM pierstoval/studio-agate-portal

# Install composer dependencies first
COPY composer.* /var/www/html/
COPY app/App*.php /var/www/html/app/
RUN composer --working-dir=/var/www/html install --optimize-autoloader --no-interaction --prefer-dist --no-scripts --no-progress

# Install node dependencies afterwards
COPY ./package.json /var/www/html/package.json
COPY ./yarn.lock /var/www/html/yarn.lock
COPY ./gulpfile.js /var/www/html/gulpfile.js
RUN yarn install

# Same directories used for nginx
COPY . /var/www/html
COPY ./docker/app/parameters.yml /var/www/html/app/parameters.yml

# Run gulp after resources are loaded
RUN /var/www/html/node_modules/.bin/gulp4 dump --prod
