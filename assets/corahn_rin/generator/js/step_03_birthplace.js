(function($, d){
    var params, basePolygonOptions;
    if (d.getElementById('generator_03_birthplace')) {

        if (d._map_params) {
            basePolygonOptions = EsterenMap.prototype._mapOptions.LeafletPolygonBaseOptions;

            basePolygonOptions.clickable = true;

            params = $.extend(true, d._map_params, {
                editMode: false,
                containerHeight: 600,
                autoresize: true,
                showDirections: false,
                showMarkers: false,
                showRoutes: false,
                autoResize: false,
                LeafletPolygonBaseOptions: basePolygonOptions,
                CustomPolygonBaseOptions: {
                    clickCallback: function(e){
                        var polygon = e.target,
                            map = polygon._esterenMap,
                            polygons = map._polygons,
                            esterenZone = polygon._esterenZone,
                            i
                        ;

                        polygon.showSidebar();

                        if (polygon._sidebar.isVisible()) {
                            d.getElementById('polygon_popup_name').innerHTML = esterenZone.name;
                            d.getElementById('polygon_popup_faction').innerHTML = esterenZone.faction ? esterenZone.faction.name : '';
                        }

                        for (i in polygons) {
                            if (polygons.hasOwnProperty(i)) {
                                polygons[i].setStyle({
                                    color: basePolygonOptions.color,
                                    fillOpacity: basePolygonOptions.fillOpacity,
                                    fillColor: basePolygonOptions.fillOpacity,
                                    weight: basePolygonOptions.weight
                                });
                            }
                        }

                        polygon.setStyle({
                            color: '#f88',
                            fillOpacity: 0.2,
                            fillColor: '#fcc',
                            weight: 3
                        });

                        d.getElementById('region_value').value = esterenZone.id;
                    }
                }
            });
            d.map = new EsterenMap(params);
        }
    }
})(jQuery, document);
