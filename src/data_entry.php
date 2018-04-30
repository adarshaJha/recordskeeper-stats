<?php

function isProcessRunning($lockFile) {
    $myfile = fopen($lockFile, "r") or die("Unable to open ".$lockFile." file!");
$status = fgets($myfile);
$length = strlen($status);
if($length > 6){
    $running = 0;
} else {
    $running = 1;
   }
return $running;
 }

function writeFile($lockFile, $text) {
  $myfile = fopen($lockFile, "w") or die("Unable to open ".$lockFile." file!"); 
  fwrite($myfile, $text); 
}

// load config
  if ($argv[1] == "test") {
  $config = include('config-testnet.php'); 
  $file = $config["lock-file"];
  $isRunning = isProcessRunning($file);
  }
else {
    $config = include('config-mainnet.php');
    $file = $config["lock-file"];
    $isRunning = isProcessRunning($file);
   } 

if($isRunning == 0){ // proceed only if script is not running already
writeFile($file, "");
$rkHost  = $config["rk_host"];
$rkPort  = $config["rk_port"];
$rkUser  = $config["rk_user"];
$rkPwd   = $config["rk_pass"];
$rkChain = $config["rk_chain"];
$dbHost  = $config["db_host"];
$dbName  = $config["db_name"];
$dbUser  = $config["db_user"];
$dbPwd   = $config["db_pass"];
$premined_tokens =  $config["premined_tokens"];
$mining_reward = $config["mining_reward"];
$genesis_block_time = $config["genesis-timestamp"];
$genesis_block_miner = $config["genesis-miner"];
$genesis_miner_tx_id = $config["genesis-miner-tx-id"];
$genesis_difficulty = $config["difficulty"];
$genesis_hash_rate = $config["hash-rate"];

function getInfo(){
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_PORT => $GLOBALS['rkPort'],
    CURLOPT_URL => $GLOBALS['rkHost'],
    CURLOPT_USERPWD => $GLOBALS['rkUser'] . ":" . $GLOBALS['rkPwd'],
    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\"method\":\"getinfo\",\"params\":[],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json"
    )
));
error_log("Sending request: getInfo");
$result   = json_decode(curl_exec($curl));
//error_log(json_encode($result, JSON_PRETTY_PRINT));
$err      = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//$difficulty  = 55;
//$latest_block = 0;
if ($httpCode == 200 && $result->error == null) {
    $latest_block = $result->result->blocks;
} else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
    error_log("ERROR: Info not fetched from blockchain");
}
return $latest_block;
}

function getblock($block_number){
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_PORT => $GLOBALS['rkPort'],
    CURLOPT_URL => $GLOBALS['rkHost'],
    CURLOPT_USERPWD => $GLOBALS['rkUser'] . ":" . $GLOBALS['rkPwd'],
    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\"method\":\"getblock\",\"params\":[\"$block_number\", 4],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json"
    )
));
error_log("Sending request: getblock");
$result   = json_decode(curl_exec($curl));
//error_log(json_encode($result, JSON_PRETTY_PRINT));
$err      = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//$latest_block = 0;
if ($httpCode == 200 && $result->error == null) {
    $r = $result->result->tx;
    $tx_count   = count($r);
    $items = 0;
    $data_size = 0; 
    $dificulty  = $result->result->difficulty;
    $miner      = $result->result->miner;
    $block_time = $result->result->time;
    $block_size = $result->result->size;
    $re = $result->result;
    $tx = $re->tx;
    $vout= $tx[0];
    $miner_tx_id = $vout->txid;
    $tx_out = $vout->vout;
    
    $value = $tx_out[0];
    $fee_value = $value->value;
    //echo($fee_value);

    $fees = $fee_value - 10;
    if ($tx_count>1){
    for ($i=0; $i< $tx_count; $i++) {
        $txn = $tx[$i];
        $vout = $txn->vout;
        for ($j=0; $j<= $i; $j++) {
        $itm = $vout[$j];
        $item = $itm->items;
        $it = $item[$j];
        $hex = $it->data;
        $count = strlen($hex);
        $size = $count/2; 
        $item_count = count($item);
        $items = $item_count + $items;
        $data_size = $size + $data_size;
        }
      }
    }

} else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
error_log("ERROR: Info not fetched from blockchain");
    }
    return array($tx_count, $dificulty, $miner, $block_time, $fees, $block_size, $items, $miner_tx_id, $data_size);
}


