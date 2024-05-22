<?php
session_start();
include 'db.php';
$resultNewCount = $_POST['resultNewCount'];


$client = $_SESSION['client'];
$fromDate = $_SESSION['from-date'];
$ToDate = $_SESSION['to-date'];
$invoice = $_SESSION['invoice'];
$getQuery = $_SESSION['getQuery'];


$result = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE 1 = 1 ".$getQuery." ORDER BY VremeKreiranja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY");

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo   '<tr>';
              if($row['BarkodPosiljke'] == ''){
                echo '<td class="text-center">N/A</td>';
              }else {
                echo '<td class="text-center">'.$row['BarkodPosiljke'].'</td>';
              }
              echo '
              <td class="text-center">'.$row['Naziv'].'</td>
              <td class="text-center">'.$row['BarkodSadrzaj'].'</td>
              <td class="text-center">'.substr($row['DatumSlanja'],0,10).'</td>
              <td class="text-center"><a href="advanced-print.php?bc='.$row['BarkodPosiljke'].'&client='.$row['Naziv'].'&date='.substr($row['DatumSlanja'],0,10).'"><img src="images/print-icon-2.svg" alt="print icon"></a></td>
            </tr>';
  }
  $conn = null;
