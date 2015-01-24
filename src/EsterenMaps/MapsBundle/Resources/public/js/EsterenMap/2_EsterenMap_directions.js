(function($, L, d, w) {

    EsterenMap.prototype.initDirections = function(){
        var control, _this = this;

        control = L.control.directions({}, this);

        this._directionsControl = control;

        this.loadRefDatas(function(){
            control.addTo(this._map);
        });

        control.setEvents();

        return this;
    };

    L.Control.Directions = L.Control.extend({
        options: {
            position: 'topleft'
        },

        _esterenMap: null,
        _controlDiv: null,
        _controlContent: null,
        _controlLink: null,

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

        setEvents: function(){
            var map = this._esterenMap;
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

        createContent: function(){
            var map = this._esterenMap;

            if (this._cntSet) {
                console.error('Content has already been set for this direction panel.');
                return false;
            }

            var content,
                msgSend = typeof FORM_SUBMIT !== 'undefined' ? FORM_SUBMIT : 'Envoyer',
                directionsMsgTitle = typeof MSG_CONTROL_DIRECTIONS_TITLE !== 'undefined' ? MSG_CONTROL_DIRECTIONS_TITLE : 'Calculer un itinéraire',
                directionsMsgStart = typeof MSG_CONTROL_DIRECTIONS_START !== 'undefined' ? MSG_CONTROL_DIRECTIONS_START : 'Départ',
                directionsMsgEnd = typeof MSG_CONTROL_DIRECTIONS_END !== 'undefined' ? MSG_CONTROL_DIRECTIONS_END : 'Arrivée'
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
                        '<label for="directions_start" class="col-sm-3 control-label">' + directionsMsgStart + '</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" name="start" id="directions_start" placeholder="' + directionsMsgStart + '" class="form-control" />' +
                            '<div class="directions_helper"></div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="directions_end" class="col-sm-3 control-label">' + directionsMsgEnd + '</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" name="end" id="directions_end" placeholder="' + directionsMsgEnd + '" class="form-control" />' +
                            '<div class="directions_helper"></div>' +
                        '</div>' +
                    '</div>' +
                    '<button class="btn btn-default" type="submit">' + msgSend + '</button>' +
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
            $(this._controlContent).find('#directions_start,#directions_end').on('keyup', function(){
                var $this = $(this),
                    html = '', marker,
                    value = $this.val().trim();
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
                if (html) {
                    html = '<ul class="list-unstyled">'+html+'</ul>';
                }
                $this.next('.directions_helper').html(html);
            });
            $(this._controlContent).find('#directions_form').on('submit', function(e){
                var datas = $(this).serializeArray(),
                    markers = map._markers,
                    markerStart, markerEnd,
                    start = datas.filter(function(e){return e.name==='start';})[0].value,
                    end = datas.filter(function(e){return e.name==='end';})[0].value
                ;
                for (marker in markers) {
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
                    console.info('start', markerStart);
                    console.info('end', markerEnd);
                    map._load({
                        uri:"maps/directions/1/7/52",
                        callback: function(response) {
                            if (response.error && response.message) {
                                alert(response.message);
                            } else {
                                //TODO
                            }
                        }
                    });
                }
                e.preventDefault();
                e.stopPropagation();
                return false;
            });

            this._cntSet= true;

            return this;
        },

        show: function(){
            $(this._controlContent).stop().slideDown(400);
        },

        hide: function(){
            $(this._controlContent).stop().slideUp(400);
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
                console.error('Fitlers control can only be added to a LeafletMap with an EsterenMap. Have you forgotten the second argument to the constructor ?');
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
            link.innerHTML = '<span class="glyphicon icon-direction"></span>';
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