<?php

require_once('dumper-config.php');

/*
dumper-config.php content

<?php
    $abeDB = 'sqlite db file';
    $db_host = "db host";
    $db_user = "db user";
    $db_pass = "db pssword";
    $db_name = "db name";
?>

*/


class MyDB extends SQLite3 {
      function __construct($liteDb) {
         $this->open($liteDb);
      }
   }

   $db = new MyDB($abeDB);
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

$sql =<<<EOF
      SELECT * from  abe_sequences;
EOF;

$tx=0;
$txin=0;
$txout=0;
$block=0;

$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
if ( $row['sequence_key'] == 'tx' ) $tx = $row['nextid'];
    if ( $row['sequence_key'] == 'txin' ) $txin = $row['nextid'];
    if ( $row['sequence_key'] == 'txout' ) $txout = $row['nextid'];
    if ( $row['sequence_key'] == 'block' ) $block = $row['nextid'];
    echo "Key = ". $row['sequence_key'] . "\n";
    echo "Value = ". $row['nextid'] ."\n";
}
echo "Operation done successfully\n";
$db->close();

// write into mysql

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO transaction_info  (tx, txin, txout, block)
VALUES ($tx, $txin, $txout, $block)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>