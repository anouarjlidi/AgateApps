document.getElementById('map_dont_move').onclick = function(){
    var active = this.getAttribute('data-active');
    if (active === 'true') {
        active = 'false';
        document.corahn_rin_map.allowMove(true);
        this.parentNode.classList.remove('active');
    } else {
        active = 'true';
        document.corahn_rin_map.allowMove(false);
        this.parentNode.classList.add('active');
    }
    this.setAttribute('data-active', active);
    return false;
};
document.getElementById('map_add_zone').onclick = function(){
    var _this = this,
        polygon,
        attr = this.getAttribute('data-active'),
        container = document.getElementById(this.getAttribute('data-map-container') ? this.getAttribute('data-map-container') : 'map_container'),
        zonesContainer = document.getElementById(this.getAttribute('data-zones-container') ? this.getAttribute('data-zones-container') : 'map_zones');
    if (attr === 'true') {
        attr = 'false';
        this.parentNode.classList.remove('active');
    } else {
        attr = 'true';
        this.parentNode.classList.add('active');
    }
    this.setAttribute('data-active', attr);

    document.addZoneContainer = container;

    if (attr === 'true') {
        document.addZoneCoordinates = [];
        document.addZoneId = document.addZoneId ? document.addZoneId + 1 : 0;
        while (document.getElementById("map_add_zone_polygon_"+document.addZoneId)) {
            document.addZoneId ++;
        }
        document.addZoneNodeId = "map_add_zone_polygon_"+document.addZoneId;
        polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
        polygon.id = document.addZoneNodeId;
        zonesContainer.appendChild(polygon);
        $(zonesContainer).height($(container).height());
    } else {
        document.addZoneContext.stroke();
        document.addZoneContext.closePath();
    }

    if (!container.getAttribute('data-add-zone')){
        document.addZoneContainer.onmousedown = function(e){
            if (document.addZoneContainer.getAttribute('data-add-zone') === 'true') {
                document.addZoneContainer.base_coords = e.clientX + ',' + e.clientY;
            }
        };
        document.addZoneContainer.onmouseup = function(e){
            if (document.addZoneContainer.getAttribute('data-add-zone') === 'true') {
                var x = typeof e.offsetX !== 'undefined'
                    ? e.offsetX
                    : (typeof e.layerX !== 'undefined' ? e.layerX : e.clientX - $(document.addZoneContainer).offset().left + window.pageXOffset );
                var y = typeof e.offsetY !== 'undefined'
                    ? e.offsetY
                    : (typeof e.layerY !== 'undefined' ? e.layerY : e.clientY - $(document.addZoneContainer).offset().top + window.pageYOffset );
                x = parseInt(x);
                y = parseInt(y);
                console.info(e);
                console.info(x,y);
                var base_coords = e.clientX+','+e.clientY;
                if (base_coords === document.addZoneContainer.base_coords) {
                    document.addZoneCoordinates.push(x+','+y);
                    document.getElementById(document.addZoneNodeId).setAttribute('points', document.addZoneCoordinates.join(' '));
                }
            }
        };
    }

    document.addZoneContainer.setAttribute('data-add-zone', attr);

    return false;
};