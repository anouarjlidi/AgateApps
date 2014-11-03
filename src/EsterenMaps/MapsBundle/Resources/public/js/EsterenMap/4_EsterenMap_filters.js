(function($, L, d, w){

    EsterenMap.prototype.initFilters = function(){
        var control, _this = this;

        control = L.control.filters({}, this);

        this._filtersControl = control;

        this.loadRefDatas(function(){
            control.addTo(this._map);
        });

        return this;
    };

    L.Control.Filters = L.Control.extend({
        options: {
            position: 'bottomleft'
        },

        _esterenMap: null,
        _controlDiv: null,
        _controlContent: null,
        _controlLink: null,

        initialize: function (options, map) {
            // Constructeur
            if (!(map instanceof EsterenMap)) {
                console.error('An "EsterenMap" is required to initialize filters control.');
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
                    console.error('You can only set an "EsterenMap" as map for filters control.');
                    return false;
                }
                this._esterenMap = map;
                return this;
            }
            return this._esterenMap;
        },

        setContent: function(content){
            $(this._controlContent).html('').append(content);
            return this;
        },

        createContent: function(){
            var content,
                _this = this,
                filtersMsgTitle = typeof MSG_CONTROL_FILTERS_TITLE !== 'undefined' ? MSG_CONTROL_FILTERS_TITLE : 'Filtres',
                filtersMsgRoutesTypes = typeof MSG_ROUTES_TYPES !== 'undefined' ? MSG_ROUTES_TYPES : 'Types de routes',
                filtersMsgZonesTypes = typeof MSG_ZONES_TYPES !== 'undefined' ? MSG_ZONES_TYPES : 'Types de zones',
                filtersMsgMarkersTypes = typeof MSG_MARKERS_TYPES !== 'undefined' ? MSG_MARKERS_TYPES : 'Types de marqueurs',
                listsClasses = 'list-unstyled col-sm-8',
                listsElementsClasses = '',
                nodesList = {
                    "markersTypes": [],
                    "routesTypes": [],
                    "zonesTypes": [],
                    "markersTypesUL": [],
                    "routesTypesUL": [],
                    "zonesTypesUL": []
                },
                list, node,
                i, c, callback
            ;

            // ------------- MARKERS -------------
            list = L.DomUtil.create('ul', listsClasses);
            if (this._esterenMap._markersTypes) {
                $.each(this._esterenMap._markersTypes, function(index, markerType) {
                    var node = L.DomUtil.create('li', listsElementsClasses, list);
                    node.innerHTML =
                        '<label for="markerType'+markerType.id+'">'
                        +'<input id="markerType'+markerType.id+'" type="checkbox" class="leaflet-filter-checkbox" />'
                        +markerType.name
                        +'</label>'
                    ;
                    nodesList.markersTypes.push(node);
                });
            }
            nodesList.markersTypesUL = list;

            // ------------- ROUTES -------------
            list = L.DomUtil.create('ul', listsClasses);
            if (this._esterenMap._routesTypes) {
                $.each(this._esterenMap._routesTypes, function(index, routeType) {
                    var node = L.DomUtil.create('li', listsElementsClasses, list);
                    node.innerHTML =
                        '<label for="routeType'+routeType.id+'">'
                        +'<input id="routeType'+routeType.id+'" type="checkbox" class="leaflet-filter-checkbox" />'
                        +routeType.name
                        +'</label>'
                    ;
                    nodesList.routesTypes.push(node);
                });
            }
            nodesList.routesTypesUL = list;

            // ------------- ZONES -------------
            list = L.DomUtil.create('ul', listsClasses);
            if (this._esterenMap._zonesTypes) {
                $.each(this._esterenMap._zonesTypes, function(index, zoneType) {
                    var node = L.DomUtil.create('li', listsElementsClasses, list);
                    node.innerHTML =
                        '<label for="routeType'+routeType.id+'">'
                        +'<input id="routeType'+routeType.id+'" type="checkbox" class="leaflet-filter-checkbox" />'
                        +routeType.name
                        +'</label>'
                    ;
                    nodesList.zonesTypes.push(node);
                });
            }
            nodesList.zonesTypesUL = list;

            // Ajout des différents noeuds à l'objet Content
            // On persiste ici à utiliser le concept objet
            // pour être sûr que des listeners ne sont pas "perdus" en route

            content = $('<div />').css('overflow-y', 'scroll')
                .append('<h3>'+filtersMsgTitle+'</h3>')
                .append(
                    $('<div />').addClass('row')
                        .append($('<div />').addClass('col-sm-4').html('<h4>'+filtersMsgMarkersTypes+'</h4>'))
                        .append($('<div />').addClass('col-sm-8').append(nodesList.markersTypesUL))
                )
                .append(
                    $('<div />').addClass('row')
                        .append($('<div />').addClass('col-sm-4').html('<h4>'+filtersMsgRoutesTypes+'</h4>'))
                        .append($('<div />').addClass('col-sm-8').append(nodesList.routesTypesUL))
                )
                .append(
                    $('<div />').addClass('row')
                        .append($('<div />').addClass('col-sm-4').html('<h4>'+filtersMsgZonesTypes+'</h4>'))
                        .append($('<div />').addClass('col-sm-8').append(nodesList.zonesTypesUL))
                )
            ;

            return content;
        },

        onAdd: function (leafletMap) {
            var _this = this,
                controlDiv, link, textTitle, mapOptions, controlContent;

            if (!(this._esterenMap instanceof EsterenMap)) {
                console.error('Fitlers control can only be added to a LeafletMap with an EsterenMap. Have you forgotten the second argument to the constructor ?');
                return false;
            }

            mapOptions = this._esterenMap.options();

            textTitle = (typeof(MSG_CONTROL_FILTERS_TITLE) !== 'undefined') ? MSG_CONTROL_FILTERS_TITLE : 'Filters';

            controlDiv = L.DomUtil.create('div', 'leaflet-draw-section leaflet-filters-control');
            controlDiv.id = "leaflet-filters-control";

            controlContent = L.DomUtil.create('div', 'leaflet-filters-control-content', controlDiv);

            link = L.DomUtil.create('a', '', controlDiv);
            link.id = 'leaflet-filters-toggle';
            link.style.backgroundImage = 'none';
            link.href = "#";
            link.innerHTML = '<span class="glyphicon icon-resize_full"></span>';
            link.title = textTitle;
            $(link).tooltip({
                "placement" : "right",
                "container": "body"
            });

            L.DomEvent
                .addListener(controlDiv, 'click', L.DomEvent.stopPropagation)
                .addListener(controlDiv, 'click', L.DomEvent.preventDefault)
                .addListener(controlContent, 'click', L.DomEvent.stopPropagation)
                .addListener(controlContent, 'click', L.DomEvent.preventDefault)
                .addListener(link, 'click', function () {
                    var container = $(d.getElementById(mapOptions.container)),
                        $controlDiv = $(this).parents('.leaflet-draw-section.leaflet-filters-control'),
                        controlDiv = $controlDiv[0];

                    if (!$controlDiv.data('baseWidth')) {
                        $controlDiv.data({
                            'baseWidth': $controlDiv.width(),
                            'baseHeight': $controlDiv.height()
                        });
                    }

                    if (!controlDiv.classList.contains('expanded')) {
                        $controlDiv.stop().animate({
                            width: (container.width() / 2),
                            height: (container.height() / 2)
                        }, 500);
                        controlDiv.classList.add('expanded');
                        link.children[0].classList.remove('icon-resize_full');
                        link.children[0].classList.add('icon-resize_small');
                    } else {
                        $controlDiv.stop().animate({
                            width: $controlDiv.data('baseWidth'),
                            height: $controlDiv.data('baseHeight')
                        }, 500);
                        controlDiv.classList.remove('expanded');
                        link.children[0].classList.add('icon-resize_full');
                        link.children[0].classList.remove('icon-resize_small');
                    }

                    return false;
                });

            this._controlDiv = controlDiv;
            this._controlLink = link;
            this._controlContent = controlContent;

            this.setContent(this.createContent());

            return controlDiv;
        }
    });

    /**
     * @param {object} options
     * @param {EsterenMap} map
     * @returns {L.Control.Filters}
     */
    L.control.filters = function (options, map) {
        return new L.Control.Filters(options, map);
    };

})(jQuery, L, document, window);