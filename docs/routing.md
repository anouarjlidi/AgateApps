
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# Routing

> ## Note
> As said in the [Readme](../README.md#subdomains), domains **must** be configured.

## Locale

All routes are automatically prepended with the locale.
You **must** be aware of this when creating new routes, because every part of the app has to be translated.

You can check the [routing/_main.yml](config/routing/_main.yml).

Base routing file only loads the `root` route and the `_main.yml` which loads all other routes

If something has to be specific to one locale, make sure your route has a requirement for this locale.

**Note:** Nested requirements don't work in Symfony. It means that if in `routing.yml` you import a file **with** 
 requirements like `_locale: %regexp%`, you **cannot** have other requirements in the Route annotation. Yml file will
 prevail.

## HTTPS

The whole `dev` environment is under `http`, and `prod` is under `https`, so you can't test prod locally without
 removing configuration in `config_dev.yml` or `config_prod.yml`.

## Multiple files

The routing load order is the following:

* Root (the `/` route), which simply redirects to `/%locale%/` to handle the route for all subdomains.
* User, which are loaded globally for every domain
* CorahnRin (character manager), under `%esteren_domains.corahnrin%` host.
* Esteren Maps, under `%esteren_domains.esterenmaps%` host.
* Agate portal, under `%agate_domains.portal%` host.
* PierstovalTools' `AssetsController`, which allows loading a javascript file containing translations (and caching it).
 Also available for all subdomains.
* PierstovalApi's webservices, all loaded under the `%esteren_domains.api%` host.
* Admin routes, under `%esteren_domains.backoffice%` host.
