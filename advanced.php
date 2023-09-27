<?php
session_start();
include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>POŠTA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
    $(document).ready(function() {
      $("#client").keyup(function() {
        var klijent = $("#client").val();
        $.post("list.php", {
          suggestion: klijent
        }, function(data, status) {
          $("#clients").html(data);
        });
      });

      var resultCount = 10;
      $("#more").click(function() {
        resultCount = resultCount + 10;
        $("#results").load("advanced-add.php", {
          resultNewCount: resultCount
        });
      });
      $(function() {
        $.datepicker.regional['sr'] = {
          closeText: 'Zatvori',
          prevText: 'Prethodni',
          nextText: 'Sledeći',
          currentText: 'Danas',
          monthNames: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun',
            'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'
          ],
          monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun',
            'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'
          ],
          dayNames: ['Nedelja', 'Ponedeljak', 'Utorak', 'Sreda', 'Četvrtak', 'Petak', 'Subota'],
          dayNamesShort: ['Ned', 'Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub'],
          dayNamesMin: ['Ne', 'Po', 'Ut', 'Sr', 'Čet', 'Pe', 'Su'],
          weekHeader: 'Sm',
          dateFormat: 'yy-mm-dd',
          firstDay: 1,
          isRTL: false,
          showMonthAfterYear: false,
          yearSuffix: ''
        };

        $.datepicker.setDefaults($.datepicker.regional['sr']);

        $('#from-date').datepicker();
        $('#to-date').datepicker();
      });
    });
  </script>
  <style>
    img:hover {
      border-radius: 30%;
      background-color: orange;
    }
  </style>
</head>

