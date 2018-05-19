
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
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

Users are managed with a port of some features from `FOSUserBundle` into the `Agate` namespace.

### Security

Now all security authenticators have to be created in this bundle as a Guard Authenticator.

Only one authenticator is needed for now, but some may be added in the future for _"Login with ..."_ login capabilities.
