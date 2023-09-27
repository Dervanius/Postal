<?php
include 'dbh.php';
$resultNewCount = $_POST['resultNewCount'];
$query = $sqlP->query("SELECT * FROM posiljka
          LEFT JOIN clients ON posiljka.KlijentId=clients.EksternaSifra
          INNER JOIN dokument ON dokument.posiljkaId = posiljka.id
          ORDER BY DatumSlanja DESC OFFSET 0 ROWS
          FETCH NEXT $resultNewCount ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);

          foreach ($query as $row){
            //try first
            if($row['BarkodPosiljke'] == ''){
              echo "<tr><td>N/A</td>";
            }else {
              echo "<tr><td>".$row['BarkodPosiljke']."</td>";
            }
            echo "<td>".$row['Naziv']."</td>";
            if($row['dokumentId'] == ''){
              echo "<td>N/A</td>";
            }else {
              echo "<td>".$row['dokumentId']."</td>";
            }
            echo "<td>".substr($row['DatumSlanja'],0,10)."</td></tr>";
          }
