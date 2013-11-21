function Map() {

    var _this = this;
    var id = document.getElementById('map_container').getAttribute('data-map-id');
    if (isNaN(id)) { console.error('Cannot generate map : wrong id'); }
    var zoom = { "current": 1, "max": 0 };// Le zoom actuel et le zoom maximum récupéré par ajax
    var name = '';
    var nameSlug = '';
    var initUrl = document.getElementById('map_container').getAttribute('data-init-url');// Url à envoyer avec ajax pour initialiser la carte
    var tilesUrl = '';// Url de chargement des tuiles. Elle est récupérée par ajax
    var identifications = {};// La liste des identifications organisées par zoom et récupérées par ajax (nombre de tuiles, dimensions en pixels, etc.)
    var timeouts = { "zoom": null };// Définition de quelques timeouts, ils seront utilisés pour les actions nécessitant une sécurité temporelle
    var wrapperSize = { "width": 0, "height": 0 };// La taille du wrapper, sera modifiée au redimensionnement
    var wrapper = null;
    var container = null;
    var imgSize;

    // Initialisation
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
                generateTiles(1);
            }
        }
    });

    // Initialisation du wrapper et du container
    if (document.getElementById('map_wrapper'))   { wrapper = document.getElementById('map_wrapper'); }
    if (document.getElementById('map_container')) { container = document.getElementById('map_container'); }
    if (!wrapper || !container) {
        console.error('Cannot generate map : failed identification of wrapper and container');
        return;
    }



    // Getters
    this.id              = function() { return id; };
    this.name            = function() { return name; };
    this.nameSlug        = function() { return nameSlug; };
    this.initUrl         = function() { return initUrl; };
    this.container       = function() { return container; };
    this.wrapper         = function() { return wrapper; };
    this.tilesUrl        = function() { return tilesUrl; };
    this.imgSize         = function() { return imgSize; };
    this.identifications = function() { return identifications; };
    this.identify        = function() { return identify(); };
    this.zoom            = function(type) {
        if (type === 'current') { return zoom.current; }
        else if (type === 'max') { return zoom.max; }
        else { return zoom; }
    };
    this.position        = function(type) {
        if (type === 'left') { return $(container).offset().left; }
        else if (type === 'top') { return $(container).offset().top; }
        else { return position; }
    };



    // Cette fonction redéfinit le zoom d'un container grâce à son id et à l'échelle mentionnée
    var zoomContainer = function(containerId, scale) {
        if (isNaN(containerId)) {
            console.error('Cannot zoom on map : wrong zoom level injected to zoom function');
            return;
        }

        if (document.getElementById('zoomContainer'+containerId)) {
            // Le style est systématiquement redéfini pour palier aux éventuels mauvais ajouts de css
            document
                .getElementById('zoomContainer'+containerId)
                .setAttribute('style',
                'z-index:'+(containerId*10)    +';'+
                '-webkit-transform:scale(' + scale + ');' +
                '-moz-transform:scale(' + scale + ');' +
                '-ms-transform:scale(' + scale + ');' +
                '-o-transform:scale(' + scale + ');' +
                'transform:scale(' + scale + ');');

        }
    };
