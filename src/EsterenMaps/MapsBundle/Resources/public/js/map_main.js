(function($, L, d, w){

    /**
     * La classe CorahnRinMap va générer une carte à partir de tuiles
     * @param object params Un objet JSON contenant les paramètres à appliquer
     * @returns CorahnRinMap
     */
    function EsterenMap(user_leaflet_options, user_map_options) {

        // Données utilisées dans le scope de la classe
        var _this = this,
            base_map_options, map_options = {},
            base_leaflet_options, leaflet_options = {},
            L_map
        ;

        base_map_options = {
            id: 0,
            container: 'map',
            baseHost: w.location.protocol + "//" + w.location.hostname + (w.location.port && ":" + w.location.port),
            tilesUrl: '/api/maps/tile/{id}/{z}/{x}/{y}.jpg',
            imgUrl: '/bundles/esterenmaps/img',
            apiUrl: '/api_test/',
            mapApiUrl: '/api_test/maps/{id}',
            center: [0,0],
            zoom: 0,
            markerMaxId: 0,
            markerBaseHtml: '',
            LeafletMarkerBaseOptions: {
                clickable: true,
                draggable: false,
                riseOnHover: true
            },
            editMode: false
        };

        if (base_map_options){ for (var attr in base_map_options) { map_options[attr] = base_map_options[attr]; } }
        if (user_map_options){ for (var attr in user_map_options) { map_options[attr] = user_map_options[attr]; } }
        map_options.tilesUrl = map_options.baseHost + map_options.tilesUrl.replace('{id}',map_options.id);
        map_options.mapApiUrl = map_options.baseHost + map_options.mapApiUrl.replace('{id}',map_options.id);

        if (!d.getElementById(map_options.container)) {
            console.error('Map could not initialize : wrong container id');
            return;
        }

        // Options par défaut, celles-ci ne changent pas
        base_leaflet_options = {
            attribution: '&copy; Corahn-Rin',
            minZoom: 0,
            maxNativeZoom: 1,
            tileSize: 168,
            noWrap: true,
            continuousWorld: true
        };

        // Merge des options
        if (base_leaflet_options){ for (var attr in base_leaflet_options) { leaflet_options[attr] = base_leaflet_options[attr]; } }
        if (user_leaflet_options){ for (var attr in user_leaflet_options) { leaflet_options[attr] = user_leaflet_options[attr]; } }

        this.map_options = map_options;
        this.leaflet_options = leaflet_options;
        this.map_elements = {
            factions: [],
            routes: [],
            routesTypes: [],
            markers: [],
            markersTypes: [],
            zones: []
        };


        //
        // Méthodes privées
        //
        var callback_load_elements = function(e){
            var id = map_options.id,
                elements = [],
                element,
                coords;
            if (e['map.'+id+'.'+names]) {
                elements = e['map.'+id+'.'+names];
                for (var i = 0, c = elements.length ; i < c ; i++) {
                    if (elements[i].coordinates) {
                        coords = elements[i].coordinates.split(' ').map(function(e){
                            e = e.split(',');
                            e = L.latlng([e[0],e[1]]);
                            return e;
                        });
                    }
                    if (coords && coords.length == 1) { coords = coords[0]; }
                    if (names == 'routes') {
                        element = L.polyline(coords).addTo(L_map);
                    } else if (names === 'zones') {
                        element = L.polygon(coords).addTo(L_map);
                    } else if (names === 'markers') {
                        element = L.marker(coords).addTo(L_map);
                    } else {
                        element = elements[i];
                    }
                    _this.map_elements[names].push(element);
                }
            }
        };

        //
        // Méthodes publiques
        //

        this.get = function(option) { return map_options[option]; };
        this.getMarkers = function(){ return markers; };

        this.load = function(names, callback, options) {
            var url,
                ajax_object;

            names = names.toLowerCase();
            if (_this.map_elements[names] === undefined) {
                console.error('Éléments à charger incorrects.');
                return false;
            }

            if (callback_load_elements == callback) {
                url = map_options.mapApiUrl + '/' + names;
            } else {
                url = map_options.apiUrl + '/' + names;
            }

            ajax_object = {
                url: url,
                dataType: 'json',
                success: callback
            };
            for (var attr in options) {
                ajax_object[attr] = options[attr];
            }

            $.ajax(options);
        };

        this.loadZones = function() { return _this.load('zones', callback_load_elements); };
        this.loadRoutes = function() { return _this.load('routes', callback_load_elements); };
        this.loadMarkers = function() { return _this.load('markers', callback_load_elements); };

        this.resetHeight = function() {
            // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
            $(d.getElementById(map_options.container)).height($(w).height() - $('#footer').outerHeight(true) - $('#navigation').outerHeight(true));
        };

        this.map = function(){ return L_map; };

        this.loadElements = function(type) {
            ;
        }

        this.addMarker = function(latLng, leafletUserOptions, customUserOptions) {
            var leafletOptions = this.map_options.LeafletMarkerBaseOptions,
                customUserOptions = customUserOptions ? customUserOptions : {},
                marker;
            for (var attrName in leafletUserOptions) {
                leafletOptions[attrname] = leafletUserOptions[attrName];
            }

            if (!leafletOptions.id) {
                while (d.getElementById('marker_'+map_options.markerMaxId)) {
                    map_options.markerMaxId ++;
                }
                leafletOptions.id = 'marker_'+map_options.markerMaxId;
            }

            marker = new L.marker(e.latlng, leafletOptions).addTo(L_map);

            if (leafletOptions.draggable && customUserOptions.dragEndCallback) {
                marker.on('dragend', dragEndCallback);
            }

            if (customUserOptions.popupContent) {
                marker.bindPopup(customUserOptions.popupContent);
            }

            return this;
        }

        //
        // Initialisations
        //
        this.resetHeight();
        L_map = L.map(map_options.container, {"center":[0,0],"zoom":map_options.zoom});// Création de la map
        L.tileLayer(map_options.tilesUrl, leaflet_options).addTo(L_map);// Création du calque des tuiles
        L.Icon.Default.imagePath = map_options.imgUrl.replace(/\/$/gi, '');
        $(w).resize(this.resetHeight);
        map_options.markerMaxId++;

        ////////////////////////////////
        ////////// Mode édition ////////
        ////////////////////////////////
        if (map_options.editMode == true) {

            d.getElementById('map_add_marker').onclick = function(){
                if (L_map.getContainer().getAttribute('data-add-marker')) {
                    this.classList.remove('active');
                    L_map.getContainer().removeAttribute('data-add-marker');
                } else {
                    this.classList.add('active');
                    L_map.getContainer().setAttribute('data-add-marker', 'true');
                }
            };

            L_map.on('click', function(map_event){
                if (L_map.getContainer().getAttribute('data-add-marker') == 'true') {
                    var latlng = map_event.latlng.lat+','+map_event.latlng.lng;
                    _this.addMarker(latlng, {
                        clickable: true,
                        draggable: true,
                        riseOnHover: true
                    }, {
                        dragEndCallback: function(event){
                            var marker = event.target;
                            var position = marker.getLatLng();
                            marker.setLatLng(position).update();
                        }
                    });
                    d.getElementById('map_add_marker').classList.remove('active');
                    L_map.getContainer().removeAttribute('data-add-marker');
                }

            });
        }


        return this;
    }

    w.EsterenMap = EsterenMap;

})(jQuery, L, document, window);