
[![CircleCI](https://circleci.com/gh/Pierstoval/AgateApps.svg?style=svg&circle-token=9dd9f3351a54a5f47ce078a4ad2ce589dedec8d7)](https://circleci.com/gh/Pierstoval/AgateApps)


Esteren full portal
========================

This project is a full-stack Symfony application.

It was created in September 2013 with Symfony 2.3, but the different concepts and reflections started in March 2013.

Since, it has followed all Symfony updates, and has been refactored countless times.

It contains multiple apps:

* The Esteren portal.
* The Games portal.
* Agate portal, and other portals like Vermine, mostly as static pages.
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

* PHP 7.2+
* NodeJS 8.0+ and `npm` accessible globally.
* Imagemagick accessible globally or at least from the app, mostly `convert` and `identify` binaries.

## Install

```bash
$ cp .env.dist .env
$ composer install
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create
$ bin/console doctrine:fixtures:load --append
```

Composer is configured to install node dependencies and dump assets. See
[composer.json](composer.json) scripts configuration for more informations.

Next, you need to set up your environment to fit our stack.

### (optional) Install Esteren Maps base tiles.

If you need to install Esteren Maps, you also need to generate the fixture tiles.

Check the [Esteren Maps](docs/maps.md#tiles-generation) documentation for this.

## Setup

### Subdomains

You need to be sure that your webserver listens to every domain name set up in the application.

You can configure the main domain in `.env`, let's check the default at [.env.dist file](/.env.dist).

There are a lot of subdomains that are linked to this application, so make sure each and anyone of them
is well listened by your webserver: you can set up the app on both Nginx and Apache, thanks to the
[vhosts](docs/03_vhosts.md) provided by the docs.

To view the list of all subdomains, check the [_app.yml](app/config/_app.yml) file.

#### Windows

Be sure that your `C:\Windows\System32\drivers\etc\hosts` file contains redirections for all subdomains defined in the
 app's configuration.
 
#### Linux and OSX

Install [dnsmasq](https://fr.wikipedia.org/wiki/Dnsmasq) if not already installed, and you can use
 `address=/dev/127.0.0.1` as basic configuration to tell your machine to resolve every `*.dev` host to your local
 machine.
 
This is easier for you then to just create a vhost with all `esteren.dev` or `studio-agate.dev` subdomains.

Or you can just edit the `/etc/hosts` and add an entry to resolve `.dev` domains as local, one by one. 

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

Note that we're using Gulp 4, so you should either install it globally, or just run `./node_modules/.bin/gulp4` to use.

## Tests

To run the tests, just run phpunit:

```bash
$ ./vendor/bin/phpunit
```

### Use the database for tests

If you **do not want to reset the database**, you can add the `NO_RECREATE_DB` env var.

```bash
$ NO_RECREATE_DB=1 phpunit
```

If you are using the database, there will be a first Sqlite file written after creating the schema and importing
the fixtures, and this file will serve as a reference for all tests until deleted.
If you want, you can force the tests to rewrite the whole database by using this environment variable:

```bash
$ RECREATE_DB=1 phpunit
```

Read the [bootstrap.php](tests/bootstrap.php) file to see these env vars in use. 


### CI

We are using [CircleCI](https://circleci.com/gh/Pierstoval/AgateApps). 

A [tests/ci/ci.bash](tests/ci/ci.bash) file has been created and it executes everything we need, based on some env vars.
 But it does not work for now. So we're using [.circleci/config.yml](.circleci/config.yml) file to configure CI properly.

## Issues tracking

For any question or problem, please open a new issue on Redmine depending on the subject:

| Subject                        | Redmine project
| ------------------------------ | ---------------
| Corahn-Rin (character manager) | [corahn-rin-dev](http://redmine.pierstoval.com/projects/corahn-rin-dev/issues)
| Esteren Maps                   | [esteren-maps](http://redmine.pierstoval.com/projects/esteren-maps/issues)
| Portal (normal or games)       | [portail-esteren](http://redmine.pierstoval.com/projects/portail-esteren/issues)
| Other                          | [apps](http://redmine.pierstoval.com/projects/apps/issues)

Any issue on Github will have to be transformed into a Redmine ticket. So please, no Github issue.

## License

View the joined [license file](LICENSE) to know about uses rights.
