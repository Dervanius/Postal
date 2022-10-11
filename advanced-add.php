<?php
session_start();
include 'db.php';
$resultNewCount = $_POST['resultNewCount'];

// $client = trim($_POST['client']);
// $date = trim($_POST['date']);
// $invoice = trim($_POST['invoice']);
$client = $_SESSION['client'];
$date = $_SESSION['date'];
$invoice = $_SESSION['invoice'];

function listAll($row){
      if($row['BarkodPosiljke'] == ''){
        echo "<tr><td>N/A</td>";
      }else {
        echo "<tr><td>".$row['BarkodPosiljke']."</td>";
      }
      echo "<td>".$row['Naziv']."</td>";
      if($row['BarkodSadrzaj'] == ''){
        echo "<td>N/A</td>";
      }else {
        echo "<td>".$row['BarkodSadrzaj']."</td>";
      }
      echo "<td>".substr($row['DatumSlanja'],0,10)."</td></tr>";
}

$query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra ORDER BY DatumSlanja")->fetchall(PDO::FETCH_ASSOC);
switch ($query) {
  case $client !== "" && $date !== "" && $invoice !== "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' AND datumSlanja >= '".$date."' AND BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
  case $client !== "" && $date !== "" && $invoice === "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' AND datumSlanja >= '".$date."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
  case $client !== "" && $date === "" && $invoice === "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
  case $client === "" && $date === "" && $invoice === "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra ORDER BY DatumSlanja OFFSET 0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
  case $client === "" && $date !== "" && $invoice === "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE datumSlanja >= '".$date."' ORDER BY DatumSlanja DESC OFFSET 0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
  case $client === "" && $date !== "" && $invoice !== "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE datumSlanja >= '".$date."' AND BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
  case $client === "" && $date === "" && $invoice !== "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
  case $client !== "" && $date === "" && $invoice !== "":
    $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' AND BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
    include 'advanced-head-more.php';
    foreach ($query as $row) {
      listAll($row);
    }
    include 'advanced-foot-more.php';
    break;
}
