<?php

include 'dbh.php';
$query = $sqlP->query("SELECT * FROM clients")->fetchall(PDO::FETCH_ASSOC);

if (isset($_POST['suggestion'])) {
  $klijent = $_POST['suggestion'];
  if (!empty($klijent)) {
    foreach ($query as $row){
      if (stripos($row['Naziv'], $klijent) !== false) {
        echo "<option>".$row['Naziv']."</option>";
      }
    }
  }
}
