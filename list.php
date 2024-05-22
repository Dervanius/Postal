<?php

include 'dbh.php';
$query = $sqlP->query("SELECT * FROM clients")->fetchall(PDO::FETCH_ASSOC);

// if (isset($_POST['suggestion'])) {
//   $klijent = $_POST['suggestion'];
//   if (!empty($klijent)) {
//     foreach ($query as $row){
//       if (stripos($row['Naziv'], $klijent) !== false) {
//         //Original
//         echo "<option>".$row['Naziv']."</option>";
//         //First Solution
//         // $originalName = str_replace(' ', '&nbsp;', $row['Naziv']);
//         // echo "<option><pre>" . $originalName . "</pre></option>";
//         //Second solution
//         // $originalName = str_replace(' ', '&nbsp;', $row['Naziv']);
//         // echo "<option>" . $originalName . "</option>";
//       }
//     }
//   }
// }





if (isset($_POST['suggestion'])) {
  $klijent = $_POST['suggestion'];
  if (!empty($klijent)) {
    foreach ($query as $row) {
      if (stripos($row['Naziv'], $klijent) !== false) {
        // Generišite opcije za datalist
        echo '<option value="' . htmlspecialchars($row['Naziv']) . '">';
      }
    }
  }
}
