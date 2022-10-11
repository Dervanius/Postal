<?php
//test tabela
session_start();
$dbase = new PDO('sqlsrv:Server=10.5.254.30; Database=Razvoj', 'phpuser', 'Test##1234');
date_default_timezone_set("Europe/Belgrade");


$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link."<br>";
$brojPosiljke = substr($actual_link,-13);

// echo $actual_link;
// echo "<br>";
// echo $_SESSION('brojPosiljke');
// echo "<br>";

//echo $actual_link;
//echo substr($actual_link,0,6);
// echo '<br>';
//
// $x = substr($actual_link,-21);
// echo $x;

?>
<!doctype html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>POŠTA</title>
</head>
<body>
<?php
try {
  $update = $dbase->prepare("UPDATE shipments SET statusSlanja='1' WHERE BarkodPosiljke = :brojPosiljke;");
  // $insert1->bindParam(':brojPosiljke', $_SESSION['brojPosiljke']);
  $update->bindParam(':brojPosiljke', $brojPosiljke);
  $update->execute();
  echo '
  <div class="mt-4 p-5 bg-primary text-white rounded">
  <h3>Status pošiljke je uspešno izmenjen</h3>
</div>
  ';
} catch (\Exception $e) {
  echo '
  <div class="mt-4 p-5 bg-danger text-white rounded">
  <h3>Greška u slanju pošiljke</h3>
</div>
  ';
}


 ?>
</body>
</html>
