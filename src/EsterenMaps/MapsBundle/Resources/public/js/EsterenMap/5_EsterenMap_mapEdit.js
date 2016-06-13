(function(d){

    var markers, zones, routes;

    // Depends on "toggleClass" helper.

    /**
     * Masquage des MARQUEURS
     */
    if (markers = d.getElementById('hide_markers')) {
        markers.addEventListener('click', function(){
            var css = d.getElementById('map_add_style').innerHTML;
            this.toggleClass('active');
            if(this.className.match('active')){
                css += '/*@MARKERS*/.leaflet-marker-icon{display:none;}/*MARKERS@*/'+"\n";
            } else {
                css = css.replace(/[\/]\*@MARKERS[^@]+@\*\//gi, '');
            }
            d.getElementById('map_add_style').innerHTML = css;
        });
    }

    /**
     * Masquage des ZONES
     */
    if (zones = d.getElementById('hide_zones')) {
        zones.addEventListener('click', function () {
            var css = d.getElementById('map_add_style').innerHTML;
            this.toggleClass('active');
            if (this.className.match('active')) {
                css += '/*@ZONES*/[class*=drawn_polygon]{display:none;}/*ZONES@*/' + "\n";
            } else {
                css = css.replace(/[\/]\*@ZONES[^@]+@\*\//gi, '');
            }
            d.getElementById('map_add_style').innerHTML = css;
        });
    }

    /**
     * Masquage des ROUTES
     */
    if (routes = d.getElementById('hide_routes')) {
        routes.addEventListener('click', function () {
            var css = d.getElementById('map_add_style').innerHTML;
            this.toggleClass('active');
            if (this.className.match('active')) {
                css += '/*@ROUTES*/[class*=drawn_polyline]{display:none;}/*ROUTES@*/' + "\n";
            } else {
                css = css.replace(/[\/]\*@ROUTES[^@]+@\*\//gi, '');
            }
            d.getElementById('map_add_style').innerHTML = css;
        });
    }

})(document);
