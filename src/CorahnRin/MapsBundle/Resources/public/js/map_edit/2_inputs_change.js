(function(){
    var changeFunction = function(e){
        // Retourne false si la touche est "entrée"
        if (e.keyCode && e.keyCode === 13) { return false; }

        var dataInputId = this.getAttribute('data-input-id');

        if (!dataInputId || !document.getElementById(dataInputId)) {
            // Si aucune cible n'a été définie
            console.error('Incorrect input id');
            return false;
        }

        document.getElementById(dataInputId).value = this.value;
        return false;
    };
    /////////////////// CHANGEMENT DE VALEUR DANS L'INPUT ///////////////////
    // Ces fonctions vont permettre à l'inputChange d'envoyer sa valeur à l'input hidden demandé
    document.getElementById('map_input_change').onkeydown = function(e){if (e.keyCode === 13) { return false; }};
    document.getElementById('map_input_change').onkeypress = function(e){if (e.keyCode === 13) { return false; }};
    document.getElementById('map_input_change').onkeyup = changeFunction;
    document.getElementById('map_select_route_type').onchange = changeFunction;
    document.getElementById('map_select_marker_type').onchange = changeFunction;
})();