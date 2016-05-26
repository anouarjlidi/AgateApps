// There here is YOUR config
// This var is an exemple of the assets you can use in your own application.
// The array KEYS correspond to the OUTPUT files,
// The array VALUES contain a LIST OF SOURCE FILES
var config = {
    "output_directory": "web",
    "files_to_watch": [
        "src/Esteren/PortalBundle/Resources/public/less/*.less"
    ],
    "less": {
        "css/fontawesome.css": [
            "src/Esteren/PortalBundle/Resources/public/less/_fontawesome.less"
        ],
        "css/global.css": [
            "src/Esteren/PortalBundle/Resources/public/less/_main.less"
        ],
        "css/maps_lib.css": [
            "src/EsterenMaps/MapsBundle/Resources/public/less/maps.less"
        ],
        "css/admin.css": [
            "src/AdminBundle/Resources/public/less/admin.less"
        ]
    },
    "sass": {},
    "css": {
        "css/generator.css": [
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/css/*.css"
        ]
    },
    "js": {
        "js/jquery.js": [
            "web/components/jquery/jquery.js"
        ],
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

/*************** End config ***************/
// Everything AFTER this line of code is updatable to the latest version of this gulpfile.
// Check it out there if you need: https://gist.github.com/Pierstoval/9d88b0dcb64f30eff4dc

/************* Some polyfills *************/

Object.prototype.p_size = function() {
    var size = 0, key;
    for (key in this) {
        if (this.hasOwnProperty(key)) {
            size++;
        }
    }
    return size;
};

Object.prototype.p_forEach = function(callback) {
    var key;
    for (key in this) {
        if (this.hasOwnProperty(key)) {
            callback.apply(this, [key, this[key]]);
        }
    }
    return this;
};

/*************** Global vars ***************/

var isProd  = process.argv.indexOf('--prod') >= 0,
    hasLess = config.less.p_size() > 0,
    hasSass = config.sass.p_size() > 0,
    hasCss  = config.css.p_size() > 0,
    hasJs   = config.js.p_size() > 0
    ;

// Required extensions
var gulp         = require('gulp'),
    gulpif       = require('gulp-if'),
    watch        = require('gulp-watch'),
    less         = require('gulp-less'),
    sass         = require('gulp-sass'),
    concat       = require('gulp-concat'),
    uglyfly      = require('gulp-uglyfly'),
    cleancss     = require('gulp-clean-css'),
    sourcemaps   = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer')
;

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
            .pipe(gulpif(isProd, cleancss()))
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
 * Dumps the SASS assets
 */
gulp.task('sass', function() {
    var list = config.sass,
        outputDir = config.output_directory+'/',
        assets_output, assets, pipes, i, l
    ;
    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pipes = gulp
            .src(assets)
            .pipe(sass())
            .pipe(concat(assets_output))
            .pipe(autoprefixer())
            .pipe(gulpif(isProd, cleancss()))
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
            .pipe(gulpif(isProd, cleancss()))
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
gulp.task('watch', ['dump'], function() {
    var files_less = [],
        files_css = [],
        files_sass = [],
        files_js = [],
        callback = function(event) {
            console.log('File "' + event.path + '" updated');
        },
        other_files_to_watch = config.files_to_watch || [],
        files_to_watch = [];

    console.info('Night gathers, and now my watch begins...');

    config.less.p_forEach(function(key, less){
        files_less.push(config.less[less]);
        files_to_watch.push(config.less[less]);
    });
    config.sass.p_forEach(function(key, sass){
        files_sass.push(config.sass[sass]);
        files_to_watch.push(config.sass[sass]);
    });
    config.css.p_forEach(function(key, css){
        files_css.push(config.css[css]);
        files_to_watch.push(config.css[css]);
    });
    config.js.p_forEach(function(key, js){
        files_js.push(config.js[js]);
        files_to_watch.push(config.js[js]);
    });

    if (files_to_watch.length) {
        console.info('Watching file(s):');
        // Flatten the array
        files_to_watch = [].concat.apply([], files_to_watch).sort();
        console.info("       > "+files_to_watch.join("\n       > "));
    }

    if (other_files_to_watch.length) {
        gulp.watch(other_files_to_watch, ['dump']).on('change', callback);
    }
    if (hasLess) {
        gulp.watch(files_less, ['less']).on('change', callback);
    }
    if (hasSass) {
        gulp.watch(files_sass, ['sass']).on('change', callback);
    }
    if (hasCss.length) {
        gulp.watch(files_css, ['css']).on('change', callback);
    }
    if (hasJs.length) {
        gulp.watch(files_js, ['js']).on('change', callback);
    }
});

/**
 * Runs all the needed commands to dump all assets and manifests
 */
var dumpTasks = [];
if (hasLess) { dumpTasks.push('less'); }
if (hasSass) { dumpTasks.push('sass'); }
if (hasCss) { dumpTasks.push('css'); }
if (hasJs) { dumpTasks.push('js'); }
gulp.task('dump', dumpTasks);

/**
 * Small user guide
 */
gulp.task('default', function(){
    console.info("");
    console.info("usage: gulp [command] [--prod]");
    console.info("");
    console.info("Options:");
    console.info("    --prod       If specified, will run clean-css and uglyfyjs when dumping the assets.");
    console.info("");
    console.info("Commands:");
    console.info("    less         Dumps the sources in the `config.less` parameter from LESS files.");
    console.info("    sass         Dumps the sources in the `config.sass` parameter from SCSS files.");
    console.info("    css          Dumps the sources in the `config.css` parameter from plain CSS files.");
    console.info("    js           Dumps the sources in the `config.js` parameter from plain JS files.");
    console.info("    dump         Executes all the above commands.");
    console.info("    watch        Executes 'dump', then watch all sources, and dump all assets once any file is updated.");
    console.info("");
});

// Gulpfile with a single var as configuration.
// License: MIT
// Author: 2016 - Alex "Pierstoval" Rock Ancelet <alex@orbitale.io>
// Repository: https://github.com/Orbitale/Gulpfile
