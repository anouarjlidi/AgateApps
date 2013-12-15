document.getElementById('map_delete_element').onclick = function(e){
    var dataElementId = this.getAttribute('data-element-id');

    if (!dataElementId) {
        // Si aucune cible n'a été définie
        console.error('No input id');
        return false;
    }
    document.getElementById(dataElementId).parentNode.removeChild(document.getElementById(dataElementId));
    var list = document.querySelectorAll('.map-icon-target[data-target-polygon="'+dataElementId+'"],input[id="input_'+dataElementId+'"],input[id="input_'+dataElementId.replace('_polygon','_name')+'"]'),
        len = list.length;

    for (var i = 0; i < len; i++) {
        list[i].parentNode.removeChild(list[i]);
    }

    this.setAttribute('disabled','disabled');
    var inputChange = document.getElementById('map_add_zone_input_change');
    inputChange.setAttribute('data-input-id', '');
    inputChange.setAttribute('disabled','disabled');
    inputChange.value = '';

    return false;
};