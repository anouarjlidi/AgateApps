(function($, L, d, w){

    var EsterenMap = function (user_map_options) {

        // Données utilisées dans le scope de la classe
        var _this = this,
            L_map,
            map_options = this.map_options
        ;

        if (!L) {
            console.error('Leaflet must be activated.');
            return this;
        }

        // Merge des options de base
        if (user_map_options){
            map_options = mergeRecursive(map_options, user_map_options);
        }
        map_options.tilesUrl = map_options.baseHost + map_options.tilesUrl.replace('{id}', ''+map_options.id);
        map_options.mapApiUrl = map_options.baseHost + map_options.mapApiUrl.replace('{id}', ''+map_options.id);
        this.map_options = map_options;

        if (!d.getElementById(map_options.container)) {
            console.error('Map could not initialize : wrong container id');
            return this;
        }

        //
        // Méthodes privées
        //
//        var callback_load_elements = function(e){
//            var id = map_options.id,
//                elements = [],
//                element,
//                coords;
//            if (e['map.'+id]) {
//                elements = e['map.'+id+];
//                for (var i = 0, c = elements.length ; i < c ; i++) {
//                    if (elements[i].coordinates) {
//                        coords = elements[i].coordinates.split(' ').map(function(e){
//                            e = e.split(',');
//                            e = L.latlng([e[0],e[1]]);
//                            return e;
//                        });
//                    }
//                    if (coords && coords.length == 1) { coords = coords[0]; }
//                    if (names == 'routes') {
//                        element = L.polyline(coords).addTo(L_map);
//                    } else if (names === 'zones') {
//                        element = L.polygon(coords).addTo(L_map);
//                    } else if (names === 'markers') {
//                        element = L.marker(coords).addTo(L_map);
//                    } else {
//                        element = elements[i];
//                    }
//                    _this.map_elements[names].push(element);
//                }
//            }
//        };

        //
        // Méthodes publiques
        //

//        _this.load = function(names, callback, options) {
//            var url,
//                ajax_object;
//
//            names = names.toLowerCase();
//            if (_this.map_elements[names] === undefined) {
//                console.error('Éléments à charger incorrects.');
//                return false;
//            }
//
//            if (callback_load_elements == callback) {
//                url = map_options.mapApiUrl + '/' + names;
//            } else {
//                url = map_options.apiUrl + '/' + names;
//            }
//
//            ajax_object = {
//                url: url,
//                dataType: 'json',
//                success: callback
//            };
//            for (var attr in options) {
//                ajax_object[attr] = options[attr];
//            }
//
//            $.ajax(options);
//        };

//        _this.loadZones = function() { return _this.load('zones', callback_load_elements); };
//        _this.loadRoutes = function() { return _this.load('routes', callback_load_elements); };
//        _this.loadMarkers = function() { return _this.load('markers', callback_load_elements); };

//        _this.loadElements = function(type) {
//
//        }

        // Reset du wrapper avant création de la map
        // Force la redimension du wrapper lors de la redimension de la page
        this.resetHeight(this);

        // Création de la map
        L_map = L.map(map_options.container, map_options.LeafletMapBaseOptions);

        // Création du calque des tuiles
        L.tileLayer(map_options.tilesUrl, map_options.LeafletLayerBaseOptions).addTo(L_map);

        L.Icon.Default.imagePath = map_options.imgUrl.replace(/\/$/gi, '');

        _this._map = L_map;

        ////////////////////////////////
        ////////// Mode édition ////////
        ////////////////////////////////
        if (map_options.editMode == true) {

            $('#map_add_marker').on('click', function(){
                if (L_map.getContainer().getAttribute('data-add-marker')) {
                    this.classList.remove('active');
                    L_map.getContainer().removeAttribute('data-add-marker');
                } else {
                    this.classList.add('active');
                    L_map.getContainer().setAttribute('data-add-marker', 'true');
                }
            });


            L_map.on('click', function(map_event){
                var latlng,
                    _this = document.map,
                    popupContent = _this.map_options.LeafletPopupBaseContent,
                    container = document.map._map.getContainer()
                ;
                if (container.getAttribute('data-add-marker') == 'true') {
                    latlng = map_event.latlng.lat+','+map_event.latlng.lng;
                    popupContent = popupContent.replace('{latlng}', latlng);
                    popupContent = popupContent.replace('{type}', '');
                    _this.addMarker(map_event.latlng, {
                        clickable: true,
                        draggable: true,
                        riseOnHover: true
                    }, {
                        popupContent: popupContent,
                        clickCallback: function(e){
                            var marker = e.target,
                                id = marker.options.alt,
                                popup = marker.getPopup()
                            ;

                            if (popup._isOpen) {
                                console.info('popup open');
                                d.getElementById('marker_popup_name').value = d.getElementById('marker_'+id+'_name').value;
                                d.getElementById('marker_popup_type').value = d.getElementById('marker_'+id+'_type').value;
                                d.getElementById('marker_popup_faction').value = d.getElementById('marker_'+id+'_faction').value;

                                d.getElementById('marker_popup_name').onkeyup = function(){
                                    d.getElementById('marker_'+id+'_name').value = this.value;
                                    return false;
                                };
                                d.getElementById('marker_popup_type').onchange = function(){
                                    d.getElementById('marker_'+id+'_type').value = this.value;
                                    return false;
                                };
                                d.getElementById('marker_popup_faction').onchange = function(){
                                    d.getElementById('marker_'+id+'_faction').value = this.value;
                                    return false;
                                };
                            } else {
                                console.info('popup closed');
                            }

                        },
                        dragCallback: function(e){
                            var marker = e.target,
                                id = marker.options.alt,
                                latlng = marker.getLatLng();
                            marker.setLatLng(latlng).update();
                            d.getElementById('marker_'+id+'_coords').value = latlng.lat+','+latlng.lng;
                        }
                    });
                    d.getElementById('map_add_marker').classList.remove('active');
                    container.removeAttribute('data-add-marker');
                }

            });

        }

        $(window).resize(function(){_this.resetHeight(_this);});

        return this;
    };

    /**
     * Ajoute un marqueur à la carte
     * @param latLng
     * @param leafletUserOptions
     * @param customUserOptions {}
     * @returns {EsterenMap}
     */
    EsterenMap.prototype.addMarker = function(latLng, leafletUserOptions, customUserOptions) {
        var _this = this,
            map_options = _this.map_options,
            id,
            option,
            leafletOptions = map_options.LeafletMarkerBaseOptions,
            marker,popup,popupContent,popupOptions,clickCallback,
            L_map = _this._map;

        customUserOptions = mergeRecursive(customUserOptions, customUserOptions);

        if (leafletUserOptions) {
            leafletOptions = mergeRecursive(leafletOptions, leafletUserOptions);
        }

        while (d.getElementById('marker_'+this.map_options.maxMarkerId+'_name')) {
            this.map_options.maxMarkerId ++;
        }

        id = this.map_options.maxMarkerId;

        leafletOptions.alt = id;

        marker = new L.marker(latLng, leafletOptions).addTo(L_map);

        // Création d'une popup
        popupContent = customUserOptions.popupContent;
        if (popupContent && typeof popupContent === 'string') {
            popupOptions = _this.map_options.LeafletPopupBaseOptions;
            if (customUserOptions.popupOptions) {
                popupOptions = mergeRecursive(popupOptions, customUserOptions.popupOptions);
            }
            popup = L.popup(popupOptions);
            popup.setContent(popupContent);
            marker.bindPopup(popup);
        } else if (customUserOptions.popupContent && typeof customUserOptions.popupContent !== 'string') {
            console.error('popupContent parameter must be a string.');
        }

        // Application des events listeners
        for (option in customUserOptions) {
            if (option.match(/Callback$/)) {
                marker.addEventListener(option.replace('Callback',''), customUserOptions[option]);
            }
        }

        if (this.map_options.editMode) {
            $('#inputs_container').append(
                '<input type="hidden" id="marker_'+id+'_name" name="marker['+id+'][name]" value="" />'+
                '<input type="hidden" id="marker_'+id+'_faction" name="marker['+id+'][faction]" value="" />'+
                '<input type="hidden" id="marker_'+id+'_coords" name="marker['+id+'][coords]" value="'+latLng.lat+','+latLng.lng+'" />'+
                '<input type="hidden" id="marker_'+id+'_type" name="marker['+id+'][type]" value="1" />'
            );
        }

        this._markers.push(marker);

        return this;
    }

    EsterenMap.prototype.get = function(option) {
        return this.map_options[option];
    };

    EsterenMap.prototype.getMarkers = function(){
        return this.map_elements['markers'];
    };

    EsterenMap.prototype.map_elements = {
        factions: [],
        routes: [],
        routesTypes: [],
        markers: [],
        markersTypes: [],
        zones: []
    };

    EsterenMap.prototype.map_options = {
        id: 0,
        editMode: false,
        container: 'map',
        baseHost: w.location.protocol + "//" + w.location.hostname + (w.location.port && ":" + w.location.port),
        tilesUrl: '/api/maps/tile/{id}/{z}/{x}/{y}.jpg',
        imgUrl: '/bundles/esterenmaps/img',
        apiUrl: '/api_test/',
        mapApiUrl: '/api_test/maps/{id}',
        center: [0,0],
        zoom: 1,
        maxMarkerId: 1,
        maxRouteId: 1,
        maxZoneId: 1,
        markerBaseHtml: '',
        LeafletPopupBaseContent: '',
        LeafletPopupBaseOptions: {
            maxWidth: 350,
            minWidth: 280
        },
        LeafletMapBaseOptions: {
            center: [0,0],
            zoom: 1,
            minZoom: 1,
            maxZoom: 1,
            attributionControl: false,
            maxBounds: [[-80.9,-180],[85.05,259.19]]
        },
        LeafletLayerBaseOptions: {
            attribution: '&copy; Corahn-Rin',
            minZoom: 0,
            maxZoom: 1,
            maxNativeZoom: 1,
            tileSize: 168,
            noWrap: false,
            continuousWorld: false
        },
        LeafletMarkerBaseOptions: {
            clickable: true,
            draggable: false,
            riseOnHover: true
        },
        LeafletRouteBaseOptions: {

        }
    };

    EsterenMap.prototype.resetHeight = function(EsterenMap) {
        // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
        $(d.getElementById(EsterenMap.map_options.container)).height(
              $(w).height()
            - $('#footer').outerHeight(true)
            - $('#navigation').outerHeight(true)
            - 20
        );
        return EsterenMap;
    };

    EsterenMap.prototype._map = null;
    EsterenMap.prototype._markers = [];

//    EsterenMap.prototype.;

    w.EsterenMap = EsterenMap;

})(jQuery, L, document, window);