(function($, L, d, w){

    /**
     * La classe CorahnRinMap va générer une carte à partir de tuiles
     * @param object params Un objet JSON contenant les paramètres à appliquer
     * @returns CorahnRinMap
     */
    function CorahnRinMap(user_leaflet_options, user_map_options) {

        // Conteneur par défaut
        var base_map_options,
            base_leaflet_options,
            leaflet_options,
            _map,
            map_options = {},
            markers = [];

        base_map_options = {
            container: 'map',
            baseUrl: w.location.protocol + "//" + w.location.hostname + (w.location.port && ":" + w.location.port) + '/api/maps/tile/1/{z}/{x}/{y}.jpg',
            imgUrl: '/bundles/corahnrinmaps/img',
            center: [0,0],
            zoom: 0,
            markerMaxId: 0,
            markerBaseHtml: '',
            editMode: false
        };

        if (base_map_options){ for (var attr in base_map_options) { map_options[attr] = base_map_options[attr]; } }
        if (user_map_options){ for (var attr in user_map_options) { map_options[attr] = user_map_options[attr]; } }

        if (!d.getElementById(map_options.container)) {
            console.error('Map could not initialize : wrong container id');
            return;
        }

        // Options par défaut, celles-ci ne changent pas
        base_leaflet_options = {
            attribution: '&copy; Corahn-Rin',
            minZoom: 0,
            noWrap: true,
            continuousWorld: true
        };

        leaflet_options = {};// Le tableau final

        // Merge des options
        if (user_leaflet_options){ for (var attr in user_leaflet_options) { leaflet_options[attr] = user_leaflet_options[attr]; } }
        if (base_leaflet_options){ for (var attr in base_leaflet_options) { leaflet_options[attr] = base_leaflet_options[attr]; } }

        //
        // Méthodes publiques
        //

        this.getMarkers = function(){ return markers; };

        this.resetHeight = function() {
            // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
            $(d.getElementById(map_options.container)).height($(window).height() - $('#footer').outerHeight(true) - $('#navigation').outerHeight(true));
        };

        this.map = function(){ return _map; };

        //
        // Initialisations
        //
        this.resetHeight();
        _map = L.map(map_options.container, {"center":[0,0],"zoom":map_options.zoom});// Création de la map
        L.tileLayer(map_options.baseUrl, leaflet_options).addTo(_map);// Création du calque des tuiles
        L.Icon.Default.imagePath = map_options.imgUrl.replace(/\/$/gi, '');
        $(w).resize(this.resetHeight);
        map_options.markerMaxId++;

        //
        // Mode édition
        //
        if (map_options.editMode == true) {
            d.getElementById('map_add_marker').onclick = function(){
                if (_map.getContainer().getAttribute('data-add-marker')) {
                    this.classList.remove('active');
                    _map.getContainer().removeAttribute('data-add-marker');
                } else {
                    this.classList.add('active');
                    _map.getContainer().setAttribute('data-add-marker', 'true');
                }
            };

            _map.on('click', function(e){
                if (_map.getContainer().getAttribute('data-add-marker') == 'true') {
                    var latlng = e.latlng.lat+','+e.latlng.lon,
                        marker = new L.marker(e.latlng, {
                        id: 'marker_'+map_options.markerMaxId,
                        clickable: true,
                        draggable: true,
                        riseOnHover: true
                    }).addTo(map);
                    map_options.markerMaxId++;
                    d.getElementById('map_add_marker').classList.remove('active');
                    _map.getContainer().removeAttribute('data-add-marker');
                    marker.on('dragend', function(e){
                        var marker = e.target;
                        var position = marker.getLatLng();
                        marker.setLatLng(position).update();
                    });
                }

            });
        }


        return this;
    }

    w.CorahnRinMap = CorahnRinMap;

})(jQuery, L, document, window);