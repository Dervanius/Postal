<?php
ini_set('max_execution_time', '600'); //600 seconds = 10 minutes
include 'db.php';


$q = $conn->query("WITH
prazne (klijent, vreme,id)
AS (
SELECT  KlijentId, LEFT(CONVERT(varchar,VremeKreiranja,3),18) as vreme, 'CRR'+ KlijentId + '/' +LEFT(CONVERT(varchar,VremeKreiranja,3),18) AS id
FROM shipments s
WHERE BarkodPosiljke = '' AND BarkodSadrzaj != ''
GROUP BY KlijentId, LEFT(CONVERT(varchar,VremeKreiranja,3),18)
)

SELECT
s.BarkodPosiljke, s.BarkodSadrzaj, DatumSlanja, s.KlijentId ,s.Status,s.statusSlanja, s.VremeKreiranja, p.id AS jedinstven
FROM shipments s
INNER JOIN prazne p ON s.KlijentId = p.klijent AND p.vreme = LEFT(CONVERT(varchar,s.VremeKreiranja,3),18)
WHERE BarkodPosiljke = '' AND BarkodSadrzaj != ''")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php
    foreach ($q as $row) {
      $newBarkode = $row['jedinstven'];
      //$newBarkodSadrzaj = $row['BarkodSadrzaj'];
      $newDatumSlanja = $row['DatumSlanja'];
      $newKlijentId = $row['KlijentId'];
      $newStatus = $row['Status'];
      $newstatusSlanja = $row['statusSlanja'];
      $newVremeKreiranja = $row['VremeKreiranja'];


      // echo $newBarkode.' - '. $newDatumSlanja.' - '.$row['KlijentId'].' - '.$row['Status'].' - '.$row['statusSlanja'].' - '.$row['VremeKreiranja'];
      // echo '<br>';

      $stmt = $conn->prepare("INSERT INTO tempPosiljka (BarkodPosiljke, DatumSlanja, KlijentId, Status, statusSlanja, VremeKreiranja) VALUES (:newBarkode,:newDatumSlanja,:newKlijentId,:newStatus,:newstatusSlanja, :newVremeKreiranja)");
      $stmt->bindParam(':newBarkode', $newBarkode);
      $stmt->bindParam(':newDatumSlanja', $newDatumSlanja);
      $stmt->bindParam(':newKlijentId', $newKlijentId);
      $stmt->bindParam(':newStatus', $newStatus);
      $stmt->bindParam(':newstatusSlanja', $newstatusSlanja);
      $stmt->bindParam(':newVremeKreiranja', $newVremeKreiranja);
      $stmt->execute();
      }
    ?>

  </body>
</html>
