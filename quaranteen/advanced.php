<?php
session_start();
include 'db.php';
include 'header.php';

 ?>
<script>
  $(document).ready(function(){
    $("#client").keyup(function(){
      var klijent = $("#client").val();
      $.post("list.php", {
        suggestion: klijent
      }, function(data,status){
        $("#clients").html(data);
      });
    });

    $("#advanced").addClass("active");

    var resultCount = 10;
    $("#more").click(function(){
      resultCount = resultCount + 10;
      $("#results").load("advanced-add.php", {
        resultNewCount: resultCount
      });
    });

  });

</script>

</head>
<body>

<div class="container-fluid">
  <?php
  include 'navigation.php';
   ?>
  <div  class="container mt-5 text-center">
    <h2>Napredna pretraga</h2>
  </div>
  <div class="container mt-5">
    <form action="advanced.php" method="POST">
      <div class="row">
        <div class="col">
          <div class="form-group mt-3">
            <label for="klijent">Klijent:</label>
            <input class="form-control" list="clients" name="client" id="client" value="<?php if(isset($_POST['submit'])){echo htmlspecialchars($_POST['client']);}?>">
            <datalist id="clients">
            </datalist>
          </div>
        </div>
        <div class="col">
          <div class="form-group mt-3">
            <label for="date">Datum od:</label>
            <input class="form-control" name="date" id="date" placeholder="YYYY-MM-DD" value="<?php if(isset($_POST['submit'])){echo htmlspecialchars($_POST['date']);}?>">
          </div>
        </div>
        <div class="col">
          <div class="form-group mt-3">
            <label for="invoice">Broj dokumenta:</label>
            <input class="form-control" name="invoice" id="invoice" value="<?php if(isset($_POST['submit'])){echo htmlspecialchars($_POST['invoice']);}?>">
          </div>
        </div>

        <div class="col">
          <div class="form-group mt-3 p-4">
            <a href="advanced.php"><button type="button" name="reset" class="btn btn-warning" style="border-radius: 25%;" title="Poništi filtere"><strong>X</strong></button></a>
          </div>
        </div>
      </div>

      <button type="submit" name="submit" class="btn btn-success mt-3">Pretraži</button>
    </form>
  </div>
  <div class="container mt-5">
    <?php


    if (isset($_POST['submit'])) {
      $client = trim($_POST['client']);
      $date = trim($_POST['date']);
      $invoice = trim($_POST['invoice']);
      $_SESSION['client'] = $client;
      $_SESSION['date'] = $date;
      $_SESSION['invoice'] = $invoice;


      function listAll($row){
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

      $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra ORDER BY DatumSlanja")->fetchall(PDO::FETCH_ASSOC);
      switch ($query) {
        case $client !== "" && $date !== "" && $invoice !== "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' AND datumSlanja >= '".$date."' AND BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
        case $client !== "" && $date !== "" && $invoice === "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' AND datumSlanja >= '".$date."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
        case $client !== "" && $date === "" && $invoice === "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
        case $client === "" && $date === "" && $invoice === "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra ORDER BY DatumSlanja OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
        case $client === "" && $date !== "" && $invoice === "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE datumSlanja >= '".$date."' ORDER BY DatumSlanja DESC OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
        case $client === "" && $date !== "" && $invoice !== "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE datumSlanja >= '".$date."' AND BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
        case $client === "" && $date === "" && $invoice !== "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
        case $client !== "" && $date === "" && $invoice !== "":
          $query = $conn->query("SELECT * FROM shipments LEFT JOIN clients ON shipments.KlijentId=clients.EksternaSifra WHERE Naziv = '".$client."' AND BarkodSadrzaj = '".$invoice."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);
          include 'advanced-head.php';
          foreach ($query as $row) {
            listAll($row);
          }
          include 'advanced-foot.php';
          break;
      }


    }else{
      echo '<div class="alert alert-success">
              <strong>Unesite kriterijum pretrage.</strong>
            </div>';
    }



     ?>
  </div>
</div>
