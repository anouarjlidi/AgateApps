
    EsterenMap.prototype._map = null;
    EsterenMap.prototype._sidebar = null;
    EsterenMap.prototype._filtersControl = null;
    EsterenMap.prototype._drawControl = null;
    EsterenMap.prototype._drawnItems = null;
    EsterenMap.prototype._tileLayer = null;
    EsterenMap.prototype._xhr_saves = {};
    EsterenMap.prototype._editedMarker = null;
    EsterenMap.prototype._editedPolyline = null;
    EsterenMap.prototype._editedPolygon = null;

    EsterenMap.prototype._markers = {};
    EsterenMap.prototype._polygons = {};
    EsterenMap.prototype._polylines = {};

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
        loadCallback: null,
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
        imgUrl: '/img/',
        apiUrls: {
            endpoint: null,
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
