(function($){
    document.addMarkerPinDraggableObject = {
        start: function(e,ui) {
            var pin = ui.helper,
                starts = pin.attr('data-routes-start') ? pin.attr('data-routes-start').split(',').map(function(e){return isNaN(parseInt(e)) ? undefined : parseInt(e);}) : [],
                ends = pin.attr('data-routes-end') ? pin.attr('data-routes-end').split(',').map(function(e){return isNaN(parseInt(e)) ? undefined : parseInt(e);}) : [];

            var coords = {"starts":[],"ends":[]};
            for (var i = 0, l = starts.length ; i < l ; i++) {
                if (document.getElementById('input_map_add_route_polyline['+starts[i]+']')) {
                    coords.starts.push({
                    "id": starts[i],
                    "input" : document.getElementById('input_map_add_route_polyline['+starts[i]+']'),
                    "svg" : document.getElementById('map_add_route_polyline['+starts[i]+']'),
                    "coords" : document.getElementById('input_map_add_route_polyline['+starts[i]+']').value.split(' ')
                    });
                }
            }
            for (var i = 0, l = ends.length ; i < l ; i++) {
                if (document.getElementById('input_map_add_route_polyline['+ends[i]+']')) {
                    coords.ends.push({
                    "id": ends[i],
                    "input" : document.getElementById('input_map_add_route_polyline['+ends[i]+']'),
                    "svg" : document.getElementById('map_add_route_polyline['+ends[i]+']'),
                    "coords" : document.getElementById('input_map_add_route_polyline['+ends[i]+']').value.split(' '),
                    "coords_length" : document.getElementById('input_map_add_route_polyline['+ends[i]+']').value.split(' ').length
                    });
                }
            }
            document.addPinDraggingRouteCoords = coords;
        },
        drag: function(e,ui){
            var pin = ui.helper,
                starts = document.addPinDraggingRouteCoords.starts,
                ends = document.addPinDraggingRouteCoords.ends,
                pos = pin.position().left + ',' + pin.position().top;
            if (starts) {
                for (var i = 0, l = starts.length ; i < l ; i++) {
                    starts[i].coords[0] = pos;
                    starts[i].input.value = starts[i].coords.join(' ');
                    starts[i].svg.setAttribute('points', starts[i].coords.join(' '));
                }
            }
            if (ends) {
                for (var i = 0, l = ends.length ; i < l ; i++) {
                    ends[i].coords[ends[i].coords_length - 1] = pos;
                    ends[i].input.value = ends[i].coords.join(' ');
                    ends[i].svg.setAttribute('points', ends[i].coords.join(' '));
                }
            }
        },
        stop: function(e, ui){
            var pin = ui.helper,
                id = "input_"+pin.attr('id').replace('_marker','_marker_coords'),
                starts = document.addPinDraggingRouteCoords.starts,
                ends = document.addPinDraggingRouteCoords.ends,
                pos = pin.position().left + ',' + pin.position().top;
            document.getElementById(id).value = pos;
            if (starts) {
                for (var i = 0, l = starts.length ; i < l ; i++) {
                    starts[i].coords[0] = pos;
                    starts[i].input.value = starts[i].coords.join(' ');
                    starts[i].svg.setAttribute('points', starts[i].coords.join(' '));
                }
            }
            if (ends) {
                for (var i = 0, l = ends.length ; i < l ; i++) {
                    ends[i].coords[ends[i].coords_length - 1] = pos;
                    ends[i].input.value = ends[i].coords.join(' ');
                    ends[i].svg.setAttribute('points', ends[i].coords.join(' '));
                }
            }
            document.addPinDraggingRouteCoords = [];
        }
    };
    $('.map-marker').draggable(document.addMarkerPinDraggableObject);
})(jQuery);