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
* [Corahn Rin / Character manager](docs/character_manager.md)
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
$ bin/console doctrine:fixtures:load --append
```

Composer is configured to install npm dependencies and dump assets. See
[composer.json](composer.json) scripts configuration for more informations.

Next, you need to set up your environment to fit our stack.

### (optional) Install Esteren Maps base tiles.

If you need to install Esteren Maps, you also need to generate the fixture tiles.

Check the [Esteren Maps](docs/maps.md#tiles-generation) documentation for this.

## Setup

### Subdomains

You need to be sure that your webserver listens to every domain name set up in the application.

You can configure the main domain in `parameters.yml`, let's check the default at  [parameters.yml.dist file](app/config/parameters.yml).

There are a lot of subdomains that are linked to this application, so make sure each and anyone of them
is well listened by your webserver: you can set up the app on both Nginx and Apache, thanks to the
[vhosts](docs/03_vhosts.md) provided by the docs.

To view the list of all subdomains, check the [_app.yml](app/config/_app.yml) file.

### Fixtures (if you don't have a proper database export to be imported)

If you don't have a prod database export, load the fixtures in your database:

```bash
$ bin/console doctrine:fixtures:load --append
```

### Assets management

Most of the CSS comes from LESS files for Bootstrap, SASS for materialize, and all JS/CSS files are compiled
with Gulp.

We use a specific gulpfile from [Orbitale/Gulpfile](https://github.com/Orbitale/Gulpfile) which allows good
flexibility and is based only on one config variable (similar to Grunt).

You can use `gulp watch` when you are working with assets so they're compiled on-change.

## Tests

To run the tests, just run phpunit:

```bash
$ phpunit
```

### Use the database for tests

If you **do not want to reset the database**, you can add the `TESTS_NO_DB` env var.

```bash
$ TESTS_NO_DB=1 phpunit
```

If you are using the database, there will be a first Sqlite file written after creating the schema and importing
the fixtures, and this file will serve as a reference for all tests until deleted.<br>
If you want, you can force the tests to rewrite the whole database by using this environment variable:

```bash
$ TESTS_REWRITE_DB=1 phpunit
```

### CI

There's no working CI at the moment.

We might use either Jenkins or Travis-CI.

As none of them is easily configurable (Jenkins must be configured on a dedicated server, Travis-CI is not free for private projects), a `tests/ci/ci.bash` file has been created in case of (tested & working on a small jenkins server).

Also, a `.travis.yml` file exists too, but needs more configuration (maybe we'll use the same CI file too).

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
