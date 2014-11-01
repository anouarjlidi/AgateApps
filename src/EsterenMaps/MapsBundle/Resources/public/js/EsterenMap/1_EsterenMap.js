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

        if (!user_mapOptions.id) {
            console.error('Map id must be defined');
            return _this;
        }

        // Force le clonage des options pour ne pas altérer le prototype
        this._mapOptions = this.options();

        if ( !(this instanceof EsterenMap) ) {
            console.error('Wrong scope check, incorrect instance.');
            w.wrongInstance = this;
            return _this;
        }

        if (!L) {
            console.error('Leaflet must be activated.');
            return this;
        }

        // Merge des options de base
        if (user_mapOptions){
            this._mapOptions = mergeRecursive(this._mapOptions, user_mapOptions);
        }

        if (!d.getElementById(this._mapOptions.container)) {
            console.error('Map could not initialize : wrong container id');
            return this;
        }

        ajaxD = {};
        if (this._mapOptions.editMode == true) {
            ajaxD.editMode = true;
        }

        $.ajax({
            url: this._mapOptions.apiUrls.settings,
            //headers: {
            //    Origin: "http://"+w.location.hostname,
            //    'Access-Control-Allow-origin': true
            //},
            type: 'POST',
            dataType: 'json',
            data: ajaxD,
            crossDomain: true,
            success: function(response) {
                if (response.settings) {
                    _this._mapOptions = mergeRecursive(_this._mapOptions, response.settings);
                    _this._initiate();
                } else {
                    console.error('Map couldn\'t initiate because settings response was not correct.');
                }
            },
            error: function(){
                console.error('Error while loading settings');
            }
        });

        return this;
    };


    EsterenMap.prototype._initiate = function() {

        var drawnItems,sidebar, _this, mapOptions;

        // Formatage de l'url d'API qui doit utiliser l'ID de la map
        this._mapOptions.apiUrls.tiles = this.options().apiUrls.tiles.replace('{id}', ''+this.options().id);
        mapOptions = this.options();

        // Reset du wrapper avant création de la map
        // Force la redimension du wrapper lors de la redimension de la page
        if (mapOptions.autoResize) {
            this.resetHeight();
        } else {
            this.resetHeight(mapOptions.containerHeight);
        }

        this.initLeafletDraw();

        // Création de la map
        this._map = L.map(mapOptions.container, mapOptions.LeafletMapBaseOptions);

        // Création du calque des tuiles
        this._tileLayer = L.tileLayer(mapOptions.apiUrls.tiles, mapOptions.LeafletLayerBaseOptions);
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

        ////////////////////////////////
        ////////// Mode édition ////////
        ////////////////////////////////
        if (mapOptions.editMode == true) {
            this.activateLeafletDraw();
        } else {
            // Doit contenir les nouveaux éléments ajoutés à la carte
            drawnItems = new L.LayerGroup();
            this._map.addLayer(drawnItems);
            this._drawnItems = drawnItems;
        }

        _this = this;

        // Force le resize à chaque redimension de la page
        if (mapOptions.autoResize) {
            $(w).resize(function(){_this.resetHeight();});
        }

        if (mapOptions.loadedCallback) {
            mapOptions.loadedCallback.call(this);
        }

    };

    /**
     * Exécute une requête AJAX dans le but de récupérer des éléments liés à la map
     * via l'API
     *
     * @param {array|string} name Le type d'élément à récupérer. Si plusieurs éléments sont indiqués dans un tableau, chacun sera validé à partir des options "allowedElement", cela créera une requête plus précise. Exemple : ["maps","routes"]. Des nombres sont autorisés pour récupérer un ID.
     * @param {object|null} [datas] les options à envoyer à l'objet AJAX
     * @param {string|null} [method] La méthode HTTP. GET par défaut.
     * @param {function|null} [callback] La fonction à exécuter (ignoré dans certains cas)
     * @param {function|null} [callbackComplete] La fonction à exécuter (ignoré dans certains cas)
     * @returns {*}
     */
    EsterenMap.prototype._load = function(name, datas, method, callback, callbackComplete) {
        var url, ajaxObject, i, c,
            _this = this,
            mapOptions = this.options(),
            allowedMethods = ["GET","POST"]
        ;

        method = method ? method.toUpperCase() : "GET";
        if (allowedMethods.indexOf(method) === -1) {
            method = "GET";
            console.warn('Wrong HTTP method for _load() method. Allowed : '+allowedMethods.join(', '));
        }

        if (!datas) {
            datas = {};
        }

        // D'abord, on autorise les chaînes de caractères avec des "/".
        // Cela permet d'écrire des requêtes de ce type : EsterenMap._load('maps/1/markers')
        // On le vérifiera comme un tableau.
        if (typeof name === 'string' && name.indexOf('/') !== -1) {
            name = name.split('/');
        }

        if (typeof name === 'string') {
            // Dans le cas ou name est une chaîne de caractères,
            // elle doit exister dans mapAllowedElements en tant que clé,
            // et être passée à true (on peut la passer à "false" pour désactiver le chargement de certaines données)
            name = name.toLowerCase();
            if (this.mapAllowedElements[name] !== true) {
                console.error('Éléments à charger incorrects.');
                return false;
            }
        } else if (Object.prototype.toString.call( name ) === '[object Array]') {
            // Sinon, name doit être obligatoirement un array.
            // On n'autorise pas les objets littéraux.
            // Cela permet de forcer un tableau parcourable avec une boucle "for"
            for (i = 0, c = name.length ; i < c ; i++) {
                // On teste les cas valides, et on négationne le if, pour plus de clarté sur le prérequis des attributs
                // En l'occurrence, ce doit être soit un élément valable de mapAllowedElements,
                // soit ce doit être un nombre (donc un identifiant qui sera valide ou non selon la requête)
                if (
                    !(this.mapAllowedElements[name[i]] === true || !isNaN(name[i]))
                ) {
                    console.error('Éléments à charger incorrects.');
                    return false;
                }
            }
            name = name.join('/');
        }

        // On s'assure d'une sécurité maximale
        name = name.toString();

        url = mapOptions.apiUrls.base.replace(/\/$/gi, '') + '/' + name;

        ajaxObject = {
            url: url,
            type: method,
            dataType: 'json',
            crossDomain: true,
            data: datas
        };
        if (typeof(callback) === 'function') {
            ajaxObject.success = function(response) {
                callback.call(_this, response);
            }
        }
        if (typeof(callbackComplete) === 'function') {
            ajaxObject.complete = function(){
                callbackComplete.call(_this);
            }
        }

        $.ajax(ajaxObject);

        return this;
    };

    EsterenMap.prototype.loadMarkers = function(){
        var mapOptions = this.options();
        return this._load(["maps",mapOptions.id,"markers"], null, null, mapOptions.loaderCallbacks.markers);
    };

    EsterenMap.prototype.loadRoutes = function(){
        var mapOptions = this.options();
        return this._load(["maps",mapOptions.id,"routes"], null, null, mapOptions.loaderCallbacks.routes);
    };

    EsterenMap.prototype.loadZones = function(){
        var mapOptions = this.options();
        return this._load(["maps",mapOptions.id,"zones"], null, null, mapOptions.loaderCallbacks.zones);
    };

    /**
     * Récupère les options de l'objet EsterenMap
     * @this {EsterenMap}
     * @returns {Object} [this.mapOptions]
     */
    EsterenMap.prototype.options = function() {
        return this.cloneObject(this._mapOptions);
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
            $(d.getElementById(this.options().container)).height(height);
        } else {
            $(d.getElementById(this.options().container)).height(
                  $(w).height()
                - $('#footer').outerHeight(true)
                - $('#navigation').outerHeight(true)
                - $('#map_edit_menu').outerHeight(true)
                - 40
            );
        }
        return this;
    };

    w.EsterenMap = EsterenMap;

})(jQuery, L, document, window);