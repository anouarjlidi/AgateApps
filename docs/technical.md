
#### Documentation index

* **[README](../README.md)**
* [Routing](routing.md)
* General technical informations
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# General technical informations

## Backoffice

The backoffice is powered by [EasyAdminBundle](https://github.com/javiereguiluz/EasyAdminBundle).
Its configuration resides in [config/packages/_easy_admin.yml](../config/packages/easy_admin.yaml).

A few other `easy_admin_*.yaml` also exist to avoid having everything in the same file.

An `Admin` namespace exists only to store the `AdminController` which allows complete override of any of EasyAdmin's.

## Tests

Tests use an `sqlite` database for max performances. There is a `WebTestCase` that provides a `resetDatabase()` method
to make sure tests don't take too long to reset database.

Also, the [tests/bootstrap.php](../tests/bootstrap.php) file creates the database and make some checks for easier and
faster testing.

For now, there's only PHPUnit.

## Users

Users are managed with a port of some features from `FOSUserBundle` into the `User` namespace.

And of course, we obliterated `FOSUserBundle` requirement from our dependencies.

### Security

Now all security authenticators have to be created in this bundle as a Guard Authenticator.

Only one authenticator is needed for now, but some may be added in the future for _"Login with ..."_ login capabilities.

We will actually need to log in the previous project (the [CorahnRinV1](https://github.com/StudioAgate/CorahnRinV1) 
project), and possibly the [Esteren forums](https://www.esteren.org/forum/) and
[Agate forums](https://forum.studio-agate.com).

The best thing would be to have something like an _"Agate Connect"_ concept that would store the same users at the same
place so our users wouldn't have to log in again on every website, but I don't have the time yet to implement such
feature as I'm not really familiar with it.
