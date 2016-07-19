/*
There here is YOUR config
This var is an example of the assets you can use in your own application.
The array KEYS correspond to the OUTPUT files/directories,
The array VALUES contain a LIST OF SOURCE FILES
*/
var config = {

    // The base output directory for all your assets
    "output_directory": "web",

    /**
     * Here you can add other files to watch when using "gulp watch".
     * They will automatically run the "dump" command when modified.
     * It is VERY useful when you use massively less/sass "import" rules, for example.
     * Example:
        "src/AppBundle/Resources/public/less/*.less"
     */
    "files_to_watch": [
        "src/Esteren/PortalBundle/Resources/public/less/*.less",
        "src/CorahnRin/CorahnRinBundle/Resources/public/generator/css/*.less"
    ],

    /**
     * All files here are images that will be optimized/compressed with imagemin.
     * The key corresponds to the output directory (prepended with "output_directory" previous option).
     * Example:
        "images/": [
            "src/AppBundle/Resources/public/images/*"
        ]
     */
    "images": {
        "img/markerstypes": [
            "src/EsterenMaps/MapsBundle/Resources/public/img/markerstypes/*"
        ]
    },

    /**
     * All files from this section are parsed with LESS plugin and dumped into a CSS file.
     * If using "--prod" in command line, will minify with "clean-css".
     * Example:
        "css/main_less.css": [
            "web/components/bootstrap/less/bootstrap.less",
            "src/AppBundle/Resources/public/less/main.less"
        ]
     */
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
        ],
        "css/generator.css": [
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/css/main_steps.less"
        ]
    },

    /**
     * All files from this section are parsed with SASS plugin and dumped into a CSS file.
     * If using "--prod" in command line, will minify with "clean-css".
     * Example:
        "css/main_sass.css": [
            "src/AppBundle/Resources/public/less/main.scss"
        ]
     */
    "sass": {
    },

    /**
     * All files from this section are just concatenated and dumped into a CSS file.
     * If using "--prod" in command line, will minify with "clean-css".
     * Example:
        "css/main.css": [
            "src/AppBundle/Resources/public/css/main.css"
        ]
     */
    "css": {
    },

    /**
     * All files from this section are just concatenated and dumped into a JS file.
     * If using "--prod" in command line, will minify with "uglyflyjs".
     * Example:
        "js/main.js": [
            "web/components/bootstrap/dist/bootstrap-src.js",
            "src/AppBundle/Resources/public/css/main.js"
        ]
     */
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
            "src/Esteren/PortalBundle/Resources/public/js/corahn_rin.js",
            "src/Esteren/PortalBundle/Resources/public/js/helpers.js"
        ],
        "js/maps_lib.js": [
            "web/components/leaflet/dist/leaflet-src.js",
            "web/components/leaflet-sidebar/src/L.Control.Sidebar.js",
            "web/components/leaflet-draw/dist/leaflet.draw-src.js",
            "src/EsterenMaps/MapsBundle/Resources/public/js/EsterenMap/*.js"
        ],
        "js/generator.js": [
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/js/main_steps.js"
        ],
        "js/step_03_birthplace.js": [
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/js/step_03_birthplace.js"
        ],
        "js/step_11_advantages.js": [
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/js/step_11_advantage_class.js",
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/js/step_11_functions.js",
            "src/CorahnRin/CorahnRinBundle/Resources/public/generator/js/step_11_advantages_process.js"
        ]
    }
};

/*************** End config ***************/

// Everything AFTER this line of code is updatable to the latest version of this gulpfile.
// Check it out there if you need: https://github.com/Orbitale/Gulpfile

/************* Some helpers *************/

var GulpfileHelpers = {};
GulpfileHelpers.objectSize = function(object) {
    var size = 0, key;
    for (key in object) {
        if (object.hasOwnProperty(key)) {
            size++;
        }
    }
    return size;
};

GulpfileHelpers.objectForEach = function(object, callback) {
    var key;
    for (key in object) {
        if (object.hasOwnProperty(key)) {
            callback.apply(object, [key, object[key]]);
        }
    }
    return object;
};