function getPendingTransactions() {
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_PORT => $GLOBALS['rkPort'],
    CURLOPT_URL => $GLOBALS['rkHost'],
    CURLOPT_USERPWD => $GLOBALS['rkUser'] . ":" . $GLOBALS['rkPwd'],
    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\"method\":\"getmempoolinfo\",\"params\":[],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json"
    )
));
error_log("Sending request: getPendingTransactions");
$result   = json_decode(curl_exec($curl));
//error_log(json_encode($result, JSON_PRETTY_PRINT));
$err      = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//$difficulty  = 55;
//$latest_block = 0;
if ($httpCode == 200 && $result->error == null) {
    $tx_count = $result->result->size;
} else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
    error_log("ERROR: Info not fetched from blockchain");
}
return $tx_count;
}

  function listStreams() {
        
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
        CURLOPT_POSTFIELDS => "{\"method\":\"liststreams\",\"params\":[],\"id\":1,\"chain_name\":\"".$GLOBALS["rkChain"]."\"}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
        ),
        ));

        error_log("Sending request: listStreams");
        $result = json_decode(curl_exec($curl),true);

        //error_log(json_encode($result, JSON_PRETTY_PRINT));
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($httpCode == 200 && $result['error'] == null) {
            $re  = $result['result'];
            $res = $re[0];

            $streams_items = $res['items'];

            
            $streamCount = sizeof($re);
            //echo($itemidCount);
        }

        else if($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
            error_log("ERROR: streams not fetched from blockchain");
        }  

        
        return array($streamCount, $streams_items);

  }

function listAddresses() {
        
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
        CURLOPT_POSTFIELDS => "{\"method\":\"listaddresses\",\"params\":[],\"id\":1,\"chain_name\":\"".$GLOBALS["rkChain"]."\"}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
        ),
        ));

        error_log("Sending request: list addresses");
        $result = json_decode(curl_exec($curl),true);

        //error_log(json_encode($result, JSON_PRETTY_PRINT));
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($httpCode == 200 && $result['error'] == null) {
         
            $re  = $result['result'];
            //print_r($re);

            
            $addressCount = count($re);
            //echo($itemidCount);
        }

        else if($httpCode != 200 || ($httpCode == 200 && $result['error'] != null)) {
            error_log("ERROR: addresses not fetched from blockchain");
        }  

        
        return $addressCount;

  }

function totalMiners() {
        
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
        CURLOPT_POSTFIELDS => "{\"method\":\"listpermissions\",\"params\":[\"mine\"],\"id\":1,\"chain_name\":\"".$GLOBALS["rkChain"]."\"}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
        ),
        ));

        error_log("Sending request: totalMiners");
        $result = json_decode(curl_exec($curl),true);

        //error_log(json_encode($result, JSON_PRETTY_PRINT));
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($httpCode == 200 && $result['error'] == null) {
         
            $re  = $result['result'];
            //print_r($re);

            
            $minersCount = count($re);
            //echo($itemidCount);
        }

        else if($httpCode != 200 || ($httpCode == 200 && $result['error'] != null)) {
            error_log("ERROR: addresses not fetched from blockchain");
        }  

        
        return $minersCount;

  }



function rkSize ($dir)
{
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : rkSize($each);
    }

    $rk_size = ($size /100000);
    return $rk_size;
  }

$latest_block = getInfo();
$info = getblock($latest_block);
$latest_tx_count = $info[0];
$latest_difficulty = $info[1];
$latest_miner = $info[2];
$latest_block_time = $info[3];
$block_fee = $info[4];
$latest_block_size = $info[5];
$latest_data_items = $info[6];
$latest_miner_tx_id = $info[7];
$latest_block_data_size = $info[8];
$dir = $config["dir"];

$pending_tx = getPendingTransactions();
$xrk_supply = $premined_tokens+ $latest_block*$mining_reward;
$stream_info = listStreams();
$streams_items = $stream_info[1];
$total_streams = $stream_info[0];
$total_addresses = listAddresses();
$total_miners = totalMiners();

$blockchain_size = rkSize($dir);

