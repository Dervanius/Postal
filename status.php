<?php
session_start();
error_reporting(0);
include 'dbh.php';
$klijent = $_SESSION['klijent'];
include 'header.php';
?>

<script>
  $(document).ready(function() {
    $("#back").click(function() {
      history.back();
    });
  });
</script>

<?php
if (isset($_POST['submit']) && !empty($_SESSION['klijent']) && count($_POST["barcode"]) > 0) {

  $kurir = $_SESSION['kurir'];
  unset($_SESSION['kurir']);
  $codes = $_POST["barcode"];
  $barcodes = array_unique($codes);
  $_SESSION['barcodes'] = $barcodes;
  $klijent = $_SESSION['klijent'];
  $klijentId = $sqlP->query("SELECT EksternaSifra FROM clients WHERE Naziv ='" . $klijent . "'")->fetch(PDO::FETCH_NUM);

  echo '
    </head>
  <body>

  <div class="container mt-3">
    <div class="mt-4 p-5 bg-success text-white rounded">
      <h1>Uspešan unos</h1>
      <p>Pošiljka pod brojem <strong>';
  echo $_SESSION['brojPosiljke'];
  echo '</strong> za <strong>';
  echo $klijent;
  echo '</strong> je uneta u bazu.</p>
      <hr>
      <div class="row">
        <div class="col">
          <p>Štampaj specifikaciju</p>
          <a href="print.php"><button class="btn btn-dark" title="Štampaj"><img src="images/print-icon.svg" alt="print icon"></button></a>

        </div>
        <div class="col">
        </div>
        <div class="col">
          <p>Nazad na početak</p>
          <a href="index.php"><button class="btn btn-warning" title="Početna stranica"><img src="images/home-icon.svg" alt="home icon"></button></a>
        </div>
      </div>

    </div>
  </div>

  </body>
  </html>';
  $insert1 = $sqlP->prepare("INSERT INTO posiljka (BarkodPosiljke, QRkodPosiljke, DatumSlanja, KlijentId, Kurir) VALUES (:brojPosiljke, :QRkodPosiljke, :datumSlanja, :klijentId, :kurir)");
  $insert2 = $sqlP->prepare("INSERT INTO dokument (posiljkaId, dokumentId) VALUES (:posiljka, :dokument)");

  $datumSlanja = date('Y-m-d', $_SESSION['vremeUnosa']);
  $sqlP->beginTransaction();

  $insert1->execute([
    'brojPosiljke' => $_SESSION['brojPosiljke'],
    'QRkodPosiljke' => $_SESSION['qrCode'],
    'datumSlanja' => $datumSlanja,
    'klijentId' => $klijentId[0],
    'kurir' => $kurir
  ]);

  $id = $sqlP->lastInsertId();

  $x = 0;
  foreach ($barcodes as $barcode) {
    $x++;

    if ($barcode != '') {
      $insert2->execute([
        'posiljka' => $id,
        'dokument' => $barcode
      ]);
    }
  }
} else {
  echo '
    </head>
  <body>

  <div class="container mt-3">
    <div class="mt-4 p-5 bg-danger text-white rounded">
      <h1>Neuspešan unos</h1>
      <p>Pošiljka pod brojem <strong>';
  echo $_SESSION['brojPosiljke'];
  echo '</strong> za <strong>';
  echo $klijent;
  echo '</strong> nema stavke.</p>
      <hr>
      <div class="row">
        <div class="col">
          <p>Unesite stavke</p>
          <button class="btn btn-success" id="back"><img src="images/page-icon.svg" alt="page icon"></button>
        </div>
        <div class="col">
        </div>
        <div class="col">
          <p>Nazad na početak</p>
          <a href="index.php"><button class="btn btn-warning"><img src="images/home-icon.svg" alt="home icon"></button></a>
        </div>
      </div>

    </div>
  </div>

  </body>
  </html>';
}

$sqlP->commit();

?>
