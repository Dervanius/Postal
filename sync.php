<?php
require 'dbh.php';


try {
    $mysql = new PDO("mysql:host=budo180.adriahost.com;dbname=transfer_posta", 'transfer_posta', ')x%k5R4[sdIe');
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "mySQL konekcija uspešna!<hr>";
} catch (Exception $e) {
    die($e->getMessage());
}


//PREBACIVANJE IZ SQL u MYSQL
$posiljke = $sqlP->query("SELECT  p.id, QRkodPosiljke, DatumSlanja, p.VremeKreiranja, k.Naziv klijent 
                            FROM posiljka p 
                            INNER JOIN CustomsClearance.dbo.Klijenti k ON p.KlijentId = k.Id 
                            WHERE statusSlanja = 0 AND Kurir = 1");

$insertMysql = $mysql->prepare("INSERT INTO posiljka (posiljkaId, qr, klijent, datumOtpreme) VALUES (:pid, :qr, :klijent, :datum)");
$updateStatusSlanja = $sqlP->prepare("UPDATE posiljka SET statusSlanja = 1 WHERE id = :id");

while ($pos = $posiljke->fetch(PDO::FETCH_ASSOC)) {
    try {
        $insertMysql->execute([

            'pid' => $pos['id'],
            'qr' => $pos['QRkodPosiljke'],
            'klijent' => $pos['klijent'],
            'datum' => $pos['DatumSlanja']
        ]);
        $updateStatusSlanja->execute([
            'id' => $pos['id']
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}





// AŽURIRANJE IZ MYSQL u SQL
$selectMysql = $mysql->query("SELECT posiljkaId, datumPrijema FROM posiljka WHERE statusRazmene = 0 AND datumPrijema IS NOT NULL");

$updateStatus = $sqlP->prepare("UPDATE posiljka SET Status = 4, DatumPrijema = :datum WHERE id = :id");
$updateMysqlStatusSlanja = $mysql->prepare("UPDATE posiljka SET statusRazmene = 1, vremeRazmene = now() WHERE posiljkaId = :id");

while ($status = $selectMysql->fetch(PDO::FETCH_ASSOC)) {
    try {
        $updateStatus->execute([
            'datum' => $status['datumPrijema'],
            'id' => $status['posiljkaId']
        ]);
        $updateMysqlStatusSlanja->execute([
            'id' => $status['posiljkaId']
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


?>