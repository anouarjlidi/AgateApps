
[![CircleCI](https://circleci.com/gh/Pierstoval/AgateApps.svg?style=svg&circle-token=9dd9f3351a54a5f47ce078a4ad2ce589dedec8d7)](https://circleci.com/gh/Pierstoval/AgateApps)


Esteren full portal
========================

This project is a full-stack Symfony application.

It was created in September 2013 with Symfony 2.3, but the different concepts and reflections started in March 2013.

Since, it has followed all Symfony updates, and has been refactored countless times.

It contains multiple apps:

* The Esteren portal.
* The Agate portal.
* The Dragons portal.
* The Vermine 2047 portal.
* The Games portal, which is still WIP at that time.
* **Esteren Maps**, an application that allows users to navigate in the different configured maps, calculate directions and
 imagine scenarios based on travels.
* **Corahn-Rin**, this is the V2 of the first [Corahn-Rin project](https://github.com/Esteren/CorahnRinV1). The goal of this
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

Simply use **Docker**. If you want to use something else, you can reverse-engineer necessary dockerfiles or vhosts.

## Install

```bash
$ make install
```

Check the [Makefile](Makefile) if you want to know what this `install` target does.

TL;DR: it does build the Docker images, start them, install the vendors, set up database, insert fixtures, dump public
assets and EsterenMap map tiles.

## Setup

First thing to manually do:

```bash
$ cp .env.dist .env
```

You **must** configure this file yourself with n

### Subdomains

There are multiple subdomains to configure in the project to make it work: API, backend, portals, etc.

You need to be sure that your environment is capable of using the hosts that are configured in the project.

By convention, all domains might end with `.docker`, but it depends on your preferences.

Check the default domains at [.env.dist file](/.env.dist), and update your `.env` file accordingly.

#### With a DNS software

On Linux and MacOS, you can use `dnsmasq` (if you know how to configure it properly) to redirect all `.docker` hosts
to your local host, with a configuration like this:

```ini
address=/docker/127.0.0.1
```

On Windows you can use [Acrylic](http://mayakron.altervista.org/wikibase/show.php?id=AcrylicHome) (if you know how to
configure it properly), or you can use hosts files.

#### With hosts file

On Windows (and on Linux and MacOS too) you can update your machine's hosts file to make your browser able to load your
custom domain names for Agate project.

Example of host files:

```ini
127.0.0.1 esteren.docker
127.0.0.1 www.studio-agate.docker
# ...
```

On Windows, the hosts file is located in `C:\Windows\System32\drivers\etc\hosts` and must be edited with administrator
permissions.

On Linux and MacOS, the host file is in `/etc/hosts` and must be edited with root permissions.

### Assets management

Most of the CSS comes from LESS files for Bootstrap, SASS for materialize, and all JS/CSS files are compiled
with Gulp.

We use a specific gulpfile from [Orbitale/Gulpfile](https://github.com/Orbitale/Gulpfile) which allows good
flexibility and is based only on one config variable (similar to Grunt).

## Tests

To run the tests, just run phpunit:

```bash
$ make phpunit
```

### CI

We are using [CircleCI](https://circleci.com/gh/Pierstoval/AgateApps).

Linting tests and phpunit are executed there for both PHP and NodeJS.

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
