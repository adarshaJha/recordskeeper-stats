<?php
include('dbconfig.php');
if(isset($_GET['fixedvalue'])){
$fixedquery = "select * from fixed_values";
$executefixed = mysqli_query($conn,$fixedquery);
$resfsquery = mysqli_fetch_assoc($executefixed);
    echo json_encode($resfsquery);
}

if(isset($_GET['dynamicvalue'])){
$dynamicquery = "select * from dynamic_values";
$executedynamic = mysqli_query($conn,$dynamicquery);
$dynfsquery = mysqli_fetch_assoc($executedynamic);
    echo json_encode($dynfsquery);
}


if(isset($_GET['totaltransactioncount'])){
$txncountquery = "select max(best_block) as block ,count(txcount) as txcnt, sum(data_items) as records from block_info";
$executcount = mysqli_query($conn,$txncountquery);
$txncountfsquery = mysqli_fetch_assoc($executcount);
    echo json_encode($txncountfsquery);
}

if(isset($_GET['bestblocknumber'])){
$bestblockquery = "select best_block,time_diff from block_info order by id desc limit 1";
$executbestblock = mysqli_query($conn,$bestblockquery);
$bestfsquery = mysqli_fetch_assoc($executbestblock);
    echo json_encode($bestfsquery);
}


if(isset($_GET['avgdatapublish'])){
$avgdatapubquery = "SELECT sum(data_size) as size,max(best_block) as block FROM block_info";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$pubdataaquery = mysqli_fetch_assoc($executavgdata);
    echo json_encode($pubdataaquery);
}

if(isset($_GET['chartdifficultdata'])){
$avgdatapubquery = "SELECT difficulty,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    $menu[] = array("block" => $row['best_block'], "diff" => $row['difficulty']);
}
echo json_encode($menu);
}

if(isset($_GET['charthasgratedata'])){
$avgdatapubquery = "SELECT hash_rate,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    $menu[] = array("block" => $row['best_block'], "hash" => $row['hash_rate']);
}
echo json_encode($menu);
}

if(isset($_GET['averageblocktimedata'])){
$avgdatapubquery = "SELECT avg_block_time,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    $menu[] = array("block" => $row['best_block'], "avgtime" => $row['avg_block_time']);
}
echo json_encode($menu);
}

if(isset($_GET['transactionvsblock'])){
$avgdatapubquery = "SELECT txcount,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    $menu[] = array("block" => $row['best_block'], "count" => $row['txcount']);
}
echo json_encode($menu);
}

if(isset($_GET['medianfeesblock'])){
$avgdatapubquery = "SELECT fee,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    $menu[] = array("block" => $row['best_block'], "fees" => $row['fee']);
}
echo json_encode($menu);
}

if(isset($_GET['diffcultyvstimechart'])){
$avgdatapubquery = "SELECT difficulty,block_time FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("time" => date('d M Y H:i:s',$row['block_time']), "diff" => $row['difficulty']);
}
echo json_encode($menu);
}

if(isset($_GET['hasratevstimechart'])){
$avgdatapubquery = "SELECT hash_rate,block_time FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("time" => date('d M Y H:i:s',$row['block_time']), "hash" => $row['hash_rate']);
}
echo json_encode($menu);
}

if(isset($_GET['minersvstimechart'])){
$avgdatapubquery = "SELECT total_miners,block_time FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("time" => date('d M Y H:i:s',$row['block_time']), "miners" => $row['total_miners']);
}
echo json_encode($menu);
}

if(isset($_GET['transactionvstimechart'])){
$avgdatapubquery = "SELECT txcount,block_time FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("time" => date('d M Y H:i:s',$row['block_time']), "txn" => $row['txcount']);
}
echo json_encode($menu);
}

if(isset($_GET['mfeesvstimechart'])){
$avgdatapubquery = "SELECT fee,block_time FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("time" => date('d M Y H:i:s',$row['block_time']), "fees" => $row['fee']);
}
echo json_encode($menu);
}

if(isset($_GET['recordvsblockchart'])){
$avgdatapubquery = "SELECT data_items,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("block" => $row['best_block'], "item" => $row['data_items']);
}
echo json_encode($menu);
}

if(isset($_GET['recordsavgvstimedatachart'])){
$avgdatapubquery = "SELECT data_items,block_time FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("time" => date('d M Y H:i:s',$row['block_time']), "items" => $row['data_items']);
}
echo json_encode($menu);
}

if(isset($_GET['datasizevstimedatachart'])){
$avgdatapubquery = "SELECT data_size,block_time FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("time" => date('d M Y H:i:s',$row['block_time']), "size" => $row['data_size']);
}
echo json_encode($menu);
}

if(isset($_GET['datasizevsblockdatachart'])){
$avgdatapubquery = "SELECT data_size,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("block" => $row['best_block'], "size" => $row['data_size']);
}
echo json_encode($menu);
}

if(isset($_GET['medianblocksizechart'])){
$avgdatapubquery = "SELECT block_size,best_block FROM block_info order by id desc limit 25";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("block" => $row['best_block'], "size" => $row['block_size']);
}
echo json_encode($menu);
}

if(isset($_GET['tabledataforminers'])){
$avgdatapubquery = "SELECT info.code_name,blo.miner,blo.block_time,blo.best_block,blo.miner_tx_id,blo.fee,blo.difficulty  FROM block_info blo , miner_info info where blo.miner = info.miner_address order by id desc limit 40";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    
    $menu[] = array("name" => $row['code_name'], "address" => $row['miner'], "time" => date('d M Y H:i:s',$row['block_time']), "block" => $row['best_block'], "txid" => $row['miner_tx_id'], "fees" => $row['fee'], "diff" => $row['difficulty']);
}
echo json_encode($menu);
}


if(isset($_GET['mapdataminersall'])){
$avgdatapubquery = "SELECT ip,country_name,city,longitude,latitude from miner_location";
$executavgdata = mysqli_query($conn,$avgdatapubquery);
$menu = array();
while ($row = mysqli_fetch_array($executavgdata)) {
    $menu[] = array("ip" => $row['ip'], "country" => $row['country_name'], "radius" => 4, "city" => $row['city'], "longitude" => $row['longitude'], "latitude" => $row['latitude']);
}
echo json_encode($menu);
}

if(isset($_GET['averagedatavaluueblock'])){
    //average block time.   latest (blocktime-genesistime)/latestblocknum
$avgdatapubquery = "SELECT best_block as blocknum, block_time as time FROM block_info order by id desc limit 1";
$executedynamic = mysqli_query($conn,$avgdatapubquery);
$dynfsquery = mysqli_fetch_assoc($executedynamic);
$avgtime = ($dynfsquery['time']-1522831575)/$dynfsquery['blocknum'];

//echo $dynfsquery['time'];
    echo json_encode($avgtime);
}

if(isset($_GET['medianblocksize'])){
    //average block time.   latest (blocktime-genesistime)/latestblocknum
$avgdatapubquery = "SELECT sum(block_size) as sum, max(best_block) as block FROM `block_info` ";
$executedynamic = mysqli_query($conn,$avgdatapubquery);
$dynfsquery = mysqli_fetch_assoc($executedynamic);
$medianblocksize = $dynfsquery['sum']/$dynfsquery['block'];
echo $medianblocksize;
}

?>