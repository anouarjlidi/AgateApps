(function($){
//    var mapAddRoute = document.getElementById('map_add_route');
//    var mapContainerId = mapAddRoute.getAttribute('data-map-container') ? mapAddRoute.getAttribute('data-map-container') : 'map_container';


    // Ajout d'un polylinee
    document.getElementById('map_add_route').onclick = function(){
        // Variables
        var _this = this,
            polyline,
            i,l,c,
            SVGcontainer = document.getElementById('map_svg_container'),
            mapContainer = document.getElementById('map_container'),
            polylineId = document.addRoutePolylineId ? document.addRoutePolylineId : 0,
            polylineIdFull = document.addRoutePolylineIdFull ? document.addRoutePolylineIdFull : '',
            attr = this.getAttribute('data-active');

        if (!document.addRoutePinIcon) {
            i = document.createElement('span');
            i.classList.add('glyphicon');
            i.classList.add('icon-riflescope');
            i.classList.add('map-icon-target');
            i.style.position = 'absolute';
            document.addRoutePinIcon = i;

            document.addRouteInputEnd = '<input type="hidden" name="map_add_route_end[__name__]" id="input_map_add_route_end[__name__]" value="" />';
        }

        if (attr === 'true') {
            $('.map-marker').on('click.marker', document.addMarkerOnClick);
            // Désactivation de l'ajout d'un polylinee
            document.getElementById('map_add_zone').removeAttribute('disabled');
            document.getElementById('map_add_marker').removeAttribute('disabled');
            attr = 'false';
            this.classList.remove('active');//Le bouton du menu devient inactif

            if (document.addRouteCoordinates.length > 2 && document.addRoutePolyline) {
                // Si des coordonnées existent, et qu'il y en a au moins 3 (= triangle au moins), alors le polylinee est défini
                document.addRoutePolyline.setAttribute('points', document.addRouteCoordinates.join(' '));

                // Un <input> est rajouté au conteneur pour contenir les coordonnées
                i = '<input type="hidden" id="input_'+document.addRoutePolylineIdFull+'" name="'+document.addRoutePolylineIdFull+'" value="'+document.addRouteCoordinates.join(' ')+'" />';
                document.getElementById('map_inputs_container').innerHTML += i;

                // Un autre input est ajouté pour contenir le titre
                i = '<input type="hidden" id="input_'+document.addRoutePolylineIdFull.replace('_polyline', '_name')+'" name="'+document.addRoutePolylineIdFull.replace('_polyline', '_name')+'" value="" />';
                document.getElementById('map_inputs_container').innerHTML += i;

                // Un autre input est ajouté pour contenir le type
                i = '<input type="hidden" id="input_'+document.addRoutePolylineIdFull.replace('_polyline', '_type')+'" name="'+document.addRoutePolylineIdFull.replace('_polyline', '_type')+'" value="" />';
                document.getElementById('map_inputs_container').innerHTML += i;
                i = null;

                document.addRoutePolyline.onclick = document.addRoutePolylineOnClick;
            } else {
                // Sinon, s'il y a moins de 3 points dans le polylinee, il est supprimé
                document.addRoutePolyline.parentNode.removeChild(document.addRoutePolyline);
            }

            // Resets
            document.addRouteCoordinates = [];
            document.addRoutePolyline = null;

            // Et enfin, suppression des éventuels polylinees sans points
            l = document.querySelectorAll('polyline:not([points])');// Liste des éléments
            c = l.length;// Nombre d'éléments
            for (i = 0; i < c; i++) { l[i].parentNode.removeChild(l[i]); }
        } else {
            $('.map-marker').off('click.marker', document.addMarkerOnClick);
            // Activation de l'ajout d'un polylinee
            document.getElementById('map_add_zone').setAttribute('disabled','disabled');
            document.getElementById('map_add_marker').setAttribute('disabled','disabled');
            attr = 'true';
            this.classList.add('active');//Le bouton du menu devient actif

            // Récupération de l'id maximum à générer. Cela permet de n'avoir que des polylinees avec des ID à partir de zéro, et consécutifs.
            while (document.getElementById("map_add_route_polyline["+polylineId+"]")) { polylineId ++; }
            polylineIdFull = "map_add_route_polyline["+polylineId+"]";// Définition de l'ID final du polylinee

            // Création du polylinee à partir du namespace SVG
            polyline = document.createElementNS('http://www.w3.org/2000/svg', 'polyline');
            polyline.id = polylineIdFull;// Application de l'id formaté
            SVGcontainer.appendChild(polyline);// Le polylinee est inséré dans le SVG

            // Reset des données en vue de la création du polylinee
            document.addRouteCoordinates = [];
            document.addRoutePolyline = polyline;
            document.addRoutePolylineId = polylineId;
            document.addRoutePolylineIdFull = polylineIdFull;
            document.addRouteMapContainerOffset = $(mapContainer).offset();
        }
        // Définition de l'attribut "active" pour le bouton et le container : ce dernier sera utilisé par les callbacks d'events
        this.setAttribute('data-active', attr);
        mapContainer.setAttribute('data-add-element', attr);
        document.addElementEditMode = attr === 'true';

        $(SVGcontainer).height($(mapContainer).height());// Redéfinition de la hauteur du SVG pour éviter les problèmes d'overflow hidden

        if (attr === 'false') {
            $(mapContainer).off('mousedown.addroute');
            $(mapContainer).off('mousemove.addroute');
            $(mapContainer).off('mouseup.addroute');
        } else {
            $(mapContainer).on('mousedown.addroute', function(e){
                // Dans un premier temps, récupère les coordonnées de la souris au mouseDown
                // Elles sont ensuite placées dans base_coords, dans le conteneur de la map
                // Cela sera réutilisé lors du mouseUp afin de vérifier que l'utilisateur n'a pas fait un drag de la map
                mapContainer = this;
                if (mapContainer.getAttribute('data-add-element') === 'true'
                    && e.target
                    && (
                        e.target.classList.contains('map-marker')
                        ||
                        document.addRouteCoordinates.length > 0
                    )
                ) {
                    document.addRouteMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                    mapContainer.base_coords = e.clientX + ',' + e.clientY;
                    document.addRouteBaseTarget = e.target;
                }
            });
            $(mapContainer).on('mousemove.addroute', function(e){
                // Au mousemove, va afficher le prochain sommet du polylinee afin de pouvoir visualiser le résultat
                // Les coordonnées de la souris sont calculées avec un maximum de compatibilité possible
                // Le tableau est récupéré dans le DOM, et on y ajoute les coordonnées de la souris au mouseMove
                // Pour éviter que le tableau dans le DOM ne soit modifié, on n'en fait pas un clone dans la variable coordinatesTemp,
                //  il est directement concaténé afin de permettre la conservation de toutes les coordonnées du polylinee en construction
                mapContainer = document.esterenmap.container();
                if (this.getAttribute('data-add-element') === 'true') {
                    if (this.getAttribute('data-add-element') === 'true' && document.addRouteCoordinates.length) {
                        document.addRouteMapContainerOffset = $(this).offset();// Redéfinition de l'offset du conteneurs

                        if (e.target.classList.contains('map-icon-target') && !document.getElementById('map_stop_magnetism').classList.contains('active')) {
                            var x = $(e.target).position().left;
                            var y = $(e.target).position().top;
                        } else {
                            var x = parseInt(e.clientX - document.addRouteMapContainerOffset.left + window.pageXOffset) - 1;
                            var y = parseInt(e.clientY - document.addRouteMapContainerOffset.top + window.pageYOffset) - 1;
                        }
                        var coordinatesTemp = document.addRouteCoordinates.concat([x+','+y]);
                        document.addRoutePolyline.setAttribute('points', coordinatesTemp.join(' '));
                    }
                }
            });

            $(mapContainer).on('mouseup.addroute', function(e){
                // Lors du mouseUp, le polylinee se voit affecter un nouveau point, et donc un nouveau sommet
                // Les coordonnées sont calculées exactement de la même façon qu'au mouseMove
                // Si la variable base_coords du conteneur de map ne contient pas les mêmes coordonnées,
                //  alors c'est que l'utilisateur a fait un drag ou a déplacé sa souris
                mapContainer = this;
                if (mapContainer.getAttribute('data-add-element') === 'true') {
                    var base_coords = e.clientX+','+e.clientY;
                    if (base_coords === mapContainer.base_coords) {
                        document.addRouteMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                        if (e.target.classList.contains('map-icon-target') && !document.getElementById('map_stop_magnetism').classList.contains('active')) {
                            var x = $(e.target).position().left;
                            var y = $(e.target).position().top;
                        } else if (e.target.classList.contains('map-marker')) {
                            var x = $(e.target).position().left;
                            var y = $(e.target).position().top;
                        } else {
                            var x = parseInt(e.clientX - document.addRouteMapContainerOffset.left + window.pageXOffset);
                            var y = parseInt(e.clientY - document.addRouteMapContainerOffset.top + window.pageYOffset);
                        }

                        var pin = $(document.addRoutePinIcon).clone()[0];
                        pin.setAttribute('data-target-element', document.addRoutePolylineIdFull);
                        pin.style.left = x+'px';
                        pin.style.top = y+'px';
                        document.getElementById('map_pins_polylines').appendChild(pin);
                        if (e.target.classList.contains('map-marker')) {
                            pin.classList.add('hide');
                        } else {
                            $(pin).draggable(document.addRoutePinDraggableObject);
                        }
                        if (isNaN(x) || isNaN(y)) {
                            // Si l'une des coordonnées n'est pas un nombre, c'est qu'il y a eu une erreur
                            // Dans ce cas, le sommet ne sera pas ajouté
                            console.error('Error with points '+(isNaN(x) ? "x" : "y")+"\n event : ", e);
                            return false;
                        }
                        document.addRouteCoordinates.push(x+','+y);
                        document.addRoutePolyline.setAttribute('points', document.addRouteCoordinates.join(' '));
                        if (e.target.classList.contains('map-marker') && document.addRouteCoordinates.length <= 1) {
                            document.getElementById('map_inputs_container').innerHTML += '<input type="hidden" name="map_add_route_start['+document.addRoutePolylineId+']" id="input_map_add_route_start['+document.addRoutePolylineId+']" value="'+e.target.id.replace(/^map_add_marker\[([0-9]+)\]$/gi, '$1')+'" />';
                        } else if (e.target.classList.contains('map-marker') && document.addRouteCoordinates.length > 1) {
                            document.getElementById('map_inputs_container').innerHTML += '<input type="hidden" name="map_add_route_end['+document.addRoutePolylineId+']" id="input_map_add_route_end['+document.addRoutePolylineId+']" value="'+e.target.id.replace(/^map_add_marker\[([0-9]+)\]$/gi, '$1')+'" />';
                            document.getElementById('map_add_route').click();
                        }
                    }
                }
            });
        }

        return false;// Permet d'éviter la présence du hash dans l'url
    };

})(jQuery);