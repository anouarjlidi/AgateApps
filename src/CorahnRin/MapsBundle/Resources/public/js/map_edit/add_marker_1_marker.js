(function($){
    var mapAddMarker = document.getElementById('map_add_marker');
    var mapContainerId = mapAddMarker.getAttribute('data-map-container') ? mapAddMarker.getAttribute('data-map-container') : 'map_container';
    document.addMarkerPinDraggableObject = {
        start: function(e,ui){
            document.addMarkerMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var x = parseInt(e.clientX - document.addMarkerMapContainerOffset.left + window.pageXOffset);
            var y = parseInt(e.clientY - document.addMarkerMapContainerOffset.top + window.pageYOffset);
            var offsets = {};
            document.addMarkerMovingPinIndex = $('[data-target-polyline="'+ui.helper.attr('data-target-polyline')+'"]').index(this);
            document.addMarkerPolyline = document.getElementById(ui.helper.attr('data-target-polyline'));
            document.addMarkerCoordinates = document.addMarkerPolyline.getAttribute('points').split(' ');
            offsets.left = x - document.addMarkerCoordinates[document.addMarkerMovingPinIndex].split(',')[0];
            offsets.top = y - document.addMarkerCoordinates[document.addMarkerMovingPinIndex].split(',')[1];
            document.addMarkerMovingPinOffset = offsets;
        },
        drag: function(e, ui){
            document.addMarkerMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var coord = document.addMarkerCoordinates.concat([]);
            var index = document.addMarkerMovingPinIndex;
            var x = parseInt(e.clientX - document.addMarkerMapContainerOffset.left + window.pageXOffset - document.addMarkerMovingPinOffset.left);
            var y = parseInt(e.clientY - document.addMarkerMapContainerOffset.top + window.pageYOffset - document.addMarkerMovingPinOffset.top);
            coord[index] = x+','+y;
            document.addMarkerPolyline.setAttribute('points', coord.join(' '));
        },
        stop: function(e, ui){
            document.addMarkerMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            $(document.getElementById("input_"+document.addMarkerPolyline.id)).val(document.addMarkerPolyline.getAttribute('points'));
            document.addMarkerMovingPinIndex = null;
            document.addMarkerPolyline = null;
            document.addMarkerCoordinates = null;
            document.addMarkerMovingPinOffset = null;
        }
    };
    $('.map-icon-target').draggable(document.addMarkerPinDraggableObject);
})(jQuery);