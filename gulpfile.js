/*
 * There here is YOUR config
 * This var is an example of the assets you can use in your own application.
 * The array KEYS correspond to the OUTPUT files/directories,
 * The array VALUES contain a LIST OF SOURCE FILES
 */
const config = {

    // The base output directory for all your assets
    "output_directory": "web",

    /**
     * This option is used to simply copy files into a new directory.
     * This is very useful when copying dist files of external components.
     * Example:
     *     "fonts/": [
     *         "node_modules/materialize-css/dist/fonts/*",
     *         "node_modules/bootstrap/dist/fonts/*"
     *     ]
     */
    "copy": {
        "fonts/roboto": [
            "node_modules/materialize-css/dist/fonts/roboto/*"
        ],
        "fonts/": [
            "node_modules/font-awesome/fonts/*",
            "node_modules/bootstrap/dist/fonts/*"
        ],
        "images/": [
            "node_modules/leaflet/dist/images/*"
        ]
    },

    /**
     * Here you can add other files to watch when using "gulp watch".
     * They will automatically run the "dump" command when modified.
     * It is VERY useful when you use massively less/sass "import" rules, for example.
     * Example:
     *     "src/AppBundle/Resources/public/less/*.less"
     */
    "files_to_watch": [
        "src/Esteren/PortalBundle/Resources/assets/less/*.less",
        "src/Esteren/PortalBundle/Resources/assets/css/*.css",
        "src/Esteren/PortalBundle/Resources/assets/sass/*.scss",
        "src/Esteren/PortalBundle/Resources/assets/sass/theme_components/*.scss",
        "src/CorahnRin/CorahnRinBundle/Resources/assets/generator/css/*.less"
    ],

    /**
     * All files here are images that will be optimized/compressed with imagemin.
     * The key corresponds to the output directory (prepended with "output_directory" previous option).
     * Example:
     *     "images/": [
     *         "src/AppBundle/Resources/public/images/*"
     *     ]
     */
    "images": {
        "img/markerstypes": [
            "src/EsterenMaps/MapsBundle/Resources/assets/img/markerstypes/*"
        ],
        "img/generator": [
            "src/CorahnRin/CorahnRinBundle/Resources/assets/img/*"
        ],
        "img/agate": [
            "src/AgateBundle/Resources/assets/images/**"
        ],
        "img/": [
            "src/Esteren/PortalBundle/Resources/assets/images/**"
        ]
    },

    /**
     * All files from this section are parsed with LESS plugin and dumped into a CSS file.
     * If using "--prod" in command line, will minify with "clean-css".
     * Example:
     *     "css/main_less.css": [
     *         "node_modules/bootstrap/less/bootstrap.less",
     *         "src/AppBundle/Resources/public/less/main.less"
     *     ]
     */
    "less": {
        "css/fa.css": [
            "node_modules/font-awesome/less/font-awesome.less"
        ],
        "css/global.css": [
            "src/Esteren/PortalBundle/Resources/assets/less/_main.less"
        ],
        "css/maps_lib.css": [
            "src/EsterenMaps/MapsBundle/Resources/assets/less/maps.less"
        ],
        "css/admin.css": [
            "src/AdminBundle/Resources/assets/less/admin.less"
        ],
        "css/generator.css": [
            "src/CorahnRin/CorahnRinBundle/Resources/assets/generator/css/main_steps.less"
        ],
        "css/character_details.css": [
            "src/CorahnRin/CorahnRinBundle/Resources/assets/generator/css/character_details.less"
        ]
    },

    /**
     * All files from this section are parsed with SASS plugin and dumped into a CSS file.
     * If using "--prod" in command line, will minify with "clean-css".
     * Example:
     *     "css/main_sass.css": [
     *         "src/AppBundle/Resources/public/less/main.scss"
     *     ]
     */
    "sass": {
        "css/global_mat.css": [
            "src/Esteren/PortalBundle/Resources/assets/sass/main.scss"
        ],
        "css/agate.css": [
            "src/AgateBundle/Resources/assets/sass/agate-theme.scss"
        ],
        "css/white_layout.css": [
            "src/Esteren/PortalBundle/Resources/assets/sass/white_layout.scss"
        ]
    },

    /**
     * All files from this section are just concatenated and dumped into a CSS file.
     * If using "--prod" in command line, will minify with "clean-css".
     * Example:
     *     "css/main.css": [
     *         "src/AppBundle/Resources/public/css/main.css"
     *     ]
     */
    "css": {
        "css/initializer.css": [
            "src/Esteren/PortalBundle/Resources/assets/css/initializer.css"
        ],
        "css/feond-beer.css": [
            "src/Esteren/PortalBundle/Resources/assets/css/feond-beer.css"
        ]
    },

    /**
     * All files from this section are just concatenated and dumped into a JS file.
     * If using "--prod" in command line, will minify with "uglifyjs".
     * Example:
     *     "js/main.js": [
     *         "web/components/bootstrap/dist/bootstrap-src.js",
     *         "src/AppBundle/Resources/public/css/main.js"
     *     ]
     */
    "js": {
        "js/jquery.js": [
            "node_modules/jquery/dist/jquery.js"
        ],
        "js/global.js": [
            "node_modules/bootstrap/js/button.js",
            "node_modules/bootstrap/js/collapse.js",
            "node_modules/bootstrap/js/dropdown.js",
            "node_modules/bootstrap/js/modal.js",
            "node_modules/bootstrap/js/tooltip.js",
            "node_modules/bootstrap/js/popover.js",
            "node_modules/bootstrap/js/transition.js",
            "node_modules/bootstrap/js/tab.js",
            "src/Esteren/PortalBundle/Resources/assets/js/corahn_rin.js",
            "src/Esteren/PortalBundle/Resources/assets/js/helpers.js"
        ],
        "js/global_mat.js": [
            "node_modules/materialize-css/dist/js/materialize.js",
            "src/AgateBundle/Resources/assets/js/connect.js",
            "src/Esteren/PortalBundle/Resources/assets/js/helpers.js",
            "src/Esteren/PortalBundle/Resources/assets/js/global_mat.js"
        ],
        "js/maps_lib.js": [
            "node_modules/leaflet/dist/leaflet-src.js",
            "web/components/leaflet-sidebar/src/L.Control.Sidebar.js",
            "node_modules/leaflet-draw/dist/leaflet.draw-src.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/1_EsterenMap.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/1_EsterenMap.load.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/2_EsterenMap_CRS_XY.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/2_EsterenMap_directions.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/2_EsterenMap_LatLngBounds.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/3_EsterenMap_ActivateLeafletDraw.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/3_EsterenMap_options.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/4_EsterenMap_markers.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/4_EsterenMap_polygons.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/4_EsterenMap_polylines.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/4_EsterenMap_filters.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/4_EsterenMap_search_engine.js",
            "src/EsterenMaps/MapsBundle/Resources/assets/js/EsterenMap/5_EsterenMap_mapEdit.js"
        ],
        "js/generator.js": [
            "src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/main_steps.js"
        ],
        "js/step_03_birthplace.js": ["src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_03_birthplace.js"],
        "js/step_11_advantages.js": [
            "src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_11_advantage_class.js",
            "src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_11_functions.js",
            "src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_11_advantages_process.js"
        ],
        "js/step_13_primary_domains.js": ["src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_13_primary_domains.js"],
        "js/step_14_use_domain_bonuses.js": ["src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_14_use_domain_bonuses.js"],
        "js/step_15_domains_spend_exp.js": ["src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_15_domains_spend_exp.js"],
        "js/step_16_disciplines.js": ["src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_16_disciplines.js"],
        "js/step_17_combat_arts.js": ["src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_17_combat_arts.js"],
        "js/step_18_equipment.js": ["src/CorahnRin/CorahnRinBundle/Resources/assets/generator/js/step_18_equipment.js"]
    }
};

