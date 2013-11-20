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
    var timeouts = { 
        "zoom": null, "generate": null };
    var wrapperSize = { "width": 0, "height": 0 };
    var container = null;
    var visible_tiles = [];

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
                generateTiles(1);
            }
        }
    });

    if (document.getElementById('map_wrapper')) {
        wrapper = document.getElementById('map_wrapper');
    }
    if (document.getElementById('map_container')) {
        container = document.getElementById('map_container');
    }

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
    
    var zoomContainer = function(containerId, scale) {
        if (document.getElementById('zoomContainer'+containerId)) {
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
    this.zoomContainer = function(id, scale) { zoomContainer(id, scale); };

    var generateTiles = function (z) {
        if (timeouts['generate']) {
            clearTimeout(timeouts['generate']);
        } else {
            timeouts['generate'] = null;
        }
        var f = function(z){
            var xstart = ystart = 0,
                ident = identify(z),
                xmax = ident.xmax,
                ymax = ident.ymax,
                wmax = ident.wmax,
                hmax = ident.hmax,
//                vis = visible_tiles,
                nodeContainer = document.createElement('div'),
                node;
            if (!ident) {
                console.error('Identification failed for zoom '+z);
                return false;
            }
            z = z ? z : zoom.current;
            zoom.current = z;
//            if (!vis[z]) { vis[z] = []; }
            nodeContainer.setAttribute('data-zoom-level', z);
            nodeContainer.classList.add('zoom-container');
            nodeContainer.id = 'zoomContainer'+z;
            nodeContainer.style.zIndex = z*100;
            
            for (i = 1; i <= zoom.max; i++) {
                if (i > z) {
                    document.getElementById('zoomContainer'+z).classList.add('hide');
                } else {
                    document.getElementById('zoomContainer'+z).classList.remove('hide');
                }
                zoomContainer(i, z / i);
            }

            if (document.getElementById('zoomContainer'+z)) {
                document.getElementById('zoomContainer'+z).classList.remove('hide');
            } else {
                for (var y = ystart; y < ymax; y++) {
                    for (var x = xstart; x < xmax; x++) {
                        node = document.createElement('img');
                        node.src = "";
                        node.setAttribute('data-image-src', tilesUrl.replace('{zoom}',z).replace('{y}',y).replace('{x}',x));
                        node.classList.add('map-image');
                        node.style.top = (y * imgSize) + 'px';
                        node.style.left = (x * imgSize) + 'px';
                        node.id = 'tile_'+z+'_'+y+'_'+x;
                        nodeContainer.appendChild(node);
                    }
                }
                container.appendChild(nodeContainer);
            }
            resetHeight();
        };
        timeouts['generate'] = setTimeout(function(){f(z);}, 200);
    };
    this.generateTiles = function(z) { return generateTiles(z); };

    var identify = function(z) {
        return identifications[(z ? z : zoom.current)];
    };
    this.identify = identify;

    var setWrapperSize = function() {
        wrapperSize.width = $(wrapper).width();
        wrapperSize.height = $(wrapper).height();
        return _this;
    };
    this.setWrapperSize = setWrapperSize;

    var resetHeight = function() {
        var id = identify();
        $(wrapper).height(
            $(window).height()
            - $('#footer').outerHeight(true)
            - $('#navigation').outerHeight(true));
        $(container).width(id.wmax).height(id.hmax);
    };

    var zoomIn = function() {
        zoom.current++;
        if (zoom.current > zoom.max) { zoom.current = zoom.max; }
        clearTimeout(timeouts.zoom);
        timeouts.zoom = setTimeout(function(){generateTiles(zoom.current);}, 200);
    };
    this.zoomIn = zoomIn;

    var zoomOut = function() {
        zoom.current--;
        if (zoom.current < 1) { zoom.current = 1; }
        clearTimeout(timeouts.zoom);
        timeouts.zoom = setTimeout(function(){generateTiles(zoom.current);}, 200);
    };
    this.zoomOut = zoomOut;

    var setPosition = function() {
//        position.top = container.style
    };
    this.setPosition = setPosition;

    $(container).draggable({
        addClasses: false
    });

    $(wrapper).mousewheel(function(event, delta, deltaX, deltaY) {
            if (delta > 0) {
                //Up
                zoomIn();
            } else if (delta < 0) {
                //Down
                zoomOut();
            }
            return false; // prevent default
        });


    //parseInt($('#navigation').css('margin-bottom').replace('px',''))//Marge top
}