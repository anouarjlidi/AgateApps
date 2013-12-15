(function(){
    /////////////////// CLIC DANS LA MAP DÉSACTIVE L'INPUT ///////////////////
    // Le clic sur la carte va désactiver l'inputChange et déselectionner tous les éléments de la carte
    var mapAddZone = document.getElementById('map_add_zone');
    var mapContainerId = mapAddZone.getAttribute('data-map-container') ? mapAddZone.getAttribute('data-map-container') : 'map_container';
    var mapContainer = document.getElementById(mapContainerId);
    document.getElementById(mapContainerId).onclick = function(e){
        if (!$(e.target).is('polygon')) {
            // Suppression de la classe "active" des polygones
            var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polygon'), len = list.length;
            for (var i = 0; i < len; i++){ list[i].classList.remove('active'); }
            var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polyline'), len = list.length;
            for (var i = 0; i < len; i++){ list[i].classList.remove('active'); }

            document.getElementById('map_delete_element').setAttribute('disabled','disabled');
            document.getElementById('map_delete_element').setAttribute('data-element-id', '');

            // Reset de l'input et de son attribut data utilisé pour la mise à jour des titres
            var inputChange = document.getElementById('map_add_zone_input_change');
            inputChange.setAttribute('data-input-id', '');
            inputChange.setAttribute('disabled','disabled');
            inputChange.value = '';
            inputChange.blur();
        }
    };
})();

/////////////////// CHANGEMENT DE VALEUR DANS L'INPUT ///////////////////
// Ces fonctions vont permettre à l'inputChange d'envoyer sa valeur à l'input hidden demandé
document.getElementById('map_add_zone_input_change').onkeydown = function(e){if (e.keyCode === 13) { return false; }};
document.getElementById('map_add_zone_input_change').onkeypress = function(e){if (e.keyCode === 13) { return false; }};
document.getElementById('map_add_zone_input_change').onkeyup = function(e){
    // Retourne false si la touche est "entrée"
    if (e.keyCode === 13) { return false; }

    var dataInputId = this.getAttribute('data-input-id');

    if (!dataInputId) {
        // Si aucune cible n'a été définie
        console.error('No input id');
        return false;
    }

    document.getElementById(dataInputId).value = this.value;
    return false;
};