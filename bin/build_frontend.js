var http = require('http');
var path = require('path');
var spawn = require('child_process').spawn;

http.createServer(function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/plain'});
    spawn('node', [path.dirname(__dirname)+'/node_modules/gulp4/bin/gulp.js', 'dump', '--prod'], { stdio: 'inherit' });
    res.end('');
}).listen(9999);
