<?php

try {
    $sqlR = new PDO('sqlsrv:Server=10.5.254.30; Database=Razvoj', 'phpuser', 'Test##1234');
    $sqlP = new PDO('sqlsrv:Server=10.5.254.30; Database=posta', 'phpuser', 'Test##1234');
    date_default_timezone_set("Europe/Belgrade");
} catch (PDOException $e) {
    echo $e->getMessage();
}
