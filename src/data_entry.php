<?php
// load config
if ($_COOKIE["rk-network"] == "test")
$config = include('config-testnet.php');
else $config = include('config-mainnet.php');*/
$config  = include('config-testnet.php');
$rkHost  = $config["rk_host"];
$rkPort  = $config["rk_port"];
$rkUser  = $config["rk_user"];
$rkPwd   = $config["rk_pass"];
$rkChain = $config["rk_chain"];
$dbHost  = $config["db_host"];
$dbName  = $config["db_name"];
$dbUser  = $config["db_user"];
$dbPwd   = $config["db_pass"];
$amount  = 0;
echo ($dbHost);

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
    CURLOPT_POSTFIELDS => "{\"method\":\"getblock\",\"params\":[\"$latest_block\", 4],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
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
    //$re = $r[1];
    
    
    
    
    //$latest_miner  = $re->miner;
    //$latest_block_time  = $re->time;
    $latest_tx_count   = count($r);
    $latest_dificulty  = $result->result->difficulty;
    $latest_miner      = $result->result->miner;
    $latest_block_time = $result->result->time;
    //echo($latest_block_time);
    for ($i = 0; $i < $latest_tx_count; $i++) {
        
        //echo ($i);
        $re    = $r[$i];
        $res   = $re->vout;
        $resu  = $res[0];
        $txid  = $re->txid;
        $resul = $resu->scriptPubKey->addresses;
        $addr  = $resul[0];
        $curl  = curl_init();
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
            CURLOPT_POSTFIELDS => "{\"method\":\"getaddresstransaction\",\"params\":[\"$addr\", \"$txid\"],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            )
        ));
        error_log("Sending request: getaddresstransaction");
        $result   = json_decode(curl_exec($curl));
        //error_log(json_encode($result, JSON_PRETTY_PRINT));
        $err      = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //$difficulty  = 55;
        //$latest_block = 0;
        if ($httpCode == 200 && $result->error == null) {
            $amt    = $result->result->balance->amount;
            $amount = $amount + $amt;
            
        } else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
            error_log("ERROR: Info not fetched from blockchain");
        }
    }
    
    //echo($amount);
    $latest_fee = $amount - 10;
    //echo($fee);
} else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
    error_log("ERROR: Info not fetched from blockchain");
}


//print_r($re);

try {
    $connectionString =  "mysql:host=". $dbHost."; dbname=".$dbName.";";
    $pdo = new PDO($connectionString , $dbUser, $dbPwd);
    $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($pdo != NULL) {
        
        $sql2 = "SELECT COUNT(id) FROM block_info";
        $sth  = $pdo->prepare($sql2);
        $sth->execute();
        $row   = $sth->fetch();
        $count = $row[0];
        if ($count == 0) {
            $sql3 = "INSERT INTO block_info(best_block, block_time, time_diff, miner, txcount, difficulty, fee)
                              VALUES ('$latest_block', '$latest_block_time', 0, '$latest_miner', '$latest_tx_count', '$latest_dificulty', '$latest_fee')";
            $sth  = $pdo->prepare($sql3);
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
                $last_block_time = ($row[0]);
                $time_diff       = $latest_block_time - $last_block_time;
                $sql6            = "INSERT INTO block_info(best_block, block_time, time_diff, miner, txcount, difficulty, fee)
             VALUES ('$latest_block','$latest_block_time','$time_diff', '$latest_miner', '$lates_tx_count', '$latest_dificulty', '$fee' )";
                $sth             = $pdo->prepare($sql6);
                $sth->execute();
                 }
            else {

                 for ($i = 1; $i <= $block_diff; $i++) {

                        $last_block = $last_block + 1;
                        $curl       = curl_init();
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
                        CURLOPT_POSTFIELDS => "{\"method\":\"getblock\",\"params\":[\"$last_block\", 4],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
                        CURLOPT_HTTPHEADER => array(
                            "cache-control: no-cache",
                            "content-type: application/json"
                        )
                    ));
                        error_log("Sending request: getblock2");
                       $result   = json_decode(curl_exec($curl));
                       //error_log(json_encode($result, JSON_PRETTY_PRINT));
                      $err      = curl_error($curl);
                      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                      //$latest_block = 0;
                           if ($httpCode == 200 && $result->error == null) {

                           $r          = $result->result->tx;
                           $tx_count   = count($r);
                           $dificulty  = $result->result->difficulty;
                           $miner      = $result->result->miner;
                           $block_time = $result->result->time;
                               for ($i = 0; $i < $tx_count; $i++) {
                               $re    = $r[$i];
                            $res   = $re->vout;
                            $resu  = $res[0];
                            $txid  = $re->txid;
                            $resul = $resu->scriptPubKey->addresses;
                            $addr  = $resul[0];
                            $curl  = curl_init();
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
                                CURLOPT_POSTFIELDS => "{\"method\":\"getaddresstransaction\",\"params\":[\"$addr\", \"$txid\"],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
                                CURLOPT_HTTPHEADER => array(
                                    "cache-control: no-cache",
                                    "content-type: application/json"
                                )
                            ));
                            error_log("Sending request: getaddresstransaction2");
                            $result   = json_decode(curl_exec($curl));
                            //error_log(json_encode($result, JSON_PRETTY_PRINT));
                            $err      = curl_error($curl);
                            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                            if ($httpCode == 200 && $result->error == null) {
                                $amt    = $result->result->balance->amount;
                                $amount = $amount + $amt;
                                echo($amount);
                                      }
                                      else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
                                     error_log("ERROR: Info not fetched from blockchain");
                                      }
                                       

                                   }

                                   $fee = $amount - 10;

                                  
                             }

                               else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
                                    error_log("ERROR: Info not fetched from blockchain");
                                }

                             $sql7 = 'SELECT block_time FROM block_info WHERE id=(SELECT max(id) FROM block_info)';
                            $sth  = $pdo->prepare($sql7);
                            $sth->execute();
                            $row             = $sth->fetch();
                            $last_block_time = $row[0];
                            $time_diff       = $block_time - $last_block_time;
                            $sql8            = "INSERT INTO block_info(best_block, block_time, time_diff, miner, txcount, difficulty, fee)
                              VALUES ('$last_block', '$block_time', '$time_diff', '$miner', '$tx_count', '$dificulty', '$fee')";
                            $sth             = $pdo->prepare($sql8);
                            $sth->execute();
                        }
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
?>
