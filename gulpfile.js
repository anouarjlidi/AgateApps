/**
 * Gulp file to use to manage assets
 */
var fs           = require('fs'),
    glob         = require('glob'),
    gulp         = require('gulp'),
    rev          = require('gulp-rev'),
    less         = require('gulp-less'),
    watch        = require('gulp-watch'),
    concat       = require('gulp-concat'),
    rename       = require('gulp-rename'),
    uglyfly      = require('gulp-uglyfly'),
    minifycss    = require('gulp-minify-css'),
    sourcemaps   = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    handlebars   = require('gulp-compile-handlebars')
;

var assets = {

    "get": function(type) {
        var toReturn = [], i, asset;
        if (!type) {
            console.error('Must specify a type when retrieving assets.');
            return;
        }
        for (i in this) {
            if (this.hasOwnProperty(i) && i !== 'get' && this[i].type === type) {
                asset = this[i];
                if (!asset.name) {
                    asset.name = i;
                }
                toReturn.push(asset);
            }
        }
        return toReturn;
    },

    "sources": function() {
        var toReturn = [], i, asset;
        for (i in this) {
            if (this.hasOwnProperty(i) && i !== 'get') {
                asset = this[i];
                for (j in asset.assets) {
                    toReturn.push(asset.assets[j]);
                }
            }
        }
        return toReturn;
    },

    // CSS
    "esteren_general_less": {
        "type": "less",
        "assets": [
            "src/Esteren/PortalBundle/Resources/public/less/_main.less"
        ],
        "output": "main_less.css"
    },
    "esteren_maps_less": {
        "type": "less",
        "assets": [
            "src/EsterenMaps/MapsBundle/Resources/public/css/maps.less"
        ],
        "output": "maps_lib.css"
    },
    "esteren_general_css": {
        "type": "css",
        "assets": [
            "web/components/leaflet/dist/leaflet.css",
            "web/components/leaflet-draw/dist/leaflet.draw.css",
            "web/components/leaflet-sidebar/src/L.Control.Sidebar.css",
            "web/css/main_less.css"
        ],
        "output": "global.css"
    },

    // JS
    "esteren_general_js": {
        "type": "js",
        "assets": [
            "web/components/bootstrap/js/button.js",
            "web/components/bootstrap/js/collapse.js",
            "web/components/bootstrap/js/dropdown.js",
            "web/components/bootstrap/js/modal.js",
            "web/components/bootstrap/js/tooltip.js",
            "web/components/bootstrap/js/popover.js",
            "web/components/bootstrap/js/transition.js",
            "web/components/bootstrap/js/tab.js",
            "src/Esteren/PortalBundle/Resources/public/js/corahn_rin.js"
        ],
        "output": "global.js"
    },
    "esteren_maps_js": {
        "type": "js",
        "assets": [
            "web/components/leaflet/dist/leaflet-src.js",
            "web/components/leaflet-sidebar/src/L.Control.Sidebar.js",
            "web/components/leaflet-draw/dist/leaflet.draw-src.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/1_EsterenMap.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/2_LeafletDrawOverrides.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/2_EsterenMap_directions.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/3_EsterenMap_options.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/3_EsterenMap_ActivateLeafletDraw.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/4_EsterenMap_addMarker.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/4_EsterenMap_addPolyline.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/4_EsterenMap_addPolygon.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/4_EsterenMap_filters.js"
        ],
        "output": "maps_lib.js"
    },
    "esterenmaps_edit_js": {
        "type": "js",
        "assets": [
            "src/EsterenMaps/MapsBundle/Resources/public/js/map_edit.js"
        ],
        "output": "map_edit_more.js"
    }
};

/**
 * Dumps the LESS assets
 */
gulp.task('less', function() {
    var type = 'less',
        list = assets.get(type),
        i, asset
    ;
    for (i in list) {
        asset = list[i];
        gulp
            .src(asset.assets)
            .pipe(less())
            .pipe(autoprefixer())
            .pipe(minifycss({
                keepBreaks: false,
                keepSpecialComments: 0
            }))
            .pipe(concat(asset.output))
            .pipe(gulp.dest('web/css'))
        ;
        console.info('Processed '+type.toUpperCase()+' "'+asset.name+'" to output "web/css/'+asset.output+'"');
    }
});

/**
 * Dumps the CSS assets
 */
gulp.task('css', function() {
    var type = 'css',
        list = assets.get(type),
        i, asset
    ;
    for (i in list) {
        if (!list.hasOwnProperty(i)) { continue; }
        asset = list[i];
        gulp
            .src(asset.assets)
            .pipe(concat(asset.output))
            .pipe(autoprefixer())
            .pipe(minifycss({
                keepBreaks: false,
                keepSpecialComments: 0
            }))
            .pipe(rev())
            .pipe(gulp.dest('web/'+type))
            .pipe(rev.manifest('rev-manifest-'+type+'-'+asset.name+'.json'))
            .pipe(gulp.dest('app/cache/'))
        ;
        console.info('Processed '+type.toUpperCase()+' "'+asset.name+'" to output "web/'+type+'/'+asset.output+'"');
    }
});

/**
 * Dumps the JS assets
 */
gulp.task('js', function() {
    var type = 'js',
        list = assets.get(type),
        i, asset
    ;
    for (i in list) {
        if (!list.hasOwnProperty(i)) { continue; }
        asset = list[i];
        gulp
            .src(asset.assets)
            .pipe(sourcemaps.init())
            .pipe(concat({path: asset.output, cwd: ''}))
            .pipe(uglyfly())
            .pipe(rev())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('web/'+type))
            .pipe(rev.manifest('rev-manifest-'+type+'-'+asset.name+'.json'))
            .pipe(gulp.dest('app/cache/'))
        ;
        console.info('Processed '+type.toUpperCase()+' "'+asset.name+'" to output "web/'+type+'/'+asset.output+'"');
    }

});

/**
 * Dumps the twig templates based on manifest files
 */
gulp.task('manifests', function() {

    glob('app/cache/rev-manifest-*.json', function(err, files) {
        var associations = [],
            manifest, fileName, i, l, k;

        // Retrieve all associations:
        // Key => value
        // Web file => Manifested file
        for (i = 0, l = files.length; i < l; i++) {
            fileName = files[i];
            manifest = JSON.parse(fs.readFileSync(fileName, 'utf8'));
            for (k in manifest) {
                if (!manifest.hasOwnProperty(k)) { continue; }
                associations[k] = manifest[k];
            }
        }

        //TODO
        console.info(associations);
    });

});

// Watcher
gulp.task('watch', function() {

    gulp.watch(assets.sources(), ['dump']).on('change', function(event) {
        console.log('File "'+event.path+'" updated, dump all assets.');
    });

});

gulp.task('default', function(){
    console.info('Available commands:');
    console.info('less');
    console.info('css');
    console.info('js');
    console.info('watch');
    console.info('manifests');
});

gulp.task('dump', ['less', 'css', 'js', 'manifests']);
