<?php
$dbHost = 'toshendra.cv9ktj9d3xrt.us-east-1.rds.amazonaws.com';
$dbUsername = 'rk-visualr';
$dbPassword = 'QJyhSnKZfwJfxHwc';
$dbName = 'rk-test-misc';

//Create connection and select DB
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Unable to connect database: " . $conn->connect_error);
}

?>