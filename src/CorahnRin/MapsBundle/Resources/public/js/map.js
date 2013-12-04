(function($){
    /**
     * La classe Map va générer une carte à partir de tuiles
     * L'url d'initialisation de la carte DOIT être présente dans le code, dans
     *   une balise avec pour id "#map_container"
     * @param object params Un objet JSON contenant les paramètres à appliquer
     * @returns Map
     */
    function Map(params) {

        var _this = this;
        var id = null;
        if (isNaN(id)) { console.error('Cannot generate map : wrong id'); }
        var zoom = { "current": 1, "max": 0 };// Le zoom actuel et le zoom maximum récupéré par ajax
        var name = '';
        var nameSlug = '';
        var tilesUrl = '';// Url de chargement des tuiles. Elle est récupérée par ajax
        var initUrl = null;// Url à envoyer avec ajax pour initialiser la carte
        var identifications = {};// La liste des identifications organisées par zoom et récupérées par ajax (nombre de tuiles, dimensions en pixels, etc.)
        var timeouts = { "zoom": null,"showImages":null };// Définition de quelques timeouts, ils seront utilisés pour les actions nécessitant une sécurité temporelle
        var wrapperSize = { "width": 0, "height": 0 };// La taille du wrapper, sera modifiée au redimensionnement
        var imgSize;
        var wrapper = null;
        var container = null;
        var allowMove = true;
        var allowZoom = true;

        // Paramètres par défaut -----------------------------------------------
        if (typeof params !== 'object')              { params = {}; }
        if (typeof params.allowMove !== 'undefined') { f_allowMove(params.allowMove); }
        if (typeof params.allowZoom !== 'undefined') { f_allowZoom(params.allowZoom); }
        if (typeof params.zoom !== 'undefined')      { zoom.current = params.zoom; console.info('specific zoom : '+params.zoom); }
        id      = params.id      ? params.id      : document.getElementById('map_container').getAttribute('data-map-id');
        initUrl = params.initUrl ? params.initUrl : document.getElementById('map_container').getAttribute('data-init-url');

        // Initialisation ------------------------------------------------------
        $.ajax({
            "url": initUrl,
            "dataType": "json",
            "type": "post",
            "data" : { "id" : id },
            "success": function(data) {
                if (data.id) {
                    // Récupération des données ajax dans l'objet Map
                    name = data.name;
                    nameSlug = data.name;
                    identifications = data.identifications;
                    zoom.max = data.maxZoom;
                    imgSize = data.imgSize;
                    tilesUrl = data.tilesUrl;
                    f_generateTiles(zoom.current);
                }
            }
        });

        // Initialisation du wrapper et du container ---------------------------
        if (document.getElementById('map_wrapper'))   { wrapper = document.getElementById('map_wrapper'); }
        if (document.getElementById('map_container')) { container = document.getElementById('map_container'); }
        if (!wrapper || !container) {
            console.error('Cannot generate map : failed identification of wrapper and container');
            return;
        }

        // Getters -------------------------------------------------------------
        this.id              = function() { return id; };
        this.name            = function() { return name; };
        this.nameSlug        = function() { return nameSlug; };
        this.initUrl         = function() { return initUrl; };
        this.container       = function() { return container; };
        this.wrapper         = function() { return wrapper; };
        this.tilesUrl        = function() { return tilesUrl; };
        this.imgSize         = function() { return imgSize; };
        this.identifications = function() { return identifications; };

        // Fonctions publiques -------------------------------------------------
        this.zoom            = function(type) { return f_zoom(type); };
        this.position        = function(type) { return f_position(type); };
        this.allowMove       = function(allow) { return f_allowMove(allow); };
        this.allowZoom       = function(allow) { return f_allowZoom(allow); };
        this.generateTiles   = function(z, move) { return f_generateTiles(z, move); };
        this.identify        = identify;
        this.showImages      = showImages;
        this.identify        = identify;
        this.zoomIn          = zoomIn;
        this.zoomOut         = zoomOut;

        // Méthodes d'initialisation -------------------------------------------
        $(window).resize(resetHeight); // Modification de la hauteur au redimensionnement
        this.allowZoom(allowZoom);
        this.allowMove(allowMove);

        // Liste des fonctions -------------------------------------------------
        function f_allowMove(allow) {
            if (typeof allow === 'undefined') {
                return allowMove;
            } else {
                allowMove = !!allow;
                if (allowMove) {
                    if ($(container).is(':ui-draggable')) {
                        $(container).draggable('enable');
                    } else {
                        $(container).draggable({
                            addClasses: false,// Gagne un peu de mémoire
                            stop: showImages// Teste l'affichage des images à chaque déplacement, pour afficher les images invisibles
                        });
                    }
                } else if (!allowMove && $(container).is(':ui-draggable')) {
                    $(container).draggable('disable');
                }
            }
        }

        function f_allowZoom(allow) {
            if (typeof allow === 'undefined') {
                return allowZoom;
            } else {
                allowZoom = !!allow;
                if (allowZoom) {
                    // Utilise le plugin mousewheel pour effectuer un zoom dynamique
                    $(wrapper).mousewheel(function(event, delta, deltaX, deltaY) {
                        if (delta > 0) { zoomIn(); }
                        else if (delta < 0) { zoomOut(); }
                        return false; // prevent default
                    });
                } else if (!allowZoom) {
                    $(wrapper).unbind('mousewheel');
                }
            }
        }

        function f_zoom(type){
            if (type === 'current') { return zoom.current; }
            else if (type === 'max') { return zoom.max; }
            else { return zoom; }
        }

        function f_position(type) {
            if (type === 'left') { return $(container).offset().left; }
            else if (type === 'top') { return $(container).offset().top; }
            else { return $(container).offset(); }
        }

        // Cette fonction redéfinit le zoom d'un container grâce à son id et à l'échelle mentionnée
        function f_zoomContainer(containerId, scale) {
            if (isNaN(containerId)) {
                console.error('Cannot zoom on map : wrong zoom level injected to zoom function');
                return;
            }

            if (document.getElementById('zoomContainer'+containerId)) {
                $('#zoomContainer'+containerId).animate({
                    transform:'scale('+scale+')'
                }, {
                    duration:200,
                    queue:false
                });
            }
        };

        // Cette fonction va générer toutes les balises <img>, sans pour autant charger toutes les images
        // Elle se base sur le zoom actuel ou sur un zoom prédéfini (pour les options cliquables)
        function f_generateTiles(z, move) {
            // Setter du zoom
            zoom.current = (z ? z : zoom.current);
            if (!z) {
                console.error('Cannot generate tiles : zoom is undefined');
                return false;
            }
            var ident = identify(z),// Identification du zoom demandé
                xmax = ident.xmax,
                ymax = ident.ymax,
                wmax = parseInt(ident.wmax),
                hmax = parseInt(ident.hmax),
                nodeContainer,// Cette variable sera utilisée pour créer un conteneur pour les images
                node;
            if (!ident) {
                console.error('Cannot generate tiles : identification failed for zoom value "'+z+'"');
                return false;
            }

            if (move === 1 || move === -1) {
                moveContainerAfterZoom(z, move);
            }

            for (i = 1; i <= zoom.max; i++) {
                nodeContainer = document.getElementById('zoomContainer'+i);
                if (nodeContainer) {
                    if (i > z) {
                        nodeContainer.classList.add('hide');
                    } else {
                        nodeContainer.classList.remove('hide');
                    }
                }
                f_zoomContainer(i, z / i);
            }

            nodeContainer = document.getElementById('zoomContainer'+z);

            if (nodeContainer) {
                nodeContainer.classList.remove('hide');
            } else {
                nodeContainer = document.createElement('div');// Création du nodeContainer
                nodeContainer.id = 'zoomContainer'+z;
                nodeContainer.setAttribute('data-zoom-level', z);
                nodeContainer.classList.add('zoom-container');
                nodeContainer.id = 'zoomContainer'+z;
                nodeContainer.style.zIndex = z*100;

                // Bouclage sur toutes les tuiles identifiées par le zoom
                for (var y = 0; y < ymax; y++) {
                    for (var x = 0; x < xmax; x++) {
                        // Création de la balise <img>
                        node = document.createElement('img');
                        node.src = "";
                        node.setAttribute('data-image-src', tilesUrl.replace('{zoom}',z).replace('{y}',y).replace('{x}',x));
                        node.classList.add('map-image');
                        node.style.top = (y * imgSize) + 'px';
    //                    node.width = imgSize;
    //                    node.height = imgSize;
                        node.style.left = (x * imgSize) + 'px';
                        node.id = 'tile_'+z+'_'+y+'_'+x;
                        nodeContainer.appendChild(node);// Ajout de cette image au nodeContainer
                    }
                }
                container.appendChild(nodeContainer);// Ajout du nodeContainer au container général de la map
            }
            resetHeight();//Redéfinition de la hauteur (au cas où)
            clearTimeout(timeouts.showImages);
            timeouts.showImages = setTimeout(showImages, 1000);
        };

        function moveContainer(x, y) {

        };

        function moveContainerAfterZoom(z, move) {
            var ident = identify(z);
            var relatedIdent = identify(z - move);
            var offsetX = $(container).position().left - ( ( parseInt(ident.wmax) - parseInt(relatedIdent.wmax) ) / 2 );
            var offsetY = $(container).position().top  - ( ( parseInt(ident.hmax) - parseInt(relatedIdent.hmax) ) / 2 );

            $(container).animate({
                'left': offsetX+'px',
                'top': offsetY+'px'
            }, {
                duration:200,
                queue:false
            });
        };

        // Cette fonction effectue une boucle sur toutes les images qui n'ont pas d'attribut "src"
        // Elle leur attribue un attribut "src" pour pouvoir les afficher
        function showImages() {
            $('img.map-image[src=""]').filter(function(){
                var	x = $(this).offset().left - $(wrapper).offset().left,
                    y = $(this).offset().top - $(wrapper).offset().top,
                    w = $(wrapper).width(),
                    h = $(wrapper).height();

                var top_left_x	= x > 0 && x < w,
                    top_left_y	= y > 0 && y < h,
                    top_right_x	= x + imgSize > 0 && x + imgSize < w,
                    top_right_y	= top_left_y,
                    bot_left_x	= top_left_x,
                    bot_left_y	= y + imgSize > 0 && y + imgSize < h,
                    bot_right_x	= top_right_x,
                    bot_right_y	= bot_left_y,

                    top_left = top_left_x && top_left_y,
                    top_right = top_right_x && top_right_y,
                    bot_left = bot_left_x && bot_left_y,
                    bot_right = bot_right_x && bot_right_y
                ;

                return top_left || top_right || bot_left || bot_right;
            }).attr('src',function(){return this.getAttribute('data-image-src');});
        };

        // Cette fonction retourne l'identification d'un zoom
        function identify(z) {
            return identifications[(z ? z : zoom.current)];
        };

        // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
        function resetHeight() {
            var id = identify(zoom.current);
            if (!id) {
                return false;
            }
            $(wrapper).height(
                $(window).height()
                - $('#footer').outerHeight(true)
                - $('#navigation').outerHeight(true));
            $(container).width(id.wmax).height(id.hmax);
        };

        // Effectue un zoom avant
        function zoomIn() {
            zoom.current++;
            if (zoom.current > zoom.max) { zoom.current = zoom.max; return false; }
            clearTimeout(timeouts.zoom);
            timeouts.zoom = setTimeout(function(){f_generateTiles(zoom.current, 1);}, 200);
        };

        // Effectue un zoom arrière
        function zoomOut() {
            zoom.current--;
            if (zoom.current < 1) { zoom.current = 1; return false; }
            clearTimeout(timeouts.zoom);
            timeouts.zoom = setTimeout(function(){f_generateTiles(zoom.current, -1);}, 200);
        };

        //parseInt($('#navigation').css('margin-bottom').replace('px',''))//Marge top
    }
    window.Map = Map;
})(jQuery);