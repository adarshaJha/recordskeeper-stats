<?php
// load config
  if ($argv[1] == "test") {
  $config = include('config-testnet.php'); 
  }
else {
    $config = include('config-mainnet.php');
   } 
$rkHost  = $config["rk_host"];
$rkPort  = $config["rk_port"];
$rkUser  = $config["rk_user"];
$rkPwd   = $config["rk_pass"];
$rkChain = $config["rk_chain"];
$dbHost  = $config["db_host"];
$dbName  = $config["db_name"];
$dbUser  = $config["db_user"];
$dbPwd   = $config["db_pass"];
$accessKey = $config["access-key"];
$miner_location = getPeerInfo();

   try {
    $connectionString =  "mysql:host=". $dbHost."; dbname=".$dbName.";";
    $pdo = new PDO($connectionString , $dbUser, $dbPwd);
    $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($pdo != NULL) {
        $sql = "UPDATE miner_location SET latest_update = 0";
            $sth  = $pdo->prepare($sql);
            $sth->execute();
        $size = count($miner_location);
        for($i=0; $i<$size; $i++){
            $miner_info = $miner_location[$i];
            $ip = $miner_info['ip'];
            $country_name = $miner_info['country_name'];
            $country_code = $miner_info['country_code'];
            $region_code = $miner_info['region_code'];
            $region_name = $miner_info['region_name'];
            $city = $miner_info['city'];
            $latitude = $miner_info['latitude'];
            $longitude = $miner_info['longitude'];

            $sql2 = "SELECT * FROM miner_location WHERE ip = '$ip'";
            $sth  = $pdo->prepare($sql2);
            $sth->execute();
            $row   = $sth->fetch();
            $count = $row[0];
            if ($count == 0) {
            $sql = "INSERT INTO miner_location(ip, country_name, country_code, region_code, region_name, city, latitude, longitude, latest_update) VALUES ('$ip', '$country_name', '$country_code', '$region_code', '$region_name', '$city', '$latitude', '$longitude', 1)";
            $sth  = $pdo->prepare($sql);
            $sth->execute();
            error_log("New information added:".$ip);

             } else {
             	 $sql = "UPDATE miner_location SET ip = '$ip', country_name= '$country_name', country_code = '$country_code', region_code = '$region_code', region_name = '$region_name', city = '$city', latitude= '$latitude', longitude= '$longitude', latest_update = 1 WHERE ip='$ip'"; 
             $sth  = $pdo->prepare($sql);
            $sth->execute();
            error_log("Information updated:".$ip);
        }

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

function getPeerInfo(){
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
    CURLOPT_POSTFIELDS => "{\"method\":\"getpeerinfo\",\"params\":[],\"id\":1,\"chain_name\":\"" . $GLOBALS["rkChain"] . "\"}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json"
    )
));
error_log("Sending request: getPeerInfo");
$result   = json_decode(curl_exec($curl));
//error_log(json_encode($result, JSON_PRETTY_PRINT));
$err      = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($httpCode == 200 && $result->error == null) {
    $info = $result->result;
    $count = count($info);

    for($i=0; $i<$count; $i++){
    
    $miner = $info[$i];
    $ip = $miner->addr;
    $urlParts = parse_url($ip);
    $ip_final = $urlParts['host'];
    // set IP address and API access key 
    $access_key = $GLOBALS['accessKey'];

// Initialize CURL:
    $str = 'http://api.ipstack.com/'.$ip_final.'?access_key='.$access_key.'';
    $ch = curl_init($str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
    $json = curl_exec($ch);
    curl_close($ch);

// Decode JSON response:
   $api_result = json_decode($json, true);

// Output the "capital" object inside "location"
 $ip_user[$i] = $ip_final;
 $country_code[$i] = $api_result['country_code'];
 $country_name[$i] = $api_result['country_name'];
 $region_code[$i] = $api_result['region_code'];
 $region_name[$i] = $api_result['region_name'];
 $city[$i] = $api_result['city'];
 $latitude[$i] = $api_result['latitude'];
 $longitude[$i] = $api_result['longitude'];
 $miner_info[$i] = array("ip" => $ip_user[$i], "country_code" => $country_code[$i], "country_name" => $country_name[$i], "region_code" => $region_code[$i], "region_name" => $region_name[$i], "city" => $city[$i], "latitude" => $latitude[$i], "longitude" => $longitude[$i]);
 } 
 } else if ($httpCode != 200 || ($httpCode == 200 && $result->error != null)) {
    error_log("ERROR: Info not fetched from blockchain");
}
  return $miner_info;
}
?>
