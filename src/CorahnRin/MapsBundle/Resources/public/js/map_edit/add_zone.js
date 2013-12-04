document.getElementById('map_add_zone').onclick = function(){
    var _this = this,
        nodeTxt,
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

    
    if (attr === 'true') {
        document.addZoneCoordinates = [];
        document.addZoneId = document.addZoneId ? document.addZoneId + 1 : 0;
        while (document.getElementById("map_add_zone_polygon_"+document.addZoneId)) {
            document.addZoneId ++;
        }
        document.addZoneNodeId = "map_add_zone_polygon_"+document.addZoneId;
        nodeTxt = '<polygon id="'+document.addZoneNodeId+'" />';
        zonesContainer.innerHTML += nodeTxt;
        console.info(nodeTxt);
    }

    if (!container.getAttribute('data-add-zone')){
        $(container)
        .mousedown(function(e){
            if (this.getAttribute('data-add-zone') === 'true') {
                this.base_coords = e.offsetX+','+e.offsetY;
            }
        })
        .mouseup(function(e){
            if (this.getAttribute('data-add-zone') === 'true') {
                var coords = e.offsetX+','+e.offsetY;
                if (coords == this.base_coords) {
                    document.addZoneCoordinates.push(e.offsetX+','+e.offsetY);
                    document.getElementById(document.addZoneNodeId).setAttribute('points', document.addZoneCoordinates.join(' '));
                }
            }
        });
    }
    
    container.setAttribute('data-add-zone', attr);
    
    return false;
};