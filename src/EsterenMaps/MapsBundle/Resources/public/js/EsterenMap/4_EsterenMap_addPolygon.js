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

    EsterenMap.prototype._mapOptions.LeafletPolygonBaseOptions = {
        color: "#fff",
        opacity: 0.3,
        fillColor: '#eee',
        fillOpacity: 0.1,
        weight: 2,
        clickable: true
    };

    EsterenMap.prototype._mapOptions.LeafletPolygonBaseOptionsEditMode = {
        opacity: 0.5
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
                id = polygon.options.className.replace('drawn_polygon_','')
                ;

            polygon.showSidebar();

            setTimeout(function(){
                var marker, latlngs;
                if (polygon._sidebar.isVisible()) {
                    d.getElementById('polygon_popup_name').value = d.getElementById('polygon_'+id+'_name').value;
                    d.getElementById('polygon_popup_faction').value = d.getElementById('polygon_'+id+'_faction').value;

                    d.getElementById('polygon_popup_name').onkeyup = function(){
                        d.getElementById('polygon_'+id+'_name').value = this.value;
                        return false;
                    };
                    d.getElementById('polygon_popup_faction').onchange = function(){
                        d.getElementById('polygon_'+id+'_faction').value = this.value;
                        return false;
                    };
                }
            },20);

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
            mapOptions = this.options(),
            popupContent = mapOptions.LeafletPopupPolygonBaseContent,
            options = mapOptions.CustomPolygonBaseOptions,
            leafletOptions = mapOptions.LeafletPolygonBaseOptions,
            coords
        ;

        for (i in this._polygons) {
            if (this._polygons.hasOwnProperty(i)) {
                this._map.removeLayer(this._polygons[i]);
                this._drawnItems.removeLayer(this._polygons[i]);
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
                    coords = JSON.parse(zone.coordinates);
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
     * Ajoute un marqueur à la carte
     * @param latLng
     * @param leafletUserOptions
     * @param customUserOptions
     * @returns {EsterenMap}
     */
    EsterenMap.prototype.addPolygon = function(latLng, leafletUserOptions, customUserOptions) {
        var _this = this,
            mapOptions = this.options(),
            className,
            id,
            option,
            leafletOptions = mapOptions.LeafletPolygonBaseOptions,
            polygon,popup,popupContent,popupOptions,
            L_map = _this._map;

        if (leafletUserOptions) {
            leafletOptions = mergeRecursive(leafletOptions, leafletUserOptions);
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
        polygon._esterenZone = customUserOptions.esterenZone;

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

        if (mapOptions.editMode == true) {
            $('#inputs_container').append(
                '<input type="hidden" id="polygon_'+id+'_name" name="polygon['+id+'][name]" value="'+(customUserOptions.polygonName?customUserOptions.polygonName:'')+'" />'+
                '<input type="hidden" id="polygon_'+id+'_faction" name="polygon['+id+'][faction]" value="'+(customUserOptions.polygonFaction?customUserOptions.polygonFaction:'')+'" />'+
                '<textarea style="display: none;" id="polygon_'+id+'_coordinates" name="polygon['+id+'][coordinates]">'+JSON.stringify(latLng)+'</textarea>'+
                '<input type="hidden" id="polygon_'+id+'_type" name="polygon['+id+'][type]" value="'+(customUserOptions.polygonType?customUserOptions.polygonType:'1')+'" />'
            );
        }

        this._drawnItems.addLayer(polygon);

        option = 'zoneType'+(customUserOptions.polygonType?customUserOptions.polygonType:'1');
        polygon._path.dataset.leafletObjectType = option;
        polygon._path.setAttribute('data-leaflet-object-type', option);

        this._polygons[id] = polygon;

        return this;
    };


})(jQuery, L, document, window);