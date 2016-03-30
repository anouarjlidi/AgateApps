
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Deploy](deploy.md)

# Esteren Maps library

## Frontend

The map frontend is managed with a Javascript library developed around [LeafletJS](http://leafletjs.com).

All the JS files must be concatenated together for the library to work.

### AJAX load

The map settings and data are loaded by different calls to the `EsterenMap._load()` method.

The stack is the following:

1. `new EsterenMap(options)`: New object creation, setup base and some static options.
2. `EsterenMap.loadSettings()`: Load the settings with Ajax by loading the `maps/settings/{id}` route.
3. `EsterenMap.initialize()`: This function sets up the different Leaflet layers and components.
4. `EsterenMap._mapOptions.loadedCallback()`: By default, this function loads **markers**, **routes**, **zones** and
 **transports**.

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
$ bin/console esterenmaps:map:generate-tiles
```

It will use [ImageMagick](http://www.imagemagick.org) and the [Orbitale ImageMagickPHP](https://github.com/Orbitale/ImageMagickPHP)
 command wrapper to generate tiles of 128x128px.

## Directions

Directions are calculated by the [DirectionsManager](../src/EsterenMaps/MapsBundle/Services/DirectionsManager.php).

Each time a direction is asked by an end-user, it is cached to avoid consuming too much resource when resolving Dijkstra's
 algorithm to calculate the best direction.

The cache key is calculated simply by all the arguments.

### Distance calculation

Distances are automatically calculated based on Pythagore's theorem with all coordinates of all points of the Route.

BUT, one can set the `forcedDistance` field, so if it is set, it forces (wow...) the `distance` attribute to be set 
 identically as `forcedDistance`. This helps to hijack the distance if the visual map does not correspond enough to what
 you would like to have in your map.

### Clear Directions cache

This cache can be cleared like any other cache by the `bin/console cache:clear` command, depending on your environment.

But it is also **automatically** cleared when you update any Maps-related entity.
Check the [CacheClearSubscriber](../src/EsterenMaps/MapsBundle/DoctrineListeners/CacheClearSubscriber.php) class. 

#Again design pattern concerns: When creating a doctrine listener, is it better to chain "instanceof" instructions, or to create an empty interface?
