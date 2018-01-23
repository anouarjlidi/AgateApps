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

        statics: {
            FORM_ID: 'search_form',
            INPUT_QUERY_ID: 'search_query',
            BUTTON_SUBMIT_ID: 'search_button_submit',
            BOX_MESSAGE_ID: 'search_message',
            DATA_ROUTE_ID: 'route-id',
            DATA_ZONE_ID: 'zone-id',
            DATA_MARKER_ID: 'marker-id'
        },

        _pathColor: '#4444dd',

        /** @var EsterenMap _esterenMap */
        _esterenMap: null,
        _controlDiv: null,
        _controlContent: null,
        _controlLink: null,

        _contentIsSet: false,

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
            this.setEvents();
            return this;
        },

        onAdd: function () {
            var controlDiv, link, textTitle, controlContent, _this = this;

            if (!(this._esterenMap instanceof EsterenMap)) {
                console.error('Search control can only be added to a LeafletMap with an EsterenMap. Have you forgotten the second argument to the constructor ?');
                return false;
            }

            textTitle = (typeof(MSG_CONTROL_SEARCH_TITLE) !== 'undefined') ? MSG_CONTROL_SEARCH_TITLE : 'MSG_CONTROL_SEARCH_TITLE';

            controlDiv = L.DomUtil.create('div', 'leaflet-draw-section leaflet-search-control');
            controlDiv.id = "leaflet-search-control";

            controlContent = L.DomUtil.create('div', 'leaflet-search-control-content', controlDiv);
            controlContent.id = 'search_control_content';

            link = L.DomUtil.create('a', 'map-control-toggle', controlDiv);
            link.id = 'leaflet-search-toggle';
            link.style.backgroundImage = 'none';
            link.href = "#";
            link.innerHTML = '<i class="fa fa-search" style="font-size: 16px;"></i>';
            link.setAttribute('data-tooltip', textTitle);
            $(link).tooltip({
                "delay": 25,
                "position" : "right",
                "html": "true"
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
        },

        message: function(message){
            var messageBox;
            if (this._controlContent && (messageBox = this._controlContent.querySelector('#'+L.Control.Search.BOX_MESSAGE_ID))) {
                messageBox.innerHTML = message;
            }
        },

        setEvents: function(){
            var _control = this,
                searchMsgNotFound = typeof MSG_CONTROL_SEARCH_NOT_FOUND !== 'undefined' ? MSG_CONTROL_SEARCH_NOT_FOUND : 'MSG_CONTROL_SEARCH_NOT_FOUND'
            ;

            /**
             * When "keyup" fires in the input, we show a list of matching data.
             * The engine works simply with a regexp.
             */
            $(this._controlContent).find('#'+L.Control.Search.INPUT_QUERY_ID).on('keyup', function(event){
                var $this = $(this),
                    html = '',
                    results = _control.findByQuery(this.value),
                    i, l
                ;

                // "Enter" key: submit
                if (event.keyCode === 13) {
                    _control.unFocusSelectedElement();
                    d.getElementById(L.Control.Search.BUTTON_SUBMIT_ID).click();
                    event.preventDefault();
                    return false;
                }
                // "Escape" key: reset the form
                if (event.keyCode === 27) {
                    this.value = "";
                    _control.unFocusSelectedElement();
                    $this.parent().find('.search_helper').html('');
                    event.preventDefault();
                    return false;
                }

                // If we have content, let's show it
                if (results.total > 0) {
                    for (i = 0, l = results.markers.length; i < l; i++) {
                        html += '<li data-'+L.Control.Search.DATA_MARKER_ID+'-id="'+results.markers[i]._esterenMarker.id+'">'+results.markers[i]._esterenMarker.name+'</li>';
                    }
                    for (i = 0, l = results.zones.length; i < l; i++) {
                        html += '<li data-'+L.Control.Search.DATA_ZONE_ID+'="'+results.zones[i]._esterenZone.id+'">'+results.zones[i]._esterenZone.name+'</li>';
                    }
                    for (i = 0, l = results.routes.length; i < l; i++) {
                        html += '<li data-'+L.Control.Search.DATA_ROUTE_ID+'="'+results.routes[i]._esterenRoute.id+'">'+results.routes[i]._esterenRoute.name+'</li>';
                    }
                    if (html) {
                        html = '<ul class="list-unstyled">'+html+'</ul>';
                    }
                }

                // Add the elements
                if (html) {
                    html = '<ul class="list-unstyled">'+html+'</ul>';
                }

                $this.parent().find('.search_helper').html(html);
                event.preventDefault();
                return false;
            });

            /**
             * When clicking an element from the generated list,
             *   the input gets its value,
             *   and we submit the form.
             */
            $(this._controlContent).find('.search_helper').on('click', function(event){
                var input, li = event.target, type = '', id = '';
                if (li.tagName.toLowerCase() === 'li') {

                    if (li.hasAttribute('data-'+L.Control.Search.DATA_ZONE_ID)) {
                        type = 'zone';
                        id = li.getAttribute('data-'+L.Control.Search.DATA_ZONE_ID);
                    } else if (li.hasAttribute('data-'+L.Control.Search.DATA_ROUTE_ID)) {
                        type = 'route';
                        id = li.getAttribute('data-'+L.Control.Search.DATA_ROUTE_ID);
                    } else if (li.hasAttribute('data-'+L.Control.Search.DATA_MARKER_ID)) {
                        type = 'marker';
                        id = li.getAttribute('data-'+L.Control.Search.DATA_MARKER_ID);
                    }

                    input = d.getElementById(L.Control.Search.INPUT_QUERY_ID);
                    input.value = li.innerHTML;
                    input.setAttribute('data-element-type', type || '');
                    input.setAttribute('data-element-id', id || '');

                    li.parentElement.innerHTML = '';

                    d.getElementById(L.Control.Search.BUTTON_SUBMIT_ID).click();
                }

                event.preventDefault();
                return false;
            });

            /**
             * When submitting the form we need to show the element.
             */
            $(this._controlContent).find('#'+L.Control.Search.FORM_ID).on('submit', function(event){
                d.getElementById(L.Control.Search.BUTTON_SUBMIT_ID).click();
                event.preventDefault();
                return false;
            });

            /**
             * When clicking the button, it submits the research, and if it finds
             *   an element to highlight, the map focuses on it.
             */
            $(this._controlContent).find('#'+L.Control.Search.BUTTON_SUBMIT_ID).on('touch click', function(event){
                var messageBox = d.getElementById(L.Control.Search.BOX_MESSAGE_ID),
                    element = null,
                    search_query_input = d.getElementById(L.Control.Search.INPUT_QUERY_ID),
                    search_query = search_query_input.value, // Gets the query
                    type, id
                ;

                type = search_query_input.getAttribute('data-element-type');
                id = search_query_input.getAttribute('data-element-id');

                _control.unFocusSelectedElement();

                if (type && id) {
                    element = _control.findOne(type, id);
                } else {
                    element = _control.findOneByQuery(search_query);
                }

                if (!element) {
                    messageBox.innerHTML = searchMsgNotFound;
                } else {
                    messageBox.innerHTML = '';
                    _control.focusElement(element);
                }

                event.preventDefault();
                return false;
            });
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

        focusElement: function(element){
            var map = this._esterenMap._map, path, bounds;

            if (this._selectedElement) {
                this.unFocusSelectedElement();
            }

            if (element._esterenMarker) {
                // Focus on the marker and add class to icon
                element._icon.classList.add('selected');
                map.setView(element.getLatLng(), map.getMaxZoom(), {animate: true});
            } else if (element._esterenRoute || element._esterenZone) {
                path = map.getRenderer(element).getPane();

                if (!path) {
                    throw 'No path was found for this element.';
                }

                // Focus on the route or zone and add class to svg path
                path.classList.add('highlighted');

                path.setAttribute('stroke-width', parseInt(path.getAttribute('stroke-width')) * 2);
                element._oldColor = path.getAttribute('stroke');
                path.setAttribute('stroke', this._pathColor);

                bounds = L.latLngBounds(element.getLatLngs());

                if (!bounds.isValid()) {
                    this.message(typeof MSG_CONTROL_SEARCH_NOT_FOUND !== 'undefined' ? MSG_CONTROL_SEARCH_NOT_FOUND : 'error');

                    return;
                }

                map.fitBounds(bounds, {animate: true});
            } else {
                throw 'No element to focus on.';
            }

            this._selectedElement = element;
        },

        findByQuery: function(search_query) {
            search_query = search_query.trim();

            var searchRegexp = new RegExp(search_query, 'gi'),
                map = this._esterenMap,
                marker, polyline, polygon, bounds,
                results = {
                    total: 0,
                    markers: [],
                    routes: [],
                    zones: []
                };

            if (search_query && search_query.length) {
                // Search in markers
                for (marker in map._markers) {
                    if (map._markers.hasOwnProperty(marker) && map._markers[marker]._esterenMarker.name.match(searchRegexp)) {
                        results.total ++;
                        results.markers.push(map._markers[marker]);
                    }
                }
                // Search in routes
                for (polyline in map._polylines) {
                    if (map._polylines.hasOwnProperty(polyline) && map._polylines[polyline]._esterenRoute.name.match(searchRegexp)) {
                        if (!L.latLngBounds(map._polylines[polyline].getLatLngs()).isValid()) {
                            continue;
                        }
                        results.total ++;
                        results.routes.push(map._polylines[polyline]);
                    }
                }
                // Search in zones
                for (polygon in map._polygons) {
                    if (map._polygons.hasOwnProperty(polygon) && map._polygons[polygon]._esterenZone.name.match(searchRegexp)) {
                        if (!L.latLngBounds(map._polygons[polygon].getLatLngs()).isValid()) {
                            continue;
                        }
                        results.total ++;
                        results.zones.push(map._polygons[polygon]);
                    }
                }
            }

            return results;
        },

        /**
         * Returns the first element found depending on the query.
         * The priority order is markers > zones > routes
         *
         * @param search_query
         * @returns {*}
         */
        findOneByQuery: function(search_query) {

            var results = this.findByQuery(search_query);

            if (results.total > 0) {
                if (results.markers.length > 0) {
                    return results.markers[0];
                }
                if (results.zones.length > 0) {
                    return results.markers[0];
                }
                if (results.routes.length > 0) {
                    return results.markers[0];
                }
            }

            return null;
        },

        /**
         * Search a specific element depending on the type and the id
         *
         * @param type string
         * @param id   integer
         */
        findOne: function(type, id) {

            var collection;

            switch (type.toLowerCase()) {
                case 'marker':
                    collection = this._esterenMap._markers;
                    break;
                case 'zone':
                    collection = this._esterenMap._polygons;
                    break;
                case 'route':
                    collection = this._esterenMap._polylines;
                    break;
                default:
                    console.error('The type "'+type+'" does not exist in the map.');
                    return null;
            }

            if (!collection[id]) {
                console.error('The element of "'+type+'" with id "'+id+'" does not exist in the map.');
                return null;
            }

            return collection[id];
        },

        /**
         * Should disable selection for the selected element.
         */
        unFocusSelectedElement: function(){
            var element = this._selectedElement, path;

            if (!element) {
                return;
            }

            if (element._esterenMarker) {
                // Remove class in icon
                element._icon.classList.remove('selected');
            } else if (element._esterenRoute || element._esterenZone) {
                // Remove class in svg path, and rollback the stroke color
                path = this._map.getRenderer(element).getPane();

                if (!path) {
                    throw 'No path was found for this element.';
                }

                path.setAttribute('stroke-width', parseInt(path.getAttribute('stroke-width')) / 2);
                path.setAttribute('stroke', element._oldColor);
                path.classList.remove('highlighted');
            }
        },

        /**
         * Initializes the content of the control container,
         * and also all the callbacks and events.
         *
         * @returns {*}
         */
        createContent: function(){
            var map = this._esterenMap, _this = this, message = '';

            if (this._contentIsSet) {
                console.error('Content has already been set for this search panel.');
                return false;
            }

            var content,
                msgSend = typeof FORM_SUBMIT !== 'undefined' ? FORM_SUBMIT : 'FORM_SUBMIT',
                searchMsgTitle = typeof MSG_CONTROL_SEARCH_TITLE !== 'undefined' ? MSG_CONTROL_SEARCH_TITLE : 'MSG_CONTROL_SEARCH_TITLE',
                searchMsgPlaceholder = typeof MSG_CONTROL_SEARCH_PLACEHOLDER !== 'undefined' ? MSG_CONTROL_SEARCH_PLACEHOLDER : 'MSG_CONTROL_SEARCH_PLACEHOLDER'
            ;

            // Ajout des différents noeuds à l'objet Content
            // On persiste ici à utiliser le concept objet
            // pour être sûr que des listeners ne sont pas "perdus" en route

            content =
            '<div>' +
                '<div id="maps_search_wait_overlay"></div>' +
                '<form action="#" id="'+L.Control.Search.FORM_ID+'">' +
                    '<h3 class="text-xxl">' + searchMsgTitle + '</h3>' +
                    '<div class="input-field">' +
                        '<input type="text" name="'+L.Control.Search.INPUT_QUERY_ID+'" id="'+L.Control.Search.INPUT_QUERY_ID+'" />' +
                        '<label for="'+L.Control.Search.INPUT_QUERY_ID+'">' + searchMsgPlaceholder + '</label>' +
                        '<div class="search_helper"></div>' +
                    '</div>' +
                    '<div id="'+L.Control.Search.BOX_MESSAGE_ID+'"></div>' +
                    '<button id="'+L.Control.Search.BUTTON_SUBMIT_ID+'" class="btn btn-default" type="button">' + msgSend + '</button>' +
                '</div>' +
                '</form>' +
            '</div>'
            ;

            // Reset the element
            $(this._controlContent).html('').append(content);

            this._contentIsSet = true;

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
            if ($(this._controlContent).is(':visible')) {
                this.hide();
            } else {
                this.show();
            }
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
