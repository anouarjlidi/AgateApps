(function($){
    $('#map_container').bind('click.mapedit', function(e){
        var t=e.target;

        if (this.getAttribute('data-add-element') === 'true'
            || document.getElementById('map_add_zone').classList.contains('active')
            || document.getElementById('map_add_route').classList.contains('active')
            || document.getElementById('map_add_marker').classList.contains('active')
            || document.addElementEditMode
            ) {
            // Aucun effet si on est en mode édition
            console.info('not able to click');
            return false;
        }

        if(t.classList.contains('map-icon-target') && t.getAttribute('data-target-element')){
            $(document.getElementById(t.getAttribute('data-target-element'))).trigger('click');
            return false;
        }

        if (
            !$(e.target).is('polygon') &&
            !$(e.target).is('polyline') &&
            !e.target.classList.contains('map-icon-target') &&
            !e.target.classList.contains('map-marker')
        ) {
            // Suppression de la classe "active" des polygones
            var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polygon'), len = list.length;
            for (var i = 0; i < len; i++){ list[i].classList.remove('active'); }

            // Suppression de la classe "active" des polylines
            var list = document.getElementsByTagNameNS('http://www.w3.org/2000/svg', 'polyline'), len = list.length;
            for (var i = 0; i < len; i++){ list[i].classList.remove('active'); }

            // Suppression de la classe "active" des marqueurs
            var list = document.getElementsByClassName('map-marker'), len = list.length;
            for (var i = 0; i < len; i++){ list[i].classList.remove('active'); }

            document.getElementById('map_delete_element').setAttribute('disabled','disabled');
            document.getElementById('map_delete_element').setAttribute('data-element-id', '');

            // Reset de l'input et de son attribut data utilisé pour la mise à jour des titres
            var inputChange = document.getElementById('map_input_change');
            inputChange.setAttribute('data-input-id', '');
            inputChange.setAttribute('disabled','disabled');
            inputChange.value = '';
            inputChange.blur();

            var selectRouteType = document.getElementById('map_select_route_type');
            selectRouteType.value = '';
            selectRouteType.setAttribute('data-input-id','');
            selectRouteType.classList.add('hide');

            var selectMarkerType = document.getElementById('map_select_marker_type');
            selectMarkerType.value = '';
            selectMarkerType.setAttribute('data-input-id','');
            selectMarkerType.classList.add('hide');
        }
    });
})(jQuery);