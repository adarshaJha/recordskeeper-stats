<?php
// load config
if ($_COOKIE["rk-network"] == "test")
$config = include('config-testnet.php');
else $config = include('config-mainnet.php');
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
$max_block_size = $config["max_block_size"];
$fee = $config["fee"];
$amount  = 0;
$latest_block = getInfo();
$info = getblock($latest_block);
$latest_tx_count = $info[0];
$latest_difficulty = $info[1];
$latest_miner = $info[2];
$latest_block_time = $info[3];
$block_fee = $info[4];
$latest_block_size = $info[5];
$dir = $config["dir"];

$pending_tx = getPendingTransactions();
$xrk_supply = $premined_tokens+ $latest_block*$mining_reward;
$stream_info = listStreams();
$streams_items = $stream_info[1];
$total_streams = $stream_info[0];
$total_addresses = listAddresses();
$active_miners = "";
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
            $sql2 = "INSERT INTO block_info(best_block, block_time, time_diff, miner, txcount, difficulty, fee)
                              VALUES (0, 1522837825, 0, '1APSxFtBTbtXFacQ4Tn3bcPLHdqwN8SBx4fmEh', 1 ,  0.06249911, 0)";
            $sth  = $pdo->prepare($sql2);
            $sth->execute();
            }
        else {

            $sql4 = 'SELECT best_block FROM block_info WHERE best_block=(SELECT max(best_block) FROM block_info)';
             $sth  = $pdo->prepare($sql4);
             $sth->execute();
             $row        = $sth->fetch();
             $last_block = $row[0];
             $block_diff = $latest_block - $last_block;
             if ($block_diff == 1) {
                $sql5 = 'SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info)';
                $sth  = $pdo->prepare($sql5);
                $sth->execute();
                $row             = $sth->fetch();
                $last_block_time = $row[0];
                $sql3 = 'SELECT AVG(time_diff) FROM block_info';
                $sth  = $pdo->prepare($sql3);
                $sth->execute();
                $row             = $sth->fetch();
                $avg_time = $row[0];
                $time_diff       = $latest_block_time - $last_block_time;
                $latest_hash_rate = $latest_difficulty/$avg_time;
                $sql6            = "INSERT INTO block_info(best_block, block_time, block_size, time_diff, miner, txcount, difficulty, hash_rate, fee)
             VALUES ('$latest_block','$latest_block_time', '$latest_block_size','$time_diff', '$latest_miner', '$latest_tx_count', '$latest_dificulty', '$latest_hash_rate', '$latest_fee' )";
                $sth             = $pdo->prepare($sql6);
                $sth->execute();
                 } else {
                    for ($i = 1; $i <= $block_diff; $i++) {
                        $last_block = $last_block + 1;
                        $block_info = getblock($last_block);
                        print_r($block_info);
                     
                        $sql7 = 'SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info)';
                            $sth  = $pdo->prepare($sql7);
                            $sth->execute();
                            $row             = $sth->fetch();
                            $last_block_time = $row[0];
                            $block_time = $block_info[3];
                            $time_diff       = $block_time - $last_block_time;
                            $tx_count = $block_info[0];
                            $difficulty = $block_info[1];
                            $miner = $block_info[2];
                            $fee = $block_info[4];
                            $block_size = $block_info[5];
                            $sql = 'SELECT AVG(time_diff) FROM block_info';
                            $sth  = $pdo->prepare($sql);
                            $sth->execute();
                            $row = $sth->fetch();
                            $avg_time = $row[0];
                            $hash_rate = $difficulty/$avg_time;
                            $sql8            = "INSERT INTO block_info(best_block, block_time, block_size, time_diff, miner, txcount, difficulty, hash_rate, fee)
                              VALUES ('$last_block', '$block_time', '$block_size', '$time_diff', '$miner', '$tx_count', '$difficulty','$hash_rate', '$fee')";
                            $sth             = $pdo->prepare($sql8);
                            $sth->execute();

                    } 

                     $sql11 = "SELECT COUNT(DISTINCT(miner)) FROM `block_info` ORDER BY id DESC LIMIT 1000";
                            $sth = $pdo->prepare($sql11);
                            $sth->execute();
                            $row = $sth->fetch();
                            $active_miners = $row[0];
                }

        $sql9 = "SELECT COUNT(id) FROM dynamic_values";
        $sth  = $pdo->prepare($sql9);
        $sth->execute();
        $row   = $sth->fetch();
        $count = $row[0];
        if ($count == 0) {
            $sql10 = "INSERT INTO dynamic_values(xrk_supply, blockchain_size, stream_items, total_addresses, total_miners, pending_tx, active_miners, total_streams)
                              VALUES ('$xrk_supply', '$blockchain_size', '$streams_items', '$total_addresses', '$total_miners' , '$pending_tx', '$active_miners', '$total_streams')";
            $sth  = $pdo->prepare($sql10);
            $sth->execute();
            }
        else {
             $sql11 = "UPDATE dynamic_values SET xrk_supply = '$xrk_supply', blockchain_size= '$blockchain_size', stream_items = '$streams_items', total_addresses = '$total_addresses', pending_tx = '$pending_tx', active_miners= '$active_miners', total_streams= '$total_streams' WHERE id=1"; 
             $sth  = $pdo->prepare($sql11);
            $sth->execute();
        }
      }
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
    $dificulty  = $result->result->difficulty;
    $miner      = $result->result->miner;
    $block_time = $result->result->time;
    $block_size = $result->result->size;
    $re = $result->result;
    $tx = $re->tx;
    $vout= $tx[0];
    $tx_out = $vout->vout;
    
    $value = $tx_out[0];
    $fee_value = $value->value;
    //echo($fee_value);

    $fees = $fee_value - 10;

} else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
error_log("ERROR: Info not fetched from blockchain");
    }
    return array($tx_count, $dificulty, $miner, $block_time, $fees, $block_size);
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
?>
