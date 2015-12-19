
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)

# Routing

> ## Note 
> As said in the [Readme](../README.md#subdomains), domains **must** be configured.
> To be able to debug APIs, don't forget to set up your `allowed_origins` configuration options in `app/config/_app.yml`.

## Multiple files

The routing load order is the following:

* FOSUser, which are loaded globally for every domain
* CorahnRin (character manager), under `%esteren_domains.corahn_rin%` host.
* Esteren Maps, under `%esteren_domains.esteren_maps%` host.
* Root (the `/` route), which simply redirects to `/%locale%/` to handle the route for all subdomains.
* PierstovalTools' `AssetsController`, which allows loading a javascript file containing translations (and caching it).
 Also available for all subdomains.
* PierstovalApi's webservices, all loaded under the `%esteren_domains.api%` host.
* Admin routes, under `%esteren_domains.backoffice%` host. Also LexikTranslation's routes that are under EasyAdmin's
 layout to have it accessible in the backend more easily.
* All other portals, they lie under all subdomains to be handled by OrbitaleCmsBundle ([view below](#cms)).


## Locale

All routes are manually prepended with the locale.
You **must** be aware of this when creating new routes, because every part of the app has to be translated.

## CMS

The [OrbitaleCmsBundle](https://github.com/Orbitale/CmsBundle) is plugged to every subdomain to be sure that a simple
 web portal is available for all websites. Mostly, it'll be used for the main and games portals, but with this config we
 might add static pages (promotions, etc.) to every website without harm.

As a reminder, the routes of this bundle are so dynamic that they **must** be used as a fallback **after** all routes.

As explained in the bundle's documentation, `/page/children/subchildren` tree-like routes can be used automatically with
 the controller, so to avoid any conflict, all other routes must be declared **before** Orbitale's CMS ones.

### Homes

As any portal will be handled by the CMS, you can create pages that will be used as homepages (if you trigger the `home`
 checkbox in the backend).

You may encounter a `No homepage has been configured. Please check your existing pages or create a homepage in your
application.` error, one day.

It's verbose enough to explain you that no homepage is configured.

You should then go to the backend and create a page, associate it (or not) to the so-requested subdomain (the portal, or
 any other configured domain) and publish the page. You should now see your homepage!