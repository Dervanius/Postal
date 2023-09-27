<?php
include 'dbh.php';
include 'header.php';

 ?>
<script>
  $(document).ready(function(){
    var resultCount = 30;
    $("#more").click(function(){
      resultCount = resultCount + 30;
      $("#results").load("all-add.php", {
        resultNewCount: resultCount
      });
    });

    $("#all").addClass("active");
  });

</script>

</head>
<body>

<div class="container-fluid">
  <?php
  include 'navigation.php';
   ?>
  <div  class="container mt-5 text-center">
    <h2>Pregled svih pošiljaka</h2>
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
      //preradi query
      $query = $sqlP->query("SELECT * FROM posiljka
                LEFT JOIN clients ON posiljka.KlijentId=clients.EksternaSifra
                INNER JOIN dokument ON dokument.posiljkaId = posiljka.id
                ORDER BY DatumSlanja DESC OFFSET  0 ROWS
                FETCH NEXT 30 ROWS ONLY")->fetchall(PDO::FETCH_ASSOC);

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
