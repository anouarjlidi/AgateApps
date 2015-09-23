    EsterenMap.prototype._map = null;
    EsterenMap.prototype._sidebar = {};
    EsterenMap.prototype.showFilters = true;
    EsterenMap.prototype._filtersControl = {};
    EsterenMap.prototype._drawControl = {};
    EsterenMap.prototype._drawnItems = {};
    EsterenMap.prototype._tileLayer = {};
    EsterenMap.prototype._xhr_saves = {};
    EsterenMap.prototype._editedMarker = null;
    EsterenMap.prototype._editedPolyline = null;
    EsterenMap.prototype._editedPolygon = null;

    EsterenMap.prototype._messageElement = null;

    EsterenMap.prototype._refDatas = false;

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

    EsterenMap.prototype.mapAllowedElements = {
        maps: true,
        factions: true,
        routes: true,
        routestypes: true,
        markers: true,
        markerstypes: true,
        zones: true,
        zonestypes: true,
        settings: true,
        "ref-datas": true,
        transports: true
    };

    EsterenMap.prototype._mapOptions = {
        id: 0,
        editMode: false,
        showFilters: true,
        showDirections: true,
        autoResize: true,
        containerHeight: 400,
        sidebarContainer: 'esterenmap_sidebar',
        container: 'map',
        wrapper: 'map_wrapper',
        loadedCallback: function(){
            this.loadMarkers();
            this.loadRoutes();
            this.loadZones();
            this.loadTransports();
        },
        messageElementId: 'esterenmap_message_element',
        imgUrl: '/bundles/esterenmaps/img',
        apiUrls: {
            base: '/api/',
            settings: '/api/maps/settings/',
            tiles: '/api/maps/tile/{id}/{z}/{x}/{y}.jpg'
        },
        loaderCallbacks: {},
        center: [0,0],
        maxMarkerId: 1,
        maxPolylineId: 1,
        maxPolygonId: 1,
        LeafletPopupMarkerBaseContent: '',
        LeafletPopupPolygonBaseContent: '',
        LeafletPopupPolylineBaseContent: '',
        LeafletPopupBaseOptions: {
            maxWidth: 350,
            minWidth: 280
        },
        LeafletMapBaseOptions: {
            center: [0,0],
            zoom: 1,
            minZoom: 1,
            maxZoom: 1,
            crs: L.CRS.Simple,
            attributionControl: false
        },
        LeafletLayerBaseOptions: {
            attribution: '&copy; Esteren Maps',
            minZoom: 1,
            maxZoom: 1,
            maxNativeZoom: 1,
            tileSize: 168,
            noWrap: true,
            continuousWorld: true
        }
    };
