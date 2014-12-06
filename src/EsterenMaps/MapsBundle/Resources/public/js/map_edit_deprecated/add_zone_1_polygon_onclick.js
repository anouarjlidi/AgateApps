document.addZonePolygonOnClick = function () {
    if (this.classList.contains('active')
        || document.getElementById('map_container').getAttribute('data-add-element') === 'true'
        || document.getElementById('map_add_zone').classList.contains('active')
        || document.getElementById('map_add_route').classList.contains('active')
        || document.getElementById('map_add_marker').classList.contains('active')
        ) {
        // Aucun effet si le polygone courant est déjà sélectionné
        // Aucun effet non plus si le polygone n'a pas pour parent "map_svg_container"
        return false;
    }

    document.getElementById('map_container').click();

    // Suppression de la classe "active" des autres polygones
    var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polygon'), len = list.length;
    for (var i = 0; i < len; i++){
        if (list[i].id !== this.id) {
            list[i].classList.remove('active');
        }
    }

    // Ajout de la classe "active" au polygone courant
    this.classList.add('active');

    var inputNameId = "input_"+this.id.replace('_polygon', '_name'),
        inputTarget = document.getElementById(inputNameId),
        inputChange = document.getElementById('map_input_change');

    // Récupération de la valeur correcte dans l'input
    inputChange.setAttribute('data-input-id', inputNameId);
    inputChange.removeAttribute('disabled');
    inputChange.value = inputTarget.value;

    document.getElementById('map_delete_element').removeAttribute('disabled');
    document.getElementById('map_delete_element').setAttribute('data-element-id', this.id);
    inputChange.focus();
};


(function(){
    // Applique la fonction ci-dessus à tous les polygones
    var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polygon'), len = list.length;
    for (var i = 0; i < len; i++){
        list[i].onclick = document.addZonePolygonOnClick;
    }
})();