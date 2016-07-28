(function($){

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
        var url, ajaxObject, i, c, xhr_name, xhr_object,
            otherParams = {},
            _this = this,
            mapOptions = this.options(),
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
})(jQuery);
