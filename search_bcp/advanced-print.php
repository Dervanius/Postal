<?php

use chillerlan\QRCode\QRCode;
include './vendor/autoload.php';
include 'db.php';

 $BarkodPosiljke = $_GET['bc'];
 $klijent = $_GET['client'];
 $datum = $_GET['date'];

 $query = $conn->query("SELECT BarkodSadrzaj FROM shipments WHERE BarkodPosiljke = '$BarkodPosiljke' ORDER BY BarkodSadrzaj")->fetchall(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Štampa pošiljke</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script type="text/javascript" src="printThis.js"></script>
    <script>
    $(document).ready(function(){
      $("#print").click(function(){
        $("#myText").printThis();
      });
      $("#footer").hide();
      $("#print").click(function(){
        $("#footer").show();
      });
      $("#header").hide();
      $("#print").click(function(){
        $("#header").show();
      });

    });
    </script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="container" id="myText">
        <div class="row" id="header">
          <div class="col-md-12">
              <!-- hardcoded -->
              <img src="http://10.5.10.239/PostPrint/images/BaneMemo2.png" id="header" alt="logo1" height="180px">
          </div>

        </div>
        <div class="container" id="body">
          <div class="text-center">
            <h3><?php echo $klijent; ?><br>
            SPECIFIKACIJA DOSTAVLJENIH FAKTURA SA DOKUMENTACIJOM<br>
            NA DAN <?php echo $datum?></h3>
          </div>

          <div class="row p-3 mt-5">
            <!-- <div class="col-md-4"></div> -->
            <!-- <div class="col-md-4"> -->
              <table class="table table-bordered text-center" style="width:300px; margin-left: 380px;">
                <tbody>
                  <?php
                  $count = 1;
                  foreach($query as $row){
                    if ($row['BarkodSadrzaj'] != '') {
                      if ($count == 18) {
                        echo '<tr><td>'.$row['BarkodSadrzaj'].'</td>';
                        echo '<tr style="height:600px; border:#ffffff;"><td></td></tr>';
                        $count++;
                      }elseif($count == 43 || $count == 68 || $count == 93){
                        echo '<tr><td>'.$row['BarkodSadrzaj'].'</td>';
                        echo '<tr style="height:600px; border:#ffffff;"><td></td></tr>';
                        $count++;
                      }
                      else{
                        echo '<td>'.$row['BarkodSadrzaj'].'</td></tr>';
                        $count++;
                      }
                    }
                  }

                  ?>
                </tbody>
              </table>
            <!-- </div> -->
            <!-- <div class="col-md-4"></div> -->

          </div>

          <div class="container">
            <p class="mt-5"><strong>Napomena: </strong>
              <?php
              if (!isset($_POST['napomena'])) {
                echo ' ';
              }else {
                $napomena = $_POST['napomena'];
                echo $napomena;
              }
               ?>
            </p>
          </div>

          <div class="d-flex flex-row-reverse">
            <div class="p-2 mt-5"><p >Potpis primaoca:<br></br>______________________________________</p>
            </div>
          </div>

          <div class="d-flex flex-row-reverse">
            <div class="p-2"><?php if (isset($result) && !empty($result)): ?>
                <img src="<?= $result ?>"/>
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
      <div class="container mt-5">
        <div class="d-flex <?php if (!isset($_POST['napomena'])) {
          echo 'justify-content-between p-3';
        }else{
          echo 'flex-column fixed-top p-3';
        } ?> ">
          <div class="p-2">
            <button type="button" class="btn btn-dark" id="print" name="print" title="Štampaj"><img src="images/print-icon.svg" alt="print icon"></button>
          </div>
          <div class="p-2">

          </div>
          <div class="p-2">
            <a href="index.php"><button type="button" class="btn btn-warning" title="Početna stranica"><img src="images/home-icon.svg" alt="home icon"></button></a>
          </div>

        </div>
      </div>
    </div>
  </body>
</html>
