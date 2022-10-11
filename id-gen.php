<?php
try {
    $sqlR = new PDO('sqlsrv:Server=10.5.254.30; Database=Razvoj', 'phpuser', 'Test##1234');
    date_default_timezone_set("Europe/Belgrade");
    
} catch (PDOException $e) {
    echo $e->getMessage();
}


$brojac = $sqlR->prepare("EXEC GetBrojac :dokument, :godina");
$brojac->execute([
  'dokument' => 'posta',
  'godina' => date_format(date_create(), 'y')
]);
$result = $brojac->fetch(PDO::FETCH_ASSOC);




// $prefix = "TR";
// $middle = date("y");
// $n = 30;
// function getSuffix($n)
// {
//   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//   $randomString = '';

//   for ($i = 0; $i < $n; $i++) {
//     $index = rand(0, strlen($characters) - 1);
//     $randomString .= $characters[$index];
//   }

//   return $randomString;
// }

// // $sufix = getSuffix($n);
// $qr = trim(getSuffix($n));
// $fullId = trim($prefix).$middle.trim($sufix);

$fullId = $result['prefix'].$result['godina'].substr($result['format'].(string)$result['broj'],-strlen($result['format']));
// $kurir = 1;
echo $fullId;
// echo   $qr;
// echo 'Bane';
//  $_SESSION['prefix'] = $prefix;
