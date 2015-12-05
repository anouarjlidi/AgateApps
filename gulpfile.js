/**
 * Gulp file to use to manage assets
 */
var gulp         = require('gulp'),
    gulpif       = require('gulp-if'),
    watch        = require('gulp-watch'),
    less         = require('gulp-less'),
    concat       = require('gulp-concat'),
    uglyfly      = require('gulp-uglyfly'),
    minifycss    = require('gulp-minify-css'),
    sourcemaps   = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer')
;

var config = {
    "output_directory": "web",
    "less": {
        "css/fontawesome.css": [
            "src/Esteren/PortalBundle/Resources/public/less/_fontawesome.less"
        ],
        "css/global.css": [
            "src/Esteren/PortalBundle/Resources/public/less/_main.less"
        ],
        "css/maps_less.css": [
            "src/EsterenMaps/MapsBundle/Resources/public/css/maps.less"
        ]
    },
    "css": {
        "css/maps_lib.css": [
            "web/components/leaflet/dist/leaflet.css",
            "web/components/leaflet-draw/dist/leaflet.draw.css",
            "web/components/leaflet-sidebar/src/L.Control.Sidebar.css",
            "web/css/maps_less.css"
        ],
        "css/generator.css": [
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/css/*.css"
        ]
    },
    "js": {
        "js/global.js": [
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
        "js/maps_lib.js": [
            "web/components/leaflet/dist/leaflet-src.js",
            "web/components/leaflet-sidebar/src/L.Control.Sidebar.js",
            "web/components/leaflet-draw/dist/leaflet.draw-src.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/*.js"
        ],
        "js/map_edit_more.js": [
            "src/EsterenMaps/MapsBundle/Resources/public/js/map_edit.js"
        ],
        "js/generator.js": [
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/js/*.js"
        ]
    }
};

var isProd = process.argv.indexOf('--prod') >= 0;

/*************** Gulp tasks ***************/

/**
 * Dumps the LESS assets
 */
gulp.task('less', function() {
    var list = config.less,
        outputDir = config.output_directory+'/',
        assets_output, assets, pipes, i, l
    ;
    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pipes = gulp
            .src(assets)
            .pipe(less())
            .pipe(concat(assets_output))
            .pipe(autoprefixer())
            .pipe(gulpif(isProd, minifycss({
                keepBreaks: false,
                keepSpecialComments: 0
            })))
            .pipe(concat(assets_output))
            .pipe(gulp.dest(outputDir))
        ;

        console.info(" [file+] "+assets_output+" >");
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }
});

/**
 * Dumps the CSS assets.
 */
gulp.task('css', function() {
    var list = config.css,
        outputDir = config.output_directory+'/',
        assets_output, assets, pipes, i, l
        ;
    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pipes = gulp
            .src(assets)
            .pipe(concat(assets_output))
            .pipe(autoprefixer())
            .pipe(gulpif(isProd, minifycss({
                keepBreaks: false,
                keepSpecialComments: 0
            })))
            .pipe(concat(assets_output))
            .pipe(gulp.dest(outputDir))
        ;

        console.info(" [file+] "+assets_output+" >");
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }
});

/**
 * Dumps the JS assets
 */
gulp.task('js', function() {
    var list = config.js,
        outputDir = config.output_directory+'/',
        assets_output, assets, pipes, i, l
        ;
    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pipes = gulp
            .src(assets)
            .pipe(sourcemaps.init())
            .pipe(concat({path: assets_output, cwd: ''}))
            .pipe(gulpif(isProd, uglyfly()))
            .pipe(gulp.dest(outputDir))
        ;

        console.info(" [file+] "+assets_output+" >");
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }
});

/**
 * Will watch for files and run "dump" for each modification
 */
gulp.task('watch', function() {
    var less = [],
        css = [],
        js = [],
        callback = function(event) {
            console.log('File "' + event.path + '" updated');
        },
        i;
    console.info('Watch start at ' + (new Date));

    for (i in config.less) {
        if (!config.less.hasOwnProperty(i)) { continue; }
        less.push(config.less[i]);
    }
    for (i in config.css) {
        if (!config.css.hasOwnProperty(i)) { continue; }
        css.push(config.css[i]);
    }
    for (i in config.js) {
        if (!config.js.hasOwnProperty(i)) { continue; }
        js.push(config.js[i]);
    }

    gulp.watch(less, ['less']).on('change', callback);
    gulp.watch(css, ['css']).on('change', callback);
    gulp.watch(js, ['js']).on('change', callback);

});

/**
 * Runs all the needed commands to dump all assets and manifests
 */
gulp.task('dump', ['less', 'css', 'js']);

/**
 * Small user guide
 */
gulp.task('default', function(){
    console.info("");
    console.info("usage: gulp [command] [--prod]");
    console.info("Options:");
    console.info("    --prod       If specified, will run some minifycss and uglyfyjs when dumping the assets.");
    console.info("");
    console.info("Commands:");
    console.info("    less         Dumps the Less assets to the \"css\" output directory.");
    console.info("    css          Dumps the CSS assets to the \"css\" output directory.");
    console.info("    js           Dumps the JS assets to the \"js\" output directory.");
    console.info("    dump         Executes all the above commands.");
    console.info("    watch        Watches all assets to dump them all when one is modified.");
    console.info("");
});