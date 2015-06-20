(function($, L, d, w){

    // Rajoute qqs attributs à des éléments de Leaflet et LeafletSidebar
    L.Polyline.prototype._esterenMap = {};
    L.Polyline.prototype._esterenRoute = {};
    L.Polyline.prototype._sidebar = {};
    L.Polyline.prototype._sidebarContent = '';
    L.Polyline.prototype._oldColor = '';
    L.Polyline.prototype.showSidebar = function(){
        this._sidebar.setContent(this._sidebarContent);
        this._sidebar.show();
        return this;
    };

    L.Polyline.prototype.hideSidebar = function(){
        this._sidebar.hide();
        this._sidebar.setContent('');
        return this;
    };

    L.Polyline.prototype.toggleSidebar = function(){
        if (this._sidebar.isVisible()) {
            this.hideSidebar();
        } else {
            this.showSidebar();
        }
        return this;
    };

    L.Polyline.prototype.bindSidebar = function(sidebar, content){
        this._sidebar = sidebar;
        this._sidebarContent = content;
        return this;
    };

    L.Polyline.prototype.disableEditMode = function() {
        this._updateEM();
        this.editing.disable();
    };

    L.Polyline.prototype.updateStyle = function(){

        if (this._esterenRoute.route_type.color) { 
            // Change l'image de l'icône
            this._path.setAttribute('stroke', this._esterenRoute.route_type.color);
        }

        // Met à jour l'attribut "data" pour les filtres
        $(this._path).attr('data-leaflet-object-type', 'routeType'+this._esterenRoute.route_type.id);

        latlngs = this.getLatLngs();
        if (this._esterenRoute.markerStart) {
            latlngs[0] = L.latLng(this._esterenRoute.markerStart.coordinates);
        }
        if (this._esterenRoute.markerEnd) {
            latlngs[this._latlngs.length-1] = L.latLng(this._esterenRoute.markerStart.coordinates);
        }

        this.setLatLngs(latlngs);
    };

    L.Polyline.prototype.calcDistance = function() {
        var distance = 0,
            points = this._latlngs,
            i = 0,
            l = points.length,
            current, next, currentX, currentY, nextX, nextY;
        do {
            current = points[i];
            next = points[i+1];
            if (next) {
                currentX = current.lng;
                currentY = current.lat;
                nextX = next.lng;
                nextY = next.lat;
                distance += Math.sqrt(
                    ( nextX * nextX )
                    - ( 2 * currentX * nextX )
                    + ( currentX * currentX )
                    + ( nextY * nextY )
                    - ( 2 * currentY * nextY )
                    + ( currentY * currentY )
                );
            }
            i++;
        } while (i < l);
        if (this._esterenRoute) {
            this._esterenRoute.distance = distance;
        }
        return distance;
    };

    L.Polyline.prototype._updateEM = function() {
        var baseRoute = this,
            esterenRoute = EsterenMap.prototype.cloneObject.call(null, this._esterenRoute || null),
            _this = this,
            id = esterenRoute.id || null;
        if (esterenRoute && this._map && !this.launched && esterenRoute.marker_start && esterenRoute.marker_end) {
            esterenRoute.map = esterenRoute.map || {id: this._esterenMap.options().id };
            esterenRoute.coordinates = JSON.stringify(this._latlngs);
            esterenRoute.route_type = { id: esterenRoute.route_type.id };
            esterenRoute.marker_start = { id: esterenRoute.marker_start.id };
            esterenRoute.marker_end = { id: esterenRoute.marker_end.id };
            esterenRoute.faction = esterenRoute.faction || null;
            this.calcDistance();
            this.launched = true;
            this._esterenMap._load({
                uri: "routes" + (id ? '/'+id : ''),
                method: id ? "POST" : "PUT", // Si on n'a pas d'ID, c'est qu'on crée une nouvelle route
                data: {
                    json: esterenRoute,
                    mapping: {
                        name: true,
                        coordinates: true,
                        map: true,
                        distance: true,
                        route_type: {
                            objectField: 'routeType'
                        },
                        marker_start: {
                            objectField: 'markerStart'
                        },
                        marker_end: {
                            objectField: 'markerEnd'
                        },
                        faction: true
                    }
                },
                callback: function(response) {
                    var map = this,
                        route = response.newObject;
                    if (!response.error) {
                        if (route && route.id) {
                            map._polylines[route.id] = baseRoute;
                            map._polylines[route.id]._esterenRoute = route;
                            map._polylines[route.id].updateStyle();
                        } else {
                            console.warn('Route retrieved by API does not have ID.');
                        }
                    } else {
                        console.error('Api sent back an error while attempting to '+(id?'update':'insert')+' a route.');
                    }
                },
                callbackError: function() {
                    console.error('Could not make a request to '+(id?'update':'insert')+' a route.');
                },
                callbackComplete: function(){
                    _this.launched = false;
                }
            });
        } else if (!this.launched && esterenRoute.marker_start && esterenRoute.marker_end) {
            console.error('Tried to update an empty route.');
        }
    };

    EsterenMap.prototype.esterenRoutePrototype = {
        id: null,
        name: null,
        route_type: null,
        marker_start: null,
        marker_end: null,
        faction: null,
        distance: 0,
        coordinates: null
    };

    EsterenMap.prototype._mapOptions.LeafletPolylineBaseOptions = {
        color: "#f66",
        opacity: 0.75,
        weight: 4,
        clickable: true
    };

    EsterenMap.prototype._mapOptions.LeafletPolylineBaseOptionsEditMode = {
        color: "#03f",
        opacity: 0.75,
        weight: 6
    };

    EsterenMap.prototype._mapOptions.CustomPolylineBaseOptions = {
        popupIsSidebar: true,
        clickCallback: function(e){
            var polyline = e.target,
                esterenRoute = polyline._esterenRoute
            ;

            polyline.showSidebar();

            if (polyline._sidebar.isVisible()) {
                d.getElementById('polyline_popup_name').innerHTML = esterenRoute.name;
                d.getElementById('polyline_popup_type').innerHTML = esterenRoute.route_type.name;
                d.getElementById('polyline_popup_faction').innerHTML = esterenRoute.faction ? esterenRoute.faction.name : '';
                d.getElementById('polyline_popup_markerStart').innerHTML = esterenRoute.marker_start ? esterenRoute.marker_start.name : '';
                d.getElementById('polyline_popup_markerEnd').innerHTML = esterenRoute.marker_end ? esterenRoute.marker_end.name : '';
            }
        }
    };

    EsterenMap.prototype._mapOptions.CustomPolylineBaseOptionsEditMode = {
        clickCallback: function(e){
            var polyline = e.target,
                map = polyline._esterenMap,
                id = polyline.options.className.replace('drawn_polyline_','')
                ;

            map.disableEditedElements();
            polyline.editing.enable();
            polyline.showSidebar();
            map._editedPolyline = polyline;

            setTimeout(function(){
                var collectionStart, collectionEnd, markers;
                if (polyline._sidebar.isVisible()) {
                    console.info('updating a route');
                    markers = map._markers;
                    collectionStart = $('#polyline_popup_markerStart option[value!=""]');
                    collectionEnd = $('#polyline_popup_markerEnd option[value!=""]');

                    $.each(markers, function(id,marker){
                        if (!collectionEnd.filter('[value="'+id+'"]').length) {
                            collectionEnd.last().after('<option value="'+id+'">'+marker.name+'</option>');
                        }
                        if (!collectionStart.filter('[value="'+id+'"]').length) {
                            collectionStart.last().after('<option value="'+id+'">'+marker.name+'</option>');
                        }
                    });

                    d.getElementById('polyline_popup_name').value = polyline._esterenRoute.name;
                    d.getElementById('polyline_popup_faction').value = polyline._esterenRoute.faction ? polyline._esterenRoute.faction.id : '';
                    d.getElementById('polyline_popup_type').value = polyline._esterenRoute.route_type ? polyline._esterenRoute.route_type.id : '';
                    d.getElementById('polyline_popup_markerStart').value = polyline._esterenRoute.marker_start ? polyline._esterenRoute.marker_start.id : '';
                    d.getElementById('polyline_popup_markerEnd').value = polyline._esterenRoute.marker_end ? polyline._esterenRoute.marker_end.id : '';

                    $('#polyline_popup_name').off('keyup').on('keyup', function(){
                        map._polylines[id]._esterenRoute.name = this.value;
                        if (this._timeout) { clearTimeout(this._timeout); }
                        this._timeout = setTimeout(function(){ map._polylines[id]._updateEM(); }, 1000);
                        return false;
                    });
                    $('#polyline_popup_type').off('change').on('change', function(){
                        map._polylines[id]._esterenRoute.route_type = map.refDatas('routesTypes', this.value);
                        if (this._timeout) { clearTimeout(this._timeout); }
                        this._timeout = setTimeout(function(){ map._polylines[id]._updateEM(); }, 1000);
                        return false;
                    });
                    $('#polyline_popup_faction').off('change').on('change', function(){
                        map._polylines[id]._esterenRoute.faction = map.refDatas('factions', this.value);
                        if (this._timeout) { clearTimeout(this._timeout); }
                        this._timeout = setTimeout(function(){ map._polylines[id]._updateEM(); }, 1000);
                        return false;
                    });
                    $('#polyline_popup_markerStart').off('change').on('change', function(){
                        var marker, latlngs;
                        if (this._timeout) { clearTimeout(this._timeout); }
                        marker = markers[this.value] || null;
                        latlngs = polyline._latlngs;
                        if (marker) {
                            latlngs[0] = marker._latlng;
                        }
                        polyline.setLatLngs(latlngs);
                        polyline._esterenRoute.coordinates = JSON.stringify(latlngs);
                        polyline._esterenRoute.marker_start = marker._esterenMarker;
                        this._timeout = setTimeout(function(){ map._polylines[id]._updateEM(); }, 1000);
                        return false;
                    });
                    $('#polyline_popup_markerEnd').off('change').on('change', function(){
                        var marker, latlngs;
                        if (this._timeout) { clearTimeout(this._timeout); }
                        marker = markers[this.value] || null;
                        latlngs = polyline._latlngs;
                        if (marker) {
                            latlngs[latlngs.length - 1] = marker._latlng;
                        }
                        polyline.setLatLngs(latlngs);
                        polyline._esterenRoute.coordinates = JSON.stringify(latlngs);
                        polyline._esterenRoute.marker_end = marker._esterenMarker;
                        this._timeout = setTimeout(function(){ map._polylines[id]._updateEM(); }, 1000);
                        return false;
                    });
                }
            },20);
        }
    };

    EsterenMap.prototype._mapOptions.loaderCallbacks.routes = function(response){
        var routes, i, route,
            finalOptions,finalLeafletOptions,
            mapOptions = this.options(),
            popupContent = mapOptions.LeafletPopupPolylineBaseContent,
            options = mapOptions.CustomPolylineBaseOptions,
            leafletOptions = mapOptions.LeafletPolylineBaseOptions,
            coords
        ;

        for (i in this._polylines) {
            if (this._polylines.hasOwnProperty(i)) {
                this._map.removeLayer(this._polylines[i]);
                this._drawnItems.removeLayer(this._polylines[i]);
            }
        }

        if (mapOptions.editMode === true) {
            options = this.cloneObject(options, mapOptions.CustomPolylineBaseOptionsEditMode);
            leafletOptions = this.cloneObject(leafletOptions, mapOptions.LeafletPolylineBaseOptionsEditMode);
        }

        if (response['map.'+mapOptions.id+'.routes']) {
            routes = response['map.'+mapOptions.id+'.routes'];
            for (i in routes) {
                if (routes.hasOwnProperty(i)) {
                    route = routes[i];
                    coords = (typeof route.coordinates === 'string') ? JSON.parse(route.coordinates) : route.coordinates;
                    finalLeafletOptions = this.cloneObject(leafletOptions, {id:route.id});

                    if (route.route_type.color) {
                        finalLeafletOptions.color = route.route_type.color;
                    }

                    finalOptions = this.cloneObject(options, {
                        popupContent:popupContent,
                        esterenRoute: route,
                        polylineName: route.name,
                        polylineType: route.route_type.id,
                        polylineFaction: route.faction ? route.faction.id : '',
                        polylineMarkerStart: route.marker_start ? route.marker_start.id : '',
                        polylineMarkerEnd: route.marker_end ? route.marker_end.id : ''
                    });
                    this.addPolyline(coords,
                        finalLeafletOptions,
                        finalOptions
                    );
                }//endif (polyline.hasOwnProperty)
            }//endfor
        }// endif response
    };

    EsterenMap.prototype._mapOptions.loaderCallbacks.routesTypes = function(response){
        if (response['routestypes'] && response['routestypes'].length > 0) {
            this._routesTypes = response['routestypes'];
        } else {
            console.error('Error while retrieving routes types');
        }
        return this;
    };

    /**
     * Ajoute un marqueur à la carte
     * @param latLng
     * @param leafletUserOptions
     * @param customUserOptions
     * @returns {EsterenMap}
     */
    EsterenMap.prototype.addPolyline = function(latLng, leafletUserOptions, customUserOptions) {
        var _this = this,
            mapOptions = this.options(),
            className,
            id,
            option,
            leafletOptions = mapOptions.LeafletPolylineBaseOptions,
            polyline,popup,popupContent,popupOptions,
            L_map = _this._map;

        if (leafletUserOptions) {
            leafletOptions = mergeRecursive(leafletOptions, leafletUserOptions);
        }

        while (d.getElementById('polyline_'+this._mapOptions.maxPolylineId+'_name')) {
            this._mapOptions.maxPolylineId ++;
        }

        if (!leafletOptions.id) {
            id = this._mapOptions.maxPolylineId;
        } else {
            id = leafletOptions.id;
        }

        while (d.getElementById('polyline_'+id+'_name')) { id ++; }

        className = 'drawn_polyline_'+id;

        leafletOptions.className = className;

        polyline = L.polyline(latLng, leafletOptions);

        polyline._esterenMap = this;
        if (customUserOptions.esterenRoute) {
            polyline._esterenRoute = customUserOptions.esterenRoute;
        } else {
            // Ici on tente de créer une nouvelle zone
            polyline._esterenRoute = this.esterenRoutePrototype;
            polyline._esterenRoute.route_type = this.refDatas('routesTypes', 1);
        }

        // Création d'une popup
        popupContent = customUserOptions.popupContent;
        if (!popupContent) {
            popupContent = mapOptions.LeafletPopupPolylineBaseContent;
        }
        if (popupContent && typeof popupContent === 'string') {
            popupOptions = mapOptions.LeafletPopupBaseOptions;
            if (typeof customUserOptions.popupOptions !== 'undefined') {
                popupOptions = mergeRecursive(popupOptions, customUserOptions.popupOptions);
            }
            polyline.bindSidebar(this._sidebar, popupContent);
        } else if (customUserOptions.popupContent && typeof customUserOptions.popupContent !== 'string') {
            console.error('popupContent parameter must be a string.');
        }

        // Application des events listeners
        for (option in customUserOptions) {
            if (customUserOptions.hasOwnProperty(option) && option.match(/Callback$/)) {
                polyline.addEventListener(option.replace('Callback',''), customUserOptions[option]);
            }
        }

        this._drawnItems.addLayer(polyline);

        option = 'routeType'+(customUserOptions.polylineType?customUserOptions.polylineType:'1');
        if (polyline._path.dataset) {
            polyline._path.dataset.leafletObjectType = option;
        }
        polyline._path.setAttribute('data-leaflet-object-type', option);

        this._polylines[id] = polyline;

        return this;
    };


})(jQuery, L, document, window);

