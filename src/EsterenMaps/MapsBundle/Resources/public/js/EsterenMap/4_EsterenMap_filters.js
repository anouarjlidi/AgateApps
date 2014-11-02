(function($, L, d, w){

    EsterenMap.prototype.initFilters = function(){
        var control, contents, loaderCallback, routesTypes, markersTypes, zonesTypes;

        control = L.control.filters({}, this);

        control.addTo(this._map);

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
                console.error('A map is required to initialize filters control.');
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
                    console.error('You can only set an EsterenMap as map for filters contorl.');
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

        onAdd: function (leafletMap) {
            var controlDiv, link, textTitle, mapOptions, controlContent;

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
            link.id = '';
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
                .addListener(link, 'click', function () {
                    var container = $(d.getElementById(mapOptions.container)),
                        $controlDiv = $(this).parents('.leaflet-draw-section.leaflet-filters-control'),
                        controlDiv = $controlDiv[0];

                    console.info('Triggered click for filters link', this);

                    if (!$controlDiv.data('baseWidth')) {
                        $controlDiv.data({
                            'baseWidth': $controlDiv.width(),
                            'baseHeight': $controlDiv.height()
                        });
                    }

                    if (!controlDiv.classList.contains('expanded')) {
                        $controlDiv.animate({
                            width: (container.width() / 2),
                            height: (container.height() / 2)
                        }, 500);
                        controlDiv.classList.add('expanded');
                    } else {
                        $controlDiv.animate({
                            width: $controlDiv.data('baseWidth'),
                            height: $controlDiv.data('baseHeight')
                        }, 500);
                        controlDiv.classList.remove('expanded');
                    }

                    return false;
                });

            this._controlDiv = controlDiv;
            this._controlLink = link;
            this._controlContent = controlContent;
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