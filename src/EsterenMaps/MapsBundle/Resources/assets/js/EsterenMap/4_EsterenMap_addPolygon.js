(function($, L, d, w){

    // Rajoute qqs attributs à des éléments de Leaflet et LeafletSidebar
    L.Polygon.prototype._esterenMap = {};
    L.Polygon.prototype._esterenZone = {};
    L.Polygon.prototype._sidebar = {};
    L.Polygon.prototype._sidebarContent = '';
    L.Polygon.prototype.showSidebar = function(){
        this._sidebar.setContent(this._sidebarContent);
        this._sidebar.show();
        return this;
    };
    L.Polygon.prototype.hideSidebar = function(){
        this._sidebar.hide();
        this._sidebar.setContent('');
        return this;
    };
    L.Polygon.prototype.toggleSidebar = function(){
        if (this._sidebar.isVisible()) {
            this.hideSidebar();
        } else {
            this.showSidebar();
        }
        return this;
    };
    L.Polygon.prototype.bindSidebar = function(sidebar, content){
        this._sidebar = sidebar;
        this._sidebarContent = content;
        return this;
    };

    L.Polygon.prototype.disableEditMode = function() {
        this._updateEM();
        this.editing.disable();
    };

    L.Polygon.prototype.updateStyle = function(){
        // Change l'image de l'icône
        this._path.setAttribute('fill', this._esterenZone.zone_type.color);
        this._path.setAttribute('stroke', this._esterenZone.zone_type.color);

        // Met à jour l'attribut "data" pour les filtres
        $(this._path).attr('data-leaflet-object-type', 'zoneType'+this._esterenZone.zone_type.id);

    };

    L.Polygon.prototype._updateEM = function() {
        var baseZone = EsterenMap.prototype.cloneObject.call(null, this),
            _this = this,
            callbackMessage = '',
            callbackMessageType = 'success',
            esterenZone = this._esterenZone || null,
            id = esterenZone.id || null;
        if (esterenZone && this._map && !this.launched) {
            esterenZone.map = esterenZone.map || {id: this._esterenMap._mapOptions.id };
            esterenZone.coordinates = JSON.stringify(this._latlngs ? this._latlngs : {});
            esterenZone.faction = esterenZone.faction || {};
            esterenZone.zone_type = { id: esterenZone.zone_type.id };
            this.launched = true;
            this._esterenMap._load({
                url: "zones" + (id ? '/'+id : ''),
                method: id ? "POST" : "PUT", // Si on n'a pas d'ID, c'est qu'on crée une nouvelle zone
                data: {
                    json: esterenZone,
                    mapping: {
                        name: true,
                        coordinates: true,
                        map: true,
                        zone_type: {
                            objectField: 'zoneType'
                        },
                        faction: true
                    }
                },
                callback: function(response) {
                    var map = this,
                        msg,
                        zone = response.newObject;
                    if (!response.error) {
                        if (zone && zone.id) {
                            map._polygons[zone.id] = baseZone;
                            map._polygons[zone.id]._esterenZone = zone;
                            map._polygons[zone.id].updateStyle();
                            callbackMessage = 'Zone: ' + zone.id + ' - ' + zone.name;
                        } else {
                            msg = 'Zone retrieved by API does not have ID.';
                            console.warn(msg);
                            callbackMessage = response.message ? response.message : msg;
                            callbackMessageType = 'warning';
                        }
                    } else {
                        msg = 'Api returned an error while attempting to '+(id?'update':'insert')+' a zone.';
                        console.error(msg);
                        callbackMessage = msg + '<br>' + (response.message ? response.message : 'Unknown error...');
                        callbackMessageType = 'danger';
                    }
                },
                callbackError: function() {
                    var msg = 'Could not make a request to '+(id?'update':'insert')+' a zone.';
                    console.error(msg);
                    callbackMessage = msg;
                    callbackMessageType = 'danger';
                },
                callbackComplete: function(){
                    _this.launched = false;
                    if (callbackMessage) {
                        _this._esterenMap.message(callbackMessage, callbackMessageType);
                    }
                }
            });
        } else if (!this.launched) {
            console.error('Tried to update an empty zone.');
        }
    };

    EsterenMap.prototype.esterenZonePrototype = {
        id: null,
        name: null,
        zone_type: null,
        faction: null,
        coordinates: null
    };

    EsterenMap.prototype._mapOptions.LeafletPolygonBaseOptions = {
        color: "#fff",
        opacity: 0.3,
        fillColor: '#eee',
        fillOpacity: 0.1,
        weight: 2,
        clickable: false
    };

    EsterenMap.prototype._mapOptions.LeafletPolygonBaseOptionsEditMode = {
        opacity: 0.5,
        clickable: true
    };

    EsterenMap.prototype._mapOptions.CustomPolygonBaseOptions = {
        popupIsSidebar: true,
        clickCallback: function(e){
            var polygon = e.target,
                esterenZone = polygon._esterenZone
            ;

            polygon.showSidebar();

            if (polygon._sidebar.isVisible()) {
                d.getElementById('polygon_popup_name').innerHTML = esterenZone.name;
                d.getElementById('polygon_popup_type').innerHTML = esterenZone.zone_type ? esterenZone.zone_type.name : '';
                d.getElementById('polygon_popup_faction').innerHTML = esterenZone.faction ? esterenZone.faction.name : '';
            }
        }
    };

    EsterenMap.prototype._mapOptions.CustomPolygonBaseOptionsEditMode = {
        clickCallback: function(e){
            var polygon = e.target,
                map = polygon._esterenMap,
                id = polygon.options.className.replace('drawn_polygon_','')
                ;

            map.disableEditedElements();
            polygon.editing.enable();
            polygon.showSidebar();
            map._editedPolygon = polygon;

            setTimeout(function(){
                if (polygon._sidebar.isVisible()) {
                    d.getElementById('polygon_popup_name').value = polygon._esterenZone.name;
                    d.getElementById('polygon_popup_faction').value = polygon._esterenZone.faction ? polygon._esterenZone.faction.id : '';
                    d.getElementById('polygon_popup_type').value = polygon._esterenZone.zone_type ? polygon._esterenZone.zone_type.id : '';

                    $('#polygon_popup_name').off('keyup').on('keyup', function(){
                        map._polygons[id]._esterenZone.name = this.value;
                        if (this._timeout) { clearTimeout(this._timeout); }
                        this._timeout = setTimeout(function(){ map._polygons[id]._updateEM(); }, 1000);
                        return false;
                    });
                    $('#polygon_popup_type').off('change').on('change', function(){
                        map._polygons[id]._esterenZone.zone_type = map.reference('zonesTypes', this.value);
                        this._timeout = setTimeout(function(){ map._polygons[id]._updateEM(); }, 1000);
                        return false;
                    });
                    $('#polygon_popup_faction').off('change').on('change', function(){
                        map._polygons[id]._esterenZone.faction = this.value ? map.reference('factions', this.value) : null;
                        this._timeout = setTimeout(function(){ map._polygons[id]._updateEM(); }, 1000);
                        return false;
                    });
                }
            },20);
        },
        dblclickCallback: function(e){
            var polygon = e.target,
                msg = CONFIRM_DELETE || 'Supprimer ?',
                id = polygon._esterenZone ? polygon._esterenZone.id : null;
            if (polygon._esterenMap._mapOptions.editMode == true && id) {
                if (confirm(msg)) {
                    polygon._map.removeLayer(polygon);
                    polygon.fire('remove');
                }
            }
            return false;
        }
    };

    EsterenMap.prototype._mapOptions.loaderCallbacks.zonesTypes = function(response){
        if (response['zonestypes'] && response['zonestypes'].length > 0) {
            this._zonesTypes = response['zonestypes'];
        } else {
            console.error('Error while retrieving zones types');
        }
        return this;
    };

    EsterenMap.prototype._mapOptions.loaderCallbacks.zones = function(response){
        var zones, i, zone,
            finalOptions,finalLeafletOptions,
            mapOptions = this._mapOptions,
            popupContent = mapOptions.LeafletPopupPolygonBaseContent,
            options = mapOptions.CustomPolygonBaseOptions,
            leafletOptions = mapOptions.LeafletPolygonBaseOptions,
            coords
        ;

        for (i in this._polygons) {
            if (this._polygons.hasOwnProperty(i)) {
                this._map.removeLayer(this._polygons[i]);
                this._polygons[i].remove();
            }
        }

        if (mapOptions.editMode === true) {
            options = this.cloneObject(options, mapOptions.CustomPolygonBaseOptionsEditMode);
            leafletOptions = this.cloneObject(leafletOptions, mapOptions.LeafletPolygonBaseOptionsEditMode);
        }

        if (response['map.'+mapOptions.id+'.zones']) {
            zones = response['map.'+mapOptions.id+'.zones'];
            for (i in zones) {
                if (zones.hasOwnProperty(i)) {
                    zone = zones[i];
                    coords = (typeof zone.coordinates === 'string') ? JSON.parse(zone.coordinates ? zone.coordinates : "{}") : zone.coordinates;
                    finalLeafletOptions = this.cloneObject(leafletOptions, {id:zone.id});

                    if (zone.zone_type && zone.zone_type.color) {
                        finalLeafletOptions.color = zone.zone_type.color;
                        finalLeafletOptions.fillColor = zone.zone_type.color;
                    }

                    finalOptions = this.cloneObject(options, {
                        popupContent:popupContent,
                        esterenZone: zone,
                        polygonName: zone.name,
                        polygonType: zone.zone_type ? zone.zone_type.id : null,
                        polygonFaction: zone.faction ? zone.faction.id : ''
                    });
                    this.addPolygon(coords,
                        finalLeafletOptions,
                        finalOptions
                    );
                }//endif (polygon.hasOwnProperty)
            }//endfor
        }// endif response
    };

    /**
     * Ajoute une zone à la carte
     * @param latLng
     * @param leafletUserOptions
     * @param customUserOptions
     * @returns {EsterenMap}
     */
    EsterenMap.prototype.addPolygon = function(latLng, leafletUserOptions, customUserOptions) {
        var _this = this,
            mapOptions = this._mapOptions,
            className,
            id,
            option,
            leafletOptions = mapOptions.LeafletPolygonBaseOptions,
            polygon,popupContent,popupOptions;

        if (leafletUserOptions) {
            leafletOptions = this.cloneObject(leafletOptions, leafletUserOptions);
        }

        while (d.getElementById('polygon_'+this._mapOptions.maxPolygonId+'_name')) {
            this._mapOptions.maxPolygonId ++;
        }

        if (!leafletOptions.id) {
            id = this._mapOptions.maxPolygonId;
        } else {
            id = leafletOptions.id;
        }

        while (d.getElementById('polygon_'+id+'_name')) { id ++; }

        className = 'drawn_polygon_'+id;

        leafletOptions.className = className;

        polygon = L.polygon(latLng, leafletOptions);

        polygon._esterenMap = this;
        if (customUserOptions.esterenZone) {
            polygon._esterenZone = customUserOptions.esterenZone;
        } else {
            // Ici on tente de créer une nouvelle zone
            polygon._esterenZone = this.esterenZonePrototype;
            polygon._esterenZone.zone_type = this.reference('zonesTypes', 1);
        }

        // Création d'une popup
        popupContent = customUserOptions.popupContent;
        if (!popupContent) {
            popupContent = mapOptions.LeafletPopupPolygonBaseContent;
        }
        if (popupContent && typeof popupContent === 'string') {
            popupOptions = mapOptions.LeafletPopupBaseOptions;
            if (typeof customUserOptions.popupOptions !== 'undefined') {
                popupOptions = this.cloneObject(popupOptions, customUserOptions.popupOptions);
            }
            polygon.bindSidebar(this._sidebar, popupContent);
        } else if (customUserOptions.popupContent && typeof customUserOptions.popupContent !== 'string') {
            console.error('popupContent parameter must be a string.');
        }

        // Application des events listeners
        for (option in customUserOptions) {
            if (customUserOptions.hasOwnProperty(option) && option.match(/Callback$/)) {
                polygon.addEventListener(option.replace('Callback',''), customUserOptions[option]);
            }
        }

        polygon.addTo(this._map);

        option = 'zoneType'+(customUserOptions.polygonType?customUserOptions.polygonType:'1');
        if (polygon._path.dataset) {
            polygon._path.dataset.leafletObjectType = option;
        }
        polygon._path.setAttribute('data-leaflet-object-type', option);

        this._polygons[id] = polygon;

        return this;
    };
})(jQuery, L, document, window);
