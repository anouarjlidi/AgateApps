(function($){
    var mapAddZone = document.getElementById('map_add_zone');
    var mapContainerId = mapAddZone.getAttribute('data-map-container') ? mapAddZone.getAttribute('data-map-container') : 'map_container';
    document.addZonePolygonOnClick = function () {
        if (this.classList.contains('active')) {
            // Aucun effet si le polygone courant est déjà sélectionné
            // Aucun effet non plus si le polygone n'a pas pour parent "map_zones"
            return false;
        }

        // Suppression de la classe "active" des autres polygones
        var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polygon'), len = list.length;
        for (var i = 0; i < len; i++){ list[i].classList.remove('active'); }

        var inputNameId = "input_"+this.id.replace('_polygon', '_name'),
            inputTarget = document.getElementById(inputNameId),
            inputChange = document.getElementById('map_add_zone_input_change');

        // Récupération de la valeur correcte dans l'input
        inputChange.setAttribute('data-input-id', inputNameId);
        inputChange.value = inputTarget.value;

        // Ajout de la classe "active" au polygone courant
        this.classList.add('active');
        console.info(inputNameId);
        inputChange.focus();

        document.getElementById(mapContainerId).onclick = function(){
        // Suppression de la classe "active" des polygones
            var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polygon'), len = list.length;
            for (var i = 0; i < len; i++){ list[i].classList.remove('active'); }

            // Reset de l'input et de son attribut data utilisé pour la mise à jour des titres
            var inputChange = document.getElementById('map_add_zone_input_change');
            inputChange.setAttribute('data-input-id', '');
            inputChange.value = '';

            this.onclick = null;
        };
    }

    document.getElementById('map_add_zone_input_change').onkeyup = function(){
        var dataInputId = this.getAttribute('data-input-id');

        if (!dataInputId) {
            // Si aucune cible n'a été définie
            console.info('No input id');
            return false;
        }

        document.getElementById(dataInputId).value = this.value;
        return false;
    };


})(jQuery);