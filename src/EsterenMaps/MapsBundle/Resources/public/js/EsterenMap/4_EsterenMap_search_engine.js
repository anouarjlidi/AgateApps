(function($, L, d, w) {

    EsterenMap.prototype.initSearch = function(){
        var control, _this = this;

        control = L.control.search({}, this);

        this._searchControl = control;

        control.addTo(this._map);

        control.setEvents();

        return this;
    };

    L.Control.Search = L.Control.extend({
        options: {
            position: 'topleft'
        },

        _esterenMap: null,
        _controlDiv: null,
        _controlContent: null,
        _controlLink: null,

        _cntSet: false,

        _selectedElement: null,

        initialize: function (options, map) {
            // Constructeur
            if (!(map instanceof EsterenMap)) {
                console.error('An "EsterenMap" is required to initialize search control.');
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
                    console.error('You can only set an "EsterenMap" as map for search control.');
                    return false;
                }
                this._esterenMap = map;
                return this;
            }
            return this._esterenMap;
        },

        highlightElement: function(){
            var path = this._steps,
                map = this._esterenMap,
                i, l, step, marker, route;

            // TODO: refactor this function

            /*
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
            */
        },

        /**
         * Should disable selection for the selected element.
         */
        cleanSearch: function(){
            var path = this._steps,
                map = this._esterenMap,
                markers = map._markers,
                routes = map._polylines,
                i, l, step, marker, route;

            // TODO: refactor this function

            /*
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
            */
            this._steps = [];
        },

        /**
         * Initializes the content of the control container,
         * and also all the callbacks and events.
         *
         * @returns {*}
         */
        createContent: function(){
            var map = this._esterenMap, _this = this, message = '';

            if (this._cntSet) {
                console.error('Content has already been set for this direction panel.');
                return false;
            }

            var content,
                msgSend = typeof FORM_SUBMIT !== 'undefined' ? FORM_SUBMIT : 'Envoyer',
                searchMsgTitle = typeof MSG_CONTROL_SEARCH_TITLE !== 'undefined' ? MSG_CONTROL_SEARCH_TITLE : 'Rechercher un élément sur la carte',
                searchMsgPlaceholder = typeof MSG_CONTROL_SEARCH_PLACEHOLDER !== 'undefined' ? MSG_CONTROL_SEARCH_PLACEHOLDER : 'Rechercher',
                searchMsgNotFound = typeof MSG_CONTROL_SEARCH_NOT_FOUND !== 'undefined' ? MSG_CONTROL_SEARCH_NOT_FOUND : 'Aucun élément trouvé.'
            ;

            // Ajout des différents noeuds à l'objet Content
            // On persiste ici à utiliser le concept objet
            // pour être sûr que des listeners ne sont pas "perdus" en route

            content =
            '<div>' +
                '<div id="search_wait_overlay"></div>' +
                '<form action="#" id="search_form" class="form-horizontal">' +
                    '<div class="form-group">' +
                        '<div class="col-xs-12">' +
                            '<label for="">' + searchMsgTitle + '</label>' +
                            '<input type="text" name="search_query" id="search_query" placeholder="' + searchMsgPlaceholder + '" class="form-control" />' +
                            '<div class="search_helper"></div>' +
                        '</div>' +
                    '</div>' +
                    '<button class="btn btn-default" type="submit">' + msgSend + '</button>' +
                    '<div id="search_message"></div>' +
                '</div>' +
                '</form>' +
            '</div>'
            ;

            // Reset the element
            $(this._controlContent).html('').append(content);

            /**
             * When clicking an element from the generated list, the input gets its value
             */
            $(this._controlContent).find('.directions_helper').on('click', function(e){
                var input, li = e.target, type = '', id = '';
                if (li.tagName.toLowerCase() === 'li') {

                    if (li.hasAttribute('data-polygon-id')) {
                        type = 'polygon';
                        id = li.getAttribute('data-polygon-id');
                    } else if (li.hasAttribute('data-polyline-id')) {
                        type = 'polyline';
                        id = li.getAttribute('data-polyline-id');
                    } else if (li.hasAttribute('data-marker-id')) {
                        type = 'marker';
                        id = li.getAttribute('data-marker-id');
                    }

                    input = li.parentElement.parentElement.previousElementSibling;
                    input.value = li.innerHTML;
                    input.setAttribute('data-element-type', type);
                    input.setAttribute('data-element-id', id);

                    li.parentElement.innerHTML = '';
                }
            });

            /**
             * When "keyup" fires in the input, we show a list of matching datas.
             * The engine works simply with a regexp.
             * @todo Check if we perform something else than a regexp.
             */
            $(this._controlContent).find('#search_query').on('keyup', function(event){
                var $this = $(this),
                    html = '',
                    marker, polyline, polygon, route, zone,
                    search_query = $this.val().trim(),
                    searchRegexp = new RegExp(search_query, 'gi')
                ;
                if (search_query && search_query.length) {
                    // Search in markers
                    for (marker in map._markers) {
                        if (map._markers.hasOwnProperty(marker)) {
                            marker = map._markers[marker]._esterenMarker;
                            if (marker.name.match(searchRegexp)) {
                                html += '<li data-marker-id="'+marker.id+'">'+marker.name+'</li>';
                            }
                        }
                    }
                    // Search in routes
                    for (polyline in map._polylines) {
                        if (map._polylines.hasOwnProperty(polyline)) {
                            route = map._polylines[polyline]._esterenRoute;
                            if (route.name.match(searchRegexp)) {
                                html += '<li data-polyline-id="'+route.id+'">'+route.name+'</li>';
                            }
                        }
                    }
                    // Search in zones
                    for (polygon in map._polygons) {
                        if (map._polygons.hasOwnProperty(polygon)) {
                            zone = map._polygons[polygon]._esterenZone;
                            if (zone.name.match(searchRegexp)) {
                                html += '<li data-polygon-id="'+zone.id+'">'+zone.name+'</li>';
                            }
                        }
                    }
                }

                // Add the elements
                if (html) {
                    html = '<ul class="list-unstyled">'+html+'</ul>';
                }

                $this.next('.search_helper').html(html);
                event.preventDefault();
                return false;
            });

            /**
             * When submitting the form we need to show the element.
             */
            $(this._controlContent).find('#search_form').on('submit', function(e){
                var datas = $(this).serializeArray(),
                    control = map._searchControl,
                    submitButton = this.querySelector('[type="submit"]'),
                    messageBox = d.getElementById('search_message'),
                    element = null,
                    search_query = datas.filter(function(e){return e.name==='search_query';})[0].value, // Gets the query
                    searchRegexp = new RegExp(search_query, 'gi'),
                    type, id
                ;

                type = this.getAttribute('data-element-type');
                id = this.getAttribute('data-element-id');

                control.cleanSearch();

                if (search_query && search_query.length) {
                    if (type === 'marker') {
                        if (id) {
                            element = map._markers[id];
                        } else {
                            $.each(map._markers, function(i, marker) {
                                if (marker._esterenMarker.name.match(searchRegexp)) {
                                    element = marker;
                                    return false;
                                }
                            });
                        }
                    } else if (type === 'polyline') {
                        if (id) {
                            element = map._polylines[id];
                        } else {
                            $.each(map._polylines, function(i, polyline) {
                                if (polyline._esterenRoute.name.match(searchRegexp)) {
                                    element = polyline;
                                    return false;
                                }
                            });
                        }
                    } else if (type === 'polygon') {
                        if (id) {
                            element = map._polygons[id];
                        } else {
                            $.each(map._polygons, function(i, polygon) {
                                if (polygon._esterenZone.name.match(searchRegexp)) {
                                    element = polygon;
                                    return false;
                                }
                            });
                        }
                    }
                }

                if (!element) {
                    message = '';
                    messageBox.innerHTML = searchMsgNotFound;
                }

                // TODO: Focus on element

                return false;
            });

            this._cntSet= true;

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
                console.error('Search control can only be added to a LeafletMap with an EsterenMap. Have you forgotten the second argument to the constructor ?');
                return false;
            }

            textTitle = (typeof(MSG_CONTROL_SEARCH_TITLE) !== 'undefined') ? MSG_CONTROL_SEARCH_TITLE : 'Calcul d\'itinéraire';

            controlDiv = L.DomUtil.create('div', 'leaflet-draw-section leaflet-search-control');
            controlDiv.id = "leaflet-search-control";

            controlContent = L.DomUtil.create('div', 'leaflet-search-control-content', controlDiv);
            controlContent.id = 'search_control_content';

            link = L.DomUtil.create('a', '', controlDiv);
            link.id = 'leaflet-search-toggle';
            link.style.backgroundImage = 'none';
            link.href = "#";
            link.innerHTML = '<i class="fa fa-search" style="font-size: 16px;"></i>';
            link.title = textTitle;
            $(link).tooltip({
                "placement" : "right",
                "container": "body"
            });

            // Listener SearchControl
            L.DomEvent
                .addListener(link, 'click', function () {
                    _this.toggle();

                    return false;
                })
                .addListener(link, 'click', L.DomEvent.stopPropagation)
            ;

            // Listeners SearchControl disable
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
     * @returns {L.Control.Search}
     */
    L.control.search = function (options, map) {
        return new L.Control.Search(options, map);
    };

})(jQuery, L, document, window);
