<?php
// load config
if ($_COOKIE["rk-network"] == "test")
  $config = include('config-testnet.php');
else $config = include('config-mainnet.php');
$rkHost = $config["rk_host"]; 
$rkPort = $config["rk_port"];
$rkUser = $config["rk_user"];
$rkPwd = $config["rk_pass"];
$rkChain = $config["rk_chain"];
$dbHost = $config["db_host"]; 
$dbName= $config["db_name"];
$dbUser = $config["db_user"];
$dbPwd = $config["db_pass"];

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
  CURLOPT_POSTFIELDS => "{\"method\":\"getinfo\",\"params\":[],\"id\":1,\"chain_name\":\"".$GLOBALS["rkChain"]."\"}",
  CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: application/json"
  ),
  ));
  error_log("Sending request: getInfo");
  $result = json_decode(curl_exec($curl));
  //error_log(json_encode($result, JSON_PRETTY_PRINT));
  $err = curl_error($curl);
  $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  //$difficulty  = 55;
  //$latest_block = 0;
  if($httpCode == 200 && $result->error == null) {
      $difficulty  = $result->result->difficulty;
      $latest_block  = $result->result->blocks;
  }
  else if($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
      error_log("ERROR: Info not fetched from blockchain");
  }
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
  CURLOPT_POSTFIELDS => "{\"method\":\"listblocks\",\"params\":[\"$latest_block\"],\"id\":1,\"chain_name\":\"".$GLOBALS["rkChain"]."\"}",
  CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: application/json"
  ),
  ));
  error_log("Sending request: listblocks");
  $result = json_decode(curl_exec($curl));
  //error_log(json_encode($result, JSON_PRETTY_PRINT));
  $err = curl_error($curl);
  $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  //$latest_block = 0;
  if($httpCode == 200 && $result->error == null) {
  	  $r = $result->result;
  	  $re = $r[0];
      $latest_miner  = $re->miner;
      $latest_block_time  = $re->time;
  }
  else if($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
      error_log("ERROR: Info not fetched from blockchain");
  }
  
  try {
  $connectionString =  "mysql:host=". $dbHost."; dbname=".$dbName.";";
  $pdo = new PDO($connectionString , $dbUser, $dbPwd);
  $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if($pdo != NULL) {
      $sql = "INSERT INTO difficulty(value) VALUES ('$difficulty')" ;
      $sth = $pdo->prepare($sql);
      $sth->execute();

      $sql2 = "SELECT COUNT(id) FROM block_info" ;
      $sth = $pdo->prepare($sql2);
      $sth->execute();
      $row = $sth->fetch();
      $count = $row[0];
      if($count == 0) { 
        $sql3 = 'INSERT INTO block_info (best_block, block_time, miner)
             VALUES (latest_block,latest_block_time, latest_miner)';
        $sth = $pdo->prepare($sql3);
        $sth->execute();
      }

      else {
      	$sql4 = 'SELECT best_block FROM block_info WHERE best_block=(SELECT max(best_block) FROM block_info)';
      	$sth = $pdo->prepare($sql4);
        $sth->execute();
        $row = $sth->fetch();
        $last_block = $row[0];
        $block_diff = $latest_block-$last_block;
        if ($block_diff == 1){
        	$sql5 = 'SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info)';
        	$sth = $pdo->prepare($sql5);
            $sth->execute();
            $row = $sth->fetch();
            $last_block_time = int(row1[0]);
            $time_diff = $latest_block_time - $last_block_time;
            $sql6 = "INSERT INTO block_info(best_block, block_time, time_diff, miner)
             VALUES ('$latest_block','$latest_block_time','$time_diff', '$latest_miner')";
            $sth = $pdo->prepare($sql6);
            $sth->execute();
            echo($last_block);
        }
        else {
        	 for ($i=1; $i<=$block_diff; $i++) {
              $last_block = $last_block + 1;
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
              CURLOPT_POSTFIELDS => "{\"method\":\"listblocks\",\"params\":[\"$last_block\"],\"id\":1,\"chain_name\":\"".$GLOBALS["rkChain"]."\"}",
              CURLOPT_HTTPHEADER => array(
              "cache-control: no-cache",
              "content-type: application/json"
              ),
              ));
              error_log("Sending request: listblocks");
              $result = json_decode(curl_exec($curl));
  //error_log(json_encode($result, JSON_PRETTY_PRINT));
              $err = curl_error($curl);
              $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
              if($httpCode == 200 && $result->error == null) {
              $r = $result->result;
  	          $re = $r[0];
              $miner  = $re->miner;
              $block_time  = $re->time;
              }
              else if($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
              error_log("ERROR: Info not fetched from blockchain");
              }
              $sql7 = 'SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info)';
              $sth = $pdo->prepare($sql7);
              $sth->execute();
              $row = $sth->fetch();
              $last_block_time = $row[0];
              $time_diff = $block_time - $last_block_time;
              $sql8 = "INSERT INTO block_info(best_block, block_time, time_diff, miner)
             VALUES ('$last_block', '$block_time', '$time_diff', '$miner')";
              $sth = $pdo->prepare($sql8);
              $sth->execute();
        	 }
          }
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
 ?>
