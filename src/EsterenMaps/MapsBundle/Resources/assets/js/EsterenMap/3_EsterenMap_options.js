
    EsterenMap.prototype._map = null;
    EsterenMap.prototype._sidebar = {};
    EsterenMap.prototype._filtersControl = {};
    EsterenMap.prototype._drawControl = {};
    EsterenMap.prototype._drawnItems = {};
    EsterenMap.prototype._tileLayer = {};
    EsterenMap.prototype._xhr_saves = {};
    EsterenMap.prototype._editedMarker = null;
    EsterenMap.prototype._editedPolyline = null;
    EsterenMap.prototype._editedPolygon = null;

    EsterenMap.prototype._clonedOptions = false;

    EsterenMap.prototype._messageElement = null;

    EsterenMap.prototype._refData = false;

    EsterenMap.prototype._transports = false;

    EsterenMap.prototype._markers = {};
    EsterenMap.prototype._polygons = {};
    EsterenMap.prototype._polylines = {};

    EsterenMap.prototype._markersTypes = {};
    EsterenMap.prototype._routesTypes = {};
    EsterenMap.prototype._zonesTypes = {};

    EsterenMap.prototype._directionsOptions = {
        position: 'topleft'
    };

    EsterenMap.prototype._mapOptions = {
        id: 0,
        crs: 'XY',
        data: {
            map: null,
            references: null,
            templates: {
                LeafletPopupMarkerBaseContent: '',
                LeafletPopupPolygonBaseContent: '',
                LeafletPopupPolylineBaseContent: ''
            }
        },
        editMode: false,
        showFilters: true,
        showDirections: true,
        showSearchEngine: true,
        showMarkers: true,
        showRoutes: true,
        showZones: true,
        autoResize: true,
        containerHeight: 400,
        sidebarContainer: 'esterenmap_sidebar',
        container: 'map',
        wrapper: 'map_wrapper',
        messageElementId: 'esterenmap_message_element',
        imgUrl: '/bundles/esterenmaps/img',
        apiUrls: {
            map: null,
            directions: null,
            tiles: null
        },
        loaderCallbacks: {},
        center: [0, 0],
        maxMarkerId: 1,
        maxPolylineId: 1,
        maxPolygonId: 1,
        LeafletPopupBaseOptions: {
            maxWidth: 350,
            minWidth: 280
        },
        LeafletMapBaseOptions: {
            center: [0, 0],
            zoom: 1,
            minZoom: 1,
            maxZoom: 1,
            worldCopyJump: false,
            attributionControl: false
        },
        LeafletLayerBaseOptions: {
            attribution: '&copy; Esteren Maps',
            minZoom: 1,
            maxZoom: 1,
            maxNativeZoom: 1,
            tileSize: 168,
            noWrap: false,
            continuousWorld: true
        }
    };