/*************** End config ***************/

// Everything AFTER this line of code is updatable to the latest version of this gulpfile.
// Check it out there if you need: https://github.com/Orbitale/Gulpfile

/************* Some helpers *************/

var GulpfileHelpers = {};

/**
 * @param {Object} object
 * @returns {Number}
 */
GulpfileHelpers.objectSize = function(object) {
    "use strict";
    let size = 0;

    for (let key in object) {
        if (object.hasOwnProperty(key)) {
            size++;
        }
    }

    return size;
};

/**
 * @param {Object} object
 * @param {Function} callback
 * @returns {Object}
 */
GulpfileHelpers.objectForEach = function(object, callback) {
    "use strict";
    for (let key in object) {
        if (object.hasOwnProperty(key)) {
            callback.apply(object, [key, object[key]]);
        }
    }

    return object;
};

/*************** Global vars ***************/

// These data are mostly used to introduce logic that will save memory and time.
const isProd    = process.argv.indexOf('--prod') >= 0;
const hasImages = GulpfileHelpers.objectSize(config.images) > 0;
const hasCopy   = GulpfileHelpers.objectSize(config.copy) > 0;
const hasLess   = GulpfileHelpers.objectSize(config.less) > 0;
const hasSass   = GulpfileHelpers.objectSize(config.sass) > 0;
const hasCss    = GulpfileHelpers.objectSize(config.css) > 0;
const hasJs     = GulpfileHelpers.objectSize(config.js) > 0;

