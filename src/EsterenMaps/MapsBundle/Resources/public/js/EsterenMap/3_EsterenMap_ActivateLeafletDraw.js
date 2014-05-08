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

        this._map.on('draw:created', function(event){
            var type = event.layerType,
                layer = event.layer,
                mapOptions = _this.options(),
                latlng,
                popupContent,
                options,
                editOptions
            ;

            d.drawEvent = event;

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

    };

})(jQuery, L, document, window);