(function(d){

    // Depends on "toggleClass" helper.

    /**
     * Masquage des MARQUEURS
     */
    d.getElementById('hide_markers').addEventListener('click', function(){
        var css = d.getElementById('map_add_style').innerHTML;
        this.toggleClass('active');
        if(this.className.match('active')){
            css += '/*@MARKERS*/.leaflet-marker-icon{display:none;}/*MARKERS@*/'+"\n";
        } else {
            css = css.replace(/[\/]\*@MARKERS[^@]+@\*\//gi, '');
        }
        d.getElementById('map_add_style').innerHTML = css;
    });

    /**
     * Masquage des ZONES
     */
    d.getElementById('hide_zones').addEventListener('click', function(){
        var css = d.getElementById('map_add_style').innerHTML;
        this.toggleClass('active');
        if(this.className.match('active')){
            css += '/*@ZONES*/[class*=drawn_polygon]{display:none;}/*ZONES@*/'+"\n";
        } else {    
            css = css.replace(/[\/]\*@ZONES[^@]+@\*\//gi, '');
        }
        d.getElementById('map_add_style').innerHTML = css;
    });

    /**
     * Masquage des ROUTES
     */
    d.getElementById('hide_routes').addEventListener('click', function(){
        var css = d.getElementById('map_add_style').innerHTML;
        this.toggleClass('active');
        if(this.className.match('active')){
            css += '/*@ROUTES*/[class*=drawn_polyline]{display:none;}/*ROUTES@*/'+"\n";
        } else {
            css = css.replace(/[\/]\*@ROUTES[^@]+@\*\//gi, '');
        }
        d.getElementById('map_add_style').innerHTML = css;
    });

})(document);
