
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

## Views

Contrary to [Symfony's recommendations and best practices](http://symfony.com/doc/current/best_practices/templates.html#template-locations),
we need the bundles to be the most standalone possible, so the views are kept inside each bundle.
Only the base template and the EasyAdmin ([view below](#backoffice)) views are stored in `app/Resources/views`,
 as of the layout & includes and form themes.

## CMS

With [OrbitaleCmsBundle](https://github.com/Orbitale/CmsBundle), a very simple CMS is handled for every configured
 subdomains. Each can have its own CMS as long as every `Page` object is configured with the `host` property.

## Backoffice

The backoffice is powered by [EasyAdminBundle](https://github.com/javiereguiluz/EasyAdminBundle).
Its configuration resides in [app/config/_easyadmin.yml](../app/config/_easyadmin.yml) and
 [app/config/admin](../app/config/admin).
An `AdminBundle` exists only to store the `AdminController` which allows complete override of any of EasyAdmin's feature.

[IvoryCKEditorBundle](https://github.com/egeloen/IvoryCKEditorBundle) is installed and configured in the `Page` entity
 to use a WYSIWYG.

## Maximal configuration evolutivity (a bit exaggerating, though)

You may notice that the classic `app/config/config.yml` is left **unchanged** compared to Symfony standard edition.
All application-related config is written in [app/config/_app.yml](../app/config/_app.yml).

Why?

Because there is nothing in the Standard edition that facilitates new versions upgrade, so all that's possible to upgrade
 the Standard Edition is a dirty copy/paste. Having files unchanged makes the diffs easier when upgrading.

Be careful that `config_dev.yml` and `config_prod.yml` files **must** import `_app.yml` instead of `config.yml`.
This way, the base config is left unchanged, and `config.yml` is included **after** `_app.yml`.

Some pretty spaces are also added in `AppKernel.php` and `composer.json` to separate Symfony's default configuration to
 the application specific config.

## Tests

Tests are located in the associated bundles, but global configuration is in the root directory.

The bootstrap file and the default `WebTestCase` class are located in the `tests/phpunit/` directory.

For now, there's only PHPUnit, but maybe one day there'll be `behat` or `phpspec` tests to be runned, this is why there
 is another directory level to allow this more easily.

## Users

Users are managed with [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle).

A simple `UsersBundle` exists to contain some fixtures and the `User` entity to be used in the whole application.
It's important to note that this bundle **extends FOSUserBundle**, because in the future we might need to tweak/override
 the behavior of some FormTypes or controllers (because there's a project of merging users from different platforms).
 
### Security

Now all security authenticators have to be created in this bundle as a Guard Authenticator.
 
**Note:** I wish to get rid of `FOSUserBundle` one day, because we will need different types of authentication.
At least we could have the model and the user provider, but it could be much better to have a fully custom user
 management system.