// Required extensions
const fs         = require('fs');
const path       = require('path');
const pump       = require('pump');
const glob       = require('glob');
const gulp       = require('gulp4');
const gulpif     = require('gulp-if');
const watch      = require('gulp-watch');
const concat     = require('gulp-concat');
const uglify     = require('gulp-uglify');
const cleancss   = require('gulp-clean-css');

// Load other extensions only when having specific components. Saves memory & time execution.
const less     = hasLess   ? require('gulp-less')     : function(){ return {}; };
const sass     = hasSass   ? require('gulp-sass')     : function(){ return {}; };
const imagemin = hasImages ? require('gulp-imagemin') : function(){ return {}; };

/************** Files checks **************/

var erroredFiles = [];

var checkCallback = function(key, values) {
    values.forEach(function(fileName) {
        try {
            // Remove wildcards
            fileName = fileName.replace(/(?:(?:\*\.\w{2,4}(?:$|\/))|(?:\/\*+(?:$|\/)))/gi, '');
            fs.statSync(fileName);
        } catch (e) {
            if (e.code === 'ENOENT' || (e.message && e.message.match(/no such file/i)) || String(e).match(/no such file/i)) {
                erroredFiles.push(fileName);
            } else {
                throw e;
            }
        }
    })
};

GulpfileHelpers.objectForEach(config.css, checkCallback);
GulpfileHelpers.objectForEach(config.js, checkCallback);
GulpfileHelpers.objectForEach(config.images, checkCallback);
GulpfileHelpers.objectForEach(config.copy, checkCallback);
GulpfileHelpers.objectForEach(config.sass, checkCallback);
GulpfileHelpers.objectForEach(config.less, checkCallback);

if (erroredFiles.length) {
    process.stderr.write("\nMissing input files: \n"+erroredFiles.join("\n")+"\n");
    process.exit(1);
}

/*************** Gulp tasks ***************/

/**
 * Dumps the LESS assets
 */
