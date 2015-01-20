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

    L.Marker.prototype.updateIcon = function(){
        // Change l'image de l'icône
        this._icon.src = this._esterenMarker.marker_type.icon.formats.icon.url;

        // Met à jour l'attribut "data" pour les filtres
        $(this._icon).attr('data-leaflet-object-type', 'markerType'+this._esterenMarker.marker_type.id);
    };

    L.Marker.prototype.disableEditMode = function() {
        this.dragging.disable();
        this._icon.classList.remove('selected');
    };

    L.Marker.prototype._updateEM = function() {
        var esterenMarker = this._esterenMarker || null,
            id = esterenMarker.id || null;
        if (esterenMarker && this._map) {
            esterenMarker.map = esterenMarker.map || {id: this._esterenMap.options().id };
            esterenMarker.latitude = this._latlng.lat;
            esterenMarker.longitude = this._latlng.lng;
            esterenMarker.altitude = this._latlng.alt;
            esterenMarker.faction = esterenMarker.faction || null;
            this._esterenMap._load({
                uri: "markers" + (id ? '/'+id : ''),
                method: id ? "POST" : "PUT", // Si on n'a pas d'ID, c'est qu'on crée un nouveau marqueur
                data: {
                    json: esterenMarker,
                    mapping: {
                        name: true,
                        description: true,
                        longitude: true,
                        latitude: true,
                        map: true,
                        marker_type: {
                            objectField: 'markerType'
                        },
                        faction: true
                    }
                },
                callback: function(response) {
                    var map = this,
                        marker = response.newObject;
                    if (!response.error) {
                        if (marker && marker.id) {
                            map._markers[marker.id]._esterenMarker = marker;
                            map._markers[marker.id].updateIcon();
                        } else {
                            console.warn('Marker retrieved by API does not have ID.');
                        }
                    } else {
                        console.error('Api sent back an error while attempting to '+(id?'update':'insert')+' a marker.');
                    }
                },
                callbackError: function() {
                    console.error('Could not make a request to '+(id?'update':'insert')+' a marker.');
                }
            });
        } else {
            console.error('Tried to update an empty marker.');
        }
    };

    EsterenMap.prototype.esterenMarkerPrototype = {
        id: null,
        name: null,
        description: null,
        marker_type: null,
        faction: null,
        latitude: null,
        longitude: null
    };

    /**
     * @this {EsterenMap}
     * @param response
     */
    EsterenMap.prototype._mapOptions.loaderCallbacks.markers = function(response){
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

        for (i in this._markers) {
            if (this._markers.hasOwnProperty(i)) {
                this._map.removeLayer(this._markers[i]);
                this._drawnItems.removeLayer(this._markers[i]);
            }
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


    EsterenMap.prototype._mapOptions.LeafletMarkerBaseOptions = {
        clickable: true,
        draggable: false
    };

    EsterenMap.prototype._mapOptions.LeafletMarkerBaseOptionsEditMode = {
        draggable: false
    };

    EsterenMap.prototype._mapOptions.LeafletIconBaseOptions = {
        shadowUrl: '',
        shadowRetinaUrl: ''
    };

    EsterenMap.prototype._mapOptions.CustomMarkerBaseOptions = {
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

    EsterenMap.prototype._mapOptions.CustomMarkerBaseOptionsEditMode = {
        clickCallback: function(e){
            var marker = e.target,
                map = marker._esterenMap,
                esterenMarker = marker._esterenMarker,
                id = esterenMarker.id || marker.options.alt
            ;

            if (map._editedMarker) {
                map._editedMarker.disableEditMode();
            }
            marker.dragging.enable();
            marker.showSidebar();
            marker._icon.classList.add('selected');
            map._editedMarker = marker;

            if (marker._sidebar.isVisible() && esterenMarker) {
                d.getElementById('marker_popup_name').value = esterenMarker.name;
                d.getElementById('marker_popup_type').value = esterenMarker.marker_type ? esterenMarker.marker_type.id : null;
                d.getElementById('marker_popup_faction').value = esterenMarker.faction ? esterenMarker.faction.id : "";

                d.getElementById('marker_popup_name').onkeyup = function(){
                    map._markers[id]._esterenMarker.name = this.value;
                    if (this._timeout) { clearTimeout(this._timeout); }
                    this._timeout = setTimeout(function(){ map._markers[id]._updateEM(); }, 1000);
                    return false;
                };
                d.getElementById('marker_popup_type').onchange = function(){
                    map._markers[id]._esterenMarker.marker_type = map.refDatas('markersTypes', this.value);
                    map._markers[id]._updateEM();
                    return false;
                };
                d.getElementById('marker_popup_faction').onchange = function(){
                    map._markers[id]._esterenMarker.faction = map.refDatas('factions', this.value);
                    map._markers[id]._updateEM();
                    return false;
                };
            }

        },
        dblclickCallback: function(e){
            var marker = e.target,
                msg = CONFIRM_DELETE || 'Supprimer ?',
                id = marker._esterenMarker ? marker._esterenMarker.id : null;
            if (marker._esterenMap.options().editMode == true && id) {
                if (confirm(msg)) {
                    if (d.getElementById('marker_' + id + '_deleted')) {
                        d.getElementById('marker_' + id + '_deleted').value = 'true';
                    } else {
                        $('<input type="hidden" value="true" />')
                            .attr({
                                'id': 'marker_' + id + '_deleted',
                                'name': 'marker[' + id + '][deleted]'
                            }).appendTo('#inputs_container');
                    }
                    marker._map.removeLayer(marker);
                    marker.fire('remove');
                }
            }
            return false;
        },
        dragendCallback: function(e) {
            var marker = e.target,
                id = marker.options.alt,
                latlng = marker.getLatLng();
//                marker.setLatLng(latlng).update();
            d.getElementById('marker_'+id+'_latitude').value = latlng.lat;
            d.getElementById('marker_'+id+'_longitude').value = latlng.lng;
            if (marker._esterenMarker) {
                marker._esterenMarker.latitude = latlng.lat;
                marker._esterenMarker.longitude = latlng.lng;
            }
            marker._updateEM();
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
            leafletOptions = this.cloneObject(mapOptions.LeafletMarkerBaseOptions),
            iconOptions = this.cloneObject(mapOptions.LeafletIconBaseOptions),
            id,option,optionTag,icon,iconHeight,iconWidth,
            marker,popup,popupContent,popupOptions;

        if (leafletUserOptions) {
            leafletOptions = this.cloneObject(leafletOptions, leafletUserOptions);
        }

        if (customUserOptions.icon) {
            iconOptions = this.cloneObject(iconOptions, customUserOptions.icon);
        }

        while (d.getElementById('marker_'+this._mapOptions.maxMarkerId+'_name')) {
            this._mapOptions.maxMarkerId ++;
        }

        if (!leafletOptions.alt) {
            id = this._mapOptions.maxMarkerId;
        } else {
            id = leafletOptions.alt;
        }
        while (d.getElementById('marker_'+id+'_name')) { id ++; }

        leafletOptions.alt = id;

        marker = L.marker(latLng, leafletOptions);

        marker._esterenMap = this;
        if (customUserOptions.esterenMarker) {
            marker._esterenMarker = customUserOptions.esterenMarker;
        } else {
            // Ici on tente de créer un nouveau marqueur
            marker._esterenMarker = this.esterenMarkerPrototype;
            marker._esterenMarker.marker_type = this.refDatas('markersTypes', 1);
        }

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

        // Ajout de l'icône au cas où
        if (marker._esterenMarker.marker_type && marker._esterenMarker.marker_type.icon) {
            iconOptions.iconUrl = marker._esterenMarker.marker_type.icon.formats.icon.url;

            iconWidth = marker._esterenMarker.marker_type.icon.formats.icon.width;
            iconHeight = marker._esterenMarker.marker_type.icon.formats.icon.height;
            if (iconWidth || iconHeight) {
                // N'applique une icône QUE si la hauteur ou la largeur sont définies

                if (!iconWidth) {
                    // Calcule la largeur de l'icône à partir du ratio largeur/largeur_icone si celle-ci n'est pas définie
                    iconWidth = parseInt(marker._esterenMarker.marker_type.icon.width / (marker._esterenMarker.marker_type.icon.height / iconHeight));
                }
                if (!iconHeight) {
                    // Calcule la hauteur de l'icône à partir du ratio largeur/largeur_icone si celle-ci n'est pas définie
                    iconHeight = parseInt(marker._esterenMarker.marker_type.icon.height / (marker._esterenMarker.marker_type.icon.width / iconWidth));
                }

                iconOptions.iconSize = [iconWidth, iconHeight];
                iconOptions.iconAnchor = [parseInt(iconWidth / 2), parseInt(iconHeight / 2)];

                icon = L.icon(iconOptions);
                marker.setIcon(icon);
            }
        }

        this._drawnItems.addLayer(marker);

        option = 'markerType'+(customUserOptions.markerType?customUserOptions.markerType:'1');
        if (marker._icon.dataset) {
            marker._icon.dataset.leafletObjectType = option;
        }
        marker._icon.setAttribute('data-leaflet-object-type', option);

        this._markers[id] = marker;

        return this;
    };


})(jQuery, L, document, window);