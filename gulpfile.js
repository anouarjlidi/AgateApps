/**
 * Gulp file to use to manage assets
 */
var fs           = require('fs'),
    glob         = require('glob'),
    yaml         = require('yamljs'),
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

var assetsManager = {
    "get": function(type) {
        var toReturn = [], i, asset;
        if (!type) {
            console.error('Must specify a type when retrieving assets.');
            return;
        }
        for (i in this.assets) {
            if (this.assets[i].type === type) {
                asset = this.assets[i];
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
        for (i in this.assets) {
            asset = this.assets[i];
            for (j in asset.sources) {
                toReturn.push(asset.sources[j]);
            }
        }
        return toReturn;
    },
    output_directory: 'web',
    assets: []
};

var assetsFile = './.assets.yml', config;

try {
    config = yaml.load(assetsFile);
    assetsManager.assets = config.assets || [];
    assetsManager.output_directory = config.output_directory || 'web';
    assetsManager.rev_directory = config.rev_directory || 'app/cache';
    try {
        fs.accessSync(assetsManager.output_directory, fs.W_OK);
    } catch (e) {
        throw 'The output directory "'+assetsManager.output_directory+'" must be valid. Did you forgot to create it?'+"\n"+e.message;
    }
    try {
        fs.accessSync(assetsManager.rev_directory, fs.W_OK);
    } catch (e) {
        throw 'The output directory "'+assetsManager.rev_directory+'" must be valid. Did you forgot to create it?'+"\n"+e.message;
    }
} catch (e) {
    if (e.message && e.message.match(/no such file or directory/gi)) {
        throw 'Your assets file does not exist. You must create one in order to use this tool.';
    }
}

/**
 * Dumps the LESS assets
 */
gulp.task('less', function() {
    var type = 'less',
        list = assetsManager.get(type),
        i, asset
    ;
    for (i in list) {
        asset = list[i];
        gulp
            .src(asset.sources)
            .pipe(less())
            .pipe(autoprefixer())
            .pipe(minifycss({
                keepBreaks: false,
                keepSpecialComments: 0
            }))
            .pipe(concat(asset.output))
            .pipe(gulp.dest('web/css'))
        ;
        console.info('Processed '+type.toUpperCase()+' "'+asset.name+'" to output "'+assetsManager.output_directory+'/css/'+asset.output+'"');
    }
});

/**
 * Dumps the CSS assets.
 * This command depends on the "less" automatically because sometimes you need
 *   to compile less files and use the generated css to compile a "global" css.
 */
gulp.task('css', ['less'], function() {
    var type = 'css',
        list = assetsManager.get(type),
        i, asset
    ;
    for (i in list) {
        if (!list.hasOwnProperty(i)) { continue; }
        asset = list[i];
        gulp
            .src(asset.sources)
            .pipe(concat(asset.output))
            .pipe(autoprefixer())
            .pipe(minifycss({
                keepBreaks: false,
                keepSpecialComments: 0
            }))
            .pipe(rev())
            .pipe(gulp.dest(assetsManager.output_directory+'/'+type))
            .pipe(rev.manifest('rev-manifest-'+type+'-'+asset.name+'.json'))
            .pipe(gulp.dest('app/cache/'))
        ;
        console.info('Processed '+type.toUpperCase()+' "'+asset.name+'" to output "'+assetsManager.output_directory+'/'+type+'/'+asset.output+'"');
    }
});

/**
 * Dumps the JS assets
 */
gulp.task('js', function() {
    var type = 'js',
        list = assetsManager.get(type),
        i, asset
    ;
    for (i in list) {
        if (!list.hasOwnProperty(i)) { continue; }
        asset = list[i];
        gulp
            .src(asset.sources)
            .pipe(sourcemaps.init())
            .pipe(concat({path: asset.output, cwd: ''}))
            .pipe(uglyfly())
            .pipe(rev())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(assetsManager.output_directory+'/'+type))
            .pipe(rev.manifest('rev-manifest-'+type+'-'+asset.name+'.json'))
            .pipe(gulp.dest('app/cache/'))
        ;
        console.info('Processed '+type.toUpperCase()+' "'+asset.name+'" to output "'+assetsManager.output_directory+'/'+type+'/'+asset.output+'"');
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

    gulp.watch(assetsManager.sources(), ['dump']).on('change', function(event) {
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