gulp.task('less', function(done) {
    "use strict";

    let list = config.less,
        outputDir = config.output_directory+'/',
        assets_output, assets, i, l,
        outputCount = GulpfileHelpers.objectSize(list),
        pipesDone = 0
    ;

    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pump([
            gulp.src(assets),
            less(),
            concat(assets_output),
            gulpif(isProd, cleancss()),
            concat(assets_output),
            gulp.dest(outputDir),
        ], finalCallback);

        console.info(" [file+] "+assets_output);
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }

    function finalCallback() {
        pipesDone++;
        if (outputCount === pipesDone) {
            done();
        }
    }
});

/**
 * Dumps the SASS assets
 */
gulp.task('sass', function(done) {
    "use strict";

    let list = config.sass,
        outputDir = config.output_directory+'/',
        assets_output, assets, i, l,
        outputCount = GulpfileHelpers.objectSize(list),
        pipesDone = 0
    ;

    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pump([
            gulp.src(assets),
            sass().on('error', sass.logError),
            concat(assets_output),
            gulpif(isProd, cleancss()),
            concat(assets_output),
            gulp.dest(outputDir)
        ], finalCallback);

        console.info(" [file+] "+assets_output);
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }

    function finalCallback() {
        pipesDone++;
        if (outputCount === pipesDone) {
            done();
        }
    }
});

/**
 * Simply copy files into another directory.
 * Useful for simple "dist" files from node_modules directory, for example.
 */
gulp.task('copy', function(done) {
    "use strict";

    let list = config.copy,
        outputDir = config.output_directory+'/',
        assets_output, assets, i, l,
        outputCount = GulpfileHelpers.objectSize(list),
        pipesDone = 0
    ;

    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pump([
            gulp.src(assets),
            gulp.dest(outputDir + assets_output)
        ], finalCallback);

        console.info(" [file+] "+assets_output);
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }

    function finalCallback() {
        pipesDone++;
        if (outputCount === pipesDone) {
            done();
        }
    }
});

/**
 * Compress images.
 * Thanks to @docteurklein.
 */
gulp.task('images', function(done) {
    "use strict";

    let list = config.images,
        outputDir = config.output_directory+'/',
        assets_output, assets, i, l,
        outputCount = GulpfileHelpers.objectSize(list),
        pipesDone = 0
    ;

    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pump([
            gulp.src(assets),
            imagemin([
                imagemin.gifsicle({interlaced: true}),
                imagemin.jpegtran({progressive: true}),
                imagemin.optipng({optimizationLevel: 7}),
                imagemin.svgo({plugins: [{removeViewBox: true}]})
            ]),
            gulp.dest(outputDir + assets_output),
        ], finalCallback);

        console.info(" [file+] "+assets_output);
        for (i = 0, l = assets.length; i < l; i++) {
            console.info('       > '+assets[i]);
        }
    }

    function finalCallback() {
        pipesDone++;
        if (outputCount === pipesDone) {
            done();
        }
    }
});

/**
 * Dumps the CSS assets.
 */
gulp.task('css', function(done) {
    "use strict";

    let list = config.css,
        outputDir = config.output_directory+'/',
        assets_output, assets, i, l,
        outputCount = GulpfileHelpers.objectSize(list),
        pipesDone = 0
    ;
    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pump([
            gulp.src(assets),
            concat(assets_output),
            gulpif(isProd, cleancss()),
            concat(assets_output),
            gulp.dest(outputDir)
        ], finalCallback);

        console.info(" [file+] "+assets_output);
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }

    function finalCallback() {
        pipesDone++;
        if (outputCount === pipesDone) {
            done();
        }
    }
});

/**
 * Dumps the JS assets
 */
gulp.task('js', function(done) {
    "use strict";

    let list = config.js,
        outputDir = config.output_directory+'/',
        assets_output, assets, i, l,
        outputCount = GulpfileHelpers.objectSize(list),
        pipesDone = 0
    ;

    for (assets_output in list) {
        if (!list.hasOwnProperty(assets_output)) { continue; }
        assets = list[assets_output];
        pump([
            gulp.src(assets),
            concat({path: assets_output, cwd: ''}),
            gulpif(isProd, uglify()),
            gulp.dest(outputDir)
        ], finalCallback);

        console.info(" [file+] "+assets_output);
        for (i = 0, l = assets.length; i < l; i++) {
            console.info("       > "+assets[i]);
        }
    }

    function finalCallback() {
        pipesDone++;
        if (outputCount === pipesDone) {
            done();
        }
    }
});

