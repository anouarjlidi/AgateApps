(function($, L, d, w){

    /**
     * @param {object} userMapOptions
     * @returns {EsterenMap}
     * @this {EsterenMap}
     * @constructor
     */
    var EsterenMap = function (userMapOptions) {
        var _this = this;

        if (!userMapOptions.id) {
            throw 'Map id must be defined';
        }

        if (!(this instanceof EsterenMap)) {
            throw 'Wrong scope check, incorrect instance.';
        }

        if (!L) {
            throw 'Leaflet must be activated.';
        }

        // Merge base options
        if (userMapOptions){
            this._mapOptions = this.cloneObject(this._mapOptions, userMapOptions);
        }

        if (!d.getElementById(this._mapOptions.container)) {
            throw 'Map could not initialize : wrong container id';
        }

        this.loadMapData();

        return this;
    };

    /**
     * To be called ONLY after having loaded the settings.
     *
     * @returns {boolean}
     * @private
     */
    EsterenMap.prototype._initialize = function() {

        var sidebar, _this = this, mapOptions;

        mapOptions = this._mapOptions;

        if (this.initialized || d.initializedEsterenMap) {
            throw 'Map already initialized.';
        }

        if (!mapOptions.data.references) {
            throw 'No references were set, map cannot be initialized';
        }

        this.initialized = true;
        d.initializedEsterenMap = true;

        // Reset wrapper's height before creating the map.
        // Forces wrapper's size when the page is resized too.
        if (mapOptions.autoResize) {
            this.resetHeight();
            $(w).resize(function(){_this.resetHeight();});
        } else {
            this.resetHeight(mapOptions.containerHeight);
        }

        if (mapOptions.messageElementId) {
            this._messageElement = d.getElementById(mapOptions.messageElementId);
            if (!this._messageElement) {
                console.warn('Message element id "'+mapOptions.messageElementId+'" was not found.');
            }
        }

        if (mapOptions.crs && !mapOptions.LeafletMapBaseOptions.crs && L.CRS[mapOptions.crs]) {
            mapOptions.LeafletMapBaseOptions.crs = L.CRS[mapOptions.crs];
        } else if (mapOptions.crs && !L.CRS[mapOptions.crs]) {
            console.warn('Could not find CRS "'+mapOptions.crs+'".');
        }

        // Create Leaflet map object.
        this._map = L.map(mapOptions.container, mapOptions.LeafletMapBaseOptions);

        // Create the layer that will show the tiles.
        this._tileLayer = L.tileLayer(mapOptions.apiUrls.tiles, mapOptions.LeafletLayerBaseOptions);
        this._map.addLayer(this._tileLayer);

        L.Icon.Default.imagePath = mapOptions.imgUrl.replace(/\/$/gi, '');

        // Add sidebar if configured.
        if (mapOptions.sidebarContainer && d.getElementById(mapOptions.sidebarContainer)) {
            sidebar = L.control.sidebar(mapOptions.sidebarContainer, {
                position: 'right',
                closeButton: true,
                autoPan: false
            });
            this._map.addControl(sidebar);
            this._map.on('click', function(e){
                // Hide the sidebar when user clicks on map.
                if ((e.originalEvent || e).target.id === mapOptions.container) {
                    sidebar.hide();
                }
            });
            this._sidebar = sidebar;
        }

        if (mapOptions.showFilters === true) {
            // See EsterenMap_filters.js
            this.initFilters();
        }

        if (mapOptions.showDirections === true) {
            // See EsterenMap_directions.js
            this.initDirections();
        }

        if (mapOptions.showSearchEngine === true) {
            // See EsterenMap_search_engine.js
            this.initSearch();
        }

        if (mapOptions.showMarkers === true) {
            // See EsterenMap_markers.js
            this.renderMarkers();
        }

        if (mapOptions.showZones === true) {
            // See EsterenMap_polygons.js
            this.renderZones();
        }

        if (mapOptions.showRoutes === true) {
            // See EsterenMap_polylines.js
            this.renderRoutes();
        }

        ////////////////////////////////
        /////////// Edit mode //////////
        ////////////////////////////////
        if (true === mapOptions.editMode) {
            this.activateLeafletDraw();
            this._map.on('click', _this.disableEditedElements);
        }

        this._mapOptions = this.cloneObject(mapOptions);

        Object.freeze(this._mapOptions);
    };

    EsterenMap.prototype.message = function(message, type, messageElement, disappearTimeout) {
        var element;

        disappearTimeout = disappearTimeout || 4000;

        if (!messageElement) {
            if (this._mapOptions._messageElement) {
                messageElement = this._mapOptions._messageElement;
            } else {
                throw 'No correct element could be used to show a message.';
            }
        }

        element = d.createElement('div');
        element.className = 'card-panel ib h';
        if (type) {
            element.className += ' alert-'+type;
        }

        element.innerHTML = message;

        messageElement.appendChild(element);

        setTimeout(function(){
            // Remove the "hiding" class so the element appears smoothly with css
            element.classList.remove('h');
        }, 10);
        setTimeout(function() {
            // Hide smoothly the element with css transitions
            element.className += ' h';
        }, disappearTimeout);
        setTimeout(function() {
            // Definitely remove the element from the flow
            messageElement.removeChild(element);
        }, disappearTimeout + 1000);
    };

    EsterenMap.prototype.disableEditedElements = function(){

        if (this._editedPolygon) {
            this._editedPolygon.disableEditMode();
        }
        if (this._editedPolyline) {
            this._editedPolyline.disableEditMode();
        }
        if (this._editedMarker) {
            this._editedMarker.disableEditMode();
        }

        this._editedPolygon = null;
        this._editedPolyline = null;
        this._editedMarker = null;
    };

    EsterenMap.prototype.mapReference = function(name, id, defaultValue) {
        var mapReferences = this._mapOptions.data.map, ref;

        defaultValue = defaultValue || null;

        if (!name || !id) {
            throw 'Please specify a map reference name or id.';
        }

        if (mapReferences[name]) {
            if (ref = mapReferences[name][id]) {
                return ref;
            }
        } else {
            console.warn('No map reference with name "'+name+'"');
        }

        return defaultValue;
    };

    EsterenMap.prototype.reference = function(name, id, defaultValue) {
        var references = this._mapOptions.data.references, ref;

        defaultValue = defaultValue || null;

        if (!name || !id) {
            throw 'Please specify a reference name or id.';
        }

        if (references[name]) {
            if (ref = references[name][id]) {
                return ref;
            }
        } else {
            console.warn('No reference with name "'+name+'"');
        }

        return defaultValue;
    };

    EsterenMap.prototype.loadMapData = function(){
        var _this = this, data = {};

        if (true === this._mapOptions.editMode) {
            data.editMode = 'true';
        }

        return this._load({
            url: this._mapOptions.apiUrls.map,
            method: 'GET',
            data: data,
            callback: function(response){
                //callback "success"
                if (response.map && response.references && response.templates) {
                    _this._mapOptions.data = response;
                    _this._initialize();
                } else {
                    throw 'Map couldn\'t initialize because settings response was not correct.';
                }
            },
            callbackError: function(){
                //callback "Error"
                throw 'Error while loading settings';
            }
        });
    };

    /**
     * Merge two objects into a new one.
     *
     * @param {object} obj1 Le premier objet
     * @param {object} [obj2] Le deuxième objet
     * @returns {object}
     */
    EsterenMap.prototype.cloneObject = function(obj1, obj2){
        var newObject;

        // Crée un nouvel objet
        newObject = $.extend(true, {}, obj1);

        if (obj2) {
            // Fusionne le deuxième avec le premier objet
            newObject = $.extend(true, {}, newObject, obj2);
        }

        return newObject;
    };

    /**
     * Redimensionne le conteneur de la carte en fonction de certaines données du layout
     * Si une hauteur est envoyée en paramètre, elle est directement affectée.
     * Sinon, c'est une hauteur estimée selon le contenant et le reste de la page
     * @param height La hauteur en pixels
     * @returns {EsterenMap}
     */
    EsterenMap.prototype.resetHeight = function(height) {
        // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
        if (height) {
            $(d.getElementById(this._mapOptions.container)).height(height);
        } else {
            var footer = d.getElementById('footer');
            var navigation = d.getElementById('navigation');
            var maps_admin_container = d.getElementById('maps_admin_container');
            height =
                $(w).height()
                - (footer ? $(footer).outerHeight(true) : 0)
                - (navigation ? $(navigation).outerHeight(true) : 0)
                - (maps_admin_container ? $(maps_admin_container).outerHeight(true) : 0)
                - 20
            ;
            $(d.getElementById(this._mapOptions.container)).height(height);
        }
        return this;
    };

    w.EsterenMap = EsterenMap;

})(jQuery, L, document, window);
