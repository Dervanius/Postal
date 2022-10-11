<?php
include 'db.php';
$resultNewCount = $_POST['resultNewCount'];
$query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra ORDER BY DatumSlanja DESC OFFSET 0 ROWS
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
