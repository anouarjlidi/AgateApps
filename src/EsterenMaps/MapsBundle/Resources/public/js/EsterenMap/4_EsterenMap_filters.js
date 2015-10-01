(function($, L, d, w){

    EsterenMap.prototype.initFilters = function(){
        var control, _this = this,
            mapOptions = this.options()
        ;

        if (mapOptions.showFilters !== true) {
            return false;
        }

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

        _cntSet: false,
        _lstnSet: false,

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

        createContent: function(){
            if (this._cntSet) {
                console.error('Content has already been set for this filter panel.');
                return false;
            }

            var content,
                filtersMsgTitle = typeof MSG_CONTROL_FILTERS_TITLE !== 'undefined' ? MSG_CONTROL_FILTERS_TITLE : 'Filtres',
                filtersMsgRoutesTypes = typeof MSG_ROUTES_TYPES !== 'undefined' ? MSG_ROUTES_TYPES : 'Types de routes',
                filtersMsgZonesTypes = typeof MSG_ZONES_TYPES !== 'undefined' ? MSG_ZONES_TYPES : 'Types de zones',
                filtersMsgMarkersTypes = typeof MSG_MARKERS_TYPES !== 'undefined' ? MSG_MARKERS_TYPES : 'Types de marqueurs',
                listsClasses = 'list-unstyled',
                listsElementsClasses = '',
                listsElementsStyles = 'display: block;',
                nodesList = {
                    "markersTypes": [],
                    "routesTypes": [],
                    "zonesTypes": [],
                    "markersTypesUL": [],
                    "routesTypesUL": [],
                    "zonesTypesUL": []
                },
                captionStyle = 'width: 12px; height: 12px; vertical-align: text-top; margin-right: 3px; margin-left: 3px;',
                list
            ;

            // ------------- MARKERS -------------
            list = L.DomUtil.create('ul', listsClasses);
            if (this._esterenMap._markersTypes) {
                $.each(this._esterenMap._markersTypes, function(index, markerType) {
                    var node = L.DomUtil.create('li', listsElementsClasses, list);
                    node.setAttribute('style', listsElementsStyles);
                    node.innerHTML =
                        '<label for="markerType'+markerType.id+'">'
                        +'<input id="markerType'+markerType.id+'" type="checkbox" class="leaflet-filter-checkbox" checked="checked" />'
                        +'<img src="'+markerType.web_icon+'" class="ib" style="'+captionStyle+'">'
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
                    node.setAttribute('style', listsElementsStyles);
                    node.innerHTML =
                        '<label for="routeType'+routeType.id+'">'
                        +'<input id="routeType'+routeType.id+'" type="checkbox" class="leaflet-filter-checkbox" checked="checked" />'
                        +'<span class="ib" style="'+captionStyle+' background: '+routeType.color+'"></span>'
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
                    node.setAttribute('style', listsElementsStyles);
                    node.innerHTML =
                        '<label for="zoneType'+zoneType.id+'">'
                        +'<input id="zoneType'+zoneType.id+'" type="checkbox" class="leaflet-filter-checkbox" checked="checked" />'
                        +'<span class="ib" style="'+captionStyle+' background: '+zoneType.color+'"></span>'
                        +zoneType.name
                        +'</label>'
                    ;
                    nodesList.zonesTypes.push(node);
                });
            }
            nodesList.zonesTypesUL = list;

            // Ajout des différents noeuds à l'objet Content
            // On persiste ici à utiliser le concept objet
            // pour être sûr que des listeners ne sont pas "perdus" en route

            content = $('<div />')
                .append($('<h3 />').text(filtersMsgTitle))
                .append($('<div class="row" />')
                    .append($('<div class="col-sm-4" />')
                        .append($('<h4 />').text(filtersMsgMarkersTypes))
                        .append(nodesList.markersTypesUL)
                    )
                    .append($('<div class="col-sm-4" />')
                        .append($('<h4 />').text(filtersMsgRoutesTypes))
                        .append(nodesList.routesTypesUL)
                    )
                    .append($('<div class="col-sm-4" />')
                        .append($('<h4 />').text(filtersMsgZonesTypes))
                        .append(nodesList.zonesTypesUL)
                    )
                )
            ;

            $(this._controlContent).html('').append(content);

            this._cntSet= true;

            return this;
        },

        show: function(){
            var controlDiv = this._controlDiv,
                link = this._controlLink;
            controlDiv.classList.add('expanded');
            link.children[0].classList.remove('icon-resize_full');
            link.children[0].classList.add('icon-resize_small');
        },

        hide: function(){
            var controlDiv = this._controlDiv,
                link = this._controlLink;
            controlDiv.classList.remove('expanded');
            link.children[0].classList.add('icon-resize_full');
            link.children[0].classList.remove('icon-resize_small');
        },

        onAdd: function () {
            var _this = this, controlDiv, link, textTitle, controlContent;

            if (!(this._esterenMap instanceof EsterenMap)) {
                console.error('Fitlers control can only be added to a LeafletMap with an EsterenMap. Have you forgotten the second argument to the constructor ?');
                return false;
            }

            textTitle = (typeof(MSG_CONTROL_FILTERS_TITLE) !== 'undefined') ? MSG_CONTROL_FILTERS_TITLE : 'Filters';

            controlDiv = L.DomUtil.create('div', 'leaflet-draw-section leaflet-filters-control');
            controlDiv.id = "leaflet-filters-control";

            controlContent = L.DomUtil.create('div', 'leaflet-filters-control-content', controlDiv);

            link = L.DomUtil.create('a', '', controlDiv);
            link.id = 'leaflet-filters-toggle';
            link.style.backgroundImage = 'none';
            link.href = "#";
            link.innerHTML = '<i class="fa fa-filter" style="font-size: 14px;"></i>';
            link.title = textTitle;
            $(link).tooltip({
                "placement" : "right",
                "container": "body"
            });

            // Listener FiltersControl
            L.DomEvent
                .addListener(link, 'click', function () {
                    var controlDiv = d.getElementById('leaflet-filters-control');

                    if (!controlDiv.classList.contains('expanded')) {
                        _this.show();
                    } else {
                        _this.hide();
                    }
                    return false;
                })
                .addListener(link, 'click', L.DomEvent.stopPropagation)
            ;

            // Listeners FiltersControl disable
            this._esterenMap._map.on('click', function(){
                _this.hide();
            });

            this._controlDiv = controlDiv;
            this._controlLink = link;
            this._controlContent = controlContent;

            this.createContent();
            this.setEvents();

            L.DomEvent
                .on(this._controlDiv, 'click', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'mousedown', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'touchstart', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'dblclick', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'mousewheel', L.DomEvent.stopPropagation)
                .on(this._controlDiv, 'MozMousePixelScroll', L.DomEvent.stopPropagation);

            return controlDiv;
        },

        setEvents: function(){
            if (this._lstnSet) {
                console.error('Content has already been set for this filter panel.');
                return false;
            }
            var inputs = $(this._controlContent).find('input.leaflet-filter-checkbox');

            inputs.on('change', function(){
                if (!d.getElementById('filtersStyle')) {
                    $('<style />').attr('id', 'filtersStyle').appendTo('head');
                }
                var styleContainer = d.getElementById('filtersStyle'),
                    html = '';
                inputs.each(function(i,input){
                    if (!$(input).is(':checked')) {
                        html += '[data-leaflet-object-type="'+input.id+'"]{display:none;}';
                    }
                });
                styleContainer.innerHTML = html;
            });

            this._lstnSet = true;

            return this;
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
