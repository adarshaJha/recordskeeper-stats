<?php
// load config
if ($_COOKIE["rk-network"] == "test")
  $config = include('config-testnet.php');
else $config = include('config-mainnet.php');


date_default_timezone_set("UTC");
header('Cache-Control: no-cache');
header("Content-Type: text/event-stream\n\n");

$rkHost = $config["rk_host"]; 
$rkPort = $config["rk_port"];
$rkUser = $config["rk_user"];
$rkPwd = $config["rk_pass"];

$rkChain = $config["rk_chain"];

$dbHost = $config["db_host"]; 
$dbName= $config["db_name"];
$dbUser = $config["db_user"];
$dbPwd = $config["db_pass"];
$preminedTokens =  $config["premined_tokens"];
$miningReward = $config["mining_reward"];
$refreshRate = $config["refresh_rate"];

// stats
$bestBlock = 0;
$lastBlockTime = 0;
$xrkSupply = 0;
$txCount = 0;
$avgTime = 0;
$chartSuccess = false;
$chartData = null;

error_log("Network: ". $_COOKIE["rk-network"]);
while (1) {
// get data from db 
try {
  $connectionString =  "mysql:host=". $dbHost."; dbname=".$dbName.";";
  $pdo = new PDO($connectionString , $dbUser, $dbPwd);
  $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if($pdo != NULL) {

      $sql = 'SELECT * FROM block_info ORDER BY id DESC LIMIT 1' ;
      $sth = $pdo->prepare($sql);
      $sth->execute();
      $row = $sth->fetch();
      if($row) { 
          $bestBlock = $row["best_block"];
          $lastBlockTime = $row["block_time"];
          $xrkSupply = ($miningReward * $bestBlock) + $preminedTokens;
      }

      $sql = 'SELECT * FROM transaction_info ORDER BY id DESC LIMIT 1' ;
      $sth = $pdo->prepare($sql);
      $sth->execute();
      $row = $sth->fetch();
      if($row) { 
          $txCount = $row["tx"];
      }
      
      $sql = 'SELECT AVG(time_diff) as avg_time FROM block_info WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY id ASC';
      $sth = $pdo->prepare($sql);
      $sth->execute();
      $row = $sth->fetch();
      if($row) { 
          $avgTime = (int)$row["avg_time"];
      }

      error_log("reading chart values");
      $sql = 'SELECT * FROM chart_values ORDER BY id DESC LIMIT 7';
      $sth = $pdo->prepare($sql);
      $sth->execute();
      $rows = $sth->fetchAll(); 
      if($rows) { 
          $chartData = $rows;
          $chartSuccess = true;
      }
      else {
        $chartSuccess = false;
      }
  }

  $sth = null;
  $pdo = null;
}
catch(Exception $e) {
  error_log("ERROR:couldn't connect". $e->getMessage());
}
catch(PDOException $e) {
    error_log("ERROR: couldn't insert". $e->getMessage());
}

  // block info
  $data = array();
  $data["best_block"] = $bestBlock;
  $data["last_block_time"] = $lastBlockTime;
  $data["xrk_supply"] = $xrkSupply;
  echo "event: block-info\n";
  echo 'data: '.json_encode($data)."\n\n";
  echo "\n\n";

  // tx count
  $data = array();
  $data["tx_count"] =  $txCount;
  echo "event: tx-count\n";
  echo 'data: '.json_encode($data)."\n\n";
  echo "\n\n";

  // pending tx
  $data = array();
  $data["pending_tx_count"] =  getPendingTransactions();
  echo "event: pending-tx\n";
  echo 'data: '.json_encode($data)."\n\n";
  echo "\n\n";

  // average block time
  $data = array();
  $data["avg_time"] =  $avgTime;
  echo "event: average-block-time\n";
  echo 'data: '.json_encode($data)."\n\n";
  echo "\n\n";

  // chart data
  $data = array();
  $data["data"] =  $chartData;
  $data["success"] =  $chartSuccess;
  echo "event: chart-data\n";
  echo 'data: '.json_encode($data)."\n\n";
  echo "\n\n";
  
  ob_end_flush();
  flush();
  sleep($refreshRate);
}



function getPendingTransactions() {
  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_PORT => $GLOBALS['rkPort'],
  CURLOPT_URL => $GLOBALS['rkHost'],
  CURLOPT_USERPWD => $GLOBALS['rkUser'].":".$GLOBALS['rkPwd'],
  CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"method\":\"getmempoolinfo\",\"params\":[],\"id\":1,\"chain_name\":\"".$GLOBALS["rkChain"]."\"}",
  CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: application/json"
  ),
  ));

  error_log("Sending request: Pending tx");
  $result = json_decode(curl_exec($curl));
  //error_log(json_encode($result, JSON_PRETTY_PRINT));
  $err = curl_error($curl);
  $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $pendingTxnCount  = 55;
  if($httpCode == 200 && $result->error == null) {
      $pendingTxnCount  = $result->result->size;
  }
  else if($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
      error_log("ERROR: pending tx not fetched from blockchain");
  }  
  return $pendingTxnCount;
}

?>