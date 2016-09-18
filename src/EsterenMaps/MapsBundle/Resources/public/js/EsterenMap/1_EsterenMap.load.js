(function($, w){

    /**
     * @param {string} str
     * @returns {number}
     */
    function hashCode(str) {
        var hash = 0, i, len;
        if (str.length === 0) { return hash; }
        for (i = 0, len = str.length; i < len; i++) {
            hash  = ((hash << 5) - hash) + str.charCodeAt(i);
            hash |= 0; // Convert to 32bit integer
        }
        return hash;
    }

    /**
     * Exécute une requête AJAX dans le but de récupérer des éléments liés à la map
     * via l'API
     *
     * @param {object|string} name Le type d'élément à récupérer. Si plusieurs éléments sont indiqués dans un tableau, chacun sera validé à partir des options "allowedElement", cela créera une requête plus précise. Exemple : ["maps","routes"]. Des nombres sont autorisés pour récupérer un ID.
     * @param {object|null} [data] les options à envoyer à l'objet AJAX
     * @param {string|null} [method] La méthode HTTP. GET par défaut.
     * @param {function|null} [callback] Une fonction de callback à envoyer à la méthode "success" de l'objet Ajax.
     * @param {function|null} [callbackComplete] Idem que "callback" mais pour la méthode "complete"
     * @param {function|null} [callbackError] Idem que "callback" mais pour la méthode "error"
     * @returns {*}
     */
    EsterenMap.prototype._load = function(name, data, method, callback, callbackComplete, callbackError) {
        var url, ajaxObject, i, c, xhr_name, xhr_object, cacheTTL, cacheKey, cacheItem, now,
            _this = this,
            mapOptions = this._mapOptions,
            allowedMethods = ["GET", "POST", "PUT"]
        ;

        if ($.isPlainObject(name)) {
            xhr_name = name.xhr_name || null;
            data = name.datas || name.data || data;
            method = name.method || method;
            callback = name.callback || callback;
            callbackComplete = name.callbackComplete || callbackComplete;
            callbackError = name.callbackError || callbackError;
            name = name.uri || name ;
            cacheTTL = name.cacheTTL || mapOptions.cacheTTL;
        }

        method = method ? method.toUpperCase() : "GET";
        if (allowedMethods.indexOf(method) === -1) {
            method = "GET";
            console.error('Wrong HTTP method for _load() method. Allowed : '+allowedMethods.join(', '));
            return false;
        }

        if (!data) {
            data = {};
        }

        // D'abord, on autorise les chaînes de caractères avec des "/".
        // Cela permet d'écrire des requêtes de ce type : EsterenMap._load('maps/1/markers')
        // On le vérifiera comme un tableau.
        if (typeof name === 'string' && name.indexOf('/') !== -1) {
            name = name.split('/');
        }

        if (name && typeof name === 'string') {
            // Dans le cas ou name est une chaîne de caractères,
            // elle doit exister dans mapAllowedElements en tant que clé,
            // et être passée à true (on peut la passer à "false" pour désactiver le chargement de certaines données)
            name = name.toLowerCase();
            if (this.mapAllowedElements[name] !== true) {
                console.error('Éléments à charger incorrects.');
                return false;
            }
        } else if (name && Object.prototype.toString.call( name ) === '[object Array]') {
            // Sinon, name doit être obligatoirement un array.
            if (this.mapAllowedElements[name[0]] !== true) {
                console.error('Éléments à charger incorrects.');
                return false;
            }
            name = name.join('/');
        } else if (!name) {
            console.error('Wrong uri sent to EsterenMap dynamic loader.');
            return false;
        }

        // On s'assure d'une sécurité maximale
        name = name.toString();

        url = mapOptions.apiUrls.base.replace(/\/$/gi, '') + '/' + name;

        ajaxObject = {
            url: url,
            type: method,
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            contentType: method === 'GET' ? "application/x-www-form-urlencoded" : "application/json",
            jsonp: false,
            data: method === 'GET' ? data : JSON.stringify(data ? data : {})
        };

        // Define the cache key based on this ajax object.
        // Callbacks cannot be stringified so we don't care about them.
        cacheKey = mapOptions.cachePrefix + hashCode(JSON.stringify(ajaxObject));

        // Check in the cache if we have an element.
        if (cacheTTL > 0 && (cacheItem = w.localStorage.getItem(cacheKey))) {
            cacheItem = JSON.parse(cacheItem);

            if (!cacheItem.hasOwnProperty('date') || !cacheItem.hasOwnProperty('response')) {
                // If cache item does not have the right properties, its corrupted.
                // By the way, corrupted data cannot hurt "that much",
                // since they can't contain functions (localStorage doesn't allow).
                console.warn('Corrupted cache data.');
            } else {
                now = new Date();

                if (cacheItem.date > now.getTime()) {
                    // If expired, let's remove the item.
                    console.info('expired');
                    w.localStorage.removeItem(cacheKey);
                } else {
                    if (typeof(callback) === 'function') {
                        callback.call(_this, cacheItem.response);
                    }
                    if (typeof(callbackComplete) === 'function') {
                        callbackComplete.call(_this);
                    }
                    return this;
                }
            }
        }

        // Apply the different callbacks
        if (typeof(callback) === 'function') {
            ajaxObject.success = function(response) {

                // Set the cache item in the browser
                var expirationDate = new Date();

                callback.call(_this, response);
                cacheItem = JSON.stringify({
                    date: expirationDate.getTime() + cacheTTL,
                    response: response
                });

                w.localStorage.setItem(cacheKey, cacheItem);
            }
        }

        if (typeof(callbackComplete) === 'function') {
            ajaxObject.complete = function(){
                callbackComplete.call(_this);
            }
        }

        // This callback is special because it's the one that stores the results in localStorage cache.
        if (typeof(callbackError) === 'function') {
            ajaxObject.callbackError = function(){
                callbackError.call(_this);
            }
        }

        if (xhr_name && this._xhr_saves[xhr_name]) {
            this._xhr_saves[xhr_name].abort();
        }

        xhr_object = $.ajax(ajaxObject);

        if (xhr_name) {
            this._xhr_saves[xhr_name] = xhr_object;
        }

        return this;
    };
})(jQuery, window);
