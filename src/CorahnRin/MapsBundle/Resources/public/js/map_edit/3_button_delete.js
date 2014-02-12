document.getElementById('map_delete_element').onclick = function(e){
    var dataElementId = this.getAttribute('data-element-id');

    if (!dataElementId) {
        // Si aucune cible n'a été définie
        console.error('No input id');
        return false;
    }

    if (dataElementId.match('_polygon')) {
        document.getElementById(dataElementId).parentNode.removeChild(document.getElementById(dataElementId));
        var list = document.querySelectorAll('.map-icon-target[data-target-element="'+dataElementId+'"],input[id="input_'+dataElementId+'"],input[id="input_'+dataElementId.replace('_polygon','_name')+'"]'),
            len = list.length;

        for (var i = 0; i < len; i++) {
            list[i].parentNode.removeChild(list[i]);
        }

        this.setAttribute('disabled','disabled');
        var inputChange = document.getElementById('map_input_change');
        inputChange.setAttribute('data-input-id', '');
        inputChange.setAttribute('disabled','disabled');
        inputChange.value = '';
    } else if (dataElementId.match('_polyline')) {
        document.getElementById(dataElementId).parentNode.removeChild(document.getElementById(dataElementId));
        var list = document.querySelectorAll(
                '.map-icon-target[data-target-element="'+dataElementId+'"]'+
                ',input[id="input_'+dataElementId+'"]'+
                ',input[id="input_'+dataElementId.replace('_polyline','_name')+'"]'+
                ',input[id="input_'+dataElementId.replace('_polyline','_type')+'"]'
            ),
            len = list.length;

        for (var i = 0; i < len; i++) {
            list[i].parentNode.removeChild(list[i]);
        }

        this.setAttribute('disabled','disabled');
        var inputChange = document.getElementById('map_input_change');
        inputChange.setAttribute('data-input-id', '');
        inputChange.setAttribute('disabled','disabled');
        inputChange.value = '';
    } else if (dataElementId.match('_marker')) {
        document.getElementById(dataElementId).parentNode.removeChild(document.getElementById(dataElementId));
        var list = document.querySelectorAll(
                '.map-icon-target[data-target-element="'+dataElementId+'"]'+
                ',input[id="input_'+dataElementId.replace('_marker','_marker_coords')+'"]'+
                ',input[id="input_'+dataElementId.replace('_marker','_marker_name')+'"]'+
                ',input[id="input_'+dataElementId.replace('_marker','_marker_type')+'"]'
            ),
            len = list.length;

        for (var i = 0; i < len; i++) {
            list[i].parentNode.removeChild(list[i]);
        }

        this.setAttribute('disabled','disabled');
        var inputChange = document.getElementById('map_input_change');
        inputChange.setAttribute('data-input-id', '');
        inputChange.setAttribute('disabled','disabled');
        inputChange.value = '';
    }

    return false;
};