//    this.zoomContainer = function(id, scale) { zoomContainer(id, scale); };//Fonction publique pour zoomer un container



    // Cette fonction va générer toutes les balises <img>, sans pour autant charger toutes les images
    // Elle se base sur le zoom actuel ou sur un zoom prédéfini (pour les options cliquables)
    var generateTiles = function (z, move) {
        // Setter du zoom
        zoom.current = (z ? z : zoom.current);
        var ident = identify(z),// Identification du zoom demandé
            move = move ? true : false,
            xmax = ident.xmax,
            ymax = ident.ymax,
            wmax = ident.wmax,
            hmax = ident.hmax,
            nodeContainer,// Cette variable sera utilisée pour créer un conteneur pour les images
            node;
        if (!ident) {
            console.error('Cannot generate tiles : identification failed for zoom value "'+z+'"');
            return false;
        }

        if (move) {
            moveContainer(z, move);
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
            zoomContainer(i, z / i, move);
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
        showImages();
    };
    this.generateTiles = function(z, move) { return generateTiles(z, move); };

    var moveContainer = function(z, move) {
        var ident = identify(z), relatedIdent = identify(z - move);
        $(container).animate({
            'top': (move == 1 ? '-='+( (ident.hmax - relatedIdent.hmax) / 2 ) : '+='+( (relatedIdent.hmax - ident.hmax) / 2 )),
            'left': (move == 1 ? '-='+( (ident.wmax - relatedIdent.wmax) / 2 ) : '+='+( (relatedIdent.wmax - ident.wmax) / 2 ))
        }, 250);
        relatedIdent = {
            'top' : (move == 1 ? '-='+( (ident.hmax - relatedIdent.hmax) / 2 ) : '+='+( (relatedIdent.hmax - ident.hmax) / 2 )) + 'px',
            'left' : + (move == 1 ? '-='+( (ident.wmax - relatedIdent.wmax) / 2 ) : '+='+( (relatedIdent.wmax - ident.wmax) / 2 )) + 'px'
        };
        container.setAttribute('style',
            '-webkit-transform:translate(' + relatedIdent + ');' +
            '-moz-transform:translate(' + relatedIdent + ');' +
            '-ms-transform:translate(' + relatedIdent + ');' +
            '-o-transform:translate(' + relatedIdent + ');' +
            'transform:translate(' + relatedIdent + ');'
        );
    }

    // Cette fonction effectue une boucle sur toutes les images qui n'ont pas d'attribut "src"
    // Elle leur attribue un attribut "src" pour pouvoir les afficher
    var showImages = function() {
        $('img.map-image[src=""]')
            .filter(function(){
                return ($(this).offset().top < ($('#map_wrapper').height() + imgSize))
                        && ($(this).offset().top > 0)
                        && ($(this).offset().left < ($('#map_wrapper').width() + imgSize))
                        && ($(this).offset().left > 0);
            })
            .attr('src', function(){
                return this.getAttribute('data-image-src')
            });
    };
    this.showImages = showImages;

    // Cette fonction retourne l'identification d'un zoom
    var identify = function(z) {
        return identifications[(z ? z : zoom.current)];
    };
    this.identify = identify;

//    var setWrapperSize = function() {
//        wrapperSize.width = $(wrapper).width();
//        wrapperSize.height = $(wrapper).height();
//        return _this;
//    };
//    this.setWrapperSize = setWrapperSize;

    // Remet la valeur de la hauteur de façon correcte par rapport au navigateur.
    var resetHeight = function() {
        var id = identify();
        $(wrapper).height(
            $(window).height()
            - $('#footer').outerHeight(true)
            - $('#navigation').outerHeight(true));
        $(container).width(id.wmax).height(id.hmax);
    };

    // Effectue un zoom avant
    var zoomIn = function() {
        zoom.current++;
        if (zoom.current > zoom.max) { zoom.current = zoom.max; }
        clearTimeout(timeouts.zoom);
        timeouts.zoom = setTimeout(function(){generateTiles(zoom.current, 1);}, 200);
    };
    this.zoomIn = zoomIn;

    // Effectue un zoom arrière
    var zoomOut = function() {
        zoom.current--;
        if (zoom.current < 1) { zoom.current = 1; }
        clearTimeout(timeouts.zoom);
        timeouts.zoom = setTimeout(function(){generateTiles(zoom.current, -1);}, 200);
    };
    this.zoomOut = zoomOut;

    // Permet à la carte de se déplacer
    $(container).draggable({
        addClasses: false,// Gagne un peu de mémoire
        drag: showImages// Teste l'affichage des images à chaque déplacement, pour afficher les images invisibles
    });


    // Utilise le plugin mousewheel pour effectuer un zoom dynamique
    $(wrapper).mousewheel(function(event, delta, deltaX, deltaY) {
        if (delta > 0) { zoomIn(); }
        else if (delta < 0) { zoomOut(); }
        return false; // prevent default
    });


    //parseInt($('#navigation').css('margin-bottom').replace('px',''))//Marge top
}