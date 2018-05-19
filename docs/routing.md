
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

## Note

As said in the [Readme](../README.md#subdomains), domains **must** be configured.

## Locale

All routes are automatically prepended with the locale.
You **must** be aware of this when creating new routes, because every part of the app has to be translated.

You can check the [config/routes.yaml](config/routes.yaml).

For the rest, some package routes can be overriden in `config/routes/`.
