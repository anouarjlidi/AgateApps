(function($){
//    var mapAddRoute = document.getElementById('map_add_route');
//    var mapContainerId = mapAddRoute.getAttribute('data-map-container') ? mapAddRoute.getAttribute('data-map-container') : 'map_container';


    // Ajout d'un polylinee
    document.getElementById('map_add_route').onclick = function(){
        // Variables
        var _this = this,
            polyline,
            i,l,c,
            SVGcontainer = document.getElementById(this.getAttribute('data-routes-container') ? this.getAttribute('data-routes-container') : 'map_routes'),
            mapContainer = document.getElementById(this.getAttribute('data-map-container') ? this.getAttribute('data-map-container') : 'map_container'),
            polylineId = document.addRoutePolylineId ? document.addRoutePolylineId : 0,
            polylineIdFull = document.addRoutePolylineIdFull ? document.addRoutePolylineIdFull : '',
            attr = this.getAttribute('data-active');

        if (!document.addRoutePinIcon) {
            i = document.createElement('span');
            i.classList.add('glyphicon');
            i.classList.add('icon-screenshot');
            i.classList.add('map-icon-target');
            i.style.position = 'absolute';
            document.addRoutePinIcon = i;
            i = null;
        }

        if (attr === 'true') {
            // Désactivation de l'ajout d'un polylinee
            attr = 'false';
            this.classList.remove('active');//Le bouton du menu devient inactif

            if (document.addRouteCoordinates.length > 2 && document.addRoutePolyline) {
                // Si des coordonnées existent, et qu'il y en a au moins 3 (= triangle au moins), alors le polylinee est défini
                document.addRoutePolyline.setAttribute('points', document.addRouteCoordinates.join(' '));

                // Un <input> est rajouté au conteneur pour contenir les coordonnées
                var i = document.createElement('input');
                i.id = "input_"+document.addRoutePolylineIdFull;
                i.type = 'hidden';
                i.name = document.addRoutePolylineIdFull;
                i.value = document.addRouteCoordinates.join(' ');
                $(mapContainer).parents('form').append(i);

                // Un autre input est ajouté pour contenir le titre
                i = document.createElement('input');
                i.id = "input_"+document.addRoutePolylineIdFull.replace('_polyline', '_name');
                i.type = 'hidden';
                i.name = document.addRoutePolylineIdFull.replace('_polyline', '_name');
                i.value = "";
                $(mapContainer).parents('form').append(i);
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
            // Activation de l'ajout d'un polylinee
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
            document.addRoutePolylineIdFull = polylineIdFull;
            document.addRouteMapContainerOffset = $(mapContainer).offset();
        }
        // Définition de l'attribut "active" pour le bouton et le container : ce dernier sera utilisé par les callbacks d'events
        this.setAttribute('data-active', attr);
        mapContainer.setAttribute('data-add-route', attr);

        $(SVGcontainer).height($(mapContainer).height());// Redéfinition de la hauteur du SVG pour éviter les problèmes d'overflow hidden

        mapContainer.onmousedown = attr === 'false' ? null : function(e){
            // Dans un premier temps, récupère les coordonnées de la souris au mouseDown
            // Elles sont ensuite placées dans base_coords, dans le conteneur de la map
            // Cela sera réutilisé lors du mouseUp afin de vérifier que l'utilisateur n'a pas fait un drag de la map
            mapContainer = this;
            if (mapContainer.getAttribute('data-add-route') === 'true') {
                document.addRouteMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                mapContainer.base_coords = e.clientX + ',' + e.clientY;
                document.addRouteBaseTarget = e.target;
            }
        };
        mapContainer.onmousemove = attr === 'false' ? null : function(e){
            // Au mousemove, va afficher le prochain sommet du polylinee afin de pouvoir visualiser le résultat
            // Les coordonnées de la souris sont calculées avec un maximum de compatibilité possible
            // Le tableau est récupéré dans le DOM, et on y ajoute les coordonnées de la souris au mouseMove
            // Pour éviter que le tableau dans le DOM ne soit modifié, on n'en fait pas un clone dans la variable coordinatesTemp,
            //  il est directement concaténé afin de permettre la conservation de toutes les coordonnées du polylinee en construction
            mapContainer = document.corahn_rin_map.container();
            if (this.getAttribute('data-add-route') === 'true') {
                if (this.getAttribute('data-add-route') === 'true' && document.addRouteCoordinates.length) {
                    document.addRouteMapContainerOffset = $(this).offset();// Redéfinition de l'offset du conteneurs
                    var x = parseInt(e.clientX - document.addRouteMapContainerOffset.left + window.pageXOffset) - 1;
                    var y = parseInt(e.clientY - document.addRouteMapContainerOffset.top + window.pageYOffset) - 1;
                    var coordinatesTemp = document.addRouteCoordinates.concat([x+','+y]);
                    document.addRoutePolyline.setAttribute('points', coordinatesTemp.join(' '));
                }
            }
        };
        mapContainer.onmouseup = attr === 'false' ? null : function(e){
            // Lors du mouseUp, le polylinee se voit affecter un nouveau point, et donc un nouveau sommet
            // Les coordonnées sont calculées exactement de la même façon qu'au mouseMove
            // Si la variable base_coords du conteneur de map ne contient pas les mêmes coordonnées,
            //  alors c'est que l'utilisateur a fait un drag ou a déplacé sa souris
            mapContainer = this;
            if (mapContainer.getAttribute('data-add-route') === 'true') {
                var base_coords = e.clientX+','+e.clientY;
                if (base_coords === mapContainer.base_coords) {
                    document.addRouteMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                    if (document.addRouteBaseTarget.classList.contains('map-icon-target')) {
                        var x = $(document.addRouteBaseTarget).position().left;
                        var y = $(document.addRouteBaseTarget).position().top;
                    } else {
                        var x = parseInt(e.clientX - document.addRouteMapContainerOffset.left + window.pageXOffset);
                        var y = parseInt(e.clientY - document.addRouteMapContainerOffset.top + window.pageYOffset);
                    }

                    var pin = $(document.addRoutePinIcon).clone()[0];
                    pin.setAttribute('data-target-polyline', document.addRoutePolylineIdFull);
                    pin.style.left = x+'px';
                    pin.style.top = y+'px';
                    document.getElementById('map_pins_polylines').appendChild(pin);
                    $(pin).draggable(document.addRoutePinDraggableObject);
                    if (isNaN(x) || isNaN(y)) {
                        // Si l'une des coordonnées n'est pas un nombre, c'est qu'il y a eu une erreur
                        // Dans ce cas, le sommet ne sera pas ajouté
                        console.error('Error with points '+(isNaN(x) ? "x" : "y")+"\n event : ", e);
                        return false;
                    }
                    document.addRouteCoordinates.push(x+','+y);
                    document.addRoutePolyline.setAttribute('points', document.addRouteCoordinates.join(' '));
                }
            }
        };

        return false;// Permet d'éviter la présence du hash dans l'url
    };

})(jQuery);