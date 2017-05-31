const path = require('path');
const spawn = require('child_process').spawn;
const fs = require('fs');

/** @type {Array} */
const filesToTest = require('./files_to_test.js');

const rootDir = path.resolve(__dirname+'/../../');

const gulpBinary = path.resolve(rootDir+'/node_modules/gulp4/bin/gulp.js');

/**
 * Run Gulp command
 */
const gulpCommand = spawn('node', [gulpBinary, 'dump', '--prod'], {cwd: rootDir, stdio: 'inherit'});

/**
 * Test all files when gulp ends
 */
gulpCommand.on('close', (code) => {
    let number = filesToTest.length;
    let done = 0;
    let valid = 0;
    let invalid = [];

    // Hack for "padding" strings
    let numberLength = String(number).length;
    let padString = '';
    for (let i = 0; i < numberLength; i++) {
        padString += ' ';
    }

    function pad(string, prependedString) {
        if (typeof prependedString === 'undefined') {
            prependedString = padString;
        }
        return String(prependedString+string).slice(-prependedString.length);
    }

    filesToTest.forEach(function(file){
        let fullPath = path.resolve(rootDir.replace(/\/$/, '')+'/'+file.replace(/^\/?/g, ''));
        fs.access(fullPath, function(err, mode){
            if (!err) {
                valid++;
                process.stdout.write('.');
            } else {
                invalid.push(file);
                process.stdout.write('F');
            }

            done++;

            if (done % 50 === 0 && done !== number) {
                process.stdout.write(' '+pad(done)+' / ' + number + ' (' + pad((Math.floor(100 * done / number)), '   ') + "%)\n");
            }

            if (done === number) {
                let rest = 50 - (done % 50);
                let spaces = '';
                for (let i = 0; i < rest; i++) {
                    spaces += ' ';
                }
                process.stdout.write(' '+spaces+valid+' / ' + done + " (100%)\n");

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
            process.exit(1);
            return;
        }

        process.exit(0);
    }
});
