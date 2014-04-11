(function($, L, d, w){

    var EsterenMap = function (user_mapOptions) {

        // Données utilisées dans le scope de la classe
        var _this = this,
            L_map,drawnItems,drawControl,
            mapOptions = this.mapOptions
        ;

        if (!L) {
            console.error('Leaflet must be activated.');
            return this;
        }

        // Merge des options de base
        if (user_mapOptions){
            mapOptions = mergeRecursive(mapOptions, user_mapOptions);
        }

        // Formatage de l'url d'API qui doit utiliser l'ID de la map
        mapOptions.apiUrls.tiles = mapOptions.apiUrls.tiles.replace('{id}', ''+mapOptions.id);

        this.mapOptions = mapOptions;

        if (!d.getElementById(mapOptions.container)) {
            console.error('Map could not initialize : wrong container id');
            return this;
        }

        // Reset du wrapper avant création de la map
        // Force la redimension du wrapper lors de la redimension de la page
        this.resetHeight(this);

        // Création de la map
        L_map = L.map(mapOptions.container, mapOptions.LeafletMapBaseOptions);

        // Création du calque des tuiles
        L.tileLayer(mapOptions.apiUrls.tiles, mapOptions.LeafletLayerBaseOptions).addTo(L_map);

        L.Icon.Default.imagePath = mapOptions.imgUrl.replace(/\/$/gi, '');

        this._map = L_map;

        ////////////////////////////////
        ////////// Mode édition ////////
        ////////////////////////////////
        if (this.mapOptions.editMode == true) {

            //--------------------LEAFLET DRAW--------------------
                // Initialise the FeatureGroup to store editable layers
                drawnItems = new L.FeatureGroup();
                this._map.addLayer(drawnItems);

                // Initialise the draw control and pass it the FeatureGroup of editable layers
                drawControl = new L.Control.Draw({
                    draw: {
                        circle: false,
                        rectangle: false,
                        polygon: {
                            allowIntersection: false
                        }
                    },
                    edit: {
                        featureGroup: drawnItems
                    }
                });
                this._map.addControl(drawControl);
            //----------------------------------------------------

//            $('#map_add_marker').on('click', function(){
//                if (L_map.getContainer().getAttribute('data-add-marker')) {
//                    this.classList.remove('active');
//                    L_map.getContainer().removeAttribute('data-add-marker');
//                } else {
//                    this.classList.add('active');
//                    L_map.getContainer().setAttribute('data-add-marker', 'true');
//                }
//            });

            _this = this;

            this._map.on('draw:created', function(event){
                var type = event.layerType,
                    layer = event.layer,
                    latlng = layer._latlng,
                    popupContent = _this.mapOptions.LeafletPopupBaseContent,
                    options = _this.mapOptions.CustomMarkerBaseOptionsEditMode,
                    editOptions = _this.mapOptions.LeafletMarkerBaseOptionsEditMode
                ;

                console.info('event draw', event);

                if (type === 'marker') {
                    console.info('latlng', latlng);
                    _this.addMarker(latlng,
                        editOptions,
                        mergeRecursive(options, {popupContent:popupContent})
                    );
                    d.getElementById('map_add_marker').classList.remove('active');
                }


                return true;

            });

        }

        _this = this;
        $(window).resize(function(){_this.resetHeight(_this);});

        this.loadMarkers();

        return this;
    };



    /**
     * Exécute une requête AJAX dans le but de récupérer des éléments liés à la map
     * via l'API
     *
     * @param name Le type d'élément à récupérer
     * @param options les options à envoyer à l'objet AJAX
     * @param callback La fonction à exécuter (ignoré dans certains cas)
     * @returns {*}
     */
    EsterenMap.prototype.load = function(name, options, callback) {
        var url, ajax_object;

        name = name.toLowerCase();
        if (this.mapElements[name] === undefined) {
            console.error('Éléments à charger incorrects.');
            return false;
        }

        url = this.mapOptions.apiUrls.base + '/' + name;

        if (!callback && this.mapOptions.loaderCallbacks[name]) {
            callback = this.mapOptions.loaderCallbacks[name];
        }

        ajax_object = {
            url: url,
            type: 'GET',
            dataType: 'json',
            success: callback
        };
        ajax_object = mergeRecursive(ajax_object, options);

        $.ajax(ajax_object);

        return this;
    };

    EsterenMap.prototype.loadMarkers = function(){
        var _this = this;
        return this.load('markers', {}, function(response){
            var markers, i, marker,
                popupContent = _this.mapOptions.LeafletPopupBaseContent,
                options = _this.mapOptions.CustomMarkerBaseOptionsEditMode,
                leafletOptions = _this.mapOptions.LeafletMarkerBaseOptionsEditMode,
                coords
            ;
            if (response['map.'+_this.mapOptions.id+'.markers']) {
                markers = response['map.'+_this.mapOptions.id+'.markers'];
                for (i in markers) {
                    marker = markers[i];
                    if (_this.mapOptions.editMode === true) {
                        coords = {
                            lat: marker.latitude,
                            lng: marker.longitude,
                            altitude: marker.altitude
                        }
                        _this.addMarker(coords,
                            mergeRecursive(leafletOptions, {alt: marker.id}),
                            mergeRecursive(options, {
                                popupContent:popupContent,
                                markerName: marker.name,
                                markerType: marker.marker_type.id,
                                markerFaction: marker.faction ? marker.faction.id : ''
                            })
                        );
                    } else {
                        console.info('public mode');
                    }
                }
            }
        });
    };

    /**
     * Ajoute un marqueur à la carte
     * @param latLng
     * @param leafletUserOptions
     * @param customUserOptions
     * @returns {EsterenMap}
     */
    EsterenMap.prototype.addMarker = function(latLng, leafletUserOptions, customUserOptions) {
        var _this = this,
            mapOptions = _this.mapOptions,
            id,
            option,
            leafletOptions = mapOptions.LeafletMarkerBaseOptions,
            marker,popup,popupContent,popupOptions,
            L_map = _this._map;

        if (leafletUserOptions) {
            leafletOptions = mergeRecursive(leafletOptions, leafletUserOptions);
        }

        while (d.getElementById('marker_'+this.mapOptions.maxMarkerId+'_name')) {
            this.mapOptions.maxMarkerId ++;
        }

        if (!leafletOptions.alt) {
            id = this.mapOptions.maxMarkerId;
        } else {
            id = leafletOptions.alt;
        }
        while (d.getElementById('marker_'+id+'_name')) { id ++; }

        leafletOptions.alt = id;

        marker = new L.marker(latLng, leafletOptions).addTo(L_map);

        // Création d'une popup
        popupContent = customUserOptions.popupContent;
        if (popupContent && typeof popupContent === 'string') {
            popupOptions = _this.mapOptions.LeafletPopupBaseOptions;
            if (typeof customUserOptions.popupOptions !== 'undefined') {
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

        if (mapOptions.editMode) {
            $('#inputs_container').append(
                '<input type="hidden" id="marker_'+id+'_name" name="marker['+id+'][name]" value="'+(customUserOptions.markerName?customUserOptions.markerName:'')+'" />'+
                '<input type="hidden" id="marker_'+id+'_faction" name="marker['+id+'][faction]" value="'+(customUserOptions.markerFaction?customUserOptions.markerFaction:'')+'" />'+
                '<input type="hidden" id="marker_'+id+'_latitude" name="marker['+id+'][latitude]" value="'+latLng.lat+'" />'+
                '<input type="hidden" id="marker_'+id+'_longitude" name="marker['+id+'][longitude]" value="'+latLng.lng+'" />'+
                '<input type="hidden" id="marker_'+id+'_altitude" name="marker['+id+'][altitude]" value="0" />'+
                '<input type="hidden" id="marker_'+id+'_type" name="marker['+id+'][type]" value="'+(customUserOptions.markerType?customUserOptions.markerType:'1')+'" />'
            );
        }

        this._markers.push(marker);

        return this;
    }

    EsterenMap.prototype.getMarkers = function(){
        return this.mapElements['markers'];
    };

    EsterenMap.prototype.mapElements = {
        factions: [],
        routes: [],
        routesTypes: [],
        markers: [],
        markersTypes: [],
        zones: []
    };

    EsterenMap.prototype.mapOptions = {
        id: 0,
        editMode: false,
        container: 'map',
        imgUrl: '/bundles/esterenmaps/img',
        apiUrls: {
            base: '/api/maps/',
            tiles: '/api/maps/tile/{id}/{z}/{x}/{y}.jpg'
        },
        loaderCallbacks: {
            routes: function(){},
            zones: function(){}
        },
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
        LeafletMarkerBaseOptionsEditMode: {
            clickable: true,
            draggable: true,
            riseOnHover: true
        },
        CustomMarkerBaseOptionsEditMode: {
            clickCallback: function(e){
                var marker = e.target,
                    id = marker.options.alt,
                    popup = marker.getPopup()
                ;

                setTimeout(function(){
                    if (popup._isOpen) {
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
                    }
                },20);

            },
            dragCallback: function(e){
                var marker = e.target,
                    id = marker.options.alt,
                    latlng = marker.getLatLng();
                marker.setLatLng(latlng).update();
                d.getElementById('marker_'+id+'_latitude').value = latlng.lat;
                d.getElementById('marker_'+id+'_longitude').value = latlng.lng;
            }
        },
        LeafletRouteBaseOptions: {

        }
    };

    EsterenMap.prototype.resetHeight = function(EsterenMap) {
        // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
        $(d.getElementById(EsterenMap.mapOptions.container)).height(
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