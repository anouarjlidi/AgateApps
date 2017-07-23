(function($, L, d, w) {

    EsterenMap.prototype.initDirections = function(){
        var control, _this = this;

        control = L.control.directions({}, this);

        this._directionsControl = control;

        control.addTo(this._map);

        return this;
    };

    L.Control.Directions = L.Control.extend({
        options: {
            position: 'topleft'
        },

        _pathColor: '#4444dd',

        _esterenMap: null,
        _controlDiv: null,
        _controlContent: null,
        _controlLink: null,
        _steps: [],

        _cntSet: false,
        _lstnSet: false,

        initialize: function (options, map) {
            // Constructeur
            if (!(map instanceof EsterenMap)) {
                console.error('An "EsterenMap" is required to initialize directions control.');
                return false;
            }
            L.setOptions(this, options);
            L.Control.prototype.initialize.call(this, options);
            this.map(map);

            return this;
        },

        map: function(map){
            if (map) {
                if (!(map instanceof EsterenMap)) {
                    console.error('You can only set an "EsterenMap" as map for directions control.');
                    return false;
                }
                this._esterenMap = map;

                return this;
            }

            return this._esterenMap;
        },

        highlightPath: function(){
            var path = this._steps,
                map = this._esterenMap,
                markers = map._markers,
                routes = map._polylines,
                i, l, step, marker, route;
            for (i = 0, l = path.length; i < l; i++) {
                step = path[i];
                marker = markers[step.id];
                route = step.route ? routes[step.route.id] : null;
                marker._icon.classList.add('selected');
                if (route && !route._path.classList.contains('highlighted')) {
                    route._path.setAttribute('stroke-width', parseInt(route._path.getAttribute('stroke-width')) * 2);
                    route._oldColor = route._path.getAttribute('stroke');
                    route._path.setAttribute('stroke', this._pathColor);
                    route._path.classList.add('highlighted');
                }
            }
        },

        cleanDirections: function(){
            var path = this._steps,
                map = this._esterenMap,
                markers = map._markers,
                routes = map._polylines,
                i, l, step, marker, route;
            if (path && path.length) {
                for (i = 0, l = path.length; i < l; i++) {
                    step = path[i];
                    marker = markers[step.id];
                    route = step.route ? routes[step.route.id] : null;
                    marker._icon.classList.remove('selected');
                    if (route && route._path.classList.contains('highlighted')) {
                        route._path.setAttribute('stroke-width', parseInt(route._path.getAttribute('stroke-width')) / 2);
                        route._path.setAttribute('stroke', route._oldColor);
                        route._path.classList.remove('highlighted');
                    }
                }
            }
            this._steps = [];
        },

        createContent: function(){
            var map = this._esterenMap, _this = this, message = '';;

            if (this._cntSet) {
                console.error('Content has already been set for this direction panel.');
                return false;
            }

            var content,
                msgSend = typeof FORM_SUBMIT !== 'undefined' ? FORM_SUBMIT : 'Envoyer',
                directionsMsgTitle = typeof MSG_CONTROL_DIRECTIONS_TITLE !== 'undefined' ? MSG_CONTROL_DIRECTIONS_TITLE : 'Calculer un itinéraire',
                directionsMsgStart = typeof MSG_CONTROL_DIRECTIONS_START !== 'undefined' ? MSG_CONTROL_DIRECTIONS_START : 'Départ',
                directionsMsgEnd = typeof MSG_CONTROL_DIRECTIONS_END !== 'undefined' ? MSG_CONTROL_DIRECTIONS_END : 'Arrivée',
                directionsMsgTransport = typeof MSG_CONTROL_TRANSPORTS !== 'undefined' ? MSG_CONTROL_TRANSPORTS : 'Moyen de transport',
                directionsMsgNotFound = typeof MSG_CONTROL_DIRECTIONS_MARKER_NOT_FOUND !== 'undefined' ? MSG_CONTROL_DIRECTIONS_MARKER_NOT_FOUND : 'Marqueur(s) non trouvé(s) :'
            ;

            // Ajout des différents noeuds à l'objet Content
            // On persiste ici à utiliser le concept objet
            // pour être sûr que des listeners ne sont pas "perdus" en route

            content =
            '<div>' +
                '<div id="directions_wait_overlay"></div>' +
                '<h3>' + directionsMsgTitle + '</h3>' +
                '<form action="#" id="directions_form" class="form-horizontal">' +
                    '<div class="form-group">' +
                        '<label for="directions_start" class="col-xs-3 control-label">' + directionsMsgStart + '</label>' +
                        '<div class="col-xs-9">' +
                            '<input type="text" name="start" id="directions_start" placeholder="' + directionsMsgStart + '" class="form-control" />' +
                            '<div class="directions_helper"></div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="directions_end" class="col-xs-3 control-label">' + directionsMsgEnd + '</label>' +
                        '<div class="col-xs-9">' +
                            '<input type="text" name="end" id="directions_end" placeholder="' + directionsMsgEnd + '" class="form-control" />' +
                            '<div class="directions_helper"></div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="transport" class="col-xs-3 control-label">' + directionsMsgTransport + '</label>' +
                        '<div class="col-xs-9">' +
                            '<select name="directions_transport" id="directions_transport" class="form-control"></select>' +
                            '<div class="directions_helper"></div>' +
                        '</div>' +
                    '</div>' +
                    '<button class="btn btn-default" type="submit">' + msgSend + '</button>' +
                    '<div id="directions_message"></div>' +
                '</div>' +
                '</form>' +
            '</div>'
            ;

            $(this._controlContent).html('').append(content);
            $(this._controlContent).find('.directions_helper').on('click', function(e){
                var input, li = e.target;
                if (li.tagName.toLowerCase() === 'li') {
                    input = li.parentElement.parentElement.previousElementSibling;
                    input.value = li.innerHTML;
                    li.parentElement.innerHTML = '';
                }
            });

            var transportsOptions = '';
            $.each(map._mapOptions.data.references.transports, function(i, e){
                transportsOptions += '<option value="' + e.id + '">' + e.name + '</option>';
            });
            $(_this._controlContent).find('#directions_transport').html(transportsOptions);

            $(this._controlContent).find('#directions_start,#directions_end').on('keypress', function(event){
                var $this = $(this),
                    html = '',
                    value = $this.val().trim(),
                    keyCode = event.keyCode ? event.keyCode : event.which,
                    directionsHelper = $this.next('.directions_helper'),
                    marker;

                // If user entered a value, we create a list based on all markers.
                // We are matching markers only with a regexp.
                // Regexp curious users will be pleased to test this themselves... :D
                if (value) {
                    for (marker in map._markers) {
                        if (map._markers.hasOwnProperty(marker)) {
                            marker = map._markers[marker]._esterenMarker;
                            if (marker.name.match(new RegExp(value, 'gi'))) {
                                html += '<li data-marker-id="'+marker.id+'">'+marker.name+'</li>';
                            }
                        }
                    }
                }

                // And finally add the list to the directions helper.
                if (html) {
                    html = '<ul class="list-unstyled">'+html+'</ul>';
                }
                directionsHelper.html(html);

                // If pressed "enter", we click on the first element.
                if (keyCode == 13) {
                    directionsHelper.find('ul > li').first().click();

                    // Avoid submitting the form at the same time, most of the time it triggers errors.
                    event.preventDefault();
                    return false;
                }
            });
            $(this._controlContent).find('#directions_form').on('submit', function(e){
                var data = $(this).serializeArray(),
                    markers = map._markers,
                    control = map._directionsControl,
                    submitButton = this.querySelector('[type="submit"]'),
                    messageBox = d.getElementById('directions_message'),
                    markerStart, markerEnd,
                    start = data.filter(function(e){return e.name==='start';})[0].value,
                    end = data.filter(function(e){return e.name==='end';})[0].value,
                    transport = data.filter(function(e){return e.name==='directions_transport';})[0].value
                ;
                if (submitButton.hasAttribute('disabled')) {
                    return false;
                }
                submitButton.setAttribute('disabled', 'disabled');
                control.cleanDirections();
                for (var marker in markers) {
                    if (markers.hasOwnProperty(marker)) {
                        marker = markers[marker]._esterenMarker;
                        if (!markerStart && marker.name === start) {
                            markerStart = marker.id;
                        }
                        if (!markerEnd && marker.name === end) {
                            markerEnd = marker.id;
                        }
                        if (markerStart && markerEnd) {
                            break;
                        }
                    }
                }
                if (markerStart && markerEnd) {
                    d.getElementById('directions_wait_overlay').style.display = "block";
                    map._load({
                        url: 'maps/directions/'+map._mapOptions.id+'/'+markerStart+'/'+markerEnd,
                        xhr_name: 'directions_calculate',
                        data: {
                            'transport': transport
                        },
                        callback: function(response) {
                            if (response.error && response.message) {
                                messageBox.innerHTML = response.message;
                                setTimeout(function(){$('#directions_message').text('');}, 3000);
                            } else if (response.path && response.path.length) {
                                control._steps = response.path;
                                control.highlightPath();
                                map._map.fitBounds(L.latLngBounds(response.bounds.northEast, response.bounds.southWest));
                                messageBox.innerHTML = response.path_view;
                            } else if (response.path_view) {
                                messageBox.innerHTML = response.path_view;
                            }
                        },
                        callbackComplete: function() {
                            submitButton.removeAttribute('disabled');
                        },
                        callbackError: function() {
                            submitButton.removeAttribute('disabled');
                        }
                    });
                } else if (markerStart || markerEnd || start || end) {
                    // If pressed "enter", we click on the first element.
                    if (keyCode == 13) {
                        directionsHelper.find('ul > li').first().click();

                        // Avoid submitting the form at the same time, most of the time it triggers errors.
                        event.preventDefault();
                    }

                    message = '';
                    if (!markerStart && start) {
                        message += start;
                    }
                    if (!markerEnd && end) {
                        message += (message?', ':'') + end;
                    }
                    messageBox.innerHTML = directionsMsgNotFound + ' ' + message;
                }
                return false;
            });

            this._cntSet = true;

            return this;
        },

        show: function(){
            this._controlContent.style.display = 'block';
            this._controlContent.parentElement.classList.add('expanded');
        },

        hide: function(){
            this._controlContent.style.display = 'none';
            this._controlContent.parentElement.classList.remove('expanded');
        },

        toggle: function(){
            var controlContent = this._controlContent;
            if ($(controlContent).is(':visible')) {
                this.hide();
            } else {
                this.show();
            }
        },

        onAdd: function () {
            var controlDiv, link, textTitle, controlContent, _this = this;

            if (!(this._esterenMap instanceof EsterenMap)) {
                console.error('Directions control can only be added to a LeafletMap with an EsterenMap. Have you forgotten the second argument to the constructor ?');
                return false;
            }

            textTitle = (typeof(MSG_CONTROL_DIRECTIONS_TITLE) !== 'undefined') ? MSG_CONTROL_DIRECTIONS_TITLE : 'Calcul d\'itinéraire';

            controlDiv = L.DomUtil.create('div', 'leaflet-draw-section leaflet-directions-control');
            controlDiv.id = "leaflet-directions-control";

            controlContent = L.DomUtil.create('div', 'leaflet-directions-control-content', controlDiv);
            controlContent.id = 'directions_control_content';

            link = L.DomUtil.create('a', '', controlDiv);
            link.id = 'leaflet-directions-toggle';
            link.style.backgroundImage = 'none';
            link.href = "#";
            link.innerHTML = '<i class="fa fa-location-arrow" style="font-size: 16px;"></i>';
            link.title = textTitle;
            $(link).tooltip({
                "placement" : "right",
                "container": "body"
            });

            // Listener DirectionsControl
            L.DomEvent
                .addListener(link, 'click', function () {
                    _this.toggle();

                    return false;
                })
                .addListener(link, 'click', L.DomEvent.stopPropagation)
            ;

            // Listeners DirectionsControl disable
            this._esterenMap._map.on('click', function(){
                _this.hide();
            });

            this._controlDiv = controlDiv;
            this._controlLink = link;
            this._controlContent = controlContent;

            this.createContent();

            L.DomEvent
                .on(this._controlDiv, 'click', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'mousedown', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'touchstart', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'dblclick', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'mousewheel', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'MozMousePixelScroll', L.DomEvent.stopPropagation);

            return controlDiv;
        }
    });

    /**
     * @param {object} options
     * @param {EsterenMap} map
     * @returns {L.Control.Directions}
     */
    L.control.directions = function (options, map) {
        return new L.Control.Directions(options, map);
    };

})(jQuery, L, document, window);
