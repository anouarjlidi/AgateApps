
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# Esteren Maps library

## Frontend

The map frontend is managed with a Javascript library developed around [LeafletJS](http://leafletjs.com).

All the JS files must be concatenated together for the library to work.

### AJAX load

The map settings and data are loaded by different calls to the `EsterenMap._load()` method.

The stack is the following:

1. `new EsterenMap(options)`: New object creation, setup base and some static options.
2. `EsterenMap.loadMapData()`: Load the settings with Ajax by loading the `maps/{id}` API route.
3. `EsterenMap.initialize()`: This function sets up the different Leaflet layers and components.
 
The `_load()` function is the one that communicates with web services defined in the API (check documentation).

## Services

There are three main services in Esteren Maps that you can use:

* `EsterenMaps\Services\DirectionsManager`, to manage itineraries calculations.
* `EsterenMaps\Services\MapImageManager`, not used yet, but it will allow generating a portion of the full map into a single image, with the routes and markers on it.
* `EsterenMaps\Services\MapsTilesManager`, to generate tiles for any map.

## Tiles generation

When you have a Map and its background saved in your app, you must generate map tiles for it to be viewable in front.

For this, run this command:

```bash
$ bin/console esterenmaps:map:generate-tiles
```

It will use [ImageMagick](http://www.imagemagick.org) and the [Orbitale ImageMagickPHP](https://github.com/Orbitale/ImageMagickPHP)
 command wrapper to generate tiles of 128x128px.<br>
<small>(actually, it doesn't use the Orbitale package yet, but it will one day)</small>

## Directions

Directions are calculated by the [DirectionsManager](../src/EsterenMaps/Services/DirectionsManager.php).

Each time a direction is asked by an end-user, it is cached to avoid consuming too much resource when resolving Dijkstra's
 algorithm to calculate the best direction.

The cache key is calculated simply by hashing all the arguments.

### Distance calculation

Distances are automatically calculated based on Pythagore's theorem with all coordinates of all points of the Route.

BUT, one can set the `forcedDistance` field, so if it is set, it forces (wow...) the `distance` attribute to be set
 identically as `forcedDistance`. This helps to hijack the distance if the visual map does not correspond enough to what
 you would like to have in your real map.

### Clear Directions cache

This cache can be cleared like any other cache by the `bin/console cache:clear` command, depending on your environment.

But it is also **automatically** cleared when you update any Maps-related entity, or any class implementing the
 `EntityToClearInterface` interface.
 
Check the [CacheClearSubscriber](../src/EsterenMaps/DoctrineListeners/CacheClearSubscriber.php) class for
 more information
