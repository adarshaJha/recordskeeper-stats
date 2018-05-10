<?php
$dbHost = 'recordskeeper-prod-db.cv9ktj9d3xrt.us-east-1.rds.amazonaws.com';
$dbUsername = 'rk-pd-m-stats';
$dbPassword = 'MSOjcFwLARHfbaZY';
$dbName = 'rk-prod-mainnet-stats';

//Create connection and select DB
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Unable to connect database: " . $conn->connect_error);
}

?>