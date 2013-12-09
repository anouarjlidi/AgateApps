(function($){
    // Désactivation du mouvement
    document.getElementById('map_dont_move').onclick = function(){
        var active = this.getAttribute('data-active');
        if (active === 'true') {
            // Réactivation du mouvement de la map
            active = 'false';
            document.corahn_rin_map.allowMove(true);
            this.parentNode.classList.remove('active');
            this.children[0].classList.remove('text-danger');
            this.children[0].classList.add('text-success');
        } else {
            // Désactivation du mouvement de la map
            active = 'true';
            document.corahn_rin_map.allowMove(false);
            this.parentNode.classList.add('active');
            this.children[0].classList.add('text-danger');
            this.children[0].classList.remove('text-success');
        }
        this.setAttribute('data-active', active);
        return false;
    };

    // Ajout d'un polygone
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

        if (attr === 'true') {
            // Désactivation de l'ajout d'un polygone
            attr = 'false';
            this.parentNode.classList.remove('active');//Le bouton du menu devient inactif
            
            if (document.addZoneCoordinates.length > 3 && document.addZonePolygon) {
                // Si des coordonnées existent, et qu'il y en a plus de 3 (= triangle au moins), alors le polygone est défini
                document.addZonePolygon.setAttribute('points', document.addZoneCoordinates.join(' '));
                // Et un <input> est rajouté au conteneur
                var i = document.createElement('input');
                i.id = document.addZonePolygon.id;
                i.name = document.addZonePolygon.id;
                i.value = document.addZoneCoordinates.join(' ');
                mapContainer.appendChild(i);
                i = null;
            } else {
                // Sinon, s'il y a moins de 3 points dans le polygone, il est supprimé
                document.addZonePolygon.parentNode.removeChild(document.addZonePolygon);
            } 
            
            // Resets
            document.addZoneCoordinates = [];
            document.addZonePolygon = null;
            document.addZoneMapContainerOffset = null;
            
            // Et enfin, suppression des éventuels polygones sans points
            l = document.querySelectorAll('polygon:not([points])');// Liste des éléments
            c = l.length;// Nombre d'éléments
            for (i = 0; i < c; i++) { l[i].parentNode.removeChild(l[i]); }
        } else {
            // Activation de l'ajout d'un polygone
            attr = 'true';
            this.parentNode.classList.add('active');//Le bouton du menu devient actif
            
            // Récupération de l'id maximum à générer. Cela permet de n'avoir que des polygones avec des ID à partir de zéro, et consécutifs.
            while (document.getElementById("map_add_zone_polygon_"+polygonId)) { polygonId ++; }
            polygonIdFull = "map_add_zone_polygon["+polygonId+"]";// Définition de l'ID final du polygone
            
            // Création du polygone à partir du namespace SVG 
            polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
            polygon.id = polygonIdFull;// Application de l'id formaté
            SVGcontainer.appendChild(polygon);// Le polygone est inséré dans le SVG
            
            // Reset des données en vue de la création du polygone
            document.addZoneCoordinates = [];
            document.addZonePolygon = polygon;
            document.addZoneMapContainerOffset = $(mapContainer).offset();
        }
        // Définition de l'attribut "active" pour le bouton et le container : ce dernier sera utilisé par les callbacks d'events
        this.setAttribute('data-active', attr);
        mapContainer.setAttribute('data-add-zone', attr);

        $(SVGcontainer).height($(mapContainer).height());// Redéfinition de la hauteur du SVG pour éviter les problèmes d'overflow hidden
        
        SVGcontainer.onmousedown = attr === 'false' ? null : function(e){
            // Dans un premier temps, récupère les coordonnées de la souris au mouseDown
            // Elles sont ensuite placées dans base_coords, dans le conteneur de la map
            // Cela sera réutilisé lors du mouseUp afin de vérifier que l'utilisateur n'a pas fait un drag de la map
            if (mapContainer.getAttribute('data-add-zone') === 'true') {
                mapContainer.base_coords = e.clientX + ',' + e.clientY;
            }
        };
        mapContainer.onmousemove = attr === 'false' ? null : function(e){
            // Au mousemove, va afficher le prochain sommet du polygone afin de pouvoir visualiser le résultat
            // Les coordonnées de la souris sont calculées avec un maximum de compatibilité possible
            // Le tableau est récupéré dans le DOM, et on y ajoute les coordonnées de la souris au mouseMove
            // Pour éviter que le tableau dans le DOM ne soit modifié, on n'en fait pas un clone dans la variable coordinatesTemp,
            //  il est directement concaténé afin de permettre la conservation de toutes les coordonnées du polygone en construction
            if (mapContainer.getAttribute('data-add-zone') === 'true') {
                if (mapContainer.getAttribute('data-add-zone') === 'true' && document.addZoneCoordinates.length) {
                    var x = typeof e.offsetX !== 'undefined'
                        ? e.offsetX
                        : e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset ;
                    var y = typeof e.offsetY !== 'undefined'
                        ? e.offsetY
                        : e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset;
                    x = parseInt(x);
                    y = parseInt(y);
                    var coordinatesTemp = document.addZoneCoordinates.concat([x+','+y]);
                    document.addZonePolygon.setAttribute('points', coordinatesTemp.join(' '));
                }
            }
        };
        SVGcontainer.onmouseup = attr === 'false' ? null : function(e){
            // Lors du mouseUp, le polygone se voit affecter un nouveau point, et donc un nouveau sommet
            // Les coordonnées sont calculées exactement de la même façon qu'au mouseMove
            // Si la variable base_coords du conteneur de map ne contient pas les mêmes coordonnées,
            //  alors c'est que l'utilisateur a fait un drag ou a déplacé sa souris
            if (mapContainer.getAttribute('data-add-zone') === 'true') {
                var base_coords = e.clientX+','+e.clientY;
                if (base_coords === mapContainer.base_coords) {
                    var x = typeof e.offsetX !== 'undefined'
                        ? e.offsetX
                        : e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset ;
                    var y = typeof e.offsetY !== 'undefined'
                        ? e.offsetY
                        : e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset;
                    x = parseInt(x);
                    y = parseInt(y);
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
})(jQuery);