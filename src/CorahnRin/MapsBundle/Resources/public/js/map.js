function Map() {

    var _this = this;
    var id = document.getElementById('map_container').getAttribute('data-map-id');
    id = !isNaN(parseInt(id)) ? parseInt(id) : null;
    var zoom = { "current": 1, "max": 0 };
    var name = '';
    var nameSlug = '';
    var position = { "top" : 0, "left" : 0 };
    var initUrl = document.getElementById('map_container').getAttribute('data-init-url');
    var tilesUrl = '';
    var identifications = {};
    var wrapper = null;
    var wrapperSize = { "width": 0, "height": 0 };
    var container = null;
    var visible_tiles = [];

    if (document.getElementById('map_wrapper')) {
        wrapper = document.getElementById('map_wrapper');
        console.info('Map wrapper initialized');
    }
    if (document.getElementById('map_container')) {
        container = document.getElementById('map_container');
        console.info('Map container initialized');
    }


    // Initialisation
    $.ajax({
        "url": initUrl,
        "dataType": "json",
        "type": "post",
        "data" : { "id" : id },
        "success": function(data) {
            if (data.id) {
                name = data.name;
                nameSlug = data.name;
                identifications = data.identifications;
                zoom.max = data.maxZoom;
                imgSize = data.imgSize;
                tilesUrl = data.tilesUrl;
                console.info(data);
                console.info('Map generated');
            }
        }
    });

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
        if (type === 'left') { return position.left; }
        else if (type === 'top') { return position.top; }
        else { return position; }
    };

    var generateTiles = function () {
        var xstart = ystart = 0,
            ident = identify(),
            xmax = ident.xmax,
            ymax = ident.ymax,
            wmax = ident.wmax,
            hmax = ident.hmax,
            vis = visible_tiles,
            z = zoom.current,
            node;
        if (!vis[z]) { vis[z] = []; }
        for (var y = ystart; y <= ymax; y++) {
            if (!vis[z][y]) { vis[z][y] = []; }
            for (var x = xstart; x <= xmax; x++) {
                if (!vis[z][y][x]) {
                    // Création de la balise <img>
                    node = document.createElement('img');
                    node.src = tilesUrl.replace('{zoom}',z).replace('{y}',y).replace('{x}',x);
                    node.style.top = (y * imgSize) + 'px';
                    node.style.left = (x * imgSize) + 'px';
                    node.id = 'tile_'+zoom+'_'+y+'_'+x;
                    container.appendChild(node);
                    vis[z][y][x] = true;
                }
            }
        }
    };
    this.generateTiles = function() { return generateTiles(); };

    function identify() {
        return identifications[zoom.current];
    }

    function setWrapperSize() {
        wrapperSize.width = $(wrapper).width();
        wrapperSize.height = $(wrapper).height();
        return _this;
    }

    function setPosition() {
//        position.top = container.style
    }

    $(container)
        .mousedown(function(){this.classList.add('map_mousedown_active');})
        .mouseup(function(){this.classList.remove('map_mousedown_active')})
        .mouseover(function(e){console.info(e);});

    //parseInt($('#navigation').css('margin-bottom').replace('px',''))//Marge top
}