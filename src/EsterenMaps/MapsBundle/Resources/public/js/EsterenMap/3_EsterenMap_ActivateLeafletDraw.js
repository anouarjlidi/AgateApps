(function($, L, d, w){

    /**
     * Initialise la surcharge des différents prototypes de LeafletDraw
     * Ceci dans le but d'adapter cette librairie à EsterenMap
     */
    EsterenMap.prototype.activateLeafletDraw = function(){
        var _this = this,
            drawControl,drawnItems
        ;

        if (this.mapOptions.editMode !== true) {
            return false;
        }

        // Doit contenir les nouveaux éléments ajoutés à la carte afin qu'ils soient éditables
        drawnItems = new L.FeatureGroup();
        this._map.addLayer(drawnItems);

        // Ajoute les boutons de contrôle
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
        this._drawControl = drawControl;
        this._drawnItems = drawnItems;

        _this = this;

        this._map.on('draw:created', function(event) {
            var type = event.layerType,
                layer = event.layer,
                mapOptions = _this.options(),
                latlng,
                popupContent,
                options,
                editOptions
                ;

            if (type === 'marker') {
                popupContent = mapOptions.LeafletPopupMarkerBaseContent;
                options = mapOptions.CustomMarkerBaseOptionsEditMode;
                editOptions = mapOptions.LeafletMarkerBaseOptionsEditMode;

                options.popupContent = popupContent;
                options.markerName = '';
                options.markerType = '';
                options.markerFaction = '';
                options.popupIsSidebar = true;

                latlng = layer._latlng;

                _this.addMarker(latlng,
                    editOptions,
                    options
                );
            } else if (type === 'polyline') {
                options = mapOptions.CustomPolylineBaseOptionsEditMode;
                popupContent = mapOptions.LeafletPopupPolylineBaseContent;
                editOptions = mapOptions.LeafletPolylineBaseOptionsEditMode;

                latlng = layer._latlngs;

                _this.addPolyline(latlng,
                    editOptions,
                    options
                );
            } else if (type === 'polygon') {
                options = mapOptions.CustomPolygonBaseOptionsEditMode;
                popupContent = mapOptions.LeafletPopupPolygonBaseContent;
                editOptions = mapOptions.LeafletPolygonBaseOptionsEditMode;

                latlng = layer._latlngs;

                _this.addPolygon(latlng,
                    editOptions,
                    options
                );
            }

            return true;
        });

        this._map.on('draw:edited', function(event) {
            var type = event.type,
                layers = event.layers,
                id,
                inputId
            ;

            console.info('event draw:edited');
            d.eventedited=event;

            d.layersd=[];

            layers.eachLayer(function (layer) {
                console.info('currently on layer ', layer);
                d.layersd.push(layer);
                if (layer._esterenMarker && layer._esterenMarker.id) {
                    $('#marker_'+layer._esterenMarker.id+'_latitude').val(layer.getLatLng().lat);
                    $('#marker_'+layer._esterenMarker.id+'_longitude').val(layer.getLatLng().lng);
                    console.info('edited marker '+layer._esterenMarker.id);

                } else if (layer._esterenRoute && layer._esterenRoute.id) {
                    inputId = '#polyline_'+layer._esterenRoute.id+'_coordinates';
                    $(inputId).val(JSON.stringify(layer.getLatLngs()));
                    console.info('edited route '+layer._esterenRoute.id);

                } else if (layer._esterenZone && layer._esterenZone.id) {
                    inputId = '#polygon_'+layer._esterenZone.id+'_coordinates';
                    $(inputId).val(JSON.stringify(layer.getLatLngs()));
                    console.info('edited zone '+layer._esterenZone.id);

                }
            });

            return true;
        });

        this._map.on('draw:deleted', function(event) {
        });

    };

})(jQuery, L, document, window);