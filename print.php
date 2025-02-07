<?php
session_start();

use chillerlan\QRCode\QRCode;

include './vendor/autoload.php';

if (isset($_POST['content']) && !empty($_POST['content'])) {
  $result = (new QRCode())->render("kurir.transfera.com/index.php?qr=" . $_SESSION['qrCode']);
}

$brojPosiljke = $_SESSION['brojPosiljke'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Štampa pošiljke</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="printThis.js"></script>
  <script>
    $(document).ready(function() {
      $("#print").click(function() {
        $("#myText").printThis();
      });
      $("#footer").hide();
      $("#print").click(function() {
        $("#footer").show();
      });
      $("#header").hide();
      $("#print").click(function() {
        $("#header").show();
      });
    });
  </script>
</head>

<body>
  <div class="container-fluid">

    <div class="container" <?php
                            if (isset($_POST['napomena'])) {
                              echo 'hidden';
                            }
                            ?>>
      <form action="print.php" method="post" class="mt-3">
        <div>
          <input type="text" class="form-control" name="content" value="<?php echo $brojPosiljke; ?>" style="width:500px; display:none;">
        </div>
        <div class="">
          <label for="napomena">Napomena:</label></br>
          <textarea name="napomena" rows="8" cols="80">Jedan potpisan primerak vratiti "Transfera DOO".</textarea>
          <?php
          if (!isset($_POST['napomena'])) {
            echo ' - ';
          } else {
            $napomena = $_POST['napomena'];
          }
          ?>
        </div>
        <button type="submit" class="btn btn-danger" id="modal" name="stampa">Unesi napomenu</button>
      </form>
    </div>

    <div class="container" id="myText" <?php if (!isset($_POST['stampa'])) {
                                          echo 'style="display:none;"';
                                        } ?>>

      <div class="row" id="header">
        <div class="col-md-12">
          <!-- hardcoded!!! -->
          <img src="http://10.5.10.239/Postal/images/memo-a4.png" id="header" alt="logo" height="180px">
        </div>

      </div>

      <div class="container" id="body">
        <div class="text-center">
          <h3><?php echo $_SESSION['klijent']; ?><br>
            SPECIFIKACIJA DOSTAVLJENIH FAKTURA SA DOKUMENTACIJOM<br>
            NA DAN <?php $datumSlanja = date('d.m.Y.', $_SESSION['vremeUnosa']);
                    echo $datumSlanja; ?></h3>
        </div>

        <div class="row p-3 mt-5">
          <table class="table table-bordered text-center" style="width:300px; margin:auto;">
            <tbody>
              <?php
              $count = 1;
              //reversing
              $barcodes = array_reverse($_SESSION['barcodes']);
              foreach ($barcodes as $barcode) {
                if ($barcode != '') {
                  if ($count == 18) {
                    echo '<tr><td>' . $count . '</td><td>' . $barcode . '</td>';
                    echo '<tr style="height:600px; border:#ffffff;"><td></td></tr>';
                    $count++;
                  } elseif ($count == 43 || $count == 68 || $count == 93) {
                    echo '<tr><td>' . $count . '</td><td>' . $barcode . '</td>';
                    echo '<tr style="height:600px; border:#ffffff;"><td></td></tr>';
                    $count++;
                  } else {
                    echo '<td>' . $count . '</td><td>' . $barcode . '</td></tr>';
                    $count++;
                  }
                }
              }

              ?>
            </tbody>
          </table>
        </div>

        <div class="container">
          <p class="mt-5"><strong>Napomena: </strong>
            <?php
            if (!isset($_POST['napomena'])) {
              echo ' ';
            } else {
              $napomena = $_POST['napomena'];
              echo $napomena;
            }
            ?>
          </p>
        </div>

        <div class="d-flex flex-row-reverse">
          <div class="p-2 mt-5">
            <p>Potpis primaoca:<br></br>______________________________________</p>
          </div>
        </div>

        <div class="d-flex flex-row-reverse">
          <div class="p-2"><?php if (isset($result) && !empty($result)) : ?>
              <img src="<?= $result ?>" />
            <?php endif; ?>
          </div>
        </div>

        <div class="text-center fixed-bottom" id="footer" style="color:red; font-family:'Calibri', sans-serif; font-size:9px;">
          <p>Administrativno sedište: Savski nasip 7, 11000 Beograd, Srbija<br>
            Tel. +381 (0) 11 414 98 00; Fax. +381 (0) 414 98 19<br>
            office@transfera.com<br>
            www.transfera.com
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <div class="d-flex <?php if (!isset($_POST['napomena'])) {
                          echo 'justify-content-between p-3';
                        } else {
                          echo 'flex-column fixed-top p-3';
                        } ?> ">
      <div class="p-2">
        <button type="button" class="btn btn-dark" id="print" name="print" title="Štampaj" <?php
                                                                                            if (!isset($_POST['napomena'])) {
                                                                                              echo 'disabled';
                                                                                            }
                                                                                            ?>><img src="images/print-icon.svg" alt="print icon"></button>
      </div>

      <div class="p-2"></div>

      <div class="p-2">
        <a href="index.php"><button type="button" class="btn btn-warning" title="Početna stranica"><img src="images/home-icon.svg" alt="home icon"></button></a>
      </div>

    </div>
  </div>
</body>

</html>