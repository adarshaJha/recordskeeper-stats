var restify = require('restify');
const bodyParser = require('body-parser');
var mysql      = require('mysql');
var unirest = require('unirest');
var config;
var connection;



function setConnection(network){
    config = getConfig(network);
    var conn = mysql.createConnection({
      host     : config.db_host,
      user     : config.db_user,
      password : config.db_pass,
      database : config.db_name
    });
    return conn;
}


function getConfig(newtork){
    if(network = 'test'){
        return require('../testnet_config.json');
    }else{
        return require('../mainnet_config.json');
    }
}
 

function getBlockInfo(req, res, next) {

    if (!req.method === 'POST') {
        return next();
    }
    var network = req.body.network;
    connection = setConnection(network);

    connection.connect(function(err) {
        if (err) throw err;
        console.log('connected as id ' + connection.threadId);
    });


    connection.query('SELECT * FROM block_info ORDER BY id DESC LIMIT 1;', function (error, results, fields) {
        if (error){
            res.json({'status':'failed','message':'Error while fetching data'});
            throw error;
        }
        else{
            var result = [];
            var d = new Date(0); // The 0 there is the key, which sets the date to the epoch
            d.setUTCSeconds(results[0].block_time);
            var xrk_supply = (config.mining_reward * results[0].best_block) + config.premined_quant;
            result.push({'status':'success',
                        'data':{'best_block':results[0].best_block,
                        'xrk_supply':xrk_supply,
                        'best_block_timestamp':d.getHours()+':'+d.getMinutes()+':'+d.getSeconds()}
                    });
            res.header('Content-Type', 'application/json');      
            res.header('Access-Control-Allow-Origin: *');  
            res.json(result);
        }
      });
    connection.end();  
}

function getAvgTime(req, res, next) {
    

    if (!req.method === 'POST') {
        return next();
    }
    var network = req.body.network;
    connection = setConnection(network);

    connection.connect(function(err) {
        if (err) throw err;
        console.log('connected as id ' + connection.threadId);
    });

    connection.query('SELECT AVG(time_diff) FROM block_info WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY id ASC;', function (error, results, fields) {
        if (error){
            res.json({'status':'failed','message':'Error while fetching data'});
            throw error;
        }
        else{
            var result = [];
            result.push({'status':'success',
                        'data':{'avg_time':results[0]['AVG(time_diff)']}
                    });
            res.json(result);
        }
      });
    connection.end();  
}

function getChartInfo(req, res, next) {
    
    if (!req.method === 'POST') {
        return next();
    }
    var network = req.body.network;
    connection = setConnection(network);

    connection.connect(function(err) {
        if (err) throw err;
        console.log('connected as id ' + connection.threadId);
    });

    connection.query('SELECT * FROM chart_values ORDER BY id DESC LIMIT 7;', function (error, results, fields) {
        if (error){
            res.json({'status':'failed','message':'Error while fetching data'});
            throw error;
        }
        else{
            var result = [];
            result.push({'status':'success',
                        'data':{results}
                    });
            res.json(result);
        }
      });
    connection.end();  
}

function geTxInfo(req, res, next) {
    
    if (!req.method === 'POST') {
        return next();
    }

    var network = req.body.network;
    connection = setConnection(network);

    connection.connect(function(err) {
        if (err) throw err;
        console.log('connected as id ' + connection.threadId);
    });


    connection.query('SELECT * FROM transaction_info ORDER BY id DESC LIMIT 1;', function (error, results, fields) {
        if (error){
            res.json({'status':'failed','message':'Error while fetching data'});
            throw error;
        }
        else{
            var result = [];
            result.push({'status':'success',
                        'data':{results}
                    });
            res.json(result);
        }
      });
    connection.end();  
}

function getPendingTx(req, res, next){
    
    if (!req.method === 'POST') {
        return next();
    }
    var network = req.body.network;
    config = getConfig(network);

    var auth = 'Basic ' + Buffer.from(config.rk_user + ':' + config.rk_pass).toString('base64');
    var req = unirest("POST", config.rk_host+':'+config.rk_port);

    req.headers({
    "cache-control": "no-cache",
    "authorization": auth,
    "content-type": "application/json"
    });

    req.type("json");
    req.send({
    "method": "getmempoolinfo",
    "id": 1,
    "chain_name": config.rk_chain
    });

    req.end(function (response) {
    if (response.error){
        res.json({'status':'failed','message':'Error while fetching data'});
        throw new Error(res.error);
    } else res.json(response.body);
    });
}

var server = restify.createServer();
server.use(bodyParser.json());
server.use(bodyParser.urlencoded({extended: true}));
// server.post('/blockInfo/', getBlockInfo);
// server.post('/pendingTx/', getPendingTx);
// server.post('/avgTime/', getAvgTime);
// server.post('/chart/', getChartInfo);
server.post('/txCount/', geTxInfo);

server.listen(8080, function() {
    console.log('%s listening at %s', server.name, server.url);
  });
