
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)

# Esteren Maps library

## Frontend

The map frontend is managed with a Javascript library developed around [LeafletJS](http://leafletjs.com).

All the JS files must be concatenated together for the library to work.

## Services

To use the different services provided by the `EsterenMapsBundle`, you must load the registry like this:

```php
/**
 * @var EsterenMaps\MapsBundle\Services\Registry $esterenMaps
 */
$esterenMaps = $this->container->get('esteren_maps');
```

Then, with auto-completion in IDEs you can retrieve all other services.

## Tiles generation

When you have a Map and its background saved in your app, you must generate map tiles for it to be viewable in front.

For this, run this command:

```bash
$ app/console esterenmaps:map:generate-tiles
```

It will use [ImageMagick](http://www.imagemagick.org) and the [Orbitale ImageMagickPHP](https://github.com/Orbitale/ImageMagickPHP)
 command wrapper to generate tiles of 128x128px.
