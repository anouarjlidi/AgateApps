(function($){
    var mapAddZone = document.getElementById('map_add_zone');
    var mapContainerId = mapAddZone.getAttribute('data-map-container') ? mapAddZone.getAttribute('data-map-container') : 'map_container';
    document.addZonePinDraggableObject = {
        start: function(e,ui){
            document.addZoneMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var x = parseInt(e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset);
            var y = parseInt(e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset);
            var offsets = {};
            document.addZoneMovingPinIndex = $('[data-target-polygon="'+ui.helper.attr('data-target-polygon')+'"]').index(this);
            document.addZonePolygon = document.getElementById(ui.helper.attr('data-target-polygon'));
            document.addZoneCoordinates = document.addZonePolygon.getAttribute('points').split(' ');
            offsets.left = x - document.addZoneCoordinates[document.addZoneMovingPinIndex].split(',')[0];
            offsets.top = y - document.addZoneCoordinates[document.addZoneMovingPinIndex].split(',')[1];
            document.addZoneMovingPinOffset = offsets;
        },
        drag: function(e, ui){
            document.addZoneMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var coord = document.addZoneCoordinates.concat([]);
            var index = document.addZoneMovingPinIndex;
            var x = parseInt(e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset - document.addZoneMovingPinOffset.left);
            var y = parseInt(e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset - document.addZoneMovingPinOffset.top);
            coord[index] = x+','+y;
            document.addZonePolygon.setAttribute('points', coord.join(' '));
        },
        stop: function(e, ui){
            document.addZoneMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            $(document.getElementById("input_"+document.addZonePolygon.id)).val(document.addZonePolygon.getAttribute('points'));
            document.addZoneMovingPinIndex = null;
            document.addZonePolygon = null;
            document.addZoneCoordinates = null;
            document.addZoneMovingPinOffset = null;
        }
    };
    var listPolygons = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polygon'),
        len = listPolygons.length;
    for (var i = 0; i < len; i++) {
        listPolygons[i].onclick = document.addZonePolygonOnClick;
    }
    $('.map-icon-target').draggable(document.addZonePinDraggableObject);
    // Désactivation du mouvement
    if (document.getElementById('map_dont_move')) {
        document.getElementById('map_dont_move').onclick = function(){
            var active = this.getAttribute('data-active');
            if (active === 'true') {
                // Réactivation du mouvement de la map
                active = 'false';
                document.corahn_rin_map.allowMove(true);
                this.classList.remove('active');
                this.parentNode.classList.remove('active');
                this.children[0].classList.remove('text-danger');
                this.children[0].classList.add('text-success');
            } else {
                // Désactivation du mouvement de la map
                active = 'true';
                document.corahn_rin_map.allowMove(false);
                this.classList.add('active');
                this.parentNode.classList.add('active');
                this.children[0].classList.add('text-danger');
                this.children[0].classList.remove('text-success');
            }
            this.onblur();
            this.setAttribute('data-active', active);
            return false;
        };
    }

    // Ajout d'un polygone
    if (document.getElementById('map_add_zone')) {
        document.getElementById('map_add_zone').onclick = function(){
            // Variables
            var _this = this,
                polygon,
                i,l,c,
                SVGcontainer = document.getElementById(this.getAttribute('data-zones-container') ? this.getAttribute('data-zones-container') : 'map_zones'),
                mapContainer = document.getElementById(this.getAttribute('data-map-container') ? this.getAttribute('data-map-container') : 'map_container'),
                polygonId = document.addZonePolygonId ? document.addZonePolygonId : 0,
                polygonIdFull = document.addZonePolygonIdFull ? document.addZonePolygonIdFull : '',
                attr = this.getAttribute('data-active');

            if (!document.addZonePinIcon) {
                i = document.createElement('span');
                i.classList.add('glyphicon');
                i.classList.add('icon-screenshot');
                i.classList.add('map-icon-target');
                i.style.position = 'absolute';
                document.addZonePinIcon = i;
                i = null;
            }

            if (attr === 'true') {
                // Désactivation de l'ajout d'un polygone
                attr = 'false';
                this.parentNode.classList.remove('active');//Le bouton du menu devient inactif

                if (document.addZoneCoordinates.length > 2 && document.addZonePolygon) {
                    // Si des coordonnées existent, et qu'il y en a au moins 3 (= triangle au moins), alors le polygone est défini
                    document.addZonePolygon.setAttribute('points', document.addZoneCoordinates.join(' '));

                    // Un <input> est rajouté au conteneur pour contenir les coordonnées
                    var i = document.createElement('input');
                    i.id = "input_"+document.addZonePolygonIdFull;
                    i.type = 'hidden';
                    i.name = document.addZonePolygonIdFull;
                    i.value = document.addZoneCoordinates.join(' ');
                    $(mapContainer).parents('form').append(i);

                    // Un autre input est ajouté pour contenir le titre
                    i = document.createElement('input');
                    i.id = "input_"+document.addZonePolygonIdFull.replace('_polygon', '_name');
                    i.type = 'hidden';
                    i.name = document.addZonePolygonIdFull.replace('_polygon', '_name');
                    i.value = "";
                    $(mapContainer).parents('form').append(i);
                    i = null;

                    document.addZonePolygon.onclick = document.addZonePolygonOnClick;
                } else {
                    // Sinon, s'il y a moins de 3 points dans le polygone, il est supprimé
                    document.addZonePolygon.parentNode.removeChild(document.addZonePolygon);
                }

                // Resets
                document.addZoneCoordinates = [];
                document.addZonePolygon = null;

                // Et enfin, suppression des éventuels polygones sans points
                l = document.querySelectorAll('polygon:not([points])');// Liste des éléments
                c = l.length;// Nombre d'éléments
                for (i = 0; i < c; i++) { l[i].parentNode.removeChild(l[i]); }
            } else {
                // Activation de l'ajout d'un polygone
                attr = 'true';
                this.parentNode.classList.add('active');//Le bouton du menu devient actif

                // Récupération de l'id maximum à générer. Cela permet de n'avoir que des polygones avec des ID à partir de zéro, et consécutifs.
                while (document.getElementById("map_add_zone_polygon["+polygonId+"]")) { polygonId ++; }
                polygonIdFull = "map_add_zone_polygon["+polygonId+"]";// Définition de l'ID final du polygone

                // Création du polygone à partir du namespace SVG
                polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
                polygon.id = polygonIdFull;// Application de l'id formaté
                SVGcontainer.appendChild(polygon);// Le polygone est inséré dans le SVG

                // Reset des données en vue de la création du polygone
                document.addZoneCoordinates = [];
                document.addZonePolygon = polygon;
                document.addZonePolygonIdFull = polygonIdFull;
                document.addZoneMapContainerOffset = $(mapContainer).offset();
            }
            // Définition de l'attribut "active" pour le bouton et le container : ce dernier sera utilisé par les callbacks d'events
            this.setAttribute('data-active', attr);
            mapContainer.setAttribute('data-add-zone', attr);

            $(SVGcontainer).height($(mapContainer).height());// Redéfinition de la hauteur du SVG pour éviter les problèmes d'overflow hidden

            mapContainer.onmousedown = attr === 'false' ? null : function(e){
                // Dans un premier temps, récupère les coordonnées de la souris au mouseDown
                // Elles sont ensuite placées dans base_coords, dans le conteneur de la map
                // Cela sera réutilisé lors du mouseUp afin de vérifier que l'utilisateur n'a pas fait un drag de la map
                mapContainer = this;
                if (mapContainer.getAttribute('data-add-zone') === 'true') {
                    document.addZoneMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                    mapContainer.base_coords = e.clientX + ',' + e.clientY;
                    document.addZoneBaseTarget = e.target;
                }
            };
            mapContainer.onmousemove = attr === 'false' ? null : function(e){
                // Au mousemove, va afficher le prochain sommet du polygone afin de pouvoir visualiser le résultat
                // Les coordonnées de la souris sont calculées avec un maximum de compatibilité possible
                // Le tableau est récupéré dans le DOM, et on y ajoute les coordonnées de la souris au mouseMove
                // Pour éviter que le tableau dans le DOM ne soit modifié, on n'en fait pas un clone dans la variable coordinatesTemp,
                //  il est directement concaténé afin de permettre la conservation de toutes les coordonnées du polygone en construction
                mapContainer = document.corahn_rin_map.container();
                if (this.getAttribute('data-add-zone') === 'true') {
                    if (this.getAttribute('data-add-zone') === 'true' && document.addZoneCoordinates.length) {
                        document.addZoneMapContainerOffset = $(this).offset();// Redéfinition de l'offset du conteneurs
                        var x = parseInt(e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset) - 1;
                        var y = parseInt(e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset) - 1;
                        var coordinatesTemp = document.addZoneCoordinates.concat([x+','+y]);
                        document.addZonePolygon.setAttribute('points', coordinatesTemp.join(' '));
                    }
                }
            };
            mapContainer.onmouseup = attr === 'false' ? null : function(e){
                // Lors du mouseUp, le polygone se voit affecter un nouveau point, et donc un nouveau sommet
                // Les coordonnées sont calculées exactement de la même façon qu'au mouseMove
                // Si la variable base_coords du conteneur de map ne contient pas les mêmes coordonnées,
                //  alors c'est que l'utilisateur a fait un drag ou a déplacé sa souris
                mapContainer = this;
                if (mapContainer.getAttribute('data-add-zone') === 'true') {
                    var base_coords = e.clientX+','+e.clientY;
                    if (base_coords === mapContainer.base_coords) {
                        document.addZoneMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                        if (document.addZoneBaseTarget.classList.contains('map-icon-target')) {
                            var x = $(document.addZoneBaseTarget).position().left;
                            var y = $(document.addZoneBaseTarget).position().top;
                        } else {
                            var x = parseInt(e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset);
                            var y = parseInt(e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset);
                        }

                        var pin = $(document.addZonePinIcon).clone()[0];
                        pin.setAttribute('data-target-polygon', document.addZonePolygonIdFull);
                        pin.style.left = x+'px';
                        pin.style.top = y+'px';
                        mapContainer.appendChild(pin);
                        $(pin).draggable(document.addZonePinDraggableObject);
                        if (isNaN(x) || isNaN(y)) {
                            // Si l'une des coordonnées n'est pas un nombre, c'est qu'il y a eu une erreur
                            // Dans ce cas, le sommet ne sera pas ajouté
                            console.error('Error with points '+(isNaN(x) ? "x" : "y")+"\n event : ", e);
                            return false;
                        }
                        document.addZoneCoordinates.push(x+','+y);
                        document.addZonePolygon.setAttribute('points', document.addZoneCoordinates.join(' '));
                    }
                }
            };

            return false;// Permet d'éviter la présence du hash dans l'url
        };
    }

})(jQuery);