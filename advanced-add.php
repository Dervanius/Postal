<?php
session_start();
include 'db.php';
$resultNewCount = $_POST['resultNewCount'];


$client = $_SESSION['client'];
$fromDate = $_SESSION['from-date'];
$ToDate = $_SESSION['to-date'];
$invoice = $_SESSION['invoice'];
$getQuery = $_SESSION['getQuery'];


$result = $conn->query("SELECT
 d.id
,d.posiljkaId
,d.dokumentId
,p.BarkodPosiljke
,p.QRkodPosiljke
,p.DatumSlanja
,p.DatumOtpreme
,p.DatumPrispeca
,p.DatumPrijema
, p.KlijentId
,p.Status
,p.statusSlanja
,p.VremeKreiranja
,p.Kreirao
,p.Dostavio
,p.Kurir
,c.id
,c.Naziv
FROM
dokument d
INNER JOIN posiljka p ON d.posiljkaId = p.id
INNER JOIN clients c ON p.KlijentId = c.EksternaSifra AND 1 = 1 ".$getQuery."  ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT $resultNewCount ROWS ONLY");

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo   '<tr>';
              if($row['BarkodPosiljke'] == ''){
                echo '<td class="text-center">N/A</td>';
              }else {
                echo '<td class="text-center">'.$row['BarkodPosiljke'].'</td>';
              }
              echo '
              <td class="text-center">'.$row['Naziv'].'</td>
              <td class="text-center">'.$row['dokumentId'].'</td>
              <td class="text-center">'.substr($row['DatumSlanja'],0,10).'</td>
              <td class="text-center"><a href="advanced-print.php?bc='.$row['BarkodPosiljke'].'&client='.$row['Naziv'].'&date='.substr($row['DatumSlanja'],0,10).'"><img src="images/print-icon-2.svg" alt="print icon"></a></td>
            </tr>';
  }
  $conn = null;
