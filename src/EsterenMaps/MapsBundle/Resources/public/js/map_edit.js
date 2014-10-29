(function($, d, w){

    /**
     * Masquage des MARQUEURS
     */
    $('#hide_markers').on('click', function(){
        var t = $(this),
            css = d.getElementById('map_add_style').innerHTML;
        t.toggleClass('active');
        if(t.is('.active')){
            css += '/*@MARKERS*/.leaflet-marker-icon{display:none;}/*MARKERS@*/'+"\n";
        } else {
            css = css.replace(/[\/]\*@MARKERS[^@]+@\*\//gi, '');
        }
        d.getElementById('map_add_style').innerHTML = css;
    });

    /**
     * Masquage des ZONES
     */
    $('#hide_zones').on('click', function(){
        var t = $(this),
            css = d.getElementById('map_add_style').innerHTML;
        t.toggleClass('active');
        if(t.is('.active')){
            css += '/*@ZONES*/[class*=drawn_polygon]{display:none;}/*ZONES@*/'+"\n";
        } else {
            css = css.replace(/[\/]\*@ZONES[^@]+@\*\//gi, '');
        }
        d.getElementById('map_add_style').innerHTML = css;
    });

    /**
     * Masquage des ROUTES
     */
    $('#hide_routes').on('click', function(){
        var t = $(this),
            css = d.getElementById('map_add_style').innerHTML;
        t.toggleClass('active');
        if(t.is('.active')){
            css += '/*@ROUTES*/[class*=drawn_polyline]{display:none;}/*ROUTES@*/'+"\n";
        } else {
            css = css.replace(/[\/]\*@ROUTES[^@]+@\*\//gi, '');
        }
        d.getElementById('map_add_style').innerHTML = css;
    });

})(jQuery, document, window);