/*************** Global vars ***************/

// These data are mostly used to introduce logic that will save memory and time.
var isProd    = process.argv.indexOf('--prod') >= 0;
var hasImages = GulpfileHelpers.objectSize(config.images) > 0;
var hasLess   = GulpfileHelpers.objectSize(config.less) > 0;
var hasSass   = GulpfileHelpers.objectSize(config.sass) > 0;
var hasCss    = GulpfileHelpers.objectSize(config.css) > 0;
var hasJs     = GulpfileHelpers.objectSize(config.js) > 0;

// Required extensions
var gulp       = require('gulp');
var gulpif     = require('gulp-if');
var watch      = require('gulp-watch');
var concat     = require('gulp-concat');
var uglyfly    = require('gulp-uglyfly');
var cleancss   = require('gulp-clean-css');
var sourcemaps = require('gulp-sourcemaps');

// Load other extensions only when having specific components. Saves memory & time execution.
var less     = hasLess   ? require('gulp-less')     : function(){ return {}; };
var sass     = hasSass   ? require('gulp-sass')     : function(){ return {}; };
var imagemin = hasImages ? require('gulp-imagemin') : function(){ return {}; };

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
 * Compress images.
 * Thanks to @docteurklein.
 */
gulp.task('images', function() {
    var list = config.images,
        outputDir = config.output_directory+'/',
        assets_output, assets, pipes, i, l
    ;
    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pipes = gulp
            .src(assets)
            .pipe(imagemin({
                optimizationLevel: 7,
                progressive: true,
                interlaced: true
            }))
            .pipe(gulp.dest(outputDir + assets_output))
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
        files_images = [],
        files_css = [],
        files_sass = [],
        files_js = [],
        callback = function(event) {
            console.log('File "' + event.path + '" updated');
        },
        other_files_to_watch = config.files_to_watch || [],
        files_to_watch = []
    ;

    console.info('Night gathers, and now my watch begins...');

    GulpfileHelpers.objectForEach(config.images, function(key, images){
        files_images.push(images);
        files_to_watch.push(images);
    });
    GulpfileHelpers.objectForEach(config.less, function(key, less){
        files_less.push(less);
        files_to_watch.push(less);
    });
    GulpfileHelpers.objectForEach(config.sass, function(key, sass){
        files_sass.push(sass);
        files_to_watch.push(sass);
    });
    GulpfileHelpers.objectForEach(config.css, function(key, css){
        files_css.push(css);
        files_to_watch.push(css);
    });
    GulpfileHelpers.objectForEach(config.js, function(key, js){
        files_js.push(js);
        files_to_watch.push(js);
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
    if (hasImages) {
        gulp.watch(files_images, ['images']).on('change', callback);
    }
    if (hasLess) {
        gulp.watch(files_less, ['less']).on('change', callback);
    }
    if (hasSass) {
        gulp.watch(files_sass, ['sass']).on('change', callback);
    }
    if (hasCss) {
        gulp.watch(files_css, ['css']).on('change', callback);
    }
    if (hasJs) {
        gulp.watch(files_js, ['js']).on('change', callback);
    }
});

/**
 * Runs all the needed commands to dump all assets and manifests
 */
var dumpTasks = [];
if (hasImages) { dumpTasks.push('images'); }
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
    console.info("    images       Dumps the sources in the `config.images` parameter from image files.");
    console.info("    less         Dumps the sources in the `config.less` parameter from LESS files.");
    console.info("    sass         Dumps the sources in the `config.sass` parameter from SCSS files.");
    console.info("    css          Dumps the sources in the `config.css` parameter from plain CSS files.");
    console.info("    js           Dumps the sources in the `config.js` parameter from plain JS files.");
    console.info("    dump         Executes all the above commands.");
    console.info("    watch        Executes 'dump', then watches all sources, and dumps all assets once any file is updated.");
    console.info("");
});

// Gulpfile with a single var as configuration.
// License: MIT
// Author: 2016 - Alex "Pierstoval" Rock Ancelet <alex@orbitale.io>
// Repository: https://github.com/Orbitale/Gulpfile