try {
    $connectionString =  "mysql:host=". $dbHost."; dbname=".$dbName.";";
    $pdo = new PDO($connectionString , $dbUser, $dbPwd);
    $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($pdo != NULL) {
        $sql = "SELECT COUNT(id) FROM block_info";
        $sth  = $pdo->prepare($sql);
        $sth->execute();
        $row   = $sth->fetch();
        $count = $row[0];
        if ($count == 0) {
            $sql = "INSERT INTO block_info(best_block, block_time, block_size, time_diff, avg_block_time, miner, miner_tx_id, total_miners, txcount, data_items, data_size, difficulty, hash_rate, fee)
                              VALUES (0, '$genesis_block_time', 245, 0, 0, '$genesis_block_miner', '$genesis_miner_tx_id', 1, 1 , 0, 0, '$genesis_difficulty', '$genesis_hash_rate', 0)";
            $sth  = $pdo->prepare($sql);
            $sth->execute();
            } else {
                    $sql2 = 'SELECT best_block FROM block_info WHERE best_block=(SELECT max(best_block) FROM block_info)';
                    $sth  = $pdo->prepare($sql2);
                    $sth->execute();
                    $row        = $sth->fetch();
                    $last_block = $row[0];
                    $block_diff = $latest_block - $last_block;
                    for ($i = 1; $i <= $block_diff; $i++) {
                        $last_block = $last_block + 1;
                        $block_info = getblock($last_block);
                        print_r($block_info);
                     
                        $sql3 = 'SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info)';
                            $sth  = $pdo->prepare($sql3);
                            $sth->execute();
                            $row             = $sth->fetch();
                            $last_block_time = $row[0];
                            $block_time = $block_info[3];
                            $time_diff       = $block_time - $last_block_time;
                            $avg_block_time = ($block_time - $genesis_block_time)/$last_block;
                            $tx_count = $block_info[0];
                            $difficulty = $block_info[1];
                            $miner = $block_info[2];
                            $fee = $block_info[4];
                            $block_size = $block_info[5];
                            $block_items = $block_info[6];
                            $miner_tx_id = $block_info[7];
                            $data_size = $block_info[8];
                            $hash_rate = $difficulty/$avg_block_time;
                            $sql4 = "INSERT INTO block_info(best_block, block_time, block_size, time_diff, avg_block_time, miner, miner_tx_id, total_miners, txcount, data_items, data_size, difficulty, hash_rate, fee)
                              VALUES ('$last_block', '$block_time', '$block_size', '$time_diff', '$avg_block_time', '$miner', '$miner_tx_id', '$total_miners', '$tx_count','$block_items', '$data_size', '$difficulty','$hash_rate', '$fee')";
                            $sth = $pdo->prepare($sql4);
                            $sth->execute();

                    } 

                     $sql5 = "SELECT COUNT(DISTINCT(miner)) FROM `block_info` ORDER BY id DESC LIMIT 1000";
                            $sth = $pdo->prepare($sql5);
                            $sth->execute();
                            $row = $sth->fetch();
                            $active_miners = $row[0];
                }

        $sql6 = "SELECT COUNT(id) FROM dynamic_values";
        $sth  = $pdo->prepare($sql6);
        $sth->execute();
        $row   = $sth->fetch();
        $count = $row[0];
        if ($count == 0) {
            $sql7 = "INSERT INTO dynamic_values(xrk_supply, blockchain_size, stream_items, total_addresses, total_miners, pending_tx, active_miners, total_streams)
                              VALUES ('$xrk_supply', '$blockchain_size', '$streams_items', '$total_addresses', '$total_miners' , '$pending_tx', 1, '$total_streams')";
            $sth  = $pdo->prepare($sql7);
            $sth->execute();
            }
        else {
             $sql8 = "UPDATE dynamic_values SET xrk_supply = '$xrk_supply', blockchain_size= '$blockchain_size', stream_items = '$streams_items', total_addresses = '$total_addresses', total_miners = '$total_miners', pending_tx = '$pending_tx', active_miners= '$active_miners', total_streams= '$total_streams' WHERE id=1"; 
             $sth  = $pdo->prepare($sql8);
            $sth->execute();
        }
        
        writeFile($file, "completed");
        
    }
    $sth = null;
    $pdo = null;
}

catch (Exception $e) {
    error_log("ERROR:couldn't connect" . $e->getMessage());
}
catch (PDOException $e) {
    error_log("ERROR: couldn't insert" . $e->getMessage());
 } 

} else {
    fclose($file);
    echo "Script already running.";
}
?>
