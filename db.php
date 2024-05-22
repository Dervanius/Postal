<?php

$hostname = '10.5.254.30';
$database = 'posta';
$username = 'phpuser';
$password = 'Test##1234';

function testdb_connect($hostname, $database, $username, $password)
{
    $conn = new PDO("sqlsrv:Server=$hostname;Database=$database", $username, $password);
    date_default_timezone_set("Europe/Belgrade");
    return $conn;
}
try {
    $conn = testdb_connect($hostname,  $database, $username, $password);
    // echo 'Connected to SQL';
} catch (PDOException $e) {
    echo $e->getMessage();
}



//$query = $sqlCC->query("SELECT * FROM Zaposleni ROWS FETCH NEXT 2 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