/**
 * Runs all the needed commands to dump all assets and manifests
 */
gulp.task('dump', gulp.series('images', 'copy', 'less', 'sass', 'css', 'js', function(done){
    done();
}));

/**
 * Will watch for files and run "dump" for each modification
 */
gulp.task('watch', gulp.series('dump', gulp.parallel(function(done) {
    "use strict";

    let files_less = [],
        files_images = [],
        files_copy = [],
        files_css = [],
        files_sass = [],
        files_js = [],
        files_to_watch = [],
        other_files_to_watch = config.files_to_watch || [],
        forEach = GulpfileHelpers.objectForEach,
        push = (key, elements, appendTo) => {
            appendTo.push(elements);
            files_to_watch.push(elements);
        },
        callback = function(event) {
            console.log('File "' + event + '" updated');
        }
    ;

    console.info('Night gathers, and now my watch begins...');

    forEach(config.images, (key, images) => { push(key, images, files_images); });
    forEach(config.copy, (key, images) => { push(key, images, files_copy); });
    forEach(config.less, (key, images) => { push(key, images, files_less); });
    forEach(config.sass, (key, images) => { push(key, images, files_sass); });
    forEach(config.css, (key, images) => { push(key, images, files_css); });
    forEach(config.js, (key, images) => { push(key, images, files_js); });

    if (files_to_watch.length) {
        console.info('Watching file(s):');
        // Flatten the array
        files_to_watch = [].concat.apply([], files_to_watch).sort();
        console.info("       > "+files_to_watch.join("\n       > "));
    }

    if (other_files_to_watch.length) {
        gulp.watch(other_files_to_watch, gulp.parallel('dump')).on('change', callback);
    }
    if (hasImages) {
        gulp.watch(files_images, gulp.parallel('images')).on('change', callback);
    }
    if (hasCopy) {
        gulp.watch(files_copy, gulp.parallel('copy')).on('change', callback);
    }
    if (hasLess) {
        gulp.watch(files_less, gulp.parallel('less')).on('change', callback);
    }
    if (hasSass) {
        gulp.watch(files_sass, gulp.parallel('sass')).on('change', callback);
    }
    if (hasCss) {
        gulp.watch(files_css, gulp.parallel('css')).on('change', callback);
    }
    if (hasJs) {
        gulp.watch(files_js, gulp.parallel('js')).on('change', callback);
    }

    done();
})));

