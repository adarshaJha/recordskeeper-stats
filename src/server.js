var restify = require('restify');
const bodyParser = require('body-parser');
var config = require('../config.json');
var mysql      = require('mysql');
var unirest = require('unirest');

var connection = mysql.createConnection({
  host     : config.db_host,
  user     : config.db_user,
  password : config.db_pass,
  database : config.db_name
});
 

function getBlockInfo(req, res, next) {
    
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
            var xrk_supply = (config.mining_reward * results[0].best_block) + config.premined_quant;
            result.push({'status':'success',
                        'data':{'best_block':results[0].best_block,
                        'xrk_supply':xrk_supply,
                        'best_block_timestamp':results[0].block_time}
                    });
            res.header('Content-Type', 'application/json');      
            res.header('Access-Control-Allow-Origin: *');  
            res.json(result);
        }
      });
    connection.end();  
}

function getAvgTime(req, res, next) {
    
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

function getPendingTx(req, res, next){
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

function getChartInfo(req, res, next) {
    
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



var server = restify.createServer();
server.use(bodyParser.json());
server.use(bodyParser.urlencoded({extended: true}));
server.get('/blockInfo/', getBlockInfo);
server.get('/pendingTx/', getPendingTx);
server.get('/avgTime/', getAvgTime);
server.get('/chart/', getChartInfo);
server.get('/txCount/', geTxInfo);

server.listen(8080, function() {
    console.log('%s listening at %s', server.name, server.url);
  });
