(function($, L, d, w){

    /**
     * @param {object} user_mapOptions
     * @returns {EsterenMap}
     * @this {EsterenMap}
     * @constructor
     * @version 1.0
     */
    var EsterenMap = function (user_mapOptions) {

        // Données utilisées dans le scope de la classe
        var _this = this, ajaxD;

        if ( !(this instanceof EsterenMap) ) {
            console.error('Wrong scope check, incorrect instance.');
            document.wrongInstance = this;
            return _this;
        }

        if (!L) {
            console.error('Leaflet must be activated.');
            return this;
        }

        // Merge des options de base
        if (user_mapOptions){
            this.mapOptions = mergeRecursive(this.mapOptions, user_mapOptions);
        }

        if (!d.getElementById(this.mapOptions.container)) {
            console.error('Map could not initialize : wrong container id');
            return this;
        }

        ajaxD = {};
        if (this.mapOptions.editMode == true) {
            ajaxD.editMode = true;
        }

        $.ajax({
            url: this.mapOptions.apiUrls.base.replace('maps/','maps/settings/'),
            type: 'GET',
            dataType: 'json',
            data: ajaxD,
            success: function(response) {
                if (response.settings) {
                    _this.mapOptions = mergeRecursive(_this.mapOptions, response.settings);
                    _this._initiate();
                } else {
                    console.error('Map couldn\'t initiate because settings response was not correct.');
                }
            },
            error: function(response){
            }
        });

        return this;
    };


    EsterenMap.prototype._initiate = function() {

        var drawnItems,sidebar, _this;

        // Formatage de l'url d'API qui doit utiliser l'ID de la map
        this.mapOptions.apiUrls.tiles = this.mapOptions.apiUrls.tiles.replace('{id}', ''+this.mapOptions.id);

        // Reset du wrapper avant création de la map
        // Force la redimension du wrapper lors de la redimension de la page
        this.resetHeight();

        this.initLeafletDraw();

        // Création de la map
        this._map = L.map(this.mapOptions.container, this.mapOptions.LeafletMapBaseOptions);

        // Création du calque des tuiles
        L.tileLayer(this.mapOptions.apiUrls.tiles, this.mapOptions.LeafletLayerBaseOptions).addTo(this._map);

        L.Icon.Default.imagePath = this.mapOptions.imgUrl.replace(/\/$/gi, '');

        // Ajout de la sidebar
        if (this.mapOptions.sidebarContainer && d.getElementById(this.mapOptions.sidebarContainer)) {
            sidebar = L.control.sidebar(this.mapOptions.sidebarContainer, {
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

        ////////////////////////////////
        ////////// Mode édition ////////
        ////////////////////////////////
        if (this.mapOptions.editMode == true) {
            this.activateLeafletDraw();
        } else {
            // Doit contenir les nouveaux éléments ajoutés à la carte
            drawnItems = new L.FeatureGroup();
            this._map.addLayer(drawnItems);
            this._drawnItems = drawnItems;
        }

        _this = this;

        // Force le resize à chaque redimension de la page
        $(w).resize(function(){_this.resetHeight();});

        this.loadMarkers();
        this.loadRoutes();
        this.loadZones();

    };

    /**
     * Exécute une requête AJAX dans le but de récupérer des éléments liés à la map
     * via l'API
     *
     * @param {string} name Le type d'élément à récupérer
     * @param {object|null} [datas] les options à envoyer à l'objet AJAX
     * @param {function|null} [callback] La fonction à exécuter (ignoré dans certains cas)
     * @returns {*}
     */
    EsterenMap.prototype._load = function(name, datas, callback) {
        var url, ajaxObject,
            _this = this,
            mapOptions = this.options()
        ;

        if (!datas) {
            datas = {};
        }

        name = name.toLowerCase();
        if (this.mapElements[name] !== true) {
            console.error('Éléments à charger incorrects.');
            return false;
        }

        url = this.mapOptions.apiUrls.base + '/' + name;

        if (!callback && mapOptions.loaderCallbacks[name]) {
            callback = mapOptions.loaderCallbacks[name];
        }

        ajaxObject = {
            url: url,
            type: 'GET',
            dataType: 'json',
            data: datas
        };
        if (callback) {
            ajaxObject.success = function(response) {
                callback.call(_this, response);
            }
        }

        $.ajax(ajaxObject);

        return this;
    };

    EsterenMap.prototype.loadMarkers = function(){
        return this._load('markers');
    };

    EsterenMap.prototype.loadRoutes = function(){
        return this._load('routes');
    };

    EsterenMap.prototype.loadZones = function(){
        return this._load('zones');
    };

    /**
     * Récupère les options de l'objet EsterenMap
     * @this {EsterenMap}
     * @returns {Object} [this.mapOptions]
     */
    EsterenMap.prototype.options = function() {
        return this.cloneObject(this.mapOptions);
    };

    /**
     * Renvoie un clone d'un objet passé en paramètre
     * Si obj2 est spécifié, obj2 remplacera les données d'obj1
     *
     * @param {object} obj1 Le premier objet
     * @param {object} [obj2] Le deuxième objet
     * @returns {object}
     */
    EsterenMap.prototype.cloneObject = function(obj1, obj2){
        var newObject;

        // Crée un nouvel objet
        newObject = $.extend(true,{},obj1);

        if (obj2) {
            // Fusionne le deuxième avec le premier objet
            newObject = $.extend(true, newObject, obj2);
        }

        return newObject;
    };

    /**
     * Redimensionne le conteneur de la carte en fonction de certanies données du layout
     * @returns {EsterenMap}
     */
    EsterenMap.prototype.resetHeight = function() {
        // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
        $(d.getElementById(this.options().container)).height(
              $(w).height()
            - $('#footer').outerHeight(true)
            - $('#navigation').outerHeight(true)
            - $('#map_edit_menu').outerHeight(true)
            - 40
        );
        return this;
    };

    w.EsterenMap = EsterenMap;

})(jQuery, L, document, window);