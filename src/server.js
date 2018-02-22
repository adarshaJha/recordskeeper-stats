var restify = require('restify');
var config = require('./config.json');

function basicStats(req, res, next) {

}

var server = restify.createServer();
server.use(bodyParser.json());
server.use(bodyParser.urlencoded({extended: true}));
server.get('/stats/', basicStats);

server.listen(8080, function() {
    console.log('%s listening at %s', server.name, server.url);
  });