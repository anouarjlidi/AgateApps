(function($){
    document.addMarkerOnClick = function () {

        if (this.classList.contains('active')
            || document.getElementById('map_container').getAttribute('data-add-element') === 'true'
            || document.getElementById('map_add_zone').classList.contains('active')
            || document.getElementById('map_add_route').classList.contains('active')
            || document.getElementById('map_add_marker').classList.contains('active')
            || document.addElementEditMode
            ) {
            // Aucun effet si le marqueur courant est déjà sélectionné
            // ou que l'on est en mode édition
            console.info('not able to click');
            return false;
        } else {
            document.getElementById('map_container').click();

            // Suppression de la classe "active" des autres marqueurs
            var list = document.getElementsByClassName('map-marker'), len = list.length;
            for (var i = 0; i < len; i++){
                if (list[i].id !== this.id) {
                    list[i].classList.remove('active');
                }
            }

            // Ajout de la classe "active" au marqueur courant
            this.classList.add('active');

            var id = 'input_'+this.id,
                inputName = document.getElementById(id.replace('_marker','_marker_name')),
                inputType = document.getElementById(id.replace('_marker','_marker_type')),
                inputChange = document.getElementById('map_input_change'),
                selectList = document.getElementById('map_select_marker_type');

            if (!inputName || !inputType || !inputChange || !selectList) {
                console.error('No input correctly loaded');
                return false;
            }

            // Récupération de la valeur correcte dans l'input
            inputChange.setAttribute('data-input-id', inputName.id);
            inputChange.removeAttribute('disabled');
            inputChange.value = inputName.value;

            selectList.classList.remove('hide');
            selectList.setAttribute('data-input-id', inputType.id);
            selectList.value = $(selectList).find('option[value="'+inputType.value+'"]').length ? inputType.value : '';

            document.getElementById('map_delete_element').removeAttribute('disabled');
            document.getElementById('map_delete_element').setAttribute('data-element-id', this.id);
            inputChange.focus();
        }
        return false;
    };

//    for (var a = document.getElementsByClassName('map-marker'), l = a.length, i = 0; i < l; i++) {
//        a[i].onclick = document.addMarkerOnClick;
//    }
    $('.map-marker').on('click.marker', document.addMarkerOnClick);
})(jQuery);;