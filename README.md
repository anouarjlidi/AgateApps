Esteren full portal
========================

This project is a full-stack Symfony application.

It was created in September 2013 with Symfony 2.3, but the different concepts and reflections started in March 2013.

Now it's on Symfony 3!

Since, it has followed all Symfony updates, and has been refactored countless times.

It contains multiple apps:

* The Esteren portal.
* The Games portal.
* Esteren Maps, an application that allows users to navigate in the different configured maps, calculate directions and
 imagine scenarios based on travels.
* Corahn-Rin, this is the V2 of the first [Corahn-Rin project](https://github.com/Esteren/CorahnRinV1). The goal of this
 application is to provide a character generator, a manager (to help the character grow up in skills!), and a virtual
 campaign board, where game leaders can invite players and reward characters in XP and treasures.

## Documentation index

* [Routing](docs/routing.md)
* [General technical informations](docs/technical.md)
* [Set up a vhost](docs/vhosts.md)
* [API / webservices](docs/api.md)
* [Esteren Maps library](docs/maps.md)
* [Deploy](docs/deploy.md)

## Pre-requisites

* PHP 5.6+
* NodeJS 4.0+ and `npm` accessible globally.
* Imagemagick accessible globally or at least from the app, mostly `convert` and `identify` binaries.

## Install

```bash
$ composer install
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create
```

Composer is configured to install npm dependencies and dump assets. See
[composer.json](composer.json) scripts configuration for more informations.

Next, you need to set up your environment to fit our stack.

## Setup

### Subdomains

You need to be sure that your webserver points to every domain name set up in the parameters,
 see [the default app/config/parameters.yml.dist file](app/config/parameters.yml) to know what domains are used.

You can set up the app on both Nginx and Apache, thanks to the [vhosts](docs/vhosts.md) provided by the docs.

### Fixtures (if you don't have a proper database export to be imported)

If you don't have a prod database export, load the fixtures in your database:

```bash
$ bin/console doctrine:fixtures:load --append
```

### Assets management

Most of the CSS comes from LESS files, and all JS/CSS files are compiled with Gulp.

We use a specific gulpfile from [Orbitale/Gulpfile](https://github.com/Orbitale/Gulpfile) which allows good
flexibility and is based only on one config variable (similar to Grunt).

You can use `gulp watch` when you are working with assets so they're compiled on-change.

## Tests

To run the tests, get the config from the `tests` directory:

```bash
$ vendor/bin/phpunit -c tests/
```

## Issues tracking

For any question or problem, please open a new issue on Redmine depending on the subject:

| Subject                        | Redmine project
| ------------------------------ | ---------------
| Corahn-Rin (character manager) | [corahn-rin-dev](http://redmine.pierstoval.com/projects/corahn-rin-dev/issues)
| Esteren Maps                   | [esteren-maps](http://redmine.pierstoval.com/projects/esteren-maps/issues)
| Portal (normal or games)       | [portail-esteren](http://redmine.pierstoval.com/projects/portail-esteren/issues)
| Other                          | [apps](http://redmine.pierstoval.com/projects/apps/issues)

Any issue on Github will be transformed into a Redmine ticket.

## License

View the joined [license file](LICENSE) to know about uses rights.