gulp.task('test', gulp.series('dump', function(done) {
    "use strict";
    let filesList = [];
    let forEach = GulpfileHelpers.objectForEach;
    let push = (key) => {
        filesList.push(config.output_directory+'/'+key);
    };

    /**
     * Retrieve files list.
     */
    forEach(config.less, push);
    forEach(config.sass, push);
    forEach(config.css, push);
    forEach(config.js, push);

    /**
     * Retrieve files from globs or specific file names.
     */
    let pushFromDirectory = (outputDirName, elements) => {
        let finalOutput = config.output_directory+'/'+outputDirName;

        let cleanName = (outputDirectory, sourceName) => {
            let cleanName = outputDirectory.replace(/\/\*+/gi, '');
            // Clean up files and dirs so we can convert a "source" name into an "output dir related" name.
            let replacedFileName = sourceName.replace(cleanName, '');
            return (finalOutput+replacedFileName).replace('//', '/');
        };

        let cleanAndPush = (name, files) => {
            files.forEach((sourceName) => {
                let cleaned = cleanName(name, sourceName);
                filesList.push(cleaned);
            });
        };

        elements.forEach((name) => {
            // Name is something like "node_modules/materialize-css/dist/fonts/*".
            // We'll check for globs and direct files here to add them to files to watch for tests.
            // This is more complex as we have to list all files in source dirs and compare them with output dir.
            if (glob.hasMagic(name)) {
                cleanAndPush(name, glob.sync(name, { nodir: true }));
            } else {
                let stat = fs.statSync(name);
                if (stat.isFile()) {
                    filesList.push(name);
                } else if (stat.isDirectory()) {
                    // Force glob search for directories
                    cleanAndPush(name, glob.sync(name.replace(/\/+$/gi, '')+'/**', { nodir: true }));
                } else {
                    throw 'Could not find a way to handle source "'+name+'".';
                }
            }
        });
    };

    forEach(config.images, pushFromDirectory);
    forEach(config.copy, pushFromDirectory);

    console.info('Check files that are not dumped according to config.');

    let number = filesList.length;
    let processedFiles = 0;
    let valid = 0;
    let invalid = [];

    // Hack for "padding" strings
    let numberLength = String(number).length;
    let padString = '';
    for (let i = 0; i < numberLength; i++) {
        padString += ' ';
    }

    // Manual "left-pad"
    let pad = (s, p) => { if (typeof p === 'undefined') { p = padString; } return String(p+s).slice(-p.length); };

    filesList.forEach(function(file){
        let fullPath = path.resolve(__dirname.replace(/\/$/, '')+'/'+file.replace(/^\/?/g, ''));
        fs.access(fullPath, function(err){
            if (!err) {
                valid++;
                process.stdout.write('.');
            } else {
                invalid.push(file);
                process.stdout.write('F');
            }

            processedFiles++;

            if (processedFiles % 50 === 0 && processedFiles !== number) {
                process.stdout.write(' '+pad(processedFiles)+' / ' + number + ' (' + pad((Math.floor(100 * processedFiles / number)), '   ') + "%)\n");
            }

            if (processedFiles === number) {
                let rest = 50 - (processedFiles % 50);
                let spaces = '';
                for (let i = 0; i < rest; i++) {
                    spaces += ' ';
                }
                process.stdout.write(' '+spaces+valid+' / ' + processedFiles + " (100%)\n");

                finish();
            }
        });
    });

    function finish() {
        if (invalid.length) {
            process.stdout.write("These files seem not to have been dumped by Gulp flow:\n");
            invalid.forEach((file) => {
                process.stdout.write(" > "+file+"\n");
            });

            done();
            process.exit(1);

            return;
        }

        done();
        process.exit(0);
    }
}));

/**
 * Small user guide
 */
gulp.task('default', function(done){
    console.info("");
    console.info("usage: gulp [command] [--prod]");
    console.info("");
    console.info("Options:");
    console.info("    --prod       If specified, will run clean-css and uglify when dumping the assets.");
    console.info("");
    console.info("Commands:");
    console.info("    copy         Copy the sources in the `config.copy` into a destination folder.");
    console.info("    images       Dumps the sources in the `config.images` parameter from image files.");
    console.info("    less         Dumps the sources in the `config.less` parameter from LESS files.");
    console.info("    sass         Dumps the sources in the `config.sass` parameter from SCSS files.");
    console.info("    css          Dumps the sources in the `config.css` parameter from plain CSS files.");
    console.info("    js           Dumps the sources in the `config.js` parameter from plain JS files.");
    console.info("    dump         Executes all the above commands.");
    console.info("    watch        Executes 'dump', then watches all sources, and dumps all assets once any file is updated.");
    console.info("    test         Executes 'dump', then makes sure that all files in the sources directories are dumped correctly.");
    console.info("");
    done();
});

// Gulpfile with a single var as configuration.
// License: MIT
// Author: 2016 - Alex "Pierstoval" Rock Ancelet <alex@orbitale.io>
// Repository: https://github.com/Orbitale/Gulpfile
