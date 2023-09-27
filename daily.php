<?php
session_start();
include 'dbh.php';
include 'header.php';

 ?>
<script>
  $(document).ready(function(){
    var resultCount = 10;
    $("#more").click(function(){
      resultCount = resultCount + 10;
      $("#results").load("daily-add.php", {
        resultNewCount: resultCount
      });
    });
  });

</script>

</head>
<body>

<div class="container-fluid">
  <nav class="navbar navbar-expand-sm justify-content-center bg-primary navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Početna</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="daily.php">Dnevni pregled</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="all.php">Sve pošiljke</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="advanced.php">Napredna pretraga</a>
      </li>
    </ul>
  </nav>
  <div  class="container mt-5 text-center">
    <h2>Dnevni pregled pošiljaka</h2>
  </div>
  <div class="container mt-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Barkod pošiljke</th>
          <th>Klijent</th>
          <th>Broj dokumenata</th>
          <th>Datum</th>
        </tr>
      </thead>
      <tbody id="results">

      <?php
      $today = date("Y-m-d");
      $_SESSION['today'] = $today;


      $query = $sqlP->query("SELECT * FROM posiljka
                LEFT JOIN clients ON posiljka.KlijentId=clients.EksternaSifra
                INNER JOIN dokument ON dokument.posiljkaId = posiljka.id
                WHERE DatumSlanja = '".$today."' ORDER BY DatumSlanja DESC OFFSET  0 ROWS
                FETCH NEXT 10 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);

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


       ?>

      </tbody>
    </table>
    <button type="button" name="button" class="btn btn-primary" id="more">Učitaj još</button>
  </div>

</div>
