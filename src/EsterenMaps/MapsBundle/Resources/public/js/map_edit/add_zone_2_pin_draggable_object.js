(function($){
    var mapContainerId = 'map_container';
    document.addZonePinDraggableObject = {
        start: function(e,ui){
            document.addZoneMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var x = parseInt(e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset);
            var y = parseInt(e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset);
            var offsets = {};
            document.addZoneMovingPinIndex = $('[data-target-element="'+ui.helper.attr('data-target-element')+'"]').index(this);
            document.addZonePolygon = document.getElementById(ui.helper.attr('data-target-element'));
            document.addZoneCoordinates = document.addZonePolygon.getAttribute('points').split(' ');
            offsets.left = x - document.addZoneCoordinates[document.addZoneMovingPinIndex].split(',')[0];
            offsets.top = y - document.addZoneCoordinates[document.addZoneMovingPinIndex].split(',')[1];
            document.addZoneMovingPinOffset = offsets;
        },
        drag: function(e, ui){
            document.addZoneMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            var coord = document.addZoneCoordinates.concat([]);
            var index = document.addZoneMovingPinIndex;
            var x = parseInt(e.clientX - document.addZoneMapContainerOffset.left + window.pageXOffset - document.addZoneMovingPinOffset.left);
            var y = parseInt(e.clientY - document.addZoneMapContainerOffset.top + window.pageYOffset - document.addZoneMovingPinOffset.top);
            coord[index] = x+','+y;
            document.addZonePolygon.setAttribute('points', coord.join(' '));
        },
        stop: function(e, ui){
            document.addZoneMapContainerOffset = $('#'+mapContainerId).offset();
            ui.helper.css('position','absolute');
            $(document.getElementById("input_"+document.addZonePolygon.id)).val(document.addZonePolygon.getAttribute('points'));
            document.addZoneMovingPinIndex = null;
            document.addZonePolygon = null;
            document.addZoneCoordinates = null;
            document.addZoneMovingPinOffset = null;
        }
    };
    $('.map-icon-target').draggable(document.addZonePinDraggableObject);
})(jQuery);