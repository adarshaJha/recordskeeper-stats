<?php
$config = include('config.php');

// Escape user inputs for security
$address = $_REQUEST['address'];
    
    try{
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => $config['rk_port'],
        CURLOPT_URL => $config['rk_host'],
        CURLOPT_USERPWD => $config['rk_user'].":".$config['rk_pass'],
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"method\":\"send\",\"params\":[\"$address\",10],\"chain_name\":\"recordskeeper-test\"}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
        ),
        ));

        error_log("Sending request");

        $result = curl_exec($curl);
        error_log(json_encode($result, JSON_PRETTY_PRINT));
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        header('Content-Type: application/json');
        echo $result;
        
    }
    catch(Exception $e){
        error_log("ERROR: could not connect to recordskeeper". $e->getMessage());
    }
?>