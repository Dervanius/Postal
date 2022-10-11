<?php

// $hostname = '10.5.254.30';
// $database = 'Razvoj';
// $username = 'phpuser';
// $password = 'Test##1234';

// function testdb_connect($hostname, $database, $username, $password)
// {
//     $conn = new PDO("sqlsrv:Server=$hostname;Database=$database", $username, $password);
//     date_default_timezone_set("Europe/Belgrade");
//     return $conn;
// }
try {
    // $conn = testdb_connect($hostname,  $database, $username, $password);
    // // echo 'Connected to SQL';

    $sqlR = new PDO('sqlsrv:Server=10.5.254.30; Database=Razvoj', 'phpuser', 'Test##1234');
    $sqlP = new PDO('sqlsrv:Server=10.5.254.30; Database=posta', 'phpuser', 'Test##1234');
    date_default_timezone_set("Europe/Belgrade");
    
} catch (PDOException $e) {
    echo $e->getMessage();
}




  


//$query = $sqlCC->query("SELECT * FROM Zaposleni ROWS FETCH NEXT 2 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
