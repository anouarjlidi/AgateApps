(function($, L, d, w){

    /**
     * @param {object} userMapOptions
     * @returns {EsterenMap}
     * @this {EsterenMap}
     * @constructor
     */
    var EsterenMap = function (userMapOptions) {
        var _this = this;

        // Force CANVAS
        w.L_PREFER_CANVAS = true;

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

        this.loadSettings();

        return this;
    };

    /**
     * To be called ONLY after having loaded the settings.
     *
     * @returns {boolean}
     * @private
     */
    EsterenMap.prototype._initialize = function() {

        var drawnItems,sidebar, _this = this, mapOptions;

        if (this.initialized || d.initializedEsterenMap) {
            throw 'Map already initialized.';
        }

        this.initialized = true;
        d.initializedEsterenMap = true;

        // Formatage de l'url d'API qui doit utiliser l'ID de la map
        this._mapOptions.apiUrls.tiles = this._mapOptions.apiUrls.tiles.replace('{id}', ''+this._mapOptions.id);
        mapOptions = this._mapOptions;

        // Reset du wrapper avant création de la map
        // Force la redimension du wrapper lors de la redimension de la page
        if (mapOptions.autoResize) {
            this.resetHeight();
        } else {
            this.resetHeight(mapOptions.containerHeight);
        }

        if (mapOptions.messageElementId) {
            this._messageElement = d.getElementById(mapOptions.messageElementId);
        }

        if (mapOptions.crs && !mapOptions.LeafletMapBaseOptions.crs && L.CRS[mapOptions.crs]) {
            mapOptions.LeafletMapBaseOptions.crs = L.CRS[mapOptions.crs];
        } else if (mapOptions.crs && !L.CRS[mapOptions.crs]) {
            console.warn('Could not find CRS "'+mapOptions.crs+'".');
        }

        // Création de la map
        this._map = L.map(mapOptions.container, mapOptions.LeafletMapBaseOptions);

        // Création du calque des tuiles
        //this._tileLayer = L.tileLayer(mapOptions.apiUrls.tiles, mapOptions.LeafletLayerBaseOptions);
        //this._map.addLayer(this._tileLayer);
        this._tileLayer = L.tileLayer.canvas(mapOptions.LeafletLayerBaseOptions);
        this._tileLayer.drawTile = function(canvas, tilePoint, zoom) {
            var context = canvas.getContext('2d'),
                img = document.createElement('img'),
                imgUrl = mapOptions.apiUrls.tiles,
                tileSize = mapOptions.LeafletLayerBaseOptions.tileSize,
                x = tilePoint.x,
                y = tilePoint.y
            ;
            imgUrl = imgUrl.replace('{x}', x);
            imgUrl = imgUrl.replace('{y}', y);
            imgUrl = imgUrl.replace('{z}', _this._map.getZoom());
            img.src = imgUrl;
            img.onload = function() {
                context.drawImage(img, 0, 0, tileSize, tileSize, 0, 0, tileSize, tileSize);
            };
        };
        this._map.addLayer(this._tileLayer);

        L.Icon.Default.imagePath = mapOptions.imgUrl.replace(/\/$/gi, '');

        // Ajout de la sidebar
        if (mapOptions.sidebarContainer && d.getElementById(mapOptions.sidebarContainer)) {
            sidebar = L.control.sidebar(mapOptions.sidebarContainer, {
                position: 'right',
                closeButton: true,
                autoPan: false
            });
            this._map.addControl(sidebar);
            this._map.on('click', function(){
                sidebar.hide();
            });
            this._sidebar = sidebar;
        }

        // Initialisation des filtres si demandé
        if (mapOptions.showFilters === true) {
            this.initFilters();
        }

        // Initialisation du calcul d'itinéraire si demandé
        if (mapOptions.showDirections === true) {
            this.initDirections();
        }

        // Initialize search engine
        if (mapOptions.showSearchEngine === true) {
            this.initSearch();
        }

        ////////////////////////////////
        ////////// Mode édition ////////
        ////////////////////////////////
        if (mapOptions.editMode === true) {
            this.activateLeafletDraw();
            this._map.on('click', function(){
                _this.disableEditedElements();
            });
        } else {
            // Doit contenir les nouveaux éléments ajoutés à la carte
            drawnItems = new L.LayerGroup();
            this._map.addLayer(drawnItems);
            this._drawnItems = drawnItems;
        }

        // Force le resize à chaque redimension de la page
        if (mapOptions.autoResize) {
            $(w).resize(function(){_this.resetHeight();});
        }

        this._mapOptions = this.cloneObject(this._mapOptions);

        Object.freeze(this._mapOptions);
    };

    EsterenMap.prototype.message = function(message, type, messageElement, disappearTimeout) {
        var element;

        disappearTimeout = disappearTimeout || 4000;

        if (!messageElement) {
            if (this._messageElement) {
                messageElement = this._messageElement;
            } else {
                throw 'No correct element could be used to show a message.';
            }
        }

        element = d.createElement('div');
        element.className = 'alert alert-sm ib h';
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

    EsterenMap.prototype.refData = function(name, id) {
        var data = this.cloneObject((this._refData['ref-data'] ? this._refData['ref-data'] : this._refData)), grep;
        if (name) {
            if (data[name]) {
                if (!isNaN(id)) {
                    grep = $.grep(data[name], function(element){return element.id == id;});
                    if (grep.length) {
                        data = grep[0];
                    } else {
                        console.warn('No ref data with id "'+id+'" in "'+name+'"');
                        data = {};
                    }
                } else {
                    data = data[name];
                }
            } else {
                console.warn('No ref data with name "'+name+'"');
                data = null;
            }
        }
        return data;
    };

    EsterenMap.prototype.loadSettings = function(){
        var _this = this;
        var data = {};

        if (true === this._mapOptions.editMode) {
            data.editMode = 'true';
        }

        return this._load({
            url: this._mapOptions.apiUrls.map,
            method: 'GET',
            data: data,
            callback: function(response){
                console.info('success', response);
                return;
                //callback "success"
                if (response.map && response.references && response.templates) {
                    _this._mapOptions = _this.cloneObject(_this._mapOptions, response.settings);
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
                - 10
            ;
            $(d.getElementById(this._mapOptions.container)).height(height);
        }
        return this;
    };

    w.EsterenMap = EsterenMap;

})(jQuery, L, document, window);
