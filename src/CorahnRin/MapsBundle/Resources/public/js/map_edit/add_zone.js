(function($){
    document.getElementById('map_dont_move').onclick = function(){
        var active = this.getAttribute('data-active');
        if (active === 'true') {
            active = 'false';
            document.corahn_rin_map.allowMove(true);
            this.parentNode.classList.remove('active');
            this.children[0].classList.remove('text-danger');
            this.children[0].classList.add('text-success');
        } else {
            active = 'true';
            document.corahn_rin_map.allowMove(false);
            this.parentNode.classList.add('active');
            this.children[0].classList.add('text-danger');
            this.children[0].classList.remove('text-success');
        }
        this.setAttribute('data-active', active);
        return false;
    };
    document.getElementById('map_add_zone').onclick = function(){
        var _this = this,
            polygon,
            i,l,c,
            coordinates = [],
            SVGcontainer = document.getElementById(this.getAttribute('data-zones-container') ? this.getAttribute('data-zones-container') : 'map_zones'),
            mapContainer = document.getElementById(this.getAttribute('data-map-container') ? this.getAttribute('data-map-container') : 'map_container'),
            polygonId = document.addZonePolygonId ? document.addZonePolygonId : 0,
            polygonIdFull = document.addZonePolygonIdFull ? document.addZonePolygonIdFull : '',
            attr = this.getAttribute('data-active');

        if (attr === 'true') {
            if (document.addZoneCoordinates.length && document.addZonePolygon) {
                document.addZonePolygon.setAttribute('points', document.addZoneCoordinates.join(' '));
            }
            document.addZoneCoordinates = [];
            document.addZonePolygon = null;
            document.addZoneMapContainerOffset = null;
            attr = 'false';
            this.parentNode.classList.remove('active');
            return;
        } else {
            attr = 'true';
            this.parentNode.classList.add('active');
        }
        this.setAttribute('data-active', attr);

        if (attr === 'true') {
            while (document.getElementById("map_add_zone_polygon_"+polygonId)) {
                polygonId ++;
            }
            polygonIdFull = "map_add_zone_polygon_"+polygonId;
            polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
            polygon.id = polygonIdFull;
            SVGcontainer.appendChild(polygon);
            $(SVGcontainer).height($(mapContainer).height());
        } else {
            l = document.querySelectorAll('polygon:not([points])');
            c = l.length;
            for (i = 0; i < c; i++) {
                l[i].parentNode.removeChild(l[i]);
            }
        }

        mapContainer.setAttribute('data-add-zone', attr);

        document.addZoneCoordinates = coordinates;
        document.addZonePolygon = polygon;
        document.addZoneMapContainerOffset = $(mapContainer).offset();

        if (!mapContainer.getAttribute('data-function-defined')){
            SVGcontainer.onmousedown = function(e){
                if (mapContainer.getAttribute('data-add-zone') === 'true') {
                    mapContainer.base_coords = e.clientX + ',' + e.clientY;
                }
            };
            mapContainer.onmousemove = function(e){
                if (mapContainer.getAttribute('data-add-zone') === 'true') {
                    if (mapContainer.getAttribute('data-add-zone') === 'true' && document.addZoneCoordinates.length) {
                        var x = typeof e.offsetX !== 'undefined'
                            ? e.offsetX
                            : e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset ;
                        var y = typeof e.offsetY !== 'undefined'
                            ? e.offsetY
                            : e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset;
                        x = parseInt(x);
                        y = parseInt(y);
                        var coordinatesTemp = document.addZoneCoordinates.concat([x+','+y]);
                        document.addZonePolygon.setAttribute('points', coordinatesTemp.join(' '));
                    }
                }
            };
            SVGcontainer.onmouseup = function(e){
                if (mapContainer.getAttribute('data-add-zone') === 'true') {
                    var base_coords = e.clientX+','+e.clientY;
                    if (base_coords === mapContainer.base_coords) {
                        var x = typeof e.offsetX !== 'undefined'
                            ? e.offsetX
                            : /*(typeof e.layerX !== 'undefined' ? e.layerX :*/ e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset /*)*/;
                        var y = typeof e.offsetY !== 'undefined'
                            ? e.offsetY
                            : /*(typeof e.layerY !== 'undefined' ? e.layerY :*/ e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset /*)*/;
                        x = parseInt(x);
                        y = parseInt(y);
                        if (isNaN(x) || isNaN(y)) {
                            console.error('Error with points '+(isNaN(x) ? "x" : "y")+"\n event : ", e);
                            return false;
                        }
                        document.addZoneCoordinates.push(x+','+y);
                        document.addZonePolygon.setAttribute('points', document.addZoneCoordinates.join(' '));
                    }
                }
            };
            mapContainer.setAttribute('data-function-defined', 'true');
        }

        return
    };
})(jQuery);