(function($, L, d, w){

    // Rajoute qqs attributs à des éléments de Leaflet et LeafletSidebar
    L.Polyline.prototype._esterenMap = {};
    L.Polyline.prototype._esterenRoute = {};
    L.Polyline.prototype._sidebar = {};
    L.Polyline.prototype._sidebarContent = '';
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



    EsterenMap.prototype.mapOptions.LeafletPolylineBaseOptions = {
        color: "#f66",
        opacity: 0.4,
        weight: 3,
        clickable: true
    };
    EsterenMap.prototype.mapOptions.LeafletPolylineBaseOptionsEditMode = {
        color: "#03f",
        opacity: 0.5,
        weight: 5
    };
    EsterenMap.prototype.mapOptions.CustomPolylineBaseOptions = {
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
    EsterenMap.prototype.mapOptions.CustomPolylineBaseOptionsEditMode = {
        clickCallback: function(e){
            var polyline = e.target,
                id = polyline.options.className.replace('drawn_polyline_','')
                ;

            polyline.showSidebar();

            setTimeout(function(){
                var marker, latlngs;
                if (polyline._sidebar.isVisible()) {
                    d.getElementById('polyline_popup_name').value = d.getElementById('polyline_'+id+'_name').value;
                    d.getElementById('polyline_popup_type').value = d.getElementById('polyline_'+id+'_type').value;
                    d.getElementById('polyline_popup_markerStart').value = d.getElementById('polyline_'+id+'_markerStart').value;
                    d.getElementById('polyline_popup_markerEnd').value = d.getElementById('polyline_'+id+'_markerEnd').value;
                    d.getElementById('polyline_popup_faction').value = d.getElementById('polyline_'+id+'_faction').value;

                    d.getElementById('polyline_popup_name').onkeyup = function(){
                        d.getElementById('polyline_'+id+'_name').value = this.value;
                        return false;
                    };
                    d.getElementById('polyline_popup_type').onchange = function(){
                        d.getElementById('polyline_'+id+'_type').value = this.value;
                        return false;
                    };
                    d.getElementById('polyline_popup_faction').onchange = function(){
                        d.getElementById('polyline_'+id+'_faction').value = this.value;
                        return false;
                    };
                    d.getElementById('polyline_popup_markerStart').onchange = function(){
                        d.getElementById('polyline_'+id+'_markerStart').value = this.value;
                        if (this.value && polyline._esterenMap._markers[this.value]) {
                            marker = polyline._esterenMap._markers[this.value];
                            latlngs = polyline._latlngs;
                            latlngs[0] = marker._latlng;
                            polyline.setLatLngs(latlngs);
                            d.getElementById('polyline_1_coordinates').value = JSON.stringify(latlngs);
                            d.getElementById('polyline_1_coordinates').innerHTML = JSON.stringify(latlngs);
                        }

                        return false;
                    };
                    d.getElementById('polyline_popup_markerEnd').onchange = function(){
                        d.getElementById('polyline_'+id+'_markerEnd').value = this.value;
                        if (this.value && polyline._esterenMap._markers[this.value]) {
                            marker = polyline._esterenMap._markers[this.value];
                            latlngs = polyline._latlngs;
                            latlngs[latlngs.length - 1] = marker._latlng;
                            polyline.setLatLngs(latlngs);
                            d.getElementById('polyline_1_coordinates').value = JSON.stringify(latlngs);
                            d.getElementById('polyline_1_coordinates').innerHTML = JSON.stringify(latlngs);
                        }

                        return false;
                    };

                }
            },20);

        }
    };

    EsterenMap.prototype.mapOptions.loaderCallbacks.routes = function(response){
        var routes, i, route,
            mapOptions = this.options(),
            popupContent = mapOptions.LeafletPopupPolylineBaseContent,
            options = mapOptions.CustomPolylineBaseOptions,
            leafletOptions = mapOptions.LeafletPolylineBaseOptions,
            coords
        ;

        if (mapOptions.editMode === true) {
            options = mergeRecursive(options, mapOptions.CustomPolylineBaseOptionsEditMode);
            leafletOptions = mergeRecursive(leafletOptions, mapOptions.LeafletPolylineBaseOptionsEditMode);
        }

        if (response['map.'+mapOptions.id+'.routes']) {
            routes = response['map.'+mapOptions.id+'.routes'];
            for (i in routes) {
                if (routes.hasOwnProperty(i)) {
                    route = routes[i];
                    coords = JSON.parse(route.coordinates);
                    this.addPolyline(coords,
                        mergeRecursive(leafletOptions, {
                            id: route.id
                        }),
                        mergeRecursive(options, {
                            popupContent:popupContent,
                            esterenRoute: route,
                            polylineName: route.name,
                            polylineType: route.route_type.id,
                            polylineFaction: route.faction ? route.faction.id : '',
                            polylineMarkerStart: route.marker_start ? route.marker_start.id : '',
                            polylineMarkerEnd: route.marker_end ? route.marker_end.id : ''
                        })
                    );
                }//endif (polyline.hasOwnProperty)
            }//endfor
        }// endif response
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

        while (d.getElementById('polyline_'+this.mapOptions.maxPolylineId+'_name')) {
            this.mapOptions.maxPolylineId ++;
        }

        if (!leafletOptions.id) {
            id = this.mapOptions.maxPolylineId;
        } else {
            id = leafletOptions.id;
        }

        while (d.getElementById('polyline_'+id+'_name')) { id ++; }

        className = 'drawn_polyline_'+id;

        leafletOptions.className = className;

        polyline = L.polyline(latLng, leafletOptions);

        polyline._esterenMap = this;

        polyline._esterenRoute = customUserOptions.esterenRoute;

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

        if (mapOptions.editMode) {
            $('#inputs_container').append(
                '<input type="hidden" id="polyline_'+id+'_name" name="polyline['+id+'][name]" value="'+(customUserOptions.polylineName?customUserOptions.polylineName:'')+'" />'+
                '<input type="hidden" id="polyline_'+id+'_faction" name="polyline['+id+'][faction]" value="'+(customUserOptions.polylineFaction?customUserOptions.polylineFaction:'')+'" />'+
                '<textarea style="display: none;" id="polyline_'+id+'_coordinates" name="polyline['+id+'][coordinates]">'+JSON.stringify(latLng)+'</textarea>'+
                '<input type="hidden" id="polyline_'+id+'_type" name="polyline['+id+'][type]" value="'+(customUserOptions.polylineType?customUserOptions.polylineType:'1')+'" />'+
                '<input type="hidden" id="polyline_'+id+'_markerStart" name="polyline['+id+'][markerStart]" value="'+(customUserOptions.polylineMarkerStart?customUserOptions.polylineMarkerStart:'')+'" />'+
                '<input type="hidden" id="polyline_'+id+'_markerEnd" name="polyline['+id+'][markerEnd]" value="'+(customUserOptions.polylineMarkerEnd?customUserOptions.polylineMarkerEnd:'')+'" />'
            );
        }

        polyline.addTo(this._drawnItems);

        this._polylines[id] = polyline;

        return this;
    };


})(jQuery, L, document, window);