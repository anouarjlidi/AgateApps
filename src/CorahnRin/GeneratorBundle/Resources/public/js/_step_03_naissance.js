(function($, d){
    var params, baseOptions;
    if (d.getElementById('generator_naissance')) {

//        document.getElementsByClassName('step_module')[0].className = 'step_module';
//        document.getElementsByClassName('step_menu')[0].className = 'step_menu';
//        document.getElementsByClassName('step_list')[0].classList.add('list-inline');
//
//        var l = document.getElementsByTagName('polygon'),
//        c = l.length,
//        i = 0;
//
//        for (i = 0; i < c; i++) {
//            $(l[i]).bind('click', function(){
//                var l = document.querySelectorAll('polygon.checked'),
//                    c = l.length;
//                i = 0;
//                for (i = 0; i < c; i++) {
//                    l[i].classList.remove('checked');
//                }
//                this.classList.add('checked');
//                document.getElementById('region_value').value = this.getAttribute('data-region-id');
//            });
//        }

        if (d._map_params) {
            baseOptions = EsterenMap.prototype.mapOptions.LeafletPolygonBaseOptions;
            params = $.extend(true, d._map_params, {
                editMode: false,
                autoResize: false,
                loadedCallback: function(){
                    this.loadZones();
                },
                CustomPolygonBaseOptions: {
                    clickCallback: function(e){
                        var polygon = e.target,
                            map = polygon._esterenMap,
                            id = polygon.options.className.replace('drawn_polygon_',''),
                            polygons = map._polygons,
                            esterenZone = polygon._esterenZone,
                            i, marker, latlngs
                        ;

                        polygon.showSidebar();

                        if (polygon._sidebar.isVisible()) {
                            d.getElementById('polygon_popup_name').innerHTML = esterenZone.name;
                            d.getElementById('polygon_popup_faction').innerHTML = esterenZone.faction ? esterenZone.faction.name : '';
                        }

                        for (i in polygons) {
                            if (polygons.hasOwnProperty(i)) {
                                polygons[i].setStyle({
                                    color: baseOptions.color,
                                    fillOpacity: baseOptions.fillOpacity,
                                    fillColor: baseOptions.fillOpacity,
                                    weight: baseOptions.weight
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
//            d.map.loadZones();
//            d.map.loadMarkers();
//            d.map.loadRoutes();
        }
    }
})(jQuery, document);