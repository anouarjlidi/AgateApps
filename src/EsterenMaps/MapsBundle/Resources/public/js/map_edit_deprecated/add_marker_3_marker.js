(function($){
//    var mapAddMarker = document.getElementById('map_add_marker');
//    var mapContainerId = mapAddMarker.getAttribute('data-map-container') ? mapAddMarker.getAttribute('data-map-container') : 'map_container';


    // Ajout d'un marqueur
    document.getElementById('map_add_marker').onclick = function(){
        // Variables
        var _this = this,
            marker,
            i,l,c,
            MarkersContainer = document.getElementById('map_markers'),
            mapContainer = document.getElementById('map_container'),
            attr = this.getAttribute('data-active') === 'true' ? 'true' : 'false';

        document.addMarkerId = document.addMarkerId ? document.addMarkerId : 0;
        while (document.getElementById('map_add_marker['+document.addMarkerId+']')) {
            document.addMarkerId ++;
        }

        if (!document.addMarkerPinIcon) {
            i = document.createElement('span');
            i.classList.add('glyphicon');
            i.classList.add('icon-pin');
            i.classList.add('map-marker');
            i.style.position = 'absolute';
            document.addMarkerPinIcon = i;
            i = null;
        }

        if (attr === 'false') {
            document.getElementById('map_add_route').setAttribute('disabled','disabled');
            document.getElementById('map_add_zone').setAttribute('disabled','disabled');
            // Activation de l'ajout d'un marqueur
            attr = 'true';
            this.classList.add('active');//Le bouton du menu devient actif
        } else {
            document.getElementById('map_add_route').removeAttribute('disabled');
            document.getElementById('map_add_zone').removeAttribute('disabled');
            attr = 'false';
            this.classList.remove('active');
        }
        // Définition de l'attribut "active" pour le bouton et le container : ce dernier sera utilisé par les callbacks d'events
        this.setAttribute('data-active', attr);
        mapContainer.setAttribute('data-add-element', attr);

        if (attr === 'false') {
            $(mapContainer).off('mousedown.addmarker');
            $(mapContainer).off('mouseup.addmarker');
        } else {
            $(mapContainer).on('mousedown.addmarker', function(e){
                // Dans un premier temps, récupère les coordonnées de la souris au mouseDown
                // Elles sont ensuite placées dans base_coords, dans le conteneur de la map
                // Cela sera réutilisé lors du mouseUp afin de vérifier que l'utilisateur n'a pas fait un drag de la map
                mapContainer = this;
                if (mapContainer.getAttribute('data-add-element') === 'true') {
                    document.addMarkerMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                    mapContainer.base_coords = e.clientX + ',' + e.clientY;
                }
            });
            $(mapContainer).on('mouseup.addmarker', function(e){
                // Lors du mouseUp, le marqueur se voit affecter un nouveau point, et donc un nouveau sommet
                // Les coordonnées sont calculées exactement de la même façon qu'au mouseMove
                // Si la variable base_coords du conteneur de map ne contient pas les mêmes coordonnées,
                //  alors c'est que l'utilisateur a fait un drag ou a déplacé sa souris
                mapContainer = this;
                if (mapContainer.getAttribute('data-add-element') === 'true') {
                    var base_coords = e.clientX+','+e.clientY;
                    if (base_coords === mapContainer.base_coords) {
                        document.addMarkerMapContainerOffset = $(mapContainer).offset();// Redéfinition de l'offset du conteneurs
                        var x = parseInt(e.clientX - document.addMarkerMapContainerOffset.left + window.pageXOffset);
                        var y = parseInt(e.clientY - document.addMarkerMapContainerOffset.top + window.pageYOffset);
                        var id = 'map_add_marker['+document.addMarkerId+']';
                        document.addMarkerId ++;
                        var inputs_container = document.getElementById('map_inputs_container');

                        if (isNaN(x) || isNaN(y)) {
                            // Si l'une des coordonnées n'est pas un nombre, c'est qu'il y a eu une erreur
                            // Dans ce cas, le sommet ne sera pas ajouté
                            console.error('Error with points '+(isNaN(x) ? "x" : "y")+"\n event : ", e);
                            return false;
                        }

                        // Ajout du marqueur
                        var pin = $(document.addMarkerPinIcon).clone()[0];
                        pin.id = id;
                        pin.style.left = x+'px';
                        pin.style.top = y+'px';
//                        pin.onclick = document.addMarkerOnClick;
                        $(pin).on('click.marker', document.addMarkerOnClick);
//                        $(pin).bind('click', document.addMarkerOnClick);
                        document.getElementById('map_markers').appendChild(pin);
                        $(pin).draggable(document.addMarkerPinDraggableObject);

                        // Ajout des inputs
                        var input_coords = document.createElement('input');
                        input_coords.type = 'hidden';
                        input_coords.id = 'input_'+id.replace('_marker','_marker_coords');
                        input_coords.name = id.replace('_marker','_marker_coords');
                        input_coords.value = x+','+y;
                        inputs_container.appendChild(input_coords);

                        var input_type = document.createElement('input');
                        input_type.type = 'hidden';
                        input_type.id = 'input_'+id.replace('_marker','_marker_type');
                        input_type.name = id.replace('_marker','_marker_type');
                        inputs_container.appendChild(input_type);

                        var input_name = document.createElement('input');
                        input_name.type = 'hidden';
                        input_name.id = 'input_'+id.replace('_marker','_marker_name');
                        input_name.name = id.replace('_marker','_marker_name');
                        inputs_container.appendChild(input_name);

                        $('#map_add_marker').trigger('click');
                    }
                }
            });
        }

        return false;// Permet d'éviter la présence du hash dans l'url
    };

})(jQuery);