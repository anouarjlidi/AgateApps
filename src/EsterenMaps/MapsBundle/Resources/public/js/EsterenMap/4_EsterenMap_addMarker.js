(function($, L, d, w){

    // Rajoute qqs attributs à des éléments de Leaflet et LeafletSidebar
    L.Marker.prototype._esterenMap = {};
    L.Marker.prototype._esterenMarker = {};
    L.Marker.prototype._sidebar = {};
    L.Marker.prototype._sidebarContent = '';
    L.Marker.prototype.showSidebar = function(){
        this._sidebar.setContent(this._sidebarContent);
        this._sidebar.show();
        return this;
    };
    L.Marker.prototype.hideSidebar = function(){
        this._sidebar.hide();
        this._sidebar.setContent('');
        return this;
    };
    L.Marker.prototype.toggleSidebar = function(){
        if (this._sidebar.isVisible()) {
            this.hideSidebar();
        } else {
            this.showSidebar();
        }
        return this;
    };
    L.Marker.prototype.bindSidebar = function(sidebar, content){
        this._sidebar = sidebar;
        this._sidebarContent = content;
        return this;
    };

    /**
     * @this {EsterenMap}
     * @param response
     */
    EsterenMap.prototype.mapOptions.loaderCallbacks.markers = function(response){
        var markers, i, marker,
            mapOptions = this.options(),
            popupContent = mapOptions.LeafletPopupMarkerBaseContent,
            options = mapOptions.CustomMarkerBaseOptions,
            leafletOptions = mapOptions.LeafletMarkerBaseOptions,
            coords
        ;

        if (mapOptions.editMode === true) {
            options = this.cloneObject(options, mapOptions.CustomMarkerBaseOptionsEditMode);
            leafletOptions = this.cloneObject(leafletOptions, mapOptions.LeafletMarkerBaseOptionsEditMode);
        }

        if (response['map.'+mapOptions.id+'.markers']) {
            markers = response['map.'+mapOptions.id+'.markers'];
            for (i in markers) {
                if (markers.hasOwnProperty(i)) {
                    marker = markers[i];
                    coords = {
                        lat: marker.latitude,
                        lng: marker.longitude,
                        altitude: marker.altitude
                    };

                    options.popupContent = popupContent;
                    options.esterenMarker = marker;
                    options.markerName = marker.name;
                    options.markerType = marker.marker_type.id;
                    options.markerFaction = marker.faction ? marker.faction.id : '';

                    leafletOptions.alt = marker.id;
                    
                    this.addMarker(coords,
                        leafletOptions,
                        options
                    );
                }//endif (marker.hasOwnProperty)
            }//endfor
        }// endif response
    };


    EsterenMap.prototype.mapOptions.LeafletMarkerBaseOptions = {
        clickable: true,
        draggable: false
    };

    EsterenMap.prototype.mapOptions.LeafletMarkerBaseOptionsEditMode = {
        draggable: true
    };

    EsterenMap.prototype.mapOptions.CustomMarkerBaseOptions = {
        popupIsSidebar: true,
        clickCallback: function(e){
            var marker = e.target,
                esterenMarker = marker._esterenMarker
            ;

            marker.showSidebar();

            if (marker._sidebar.isVisible()) {
                d.getElementById('marker_popup_name').innerHTML = esterenMarker.name;
                d.getElementById('marker_popup_type').innerHTML = esterenMarker.marker_type.name;
                d.getElementById('marker_popup_faction').innerHTML = esterenMarker.faction ? esterenMarker.faction.name : '';
            }
        }
    };

    EsterenMap.prototype.mapOptions.CustomMarkerBaseOptionsEditMode = {
        clickCallback: function(e){
            var marker = e.target,
                id = marker.options.alt
            ;

            marker.showSidebar();

            if (marker._sidebar.isVisible()) {
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

        },
        moveCallback: function(e){
            var marker = e.target,
                id = marker.options.alt,
                latlng = marker.getLatLng();
//                marker.setLatLng(latlng).update();
            d.getElementById('marker_'+id+'_latitude').value = latlng.lat;
            d.getElementById('marker_'+id+'_longitude').value = latlng.lng;
        },
        addCallback: function(e){
            var marker = e.target,
                id = marker.options.alt;
            if (marker._esterenMap.editMode == true && id) {
                if (d.getElementById('marker_'+id+'_deleted')) {
                    d.getElementById('marker_'+id+'_deleted').value = 'false';
                } else {
                    $('<input type="hidden" value="false" />')
                        .attr({
                            'id':'marker_'+id+'_deleted',
                            'name':'marker['+id+'][deleted]'
                        }).appendTo('#inputs_container');
                }
            }
        },
        removeCallback: function(e){
            var marker = e.target,
                id = marker.options.alt;
            if (marker._esterenMap.editMode == true && id) {
                if (d.getElementById('marker_'+id+'_deleted')) {
                    d.getElementById('marker_'+id+'_deleted').value = 'true';
                } else {
                    $('<input type="hidden" value="true" />')
                        .attr({
                            'id':'marker_'+id+'_deleted',
                            'name':'marker['+id+'][deleted]'
                        }).appendTo('#inputs_container');
                }
            }
        }
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
            mapOptions = this.options(),
            id,
            option,optionTag,
            leafletOptions = this.cloneObject(mapOptions.LeafletMarkerBaseOptions),
            marker,popup,popupContent,popupOptions,
            L_map = _this._map;

        if (leafletUserOptions) {
            leafletOptions = this.cloneObject(leafletOptions, leafletUserOptions);
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

        marker = L.marker(latLng, leafletOptions);

        marker._esterenMap = this;
        marker._esterenMarker = customUserOptions.esterenMarker;

        // Création d'une popup
        popupContent = customUserOptions.popupContent;
        if (!popupContent) {
            popupContent = mapOptions.LeafletPopupMarkerBaseContent;
        }
        if (popupContent && typeof popupContent === 'string') {
            popupOptions = mapOptions.LeafletPopupBaseOptions;
            if (typeof customUserOptions.popupOptions !== 'undefined') {
                popupOptions = this.cloneObject(popupOptions, customUserOptions.popupOptions);
            }
            if (customUserOptions.popupIsSidebar == true) {
                marker.bindSidebar(this._sidebar, popupContent);
            } else {
                popup = L.popup(popupOptions);
                popup.setContent(popupContent);
                marker.bindPopup(popup);
            }
        } else if (customUserOptions.popupContent && typeof customUserOptions.popupContent !== 'string') {
            console.error('popupContent parameter must be a string.');
        }

        // Application des events listeners
        for (option in customUserOptions) {
            if (customUserOptions.hasOwnProperty(option) && option.match(/Callback$/)) {
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

        marker.addTo(this._drawnItems);

        this._markers[id] = marker;

        return this;
    };


})(jQuery, L, document, window);