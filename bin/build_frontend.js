const http = require('http');
const path = require('path');
const spawn = require('child_process').spawn;

const port = 9999;

console.log('Listening to port '+9999);

http.createServer(function (req, res) {
    if (req.url !== '/') {
        res.writeHead(400);
        res.end();

        return;
    }

    // First, update all project
    let cmd = spawn('git', ['pull', 'origin', 'master'], { stdio: 'inherit' });

    cmd.on('close', () => {
        // Then dump assets
        let dump = spawn('node', [path.dirname(__dirname)+'/node_modules/gulp4/bin/gulp.js', 'dump', '--prod'], { stdio: 'inherit' });

        dump.on('close', (code) => {
            if (0 !== code) {
                res.writeHead(500, {'Content-Type': 'text/plain'});
            } else {
                res.writeHead(200, {'Content-Type': 'text/plain'});
            }

            res.end(code.toString());
        });
    });

}).listen(port);
