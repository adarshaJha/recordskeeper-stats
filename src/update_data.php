<?php
$config = include('config-mainnet.php');
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

try {
    $connectionString =  "mysql:host=". $dbHost."; dbname=".$dbName.";";
    $pdo = new PDO($connectionString , $dbUser, $dbPwd);
    $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($pdo != NULL) {
    for($last_block=1; $last_block<= $latest_block; $last_block++){
         $sql = "SELECT block_time FROM block_info WHERE best_block= '$last_block'";
                            $sth  = $pdo->prepare($sql);
                            $sth->execute();
                            $row             = $sth->fetch();
                            $last_block_time = $row[0];
                            $avg_block_time = ($last_block_time - $genesis_block_time)/$last_block;
          $sql2 = "UPDATE block_info SET avg_block_time = '$avg_block_time' WHERE best_block = '$last_block'"; 
             $sth  = $pdo->prepare($sql2);
            $sth->execute();
            error_log($last_block);
    }

    }

    $sth = null;
    $pdo = null;

} catch (Exception $e) {
    error_log("ERROR:couldn't connect" . $e->getMessage());
}
catch (PDOException $e) {
    error_log("ERROR: couldn't insert" . $e->getMessage());
 }


?>