<body>

  <div class="container-fluid">
    <nav class="navbar navbar-expand-sm justify-content-center bg-primary navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php" id="home">Početna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="daily.php" id="daily">Dnevni pregled</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="all.php" id="all">Sve pošiljke</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="advanced.php" id="advanced">Napredna pretraga</a>
        </li>
      </ul>
    </nav>
    <div class="container mt-5 text-center">
      <h2>Pretraga pošiljaka</h2>
    </div>
    <div class="container mt-5">
      <form action="advanced.php" method="POST">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group mt-3">
              <label for="klijent">Klijent:</label>
              <input class="form-control" list="clients" name="client" id="client" autocomplete="off" value="<?php if (isset($_POST['submit'])) {
                                                                                                                echo htmlspecialchars($_POST['client']);
                                                                                                              } ?>">
              <datalist id="clients">
              </datalist>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group mt-3">
              <label for="from-date">Datum od:</label>
              <input class="form-control" name="from-date" id="from-date" autocomplete="off" placeholder="YYYY-MM-DD" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                echo htmlspecialchars($_POST['from-date']);
                                                                                                                              } ?>">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group mt-3">
              <label for="to-date">Datum do:</label>
              <input class="form-control" name="to-date" id="to-date" autocomplete="off" placeholder="YYYY-MM-DD" value="<?php if (isset($_POST['submit'])) {
                                                                                                                            echo htmlspecialchars($_POST['to-date']);
                                                                                                                          } ?>">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group mt-3">
              <label for="invoice">Broj dokumenta:</label>
              <input class="form-control" name="invoice" id="invoice" value="<?php if (isset($_POST['submit'])) {
                                                                                echo htmlspecialchars($_POST['invoice']);
                                                                              } ?>">
            </div>
          </div>
          <div class="col-md-1 mt-3">
            <div class="mt-4">
              <a href="advanced.php"><button type="button" name="reset" class="btn btn-warning" style="border-radius: 25%;" title="Poništi filtere"><strong>X</strong></button></a>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-2">
            <button type="submit" name="submit" class="btn btn-success mt-3">Pretraži</button>
          </div>
          <div class="col-md-10">
          </div>
        </div>

      </form>
    </div>
    <div class="container mt-5">
      <?php


      if (isset($_POST['submit'])) {
        $clientWithSpace = $_POST['client'];
        $clientWithoutSpace = explode(' ', $clientWithSpace);
        $client = "";
        for ($i = 0; $i < count($clientWithoutSpace); $i++) {
          $client .= $clientWithoutSpace[$i] . '%';
        }
        $fromDate = trim($_POST['from-date']);
        $toDate = trim($_POST['to-date']);
        $invoice = trim($_POST['invoice']);
        $_SESSION['client'] = $client;
        $_SESSION['from-date'] = $fromDate;
        $_SESSION['to-date'] = $toDate;
        $_SESSION['invoice'] = $invoice;

        $getQuery = "";

        $getClient = "";
        if ($client !== '') {
          $getClient .= "AND Naziv LIKE '" . $client . "'";
        }
        $getQuery .= $getClient;

        $getFromDate = "";
        if ($fromDate !== '') {
          $getFromDate .= "AND datumSlanja >=  '" . $fromDate . "'";
        }
        $getQuery .= $getFromDate;

        $getToDate = "";
        if ($toDate !== '') {
          $getToDate .= "AND datumSlanja <=  '" . $toDate . "'";
        }
        $getQuery .= $getToDate;

        $getInvoice = "";
        if ($invoice !== '') {
          $getInvoice .= "AND dokumentId =  '" . $invoice . "'";
        }
        $getQuery .= $getInvoice;
        $_SESSION['getQuery'] = $getQuery;

        //Query sa COUNT(1) za brojanje rezultata / ne sme da sadrzi ORDER BY
        $result_count = $conn->query("SELECT
      COUNT(1) total_records
      FROM
      dokument d
      INNER JOIN posiljka p ON d.posiljkaId = p.id
      INNER JOIN clients c ON p.KlijentId = c.EksternaSifra
       WHERE 1 = 1 " . $getQuery . "")->fetch(PDO::FETCH_ASSOC);

        $total_records = $result_count['total_records'];

        //Pravi Query - mora da sadrzi ORDER BY
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
      INNER JOIN clients c ON p.KlijentId = c.EksternaSifra AND 1 = 1 " . $getQuery . " ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT 10 ROWS ONLY");

        if ($total_records > 0) {
          echo '<table class="table table-striped">
                <thead>
                <tr class="text-center">
                  <th>Barkod pošiljke</th>
                  <th>Klijent</th>
                  <th>Broj dokumenta</th>
                  <th>Datum</th>
                  <th></th>
                </tr>
                </thead>
                <tbody id="results">
                ';
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo   '<tr>';
            if ($row['BarkodPosiljke'] == '') {
              echo '<td class="text-center">N/A</td>';
            } else {
              echo '<td class="text-center">' . $row['BarkodPosiljke'] . '</td>';
            }
            echo '
                    <td class="text-center">' . $row['Naziv'] . '</td>
                    <td class="text-center">' . $row['dokumentId'] . '</td>
                    <td class="text-center">' . substr($row['DatumSlanja'], 0, 10) . '</td>
                    <td class="text-center"><a href="advanced-print.php?bc=' . $row['BarkodPosiljke'] . '&client=' . $row['Naziv'] . '&date=' . substr($row['DatumSlanja'], 0, 10) . '"><img src="images/print-icon-2.svg" alt="print icon" title="Štampaj specifikaciju"></a></td>
                  </tr>';
          }
          $conn = null;
          echo '</tbody></table>
        <button type="button" name="button" class="btn btn-primary" id="more"';
          if ($total_records < 10) {
            echo 'hidden';
          }
          echo '>Učitaj još</button>
        <div class="alert alert-primary mt-2">
           Ukupno rezultata: <strong>' . $total_records . '</strong>
        </div>';
        } else {
          echo '<div class="alert alert-warning">
                  <strong>Nema rezultata.</strong>
                </div>';
        }
      } else {
        echo '<div class="alert alert-success">
                <strong>Unesite kriterijum pretrage.</strong>
              </div>';
      }



      ?>
    </div>
  </div>