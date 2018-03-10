<?php
// load config
if ($_COOKIE["rk-network"] == "test")
  $config = include('config-testnet.php');
else $config = include('config-mainnet.php');


date_default_timezone_set("UTC");
header('Cache-Control: no-cache');
header("Content-Type: text/event-stream\n\n");

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
error_log("cookie ". $_COOKIE["rk-network"]);
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


  $data = array();
  $data["best_block"] = $bestBlock;
  $data["last_block_time"] = $lastBlockTime;
  $data["xrk_supply"] = $xrkSupply;
  
  echo "event: block-info\n";
  echo 'data: '.json_encode($data)."\n\n";
  echo "\n\n";
  
  ob_end_flush();
  flush();
  sleep($refreshRate);
}

?>