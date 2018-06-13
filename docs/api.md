
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# API / webservices

The webservices are a big part of Esteren Maps, because the Javascript library developed for it makes a lot of use of
 AJAX queries to retrieve contents, but the Maps backend also use these webservices to handle object updates.

Everything is, for now, handled manually, and was written by hand, instead of using an external bundle.

For now, we only need a few endpoints:

* Retrieve a map with **all** its details, in edit mode or classic mode.
* Update map resources from the interactive editor (routes, markers and zones).
* Calculate directions.

## CORS configuration

First, check out [what is CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing).

When using the backoffice to manage the map, we face a problem:
the backend is under one subdomain, usually `back.esteren.docker` in dev, and the webservices are under another
subdomain, usually `api.esteren.docker`.

To manage non-GET HTTP requests, a full setup must be configured in your app.

If you are developing locally, you won't be able to access the webservices "manually" because they're protected by
[NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle)'s configuration (check in `config/_app.yml`).

For this, you may have to allow `127.0.0.1` as a valid origin, but this is quite exceptional.

The same kind of requirement is also added to `PierstovalApiBundle` so be sure you don't face any issue in debugging
 the webservices results.

## Problems that you may encounter

If CORS requests fail, be sure that all domains are configured.

Also, make sure that `always_populate_raw_post_data` is set to `-1` in your `php.ini`, because Ajax requests are made 
with a raw payload encoded in JSON, and some PHP configurations need this to avoid populating the `$HTTP_RAW_POST_DATA` 
var, which is deprecated, and the deprecation may trigger an error that would send text to the browser before sending 
the response, and not allow the application to send the correct CORS headers.
