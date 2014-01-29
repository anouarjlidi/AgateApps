(function($){
    var mapAddRoute = document.getElementById('map_add_route');
    var mapContainerId = mapAddRoute.getAttribute('data-map-container') ? mapAddRoute.getAttribute('data-map-container') : 'map_container';
    document.addRoutePinDraggableObject = {
        start: function(e,ui){
            document.addRouteMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var x = parseInt(e.clientX - document.addRouteMapContainerOffset.left + window.pageXOffset);
            var y = parseInt(e.clientY - document.addRouteMapContainerOffset.top + window.pageYOffset);
            var offsets = {};
            document.addRouteMovingPinIndex = $('[data-target-polyline="'+ui.helper.attr('data-target-polyline')+'"]').index(this);
            document.addRoutePolyline = document.getElementById(ui.helper.attr('data-target-polyline'));
            document.addRouteCoordinates = document.addRoutePolyline.getAttribute('points').split(' ');
            offsets.left = x - document.addRouteCoordinates[document.addRouteMovingPinIndex].split(',')[0];
            offsets.top = y - document.addRouteCoordinates[document.addRouteMovingPinIndex].split(',')[1];
            document.addRouteMovingPinOffset = offsets;
        },
        drag: function(e, ui){
            document.addRouteMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var coord = document.addRouteCoordinates.concat([]);
            var index = document.addRouteMovingPinIndex;
            var x = parseInt(e.clientX - document.addRouteMapContainerOffset.left + window.pageXOffset - document.addRouteMovingPinOffset.left);
            var y = parseInt(e.clientY - document.addRouteMapContainerOffset.top + window.pageYOffset - document.addRouteMovingPinOffset.top);
            coord[index] = x+','+y;
            document.addRoutePolyline.setAttribute('points', coord.join(' '));
        },
        stop: function(e, ui){
            document.addRouteMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            $(document.getElementById("input_"+document.addRoutePolyline.id)).val(document.addRoutePolyline.getAttribute('points'));
            document.addRouteMovingPinIndex = null;
            document.addRoutePolyline = null;
            document.addRouteCoordinates = null;
            document.addRouteMovingPinOffset = null;
        }
    };
    $('.map-icon-target').draggable(document.addRoutePinDraggableObject);
})(jQuery);