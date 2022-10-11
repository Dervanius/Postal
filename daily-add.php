<?php
session_start();
include 'db.php';
$resultNewCount = $_POST['resultNewCount'];
$today = $_SESSION['today'];

$query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE DatumSlanja = '".$today."' ORDER BY DatumSlanja DESC OFFSET 0 ROWS
          FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);

          foreach ($query as $row){
            //try first
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
