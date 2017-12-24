
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
Its configuration resides in [app/config/_easy_admin.yml](../app/config/_easyadmin.yml) and
 [app/config/admin/](../app/config/admin/) directory.
An `AdminBundle` exists only to store the `AdminController` which allows complete override of any of EasyAdmin's feature
(it also registers the `admin` directory as resource files so container is recompiled when one changes).

[IvoryCKEditorBundle](https://github.com/egeloen/IvoryCKEditorBundle) is installed and configured in the `Page` entity
 to use a WYSIWYG.

## Tests

Tests are located in the associated bundles, but global configuration is in the root directory.

The bootstrap file and the default `WebTestCase` class are located in the `tests/` directory.

For now, there's only PHPUnit.

There's a CI script located in `tests/ci/ci.bash` that should be runned on CI servers.

## Users

Users are managed with a port of some features from `FOSUserBundle` into the `Agate` namespace.

### Security

Now all security authenticators have to be created in this bundle as a Guard Authenticator.

Only one authenticator is needed for now, but some may be added in the future for _"Login with ..."_ login capabilities.
